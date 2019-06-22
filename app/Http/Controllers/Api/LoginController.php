<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/20
 * Time: 8:39
 */

namespace  App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Model\Code;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->login($arr);

    }
    public function reset(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->reset($arr);

    }
    public function register(Request $request){
        $arr = $request->input();
        $file = $request->file('uheader');

        if($file->isValid()){
            $path = $request->uheader->path();
            $path = $request->uheader->store('');
            $path = "/image/".$path;
        }

        $arr = [
            'uname'=>$arr['uname'],
            'upwd'=>md5($arr['upwd']),
            'uemail'=>$arr['uemail'],
            'uphone'=>$arr['uphone'],
            'usex'=>$arr['usex'],
            'uheader' =>$path,
        ];

        $api = new Code();
        return $api->register($arr);
    }

}