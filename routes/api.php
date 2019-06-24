<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//登录
Route::post('login',"Api\LoginController@login");
//重置
Route::post('reset',"Api\LoginController@reset");
//注册
Route::post('register',"Api\LoginController@register");
//轮播图
Route::get('Carousel',"Api\HomeController@Carousel");
//个人展示
Route::post('demoshow',"Api\PersonalController@show")->Middleware('token');
//个人信息修改
Route::post('demoupdate',"Api\PersonalController@update")->Middleware('token');
//我的订单
Route::post('demorder',"Api\PersonalController@order")->Middleware('token');