<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/14
 * Time: 19:41
 */

namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use DB;
use Illuminate\Support\Facades\DB;

class DonodeController extends Controller
{
    public function list(){
        $data = DB::table('modules')->get();
        $res = DB::table('modules')
            ->rightJoin('node_modules',function($join){
                $join->on('modules.m_id','node_modules.p_id');
            })
            ->rightJoin('node',function($join){
                $join->on('node_modules.n_id','node.n_id');
            })
            ->paginate(5);

        return view('admin/do_node/list',['res'=>$res,'data'=>$data]);
    }

    public function add(Request $request){
        if($request->ajax()){
            $arr = $request->input();
            $res = DB::table('modules')->where('m_content',$arr['m_content'])->first();
            $node = [
                'n_name'=>$arr['n_name'],
                'n_remarks'=>$arr['n_remarks'],
            ];
            $data = DB::table('node')->insert($node);
            if($data){
                $reses = DB::table('node')->where('n_name',$arr['n_name'])->first();
                $arr = [
                    'n_id' => $reses->n_id,
                    'p_id' => $res->m_id,
                ];
                DB::table('node_modules')->insert($arr);
                return 1;
            }
        }
    }

    public function del(Request $request){
        $n_id = $request->input('n_id');
        $res = DB::table('node')->where('n_id',$n_id)->delete();
        if($res){
            DB::table('node_modules')->where('n_id',$n_id)->delete();
            DB::table('role_node')->where('n_id',$n_id)->delete();
            return 1;
        }else{
            return 2;
        }
    }

    public function update(Request $request){
        $n_id  =$request->input('n_id');
        if($request->ajax()){
            $data = $request->input();
//            var_dump($data);die;
            $arr = [

                'm_content' => $data['m_content'],
            ];
            $arrs = [
                'n_name'=>$data['n_name'],
                'n_remarks'=>$data['n_remarks'],
            ];
//            echo $data['m_id'];die;
            $arres = [
              'p_id'=>$data['m_id'],
              'n_id'=>$data['n_id'],
            ];
            DB::table('modules')->where('m_id',$data['m_id'])->update($arr);
            DB::table('node')->where('n_id',$data['n_id'])->update($arrs);
            DB::table('node_modules')->insert($arres);
            return 1;
        }else{
            $modules = DB::table('modules')->get();
            $res = DB::table('modules')
                ->rightJoin('node_modules',function($join){
                    $join->on('modules.m_id','node_modules.p_id');
                })
                ->rightJoin('node',function($join){
                    $join->on('node_modules.n_id','node.n_id');
                })
                ->get();
            $data = DB::table('modules')
                ->rightJoin('node_modules',function($join){
                    $join->on('modules.m_id','node_modules.p_id');
                })
                ->rightJoin('node',function($join){
                    $join->on('node_modules.n_id','node.n_id');
                })
                ->where('node.n_id',$n_id)
                ->first();
            return view('admin/do_node/update',['res'=>$res,'data'=>$data,'modules'=>$modules]);
        }

    }
}