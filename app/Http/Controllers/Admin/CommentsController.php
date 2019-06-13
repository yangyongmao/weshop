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
            ->whereBetween("addtime",[[$startTime],[$endTime]])
            ->where([
                ['pid','=',0],
                ['is_show','=',2]
            ])
            ->orderBy("addtime","ASC")
            ->paginate(5);

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




}