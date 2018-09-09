<?php

namespace App\Http\Controllers;

use App\Libs\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ResourceController extends Controller
{
    public function preview($slug,$res_slug){
        echo $slug . " | " . $res_slug;
    }
}
