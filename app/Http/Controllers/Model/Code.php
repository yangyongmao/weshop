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
        return json_encode(['errorCode'=>$code,'errorMsg'=>$message,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }
    //登录
    public function login($arr)
    {

        if(empty($arr)){
            return $this->message('500', '账号密码不能为空');
        }
        $data = DB::table('user')->where(['uname' => $arr['uname'], 'upwd' => md5($arr['upwd'])])->first();
        if (!empty($data)) {
            $list = get_object_vars($data);
            $token = md5($list['uphone'] . $list['upwd']);
            DB::table('user')->where('uname', $arr['uname'])->update(['token' => $token, 'time' => time()]);
            $data = DB::table('user')->where(['uname' => $arr['uname'], 'upwd' => md5($arr['upwd'])])->first();

            if (!empty($data)) {
                return $this->message('200', '登录成功',['data' => $data]);
            } else {
                return $this->message('500', '账号密码错误');
            }
        }else {
            return $this->message('500', '账号密码错误');
        }
    }
    //重置
    public function reset($arr){

        $data = DB::table('user')->where('uname',$arr['uname'])->update(['upwd'=>md5($arr['upwd'])]);

        if($data){
            return $this->message('200','修改成功');
        }else{
            return $this->message('202','修改失败');
        }
    }
    //注册
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
    //轮播
    public function Carousel($arr){
        $p = $username = isset($arr['p']) ? $arr['p'] :'5';
        if($p>5){
            return $this->message('205','p值太大');
        }
        $data = DB::table("goods")->orderBy('is_hot', 'desc')->limit($p)->get();
        var_dump($data);
        if($data){
            return $this->message('200','查询成功',$data);
        }else{
            return $this->message('204','未查到');
        }
    }
    //个人中心
    public function demoshow($arr){

        $data = DB::table('user')->where('uid',$arr['uid'])->get();
        if($data){
            return $this->message('200','个人信息',$data);
        }else{
            return $this->message('204','未查到');
        }
    }
    public function demoupdate($arr){
//        var_dump($arr);die;
        $data = DB::table('user')->where('uid',$arr['uid'])->update($arr);
        if($data){
            return $this->message('200','修改成功');
        }else{
            return $this->message('204','修改失败');
        }
    }
    public function demorder($arr){
        $uid = $arr['uid'];
        $data = DB::table('order')->where('uid',$uid)->get();
        if($data){
            return $this->message('200','我的订单',$data);
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function shopcat($arr){
        $uid = $arr['uid'];
//        $data = DB::table('')
    }
    public function address($arr){
        $uid = $arr['uid'];
        $data = DB::table('address')->where('u_id',$uid)->get();
        if($data){
            return $this->message('200','我的地址',$data);
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function add_address($arr){
        $arr = [
            'a_info'=>$arr['a_info'],
            'a_city'=>$arr['a_city'],
            'a_province'=>$arr['a_province'],
            'a_country'=>$arr['a_country'],
            'a_call'=>$arr['a_call'],
            'a_name' =>$arr['a_name'],
            'u_id' =>$arr['u_id'],
        ];
        $data = DB::table('address')->insert($arr);
        if($data){
            return $this->message('200','添加地址');
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function update_address($arr){
        $a_id = $arr['a_id'];
        $arr = [
            'a_info'=>$arr['a_info'],
            'a_city'=>$arr['a_city'],
            'a_province'=>$arr['a_province'],
            'a_country'=>$arr['a_country'],
            'a_call'=>$arr['a_call'],
            'a_name' =>$arr['a_name'],
        ];
        $data = DB::table('address')->where('a_id',$a_id)->update($arr);
        if($data){
            return $this->message('200','修改地址');
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function delete_address($arr){
        $a_id = $arr['a_id'];
        $data = DB::table('address')->where('a_id',$a_id)->delete();
        if($data){
            return $this->message('200','地址已删除');
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function cat(){
        $data = DB::table('cat')->get();
        if($data){
            return $this->message('200','分类查询',$data);
        }else{
            return $this->message('204','服务器错误');
        }
    }
    public function goods(){
        $data = DB::table('goods')->get();
        if($data){
            return $this->message('200','商品查询',$data);
        }else{
            return $this->message('204','服务器错误');
        }
    }
}