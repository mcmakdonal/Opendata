<?php

namespace App\Libs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class Customlib extends ServiceProvider
{
    public static function get_id($type, $slug)
    {
        if ($type == "ogz") {
            $result = DB::table('tbl_organization')->select('ogz_id')->where('url', $slug)->get();
            if ($result) {
                return $result[0]->ogz_id;
            } else {
                return false;
            }
        } elseif ($type == "dts") {
            $result = DB::table('tbl_dataset')->select('dts_id')->where('url', $slug)->get();
            if ($result) {
                return $result[0]->dts_id;
            } else {
                return false;
            }
        } elseif ($type == "res") {
            $result = DB::table('tbl_resource')->select('res_id')->where('file_slug', $slug)->get();
            if ($result) {
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

    public static function get_dts($ogz_slug = "", $format = "")
    {
        $matchThese = [];
        if ($ogz_slug != "") {
            $ogz_id = Customlib::get_id("ogz", $ogz_slug);
            $matchThese['tbl_dataset.ogz_id'] = $ogz_id;
        }
        if ($format != "") {
            $matchThese['tbl_resource.file_format'] = $format;
        }
        $select = ['tbl_dataset.dts_id', 'tbl_dataset.title', 'tbl_dataset.url', 'tbl_dataset.status', 'tbl_dataset.description'];
        $tbl_dataset = DB::table('tbl_dataset')
            ->select($select)
            ->join('tbl_organization', 'tbl_organization.ogz_id', '=', 'tbl_dataset.ogz_id')
            ->leftJoin('tbl_resource', 'tbl_resource.dts_id', '=', 'tbl_dataset.dts_id')
            ->where($matchThese)
            ->groupBy($select)
            ->get()
            ->toArray();
        return $tbl_dataset;

    }

    public static function get_ogz()
    {
        $tbl_organization = DB::table('tbl_organization')->get()->toArray();
        return $tbl_organization;
    }

    public static function get_lcs()
    {
        $tbl_license = DB::table('tbl_license')->get()->toArray();
        return $tbl_license;
    }

    public static function get_ogz_count($slug = "")
    {
        $matchThese = [];
        if ($slug != "") {
            $matchThese['tbl_organization.url'] = $slug;
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
        $res = DB::table('tbl_resource')
            ->select('file_format', DB::raw('count(tbl_resource.file_format) num'))
            ->distinct()
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

}
