<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        $administrator = DB::table('tbl_administrator')->select('*')->get()->toArray();
        return view('administrator.index', [
            'title' => 'Administrator',
            'header' => 'Administrator',
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
        return view('administrator.create', [
            'title' => 'Create Administrator',
            'header' => 'Create Administrator',
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Crypt::encryptString($request->password),
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => 1,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'record_status' => 'A',
        );

        $id = DB::table('tbl_administrator')->insertGetId($args);
        // dd($result);
        if ($id) {
            return redirect("/administrator/$id/edit")->with('status', 'Success');
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
        return view('administrator.edit', [
            'title' => 'Edit Administrator',
            'header' => 'Edit Administrator',
            'tbl_administrator' => $tbl_administrator,
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => ($request->password != "") ? Crypt::encryptString($request->password) : $request->old_password,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'record_status' => 'A',
        );

        $result = DB::table('tbl_administrator')->where('admin_id', $id)->update($args);
        // dd($result);
        if ($result) {
            return redirect("/administrator/$id/edit")->with('status', 'Update Success');
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
