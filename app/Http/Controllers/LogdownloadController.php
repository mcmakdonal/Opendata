<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Support\Facades\DB;

class LogdownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['islogin:A']);
    }

    public function index()
    {
        $log = DB::table('tbl_userdownload')
        ->select('tbl_userdownload.*', 'file_name')
        ->join('tbl_resource', 'tbl_resource.res_id', '=', 'tbl_userdownload.res_id')
        ->paginate(10);
        return view('log.index', [
            'title' => 'ประวัติดาวน์โหลด',
            'header' => 'ประวัติดาวน์โหลด',
            'log' => $log,
        ]);
    }
}
