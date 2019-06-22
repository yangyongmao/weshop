<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 10:28
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        if($request->isMethod('GET')){
            return view('index.login.login');
        }
    }



}