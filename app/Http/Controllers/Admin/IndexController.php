<?php
/**
 * Created by PhpStorm.
 * User: lixinyuan
 * Date: 2019/6/10
 * Time: 11:21
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $thisAdmin = $request->session()->get("thisAdmin");
        return view("admin.index.index")->with("thisAdmin",$thisAdmin);
<<<<<<< HEAD
=======
    }




    public function welcome(Request $request)
    {
        return view('admin.index.welcome')->with([
            'thisAdmin' => $request->session()->get('thisAdmin'),
        ]);
>>>>>>> upstream/master
    }

}
