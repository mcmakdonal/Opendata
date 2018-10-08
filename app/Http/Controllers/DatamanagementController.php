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
            'index'
        ]]);
    }

    public function index(Request $request)
    {
        $get_ogz = Customlib::get_ogz();
        $get_lcs = Customlib::get_lcs();
        $get_cat = Customlib::get_cat();
        $get_frequent = Customlib::frequent();

        return view('datamanagement.index', [
            'title' => 'Create an Dataset',
            'header' => 'Create an Dataset',
            'get_ogz' => $get_ogz,
            'get_lcs' => $get_lcs,
            'get_cat' => $get_cat,
            'lock_ogz' => ($request->ogz) ? $request->ogz : "",
            'get_frequent' => $get_frequent
        ]);
    }

    
}
