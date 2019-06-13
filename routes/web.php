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

/**
 * yangyongmao
 */
//商品展示
//Route::any('goods/index','Admin\GoodsController@index');

//商品详情页
Route::get('goods/goodsInfo','Admin\GoodsController@goodsInfo');
//商品批删
Route::get('goods/goodsDelAll','Admin\GoodsController@goodsDelAll');
//商品单删
Route::get('goods/goodsDelOne','Admin\GoodsController@goodsDelOne');
//商品修改上下架状态
Route::get('goods/goodsUpdSale','Admin\GoodsController@goodsUpdSale');
//商品修改
Route::post('goods/goodsUpdGoods','Admin\GoodsController@goodsUpdGoods');
//商品添加页面
Route::any('goods/goodsInsert','Admin\GoodsController@goodsInsert');

