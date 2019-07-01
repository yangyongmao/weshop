<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function shopping()
    {
//        $session = request()->session()->get('thisUser');
        $uid = 1;
        $carList = Db::table('shoppingcar')
                    ->leftJoin('goods','shoppingcar.goods_id','=','goods.goods_id')
                    ->where('uid','=',"$uid")
                    ->get();
//        echo "<pre>";
//        var_dump($carList);die;
        return view('index/shoppindcart/shopping',['carList' => $carList]);
    }
}