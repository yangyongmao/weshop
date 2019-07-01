<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>会员登录</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/login.css">
	</head>
	<body>
		<!-- login -->
		<div class="top center">
			<div class="logo center">
				<a href="http://weshop.io" target=""><img src="/indexStatic/image/mistore_logo.png" alt=""></a>
			</div>
		</div>
		<form  method="post" action="" class="form center">
		<div class="login">
			<div class="login_center">
				<div class="login_top">
					<div class="left fl">会员登录</div>
					<div class="right fr">您还不是我们的会员？<a href="register" target="_self">立即注册</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="login_main center">
					<div class="username">用户名:&nbsp;<input class="shurukuang" type="text" name="uname" placeholder="请输入你的用户名"/></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input class="shurukuang" type="password" name="upwd" placeholder="请输入你的密码"/></div>
					<div class="username">
						<div class="left fl">验证码:&nbsp;<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码"/></div>
						<div class="right fl">
							<img src="{{Captcha::src()}}" alt="" class="captcha">
                        </div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="login_submit">
					<input class="submit" type="button" name="submit" value="立即登录" >
				</div>
			</div>
		</div>
		</form>
		<footer>
			<div class="copyright">简体 | 繁体 | English | 常见问题</div>
			<div class="copyright">小米公司版权所有-京ICP备10046444-<img src="/indexStatic/image/ghs.png" alt="">京公网安备11010802020134号-京ICP证110507号
			</div>
		</footer>
	</body>
</html>
<script src="/indexStatic/js/jquery-3.4.1.js"></script>
<script>

    /**
	 * 提交登录事件
     */
	$("input[type='button']").on('click',function () {
		$.post("login",{uname:$("input[name='uname']").val(),upwd:$("input[name='upwd']").val(),captcha:$("input[name='captcha']").val()},function (jsonMsg) {
			let objMsg = $.parseJSON(jsonMsg);
			console.log(objMsg);
			if(objMsg.errorCode != 200){
				alert(objMsg.errorMsg);
				location.href = '';
				return false;
			}
			location.href = "http://weshop.io/";
		});
    })	;

    /**
	 * 点击验证码
     */
    $(".captcha").on('click',function () {
		window.location.reload();
    });


</script>