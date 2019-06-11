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
use DB;

class AdminController extends Controller
{

    public function list()
    {
        $data = DB::table('admin')->get();
        return view('admin/admin/list',['data'=>$data]);
    }

    public function add(Request $request)
    {
        if($request->ajax()) {
            $data = $request->input();
            $u_name = $data['name'];
            $u_pwd = $data['pass'];

            $u_account = $data['u_account'];
            $account = DB::table('admin')->where('u_account','=',$u_account)->first();
            if($account){
                return 3;
            }
            $u_phone = $data['u_phone'];
            $u_email = $data['u_email'];
//            echo $u_email;die;
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
                return 1;
            }else{
                return 2;
            }





//            $role = $data['role'];
//            var_dump($data);
//            $arr = [];
//            foreach ($role as $key => $v){
//                $arr[$key]['']
//            }
        }else{
            return view("admin/admin/add");
        }
    }

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

    public function update(Request $request){
        if($request->ajax()) {
            $data = $request->input();
            $u_id = $data['id'];
            $u_name = $data['u_name'];
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
                'u_pwd'=>md5($u_pwd),
                'u_account'=>$u_account,
                'u_phone'=>$u_phone,
                'u_email'=>$u_email,
                'u_updatetime'=>time()
            ];
//            echo 1;die;
            $res = DB::table('admin')->where('u_id',$u_id)->update($arr);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }else{
            $id = $request->input('id');
            $res = DB::table('admin')->where('u_id',$id)->first();
            return view('admin/admin/update',['res'=>$res]);
        }

    }

    public function statuses(Request $request){
        $id = $request->input('id');
        $res = DB::table('admin')->where('u_id',$id)->first();
//        var_dump($res);die;
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