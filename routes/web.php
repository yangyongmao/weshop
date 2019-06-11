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

//后台主页
Route::get('admin','Admin\IndexController@index')->middleware('admin.login');

//后台登录
//Route::get('admin/login',"Admin\LoginController@login");

//中间件路由     重定向到登录界面
Route::get("admin/login","Admin\LoginController@login");
//后台登录功能
Route::post("admin/login","Admin\LoginController@login");