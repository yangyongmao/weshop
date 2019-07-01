<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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

            var_dump($data);
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


}