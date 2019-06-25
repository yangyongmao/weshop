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

        $goodsData1 = DB::table('goods')
            ->where([
                ['cat_id','=',$cat_id],
                ['brand_id','=',$brand_id],
                ['is_delete','=',2]
            ])
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
            ->select(DB::raw('goods_id,goods_name,goods_price,goods_img,LEFT(goods_desc,50) as goods_desc_short'))
            ->offset(5)
            ->limit(5)
            ->get();

//        var_dump($goodsData);die();

        return view('index.goodslist.goodslist')->with([
            'sear_title' => $sear_title,
            'goodsData1' => $goodsData1,
            'goodsData2' => $goodsData2,
        ]);

    }





}