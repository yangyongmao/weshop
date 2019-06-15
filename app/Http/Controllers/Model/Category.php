<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
class Category extends Model
{

    //使用递归获取分类 （正式函数）
    //测试函数 （测试正式函数）
    public function getCategoryInfoTest()
    {
        $data = DB::table('modules')->get()->toArray();
//var_dump($data);die();

        foreach ($data as $k => $v){
            $child = DB::table('node_modules')
                ->leftJoin("node",function ($query){
                    $query->on("node_modules.n_id","=","node.n_id");
                })
                ->where("node_modules.p_id","=",$v->m_id)
                ->get()->toArray();
            $v->child = $child;
        }


        return $data;
    }

}