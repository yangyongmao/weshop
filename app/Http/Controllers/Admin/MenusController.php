<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/11
 * Time: 14:19
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Model\Menus;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{

    public function add(Request $request)
    {
        if($request->isMethod("GET")){
            /**
             * 查询已有菜单
             */
            $menusData = DB::table('menus')->where('m_pid','=','0')->get();

            return view("admin.menus.add")->with('menusData',$menusData);
        }else{
            $menusData = $request->post();
            $res = DB::table('menus')->insert([
                'm_title' => $menusData['m_title'],
                'm_url' => $menusData['m_url'],
                'm_pid' => $menusData['m_pid'],
                'm_addtime' => time(),
            ]);

            if($res){

                return json_encode(
                    [
                        'errorCode' => 200,
                        'errorMsg'  => '添加菜单成功',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }else{

                return json_encode(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '添加菜单失败',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }
        }
    }

    public function show(Request $request)
    {
        $m_addtime_start = $request->input('m_addtime_start','1970-01-01');
        $m_addtime_end = $request->input('m_addtime_end',time());
        $m_title = $request->input('m_title','');

        /**
         * 判断时间是否是int 是int为时间戳形式
         */
        $m_addtime_start = is_int($m_addtime_start) ? $m_addtime_start : strtotime($m_addtime_start);
        $m_addtime_end = is_int($m_addtime_end) ? $m_addtime_end : strtotime($m_addtime_end) + 24*60*60;
        $m_title = empty($m_title) ? '' : $m_title;

        $menusData = DB::table('menus')
            ->whereBetween("m_addtime",[[$m_addtime_start],[$m_addtime_end]])
            ->where("m_title","like","%$m_title%")
            ->orderBy("m_addtime","DESC")
            ->paginate(7);

        return view('admin.menus.show')->with([
            "data" => $menusData,
            "m_addtime_start" => date("Y-m-d",$m_addtime_start),
            "m_addtime_end" => date("Y-m-d",$m_addtime_end),
            "m_title" => $request->post('m_title'),
        ]);
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            $m_id = $request->get('m_id');

            if(empty($m_id)){
                return json_encode(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '删除失败',
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            }

            $res = DB::table('menus')
                ->whereIn('m_id',(array)$m_id)
                ->whereIn('m_id',explode(',',$m_id))
                ->orWhereIn('m_pid',explode(',',$m_id))
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