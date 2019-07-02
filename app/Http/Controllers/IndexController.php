<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/19
 * Time: 15:08
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{

    public function index()
    {
        $userinfo = request()->session()->get('thisUser');
        //轮播图信息
        $carousel = curl('http://weshop.io/api/Car0ousel','GET');

        $recommend = DB::table('goods')->orderBy('goods_price','desc')->limit(5 )->select('goods_img','goods_name','goods_desc','goods_price','goods_id')->get();


        $catGoods = Db::table('cat')
                    ->leftJoin('goods', 'cat.cat_id', '=', 'goods.cat_id')
                    ->where('cat.is_show', 1)
                    ->where('goods.is_delete', 2)
                    ->select('cat.cat_id', 'cat.cat_name', 'goods.goods_id', 'goods.goods_name', 'goods.goods_img')->get();
        $catGoods = getData($catGoods);

        //优惠券信息
        $discount = DB::table('discount')
            ->where('status','=',1)
            ->where('end','>',time())
            ->limit(4)
            ->get();


        return view('index.index.index')->with([
            'carousel' => $carousel,
            'thisUser' => $userinfo['data'],
            'sear_name' => '',
            'cat_id' => 1,
            'brand_id' => 1,
            'sear_title' => '小米手机',
            'recommend' => $recommend,
            'catGoods' => $catGoods,
            'discount' => $discount,

        ]);
    }

}