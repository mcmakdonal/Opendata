<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class DatamanagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('islogin', ['except' => [
            'index',
        ]]);
    }

    public function index()
    {
        $tbl_exportdata = DB::table('tbl_exportdata')->select('*')->get()->toArray();
        return view('datamanagement.index', [
            'title' => 'Data Management',
            'header' => 'Data Management',
            'content' => $tbl_exportdata,
        ]);
    }

    public function create()
    {
        $get_ogz = Customlib::get_ogz();
        $get_lcs = Customlib::get_lcs();
        $get_cat = Customlib::get_cat();
        $get_frequent = Customlib::frequent();
        $view = Customlib::my_curl("http://oae-social.demotoday.net:3000/getview", "3000");

        return view('datamanagement.create', [
            'title' => 'Create Data Management',
            'header' => 'Create Data Management',
            'get_ogz' => $get_ogz,
            'get_lcs' => $get_lcs,
            'get_cat' => $get_cat,
            'get_frequent' => $get_frequent,
            'view' => $view,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ep_title' => 'required|string|max:255',
            'ep_scope_geo' => 'string|max:255',
            'ep_view' => 'required',
            'ogz_id' => 'required',
            'cat_id' => 'required',
            'ep_status' => 'required',
            'lcs_id' => 'required',
            'ep_file' => 'required',
            'ep_contact_name' => 'required|string|max:255',
            'ep_contact_email' => 'required|string|max:255',
            'ep_description' => 'nullable|string|max:255',
            'ep_tag' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ep_file = "";
        foreach ($request->ep_file as $v) {
            $ep_file .= $v;
            $ep_file .= ",";
        }
        $uniq = uniqid() . md5(date('Y-m-d H:i:s'));

        $args = array(
            'ep_title' => $request->ep_title,
            'ep_url' => $uniq,
            'ep_scope_geo' => $request->ep_scope_geo,
            'ep_view' => $request->ep_view,
            'ogz_id' => $request->ogz_id,
            'cat_id' => $request->cat_id,
            'ep_status' => $request->ep_status,
            'lcs_id' => $request->lcs_id,
            'ep_file' => $ep_file,
            'ep_contact_name' => $request->ep_contact_name,
            'ep_contact_email' => $request->ep_contact_email,
            'ep_description' => $request->ep_description,
            'ep_tag' => $request->ep_tag,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => \Cookie::get('token'),
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $id = DB::table('tbl_exportdata')->insertGetId($args);
        // dd($result);
        if ($id) {
            return redirect("/datamanagement/$id/edit")->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function edit($id)
    {
        $get_ogz = Customlib::get_ogz();
        $get_lcs = Customlib::get_lcs();
        $get_cat = Customlib::get_cat();
        $get_frequent = Customlib::frequent();
        $view = Customlib::my_curl("http://oae-social.demotoday.net:3000/getview", "3000");
        $tbl_exportdata = DB::table('tbl_exportdata')->where('ep_id', $id)->get()->toArray();

        return view('datamanagement.edit', [
            'title' => 'Edit Data Management',
            'header' => 'Edit Data Management',
            'get_ogz' => $get_ogz,
            'get_lcs' => $get_lcs,
            'get_cat' => $get_cat,
            'get_frequent' => $get_frequent,
            'view' => $view,
            'content' => $tbl_exportdata,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ep_title' => 'required|string|max:255',
            'ep_scope_geo' => 'string|max:255',
            'ep_view' => 'required',
            'ogz_id' => 'required',
            'cat_id' => 'required',
            'ep_status' => 'required',
            'lcs_id' => 'required',
            'ep_file' => 'required',
            'ep_contact_name' => 'required|string|max:255',
            'ep_contact_email' => 'required|string|max:255',
            'ep_description' => 'nullable|string|max:255',
            'ep_tag' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ep_file = "";
        foreach ($request->ep_file as $v) {
            $ep_file .= $v;
            $ep_file .= ",";
        }

        $args = array(
            'ep_title' => $request->ep_title,
            'ep_scope_geo' => $request->ep_scope_geo,
            'ep_view' => $request->ep_view,
            'ogz_id' => $request->ogz_id,
            'cat_id' => $request->cat_id,
            'ep_status' => $request->ep_status,
            'lcs_id' => $request->lcs_id,
            'ep_file' => $ep_file,
            'ep_contact_name' => $request->ep_contact_name,
            'ep_contact_email' => $request->ep_contact_email,
            'ep_description' => $request->ep_description,
            'ep_tag' => $request->ep_tag,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $result = DB::table('tbl_exportdata')->where('ep_id', $id)->update($args);
        // dd($result);
        if ($result) {
            return redirect("/datamanagement/$id/edit")->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function destroy($id)
    {
        $result = DB::table('tbl_exportdata')->where('ep_id', $id)->delete();
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

    public function export($id)
    {
        $tbl_exportdata = DB::table('tbl_exportdata')->where('ep_id', $id)->get()->toArray();
        // dd($tbl_exportdata);
        $args = [];
        foreach($tbl_exportdata as $k => $v){
            $args['view'] = $v->ep_view;
            $args['ogz_id'] = $v->ogz_id;
            $args['dts_title'] = $v->ep_title;
            $args['dts_description'] = $v->ep_description;
            $args['dts_status'] = $v->ep_status;
            $args['lcs_id'] = $v->lcs_id;
            $args['cat_id'] = $v->cat_id;
            $args['dts_scope_geo'] = $v->ep_scope_geo;
            $args['dts_tag'] = $v->ep_tag;
            $args['ep_file'] = $v->ep_file;
            $args['dts_contact_name'] = $v->ep_contact_name;
            $args['dts_contact_email'] = $v->ep_contact_email;
            $args['dts_permission'] = "all";
            $args['dts_res_point'] = "3";
            $args['dts_view'] = "0";
            $args['create_date'] = $v->create_date;
            $args['create_by'] = $v->create_by;
            $args['update_date'] = $v->update_date;
            $args['update_by'] = $v->update_by;
            $args['record_status'] = $v->record_status;
        }

        $result = Customlib::my_curl("http://oae-social.demotoday.net:3000/input", "3000","POST",$args);
        if ($result->status) {
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
