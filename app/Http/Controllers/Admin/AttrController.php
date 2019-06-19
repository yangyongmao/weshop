<?php
/**
 * Created by PhpStorm.
 * User: 杨永茂
 * Date: 2019/6/19
 * Time: 9:49
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AttrController extends Controller
{
    public function attrList(Request $request)
    {
        $keyword = $request->input('keyword');

        $keyword = !empty($keyword) ? $keyword : '';

        $attrList = DB::table('attribute')->join('cat', 'cat.cat_id', '=', 'attribute.cat_id')
                    ->where('attribute.name', 'like', "%$keyword%")
                    ->orWhere('cat.cat_name', 'like', "%$keyword%")
                    ->select('cat.cat_id', 'cat.cat_name', 'attribute.id', 'attribute.name')
                    ->orderBy('attribute.id', 'asc')->paginate(13);

        return view('admin\attr.attrList')
                ->with([
                    'attrList'=> $attrList,
                    'keyword' => $keyword
                ]);
    }

    public function addAttr()
    {
        $catList = Db::table('cat')->select('cat_name', 'cat_id','pid')->get();

        $catList = getTree($catList);

        return view('admin\attr.addAttr')
                ->with([
                    'catList'=>$catList
                ]);
    }

}