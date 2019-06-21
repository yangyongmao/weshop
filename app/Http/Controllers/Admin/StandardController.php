<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/17
 * Time: 11:49
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandardController extends Controller
{

    public function addstandard(Request $request)
    {
        if($request->isMethod('GET')){
            $cat_id = $request->get('cat_id');
            return view("admin.standard.add")->with([
                'cat_id' => $cat_id,
            ]);
        }else{
            $data = $request->post();

            $name = explode(',',$data['name']);
            $standard_group_id = explode(',',$data['standard_group_id']);
            $show_posi = explode(',',$data['show_posi']);

            if(count($name) != count($standard_group_id) ||count($standard_group_id) != count($show_posi) || count($show_posi) != count($name)){
                return json_encode(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '数据格式有误',
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            }

            $insertData = [];
            foreach ($name as $k =>$v){
                $insertData[$k]['name'] = $v;
                $insertData[$k]['standard_group_id'] = $standard_group_id[$k];
                $insertData[$k]['show_posi'] = $show_posi[$k];
                $insertData[$k]['cat_id'] = $data['cat_id'];
            }

            $res = DB::table('standard')->insert($insertData);

            if($res){
                return json_encode(
                    [
                        'errorCode' => 200,
                        'errorMsg' => '添加成功',
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            }else{
                return json_encode(
                    [
                        'errorCode' => 202,
                        'errorMsg' => '添加失败',
                    ],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
    }

    public function show(Request $request)
    {
        $cat_id = $request->get('cat_id');
        $cat_name = $request->get('cat_name');

        $standardData = DB::table('standard')
            ->where("cat_id","=",$cat_id)
            ->get();

        return view("admin.standard.show")->with([
            'cat_name' => $cat_name,
            'standardData' => $standardData,
        ]);
    }

    public function selfList(Request $request)
    {
        $sear_cat_name = $request->get('sear_cat_name','');

        $standardData = DB::table('standard')
            ->select(
                DB::raw("
                    weshop_standard.*,
                    weshop_standard_group.`name` as `group_name`,
                    weshop_cat.`cat_name`,
                    case 
                    when show_posi=1 then '筛选列表'  
                    when show_posi=2 then '详情页搭配' 
                    when show_posi=3 then '详情页规格表'
                    end as show_posi_desc
                ")
            )
            ->leftJoin("standard_group",function ($query){
                $query->on("standard.standard_group_id","=","standard_group.id");
            })
            ->leftJoin("cat",function ($query){
                $query->on("standard.cat_id","=","cat.cat_id");
            })
            ->where("cat.cat_name","like","%$sear_cat_name%")
            ->orderBy("cat_id","DESC")
            ->paginate(7);

        return view("admin.standard.selflist")->with([
            'standardData' => $standardData,
            'sear_cat_name' => $sear_cat_name,
        ]);
    }

    public function value(Request $request)
    {
        $id = $request->get('id');

        $childValue = DB::table('standard_option')
            ->where([
                'standard_id' => $id,
            ])
            ->get();

        return view("admin.standard.childvalue")->with([
            'childValue'               => $childValue,
            'standard_name'      => $request->get('standard_name'),
        ]);
    }

    public function addChildValue(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();

            $insertData = [];
            foreach (explode(',',$data['value']) as $k => $v){
                $insertData[$k]['value'] = $v;
                $insertData[$k]['standard_id'] = $data['standard_id'];
            }

            $res = DB::table('standard_option')->insert($insertData);
            if($res){

                return json_encode(
                    [
                        'errorCode' => 200,
                        'errorMsg' => '添加成功',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }else{

               return json_encode(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '添加失败',
                    ],
                    JSON_UNESCAPED_UNICODE
                );

            }
        }else{
            $standard_id = $request->get('standard_id');
            return view("admin.standard.addchild")->with([
                'standard_id' => $standard_id,
            ]);
        }
    }


}