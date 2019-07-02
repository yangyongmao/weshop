<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/7/2
 * Time: 11:43
 */
namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class PurchaseController extends Controller
{

    public function list()
    {
        $data = DB::table('purchase')
            ->leftJoin('goods',function($join){
                $join->on('purchase.goods_id','=','goods.goods_id');
            })
            ->where('goods.is_hot',2)
            ->select('goods.goods_name','purchase.new_money','goods.goods_price','purchase.start','purchase.end','purchase.id')
            ->get();
//        var_dump($res);die;
        return view('admin/purchase/list',['data'=>$data]);
    }
    public function add(Request $request){
        if($request->ajax()){
            $data = $request->input();
            $res = DB::table('purchase')->where('goods_id',$data['goods_id'])->select('end')->first();

            if($res!=null){
                $end = $res->end;
                if( $end > time()) {
                    return 3;//此商品的活动正在进行中
                }else if($end < time()){
                    $start = is_int($data['start'] ) ? $data['start']  : strtotime($data['start'] );
                    $end = is_int($data['end']) ? $data['end'] : strtotime($data['end']) + 24*60*60;
                    $arr = [
                        'start' =>$start,
                        'end' =>$end,
                        'new_money'=>$data['new_money'],
                    ];
                    $res = DB::table('purchase')->where('goods_id',$data['goods_id'])->update($arr);
                    if($res){
                        return 1;
                    }else{
                        return 2;
                    }
                }
            }else{
                $start = is_int($data['start'] ) ? $data['start']  : strtotime($data['start'] );
                $end = is_int($data['end']) ? $data['end'] : strtotime($data['end']) + 24*60*60;
                $arr = [
                    'goods_id' =>$data['goods_id'],
                    'start' =>$start,
                    'end' =>$end,
                    'new_money'=>$data['new_money'],
                ];
                $res = DB::table('purchase')->insert($arr);
                if($res){
                    DB::table('goods')->where('goods_id',$data['goods_id'])->update(['is_hot'=>2]);
                    return 1;
                }else{
                    return 2;
                }
            }
        }else{
            $data = DB::table('goods')->select('goods_name','goods_id','goods_price')->get();
            return view('admin/purchase/add',['data'=>$data]);
        }
    }
}