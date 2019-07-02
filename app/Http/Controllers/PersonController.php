<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{

    public function InfoShow()
    {
        //用户信息
        $thisUser = request()->session()->get('thisUser');
        //默认收货地址
        $address = DB::table('address')
            ->where('u_id','=',$thisUser['data']['uid'])
            ->first();


        return view('index.person.personinfo')->with([
//            'carousel' => $carousel,
            'address' => $address,
            'thisUser' => $thisUser['data'],
            'sear_name' => '',
            'cat_id' => 1,
            'brand_id' => 1,
            'sear_title' => '小米手机',
        ]);
    }

    public function discount()
    {
        //用户信息
        $thisUser = request()->session()->get('thisUser');
        //优惠券信息
        $data = DB::table('user_discount')
            ->where('u_id','=',$thisUser['data']['uid'])
            ->leftJoin('discount',function ($query){
                $query->on('user_discount.discount_id','=','discount.id');
            })
            ->where('discount.status','=',1)
            ->select(DB::raw("
                weshop_user_discount.status,
                weshop_discount.money,
                weshop_discount.start,
                weshop_discount.end,
                weshop_discount.name,
                case
                when weshop_user_discount.status=1 then '未使用'
                when weshop_user_discount.status=2 then '已使用'
                end 'statusinfo'
            "))
            ->orderBy("user_discount.status",'ASC')
            ->get();

        return view('index.person.discount')->with([
            'data' => $data,
            'thisUser' => $thisUser['data'],
            'sear_name' => '',
            'cat_id' => 1,
            'brand_id' => 1,
            'sear_title' => '小米手机',
        ]);

    }

    public function updatemyself()
    {
        if(request()->isMethod('POST')){
            $data = request()->post();

            //处理头像
            $filename = request()->session()->get('thisUser')['data']['uheader'];
            if(!empty(request()->file('uheader'))){
                $file   = request()->file('uheader');
                $ext    = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();                     //临时文件的绝对路径
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext; //设置文件路径
                Storage::disk('userhead')->put($filename, file_get_contents($realPath)); //上传
            }

            //处理密码
            if(request()->session()->get('thisUser')['data']['upwd'] == $data['upwd']){
                $upwd = $data['upwd'];
            }else{
                $upwd = md5($data['upwd']);
            }

            //处理地址
            $province = DB::table('areas')
                ->where('area_id','=',$data['addr_1'])
                ->first('area_name');
            $city = DB::table('areas')
                ->where('area_id','=',$data['addr_2'])
                ->first('area_name');
            $sec_city = DB::table('areas')
                ->where('area_id','=',$data['addr_3'])
                ->first('area_name');
            $town = DB::table('areas')
                ->where('area_id','=',$data['addr_4'])
                ->first('area_name');

            //执行入库
            DB::beginTransaction();

            $res = DB::table('user')->where('uid','=',$data['uid'])->update([
                'uname' => request()->session()->get('thisUser')['data']['uname'],
                'upwd' =>$upwd,
                'uemail' => $data['uemail'],
                'uphone' => $data['uphone'],
                'usex' => $data['usex'],
                'uheader' => '/'.$filename,
                'time' => time()
            ]);

            if($res){
                $is_address = DB::table('address')->where('u_id','=',$data['uid'])->first('a_id');
                //设置过我的地址  则更新它
                if(!empty($is_address)){
                    $res = DB::table('address')
                        ->where('a_id','=',$is_address->a_id)
                        ->update([
                            'a_call' => $data['uphone'],
                            'a_province' => $province->area_name,
                            'a_city' => $city->area_name,
                            'a_sec_city' => $sec_city->area_name,
                            'a_town' => $town->area_name,
                            'a_info' => $data['addr_5'],
                        ]);
                    if($res){
//                        echo 1;die();
                        DB::commit();
                    }else{
//                        echo 2;die();
                        DB::rollBack();
                    }
                }else{
                    $res = DB::table('address')->insert([
                        'u_id' => $data['uid'],
                        'a_name' => request()->session()->get('thisUser')['data']['uname'],
                        'a_call' => $data['uphone'],
                        'a_country' => "中国",
                        'a_province' => $province->area_name,
                        'a_city' => $city->area_name,
                        'a_sec_city' => $sec_city->area_name,
                        'a_town' => $town->area_name,
                        'a_info' => $data['addr_5'],
                    ]);
                    if($res){
//                        echo 3;die();
                        DB::commit();
                    }else{
//                        echo 4;die();
                        DB::rollBack();
                    }
                }
            }else{
//                echo 5;die();
                DB::rollBack();
            }
            request()->session()->forget('thisUser');
            return redirect('loginout');

        }else{
            //查询用户信息
            $myinfo = request()->session()->get('thisUser');

            $address = DB::table('address')
                ->where('u_id','=',$myinfo['data']['uid'])
                ->first();

            //查询全国一级地址数据
            $addr = DB::table('areas')
                ->where('parent_id','=',0)
                ->get();

            return view('index.person.update')->with([
                'thisUser' => $myinfo['data'],
                'address' => $address,
                'addr' => $addr,
            ]);

        }
    }

    public function collection()
    {
        $data = request()->get();
        return json_encode($data);
    }


}