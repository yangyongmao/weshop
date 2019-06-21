<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/10
 * Time: 17:06
 */

namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
//首页
    public function list(Request $request)
    {
        $arr = $request->input();

        $username = isset($arr['username']) ? $arr['username'] :'';
        $start = $request->input('start','1970-01-01');
        $end = $request->input('end',time());

        $start = is_int($start) ? $start : strtotime($start);
        $end = is_int($end) ? $end : strtotime($end) + 24*60*60;

        $data = DB::table('admin')
            ->whereBetween("u_addtime",[[$start],[$end]])
            ->where('u_name', 'like', "%$username%")
            ->paginate(5);
        foreach ($data as $v){
            $child = DB::table('admin_role')
                ->leftJoin('role',function($join){
                    $join->on('admin_role.r_id','=','role.r_id');
                })
                ->where('admin_role.u_id',$v->u_id)
                ->get();
            $v->child=$child;
        }
//        echo "<pre>";
//        var_dump($data);die;
        return view('admin/admin/list')->with([
            'data' => $data,
            'start' => date('Y-m-d',$start),
            'end' => date('Y-m-d',$end),
            'username' => $username
        ]);
    }
//添加
    public function add(Request $request)
    {
        if($request->ajax()) {
            $data = $request->input();
            if(!$request->input('role')){
                return 4;
            }
            $u_name = $data['name'];
            $account = DB::table('admin')->where('u_name','=',$u_name)->first();
            if($account){
                return 5;
            }
            $u_pwd = $data['pass'];
            $u_account = $data['u_account'];
            $account = DB::table('admin')->where('u_account','=',$u_account)->first();
            if($account){
                return 3;
            }
            $u_phone = $data['u_phone'];
            $u_email = $data['u_email'];
            $arr = [
                'u_name'=>$u_name,
                'u_pwd'=>md5($u_pwd),
                'u_account'=>$u_account,
                'u_phone'=>$u_phone,
                'u_email'=>$u_email,
                'u_addtime'=>time(),
                'u_updatetime'=>time()
            ];
            $res = DB::table('admin')->insert($arr);
            if($res){
                $account = DB::table('admin')->where('u_account','=',$u_account)->first();
                $u_id = $account->u_id;
                $role = $data['role'];
                $arr = [];
                foreach ($role as $key => $v){
                    $arr[$key]['r_id'] = $v;
                    $arr[$key]['u_id'] = $u_id;
                }
                DB::table('admin_role')->insert($arr);
                return 1;
            }else{
                return 2;
            }
        }else{
            $res = DB::table('role')->get();
            return view("admin/admin/add",['res'=>$res]);
        }
    }
//删除
    public function del(Request $request)
    {
        if($request->ajax()) {
            $data = $request->input();
            $u_id = $data['id'];
            $data = DB::table('admin')->where('u_id',$u_id)->delete();
            if($data){
                return 1;
            }else{
                return 2;
            }
        }
    }
//修改
    public function update(Request $request){
        if($request->ajax()) {
            $data = $request->input();
            if(!$request->input('role')){
                return 4;
            }
            $u_id = $data['id'];
            $u_name = $data['u_name'];
            $accounts = DB::table('admin')->where('u_name','=',$u_name)->first();
            $account = DB::table('admin')->where('u_id','=',$u_id)->first();
            if($account->u_name != $u_name && $accounts){
                return 5;
            }
            $u_pwd = md5($data['u_pwd']);
            $u_account = $data['u_account'];
            $accounts = DB::table('admin')->where('u_account','=',$u_account)->first();
            $account = DB::table('admin')->where('u_id','=',$u_id)->first();
            if($account->u_account != $u_account && $accounts){
                return 3;
            }
            $u_phone = $data['u_phone'];
            $u_email = $data['u_email'];
            $arr = [
                'u_name'=>$u_name,
                '  u_pwd'=>md5($u_pwd),
                'u_account'=>$u_account,
                'u_phone'=>$u_phone,
                'u_email'=>$u_email,
                'u_updatetime'=>time()
            ];
            $res = DB::table('admin')->where('u_id',$u_id)->update($arr);
            if($res){
                DB::table('admin_role')->where('u_id',$u_id)->delete();
                $account = DB::table('admin')->where('u_account','=',$u_account)->first();
                $u_id = $account->u_id;
                $role = $data['role'];
                $arr = [];
                foreach ($role as $key => $v){
                    $arr[$key]['r_id'] = $v;
                    $arr[$key]['u_id'] = $u_id;
                }
                DB::table('admin_role')->insert($arr);
                return 1;
            }else{
                return 2;
            }
        }else{
            $id = $request->input('id');
            $res = DB::table('admin')->where('u_id',$id)->first();
            $data = DB::table('role')->get();

            $role = DB::table('admin')
                ->leftJoin('admin_role',function ($join){
                    $join->on("admin.u_id","=","admin_role.u_id");
                })
                ->leftJoin('role',function ($join){
                    $join->on("admin_role.r_id","=","role.r_id");
                })
                ->where('admin.u_id',$id)
                ->get();

            $arr = [];
            foreach ($role as $key => $v){
                $arr[] = $v->r_id;
            }
            foreach($data as $key => $v){
                if(in_array($v->r_id,$arr)){
                    $data[$key]->flag=1;
                }else{
                    $data[$key]->flag=2;
                }
            }

            return view('admin/admin/update' , ['res'=>$res,'data'=>$data]);
        }

    }
//状态
    public function statuses(Request $request){
        $id = $request->input('id');
        $res = DB::table('admin')->where('u_id',$id)->first();
        $status = $res->status;
        if($status == 0){
            $res = DB::table('admin')->where('u_id',$id)->update(['status'=>1]);
            return 1;
        }else{
            $res = DB::table('admin')->where('u_id',$id)->update(['status'=>0]);
            return 0;
        }
    }




}