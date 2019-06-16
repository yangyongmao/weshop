<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>回复用户评论</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/adminStatic/css/font.css">
        <link rel="stylesheet" href="/adminStatic/css/xadmin.css">
        <script type="text/javascript" src="/adminStatic/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/adminStatic/js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" id="layui-form">

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>您查看的是
                        </label>
                        <div class="layui-input-inline">
                            <span class="layui-form-mid" style="color: red;">{{$user}}</span>
                            <span class="layui-form-mid">评论</span>
                            <span class="layui-form-mid" style="color:red;">{{$good}}</span>
                            <span class="layui-form-mid">的评论信息</span>
                            {{--<input type="text" id="L_username" name="m_title" required="" lay-verify="m_title" autocomplete="off" class="layui-input">--}}
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>评论内容</label>
                        <div class="layui-input-inline">
                            {{--<input type="text" id="L_username" name="m_url" required="" lay-verify="m_url" autocomplete="off" class="layui-input">--}}
                            <textarea  id="L_username" required="" lay-verify="" autocomplete="off" class="layui-input" cols="100" rows="100" style="width:230px;height: 200px; " disabled>{{$comm}}</textarea>
                        </div>
                        {{--<div class="layui-form-mid layui-word-aux">URL最长为30个字符\若是父级，'/'表示</div>--}}
                    </div>

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>回复客户</label>
                        <div class="layui-input-inline">
                            <textarea name="reply_comment" id="reply_comment" required="" lay-verify="m_reply" autocomplete="off" class="layui-input" cols="100" rows="100" style="width:230px;height: 200px; ">{{$old_reply}}</textarea>
                        </div>
                    </div>
                    <input type="hidden" name="comm_id" value="{{$comm_id}}">
                    @csrf

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">回复</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            layui.use(['form', 'layer','jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    m_title: function(value) {
                        if (value.length <= 0 || value.length > 18) {
                            return '菜单标题最大为6个汉字';
                        }
                    },
                    m_reply:function(value){
                       if(value.length <= 0){
                           return '回复内容不可为空';
                       }
                    },
                    // pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    // repass: function(value) {
                    //     if ($('#L_pass').val() != $('#L_repass').val()) {
                    //         return '两次密码不一致';
                    //     }
                    // }
                });

                //监听提交
                form.on('submit(add)', function(data) {
                    /**
                     * 异步添加数据
                     */
                    var comm_id = $("input[name='comm_id']").val(); //回复的文章id
                    var reply_comment = $("textarea[name='reply_comment']").val();
                    var _token = $("input[name='_token']").val();
                    // console.log(reply_comment);return false;

                    $.post("",{pid:comm_id,comment:reply_comment,_token:_token},function (jsonMsg) {
                        var objMsg = $.parseJSON(jsonMsg);
                        // console.log(objMsg);return false;
                        if(objMsg.errorCode == 200){}else{
                            alert("回复评论失败");return false;
                        }
                    });
                    //发异步，把数据提交给php
                    layer.alert("回复成功", {
                        icon: 6
                    },
                    function() {
                        //关闭当前frame
                        xadmin.close();
                        // 可以对父窗口进行刷新 
                        // xadmin.father_reload();
                    });
                    return false;

                });

            });
        </script>
        <script>
            var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();
        </script>
    </body>

</html>