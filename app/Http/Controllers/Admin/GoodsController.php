<?php
/**
 * Created by PhpStorm.
 * User: 杨永茂
 * Date: 2019/6/11
 * Time: 14:24
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $wheres = !empty($keyword) ? $keyword : '';

        $goodsList = Db::table('goods')->join('cat', 'cat.cat_id', '=', 'goods.cat_id')
            ->join('brand', 'brand.brand_id', '=', 'goods.brand_id')
            ->where('goods.is_delete', '=', '2')
            ->where(function ($query) use ($wheres) {
                $query->where('goods.goods_name', 'like', "%$wheres%")
                    ->orWhere('cat.cat_name', 'like', "%$wheres%")
                    ->orWhere('brand.brand_name', 'like', "%$wheres%");
            })->select('goods.goods_id', 'goods.goods_sn', 'goods.goods_name', 'goods.goods_number', 'goods.is_on_sale', 'cat.cat_name', 'brand.brand_name')
            ->paginate(15);

        return view('admin\goods.index', ['goodsList' => $goodsList]);
    }

    public function goodsInfo(Request $request)
    {
        $goods_id = $request->input('goods_id');

        $catList = Db::table('cat')->select('cat_name', 'cat_id','pid')->get();

        $catList = getTree($catList);

        $brandList = Db::table('brand')->select('brand_id', 'brand_name')->get();

        $goodsList = Db::table('goods')->join('cat', 'cat.cat_id', '=', 'goods.cat_id')
            ->join('brand', 'brand.brand_id', '=', 'goods.brand_id')
            ->where('goods.goods_id', '=', "$goods_id")
            ->select('goods.*', 'cat.cat_name','cat.cat_id', 'brand.brand_id', 'brand.brand_name')
            ->first();

        return view('admin\goods.goodsInfo', ['goodsList' => $goodsList, 'catList'=>$catList, 'brandList'=>$brandList]);
    }

    public function goodsUpdGoods(Request $request)
    {
        $updData = $request->input();

        $goods_id = $updData['goods_id'];

        unset($updData['_token']);

        unset($updData['goods_id']);

        $res = DB::table('goods')->where('goods_id', $goods_id)->update($updData);

        if($res){
            return view('jump')->with([
                //跳转信息
                'message'=>'修改成功，正在跳转!',
                //自己的跳转路径
                'url' =>'/goods/index',
                //跳转路径名称
                'urlname' =>'商品列表',
                //跳转等待时间（s）
                'jumpTime'=>2,
            ]);
        }else{
            return view('jump')->with([
                //跳转信息
                'message'=>'修改失败!',
                //自己的跳转路径
                'url' =>'/goods/index',
                //跳转路径名称
                'urlname' =>'商品列表',
                //跳转等待时间（s）
                'jumpTime'=>2,
            ]);
        }
    }

    public function goodsDelAll(Request $request)
    {
        $ids = $request->input('ids');

        $res = Db::table('goods')->whereIn('goods_id', $ids)->update(['is_delete' => 1]);

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }
    }

    public function goodsDelOne(Request $request)
    {
        $id = $request->input('id');

        $res = Db::table('goods')->where('goods_id', $id)->update(['is_delete' => 1]);

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }

    }

    public function goodsUpdSale(Request $request)
    {
        $id = $request->input('id');

        $code = $request->input('code');

        if( $code == 1 ){
            $res = Db::table('goods')->where('goods_id', $id)->update(['is_on_sale' => 2]);
        }else{
            $res = Db::table('goods')->where('goods_id', $id)->update(['is_on_sale' => 1]);
        }

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }
    }

    public function goodsInsert()
    {
        $catList = Db::table('cat')->select('cat_name', 'cat_id','pid')->get();

        $catList = getTree($catList);

        $brandList = Db::table('brand')->select('brand_id', 'brand_name')->get();

        return view('admin\goods.goodsInsert', [ 'catList'=>$catList, 'brandList'=>$brandList ]);
    }

    public function doInsert(Request $request)
    {
        $postData = $request->input();

        echo "<pre>";
        var_dump($postData);
    }


}