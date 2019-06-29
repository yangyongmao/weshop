<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

class ShopcartController extends Controller
{

    public function ShopShow()
    {
            return view('index.shop.shopcart');
    }


}