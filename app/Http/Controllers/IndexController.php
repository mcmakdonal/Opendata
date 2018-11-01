<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function login()
    {
        return view('login', [
            'title' => 'Login',
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
        if (count($tbl_administrator) === 0) {
            return redirect()->back()->withErrors(array('error' => 'Username or Password Incorrect'));
        }

        if (Hash::check($request->password, $tbl_administrator[0]->password)) {
            return redirect("/")
            ->cookie('token', $tbl_administrator[0]->admin_id, 14660)
            ->cookie('name', $tbl_administrator[0]->first_name, 14660)
            ->cookie('m_type', $tbl_administrator[0]->admin_type, 14660)
            ->cookie('m_ogz', $tbl_administrator[0]->admin_ogz, 14660);
        } else {
            return redirect()->back()->withErrors(array('error' => 'Username or Password Incorrect'));
        }
    }

    public function is_login()
    {
        return response()->json([
            'status' => Customlib::is_login(),
        ]);
    }

    public function is_exists(Request $request)
    {
        $username = $request->username;
        return response()->json([
            'status' => Customlib::check_has_username($username),
        ]);
    }

    public function user_download(Request $request)
    {
        $args = [
            'res_id' => $request->res_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'description' => $request->description,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => 0,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 0,
            'record_status' => 'A',
        ];

        $result = DB::table('tbl_userdownload')->insert($args);
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

    public function list_data(Request $request)
    {
        $organization = $request->organization;
        $format = $request->format;
        $license = $request->license;
        $categories = $request->categories;
        $title = $request->title;
        $order = $request->order;
        $page = ($request->page) ? $request->page : 1;

        $get_join_dts = Customlib::get_all_data($organization, $format, $license, $categories, $title, $order, $page);
        $arg = [
            'data' => $get_join_dts['table'],
            'is_login' => Customlib::is_login(),
            'totalPages' => $get_join_dts['totalPages'],
            'startPage' => (int) $page,
        ];
        // dd($arg);
        return response()->json($arg);
    }

    public function filter_cat(Request $request){
        $categories = ($request->categories) ? $request->categories : "";
        $organization = ($request->organization) ? $request->organization : "";
        $filter_cat = Customlib::filter_cat($categories,$organization);
        $arg = [
            'data' => $filter_cat

        ];
        return response()->json($arg);
    }

    public function filter_ogz(Request $request){
        $organization = ($request->organization) ? $request->organization : "";
        $categories = ($request->categories) ? $request->categories : "";
        $filter_ogz = Customlib::filter_ogz($organization,$categories);
        $arg = [
            'data' => $filter_ogz

        ];
        return response()->json($arg);
    }

}
