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

            //查询拥有的权限，URL路由数据
            $thisAdminAccess = DB::table('admin_role')
                ->where('admin_role.u_id','=',$thisAdmin->u_id)
                ->leftJoin('role',function ($query){
                    $query->on('admin_role.r_id','=','role.r_id');
                })
                ->leftJoin('role_node',function ($query){
                    $query->on('role.r_id','=','role_node.r_id');
                })
                ->leftJoin('node',function ($query){
                    $query->on('role_node.n_id','=','node.n_id');
                })
                ->leftJoin('menus',function ($query){
                    $query->on('node.n_name','=','menus.m_url');
                })
                ->select(DB::raw('
                    weshop_node.n_name,
                    weshop_menus.m_url,
                    weshop_menus.m_title
                '))
                ->get();

            //存储用户权限Session
//            $request->session()->put('adminAccess',$thisAdminAccess);

//            var_dump($thisAdminAccess);die();

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