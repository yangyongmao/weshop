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
                          <input type="hidden" id="id" name="id" required="" lay-verify="required"
                                 autocomplete="off" class="layui-input" value='<?php echo $res->id?>'>
                          <label for="username" class="layui-form-label">
                              <span class="x-red">*</span>优惠卷面值
                          </label>
                          <div class="layui-input-inline">
                              <input type="text" id="username" name="money" required="" lay-verify="required"
                                     autocomplete="off" class="layui-input" value="<?php echo $res->money?>">
                          </div>
                          <div class="layui-form-mid layui-word-aux">
                              <span class="x-red">*</span>
                          </div>
                      </div>
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>开始时间
                      </label>
                      <div class="layui-input-inline">
                          <input type="date" id="username" name="start" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="<?php echo date('Y-m-d',$res->start)?>">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="phone" class="layui-form-label">
                          <span class="x-red">*</span>结束时间
                      </label>
                      <div class="layui-input-inline">
                          <input type="date"  name="end" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="<?php echo date('Y-m-d',$res->end)?>">
                      </div>

                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>优惠卷名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text"  name="name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="<?php echo $res->name?>">
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
                            }else if(res==4){
                                layer.alert("角色不能为空", {
                                    icon: 3
                                });
                            }else if(res==5){
                                layer.alert("用户名为空", {
                                    icon: 2
                                });
                            }
                        });
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
