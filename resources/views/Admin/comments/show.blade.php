<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>商品评论</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/adminStatic/css/font.css">
        <link rel="stylesheet" href="/adminStatic/css/xadmin.css">
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
                            <form class="layui-form layui-col-space5" method="post">
                                @csrf
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="开始日" name="startTime" id="start" value="{{$startTime}}">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="截止日" name="endTime" id="end" value="{{$endTime}}">
                                </div>
                                {{--<div class="layui-inline layui-show-xs-block">--}}
                                    {{--<input type="text" name="m_title"  placeholder="" autocomplete="off" class="layui-input" value="">--}}
                                {{--</div>--}}
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            {{--<button class="layui-btn" onclick="xadmin.open('添加用户','addmenus',600,400)"><i class="layui-icon"></i>添加</button>--}}
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>用户昵称</th>
                                    <th>关于商品</th>
                                    <th>评论内容</th>
                                    <th>评论类型</th>
                                    <th>发表时间</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($commData as $k => $v)
                                  <tr>
                                    <td>
                                      <input type="checkbox" name="m_id" value="{{$v->id}}"   lay-skin="primary">
                                    </td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->u_id}}</td>
                                    <td>{{$v->goods_id}}</td>
                                    <td>{{$v->comment}}</td>
                                    <td>{{$v->comm_type}}</td>
                                    <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
                                    <td class="td-manage">
                                      {{--<a title="编辑"  onclick="xadmin.open('编辑','updatemenus',600,400)" href="javascript:;">--}}
                                        <a title="编辑"  onclick="xadmin.open('回复此评论','replycomm?comm_id={{$v->id}}&good_id={{$v->goods_id}}&u_id={{$v->u_id}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      <a title="删除" onclick="member_del(this,{{$v->id}})" href="javascript:;">
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
                                    {{$commData->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script src="/adminStatic/js/jquery.min.js"></script>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
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
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });


      /**
       * 搜索后分页 将a连接带上搜索值
       */
      $(".page-item").on('click',function () {
          var url = $(this).children().prop('href');
          var newUrl = url + '&startTime=' + $("input[name='startTime']").val()
                    + "&endTime=" + $("input[name='endTime']").val();
          $(this).children().prop('href',newUrl);
      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){

              $.get("deletecomments",{id:id},function (jsonMsg) {
                  var objMsg = $.parseJSON(jsonMsg);
                  if(objMsg.errorCode == 200){
                      //发异步删除数据
                      $(obj).parents("tr").remove();
                      layer.msg('已删除!',{icon:1,time:1000});
                  }else{
                      layer.msg('删除失败',{icon:1});
                      return false;
                  }
              });

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
            $.get("deletecomments",{id:ids.toString()},function (jsonMsg) {
                var objMsg = $.parseJSON(jsonMsg);
                if(!(objMsg.errorCode == 200)){
                    layer.msg('删除失败',{icon:1});
                    return false;
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
      // function pleaseDel() {
      //     alert('请删除重现添加');
      // }
    </script>
</html>