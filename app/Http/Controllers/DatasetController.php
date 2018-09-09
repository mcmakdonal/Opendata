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
        $this->middleware(['islogin'], ['except' => [
            'index',
            'page',
        ]]);
    }

    public function index(Request $request)
    {
        $slug = $request->slug;
        $format = $request->format;
        $get_dts = Customlib::get_dts($slug, $format);
        $ogz = Customlib::get_ogz_count($request->slug);
        $file_format = Customlib::file_has();
        // dd($file_format);
        return view('dataset.index', [
            'title' => 'Dataset',
            'header' => 'Dataset',
            'get_dts' => $get_dts,
            'ogz' => $ogz,
            'slug_sec' => ($request->slug) ? true : false,
            'file_format' => $file_format,
            'is_login' => Customlib::is_login(),
        ]);
    }

    function new (Request $request) {
        $get_ogz = Customlib::get_ogz();
        $get_lcs = Customlib::get_lcs();
        return view('dataset.new', [
            'title' => 'Create an Dataset',
            'header' => 'Create an Dataset',
            'get_ogz' => $get_ogz,
            'get_lcs' => $get_lcs,
            'lock_ogz' => ($request->ogz) ? $request->ogz : "",
        ]);
    }

    public function pre_new_resource(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required|string|max:250',
            'description' => 'required|max:500',
            'lcs_id' => 'string|required',
            'ogz_id' => 'string|required',
            'status' => 'string|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $find = array(" ", "/", "@", ".", "_");
        $replace = array("-");
        $url = strtolower(str_replace($find, $replace, $request->url));
        if (Customlib::get_url("dts", $url)) {
            return redirect()->back()->withErrors("Url ถูกใช้ไปแล้ว กรุณาเปลี่ยน url ใหม่");
        }

        $args = array(
            'ogz_id' => $request->ogz_id,
            'lcs_id' => $request->lcs_id,
            'title' => $request->title,
            'url' => $url,
            'description' => $request->description,
            'status' => $request->status,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => 1,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'record_status' => 'A',
        );
        session(['new_dataset' => $args]);
        return redirect('/dataset/new_resource');
    }

    public function new_resource(Request $request)
    {
        if ($request->session()->has('new_dataset')) {
            return view('dataset.new_res', [
                'title' => 'Create an Dataset',
                'header' => 'Create an Dataset',
            ]);
        } else {
            return redirect('/dataset/new');
        }
    }

    public function add_new_resource(string $slug_url)
    {
        if ($slug_url != "") {
            return view('dataset.add_resource', [
                'title' => 'Add an Resource',
                'header' => 'Add an Resource',
                'slug_url' => $slug_url,
            ]);
        }
    }

    public function save(Request $request)
    {
        if ($request->session()->has('new_dataset')) {
            $new_dataset = session('new_dataset');
            $validator = Validator::make($request->all(), [
                'file_name' => 'required|max:250',
                'file_format' => 'string|max:20|nullable',
                'file_desc' => 'required|max:500',
                'file.*' => 'max:16384|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $file = "";
            $file_arg = [];
            if ($request->hasfile('file')) {
                if ($request->file('file')) {
                    $path = uniqid();
                    if (!mkdir(public_path('/files/' . $path), 0777, true)) {
                        $path = "res";
                    }

                    $file = $request->file('file');
                    $name = $file->getClientOriginalName();
                    $file->move(public_path('/files/' . $path) . '/', $name);
                    $file_arg['file_path'] = '/files/' . $path . '/' . $name;
                    $file_arg['file_ext'] = $file->getClientOriginalExtension();
                    $file_arg['file_format'] = ($request->file_format == "") ? $file->getClientOriginalExtension() : $request->file_format;
                } else {
                    return redirect()->back()->withErrors("Issue With upload file");
                    exit();
                }
            }

            $dts_id = DB::table('tbl_dataset')->insertGetId($new_dataset);
            if ($dts_id) {
                $file_arg['dts_id'] = $dts_id;
                $file_arg['file_name'] = $request->file_name;
                $file_arg['file_desc'] = $request->file_desc;
                $file_arg['file_slug'] = uniqid();
                $file_arg['create_date'] = date('Y-m-d H:i:s');
                $file_arg['create_by'] = 1;
                $file_arg['update_date'] = date('Y-m-d H:i:s');
                $file_arg['update_by'] = 1;
                $file_arg['record_status'] = "A";
                $result = DB::table('tbl_resource')->insertGetId($file_arg);
                if ($result) {
                    \Session::forget('new_dataset');
                    return redirect('/dataset/page/' . $new_dataset['url']);
                } else {
                    return redirect('/dataset/new');
                }
            }

        } else {
            return redirect('/dataset/new');
        }
    }

    public function save_res(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required|max:250',
            'file_format' => 'string|max:20|nullable',
            'file_desc' => 'required|max:500',
            'slug_url' => 'required|max:500',
            'file.*' => 'max:16384|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = "";
        $file_arg = [];
        if ($request->hasfile('file')) {
            if ($request->file('file')) {
                $path = uniqid();
                if (!mkdir(public_path('/files/' . $path), 0777, true)) {
                    $path = "res";
                }

                $file = $request->file('file');
                $name = $file->getClientOriginalName();
                $file->move(public_path('/files/' . $path) . '/', $name);
                $file_arg['file_path'] = '/files/' . $path . '/' . $name;
                $file_arg['file_ext'] = $file->getClientOriginalExtension();
                $file_arg['file_format'] = ($request->file_format == "") ? $file->getClientOriginalExtension() : $request->file_format;
            } else {
                return redirect()->back()->withErrors("Issue With upload file");
                exit();
            }
        }

        $dts_id = Customlib::get_id("dts", $request->slug_url);
        if ($dts_id) {
            $file_arg['dts_id'] = $dts_id;
            $file_arg['file_name'] = $request->file_name;
            $file_arg['file_desc'] = $request->file_desc;
            $file_arg['file_slug'] = uniqid();
            $file_arg['create_date'] = date('Y-m-d H:i:s');
            $file_arg['create_by'] = 1;
            $file_arg['update_date'] = date('Y-m-d H:i:s');
            $file_arg['update_by'] = 1;
            $file_arg['record_status'] = "A";
            $result = DB::table('tbl_resource')->insertGetId($file_arg);
            if ($result) {
                return redirect('/dataset/page/' . $request->slug_url);
            } else {
                return redirect('/dataset/new');
            }
        }

    }

    public function page(string $slug_url)
    {
        if ($slug_url != "") {
            $tbl_dataset = DB::table('tbl_dataset')->where('url', $slug_url)->get();
            $dts_id = $tbl_dataset[0]->dts_id;
            $tbl_resource = DB::table('tbl_resource')->where('dts_id', $dts_id)->get();
            // dd($tbl_resource);
            return view('dataset.page', [
                'title' => 'Dataset',
                'header' => 'Dataset',
                'content' => $tbl_dataset,
                'resource' => $tbl_resource,
                'slug_url' => $slug_url,
                'is_login' => Customlib::is_login(),
            ]);
        }
    }

    public function edit(string $slug_url)
    {
        if ($slug_url != "") {
            $tbl_dataset = DB::table('tbl_dataset')->where('url', $slug_url)->get()->toArray();
            $dts_id = $tbl_dataset[0]->dts_id;
            $tbl_resource = DB::table('tbl_resource')->where('dts_id', $dts_id)->get();
            $get_ogz = Customlib::get_ogz();
            $get_lcs = Customlib::get_lcs();
            return view('dataset.edit', [
                'title' => 'Dataset Edit',
                'header' => 'Dataset Edit',
                'tbl_dataset' => $tbl_dataset,
                'get_ogz' => $get_ogz,
                'slug_url' => $slug_url,
                'resource' => $tbl_resource,
                'get_lcs' => $get_lcs,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required|string|max:250',
            'description' => 'required|max:500',
            'ogz_id' => 'string|required',
            'lcs_id' => 'string|required',
            'status' => 'string|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'ogz_id' => $request->ogz_id,
            'lcs_id' => $request->lcs_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
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

    public function set_status(Request $request)
    {
        $dts_id = json_decode($request->dts_id, true);
        $type = $request->type;
        if ($type === "pb" || $type === "pv") {
            foreach ($dts_id as $k => $v) {
                $args = array(
                    'status' => $type,
                    'update_date' => date('Y-m-d H:i:s'),
                    'update_by' => 1,
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

    public function res_detail(string $slug_url, string $slug_file)
    {

    }

}
