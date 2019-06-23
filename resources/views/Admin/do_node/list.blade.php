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
                                    <select name="m_content" id="m_id">
                                      <option>规则分类</option>
                                        @foreach($data as $v)
                                      <option id="{{$v->m_id}}" name="{{$v->m_content}}">{{$v->m_content}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">

                                    <div class="layui-input-inline">
                                        <input type="text" id="username" name="n_name" required="" lay-verify="required"
                                               autocomplete="off" class="layui-input" placeholder="请填写控制器于方法名">
                                    </div>

                                </div>
                                <div class="layui-inline layui-show-xs-block">

                                    <div class="layui-input-inline">
                                        <input type="text" id="username" name="n_remarks" required="" lay-verify="required"
                                               autocomplete="off" class="layui-input" placeholder="请描述控制器于方法名">
                                    </div>

                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="add"><i class="layui-icon"></i>增加</button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary">
                                  </th>
                                  <th>ID</th>
                                  <th>权限规则</th>
                                  <th>权限名称</th>
                                  <th>所属分类</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                              @foreach($res as $v)
                                <tr>
                                  <td>
                                   <input type="checkbox" name=""  lay-skin="primary">
                                  </td>
                                  <td>{{$v->n_id}}</td>
                                  <td>{{$v->n_name}}</td>
                                  <td>{{$v->n_remarks}}</td>
                                  <td>{{$v->m_content}}</td>
                                  <td class="td-manage">
                                    <a title="编辑"  onclick="xadmin.open('编辑','update?n_id={{$v->n_id}}')" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,'{{$v->n_id}}')" href="javascript:;">
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
                                    {!!$res->links()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
          form.on('submit(add)',
              function(data) {
                    // console.log(data);return false
                  $.get('add',data.field,function(res){
                      // console.log(res);return false;
                      if(res==1){
                          layer.alert("增加成功", {
                              icon: 6
                          },
                          function() {
                              //关闭当前frame
                              xadmin.close();

                              // 可以对父窗口进行刷新
                              xadmin.father_reload();
                          });
                      }
                  });
                  return false;
              });

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
      function member_del(obj,n_id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
             $.get('del',{n_id:n_id},function(res){
                 if(res==1){
                     $(obj).parents("tr").remove();
                     layer.msg('已删除!',{icon:1,time:1000});
                 }else if(res == 2){
                     layer.alert("删除失败", {
                         icon: 4
                     });
                 }
             })
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
</html>