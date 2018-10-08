<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;

class LogdownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['islogin']);
    }

    public function index()
    {
        $log = Customlib::log_download();
        return view('log.index', [
            'title' => 'Log Download',
            'header' => 'Log Download',
            'log' => $log,
        ]);
    }
}
