<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>添加规格子值</title>
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

        <style>
            th{
                width: 150px;
            }

            tr{
                margin-top: 5px;
            }

            td{
                padding-left: 5px;
            }
        </style>

    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">

                <form class="layui-form">

                    <table>
                        <tr>
                            <th>规格子值</th>
                        </tr>

                            <tr class="no1_tr">
                                <td>
                                    <input type="text" id="L_username" name="value[]" required="" lay-verify="m_title" autocomplete="off" class="layui-input names">
                                </td>
                                <td>
                                    <button class="layui-btn addDiv" style="width: 28px;height: 28px;" type="button">+</button>
                                </td>
                            </tr>
                        @csrf
                        <input type="hidden" name="standard_id" value="{{$standard_id}}">
                    </table>
                    {{--提交表单按钮--}}
                    <div class="layui-form-item" style="margin-top: 20px;">
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
                    var value=$(".names").map(function(){
                        return this.value
                    }).get().join(',');

                    $.ajax({
                        url:"",
                        type:"POST",
                        data:{value:value,_token:$("input[name='_token']").val(),standard_id:$("input[name='standard_id']").val()},
                        dataType:"JSON",
                        success:function (msg) {
                            let objMsg = $.parseJSON(msg);
                            if(objMsg.errorCode != 200){
                                layer.alert("添加失败", {
                                    icon: 6
                                });return false;
                            }
                        },
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


                /**
                 * 动态添加多条菜单
                 */
                $(".addDiv").on("click",function () {
                    var str="<tr class='no1_tr'>"+$(this).parent().parent().html()+"</tr>";
                        var str=str.replace('addDiv','removeDiv');		// 将类名add替换为del，在下面的代码中我们要给del添加事件
                    var str=str.replace('+','-');			// 将+符号替换为-符号
                    $(this).parent().parent().after(str);
                    // console.log(str);return false;
                    // let lessdiv = $(".no1_tr:first").html();
                    //
                    // let alldiv = lessdiv.replace("<button class=\"layui-btn addDiv\" style=\"width: 28px;height: 28px;\" type=\"button\">+</button>"
                    //     ,
                    //     "<button class=\"layui-btn removeDiv\" style=\"width: 28px;height: 28px;\" type=\"button\">-</button>");
                    //
                    // let div = "<tr class='no1_tr'>" + alldiv + "</tr>";
                    //
                    // $(".no1_tr:last").after(div);
                });

                /**
                 * 动态减少多条表单
                 */
                $("table").on("click",".removeDiv",function () {
                    $(this).parent().parent().remove();
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