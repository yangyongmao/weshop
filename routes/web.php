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
//角色展示
Route::get('role/list',"Admin\RoleController@list");
//角色添加 post
Route::get('role/add',"Admin\RoleController@add");
//角色修改及权限的更改
Route::get('role/update',"Admin\RoleController@update");
//角色删除
Route::get('role/del',"Admin\RoleController@del");
//权限展示
Route::get('node/list',"Admin\NodeController@list");
//权限分类添加
Route::get('node/add',"Admin\NodeController@add");
//权限分类删除
Route::get('node/del',"Admin\NodeController@del");
//权限分类修改
Route::get('node/update',"Admin\NodeController@update");
//子权限展示
Route::get('do_node/list',"Admin\DonodeController@list");
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

