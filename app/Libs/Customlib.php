<?php

namespace App\Libs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class Customlib extends ServiceProvider
{
    public static function get_id($type, $slug)
    {
        $matchThese = [];
        if (!Customlib::is_login()) {
            $matchThese[] = ['status', '=', "pb"];
        }
        if ($type == "ogz") {
            $matchThese[] = ['url', '=', $slug];
            $result = DB::table('tbl_organization')->select('ogz_id')->where($matchThese)->get()->toArray();
            if (count($result) > 0) {
                return $result[0]->ogz_id;
            } else {
                return false;
            }
        } elseif ($type == "dts") {
            $matchThese[] = ['url', '=', $slug];
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
            $result = DB::table('tbl_organization')->where('url', $slug)->count();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } elseif ($type == "dts") {
            $result = DB::table('tbl_dataset')->where('url', $slug)->count();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function get_join_dts($ogz_slug = "", $format = "", $title = "", $license = "")
    {
        $matchThese = [];
        if ($ogz_slug != "") {
            $ogz_id = Customlib::get_id("ogz", $ogz_slug);
            $matchThese[] = ['tbl_dataset.ogz_id', '=', $ogz_id];
        }
        if ($format != "") {
            $matchThese[] = ['tbl_resource.file_format', '=', $format];
        }
        if ($title != "") {
            $matchThese[] = ['tbl_dataset.title', 'like', "%$title%"];
        }
        if ($license != "") {
            $matchThese[] = ['tbl_license.license', 'like', "%$license%"];
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.status', '=', "pb"];
        }
        // return $matchThese;
        $select = ['tbl_dataset.dts_id', 'tbl_dataset.title', 'tbl_dataset.url', 'tbl_dataset.status', 'tbl_dataset.description'];
        $tbl_dataset = DB::table('tbl_dataset')
            ->select('tbl_dataset.dts_id', 'tbl_dataset.title', 'tbl_dataset.url', 'tbl_dataset.status', 'tbl_dataset.description', DB::raw('group_concat(tbl_resource.file_format) format'))
            ->join('tbl_organization', 'tbl_organization.ogz_id', '=', 'tbl_dataset.ogz_id')
            ->leftJoin('tbl_resource', 'tbl_resource.dts_id', '=', 'tbl_dataset.dts_id')
            ->leftJoin('tbl_license', 'tbl_license.lcs_id', '=', 'tbl_dataset.lcs_id')
            ->where($matchThese)
            ->groupBy($select)
            ->get()
            ->toArray();
        return $tbl_dataset;

    }

    public static function get_ogz($slug = "", $title = "")
    {
        $matchThese = [];
        if ($slug != "") {
            $matchThese[] = ['tbl_organization.url', '=', "$slug"];
        }
        if ($title != "") {
            $matchThese[] = ['tbl_organization.title', 'like', "%$title%"];
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_organization.status', '=', "pb"];
        }
        $tbl_organization = DB::table('tbl_organization')->where($matchThese)->get()->toArray();
        return $tbl_organization;
    }

    public static function get_dts($ogz_id = "", $title = "", $slug_url = "")
    {
        $matchThese = [];
        if ($ogz_id != "") {
            $matchThese['tbl_dataset.ogz_id'] = $ogz_id;
        }
        if ($title != "") {
            $matchThese[] = ['tbl_dataset.title', 'like', "%$title%"];
        }
        if ($slug_url != "") {
            $matchThese[] = ['tbl_dataset.url', '=', "$slug_url"];
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.status', '=', "pb"];
        }
        $tbl_dataset = DB::table('tbl_dataset')->where($matchThese)->get()->toArray();
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
            $matchThese[] = ['tbl_dataset.status', '=', "pb"];
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

    public static function get_ogz_count($slug = "")
    {
        $matchThese = [];
        if ($slug != "") {
            $matchThese['tbl_organization.url'] = $slug;
        }
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_organization.status', '=', "pb"];
        }
        // return $matchThese;
        $tbl_organization = DB::table('tbl_organization')
            ->select('tbl_organization.title', 'tbl_organization.url', DB::raw('count(tbl_dataset.dts_id) num'))
            ->leftJoin('tbl_dataset', 'tbl_dataset.ogz_id', '=', 'tbl_organization.ogz_id')
            ->where($matchThese)
            ->groupBy('title', 'url')
            ->get()
            ->toArray();

        return $tbl_organization;
    }

    public static function file_has()
    {
        $matchThese = [];
        if (!Customlib::is_login()) {
            $matchThese[] = ['tbl_dataset.status', '=', "pb"];
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

}
