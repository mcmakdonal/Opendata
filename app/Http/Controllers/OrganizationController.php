<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('islogin', ['except' => [
            'index',
            'page',
        ]]);
    }

    public function index()
    {
        $get_ogz = Customlib::get_ogz();
        // dd($paginatedItems);
        return view('organization.index', [
            'title' => 'Organization',
            'header' => 'Organization',
            'get_ogz' => $get_ogz,
            'is_login' => Customlib::is_login(),
        ]);
    }

    function new () {
        return view('organization.new', [
            'title' => 'Create an Organization',
        ]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required|string|max:250',
            'description' => 'required|max:500',
            'status' => 'string|required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = "";
        if ($request->hasfile('image')) {
            if ($request->file('image')) {
                $file = $request->file('image');
                $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/og_image/', $name);
                $image = 'files/og_image/' . $name;
            }
        }

        $find = array(" ", "/", "@", ".", "_");
        $replace = array("-");
        $url = strtolower(str_replace($find, $replace, $request->url));
        if (Customlib::get_url("ogz", $url)) {
            return redirect()->back()->withErrors("Url ถูกใช้ไปแล้ว กรุณาเปลี่ยน url ใหม่");
        }

        $args = array(
            'title' => $request->title,
            'url' => $url,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $image,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => 1,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'record_status' => 'A',
        );

        $result = DB::table('tbl_organization')->insert($args);
        // dd($result);
        if ($result) {
            return redirect("/organization/page/$url")->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function page(string $slug_url)
    {
        if ($slug_url != "") {
            $ogz_id = Customlib::get_id("ogz", $slug_url);
            if ($ogz_id == "") {
                return redirect("/organization")->with('status', 'Error');
                exit();
            }
            $tbl_dataset = DB::table('tbl_dataset')->where('ogz_id', $ogz_id)->get();
            return view('organization.page', [
                'title' => 'Organization',
                'header' => 'Organization',
                'content' => $tbl_dataset,
                'slug_url' => $slug_url,
                'is_login' => Customlib::is_login(),
            ]);
        }
    }

    public function edit(string $slug_url)
    {
        if ($slug_url != "") {
            $get_ogz = Customlib::get_ogz($slug_url);
            $ogz_id = $get_ogz[0]->ogz_id;
            if ($ogz_id == "") {
                return redirect("/organization")->with('status', 'Success');
                exit();
            }
            $tbl_dataset = DB::table('tbl_dataset')->where('ogz_id', $ogz_id)->get();
            return view('organization.edit', [
                'title' => 'Manage Organization',
                'header' => 'Manage Organization',
                'content' => $get_ogz,
                'dataset' => $tbl_dataset,
                'slug_url' => $slug_url,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|max:500',
            'status' => 'string|required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image =  $request->old_image;
        if ($request->hasfile('image')) {
            if ($request->file('image')) {
                $file = $request->file('image');
                $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/og_image/', $name);
                $image = 'files/og_image/' . $name;
            }
        }

        $args = array(
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $image,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'record_status' => 'A',
        );
        $slug_url = $request->slug_url;
        $ogz_id = Customlib::get_id("ogz", $slug_url);
        // dd($ogz_id);
        $result = DB::table('tbl_organization')->where('ogz_id', $ogz_id)->update($args);
        // dd($result);
        if ($result) {
            return redirect()->back()->with('status', 'Success');
        } else {
            return redirect()->back()->withErrors(array('error' => 'error'));
        }
    }

    public function delete(string $slug_url)
    {
        if ($slug_url != "") {
            $ogz_id = Customlib::get_id("ogz", $slug_url);
            $result = DB::table('tbl_organization')->where('ogz_id', $ogz_id)->delete();
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
