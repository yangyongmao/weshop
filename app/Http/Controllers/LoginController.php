<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;
use Mews\Captcha\Facades\Captcha;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login()
    {
        if (request()->getMethod() == 'POST') {
            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
                return json_encode(
                    [
                        'errorCode' => 500,
                        'errorMsg' => '<p style="color: #ff0000;">验证码有误!</p>'
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                $data = [
                    'uname' => request()->post('uname'),
                    'upwd' => request()->post('upwd'),
                ];
                /**
                 * 调用公共函数CURL
                 */
                $apiMsg = curl('http://weshop.io/api/login','POST',$data);
                $apiMsg_array = json_decode($apiMsg,true);
                if(!empty($apiMsg_array['data'])){
                    request()->session()->put("thisUser",$apiMsg_array['data']);
                }
                $this->updateSessionCar();
                return $apiMsg;
            }
        }else{
            return view('index.login.login');
        }
    }

    public function loginout()
    {
        request()->session()->forget('thisUser');
        return redirect('/');
    }

    //更新session购物车
    public function updateSessionCar()
    {
        $u_id = request()->session()->get('thisUser')['data']['uid'];

        $sessionGoodsId = substr(request()->session()->get('shopcar'),0,-1);
        //若session购物车为空  直接返回
        if(!$sessionGoodsId){return "NULL";}
        $sessionGoodsId = explode(',',$sessionGoodsId);

        /**
         * 数组的 key是goods_id val是session中这个商品的数量
         */
        $sessionGoodsId = array_count_values($sessionGoodsId);

        foreach($sessionGoodsId as $k => $v){
            //检查当前数据是否存在数据表中
            $thisGoodsInDb = DB::table('shoppingcar')
                ->where([
                    'uid' => $u_id,
                    'goods_id' => $k,
                    'status' => 1
                ])
                ->first('carid');

            //若存在
            if(!empty($thisGoodsInDb)){
                DB::table('shoppingcar')
                    ->where([
                        'uid' => $u_id,
                        'goods_id' => $k,
                    ])
                    ->increment('num',$v);
            }else{
                DB::table('shoppingcar')->insert([
                    'uid' => $u_id,
                    'goods_id' => $k,
                    'num' => $v
                ]);
            }
        }
        //清除session购物车
        request()->session()->forget('shopcar');
    }

}