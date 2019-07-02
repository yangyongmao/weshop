<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function shopping()
    {
        $session = request()->session()->get('thisUser');
        $uid = $session['data']['uid'];

        $carList = Db::table('shoppingcar')
                    ->leftJoin('goods','shoppingcar.goods_id','=','goods.goods_id')
                    ->where('uid','=',"$uid")
                    ->get();

        $count = 0;
        foreach ($carList as $v){
            $count += $v->num;
        }

        return view('index/shoppindcart/shopping',['carList' => $carList , 'count' => $count ,'thisUser' => $session['data']]);
    }

    public function cardel()
    {
        $id = [$_GET['id']];
        $res = Db::table('shoppingcar')->whereIn('carid',$id)->delete();
        if($res){
            echo json_encode(['msg' => 1]);
        }else{
            echo json_encode(['msg' => 0]);
        }
    }

    public function carchange()
    {
        $id = $_GET['id'];
        $num = $_GET['num'];
        $res = Db::table('shoppingcar')->where('carid','=',"$id")->update(['num' => $num]);
        if($res){
            echo json_encode(['msg' => 1]);
        }else{
            echo json_encode(['msg' => 0]);
        }
    }


}