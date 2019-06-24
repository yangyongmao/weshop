<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
use Nette\Mail;

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
    public function opinionDelall()
    {
        $ids = is_array($_GET['ids']) ? $_GET['ids'] : [$_GET['ids']] ;
        $res = Db::table('user_opinion')->whereIn('id',$ids)->delete();
        if($res){
            echo json_encode(['msg' => 1]);
        }else{
            echo json_encode(['msg' => 0]);
        }
    }
    public function opinionDesc()
    {
        $id = $_GET['id'];
        $opinionDesc = Db::table('user_opinion')->where('id','=',"$id")->first();

        return view('admin/opinion/desc',['opinionDesc' => $opinionDesc]);
    }
    public function isokAll()
    {
        $email = is_array($_GET['email']) ? $_GET['email'] : [$_GET['email']] ;
        $ids = is_array($_GET['ids']) ? $_GET['ids'] : [$_GET['ids']] ;
        $message = '感谢您的建议';
        $mail = new Message;
        $obj = $mail->setFrom('WeShop <206615407@qq.com>');
        foreach ($email as $k => $v){
            $obj = $obj->addTo("$v");
        }

        $obj->setSubject('建议反馈')
            ->setBody("$message");
        $mailer = new SmtpMailer([
            'host' => 'smtp.qq.com',
            'username' => '206615407@qq.com',
            'password' => 'zoudufpbwupobgjg',
        ]);
        $mailer->send($mail);
        Db::table('user_opinion')->whereIn('id',$ids)->update(['is_ok' => 2]);
        echo json_encode(['msg' => $email]);
    }
}