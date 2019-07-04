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


	<div class="gwcxqbj" style="height: auto;">
		<div class="gwcxd center">
			<div class="top2 center">
				<div class="sub_top fl">
					<input type="checkbox" value="quanxuan" class="quanxuan" title="点击全选" />全选
				</div>
				<div class="sub_top fl">商品名称</div>
				<div class="sub_top fl" >单价</div>

				<div class="clear"></div>
			</div>

			@foreach($data as  $v)
				<div class="content2 center">
					<div class="sub_content fl ">
						<input type="checkbox" value="" data-carid="" data-goods_id="" data-goods_price="" class="quanxuan" title=""/>
					</div>
					<div class="sub_content fl">
						{{--@foreach($v->order as $val)--}}
						<img src="{{asset('/storage/goodsImg/'.$v->goods_img)}}" width="100px" height="100px">
							{{--@endforeach--}}
					</div>
					<div class="sub_content fl ft20">{{$v->goods_name}}</div>
					<div class="sub_content fl ft20">{{$v->goods_price}}</div>


					<div class="clear"></div>
				</div>
			@endforeach

		</div>

			<div class="jiesuandan mt20 center">
				<div class="tishi fl ml20">
					<ul>
						<li><a href="/">继续购物</a></li>
						{{--<li>|</li>--}}
						{{--<li>下单时间:</li>--}}
						<div class="clear"></div>
					</ul>
				</div>
				<div class="jiesuan fr">
					<div class="jiesuanjiage fl">合计（不含运费）：<span id="money">{{$v->o_price}}元</span></div>
					<div class="jsanniu fr"><input class="jsan" type="button" name="jiesuan"  value="去支付"/></div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>


















			{{--<div class="gwcxqbj" style="height: auto;">--}}
				{{--<div class="gwcxd center" >--}}
					{{--<div class="top2 center" >--}}
			{{--<div class="gwcxd center" >--}}
				{{--<div class="top2 center"  >--}}
					{{--<div style="width: 100px;"></div>--}}
					{{--<div class="sub_top fl" style="width: 70px;"></div>--}}
					{{--<div class="sub_top fl" ></div>--}}
					{{--<div class="sub_top fl"></div>--}}
					{{--<div class="sub_top fl"></div>--}}
					{{--<div class="sub_top fl"></div>--}}
					{{--<div class="clear"></div>--}}
				{{--</div>--}}
				{{--<div >--}}
					{{--<div >--}}
						{{--<div>--}}

						{{--</div>--}}
					{{--</div>--}}

					{{--<div style="float: left; margin-left: 100px;">商品名称</div>--}}
					{{--<div style="float: left; margin-left: 100px;">商品数量</div>--}}
					{{--<div style="float: left; margin-left: 100px;">商品价格</div>--}}
					{{--<div style="float: left; margin-left: 100px;">商品状态</div>--}}

				{{--</div>--}}
				{{--@foreach($data as  $v)--}}
					{{--<div class="content2 center" style="text-align: center; margin-top: 80px;" >--}}
						{{--<div style="float: left">--}}
							{{--<div>--}}
								{{--<img src="{{asset('/storage/goodsImg/'.$v->goods_img)}}" style=" margin-top: 10px;" width="100px" height="100px" alt="">--}}
							{{--</div>--}}
						{{--</div>--}}

							{{--<div style="float: left; margin-left: 120px; width: auto; margin-top: 40px;">{{$v->goods_name}}</div>--}}
							{{--<div style="float: left; margin-left: 120px; width: auto; margin-top: 40px;">{{$v->o_total}}</div>--}}
							{{--<div style="float: left; margin-left: 120px; width: auto; margin-top: 40px;">{{$v->o_price}}</div>--}}
							{{--<div style="float: left; margin-left: 120px; width: auto; margin-top:40px;">--}}

								{{--@if($v->o_status == 1 )--}}
									{{--未支付--}}
								{{--@elseif($v->o_status == 2)--}}
									{{--已支付--}}
								{{--@endif--}}
							{{--</div>--}}

					{{--</div>--}}
				{{--@endforeach--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			{{--</div>--}}

	{{--</div>--}}
<!-- self_info -->
		
		<footer class="mt20 center">			
			<div class="mt20">小米商城|MIUI|米聊|多看书城|小米路由器|视频电话|小米天猫店|小米淘宝直营店|小米网盟|小米移动|隐私政策|Select Region</div>
			<div>©mi.com 京ICP证110507号 京ICP备10046444号 京公网安备11010802020134号 京网文[2014]0059-0009号</div> 
			<div>违法和不良信息举报电话：185-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</div>
		</footer>
	</body>
</html>