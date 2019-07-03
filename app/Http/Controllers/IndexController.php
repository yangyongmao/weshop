<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/19
 * Time: 15:08
 */
namespace App\Http\Controllers;

//use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        $userinfo = request()->session()->get('thisUser');
        //轮播图信息

        $carousel = curl('http://weshop.io/api/Carousel','GET');
        $recommend = DB::table('goods')
            ->orderBy('goods_price','desc')
            ->limit(5 )->get();
        $purchase = DB::table('purchase')
            ->leftJoin('goods',function($join){
                $join->on('purchase.goods_id','=','goods.goods_id');
            })
            ->select('goods_img','goods_number','goods_name','goods_desc','goods_price','purchase.goods_id','purchase.new_money','purchase.start','purchase.end')
            ->get();
//        var_dump($purchase);die;

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

            'purchase'=>$purchase,

            'discount' => $discount,


        ]);
    }
    public function add(Request $request){
        $goods_id = $request->input("goods_id");
        $userinfo = request()->session()->get('thisUser');

        if($userinfo==null){
            return 1;
        }else{
            
            $data = DB::table('purchase')->where('goods_id',$goods_id)->select('new_money')->first();
//            var_dump($data);die;
            $money = $data->new_money;
            $arr = [
                'o_num' =>1,
                'o_total'=>$money,
                'o_price'=>$money,
                'o_status'=>1,
                'o_addtime'=>time(),
                'uid'=>$userinfo['data']['uid'],
            ];
            $res = DB::table('order')->insert($arr);
            $lastid = DB::getPdo()->lastInsertId();

            if($res){
                DB::table('ordergoods')->insert(['order_id'=>$lastid,'goods_id'=>$goods_id]);
                return 2;
            }else{
                return 3;
            }
        }
    }

}














