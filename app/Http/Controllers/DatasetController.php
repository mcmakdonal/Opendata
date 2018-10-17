<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class DatasetController extends Controller
{
    public function __construct()
    {
        $this->middleware('islogin', ['except' => [
            'index',
            'page',
            'view_metadata',
        ]]);
    }

    public function index(Request $request)
    {
        $title = $request->title;

        $get_ogz_count = Customlib::get_ogz_count();
        $file_format = Customlib::file_has();
        $get_lcs = Customlib::get_lcs();
        $get_cat = Customlib::get_cat();

        return view('dataset.index', [
            'title' => 'ชุดข้อมูล',
            'header' => 'ชุดข้อมูล',
            'get_ogz_count' => $get_ogz_count,
            'file_format' => $file_format,
            'get_lcs' => $get_lcs,
            'get_cat' => $get_cat,
            'is_login' => Customlib::is_login(),
        ]);
    }

    function new (Request $request) {
        $get_ogz = Customlib::get_ogz();
        $get_lcs = Customlib::get_lcs();
        $get_cat = Customlib::get_cat();
        $get_frequent = Customlib::frequent();
        $uniq = uniqid() . md5(date('Y-m-d H:i:s'));

        return view('dataset.new', [
            'title' => 'สร้าง ชุดข้อมูล',
            'header' => 'สร้าง ชุดข้อมูล',
            'get_ogz' => $get_ogz,
            'get_lcs' => $get_lcs,
            'get_cat' => $get_cat,
            'lock_ogz' => ($request->ogz) ? $request->ogz : "",
            'get_frequent' => $get_frequent,
            'uniq' => $uniq,
        ]);
    }

    public function pre_new_resource(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ogz_id' => 'string|required',
            'dts_title' => 'required',
            'dts_url' => 'required|string|max:250',
            'dts_description' => 'required|max:500',
            'lcs_id' => 'string|required',
            'cat_id' => 'string|required',
            'dts_status' => 'string|required',
            'dts_scope_geo' => 'string|required',
            'dts_tag' => 'string|nullable',
            'dts_contact_name' => 'string|required',
            'dts_permission' => 'string|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $url = Customlib::make_slug("url", $request->dts_url);
        if (Customlib::get_url("dts", $url)) {
            return redirect()->back()->withErrors("ลิงก์ถาวร ถูกใช้ไปแล้ว กรุณาเปลี่ยน ลิงก์ถาวร ใหม่");
        }

        $args = array(
            'ogz_id' => $request->ogz_id,
            'dts_title' => $request->dts_title,
            'dts_url' => $url,
            'dts_description' => $request->dts_description,
            'dts_status' => $request->dts_status,
            'lcs_id' => $request->lcs_id,
            'cat_id' => $request->cat_id,
            'dts_scope_geo' => $request->dts_scope_geo,
            'dts_tag' => $request->dts_tag,
            'dts_contact_name' => $request->dts_contact_name,
            'dts_contact_email' => $request->dts_contact_email,
            'dts_permission' => $request->dts_permission,
            'dts_frequent' => $request->dts_frequent,
            'dts_res_point' => 1,
            'dts_view' => 0,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => \Cookie::get('token'),
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );
        session(['new_dataset' => $args]);
        return redirect('/dataset/new_resource');
    }

    public function new_resource(Request $request)
    {
        if ($request->session()->has('new_dataset')) {
            return view('dataset.new_res', [
                'title' => 'สร้าง ชุดข้อมูล',
                'header' => 'สร้าง ชุดข้อมูล',
            ]);
        } else {
            return redirect('/dataset/new');
        }
    }

    public function save(Request $request)
    {
        if ($request->session()->has('new_dataset')) {
            $new_dataset = session('new_dataset');
            $validator = Validator::make($request->all(), [
                'file_name' => 'required|max:250',
                'file_type' => 'string|max:1|required',
                'file_desc' => 'required|max:500',
                'file' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $file = "";
            $file_arg = [];
            if ($request->hasfile('file')) {
                if ($request->file('file')) {
                    $path = uniqid();
                    Customlib::create_dir();
                    if (!mkdir(public_path('/files/' . $path), 0777, true)) {
                        $path = "res";
                    }

                    $file = $request->file('file');
                    $name = Customlib::make_slug("img", $file->getClientOriginalName());
                    $file->move(public_path('/files/' . $path) . '/', $name);
                    $file_arg['file_path'] = '/files/' . $path . '/' . $name;
                    $file_arg['file_ext'] = $file_arg['file_format'] = $file->getClientOriginalExtension();
                    // $file_arg['file_format'] = ($request->file_format == "") ? $file->getClientOriginalExtension() : $request->file_format;
                } else {
                    return redirect('/dataset/new_resource')->withErrors("Issue With upload file");
                    exit();
                }
            } else {
                $file_arg['file_path'] = $request->file;
                $explode = explode(".", $request->file);
                $ext = strtolower(end($explode));
                $clear = explode("/", $ext);
                $ext = $clear[0];
                $format = ['com', 'th', 'net', 'info', 'php', 'html', 'aspx'];
                $file_arg['file_ext'] = $file_arg['file_format'] = (in_array($ext, $format)) ? "web" : $ext;
            }

            $dts_id = DB::table('tbl_dataset')->insertGetId($new_dataset);
            if ($dts_id) {
                $file_arg['dts_id'] = $dts_id;
                $file_arg['file_name'] = $request->file_name;
                $file_arg['file_desc'] = $request->file_desc;
                $file_arg['file_type'] = $request->file_type;
                $file_arg['file_slug'] = uniqid();
                $file_arg['create_date'] = date('Y-m-d H:i:s');
                $file_arg['create_by'] = 1;
                $file_arg['update_date'] = date('Y-m-d H:i:s');
                $file_arg['update_by'] = 1;
                $file_arg['record_status'] = "A";
                $result = DB::table('tbl_resource')->insert($file_arg);

                $rules = [
                    // put your static input fields here
                    'field_name' => 'required',
                ];

                if ($request->has('field_name')) {
                    $field_name = $request->field_name;
                    $description = $request->description;
                    $field_type = $request->field_type;
                    $unit = $request->unit;
                    $size = count($field_name);
                    for ($x = 0; $x < $size; $x++) {
                        $metadata = [];
                        $metadata['mtd_field_name'] = $field_name[$x];
                        $metadata['mtd_description'] = ($description[$x] == "" ? " " : $description[$x]);
                        $metadata['mtd_field_type'] = $field_type[$x];
                        $metadata['mtd_unit'] = ($unit[$x] == "" ? " " : $unit[$x]);
                        $metadata['dts_id'] = $dts_id;
                        $result2 = DB::table('tbl_metadata')->insert($metadata);
                    }
                }

                if ($result) {
                    \Session::forget('new_dataset');
                    // อัพเดตคะแนนดาว
                    Customlib::update_rate_star($dts_id);

                    $url = $new_dataset['dts_url'];

                    //$url = iconv(mb_detect_encoding($url, mb_detect_order(), true), "UTF-8", $url);

                    return redirect('/dataset/page/' . $url)->with('status', 'Success');
                } else {
                    return redirect('/dataset/new');
                }
            }

        } else {
            return redirect('/dataset/new');
        }
    }

    public function page(string $slug_url)
    {
        if ($slug_url != "") {
            $tbl_dataset = Customlib::get_dts("", "", $slug_url);
            // dd($tbl_dataset);
            if (!(count($tbl_dataset) > 0)) {
                abort(404);
            }
            $dts_id = $tbl_dataset[0]->dts_id;
            $tbl_resource = Customlib::get_res("", $dts_id);
            $tbl_metadata = Customlib::get_metadata($dts_id);
            $get_frequent = Customlib::frequent();
            // dd($tbl_resource);
            return view('dataset.page', [
                'title' => 'ชุดข้อมูล',
                'header' => 'ชุดข้อมูล',
                'content' => $tbl_dataset,
                'resource' => $tbl_resource,
                'metadata' => $tbl_metadata,
                'slug_url' => $slug_url,
                'is_login' => Customlib::is_login(),
                'get_frequent' => $get_frequent,
            ]);
        }
    }

    public function edit(string $slug_url)
    {
        if ($slug_url != "") {
            $tbl_dataset = DB::table('tbl_dataset')->where('dts_url', $slug_url)->get()->toArray();
            if (!(count($tbl_dataset) > 0)) {
                abort(404);
            }
            $dts_id = $tbl_dataset[0]->dts_id;
            $tbl_metadata = Customlib::get_metadata($dts_id);
            $tbl_resource = DB::table('tbl_resource')->where('dts_id', $dts_id)->get();
            $get_ogz = Customlib::get_ogz();
            $get_lcs = Customlib::get_lcs();
            $get_cat = Customlib::get_cat();
            $get_frequent = Customlib::frequent();

            return view('dataset.edit', [
                'title' => 'แก้ไข ชุดข้อมูล',
                'header' => 'แก้ไข ชุดข้อมูล',
                'tbl_dataset' => $tbl_dataset,
                'get_ogz' => $get_ogz,
                'slug_url' => $slug_url,
                'metadata' => $tbl_metadata,
                'resource' => $tbl_resource,
                'get_lcs' => $get_lcs,
                'get_cat' => $get_cat,
                'get_frequent' => $get_frequent,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ogz_id' => 'string|required',
            'dts_title' => 'required',
            'dts_url' => 'required|string|max:250',
            'dts_description' => 'required|max:500',
            'lcs_id' => 'string|required',
            'cat_id' => 'string|required',
            'dts_status' => 'string|required',
            'dts_scope_geo' => 'string|required',
            'dts_tag' => 'string|nullable',
            'dts_contact_name' => 'string|required',
            'dts_permission' => 'string|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'ogz_id' => $request->ogz_id,
            'dts_title' => $request->dts_title,
            'dts_description' => $request->dts_description,
            'dts_status' => $request->dts_status,
            'lcs_id' => $request->lcs_id,
            'cat_id' => $request->cat_id,
            'dts_scope_geo' => $request->dts_scope_geo,
            'dts_tag' => $request->dts_tag,
            'dts_contact_name' => $request->dts_contact_name,
            'dts_contact_email' => $request->dts_contact_email,
            'dts_permission' => $request->dts_permission,
            'dts_frequent' => $request->dts_frequent,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $result = DB::table('tbl_dataset')->where('dts_id', $request->dts_id)->update($args);
        if ($result) {
            return redirect()->back()->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function delete(string $slug_url)
    {
        if ($slug_url != "") {
            $dts_id = Customlib::get_id("dts", $slug_url);
            $result = DB::table('tbl_dataset')->where('dts_id', $dts_id)->delete();
            $result2 = DB::table('tbl_metadata')->where('dts_id', $dts_id)->delete();
            if ($result) {
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
    }

    public function delete_metadata($mtd_id)
    {
        if ($mtd_id != "") {
            $result = DB::table('tbl_metadata')->where('mtd_id', $mtd_id)->delete();
            if ($result) {
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
    }

    public function update_metadata(Request $request)
    {
        $field_name = $request->field_name;
        $description = $request->description;
        $field_type = $request->field_type;
        $unit = $request->unit;
        $type = $request->type;
        $dts_id = $request->dts_id;
        $slug_url = $request->slug_url;

        $size = count($field_name);
        $result = "";
        if ($size > 0) {
            for ($x = 0; $x < $size; $x++) {
                $metadata = [];
                $metadata['mtd_field_name'] = $field_name[$x];
                $metadata['mtd_description'] = ($description[$x] == "" ? " " : $description[$x]);
                $metadata['mtd_field_type'] = $field_type[$x];
                $metadata['mtd_unit'] = ($unit[$x] == "" ? " " : $unit[$x]);
                $metadata['dts_id'] = $dts_id;

                if ($type[$x] == '1') {
                    $result = DB::table('tbl_metadata')->insert($metadata);
                } else {
                    $result = DB::table('tbl_metadata')->where('mtd_id', $request->mtd_id[$x])->update($metadata);
                }
            }
        }
        if ($result) {
            return redirect('/dataset/edit/' . $slug_url)->with('status', 'Success');
        } else {
            return redirect('/dataset/edit/' . $slug_url);
        }
    }

    public function view_metadata($dts_id)
    {
        $tbl_data = null;
        if ($dts_id != "") {
            $tbl_resource = DB::table('view_metadata')->where('dts_id', $dts_id)->get();
            $ary = [];
            $size = count($tbl_resource);
            for ($x = 0; $x < $size; $x++) {
                if ($tbl_resource[$x]->mtd_field_name != null) {
                    $ary[] = [
                        'mtd_field_name' => $tbl_resource[$x]->mtd_field_name,
                        'mtd_description' => $tbl_resource[$x]->mtd_description,
                        'mtd_field_type' => $tbl_resource[$x]->mtd_field_type,
                        'mtd_unit' => $tbl_resource[$x]->mtd_unit,

                    ];
                }
            }

            $tbl_data = array(
                'dts_title' => $tbl_resource[0]->dts_title,
                'dts_description' => $tbl_resource[0]->dts_description,
                'dts_scope_geo' => $tbl_resource[0]->dts_scope_geo,
                'dts_tag' => $tbl_resource[0]->dts_tag,
                'dts_contact_name' => $tbl_resource[0]->dts_contact_name,
                'dts_contact_email' => $tbl_resource[0]->dts_contact_email,
                'create_date' => $tbl_resource[0]->create_date,
                'update_date' => $tbl_resource[0]->update_date,
                'license' => $tbl_resource[0]->license,
                'ogz_title' => $tbl_resource[0]->ogz_title,
                'cat_title' => $tbl_resource[0]->cat_title,
                'meta_data' => $ary,
            );

        }

        return response()->json($tbl_data);
    }

    public function set_status(Request $request)
    {
        $dts_id = json_decode($request->dts_id, true);
        $type = $request->type;
        if ($type === "pb" || $type === "pv") {
            foreach ($dts_id as $k => $v) {
                $args = array(
                    'dts_status' => $type,
                    'update_date' => date('Y-m-d H:i:s'),
                    'update_by' => \Cookie::get('token'),
                );
                $dts_id = Customlib::get_id("dts", $v);
                $result = DB::table('tbl_dataset')->where('dts_id', $dts_id)->update($args);
                if (!$result) {
                    return response()->json([
                        'status' => false,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
            ]);
        } else {
            foreach ($dts_id as $k => $v) {
                $dts_id = Customlib::get_id("dts", $v);
                $result = DB::table('tbl_dataset')->where('dts_id', $dts_id)->delete();
                if (!$result) {
                    return response()->json([
                        'status' => false,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
            ]);
        }
    }

}
