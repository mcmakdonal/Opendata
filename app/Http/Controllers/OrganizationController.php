<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
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

    public function index(Request $request)
    {
        $title = $request->title;
        $get_ogz = Customlib::get_ogz("", $title, true);
        // dd($get_ogz);
        return view('organization.index', [
            'title' => 'หน่วยงาน',
            'header' => 'หน่วยงาน',
            'get_ogz' => $get_ogz,
            'is_login' => Customlib::is_login(),
        ]);
    }

    function new () {
        $uniq = uniqid() . md5(date('Y-m-d H:i:s'));
        return view('organization.new', [
            'title' => 'สร้าง หน่วยงาน', 'uniq' => $uniq,
        ]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ogz_title' => 'required',
            'ogz_url' => 'required|string|max:250',
            'ogz_description' => 'required|max:500',
            'ogz_status' => 'string|required',
            'ogz_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = "";
        if ($request->hasfile('ogz_image')) {
            if ($request->file('ogz_image')) {
                Customlib::create_dir();
                $file = $request->file('ogz_image');
                $image_info = getimagesize($file);
                $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/og_image/', $name);
                $image_resize = Image::make(public_path() . '/files/og_image/' . $name);
                if ($image_info[0] > 300 && $image_info[1] > 300) {
                    $image_resize->resize(300, 300);
                } else {
                    // resize the image to a height of 300 and constrain aspect ratio (auto width)
                    $image_resize->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $image_resize->save(public_path() . '/files/og_image/' . $name);
                $image = 'files/og_image/' . $name;
            }
        }

        $url = Customlib::make_slug("url", $request->ogz_url);
        if (Customlib::get_url("ogz", $url)) {
            return redirect()->back()->withErrors("ลิงก์ถาวร ถูกใช้ไปแล้ว กรุณาเปลี่ยน ลิงก์ถาวร ใหม่");
        }

        $args = array(
            'ogz_title' => $request->ogz_title,
            'ogz_url' => $url,
            'ogz_description' => $request->ogz_description,
            'ogz_status' => $request->ogz_status,
            'ogz_image' => $image,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => \Cookie::get('token'),
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
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

    public function page(string $slug_url, Request $request)
    {
        if ($slug_url != "") {
            $ogz_id = Customlib::get_id("ogz", $slug_url);
            $get_ogz = Customlib::get_ogz($slug_url);
            if ($ogz_id == false) {
                abort(404);
            }
            $get_cat = Customlib::get_cat();
            return view('organization.page', [
                'title' => 'หน่วยงาน',
                'header' => 'หน่วยงาน',
                'slug_url' => $slug_url,
                'ogz_id' => $ogz_id,
                'is_login' => Customlib::is_login(),
                'get_cat' => $get_cat,
                'ogz_title' => $get_ogz[0]->ogz_title,
            ]);
        }
    }

    public function edit(string $slug_url)
    {
        if ($slug_url != "") {
            $get_ogz = Customlib::get_ogz($slug_url);
            if (!(count($get_ogz) > 0)) {
                abort(404);
            }
            $ogz_id = $get_ogz[0]->ogz_id;
            $tbl_dataset = DB::table('tbl_dataset')->where('ogz_id', $ogz_id)->get();
            return view('organization.edit', [
                'title' => 'แก้ไข หน่วยงาน',
                'header' => 'แก้ไข หน่วยงาน',
                'content' => $get_ogz,
                'dataset' => $tbl_dataset,
                'slug_url' => $slug_url,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ogz_title' => 'required',
            'ogz_description' => 'required|max:500',
            'ogz_status' => 'string|required',
            'ogz_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->ogz_old_image;
        if ($request->hasfile('ogz_image')) {
            if ($request->file('ogz_image')) {
                Customlib::create_dir();
                $file = $request->file('ogz_image');
                $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/files/og_image/', $name);
                $image_resize = Image::make(public_path() . '/files/og_image/' . $name);
                $image_resize->resize(300, 300);
                $image_resize->save(public_path() . '/files/og_image/' . $name);
                $image = 'files/og_image/' . $name;
            }
        }

        $args = array(
            'ogz_title' => $request->ogz_title,
            'ogz_description' => $request->ogz_description,
            'ogz_status' => $request->ogz_status,
            'ogz_image' => $image,
            'update_date' => date('Y-m-d H:i:s'),
            'update_by' => \Cookie::get('token'),
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
