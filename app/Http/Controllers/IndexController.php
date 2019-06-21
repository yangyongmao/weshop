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
        return view('index.index.index');
    }


}