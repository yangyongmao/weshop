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


/**
 * 主页
 */
Route::get("admin/welcome","Admin\IndexController@welcome");


/**
 * lixinyuan
 */
//管理员列表
Route::get('admin/list',"Admin\AdminController@list")->middleware('check.module');
//管理员添加
Route::get('admin/add',"Admin\AdminController@add")->middleware('check.module');
//管理员删除
Route::get('admin/del',"Admin\AdminController@del")->middleware('check.module');
//管理员修改
Route::get('admin/update',"Admin\AdminController@update")->middleware('check.module');
//管理员是否启用
Route::get('admin/statuses',"Admin\AdminController@statuses")->middleware('check.module');

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
Route::get("admin/addmenus","Admin\MenusController@add")->middleware('admin.login')->middleware('check.module');
//后台添加菜单执行
Route::post("admin/addmenus","Admin\MenusController@add")->middleware('check.module');
//后台菜单展示
Route::get("admin/showmenus","Admin\MenusController@show")->middleware('check.module');
//菜单展示 条件查询提交
Route::post("admin/showmenus","Admin\MenusController@show")->middleware('check.module');
//删除菜单
Route::get("admin/deletemenus","Admin\MenusController@delete")->middleware('check.module');
//商品评论审核 展示
Route::get("admin/showcomments","Admin\CommentsController@show")->middleware('admin.login')->middleware('check.module');
Route::post("admin/showcomments","Admin\CommentsController@show")->middleware('admin.login')->middleware('check.module');
//删除商品的评论
Route::get('admin/deletecomments',"Admin\CommentsController@delete")->middleware('admin.login')->middleware('check.module');
//回复商品的评论
Route::get("admin/replycomm","Admin\CommentsController@reply")->middleware('admin.login')->middleware('check.module');
Route::post("admin/replycomm","Admin\CommentsController@reply")->middleware('admin.login')->middleware('check.module');
//查询商品分类
Route::get("admin/showcate","Admin\CateController@show")->middleware("admin.login")->middleware('check.module');
//添加商品分类
Route::get("admin/addcate","Admin\CateController@add")->middleware("admin.login")->middleware('check.module');
Route::post("admin/addcate","Admin\CateController@add")->middleware("admin.login")->middleware('check.module');
//删除商品分类
Route::get("admin/deletecate","Admin\CateController@delete")->middleware("admin.login")->middleware('check.module');



/**
 * yangyongmao
 */

//商品详情页
Route::get('goods/goodsInfo', 'Admin\GoodsController@goodsInfo')->middleware('check.module');
//商品批删
Route::get('goods/goodsDelAll', 'Admin\GoodsController@goodsDelAll')->middleware('check.module');
//商品单删
Route::get('goods/goodsDelOne', 'Admin\GoodsController@goodsDelOne')->middleware('check.module');
//商品修改上下架状态
Route::get('goods/goodsUpdSale', 'Admin\GoodsController@goodsUpdSale')->middleware('check.module');
//商品修改
Route::post('goods/goodsUpdGoods', 'Admin\GoodsController@goodsUpdGoods')->middleware('check.module');
//商品添加页面
Route::any('goods/goodsInsert', 'Admin\GoodsController@goodsInsert')->middleware('check.module');
//执行添加
Route::any('goods/doInsert', 'Admin\GoodsController@doInsert')->middleware('check.module');
//商品展示
Route::any('goods/index','Admin\GoodsController@index')->middleware('check.module');


/**
 * caoyuefeng
 */
Route::any('admin/orderList',"Admin\OrderController@orderList")->middleware('check.module');
Route::any('admin/orderDelall',"Admin\OrderController@orderDelall")->middleware('check.module');
Route::any('admin/orderDesc',"Admin\OrderController@orderDesc")->middleware('check.module');

Route::any('admin/opinionDelall',"Admin\OpinionController@opinionDelall")->middleware('check.module');
Route::any('admin/opinionDesc','Admin\OpinionController@opinionDesc')->middleware('check.module');

Route::any('admin/isokAll','Admin\OpinionController@isokAll')->middleware('check.module');
//用户意见
Route::any("admin/opinionList","Admin\OpinionController@opinionList")->middleware('check.module');

