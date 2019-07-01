<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/login.css">

	</head>
	<body>
		<form  method="post" action="">
		<div class="regist" id="regist">
			<div class="regist_center">

				<div class="regist_top">
					<div class="left fl">会员注册</div>
					<div class="right fr"><a href="http://weshop.io" target="_self">小米商城</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>

				<div class="regist_main center">
					<div class="username">用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;
						<input class="shurukuang" type="text" v-model="uname" placeholder="请输入你的用户名" name="uname"/>
						<span>请不要输入汉字</span>
					</div>

					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" v-model="upwd" placeholder="请输入你的密码" name="upwd"/>
						<span>请输入6位以上字符</span>
					</div>
					
					<div class="username">确认密码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" v-model="upwd_again" placeholder="请确认你的密码" name="upwd_confirm"/>
						<span>两次密码要输入一致哦</span>
					</div>

					<div class="username">电子邮箱:&nbsp;&nbsp;
						<input class="shurukuang" type="email" v-model="uemail" placeholder="请输入你的邮箱" name="uemail"/>
						<span>请填写您的电子邮件</span>
					</div>

					<div class="username">手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;
						<input class="shurukuang" type="text" v-model="uphone" placeholder="请填写正确的手机号" name="uphone"/>
						<span>填写下手机号吧，方便我们联系您！</span>
					</div>

					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;
							<input class="yanzhengma" type="text" v-model="captcha" placeholder="请输入验证码" name="captch"/>
						</div>
						<div class="right fl"><img src="{{Captcha::src()}}"></div>
						<div class="clear"></div>
					</div>
				</div>
				@csrf
				<div class="regist_submit">
					<input class="submit submit-form" type="button" value="立即注册">
				</div>
			</div>
		</div>
		</form>
	</body>
</html>
<script src="/indexStatic/js/vue.js"></script>
<script src="/indexStatic/js/jquery-3.4.1.js"></script>
{{--<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>--}}
{{--<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>--}}
<script>

	$(".submit-form").on('click',function () {
		let uname = $("input[name='uname']").val();
		let upwd = $("input[name='upwd']").val();
		let uemail = $("input[name='uemail']").val();
		let uphone = $("input[name='uphone']").val();
		let usex = $("input[name='usex']").val();
		let captcha = $("input[name='captch']").val();
		let _token = $("input[name='_token']").val();

		if(uname == '' || upwd == '' || uemail == '' || uphone == '' || usex == ''){
		    alert('请输入每一条信息');return false;
		}

		let form = {uname:uname,upwd:upwd,uemail:uemail,uphone:uphone,captcha:captcha,_token:_token};

		$.post('',form,function (jsonMsg) {
			let objMsg = $.parseJSON(jsonMsg);
			if(objMsg.errorCode == 500){
				alert('验证码有误');return false;
			}else if(objMsg.errorCode == 200){
				location.href = 'login';
			}else{
			    alert('注册失败');return false;
			}
        });



    });





	// var regist = new Vue({
	// 	el:'#regist',
	// 	data:{
	// 	    uname:'',
	// 		upwd:'',
	// 		upwd_again:'',
	// 		uemail:'',
	// 		uphone:'',
	// 		captch:'',
	// 	},
	// 	methods:{
	// 	    regist:function () {
	// 			this.$http.post("",{captch: this.captch},{emulateJSON:true}).then(function (jsonMsg) {
    //                 // document.write(jsonMsg);
	// 				console.log(jsonMsg)
	//
    //             },function (jsonMsg) {
	// 				document.write(jsonMsg);
    //             });
    //         }
	//
	// 	}
	// });
</script>