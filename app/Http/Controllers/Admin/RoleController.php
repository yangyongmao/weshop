<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/12
 * Time: 19:08
 */

namespace  App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use DB;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function list(){
        $res = DB::table('role')->get();
        return view('admin/role/list',['res'=>$res]);
    }

    public function add(){
        echo 1;
    }


}