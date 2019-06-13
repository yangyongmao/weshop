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
//后台首页
Route::get("admin/welcome","Admin\IndexController@welcome")->middleware('admin.login');
//后台主页
Route::get('admin','Admin\IndexController@index');
//后台登录

/**
 * 李新元
 */
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

/**
 * Jiaxinchen
 */
Route::get('admin','Admin\IndexController@index')->middleware('admin.login');
//登录界面
Route::get("admin/login","Admin\LoginController@login");
//后台登录功能
Route::post("admin/login","Admin\LoginController@login");
//后台退出（注销）
Route::get("admin/loginout","Admin\LoginController@loginOut");
//后台添加菜单
Route::get("admin/addmenus","Admin\MenusController@add")->middleware('admin.login');
//后台添加菜单执行
Route::post("admin/addmenus","Admin\MenusController@add");
//后台菜单展示
Route::get("admin/showmenus","Admin\MenusController@show");
//菜单展示 条件查询提交
Route::post("admin/showmenus","Admin\MenusController@show");
//删除菜单
Route::get("admin/deletemenus","Admin\MenusController@delete");
//商品评论审核
Route::get("admin/showcomments","Admin\CommentsController@show")->middleware('admin.login');
Route::post("admin/showcomments","Admin\CommentsController@show")->middleware('admin.login');
//删除评论
Route::get('admin/deletecomments',"Admin\CommentsController@delete")->middleware('admin.login');

/**
 * 曹跃峰
 */
Route::any('admin/orderList',"Admin\OrderController@orderList");
Route::any('admin/orderDel',"Admin\OrderController@orderDel");
Route::any('admin/orderDelall',"Admin\OrderController@orderDelall");
Route::any('admin/orderDesc',"Admin\OrderController@orderDesc");
//用户意见
Route::any("admin/opinionList","Admin\OpinionController@opinionList");