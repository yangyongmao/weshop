<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
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
                      <div class="layui-form-item">
                          <input type="hidden" id="id" name="u_id" required="" lay-verify="required"
                                 autocomplete="off" class="layui-input" value='<?php echo $res->u_id?>'>
                          <label for="username" class="layui-form-label">
                              <span class="x-red">*</span>用户名
                          </label>
                          <div class="layui-input-inline">
                              <input type="text" id="username" name="u_name" required="" lay-verify="required"
                                     autocomplete="off" class="layui-input" value="<?php echo $res->u_name?>">
                          </div>
                          <div class="layui-form-mid layui-word-aux">
                              <span class="x-red">*</span>
                          </div>
                      </div>
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>登录名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="u_account" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="<?php echo $res->u_account?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="phone" class="layui-form-label">
                          <span class="x-red">*</span>手机
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="phone" name="u_phone" required="" lay-verify="phone"
                          autocomplete="off" class="layui-input" value="<?php echo $res->u_phone?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>邮箱
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="u_email" required="" lay-verify="email"
                          autocomplete="off" class="layui-input" value="<?php echo $res->u_email?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                      <div class="layui-input-block">
<<<<<<< HEAD
                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="超级管理员" checked="">
                        <input type="checkbox" name="like1[read]" lay-skin="primary" title="编辑人员">
                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="宣传人员" checked="">
=======
                        @foreach($data as $v)

                            @if($v->flag == 1)
                                <input type="checkbox" name="role[]" lay-skin="primary" title="{{$v->r_name}}" value="{{$v->r_id}}" checked>
                              @else
                                  <input type="checkbox" name="role[]" lay-skin="primary" title="{{$v->r_name}}" value="{{$v->r_id}}" >
                              @endif
                       @endforeach
>>>>>>> 8b2138b2f08383c42be4f4b78a27fd70d57f57ae
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_pass" name="u_pwd" required="" lay-verify="pass"
                          autocomplete="off" class="layui-input" value="<?php echo $res->u_pwd?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          6到16个字符
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          修改
                      </button>
                  </div>
              </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });

                //监听提交
                form.on('submit(add)',
                    function(data) {
                        var action = data.form.action;
                        // console.log(action);return false;
                        $.get(action,data.field,function(res){
                            // console.log(res);return false;
                            if(res==1){
                                layer.alert("修改成功", {
                                        icon: 6
                                    },
                                    function() {
                                        //关闭当前frame
                                        xadmin.close();

                                        // 可以对父窗口进行刷新
                                        xadmin.father_reload();
                                    });

                            }else if(res==2){
                                layer.alert("修改失败", {
                                        icon: 5
                                    },
                                    function() {
                                        //关闭当前frame
                                        xadmin.close();

                                        // 可以对父窗口进行刷新
                                        xadmin.father_reload();
                                    });
                            }else if(res==3){
                                layer.alert("登录名重复", {
                                    icon: 4
                                });
<<<<<<< HEAD
=======
                            }else if(res==4){
                                layer.alert("角色不能为空", {
                                    icon: 3
                                });
                            }else if(res==5){
                                layer.alert("用户名为空", {
                                    icon: 2
                                });
>>>>>>> 8b2138b2f08383c42be4f4b78a27fd70d57f57ae
                            }
                        })
                        return false;
                    });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>
