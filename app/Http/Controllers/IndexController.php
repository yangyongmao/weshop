<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/19
 * Time: 15:08
 */
namespace App\Http\Controllers;

class IndexController extends Controller
{

    public function index()
    {
        $userinfo = request()->session()->get('thisUser');
        var_dump($userinfo);

//        $userInfo = curl('http://weshop.io/api/demoshow','POST',['token']);


        return view('index.index.index')->with([
                'thisUser' => request()->session()->get('thisUser'),
        ]);
    }


}