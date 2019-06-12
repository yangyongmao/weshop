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
Route::get('admin','Admin\IndexController@index');
//后台登录
Route::get('admin/login',"Admin\LoginController@login");
//管理员列表
Route::get('admin/list',"Admin\AdminController@list");
//管理员添加
Route::get('admin/add',"Admin\AdminController@add");
Route::get('admin/do_add',"Admin\AdminController@add");
//管理员删除
Route::get('admin/del',"Admin\AdminController@del");
//管理员修改
Route::get('admin/update',"Admin\AdminController@update");
//管理员是否启用
Route::get('admin/statuses',"Admin\AdminController@statuses");
//管理员搜索
//Route::get('admin/list',"Admin\AdminController@list");

