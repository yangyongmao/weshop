<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin','Admin\IndexController@index');

//后台主页
Route::get('admin','Admin\IndexController@index');
//后台登录
Route::get('admin/login',"Admin\LoginController@login");

//商品展示
Route::any('goods/index','Admin\GoodsController@index');

//商品详情页
Route::get('goods/goodsInfo','Admin\GoodsController@goodsInfo');

//商品批删
Route::get('goods/goodsDelAll','Admin\GoodsController@goodsDelAll');

//商品单删
Route::get('goods/goodsDelOne','Admin\GoodsController@goodsDelOne');

//商品修改上下架状态
Route::get('goods/goodsUpdSale','Admin\GoodsController@goodsUpdSale');

//商品添加页面
Route::any('1','Admin\GoodsController@goodsInsert');

