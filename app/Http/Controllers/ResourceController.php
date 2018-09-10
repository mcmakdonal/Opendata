<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ResourceController extends Controller
{
    public function preview($slug, $res_slug)
    {
        $res_id = Customlib::get_id("res", $res_slug);
        $get_res = Customlib::get_res($res_id);
        // dd($get_res);
        return view('dataset.preview', [
            'title' => 'Preview Resource',
            'header' => 'Preview Resource',
            'is_login' => Customlib::is_login(),
            'get_res' => $get_res,
            'slug_url' => $slug,
            'res_slug' => $res_slug
        ]);
    }

    public function edit($slug, $res_slug)
    {
        $res_id = Customlib::get_id("res", $res_slug);
        $get_res = Customlib::get_res($res_id);
        // dd($get_res);
        return view('dataset.res_edit', [
            'title' => 'Edit Resource',
            'header' => 'Edit Resource',
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
            'file_format' => 'string|max:20|nullable',
            'file_desc' => 'required|max:500',
            'slug_url' => 'required|max:500',
            'file.*' => 'max:16384|nullable',
            'old_file_path' => 'required',
            'old_file_ext' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = "";
        $file_arg['file_path'] = $request->old_file_path;
        $file_arg['file_ext'] = $request->old_file_ext;
        $file_arg['file_format'] = $request->file_format;
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

        $file_arg['file_name'] = $request->file_name;
        $file_arg['file_desc'] = $request->file_desc;
        $file_arg['update_date'] = date('Y-m-d H:i:s');
        $file_arg['update_by'] = 1;
        $file_arg['record_status'] = "A";
        $result = DB::table('tbl_resource')->where('res_id', $request->res_id)->update($file_arg);
        if ($result) {
            return redirect()->back()->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function delete($res_id){
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
