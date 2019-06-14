<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="csrf-token" content="{{ csrf_token()}}">
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
                <form class="layui-form" action="#" method="post" enctype="multipart/form-data" id="form-data">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>品牌标题</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="brand_name" required="" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">最大为6个汉字</div>
                    </div>

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>品牌链接</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="brand_url" required=""  autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>品牌Logo</label>
                            <input type="file"  id="file" name="brand_logo" required=""  autocomplete="off" class="layui-input-inline">
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>品牌排序</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="scort" required=""  autocomplete="off" class="layui-input">
                        </div>
                    </div>                    <div class="layui-form-item">
                    <label class="layui-form-label">品牌展示</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_show" value="0" title="是">
                        <input type="radio" name="is_show" value="1" title="否" checked>
                    </div>
            </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">品牌简介</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入内容" name="brand_desc" class="layui-textarea"></textarea>
                        </div>
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
            layui.use(['form', 'layer','jquery'], function(){
                 const $ = layui.jquery;
                const form = layui.form,
                    layer = layui.layer;

                //监听提交
                form.on('submit', function(data) {
                    /**
                     * 异步添加数据
                     */
                    let formObj = document.getElementById("form-data");
                    let formData = new FormData(formObj);
                    $.ajax({
                        url: "/admin/brandadd",
                        data: formData,
                        type: "POST",
                        dataType: "json",
                        cache:false,
                        processData: false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
                        contentType: false, // 不设置Content-type请求头
                        success: function (msg) {
                            // console.log(layer);
                        },
                        error:function (msg) {
                            layer.alert("增加失败", {
                                icon: 6
                            });
                            return false;
                        }
                    });

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

                    //     $.post("/admin/brandadd",,{data:data,brand_desc:brand_desc,is_show:is_show,scort:scort,brand_name:brand_name,brand_url:brand_url,brand_logo:brand_logo,_token:_token},function (jsonMsg) {
                    //         var objMsg = $.parseJSON(jsonMsg);
                    //         if(objMsg.errorCode == 200){
                    //             // location.href="admin/showmenus";
                    //         }else{
                    //             alert("添加菜单失败");return false;
                    //         }
                    //     });
                        //发异步，把数据提交给php
                   });
                })
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