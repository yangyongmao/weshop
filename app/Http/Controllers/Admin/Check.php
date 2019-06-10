<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/10
 * Time: 13:43
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class Check extends Controller
{

    public function __construct()
    {
        //验证登录
        $this->checkLogin();
    }

    private function checkLogin()
    {
        //检查Session文件是否存在 -> 用户是否登录
        $thisAdmin = Request::session()->get('thisAdmin');
        if(empty($thisAdmin)){
            return redirect("admin/login");
        }
    }

}