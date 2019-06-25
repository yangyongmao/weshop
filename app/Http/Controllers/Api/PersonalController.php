<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/20
 * Time: 19:32
 */

namespace  App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Model\Code;

class PersonalController extends Controller
{
    public function show(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->demoshow($arr);
    }
    public function update(Request $request){
        $arr = $request->input();
        if($request->input('uheader')){
            $file = $request->file('uheader');
            if($file->isValid()){
                $path = $request->uheader->path();
                $path = $request->uheader->store('');
                $path = "/image/".$path;
            }
        }else{
            $path = null;
        }

        $arr = [
            'uname'=>$arr['uname'],
            'uemail'=>$arr['uemail'],
            'uphone'=>$arr['uphone'],
            'uheader'=>$path,
            'usex'=>$arr['usex'],
            'token' =>$arr['token'],
        ];
        $api = new Code;
        return $api->demoupdate($arr);
    }
    public function order(Request $request){
        $arr = $request->input();
        $api = new Code;
        return $api->demorder($arr);
    }
    public function shopcat(){

    }
    public function address(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->address($arr);
    }
    public function add_address(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->add_address($arr);
    }
    public function update_address(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->update_address($arr);
    }
    public function delete_address(Request $request){
        $arr = $request->input();
        $api = new Code();
        return $api->delete_address($arr);
    }
}