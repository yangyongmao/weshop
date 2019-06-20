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
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{

    public function add(Request $request)
    {
        if($request->ajax()){

            $menusData = $request->post();

            unset($menusData['_token']);

            $file   = $request->file('brand_logo');
            $ext    = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            Storage::disk('uploads')->put($filename, file_get_contents($realPath));

            $res = DB::table('brand')->insert([
                'brand_name'    => $menusData['brand_name'],
                'brand_url'     => $menusData['brand_url'],
                'brand_logo'    => $filename,
                'brand_desc'    => $menusData['brand_desc'],
                'scort'         => $menusData['scort'],
                'is_show'       => $menusData['is_show'],
            ]);

            if($res){

                return response()->json(
                    [
                        'errorCode' => 200,
                        'errorMsg' => '成功',
                    ]
                );

            }else{
                return response()->json(
                    [
                        'errorCode' => 201,
                        'errorMsg' => '上传失败',
                    ]
                );
            }


        }else{
            return view('admin.brand.add');
        }
    }
    public function allow(Request $request)
    {
        $brand_id = $request->post('brand_id');
        $is_show = $request->post('is_show');

        if($is_show == 0 )
        {

            $res = DB::table('brand')->where(['brand_id' => $brand_id])->update(['is_show' =>1]);

        }elseif($is_show == 1 )
            {
                $res = DB::table('brand')->where(['brand_id' => $brand_id])->update(['is_show' =>0]);


            }

        return $is_show;
    }

    public function show(Request $request)
    {

        $brand_title = $request->input('brand_name','');

        $menusData = DB::table('brand')
            ->where('brand_name','like','%'.$brand_title.'%')
            ->orderBy('scort')
            ->paginate(7);

        return view('admin.brand.show')->with("data",$menusData);
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            $brand_id = $request->get('brand_id');
            $res = DB::table('brand')
                ->whereIn('brand_id',(array)$brand_id)
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