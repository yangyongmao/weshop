<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orderList()
    {
        $start = isset($_GET['start'])?strtotime($_GET['start']):'25200';
        $end = isset($_GET['end'])?strtotime($_GET['end'])+24*60*60:time();
        $contrller = isset($_GET['contrller'])?[$_GET['contrller']]:[1,2,3,4,5,6];
        $username = isset($_GET['username'])?$_GET['username']:'';

        $orderList = Db::table('order')
                        ->leftJoin('status','order.o_status','=','status.s_id')
                        ->leftJoin('address','order.a_id','=','address.a_id')
//                        ->whereBetween('o_addtime',[[$start],[$end]])
                        ->whereIn('o_status',$contrller)
                        ->where('o_num','like',"%$username%")
                        ->orderBy('o_addtime','desc')
                        ->paginate(5);

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
                        ->leftJoin('address','order.a_id','=','address.a_id')
                        ->where('o_id','=',"$id")
                        ->orderBy('order.o_addtime','desc')
                        ->select()
                        ->get();
        echo "<pre>";
        var_dump($orderDesc);die;
    }
}
