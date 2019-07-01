<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/7/1
 * Time: 14:39
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AddrController extends Controller
{

    public function getdata()
    {
        if(request()->ajax()){
            $area_id = request()->get('area_id');

            $data = DB::table('areas')
                ->where('parent_id','=',$area_id)
                ->get();

            return json_encode($data);

        }
    }


}