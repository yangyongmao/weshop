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
        $searchData = $request->input();
        var_dump($searchData);


        $menusData = DB::table('menus')
            ->whereBetween("m_addtime",[$searchData['m_addtime_start'],$searchData['m_addtime_end']])
            ->where("m_title","like","$searchData['m_title'])
            ->paginate(3);
        return view('admin.menus.show')->with("data",$menusData);
    }

    public function getTree($data = [],$pid = 0)
    {
        $array = [];
        foreach ($data as $k => $v){
            if($v->m_pid == $pid){
                $v->child = $this->getTree($data,$v->m_id);
                $array[] = $v;
            }
        }
        return (object)$array;
    }



}