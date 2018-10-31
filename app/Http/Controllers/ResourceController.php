<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('islogin', ['except' => [
            'preview'
        ]]);
    }

    public function preview($slug, $res_slug)
    {
        $res_id = Customlib::get_id("res", $res_slug);
        $get_res = Customlib::get_res($res_id);
        // dd($get_res);
        return view('dataset.preview', [
            'title' => 'ตัวอย่าง ทรัพยากร',
            'header' => 'ตัวอย่าง ทรัพยากร',
            'is_login' => Customlib::is_login(),
            'get_res' => $get_res,
            'slug_url' => $slug,
            'res_slug' => $res_slug,
        ]);
    }

    public function add_new_resource(string $slug_url)
    {
        if ($slug_url != "") {
            return view('dataset.add_resource', [
                'title' => 'เพิ่ม ทรัพยากร',
                'header' => 'เพิ่ม ทรัพยากร',
                'slug_url' => $slug_url,
            ]);
        }
    }

    public function save(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'file_name' => 'required|max:250',
            'file_type' => 'string|max:1|required',
            'file_desc' => 'required|max:500',
            'slug_url' => 'required|max:500',
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
                return redirect('/dataset/page/' . $request->slug_url)->withErrors("Issue With upload file");
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

        $dts_id = Customlib::get_id("dts", $request->slug_url);
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
            if ($result) {
                // อัพเดตคะแนนดาว
                Customlib::update_rate_star($dts_id);
                return redirect('/dataset/page/' . $request->slug_url)->with('status', 'บันทึกสำเร็จ');
            } else {
                return redirect('/dataset/page/' . $request->slug_url)->withErrors("Issue With upload file");
            }
        }

    }

    public function edit($slug, $res_slug)
    {
        $res_id = Customlib::get_id("res", $res_slug);
        $get_res = Customlib::get_res($res_id);
        // dd($get_res);
        return view('dataset.res_edit', [
            'title' => 'แก้ไข ทรัพยากร',
            'header' => 'แก้ไข ทรัพยากร',
            'is_login' => Customlib::is_login(),
            'get_res' => $get_res,
            'slug_url' => $slug,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'res_id' => 'required',
            'file_name' => 'required|max:250',
            'file_type' => 'string|max:1|required',
            'file_desc' => 'required|max:500',
            'slug_url' => 'required|max:500',
            'file' => 'nullable',
            'old_file_path' => 'required',
            'old_file_ext' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = "";
        $file_arg['file_path'] = $request->old_file_path;
        $file_arg['file_ext'] = $file_arg['file_format']= $request->old_file_ext;
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
        } elseif ($request->file != "") {
            $file_arg['file_path'] = $request->file;
            $explode = explode(".", $request->file);
            $ext = strtolower(end($explode));
            $clear = explode("/", $ext);
            $ext = $clear[0];
            $format = ['com', 'th', 'net', 'info', 'php', 'html', 'aspx'];
            $file_arg['file_ext'] = $file_arg['file_format'] = (in_array($ext, $format)) ? "web" : $ext;
        }

        $file_arg['file_name'] = $request->file_name;
        $file_arg['file_desc'] = $request->file_desc;
        $file_arg['file_type'] = $request->file_type;
        $file_arg['update_date'] = date('Y-m-d H:i:s');
        $file_arg['update_by'] = 1;
        $file_arg['record_status'] = "A";
        $result = DB::table('tbl_resource')->where('res_id', $request->res_id)->update($file_arg);
        if ($result) {
            // อัพเดตคะแนนดาว
            Customlib::update_rate_star($request->dts_id);
            return redirect()->back()->with('status', 'บันทึกสำเร็จ');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function delete($res_id)
    {
        if ($res_id != "") {
            $result = DB::table('tbl_resource')->where('res_id', $res_id)->delete();
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

}
