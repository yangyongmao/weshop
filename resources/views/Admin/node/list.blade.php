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

          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>

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
                                    <input type="text" name="m_content"  placeholder="分类名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="m_remarks"  placeholder="分类名描述" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
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
                                    <th>分类名</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                  <tr>
                                    <td>
                                      <input type="checkbox" name=""  lay-skin="primary">
                                    </td>
                                    <td>{{$v->m_id}}</td>
                                    <td>{{$v->m_content}}</td>
                                    <td class="td-manage">
                                      <a title="编辑"  onclick="xadmin.open('编辑','update?m_id={{$v->m_id}}')" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      <a title="删除" onclick="member_del(this,'{{$v->m_id}}')" href="javascript:;">
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
          form.on('submit(sreach)', function(data){
              //发异步，把数据提交给php
              $.get('add',data.field,function(res){
                  // console.log(res);return false;
                  if(res == 1){
                      layer.alert("增加成功", {
                              icon: 6
                          },
                          function() {
                              //关闭当前frame
                              xadmin.close();

                              // 可以对父窗口进行刷新
                              xadmin.father_reload();
                          });
                  }else if(res == 2){
                      layer.alert("增加失败", {
                          icon: 4
                      });
                  }else if(res == 3){
                      layer.alert("此类名存在", {
                          icon: 4
                      });
                  }
              })

              return false;
          });
      });



      /*用户-删除*/
      function member_del(obj,m_id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.get('del',{id:m_id},function(res){
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