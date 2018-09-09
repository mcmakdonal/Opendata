<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Validator;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', [
            'title' => 'Home',
            'header' => 'Dashboard',
        ]);
    }

    public function login(){
        return view('login', [
            'title' => 'Home',
            'header' => 'Dashboard',
        ]);
    }

    public function chk_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:250',
            'password' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tbl_administrator = DB::table('tbl_administrator')->where('username', $request->username)->get()->toArray();
        if(count($tbl_administrator) === 0){
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
        if($request->password === Crypt::decryptString($tbl_administrator[0]->password)){
            return redirect("/")->cookie('token', $tbl_administrator[0]->admin_id, 14660)->cookie('name', $tbl_administrator[0]->first_name, 14660);
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }
}
