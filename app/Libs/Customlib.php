<?php

namespace App\Libs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class Customlib extends ServiceProvider
{
    public static function get_id($type, $slug)
    {
        $matchThese = [];
        if ($type == "ogz") {
            $matchThese[] = ['ogz_url', '=', $slug];
            if (!Customlib::is_login()) {
                $matchThese[] = ['ogz_status', '=', "pb"];
            }
            $result = DB::table('tbl_organization')->select('ogz_id')->where($matchThese)->get()->toArray();
            if (count($result) > 0) {
                return $result[0]->ogz_id;
            } else {
                return false;
            }
        } elseif ($type == "dts") {
            $matchThese[] = ['dts_url', '=', $slug];
            if (!Customlib::is_login()) {
                $matchThese[] = ['dts_status', '=', "pb"];
            }
            $result = DB::table('tbl_dataset')->select('dts_id')->where($matchThese)->get()->toArray();
            if (count($result) > 0) {
                return $result[0]->dts_id;
            } else {
                return false;
            }
        } elseif ($type == "res") {
            $matchThese[] = ['file_slug', '=', $slug];
            $result = DB::table('tbl_resource')->select('res_id')->where($matchThese)->get()->toArray();
            if (count($result) > 0) {
                return $result[0]->res_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function get_url($type, $slug)
    {
        if ($type == "ogz") {
            $result = DB::table('tbl_organization')->where('ogz_url', $slug)->count();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } elseif ($type == "dts") {
            $result = DB::table('tbl_dataset')->where('dts_url', $slug)->count();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function get_all_data($organization = "", $format = "", $license = "", $categories = "", $title = "", $order = "", $page = 1)
    {

        $limit = 10;
        if ($page == 1) {
            $offset = 0;
        } else {
            $offset = ($limit * $page) - 1;
        }
        $matchThese = [];
        if ($organization != "") {
            $matchThese[] = ['tbl_dataset.ogz_id', '=', $organization];
        }
        // if ($format != "") {
        //     $matchThese[] = ['tbl_resource.file_format', '=', $format];
        // }
        // if ($license != "") {
        //     $matchThese[] = ['tbl_license.lcs_id', '=', "$license"];
        // }
        if ($categories != "") {
            $matchThese[] = ['tbl_dataset.cat_id', '=', $categories];
        }
        if ($title != "") {
            $matchThese[] = ['tbl_dataset.dts_title', 'like', "%$title%"];
        }
        $matchOrder = 'tbl_dataset.dts_id DESC';
        if ($order != "") {
            if ($order == "view") {
                $matchOrder = 'tbl_dataset.dts_view DESC';
            } elseif ($order == "txt") {
                $matchOrder = 'tbl_dataset.dts_title ASC';
            } elseif ($order == "update") {
                $matchOrder = 'tbl_dataset.update_date DESC';
            }
        }

        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        // return $matchThese;
        $select = ['tbl_dataset.dts_id', 'tbl_dataset.dts_title', 'tbl_dataset.dts_url', 'tbl_dataset.dts_status', 'tbl_dataset.dts_description', 'tbl_dataset.dts_res_point', 'tbl_categories.cat_title'];
        $tbl_dataset = DB::table('tbl_dataset')
            ->select($select)
        // ->join('tbl_organization', 'tbl_organization.ogz_id', '=', 'tbl_dataset.ogz_id')
        // ->leftJoin('tbl_resource', 'tbl_resource.dts_id', '=', 'tbl_dataset.dts_id')
        // ->leftJoin('tbl_license', 'tbl_license.lcs_id', '=', 'tbl_dataset.lcs_id')
            ->join('tbl_categories', 'tbl_categories.cat_id', '=', 'tbl_dataset.cat_id')
            ->where($matchThese)
            ->orderByRaw($matchOrder)
            ->groupBy($select)
            ->offset($offset)
            ->limit($limit)
            ->get();

        foreach ($tbl_dataset as $k => $v) {
            $str = "";
            $format = DB::table('tbl_resource')
                ->select('file_format')
                ->where("dts_id", $v->dts_id)
                ->get()->toArray();
            foreach ($format as $kk => $vv) {
                $str .= $vv->file_format;
                $str .= ",";
            }
            // add ลง array
            $tbl_dataset[$k]->format = $str;
        }

        $count = DB::table('tbl_dataset')
            ->select('tbl_dataset.dts_id')
            ->leftJoin('tbl_resource', 'tbl_resource.dts_id', '=', 'tbl_dataset.dts_id')
            ->where($matchThese)
            ->get()->toArray();

        $ceil = ceil(count($count) / $limit);
        $args = [
            'table' => $tbl_dataset,
            'totalPages' => (($ceil == 0) ? 1 : $ceil),
        ];
        return $args;
    }

    public static function get_ogz($slug = "", $title = "", $pagi = false)
    {
        $matchThese = [];
        if ($slug != "") {
            $matchThese[] = ['tbl_organization.ogz_url', '=', "$slug"];
        }
        if ($title != "") {
            $matchThese[] = ['tbl_organization.ogz_title', 'like', "%$title%"];
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_organization.ogz_status', '=', "pb"];
        }
        if ($pagi) {
            $tbl_organization = DB::table('tbl_organization')
                ->select('tbl_organization.ogz_id', 'ogz_title', 'ogz_url', 'ogz_description', 'ogz_image', 'ogz_status', DB::raw('count(tbl_dataset.ogz_id) num'))
                ->leftJoin('tbl_dataset', 'tbl_dataset.ogz_id', '=', 'tbl_organization.ogz_id')
                ->where($matchThese)
                ->groupBy('tbl_organization.ogz_id', 'ogz_title', 'ogz_url', 'ogz_description', 'ogz_image', 'ogz_status')
                ->get()
                ->toArray();
        } else {
            $tbl_organization = DB::table('tbl_organization')
                ->select('tbl_organization.ogz_id', 'ogz_title', 'ogz_url', 'ogz_description', 'ogz_image', 'ogz_status', DB::raw('count(tbl_dataset.ogz_id) num'))
                ->leftJoin('tbl_dataset', 'tbl_dataset.ogz_id', '=', 'tbl_organization.ogz_id')
                ->where($matchThese)
                ->groupBy('tbl_organization.ogz_id', 'ogz_title', 'ogz_url', 'ogz_description', 'ogz_image', 'ogz_status')
                ->get()
                ->toArray();
        }

        return $tbl_organization;
    }

    public static function get_metadata($dts_id = "")
    {

        if ($dts_id != "") {
            $matchThese['tbl_metadata.dts_id'] = $dts_id;
        }
        $tbl_resource = DB::table('tbl_metadata')->where($matchThese)->get()->toArray();
        return $tbl_resource;
    }

    public static function get_dts($ogz_id = "", $title = "", $slug_url = "")
    {
        $matchThese = [];
        if ($ogz_id != "") {
            $matchThese['tbl_dataset.ogz_id'] = $ogz_id;
        }
        if ($title != "") {
            $matchThese[] = ['tbl_dataset.dts_title', 'like', "%$title%"];
        }
        if ($slug_url != "") {
            $matchThese[] = ['tbl_dataset.dts_url', '=', "$slug_url"];
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        $tbl_dataset = DB::table('tbl_dataset')
            ->select('tbl_dataset.*', 'ogz_title', 'license', 'cat_title')
            ->where($matchThese)
            ->join('tbl_license', 'tbl_license.lcs_id', '=', 'tbl_dataset.lcs_id')
            ->join('tbl_categories', 'tbl_categories.cat_id', '=', 'tbl_dataset.cat_id')
            ->join('tbl_organization', 'tbl_organization.ogz_id', '=', 'tbl_dataset.ogz_id')
            ->get()
            ->toArray();
        return $tbl_dataset;
    }

    public static function get_res($res_id = "", $dts_id = "")
    {
        $matchThese = [];
        if ($res_id != "") {
            $matchThese['tbl_resource.res_id'] = $res_id;
        }
        if ($dts_id != "") {
            $matchThese['tbl_resource.dts_id'] = $dts_id;
        }
        $tbl_resource = DB::table('tbl_resource')->where($matchThese)->get()->toArray();
        return $tbl_resource;
    }

    public static function get_lcs()
    {
        // $tbl_license = DB::table('tbl_license')->get()->toArray();
        $matchThese = [];
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        $tbl_license = DB::table('tbl_license')
            ->select('tbl_license.lcs_id', 'tbl_license.license', DB::raw('count(tbl_dataset.lcs_id) num'))
            ->leftJoin('tbl_dataset', 'tbl_dataset.lcs_id', '=', 'tbl_license.lcs_id')
            ->where($matchThese)
            ->groupBy('lcs_id', 'license')
            ->get()
            ->toArray();

        return $tbl_license;
    }

    public static function get_cat()
    {
        $matchThese = [];
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        $tbl_categories = DB::table('tbl_categories')
            ->select('tbl_categories.cat_id', 'tbl_categories.cat_title', DB::raw('count(tbl_dataset.cat_id) num'))
            ->leftJoin('tbl_dataset', 'tbl_dataset.cat_id', '=', 'tbl_categories.cat_id')
            ->where($matchThese)
            ->groupBy('cat_id', 'cat_title')
            ->get()
            ->toArray();

        return $tbl_categories;
    }

    public static function get_ogz_count($slug = "")
    {
        $matchThese = [];
        if ($slug != "") {
            $matchThese['tbl_organization.ogz_url'] = $slug;
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_organization.ogz_status', '=', "pb"];
        }
        // return $matchThese;
        $tbl_organization = DB::table('tbl_organization')
            ->select('tbl_organization.ogz_id', 'tbl_organization.ogz_title', 'tbl_organization.ogz_url', DB::raw('count(tbl_dataset.dts_id) num'))
            ->leftJoin('tbl_dataset', 'tbl_dataset.ogz_id', '=', 'tbl_organization.ogz_id')
            ->where($matchThese)
            ->groupBy('ogz_id', 'ogz_title', 'ogz_url')
            ->get()
            ->toArray();

        return $tbl_organization;
    }

    public static function filter_cat($cat_id = "", $ogz_id = "")
    {
        $matchThese = [];
        if ($cat_id != "") {
            $matchThese['tbl_dataset.cat_id'] = $cat_id;
        }
        if ($ogz_id != "") {
            $matchThese['tbl_dataset.ogz_id'] = $ogz_id;
        }
        $res = DB::table('tbl_dataset')
            ->select('tbl_dataset.ogz_id', DB::raw('count(tbl_dataset.ogz_id) sum'))
            ->leftJoin('tbl_organization', 'tbl_organization.ogz_id', '=', 'tbl_dataset.ogz_id')
            ->where($matchThese)
            ->groupBy('tbl_dataset.ogz_id')
            ->get()
            ->toArray();
        return $res;
    }

    public static function filter_ogz($ogz_id = "", $cat_id = "")
    {
        $matchThese = [];
        if ($ogz_id != "") {
            $matchThese['tbl_dataset.ogz_id'] = $ogz_id;
        }
        if ($cat_id != "") {
            $matchThese['tbl_dataset.cat_id'] = $cat_id;
        }
        $res = DB::table('tbl_dataset')
            ->select('tbl_dataset.cat_id', DB::raw('count(tbl_dataset.cat_id) sum'))
            ->leftJoin('tbl_categories', 'tbl_categories.cat_id', '=', 'tbl_dataset.cat_id')
            ->where($matchThese)
            ->groupBy('tbl_dataset.cat_id')
            ->get()
            ->toArray();
        return $res;
    }

    public static function file_has()
    {
        $matchThese = [];
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        $res = DB::table('tbl_resource')
            ->select('file_format', DB::raw('count(tbl_resource.file_format) num'))
            ->distinct()
            ->join('tbl_dataset', 'tbl_dataset.dts_id', '=', 'tbl_resource.dts_id')
            ->where($matchThese)
            ->groupBy('file_format')
            ->get()
            ->toArray();
        return $res;
    }

    public static function update_rate_star($dts_id)
    {
        // ดึงไฟล์ ext ทั้งหมดมา เพื่อ นำมาเช็คหาค่่า ดาวสูงสุด
        $all_file_ext = DB::table('tbl_resource')
            ->select('file_format')
            ->distinct()
            ->join('tbl_dataset', 'tbl_dataset.dts_id', '=', 'tbl_resource.dts_id')
            ->where('tbl_resource.dts_id', $dts_id)
            ->get()
            ->toArray();

        $file_star = [];
        foreach ($all_file_ext as $k => $v) {
            $file_star[] = Customlib::rate_start($v->file_format);
        }
        $max_star = max($file_star);

        $args = ['dts_res_point' => $max_star];
        return DB::table('tbl_dataset')->where('dts_id', $dts_id)->update($args);
    }

    public static function check_has_username($username = "")
    {
        $matchThese = [];
        $matchThese['username'] = $username;
        $check_has_username = DB::table('tbl_administrator')
            ->select('admin_id')
            ->where($matchThese)
            ->get()
            ->toArray();

        if (count($check_has_username) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function log_download($log_id = "", $search = "")
    {
        $matchThese = [];
        if ($search != "") {
            $matchThese[] = ['tbl_dataset.dts_status', '=', "pb"];
        }
        $tbl_userdownload = DB::table('tbl_userdownload')
            ->select('tbl_userdownload.*', 'file_name')
            ->join('tbl_resource', 'tbl_resource.res_id', '=', 'tbl_userdownload.res_id')
            ->where($matchThese)
            ->get()
            ->toArray();
        return $tbl_userdownload;
    }

    public static function is_login()
    {
        if ((\Cookie::get('token') !== null)) {
            return true;
        } else {
            return false;
        }
    }

    public static function make_slug($type, $value)
    {
        if ($type == 'url') {
            $find = array(" ", "/", "@", ".", "_");
        } else {
            $find = array(" ", "/", "@", "_");
        }

        $replace = array("-");
        $url = strtolower(str_replace($find, $replace, $value));
        return $url;
    }

    public static function null_args($args)
    {
        if (!(count($args) > 0)) {
            return response('Unauthorized.', 401);
        }
    }

    public static function create_dir()
    {
        $arg = ['files', 'files/og_image', 'files/res'];
        foreach ($arg as $dir) {
            if (is_dir($dir)) {
                chmod(public_path($dir), 0777);
            } else {
                mkdir(public_path($dir), 0777, true);
            }
        }

    }

    public static function rate_start($file)
    {
        $ext = strtolower($file);
        $start_1 = ['pdf', 'doc', 'docx', 'txt', 'tiff', 'jpeg', 'png'];
        $start_2 = ['xls', 'xlsx'];
        $start_3 = ['csv', 'ods', 'xml', 'json', 'kml', 'shp', 'kmz'];
        $start_4 = ['rdf'];
        $start_5 = ['rdf'];
        if (in_array($ext, $start_1)) {
            return 1;
        } else if (in_array($ext, $start_2)) {
            return 2;
        } else if (in_array($ext, $start_3)) {
            return 3;
        } else if (in_array($ext, $start_4)) {
            return 4;
        } else if (in_array($ext, $start_5)) {
            return 5;
        } else {
            return 1;
        }
    }

    public static function frequent()
    {
        $arg = ['Not updated(historical only)', 'Annual', 'Quarterly', 'Monthly'];
        return $arg;
    }

    public static function my_curl($path, $port = "3000", $method = "GET", $args = ['' => ''])
    {
        $curl = curl_init();
        $args = json_encode($args, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port,
            CURLOPT_URL => $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => "$args",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            exit();
        } else {
            $result = json_decode($response);
            return $result;
        }
    }
}
