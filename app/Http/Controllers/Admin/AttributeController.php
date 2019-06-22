<?php
/**
 * Created by PhpStorm.
 * User: 杨永茂
 * Date: 2019/6/17
 * Time: 11:57
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function attrInsert(Request $request)
    {
        if($request->isMethod('post')){

            $postData = $request->input('data');

            $attrName = $postData['name'];

            $attrName = str_replace('，', ',', $attrName);

            $arr_attr = explode(',', $attrName);

            $attrName = array_filter($arr_attr) ;

            foreach ($attrName as $k=>$v){
                $arr[$k]['name'] = $v;
                $arr[$k]['cat_id'] = $postData['cat_id'];
            }

            $res = DB::table('attribute')->insert($arr);

            if($res){
                return json_encode(['code'=>1, 'msg'=>'success']);
            }else{
                return json_encode(['code'=>2, 'msg'=>'error']);
            }

        }

        if($request->isMethod('get')){

            $catId = $request->input('cat_id');

            return view('admin\attribute.attrInsert')
                ->with([
                    'catId'=>$catId,
                ]);
        }
    }

    public function catAttr(Request $request)
    {
        $attrName = $request->input('attr_name');

        $attrName = !empty($attrName) ? $attrName : '';

        $catId = $request->input('cat_id');

        $attrInfo = DB::table('cat')->where('cat_id', $catId)->select('cat_id', 'cat_name')->first();

        $attrList = DB::table('attribute')
                        ->where('cat_id', $catId)
                        ->where(function ($query) use ($attrName){
                            $query->where('name', 'like', "%$attrName%");
                        })
                        ->select('id', 'name')->paginate(10);

        return view('admin\attribute.catAttr')
            ->with([
                'attrList'=>$attrList,
                'attrInfo'=>$attrInfo
            ]);
    }

    public function attrDelAll(Request $request)
    {
        $ids = $request->input('ids');

        $res = Db::table('attribute')->whereIn('id', $ids)->delete();

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }
    }

    public function attrDelOne(Request $request)
    {
        $id = $request->input('id');

        $res = Db::table('attribute')->where('id', $id)->delete();

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }
    }

    public function attrUpd(Request $request)
    {
        $id = $request->input('id');

        $name = $request->input('name');

        $res = Db::table('attribute')->where('id', $id)->update(['name'=>$name]);

        if( $res ){
            return json_encode(['code'=>'1', 'msg'=>'success']);
        }else{
            return json_encode(['code'=>'2', 'msg'=>'error']);
        }
    }



}