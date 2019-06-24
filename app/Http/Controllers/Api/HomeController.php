<?php

/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/20
 * Time: 14:05
 */

namespace  App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Model\Code;

class HomeController extends Controller
{
    public function Carousel(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->Carousel($arr);
    }

}