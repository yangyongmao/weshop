<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/10
 * Time: 11:21
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;

class IndexController extends Check
{
    public function index(){
        return view("admin\index\\index");
    }
}