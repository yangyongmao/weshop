<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/25
 * Time: 10:48
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GoodslistController extends Controller
{


    public function show()
    {
        /**
         * 接收筛选参数
         *  分类id
         *  品牌id
         */
        $cat_id = request()->get('cat_id');
        $brand_id = request()->get('brand_id');
        $sear_title = request()->get('sear_title');
        $sear_name = request()->get('sear_name');

        $goodsData1 = DB::table('goods')
            ->where([
                ['cat_id','=',$cat_id],
                ['brand_id','=',$brand_id],
                ['is_delete','=',2]
            ])
            ->where('goods_name','like',"%$sear_name%")
            ->select(DB::raw('goods_id,goods_name,goods_price,goods_img,LEFT(goods_desc,50) as goods_desc_short'))
            ->offset(0)
            ->limit(5)
            ->get();

        $goodsData2 = DB::table('goods')
            ->where([
                ['cat_id','=',$cat_id],
                ['brand_id','=',$brand_id],
                ['is_delete','=',2]
            ])
            ->where('goods_name','like',"%$sear_name%")
            ->select(DB::raw('goods_id,goods_name,goods_price,goods_img,LEFT(goods_desc,50) as goods_desc_short'))
            ->offset(5)
            ->limit(5)
            ->get();

        return view('index.goodslist.goodslist')->with([
            'sear_title' => $sear_title,
            'cat_id' => $cat_id,
            'brand_id' => $brand_id,
            'sear_name' => $sear_name,
            'goodsData1' => $goodsData1,
            'goodsData2' => $goodsData2,
        ]);
    }

    public function detail()
    {
        $goods_id = request()->get('goods_id');
        $goodsDetail = DB::table('goods')
            ->where('goods_id','=',$goods_id)
            ->first();

        return view('index.goodslist.detail')->with([
            'goodsDetail' => $goodsDetail,
        ]);
    }





}