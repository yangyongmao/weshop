<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米商城-个人中心</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/style.css">
	</head>
	<body>
	<!-- start header -->
		@include('index.layouts.header');
	<!--end header -->
	<!-- start banner_x -->
		{{--@include('index.layouts.navx');--}}
<!-- end banner_x -->
<!-- self_info -->
		@include('index.layouts.personleft')


		<div class="rtcont fr">
			<div class="grzlbt ml40">我的资料  &nbsp;&nbsp;<a href="updatemyself" style="font-size: 13px;color: #1d643b;">编辑</a></div>
			<div class="subgrzl ml40"><span>昵称</span><span>{{$thisUser['uname']}}</span></div>
			<div class="subgrzl ml40"><span>手机号</span><span>{{$thisUser['uphone']}}</span></div>
			<div class="subgrzl ml40"><span>密码</span><span>************</span></div>
			<div class="subgrzl ml40">
				<span>收货地址</span>
				<span  style="width: 450px;">{{$address->a_country}} {{$address->a_province}} {{$address->a_city}} {{$address->a_sec_city}} {{$address->a_town}} {{$address->a_info}}
				</span>
			</div>
		</div>
		<div class="clear"></div>
		</div>
	</div>
<!-- self_info -->
		
		<footer class="mt20 center">			
			<div class="mt20">小米商城|MIUI|米聊|多看书城|小米路由器|视频电话|小米天猫店|小米淘宝直营店|小米网盟|小米移动|隐私政策|Select Region</div>
			<div>©mi.com 京ICP证110507号 京ICP备10046444号 京公网安备11010802020134号 京网文[2014]0059-0009号</div> 
			<div>违法和不良信息举报电话：185-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</div>
		</footer>
	</body>
</html>