<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/21
 * Time: 14:18
 */
namespace App\Http\Controllers;

class RegisterController extends Controller
{

    public function register()
    {
        if(request()->getMethod() == 'POST'){
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
            }else{
                $registerData = request()->post();
                unset($registerData['_token']);unset($registerData['captcha']);

                $msg = curl('http://weshop.io/api/register','POST',$registerData);
                return $msg;
            }
        }else{
            return view('index.register.register');
        }
    }



}