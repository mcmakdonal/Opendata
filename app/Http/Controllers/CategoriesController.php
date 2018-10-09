<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('islogin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_cat = Customlib::get_cat();
        return view('categories.index', [
            'title' => 'Categories',
            'header' => 'Categories',
            'is_login' => Customlib::is_login(),
            'get_cat' => $get_cat,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'cat_title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args['cat_title'] = $request->cat_title;
        $args['cat_slug'] = Customlib::make_slug("url", $request->cat_title);
        $args['create_date'] = date('Y-m-d H:i:s');
        $args['create_by'] = 1;
        $args['update_date'] = date('Y-m-d H:i:s');
        $args['update_by'] = 1;
        $args['record_status'] = "A";
        $result = DB::table('tbl_categories')->insert($args);
        if ($result) {
            return redirect('/categories')->with('status', 'Success');
        } else {
            return redirect('/categories');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'cat_title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $args = array(
            'cat_title' => $request->cat_title,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
            'record_status' => 'A',
        );

        $result = DB::table('tbl_categories')->where('cat_id', $id)->update($args);
        if ($result) {
            return redirect()->back()->with('status', 'Success');
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
        $result = DB::table('tbl_categories')->where('cat_id', $id)->delete();
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
