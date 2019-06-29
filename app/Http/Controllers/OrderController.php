<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function orderShow(Request $request)
    {
        $data = $request->session()->get('thisUser');
        if(!empty($data))
        {
            $res = DB::table('order')->join('status','order.o_status','=','s_id')->where('uid','=',$data['uid'])->select()->get();
            return view('index.order.order')->with(['data'=>$res]);
        }else{

            return view('index.login.login');
        }


    }


}