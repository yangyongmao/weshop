<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/14
 * Time: 19:41
 */

namespace  App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use DB;
use Illuminate\Support\Facades\DB;

class DonodeController extends Controller
{
    public function list(){
        return view('admin/do_node/list');
    }
}