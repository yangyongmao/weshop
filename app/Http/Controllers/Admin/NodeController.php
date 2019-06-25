<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/14
 * Time: 15:05
 */

namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Model\Category;

class NodeController extends Controller
{
    public function list(Request $request){
            $data = DB::table("modules")->paginate(5);

            return view('admin/node/list',['data'=>$data]);
    }

    public function add(Request $request){
        if($request->ajax()){
            $m_content = $request->input('m_content');
            $data = DB::table('modules')->where('m_content',$m_content)->first();
//            var_dump($data);die;
            if($data){
                return 3;
            }
            $m_remarks = $request->input('m_remarks');
            $arr = [
                'm_content'=>$m_content,
                'm_remarks'=>$m_remarks
            ];
            $res = DB::table('modules')->insert($arr);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }
    }

    public function del(Request $request){
        $m_id = $request->input('id');
        $res = DB::table('modules')->where('m_id',$m_id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
    public function update(Request $request){
        if($request->ajax()){
            $data = $request->input();
//            var_dump($data);die;
            DB::table('modules')->where('m_id',$data['m_id'])->update($data);
            return 1;die;
        }else{
            $m_id = $request->input('m_id');
            $data = DB::table('modules')->where('m_id',$m_id)->get();
            return view('admin/node/update',['data'=>$data]);
        }
    }
}