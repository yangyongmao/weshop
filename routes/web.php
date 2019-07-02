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
 * ====================
 * =======前台路由========
 * ====================
 */

/**
 * jiaxinchen
 */
Route::middleware([
    'index.login'
])->group(function (){
    //个人中心
    Route::get('me','PersonController@InfoShow');
    //优惠券信息
    Route::get('discount','PersonController@discount');
    //编辑我的资料
    Route::any('updatemyself','PersonController@updatemyself');
    //收藏商品
    Route::get('collection','PersonController@collection');
    //领取优惠券
    Route::get('getdiscount','PersonController@getdiscount');

});
//前台主页
Route::get("","IndexController@index");
//前台登录页面跳转
Route::any("login","LoginController@login");
//前台注销
Route::get('loginout','LoginController@loginout');
//注册功能
Route::any('register','RegisterController@register');
//前台商品列表
Route::get('goodslist','GoodslistController@show');
//商品详情页
Route::get('goodsdetail','GoodslistController@detail');
//请求地址数据
Route::get('getaddr','AddrController@getdata');
//搜索商品
Route::get('seargoodslist','GoodslistController@searlist');
//收藏
Route::get('addcollect','GoodslistController@collect');
//取消收藏
Route::get('delcollect','GoodslistController@delcollect');













/**
 * ====================
 * =======后台路由========
 * ====================
 */

/**
 * lixinyuan的路由组
 */
Route::middleware([
    'admin.login',
    'check.module',
])->group(function (){
    //管理员列表
    Route::get('admin/list',"Admin\AdminController@list");
    //管理员添加
    Route::get('admin/add',"Admin\AdminController@add");
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
    //子权限添加
    Route::get('do_node/add',"Admin\DonodeController@add");
    //子权限删除
    Route::get('do_node/del',"Admin\DonodeController@del");
    //子权限修改
    Route::get('do_node/update',"Admin\DonodeController@update");
    //活动管理

});
Route::get('discount/list',"Admin\DiscountController@list");
Route::get('discount/add',"Admin\DiscountController@add");
Route::get('discount/del',"Admin\DiscountController@delete");
Route::get('discount/update',"Admin\DiscountController@update");
/**
 * Jiaxinchen的路由组
 */
Route::middleware([
    'admin.login',
    'check.module',
])->group(function (){
    //后台添加菜单
    Route::get("admin/addmenus","Admin\MenusController@add");
//后台添加菜单执行
    Route::post("admin/addmenus","Admin\MenusController@add");
//后台菜单展示
    Route::get("admin/showmenus","Admin\MenusController@show");
//删除菜单
    Route::get("admin/deletemenus","Admin\MenusController@delete");
    //菜单展示 条件查询提交
    Route::post("admin/showmenus","Admin\MenusController@show");
//删除菜单
    Route::get("admin/deletemenus","Admin\MenusController@delete");
//商品评论审核 展示
    Route::get("admin/showcomments","Admin\CommentsController@show");
    Route::post("admin/showcomments","Admin\CommentsController@show");
//删除商品的评论
    Route::get('admin/deletecomments',"Admin\CommentsController@delete");
//回复商品的评论
    Route::get("admin/replycomm","Admin\CommentsController@reply");
    Route::post("admin/replycomm","Admin\CommentsController@reply");
//查询商品分类
    Route::get("admin/showcate","Admin\CateController@show");
//添加商品分类
    Route::get("admin/addcate","Admin\CateController@add");
    Route::post("admin/addcate","Admin\CateController@add");
//删除商品分类
    Route::get("admin/deletecate","Admin\CateController@delete");
//给分类添加规格
    Route::get("admin/addstandard","Admin\StandardController@addStandard");
//执行添加规格
    Route::post("admin/addstandard","Admin\StandardController@addStandard");
//查看分类拥有的规格
    Route::get("admin/showcatstandard","Admin\StandardController@show");
//商品规格展示表
    Route::get("admin/showstandard","Admin\StandardController@selfList");
//查看规格的子Value
    Route::get("admin/showstandardvalue","Admin\StandardController@value");
//添加规格子value
    Route::get("admin/addstandardvalue","Admin\StandardController@addChildValue");
    Route::post("admin/addstandardvalue","Admin\StandardController@addChildValue");
    //生成SKU
    Route::any('admin/sku','Admin\GoodsController@sku');
});

