<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/20
 * Time: 8:48
 */
namespace App\Http\Controllers\Model;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Code extends Model
{
    function message($code='200',$message='success',$data = []){
        echo json_encode(['code'=>$code,'msg'=>$message,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }
    public function login($arr){

        $data = DB::table('user')->where(['uname'=>$arr['uname'],'upwd'=>md5($arr['upwd'])])->get();
//        var_dump($data);die;
        if($data){
            return $this->message('200','登录成功');
        }else{
            return $this->message('500','账号密码错误');
        }
    }
    public function reset($arr){

        $data = DB::table('user')->where('uname',$arr['uname'])->update(['upwd'=>md5($arr['upwd'])]);

        if($data){
            return $this->message('200','修改成功');
        }else{
            return $this->message('202','修改失败');
        }
    }
    public function register($arr){
        $data = DB::table('user')->where('uname',$arr['uname'])->first();
//        var_dump($data);die;
        if($data){
            return $this->message('203','此用户已存在',$data);
        }
        $data = DB::table('user')->insert($arr);
        if($data){
            return $this->message('200','注册成功');
        }else{
            return $this->message('201','注册失败');
        }
    }
}