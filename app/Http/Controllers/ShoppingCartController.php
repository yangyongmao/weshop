<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function shopping()
    {
        $session = request()->session()->get('thisUser');
        $uid = $session['data']['uid'];

        if(!empty($session)){
            $carList = Db::table('shoppingcar')
                ->leftJoin('goods','shoppingcar.goods_id','=','goods.goods_id')
                ->where('uid','=',"$uid")
                ->where('shoppingcar.status','=',1)
                ->get();

            $count = 0;
            foreach ($carList as $v){
                $count += $v->num;
            }

            return view('index/shoppindcart/shopping',[
                'carList' => $carList , 'count' => $count ,'thisUser' => $session['data']
            ]);

        }else{

            //用户未登录，查询session购物车
            $goodsId = substr(request()->session()->get('shopcar'),0,-1);
            if(!$goodsId){
                return view('index/shoppindcart/shopping',[
                    'carList' => [] , 'count' => 0 ,'thisUser' => [],
                ]);
            }

            $goodsId = explode(',',$goodsId);
            $goodsId = array_count_values($goodsId);

            foreach ($goodsId as $k => $v){
                    $carList[$k] = DB::table('goods')
                        ->where(['goods_id' => $k])
                        ->first();
                    $carList[$k]->num = $v;
                    $carList[$k]->carid = '#';

            }

            return view('index/shoppindcart/shopping',[
                'carList' => $carList , 'count' => count($goodsId) ,'thisUser' => [],
            ]);

        }


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

    public function addgood()
    {
        if(request()->ajax()){
            $thisUser = request()->session()->get('thisUser');
            $newGoodsId = request()->get('goods_id');

            //用户未登录将数据存储在session中
            if(empty($thisUser)){
                //获取旧的session购物车数据
                $oldShopcar = request()->session()->get('shopcar');
                request()->session()->put('shopcar',$oldShopcar . $newGoodsId.',');

                return response()->json([
                    'errorCode' => '200',
                    'errorMsg' => '添加购物车成功',
                    'data' => 'session存储'
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }else{
                $u_id = request()->session()->get('thisUser')['data']['uid'];
                //防止数据表重复
                $thisGoodsincar = DB::table('shoppingcar')
                    ->where([
                        'uid' => $u_id,
                        'goods_id' => $newGoodsId,
                    ])
                    ->first('carid');

                if(!empty($thisGoodsincar)){
                    DB::table('shoppingcar')
                        ->where([
                            'uid' => $u_id,
                            'goods_id' => $newGoodsId,
                        ])
                        ->increment('num',1);
                }else{
                    DB::table('shoppingcar')->insert([
                        'uid' => $u_id,
                        'goods_id' => $newGoodsId,
                        'num' => 1
                    ]);
                }

                return response()->json([
                    'errorCode' => '200',
                    'errorMsg' => '添加购物车成功',
                    'data' => 'Db存储'
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }

        }
    }


}