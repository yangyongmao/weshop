<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/13
 * Time: 9:07
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{

    public function show(Request $request)
    {
        //开始结束时间
        $startTime = $request->post('startTime','1970-01-01');
        $endTime = $request->post('endTime',time());

        $startTime = is_int($startTime) ? $startTime : strtotime($startTime);
        $endTime = is_int($endTime) ? $endTime : strtotime($endTime);

        /**
         * 查询评论数据
         *      在时间条件区间
         *      是否有回复信息，设置新字段
         */
        $commData = DB::table('goodscomments')
            ->select(
                DB::raw("
                    *,
                    case 
                    when type=1 then '好评'  
                    when type=2 then '中评' 
                    when type=3 then '差评'
                    end as comm_type
                ")
            )
            ->whereBetween("addtime",[[$startTime],[$endTime]])
            ->where([
                ['pid','=',0],
                ['is_show','=',2]
            ])
            ->orderBy("addtime","ASC")
            ->paginate(5);

        /**
         * 检查每条数据是否有回复
         */
        foreach ($commData as $commkey => $v) {
                $replyData = DB::table('goodscomments')
                    ->where("pid","=",$v->id)
                    ->select(DB::raw("id"))
                    ->first();

                if(!empty($replyData)){
                    $v->reply_id = $replyData->id;
                }else{
                    $v->reply_id = '';
                }
        }

        return view('admin.comments.show')
            ->with([
                'commData' => $commData,
                'startTime' => date("Y-m-d",$startTime),
                'endTime' => date("Y-m-d",$endTime),
            ]);

    }

    public function delete(Request $request)
    {
        if($request->ajax()){

            if($request->isMethod('GET')){
                $id = $request->get('id');

                $res = DB::table('goodscomments')
                    ->whereIn("id",explode(',',$id))
                    ->orWhereIn("pid",explode(',',$id))
                    ->delete();

                if($res){

                    return json_encode(
                        [
                            'errorCode' => 200,
                            'errorMsg' => '删除成功',
                        ],
                        JSON_UNESCAPED_UNICODE
                    );

                }else{

                    return json_encode(
                        [
                            'errorCode' => 201,
                            'errorMsg' => '删除失败',
                        ],
                        JSON_UNESCAPED_UNICODE
                    );

                }

            }

        }
    }

    public function reply(Request $request)
    {
        if($request->isMethod("GET")){

            $comm_id = $request->get('comm_id');
            $good_id = $request->get('good_id');
            $u_id = $request->get('u_id');

            //发布的用户
            $user = '北京的购物狂';
            //关于的商品
            $good = DB::table('goods')
                ->where("goods_id","=",$good_id)
                ->select(DB::raw("goods_name"))
                ->first();
            //评论信息
            $comm = DB::table('goodscomments')
                ->where("id","=",$comm_id)
                ->select(DB::raw("comment"))
                ->first();

            return view('admin.comments.reply')->with([
                'user' => $user,
                'good' => $good->goods_name,
                'comm' => $comm->comment,
            ]);
        }
    }


}