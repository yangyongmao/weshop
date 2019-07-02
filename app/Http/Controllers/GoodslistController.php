<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/25
 * Time: 10:48
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
//use think\Request;
use Illuminate\Http\Request;
class GoodslistController extends Controller
{


    public function show()
    {
        /**
         * 接收筛选参数
         *  分类id
         *  品牌id
         */
        $cat_id = request()->get('cat_id',1);
        $brand_id = request()->get('brand_id',1);
        $sear_title = request()->get('sear_title','小米手机');
        $sear_name = request()->get('sear_name','');

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
            'thisUser' => request()->session()->get('thisUser')['data'],
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
            'thisUser' => request()->session()->get('thisUser')['data'],
            'goodsDetail' => $goodsDetail,
        ]);
    }

    public function searlist()
    {
        $searValue = request()->get('sear_name');
        $goodsData1 = DB::table('goods')
            ->where([
                ['is_delete','=',2]
            ])
            ->where('goods_name','like',"%$searValue%")
            ->select(DB::raw('goods_id,goods_name,goods_price,goods_img,LEFT(goods_desc,50) as goods_desc_short'))
            ->offset(0)
            ->limit(5)
            ->get();

        $goodsData2 = DB::table('goods')
            ->where([
                ['is_delete','=',2]
            ])
            ->where('goods_name','like',"%$searValue%")
            ->select(DB::raw('goods_id,goods_name,goods_price,goods_img,LEFT(goods_desc,50) as goods_desc_short'))
            ->offset(5)
            ->limit(5)
            ->get();

        return view('index.goodslist.seargoodslist')->with([
            'goodsData1' => $goodsData1,
            'goodsData2' => $goodsData2,
            'searValue' => $searValue,
        ]);
    }

    public function collect(Request $request)
    {
        $goods_id = $request->get('goods_id');

        $userinfo = $request->session()->get('thisUser');

        $uid = $userinfo['data']['uid'];

        $ishave = Db::table('collection')->where('user_id', '=', $uid)->where('goods_id', '=', $goods_id)->first();

        if($ishave){
            return json_encode(['code'=>'2', 'msg'=>'已经收藏了!'], true);
        }else{
            $goods_img= $request->get('goods_img');

            $addtime = date('Y-m-d h:i:s',time());

            $res = Db::table('collection')->insert([
                'user_id' => $uid,
                'goods_id'=> $goods_id,
                'goods_img' => $goods_img,
                'addtime' => $addtime
            ]);

            if($res){
                return json_encode(['code'=>'1','msg'=>'收藏成功'], true);
            }else{
                return json_encode(['code'=>'3','msg'=>'错误'], true);
            }
        }

    }

    public function delcollect(Request $request)
    {

        $collecid = $request->get('collecid');

        $res = Db::table('collection')
            ->where('id', '=', $collecid)->delete();

        if($res){
            return json_encode(['code'=>1, 'msg'=>'取消成功']);
        }else{
            return json_encode(['code'=>2, 'msg'=>'错误']);
        }
    }

}