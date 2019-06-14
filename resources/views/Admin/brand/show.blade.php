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
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <script src="/adminStatic/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/adminStatic/js/xadmin.js"></script>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="开始日" name="m_addtime_start" id="start">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="截止日" name="m_addtime_end" id="end">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="m_title"  placeholder="请输入菜单名..." autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    <button class="layui-btn" onclick="xadmin.open('添加用户','brandadd',600,400)"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body layui-table-body layui-table-main">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                            </th>
                            <th>ID</th>
                            <th>品牌名称</th>
                            <th>品牌链接</th>
                            <th>品牌LOGO</th>
                            <th>品牌描述</th>
                            <th>品牌排序</th>
                            <th>是否展示</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $v)
                            <tr>
                                <td>
                                    <input type="checkbox" name="brand_id" value="{{$v->brand_id}}"   lay-skin="primary">
                                </td>
                                <td>{{$v->brand_id}}</td>
                                <td>{{$v->brand_name}}</td>
                                <td>{{$v->brand_url}}</td>
                                <td><img style="width: 100px;height: 50px" src="{{asset('/storage/uploads/'.$v->brand_logo)}}" alt=""></td>
                                <td>{{$v->brand_desc}}</td>
                                <td>{{$v->scort}}</td>
                                <td id="{{$v->is_show}}">
                                    <button class="layui-btn"   value="{{$v->brand_id}}">
                                        @if($v->is_show == 0)
                                    展示
                                    @else
                                    禁止
                                    @endif
                                    </button>
                                </td>
                                <td class="td-manage">
                                    {{--<a title="编辑"  onclick="xadmin.open('编辑','updatemenus',600,400)" href="javascript:;">--}}
                                    <a title="编辑"  onclick="pleaseDel()" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,{{$v->brand_id}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-card-body ">
                    <div class="page">
                        <div>
                            {{$data->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    layui.use(['laydate','form','jquery'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;
        var $ = layui.jquery;


        $('.layui-btn').click(function () {
            var brand_id =$(this).val();
            var name = $(this);
            var is_show = $(this).parents('td').attr('id');
            $.ajax({
                url:'/admin/brandallow',
                data:{brand_id:brand_id,is_show:is_show,_token:'{{csrf_token()}}'},
                type:'post',
                datatype:'json',
                success:function (res) {

                    if(res==0){
                        $(name).text('展示')
                    }else{
                        $(name).text('禁止')
                    }
                    window.location.reload();
                }
            })
        })

        // 监听全选
        form.on('checkbox(checkall)', function(data){

            if(data.elem.checked){
                $('tbody input').prop('checked',true);
            }else{
                $('tbody input').prop('checked',false);
            }
            form.render('checkbox');
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });


    });



    /*用户-删除*/
    function member_del(obj,brand_id){
        layer.confirm('确认要删除吗？',function(index){

            $.get("brandelete",{brand_id},function (jsonMsg) {
                var objMsg = $.parseJSON(jsonMsg);
                if(objMsg.errorCode == 200){
                    layer.msg('删除成功',{icon:1});return false;
                }else{
                    layer.msg('删除失败',{icon:1});return false;
                }
            });
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }

    /**
     *    批量删除
     * */
    function delAll (argument) {
        var ids = [];

        // 获取选中的id
        $('tbody input').each(function(index, el) {
            if($(this).prop('checked')){
                ids.push($(this).val())
            }
        });

        layer.confirm('确认要删除吗？'+ids.toString(),function(index){
            console.log(ids);
            $.get("brandelete",{brand_id:ids.toString()},function (jsonMsg) {
                var objMsg = $.parseJSON(jsonMsg);
                if(!(objMsg.errorCode == 200)){
                    layer.msg('删除失败',{icon:1});return false;
                }else{
                    layer.msg('删除成功', {icon: 1});
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                }
            });

        });
    }

    /**
     * 提示用户删除重新添加
     */
    function pleaseDel() {
        alert('请删除重现添加');
    }
</script>
</html>