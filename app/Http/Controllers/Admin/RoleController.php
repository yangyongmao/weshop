<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/12
 * Time: 19:08
 */

namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Model\Category;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        $data = $request->input('username');
        $res = DB::table('role')
            ->where('r_name', 'like', "%$data%")
            ->paginate(3);
        return view('admin/role/list')->with([
            'res' => $res,
            'data'=>$data
        ]);;
    }

    public function add(Request $request){
        if($request->ajax()){
            $data = $request->input();
//            var_dump($data);die;
            $res = DB::table('role')->where('r_name',$data['name'])->first();
            if($res){
                return 3;
            }
            if(!$request->input('n_id')){
                return 4;
            }
            $arr = [
                'r_name' =>$data['name'],
                'r_remarks' =>$data['desc'],
            ];
            $res = DB::table('role')->insert($arr);
            if($res){
                $res = DB::table('role')->where('r_name',$data['name'])->first();
//                var_dump($res);die;
                $arr = [];
                foreach($data['n_id'] as $k => $v){
                    $arr[$k]['n_id'] = $v;
                    $arr[$k]['r_id'] =$res->r_id;
                }
//                echo 1;die;
                $res = DB::table('role_node')->insert($arr);
                return 1;
            }else{
                return 2;
            }
        }else{
            $category = new Category;
            $data = $category->getCategoryInfoTest();
            return view('admin/role/add',['data'=>$data]);
        }
    }

    public function update(Request $request){
        if($request->ajax()){
            $data = $request->input();

//            var_dump($data);die;
            $res = DB::table('role')->where('r_id',$data['r_id'])->first();
            $reses = DB::table('role')->where('r_name',$data['r_name'])->first();
            if($res->r_name != $data['r_name'] && $reses){
                return 4;
            }
            if(!$request->input('role')){
                return 3;
            }
            $arr = [
                'r_name'=>$data['r_name'],
                'r_remarks'=>$data['r_remarks'],
            ];
//            var_dump($arr);die;
            $r_id = $data['r_id'];
//            echo $r_id;die;

            $res = DB::table('role')->where('r_id','=',$r_id)->update($arr);
//          print_r($res);die;
            DB::table('role_node')->where('r_id',$data['r_id'])->delete();
                $account = DB::table('role')->where('r_name','=',$data['r_name'])->first();
            $r_id = $account->r_id;
            $role = $data['role'];
            $arr = [];
            foreach ($role as $key => $v){
                $arr[$key]['n_id'] = $v;
                $arr[$key]['r_id'] = $r_id;
            }
//            print_r($arr);die;
//            echo 1;die;
            DB::table('role_node')->insert($arr);
            return 1;



        }else{
            $r_id = $request->input('r_id');
            $data = DB::table('role')->where('r_id',$r_id)->get();
            $res = DB::table('modules')->get()->toArray();

            foreach($res as $v){
                $chlid = DB::table('node_modules')
                    ->leftJoin('node',function($query){
                        $query->on('node_modules.n_id','=','node.n_id');
                    })
                    ->where("node_modules.p_id","=",$v->m_id)->get()->toArray();
                $v->child = $chlid;
            }

            $node = DB::table('node')->get();
            $role_node = DB::table('role')
                ->leftJoin('role_node',function($join){
                    $join->on('role.r_id','=','role_node.r_id');
                })
                ->leftJoin('node',function($join){
                    $join->on('role_node.n_id','=','node.n_id');
                })
                ->where('role.r_id',$r_id)
                ->get();

            $arr = [];
            foreach($role_node as $v){
                $arr[] = $v->n_id;
            }

            foreach($res as $v){
                foreach($v->child as $va){
                    if(in_array($va->n_id,$arr)){
                        $va->flag = 1;
                    }else{
                        $va->flag = 2;
                    }
                }
            }
//            echo "<pre>";
//            print_r($res);die;
            return view('admin/role/update',['data'=>$data,'res'=>$res]);
        }
    }

    public function del(Request $request){
        $r_id = $request->input('r_id');
        $res = DB::table('role')->where('r_id',$r_id)->delete();
        if($res){
            DB::table('role_node')->where('r_id',$r_id)->delete();
            DB::table('admin_role')->where('r_id',$r_id)->delete();
            return 1;
        }else{
            return 2;
        }
    }

}

