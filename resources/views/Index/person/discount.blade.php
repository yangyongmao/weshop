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
	<div class="grzxbj">
		<div class="selfinfo center">
		<div class="lfnav fl">
			<div class="ddzx">订单中心</div>
			<div class="subddzx">
				<ul>
					<li><a href="./dingdanzhongxin.html" >我的订单</a></li>
					<li><a href="">意外保</a></li>
					<li><a href="">团购订单</a></li>
					<li><a href="">评价晒单</a></li>
				</ul>
			</div>
			<div class="ddzx">个人中心</div>
			<div class="subddzx">
				<ul>
					<li><a href="me">我的个人中心</a></li>
					<li><a href="">消息通知</a></li>
					<li><a href="discount"  style="color:#ff6700;font-weight:bold;">优惠券</a></li>
					<li><a href="">收货地址</a></li>
				</ul>
			</div>
		</div>
		<div class="rtcont fr">

			<div class="grzlbt ml40">我的优惠券</div>
			@foreach($data as $k => $v)
				<div class="subgrzl ml40" style="{{$v->status==2?'background-color: #c8c8c8':'background-color: greenyellow'}}">
					<span style="width: 110px;">{{$v->name}}</span>
					<span style="">{{date("Y-m-d",$v->start)}} - {{date("Y-m-d",$v->end)}}</span>
					<span>{{$v->statusinfo}}</span>
					<span style="">￥{{$v->money}}</span>
				</div>
			@endforeach

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