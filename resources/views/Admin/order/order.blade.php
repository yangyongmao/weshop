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
    </head>
    
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">演示</a>
                <a>
                    <cite>导航元素</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" method="get" action="orderList">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input class="layui-input" placeholder="开始日" name="start" id="start"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input class="layui-input" placeholder="截止日" name="end" id="end"></div>

                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="contrller">
                                        <option value="0">订单状态</option>
                                        @foreach($statusList as $k => $v)
                                        <option value="{{$v->s_id}}">{{$v->status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="username" placeholder="请输入订单号" autocomplete="off" class="layui-input"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">
                                        <i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()">
                                <i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','./order-add.html',800,600)">
                                <i class="layui-icon"></i>添加</button></div>
                        <div id="contentbox">
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" name="" lay-filter="checkall"  lay-skin="primary">
                                        </th>
                                        <th>订单编号</th>
                                        <th>收货人</th>
                                        <th>总金额</th>
                                        <th>应付金额</th>
                                        <th>订单状态</th>
                                        <th>下单时间</th>
                                        <th>操作</th></tr>
                                </thead>
                                <tbody>
                                @foreach($orderList as $k => $v)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id" lay-skin="primary" value="{{$v->o_id}}"></td>
                                        <td>{{$v->o_num}}</td>
                                        <td>{{$v->a_name}}:{{$v->a_call}}</td>
                                        <td>{{$v->o_total}}</td>
                                        <td>{{$v->o_price}}</td>
                                        <td>{{$v->status}}</td>
                                        <td>{{date('Y-m-d H:i:s',$v->o_addtime)}}</td>
                                        <td class="td-manage">
                                            <a title="查看" onclick="xadmin.open('编辑','orderDesc?id={{$v->o_id}}')" href="javascript:;">
                                                <i class="layui-icon">&#xe63c;</i></a>
                                            <a title="删除" onclick="member_del(this,{{$v->o_id}})" href="javascript:;">
                                                <i class="layui-icon">&#xe640;</i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                    {{ $orderList->links() }}
{{--                                    <a class="prev" href="">&lt;&lt;</a>--}}
{{--                                    <a class="num" href="">1</a>--}}
{{--                                    <span class="current">2</span>--}}
{{--                                    <a class="num" href="">3</a>--}}
{{--                                    <a class="num" href="">489</a>--}}
{{--                                    <a class="next" href="">&gt;&gt;</a></div>--}}
                            </div>
                        </div>
                    </div>
                        </div>
                </div>
            </div>
        </div>
        </div>
    </body>

    <script>

        layui.use(['laydate', 'form','jquery'],
        function() {
            var laydate = layui.laydate;
            //执行一个laydate实例
            var  form = layui.form;


            // 监听全选
            form.on('checkbox(checkall)', function(data){

                if(data.elem.checked){
                    $('tbody input').prop('checked',true);
                }else{
                    $('tbody input').prop('checked',false);
                }
                form.render('checkbox');
            });
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });


        });

        /*用户-停用*/
        function member_stop(obj, id) {
            layer.confirm('确认要停用吗？',
            function(index) {

                if ($(obj).attr('title') == '启用') {

                    //发异步把用户状态进行更改
                    $(obj).attr('title', '停用');
                    $(obj).find('i').html('&#xe62f;');

                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {
                        icon: 5,
                        time: 1000
                    });

                } else {
                    $(obj).attr('title', '启用');
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!', {
                        icon: 5,
                        time: 1000
                    });
                }

            });
        }

        /*用户-删除*/
        function member_del(obj, id) {
            layer.confirm('确认要删除吗？',
            function(index) {
                //发异步删除数据
                $.ajax({
                    url:'orderDel',
                    data:{id:id},
                    dataType:'json',
                    type:'GET',
                    success:function(e){
                        if(e.msg == 1){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!', {
                                icon: 1,
                                time: 1000
                            });
                        }else{
                            history.go(0);
                        }
                    }
                })

            });
        }


        function delAll (argument) {
            var ids = [];

            // 获取选中的id
            $('tbody input').each(function(index, el) {
                if($(this).prop('checked')){
                    ids.push($(this).val())
                }
            });
            layer.confirm('确认要删除吗？'+ids.toString(),function(index) {
                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    url: 'orderDelall',
                    data: {ids: ids},
                    dataType: 'json',
                    type: 'GET',
                    success: function (e) {
                        if(e.msg == 1){
                            layer.msg('删除成功', {icon: 1});
                            $(".layui-form-checked").not('.header').parents('tr').remove();
                        }else{
                            history.go(0);
                        }

                    }

                });
            });
        }
        // function member_sreach(argument){
        //     var start = $('input[name="start"]').val();
        //     var end = $('input[name="end"]').val();
        //     var contrller = $("#contrller option:selected").val();
        //     // $.ajax({
        //     //     url:'',
        //     //     data:{start:start,end:end,contrller:contrller},
        //     //     type:'GET',
        //     //     dataType:'json',
        //     //     success:function(e){
        //     //
        //     //     }
        //     // })
        //     return false;
        // }
        // member_onload();
        // function member_onload(argument){
        //     // var text = $('#contentbox').text();
        //     var obj = layer.$('#contentbox').html();
        //     console.log(obj);
        // }

    </script>

</html>
