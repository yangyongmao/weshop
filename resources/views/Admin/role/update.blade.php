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
            <form action="" method="post" class="layui-form layui-form-pane">
                @foreach($data as $v)
                    <input type="hidden" name="r_id" value="{{$v->r_id}}">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="r_name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="{{$v->r_name}}">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                        @foreach($res as $va)
                            <tr>
                                <td>
                                    <input type="checkbox" name="like1[write]" lay-skin="primary" class="parent" lay-filter="father" title="{{$va->m_content}}">
                                </td>
                                <td>
                                    @foreach($va->child as $val)
                                        {{--@foreach($node as $value)--}}
                                        <div class="layui-input-block">
                                        @if($val->flag==1)
                                        <input name="role[]" lay-skin="primary" type="checkbox" class="child"  value="{{$val->n_id}}" title="{{$val->n_remarks}}" checked="">
                                            @else
                                            <input name="role[]" lay-skin="primary" type="checkbox" class="child" value="{{$val->n_id}}" title="{{$val->n_remarks}}">
                                        @endif
                                    </div>
                                        {{--@endforeach--}}
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="r_remarks"  class="layui-textarea" >{{$v->r_remarks}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
                    @endforeach
            </form>
        </div>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });

          //监听提交
          form.on('submit(add)', function(data){
            console.log(data);
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
                }else if(res ==4 ){
                    layer.alert("角色名存在", {
                        icon: 4
                    });
                }else if(res ==3 ){
                    layer.alert("权限不能为空", {
                        icon: 4
                    });
                }
            })
            //发异步，把数据提交给php

            return false;
          });


        form.on('checkbox(father)', function(data){
            if(data.elem.checked){
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render();
            }else{
               $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();
            }
            var i=0;
            if($(".child").nextAll().children("parent").hasClass("layui-form-checked")){
                i++;
            }
            if($(".child").nextAll().children("parent").length == i){
                $(".child").addClass("layui-form-checked");
            }else{
                $(".child").removeClass("layui-form-checked");
            }
            form.render(); //更新全部
            form.on('select'); //刷新select选择框渲染
        });





          
          
        });
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>
{{--<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>--}}
{{--<script>--}}
    {{--$(".child").change(function(){--}}
        {{--if($(".child:checked").length==$(".child").length){--}}
            {{--console.log1(1);return false--}}
            {{--$(".parent").prop("checked",true);--}}
        {{--}else{--}}
            {{--console.log1(2);return false--}}
            {{--$(".parent").prop("checked",false);--}}
        {{--}--}}
    {{--});--}}
{{--</script>--}}