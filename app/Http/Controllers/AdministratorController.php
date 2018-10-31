<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class AdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['islogin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrator = DB::table('tbl_administrator')->select('*')->where('admin_id', '!=', 1)->get()->toArray();
        return view('administrator.index', [
            'title' => 'ผู้ดูแลระบบ',
            'header' => 'ผู้ดูแลระบบ',
            'administrator' => $administrator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ogz = Customlib::get_ogz();
        return view('administrator.create', [
            'title' => 'เพิ่ม ผู้ดูแลระบบ',
            'header' => 'เพิ่ม ผู้ดูแลระบบ',
            'ogz' => $ogz,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:250',
            'last_name' => 'required|string|max:250',
            'username' => 'required|string|max:250',
            'password' => 'required|string|max:250',
            'admin_type' => 'required',
            'admin_ogz' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Customlib::check_has_username($request->username)) {
            return redirect()->back()->withErrors(array('error' => 'Username already exists'));
        }

        $args = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'admin_type' => $request->admin_type,
            'admin_ogz' => ($request->admin_type == "A") ? 0 : $request->admin_ogz,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => \Cookie::get('token'),
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $id = DB::table('tbl_administrator')->insertGetId($args, 'admin_id');
        // dd($result);
        if ($id) {
            return redirect("/administrator/$id/edit")->with('status', 'บันทึกสำเร็จ');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo $encrypted = Crypt::encryptString('Hello world.');
        // echo "<br />";
        // echo$decrypted = Crypt::decryptString($encrypted);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tbl_administrator = DB::table('tbl_administrator')->where('admin_id', $id)->get()->toArray();
        $ogz = Customlib::get_ogz();
        return view('administrator.edit', [
            'title' => 'แก้ไข ผู้ดูแลระบบ',
            'header' => 'แก้ไข ผู้ดูแลระบบ',
            'tbl_administrator' => $tbl_administrator,
            'ogz' => $ogz,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:250',
            'last_name' => 'required|string|max:250',
            'username' => 'required|string|max:250',
            'password' => 'string|max:250|nullable',
            'old_password' => 'required|string|max:250',
            'admin_type' => 'required',
            'admin_ogz' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => ($request->password != "") ? Hash::make($request->password) : $request->old_password,
            'admin_type' => $request->admin_type,
            'admin_ogz' => ($request->admin_type == "A") ? 0 : $request->admin_ogz,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $result = DB::table('tbl_administrator')->where('admin_id', $id)->update($args);
        // dd($result);
        if ($result) {
            return redirect("/administrator/$id/edit")->with('status', 'แก้ไขสำเร็จ');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === '1') {
            return response()->json([
                'status' => false,
            ]);
        }
        $result = DB::table('tbl_administrator')->where('admin_id', $id)->delete();
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
