<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/7/1
 * Time: 10:22
 */
namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function list()
    {
        $data = DB::table('discount')->where("status",1)->get();
//        var_dump($data);die;
        return view("admin/discount/list",['data'=>$data]);
    }
    public function add(Request $request){
        if($request->ajax()){
            $data = $request->input();
            $start = is_int($data['start']) ? $data['start'] : strtotime($data['start']);
            $end = is_int($data['end']) ? $data['end'] : strtotime($data['end']) + 24*60*60;
            $arr = [
                'money'=>$data['money'],
                'start'=>$start,
                'end'=>$end,
                'name'=>$data['name'],
            ];
            $res = DB::table('discount')->insert($arr);
            if($res){
                return 1;
            }else{
                return 2;
            }

        }else{
            return view('admin/discount/add');
        }
    }
    public function delete(Request $request){
        $id = $request->input('id');
        $data = DB::table('discount')->where('id',$id)->select('status')->first();
        if($data->status == 1){
            $data = DB::table('discount')->where('id',$id)->update(['status'=>0]);
            if($data){
                return 1;
            }else{
                return 2;
            }
        }else{
            $data = DB::table('discount')->where('id',$id)->update(['status'=>1]);
            if($data){
                return 1;
            }else{
                return 2;
            }
        }
    }
    public function update(Request $request){
        $id = $request->input('id');
        if($request->ajax()){
            $data = $request->input();
            $start = is_int($data['start']) ? $data['start'] : strtotime($data['start']);
            $end = is_int($data['end']) ? $data['end'] : strtotime($data['end']) + 24*60*60;
            $arr = [
                'money'=>$data['money'],
                'start'=>$start,
                'end'=>$end,
                'name'=>$data['name'],
            ];
            $res = DB::table('discount')->where('id',$id)->update($arr);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }else{
            $res = DB::table('discount')->where('id',$id)->first();
            return view('admin/discount/update',['res'=>$res]);
        }
    }
}