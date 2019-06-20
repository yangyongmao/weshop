<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/17
 * Time: 9:38
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CateController extends Controller
{

    public function show(Request $request)
    {
        if($request->isMethod('GET')){

            $sear_cat_name = $request->get('sear_cat_name','');

            $catData = DB::table('cat')
                ->where("cat_name","like","%$sear_cat_name%")
                ->where("is_show","=",1)
                ->paginate(7);

            return view("admin.cat.show")
                ->with([
                    'catData' => $catData,
                    'sear_cat_name' => $sear_cat_name,
                ]);
        }else{

        }
    }

    public function add(Request $request)
    {
        if($request->isMethod('GET')){
            $dadData = DB::table('cat')
                ->where([
                    'pid' => 0,
                    'is_show' => 1
                ])
                ->get();

            return view("admin.cat.add")
                ->with([
                    'dadData' => $dadData,
                ]);
        }else{
            if($request->ajax()){

                $data = $request->post();
                unset($data['_token']);
                $data['is_show'] = 1;

                $res = DB::table('cat')->insert($data);
                if($res){

                    json_encode(
                        [
                        'errorCode' => 200,
                        'errorMsg' => '添加成功',
                        ],
                        JSON_UNESCAPED_UNICODE
                    );

                }else{

                    json_encode(
                        [
                            'errorCode' => 201,
                            'errorMsg' => '添加失败',
                        ],
                        JSON_UNESCAPED_UNICODE
                    );

                }
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            $cat_id = $request->get('cat_id');

            if(empty($cat_id)){
                return json_encode(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '删除失败',
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            }

            $res = DB::table('cat')
                ->whereIn("cat_id",explode(',',$cat_id))
                ->orWhereIn('pid',explode(',',$cat_id))
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