Route::middleware([
    'admin.login',
])->group(function (){
//后台主页
    Route::get("admin","Admin\IndexController@index");
//后台主页欢迎
    Route::get("admin/welcome","Admin\IndexController@welcome");
//后台退出（注销）
    Route::get("admin/loginout","Admin\LoginController@loginOut");
});
//登录界面
Route::get("admin/login","Admin\LoginController@login");
//后台登录功能
Route::post("admin/login","Admin\LoginController@login");



/**
 * yangyongmao的路由组
 */
Route::middleware([
    'admin.login',
    'check.module'
])->group(function (){
    //商品详情页
    Route::get('goods/goodsInfo', 'Admin\GoodsController@goodsInfo');
//商品批删
    Route::get('goods/goodsDelAll', 'Admin\GoodsController@goodsDelAll');
//商品单删
    Route::get('goods/goodsDelOne', 'Admin\GoodsController@goodsDelOne');
//商品修改上下架状态
    Route::get('goods/goodsUpdSale', 'Admin\GoodsController@goodsUpdSale');

//商品详情页
    Route::get('goods/goodsInfo', 'Admin\GoodsController@goodsInfo');

//商品修改
    Route::post('goods/goodsUpdGoods', 'Admin\GoodsController@goodsUpdGoods');
//商品添加页面

    Route::any('goods/goodsInsert', 'Admin\GoodsController@goodsInsert');
//执行添加
    Route::any('goods/doInsert', 'Admin\GoodsController@doInsert');
//商品展示
    Route::any('goods/index','Admin\GoodsController@index');

    Route::any('goods/goodsInsert', 'Admin\GoodsController@goodsInsert');
//商品执行添加
    Route::any('goods/doInsert', 'Admin\GoodsController@doInsert');
//商品展示
    Route::any('goods/index','Admin\GoodsController@index');
//商品批删
    Route::get('goods/goodsDelAll','Admin\GoodsController@goodsDelAll');
//商品单删
    Route::get('goods/goodsDelOne','Admin\GoodsController@goodsDelOne');
//商品修改上下架状态
    Route::get('goods/goodsUpdSale','Admin\GoodsController@goodsUpdSale');

//分类添加属性
    Route::any('/attribute/attrInsert', 'Admin\AttributeController@attrInsert');
//分类 属性 列表
    Route::get('/attribute/catAttr', 'Admin\AttributeController@catAttr');
//分类 属性 批删
    Route::get('/attribute/attrDelAll', 'Admin\AttributeController@attrDelAll');
//分类 属性 单删
    Route::get('/attribute/attrDelOne', 'Admin\AttributeController@attrDelOne');
//分类 属性 修改
    Route::get('/attribute/attrUpd', 'Admin\AttributeController@attrUpd');
//所有属性列表
    Route::any('/attr/attrList', 'Admin\AttrController@attrList');
//添加属性页面
    Route::any('/attr/addAttr', 'Admin\AttrController@addAttr');
//添加属性值页面
    Route::get('/attr/addOption', 'Admin\AttrController@addOption');
//执行添加属性值
    Route::post('/attr/doAddOption', 'Admin\AttrController@doAddOption');
//属性值列表
    Route::get('/attr/optionList', 'Admin\AttrController@optionList');

});



/**
 * caoyuefeng的属性组
 */
Route::middleware([
    'admin.login',
    'check.module'
])->group(function (){
    //订单
    Route::any('admin/orderDel',"Admin\OrderController@orderDel");
    Route::any('admin/orderList',"Admin\OrderController@orderList");
    Route::any('admin/orderDelall',"Admin\OrderController@orderDelall");
    Route::any('admin/orderDesc',"Admin\OrderController@orderDesc");
    //用户意见
    Route::any('admin/opinionDelall',"Admin\OpinionController@opinionDelall");
    Route::any('admin/opinionDesc','Admin\OpinionController@opinionDesc');
    Route::any('admin/isokAll','Admin\OpinionController@isokAll');
    Route::any("admin/opinionList","Admin\OpinionController@opinionList");
});


/**
 * renfuxiang的属性组
 */
Route::middleware([
    'admin.login',
    'check.module'
])->group(function (){
    //品牌展示
    Route::any("admin/brandmenus","Admin\BrandController@show");
//添加品牌
    Route::any("admin/brandadd","Admin\BrandController@add");
//品牌删除
    Route::any("admin/brandelete","Admin\BrandController@delete");
//品牌展示
    Route::any("admin/brandallow","Admin\BrandController@allow");
});
Route::any('shopping','Auth\ShoppingCartController@shopping');
Route::any('shopcar/cardel','Auth\ShoppingCartController@cardel');
Route::any('shocar/carchange','Auth\ShoppingCartController@carchange');