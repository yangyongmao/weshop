<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orderList()
    {
        $start = isset($_GET['start'])&&!empty($_GET['start'])?strtotime($_GET['start']):25200;
        $end = isset($_GET['end'])&&!empty($_GET['end'])?strtotime($_GET['end']):time()+60*60*24;
        $contrller = isset($_GET['contrller'])&&!empty($_GET['contrller'])?[$_GET['contrller']]:[1,2,3,4,5,6];
        $username = isset($_GET['username'])&&!empty($_GET['username'])?$_GET['username']:'';
        $between = [$start,$end];
        $orderList = Db::table('order')
                        ->join('status','order.o_status','=','status.s_id',"")
                        ->join('address','order.o_id','=','address.a_id',"")
                        ->whereBetween('order.o_addtime',$between)
                        ->whereIn('order.o_status',$contrller)
                        ->where('order.o_num','like',"%$username%")
                        ->orderBy('order.o_addtime','desc')
                        ->select()
                        ->paginate(15);

//        echo "<pre>";
//        var_dump($orderList);die;

        $statusList = Db::table('status')->select()->get();
        return view('admin/order/order',['orderList' => $orderList ,'statusList' => $statusList]);
    }
    public function orderDel()
    {
        $o_id = $_GET['id'];
        $res = Db::table('order')->where('o_id', '=', "$o_id")->delete();
        if($res){
            echo json_encode(['msg' => 1]);
        }else{
            echo json_encode(['msg' => 0]);
        }
    }
    public function orderDelall()
    {
        $ids = $_GET['ids'];
        $res = Db::table('order')->whereIn('o_id',$ids)->delete();
        if($res){
            echo json_encode(['msg' => 1]);
        }else{
            echo json_encode(['msg' => 0]);
        }
    }
    public function orderDesc()
    {
        $id = $_GET['id'];
        $orderDesc = Db::table('order')
                        ->leftJoin('status','order.o_status','=','status.s_id')
                        ->leftJoin('address','order.o_id','=','address.a_id')
                        ->where('o_id','=',"$id")
                        ->orderBy('order.o_addtime','desc')
                        ->select()
                        ->get();
//        echo "<pre>";
//        var_dump($orderDesc);die;
        return view('admin/order/desc');
    }
}
