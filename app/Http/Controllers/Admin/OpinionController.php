<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OpinionController extends Controller
{
    public function opinionList()
    {
        $start = isset($_GET['start'])&&!empty($_GET['start'])?strtotime($_GET['start']):25200;
        $end = isset($_GET['end'])&&!empty($_GET['end'])?strtotime($_GET['end']):time()+60*60*24;
        $contrller = isset($_GET['contrller'])&&!empty($_GET['contrller'])?[$_GET['contrller']]:[1,2];
        $username = isset($_GET['username'])&&!empty($_GET['username'])?$_GET['username']:'';
        $between = [$start,$end];

        $opinionList = Db::table('user_opinion')
                            ->whereBetween('addtime',$between)
                            ->whereIn('is_ok',$contrller)
//                            ->where('用户名','like',"%$username%")
                            ->orderBy('addtime','desc')
                            ->select()
                            ->paginate(15);
        return view('admin/opinion/opinion',['opinionList' => $opinionList]);
    }
}