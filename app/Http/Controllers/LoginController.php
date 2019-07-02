<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;
use Mews\Captcha\Facades\Captcha;

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


}