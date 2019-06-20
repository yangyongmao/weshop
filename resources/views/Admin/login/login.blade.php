<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>Weshop后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/adminStatic/css/font.css">
    <link rel="stylesheet" href="/adminStatic/css/login.css">
	  <link rel="stylesheet" href="/adminStatic/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/adminStatic/lib/layui/layui.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">管理员登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" action="">
            <input name="u_account" placeholder="请输入账号..."  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="u_pwd" lay-verify="required" placeholder="请输入密码..."  type="password" class="layui-input">
            <div id="vaptchaContainer" style="width: 100%;height: 36px;margin-top: 10px;" class="">
                <div class="vaptcha-init-main">
                    <div class="vaptcha-init-loading">
                        <a href="https://www.vaptcha.com" target="_blank">
                            <img src="https://cdn.vaptcha.com/vaptcha-loading.gif" />
                        </a>
                        <span class="vaptcha-text">Vaptcha启动中...</span>
                    </div>
                </div>
            </div>
            @csrf
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>


    <script src="https://cdn.vaptcha.com/v2.js"></script>
    <script>
        /**
         * 人机手势验证
         */
        loginTestStatus = false;
        vaptcha({
            //配置参数
            vid: '5cfefb50fc650ead100b1c07', // 验证单元id
            type: 'click', // 展现类型 点击式
            container: '#vaptchaContainer' // 按钮容器，可为Element 或者 selector
        }).then(function (vaptchaObj) {
            //人机验证返回值
            vaptchaObj.listen('pass', function() {
                loginTestStatus = true;
            });
            vaptchaObj.render()// 调用验证实例 vaptchaObj 的 render 方法加载验证按钮
        });

        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              //监听提交
              form.on('submit(login)', function(data){
                  if(!loginTestStatus){
                      alert("请进行人机验证");return false;
                  }

                  var u_account = $("input[name='u_account']").val();
                  var u_pwd = $("input[name='u_pwd']").val();
                  var _token = $("input[name='_token']").val();

                  $.post("",{u_account:u_account,u_pwd:u_pwd,_token:_token},function (jsonMsg) {
                      // console.log(jsonMsg);return false;
                      var objMsg = $.parseJSON(jsonMsg);
                      if(objMsg.errorCode == 200){
                          location.href="/admin";
                      }else{
                          alert('登录失败');
                      }
                  });
                return false;
              });
            });
        })
    </script>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>