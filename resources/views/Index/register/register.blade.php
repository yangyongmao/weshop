<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/login.css">

	</head>
	<body>
		<form  method="post" action="./regist.php">
		<div class="regist" id="regist">
			<div class="regist_center">

				<div class="regist_top">
					<div class="left fl">会员注册</div>
					<div class="right fr"><a href="" target="_self">小米商城</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>

				<div class="regist_main center">
					<div class="username">用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;
						<input class="shurukuang" type="text" v-model="uname" placeholder="请输入你的用户名"/>
						<span>请不要输入汉字</span>
					</div>

					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" v-model="upwd" placeholder="请输入你的密码"/>
						<span>请输入6位以上字符</span>
					</div>
					
					<div class="username">确认密码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" v-model="upwd_again" placeholder="请确认你的密码"/>
						<span>两次密码要输入一致哦</span>
					</div>

					<div class="username">电子邮箱:&nbsp;&nbsp;
						<input class="shurukuang" type="password" v-model="uemail" placeholder="请输入你的邮箱"/>
						<span>请填写您的电子邮件</span>
					</div>

					<div class="username">手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;
						<input class="shurukuang" type="text" v-model="uphone" placeholder="请填写正确的手机号"/>
						<span>填写下手机号吧，方便我们联系您！</span>
					</div>

					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;
							<input class="yanzhengma" type="text" v-model="captch" placeholder="请输入验证码"/>
						</div>
						<div class="right fl"><img src="{{Captcha::src()}}"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="regist_submit">
					<input class="submit" type="button" value="立即注册" @click="regist()">
				</div>
			</div>
		</div>
		</form>
	</body>
</html>
<script src="/indexStatic/js/vue.js"></script>
{{--<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>--}}
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script>
	var regist = new Vue({
		el:'#regist',
		data:{
		    uname:'',
			upwd:'',
			upwd_again:'',
			uemail:'',
			uphone:'',
			captch:'',
		},
		methods:{
		    regist:function () {
				this.$http.post("",{captch: this.captch},{emulateJSON:true}).then(function (jsonMsg) {
                    // document.write(jsonMsg);
					console.log(jsonMsg)

                },function (jsonMsg) {
					document.write(jsonMsg);
                });
            }
		    
		}



	});
</script>