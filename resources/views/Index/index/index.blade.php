<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米商城</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/style.css">
		<script src="/indexStatic/js/index/index.js"></script>
	</head>
	<body>
	<!-- start header -->
	@include('index.layouts.header')
	<!--end header -->

	<!-- start banner_x -->
	@include('index.layouts.navx')
	<!-- end banner_x -->

	<!-- start banner_y -->
		<div class="banner_y center">
			<div class="nav">				
				<ul>
					@foreach($catGoods as $k=>$v)
					<li>
						<a href="/goodslist?cat_id={{$v['cat_id']}}">{{$v['cat_name']}}</a>
						<div class="pop">
							<div class="left fl">

								@foreach( $v['goods'] as $key=>$val )
								<div style="margin-bottom: 4px;">
									<div class="xuangou_left fl">
										<a href="/goodsdetail?goods_id={{$val['goods_id']}}">
											<div class="img fl">
												<img src="{{asset('/storage/goodsImg/'.$val['goods_img'])}}" width="50px" height="80px" alt="">
											</div>
											<span class="fl">{{$val['goods_name']}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<div class="xuangou_right fr"><a href="/goodsdetail?goods_id={{$val['goods_id']}}" target="_blank">选购</a></div>
									<div class="clear"></div>
								</div>
								@endforeach

							</div>

						</div>
					</li>
					@endforeach
				</ul>
			</div>
		
		</div>	

		<div class="sub_banner center">
			<div class="sidebar fl">
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_01.gif"></a></div>
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_02.gif"></a></div>
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_03.gif"></a></div>
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_04.gif"></a></div>
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_05.gif"></a></div>
				<div class="fl"><a href=""><img src="/indexStatic/image/hjh_06.gif"></a></div>
				<div class="clear"></div>
			</div>

			<div class="datu fl"><a href=""><img src="/indexStatic/image/hongmi4x.png" alt=""></a></div>
			<div class="datu fl"><a href=""><img src="/indexStatic/image/xiaomi5.jpg" alt=""></a></div>
			<div class="datu fr"><a href=""><img src="/indexStatic/image/pinghengche.jpg" alt=""></a></div>
			<div class="clear"></div>

		</div>
	<!-- end banner -->
	<div class="tlinks">Collect from <a href="http://www.cssmoban.com/" >企业网站模板</a></div>

	<!-- start danpin -->
		<div class="danpin center">
			
			<div class="biaoti center">小米明星单品</div>
			<div class="main center">
				@foreach($recommend as $v)
				<div class="mingxing fl">
					<div class="sub_mingxing"><a href="goodsdetail?goods_id={{$v->goods_id}}"><img src="{{asset("/storage/goodsImg/".$v->goods_img)}}" alt=""></a></div>
					<div class="pinpai"><a href="goodsdetail?goods_id={{$v->goods_id}}">{{$v->goods_name}}</a></div>
					<div class="youhui">{{$v->goods_desc}}</div>
					<div class="jiage">{{$v->goods_price}}</div>
				</div>
				@endforeach
				<div class="clear"></div>
			</div>

			<div class="biaoti center">优惠券专区</div>
			<div class="main center">

				@foreach($discount as $k => $v)
					<a href="javascript:;" class="getDiscount" data-discount_id="{{$v->id}}">
						<div class="stamp stamp0{{($k+1)%4}}">
							<div class="par"><p>{{$v->name}}</p><sub class="sign">￥</sub><span>{{$v->money}}</span><sub>优惠券</sub><p>满100.00元且不低于优惠券面值</p></div>
							<div class="copy">副券<p>{{date('Y-m-d',$v->start)}}<br>{{date('Y-m-d',$v->end)}}</p></div>
							<i></i>
						</div>
					</a>
				@endforeach

				<div class="clear"></div>
			</div>

		</div>

		<footer class="mt20 center">			
			<div class="mt20">小米商城|MIUI|米聊|多看书城|小米路由器|视频电话|小米天猫店|小米淘宝直营店|小米网盟|小米移动|隐私政策|Select Region</div>
			<div>©mi.com 京ICP证110507号 京ICP备10046444号 京公网安备11010802020134号 京网文[2014]0059-0009号</div> 
			<div>违法和不良信息举报电话：185-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</div>
		</footer>

	</body>
</html>

<script src="/indexStatic/js/jquery-3.4.1.js"></script>
<script>

	//领取优惠券
	$(".getDiscount").on('click',function () {
		let discount_id = $(this).attr('data-discount_id');

		$.get('/getdiscount',{discount_id:discount_id},function (jsonMsg) {
			if(jsonMsg.errorCode == 501){
				alert('请先登录');
				location.href = '/login';
			}else {
			    alert(jsonMsg.errorMsg);
			}
        });
    });


</script>