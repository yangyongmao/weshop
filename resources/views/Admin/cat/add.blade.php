<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>分类添加</title>
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
                <form class="layui-form">

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>分类名称</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="cat_name" required="" lay-verify="m_title" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">最大为10个汉字</div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>父级分类</label>
                        <div class="layui-input-inline">
                            <select id="" name="pid" class="valid">
                                <option value="0">最高级</option>
                                @foreach ($dadData as $k => $v)
                                    <option value="{{   $v->cat_id    }}">{{ $v->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>描述</label>
                        <div class="layui-input-inline">
                            <textarea name="cat_desc" id="L_username" style="width: 190px;height: 200px;" lay-verify="m_desc" autocomplete="off" class="layui-input"></textarea>
                        </div>
                        <div class="layui-form-mid layui-word-aux">描述最长为80个汉字</div>
                    </div>

                    @csrf

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button>
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
                        if (value.length <= 0 || value.length > 30) {
                            return '菜单标题最大为10个汉字';
                        }
                    },
                    m_desc:function(value){
                       if(value.length <= 0 || value.length > 255){
                           return '菜单路由最长为80个汉字';
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
                    // console.log(data);
                    var cat_name = $("input[name='cat_name']").val();
                    var cat_desc = $("textarea[name='cat_desc']").val();
                    var pid = $("select[name='pid']").val();
                    var _token = $("input[name='_token']").val();

                    // console.log(cat_name);return false;

                    $.post("/admin/addcate",{cat_name:cat_name,cat_desc:cat_desc,pid:pid,_token:_token},function (jsonMsg) {
                        var objMsg = $.parseJSON(jsonMsg);
                        if(objMsg.errorCode == 200){
                            // location.href="admin/showmenus";
                        }else{
                            alert("添加分类失败");return false;
                        }
                    });
                    //发异步，把数据提交给php
                    layer.alert("增加成功", {
                        icon: 6
                    },
                    function() {
                        //关闭当前frame
                        xadmin.close();
                        // 可以对父窗口进行刷新 
                        xadmin.father_reload();
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