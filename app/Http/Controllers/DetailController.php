<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

class DetailController extends Controller
{

    public function DetailShow()
    {
            return view('index.detail.goodetail');
    }


}