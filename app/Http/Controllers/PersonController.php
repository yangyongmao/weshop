<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/20
 * Time: 14:30
 */
namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
        $now = time();

//        //优惠券信息
//        $data = DB::table('user_discount')
//            ->where('u_id','=',$thisUser['data']['uid'])
//            ->leftJoin('discount',function ($query){
//                $query->on('user_discount.discount_id','=','discount.id');
//            })
//            ->where('discount.status','=',1)
//            ->select(DB::raw("
//                weshop_user_discount.status,
//                weshop_discount.money,
//                weshop_discount.start,
//                weshop_discount.end,
//                weshop_discount.name,
//                case
//                when weshop_discount.end<$now then '已作废'
//                when weshop_user_discount.status=1 then '未使用'
//                when weshop_user_discount.status=2 then '已作废'
//                end 'statusinfo'
//            "))
//            ->orderBy("discount.end",'DESC')
//            ->get();


        //未使用的优惠券
        $unusedDiscount = DB::table('user_discount')
            ->leftJoin('discount',function ($query){
                $query->on('user_discount.discount_id','=','discount.id');
            })
            ->where([
                'u_id' => $thisUser['data']['uid'],
                'user_discount.status' => 1,
            ])
            ->select(DB::raw('
                weshop_user_discount.status,
                weshop_discount.money,
                weshop_discount.start,
                weshop_discount.end,
                weshop_discount.name
            '))
            ->where('end','>',time())
            ->get();

        //作废的优惠券 ;过期和使用过的
        $overdue = DB::table('user_discount')
            ->leftJoin('discount',function ($query){
                $query->on('user_discount.discount_id','=','discount.id');
            })
            ->where('user_discount.status','=',2)
            ->orWhere('discount.end','<',time())
            ->select(DB::raw('
                weshop_user_discount.status,
                weshop_discount.money,
                weshop_discount.start,
                weshop_discount.end,
                weshop_discount.name
            '))
            ->get();

        return view('index.person.discount')->with([
            'unusedDiscount' => $unusedDiscount,
            'overdue' => $overdue,
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

    public function collection(Request $request)
    {
        $userinfo = $request->session()->get('thisUser');

        $uid = $userinfo['data']['uid'];

        $collectionList = Db::table('collection')
            ->join('goods', 'goods.goods_id', '=', 'collection.goods_id')
            ->where('collection.user_id', '=', $uid)
            ->select( 'goods.goods_id', 'goods.goods_name', 'goods.goods_price', 'collection.id', 'goods.goods_img')->get();

        return view('index.person.collection',['collectionList'=>$collectionList,'thisUser'=>$userinfo['data']]);
    }

    public function getdiscount()
    {
        if(request()->ajax()){
            $discount_id = request()->get('discount_id');
            $user_id = request()->session()->get('thisUser')['data']['uid'];

            //检查此用户是否领取过此购物券
            $thisDiscount = DB::table('user_discount')
                ->where([
                    'u_id' => $user_id,
                    'discount_id' => $discount_id,
                ])
                ->first('status');

            if(!empty($thisDiscount)){
                return response()->json([
                    'errorCode' => 201,
                    'errorMsg' => '您已领取过',
                    'data' => [],
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }

            //没有领取过
            $res = DB::table('user_discount')->insert([
                'u_id' => $user_id,
                'discount_id' => $discount_id,
            ]);

            if($res){
                return response()->json([
                    'errorCode' => 200,
                    'errorMsg' => '领取成功',
                    'data' => [],
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }else{
                return response()->json([
                    'errorCode' => 202,
                    'errorMsg' => '领取失败',
                    'data' => [],
                ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }



        }
    }



}