<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/adminStatic/./css/font.css">
        <link rel="stylesheet" href="/adminStatic/./css/xadmin.css">
        <script src="/adminStatic/./lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/adminStatic/./js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">

                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">详细信息</div>
                        <div class="layui-card-body ">
                            <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">


                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>用户</h3>
                                        <p>
                                            <cite>马云</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>时间</h3>
                                        <p>
                                            <cite>{{date('Y-m-d H:i:s',$opinionDesc->addtime)}}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>邮箱</h3>
                                        <p>
                                            <cite id="email">2637005117@qq.com</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-md2 layui-col-xs6 ">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>是否审阅</h3>
                                        <p>
                                            <cite>
                                                @if($opinionDesc->is_ok == 1)
                                                    未审阅
                                                @else
                                                    已审阅
                                                @endif
                                            </cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-col-sm6 layui-col-md3">
                    <div class="layui-card" style="width:1000px">
                        <div class="layui-card-header">意见内容</div>
                        <div class="layui-card-body  ">
                            <p class="layuiadmin-big-font"></p>
                            <p>
                                {{$opinionDesc->opinion}}
                                fdsaaaaaaaaaaa
                                fsdaaaaaaaaaaaaaaaaaafdsa
                                fsadddddddddd
                                fdsaaaaaaaaaaasajfkljfskdljfkdlsafkjjeoifioj锻炼腹肌卡戴珊发的附件打开拉萨解放第三方监督是否即时的反馈陆军二级放假啊士大夫是安抚打扫房间欸韦杰夫撒酒疯看来就是地方二级哦i发书法家炯哇封建时代分解哦九分啊的经费进复试的后果是疯狂的就噶JFK了发
                            </p>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <blockquote class="layui-elem-quote layui-quote-nm" id="{{$opinionDesc->id}}">
                        <button>发送反馈邮件</button>
                        <button>删除</button>
                    </blockquote></div>

            </div>
        </div>
        </div>
    </body>
</html>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    $('button').click(function () {
        var txt = $(this).text();
        var id = $(this).parent().attr('id');
        var email = $('#email').text();
        if(txt == '删除'){
            $.ajax({
                url:'opinionDelall',
                data:{ids:id},
                dataType:'json',
                type:'GET',
                success:function(e){
                    if(e.msg == 1){
                        window.opener = null;//禁止某些浏览器的一些弹窗
                        window.open('','_self');
                        window.close();
                        $('.x-admin-sm').close()

                    }else{
                        alert('删除失败')
                        history.go(0);
                    }
                }
            })
        }else if(txt == '发送反馈邮件'){
            $.ajax({
                url:'isokAll',
                data:{id:id,email:email},
                dataType: 'json',
                type:'GET',
                success:function(e){
                    console.log(e)
                    if(e.msg == 1){

                    }else{

                    }
                }
            })
        }
    })
</script>