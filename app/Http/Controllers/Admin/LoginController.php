<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/10
 * Time: 13:42
 */
namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        if($request->isMethod("GET")){
            return view('Admin.login.login');
        }else{
            $loginData = $request->post();

            $thisAdmin = DB::table('admin')
                ->where([
                    ['u_account',   '=',    $loginData['u_account']],
                    ['u_pwd',   '=',    md5($loginData['u_pwd'])],

                    ['status','=',0],
                ])
                ->first();

            if(!empty($thisAdmin)){
                $request->session()->put("thisAdmin",$thisAdmin);
                return json_encode(
                    [
                        'errorCode' => 200,
                        'errorMsg' => '登录成功',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }else{

                return json_encode(
                    [
                        'errorCode' => 404,
                        'errorMsg' => '未发现此用户',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }

        }
    }

    public function loginOut(Request $request)
    {
        $request->session()->forget("thisAdmin");
        return redirect('admin/login');
    }



}