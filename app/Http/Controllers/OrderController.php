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

    public function list(){
        $data = DB::table('order')
            ->get();
        return view('index.order.list');
    }

    public function inputorder()
    {
        if(\request()->ajax()){
            $u_id = \request()->session()->get('thisUser')['data']['uid'];

            //接收提交的订单中包含的购物车数据id
            //接收提交订单中包含商品的id和数量
            $carid = \request()->get('carid');
            $data = \request()->get('data');

            DB::beginTransaction();

            /**
             * 添加订单->计算必要字段值
             *          订单编号 num
             *          商品总数 total
             *          总价格    price
             *          添加时间 addtime
             *          用户id     uid
             */
            $num = 'Ord' . time() . 'U' . $u_id;
            $total = array_sum(array_column($data,'goods_num'));
            $price = array_sum(array_column($data,'goods_price'));

            $res = DB::table('order')->insert([
                'o_num' => $num,
                'o_total' => $total,
                'o_price' => $price,
                'o_addtime' => time(),
                'uid' => $u_id,
            ]);
            if(!$res){
                DB::rollBack();
                return response()->json([
                    'errorCode' => 201,
                    'errorMsg' => '提交失败',
                    'data' => [],
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }

            $orderLastId = DB::getPdo()->lastInsertId();

            /**
             * 添加订单商品 ->计算必要字段值
             *             订单id  order_id
             *             商品id  goods_id
             *             商品数量 goods_num
             */
            foreach ($data as $k => $v){
                $data[$k]['order_id'] = $orderLastId;
            }

            $res = DB::table('ordergoods')->insert($data);
            if(!$res){
                DB::rollBack();
                return response()->json([
                    'errorCode' => 202,
                    'errorMsg' => '提交失败',
                    'data' => []
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }

            /**
             * 更新购物车 数据状态
             */
            $res = DB::table('shoppingcar')
                ->whereIn('carid',$carid)
                ->update([
                    'status' => 2
                ]);

            if(!$res){
                DB::rollBack();
                return response()->json([
                    'errorCode' => 203,
                    'errorMsg' => '提交失败',
                    'data' => []
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }else{
                DB::commit();
                return response()->json([
                    'errorCode' => 200,
                    'errorMsg' => '提交成功',
                    'data' => ['order_id' => $orderLastId]
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }


        }
    }

}