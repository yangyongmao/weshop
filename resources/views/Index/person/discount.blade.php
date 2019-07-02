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
		@include('index.layouts.header')
	<!--end header -->
	<!-- start banner_x -->
		{{--@include('index.layouts.navx');--}}
	<!-- end banner_x -->
	<!-- self_info -->
		@include('index.layouts.personleft')

		<!--模块1-->
		<div class="rtcont fr">
			<div class="grzlbt ml40">我的优惠券</div>
			@foreach($unusedDiscount as $k => $v)
				<div class="subgrzl ml40" style="background-color: limegreen;">
					<span style="width: 110px;">{{$v->name}}</span>
					<span style="">开始{{date("Y-m-d",$v->start)}} - 截止{{date("Y-m-d",$v->end)}}</span>
					<span>未使用</span>
					<span style="">￥{{$v->money}}</span>
				</div>
			@endforeach

			<div class="grzlbt ml40">已失效的优惠券</div>
			@foreach($overdue as $k => $v)
				<div class="subgrzl ml40" style="background-color: #b0b0b0;">
					<span style="width: 110px;">{{$v->name}}</span>
					<span style="">开始{{date("Y-m-d",$v->start)}} - 截止{{date("Y-m-d",$v->end)}}</span>
					<span>已失效</span>
					<span style="">￥{{$v->money}}</span>
				</div>
			@endforeach
		</div>
		<div class="clear"></div>
		<!--模块1end-->

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