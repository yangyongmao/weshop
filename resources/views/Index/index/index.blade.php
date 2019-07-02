<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米商城</title>
		<link rel="stylesheet" type="text/css" href="/indexStatic/css/style.css">
		<script src="/indexStatic/js/index/index.js"></script>
		<script type="text/javascript" src="/adminStatic/lib/layui/layui.js" charset="utf-8"></script>
		<script type="text/javascript" src="/adminStatic/js/xadmin.js"></script>

            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    </head>
    <body>
    <!-- start header -->
	@include('index.layouts.header');
	<!--end header -->

	<!-- start banner_x -->
	@include('index.layouts.navx');
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
				<div class="fl"><a href="https://miaosha.jd.com/"><img src="/indexStatic/image/hjh_03.gif"></a></div>
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
		</div>
	<div class="danpin center">

		<div class="biaoti center">秒杀单品</div>
		<div class="main center">
			@foreach($purchase as $v)
				<div class="mingxing fl">
					<div class="sub_mingxing"><a href="goodsdetail?goods_id={{$v->goods_id}}"><img src="{{asset("/storage/goodsImg/".$v->goods_img)}}" alt=""></a></div>
					<div class="pinpai"><a href="goodsdetail?goods_id={{$v->goods_id}}" >{{$v->goods_name}}</a></div>
					{{--<div class="youhui">{{$v->goods_desc}}</div>--}}
					<div class="jiage">￥{{$v->new_money}}</div>
					<div class="jiage">{{date("Y-m-d H:i:s",$v->start)}}</div>
					<div class="jiage">|</div>
					<div class="jiage">{{date("Y-m-d H:i:s",$v->end)}}</div>
					@if($v->goods_number>0)

					<div style="width: 50px;margin-left: 93px; text-align: center"  ><a title="抢购" onclick="member_del(this,'{{$v->goods_id}}')" href="javascript:;">
							<button  class="layui-icon">抢购</button>
						</a></div>
					@else
						<div  style="color: #000000;background-color: #ccc;width: 50px;margin-left: 93px; text-align: center;cursor:not-allowed" >已售空</div>
					@endif
				</div>
			@endforeach
			<div class="clear"></div>
		</div>
	</div>
		{{--<div class="peijian w">--}}
			{{--<div class="biaoti center">配件</div>--}}
			{{--<div class="main center">--}}
				{{--<div class="content">--}}
					{{--<div class="remen fl"><a href=""><img src="./image/peijian1.jpg"></a>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span>新品</span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian2.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">小米6 硅胶保护套</a></div>--}}
						{{--<div class="jiage">49元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
						{{--<div class="piao">--}}
							{{--<a href="">--}}
								{{--<span>发货速度很快！很配小米6！</span>--}}
								{{--<span>来至于mi狼牙的评价</span>--}}
							{{--</a>--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:#fff"></span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian3.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">小米手机4c 小米4c 智能</a></div>--}}
						{{--<div class="jiage">29元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:red">享6折</span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian4.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">红米NOTE 4X 红米note4X</a></div>--}}
						{{--<div class="jiage">19元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
						{{--<div class="piao">--}}
							{{--<a href="">--}}
								{{--<span>发货速度很快！很配小米6！</span>--}}
								{{--<span>来至于mi狼牙的评价</span>--}}
							{{--</a>--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:#fff"></span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian5.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">小米支架式自拍杆</a></div>--}}
						{{--<div class="jiage">89元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
						{{--<div class="piao">--}}
							{{--<a href="">--}}
								{{--<span>发货速度很快！很配小米6！</span>--}}
								{{--<span>来至于mi狼牙的评价</span>--}}
							{{--</a>--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div class="clear"></div>--}}
				{{--</div>--}}
				{{--<div class="content">--}}
					{{--<div class="remen fl"><a href=""><img src="./image/peijian6.png"></a>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:#fff"></span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian7.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">小米指环支架</a></div>--}}
						{{--<div class="jiage">19元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
						{{--<div class="piao">--}}
							{{--<a href="">--}}
								{{--<span>发货速度很快！很配小米6！</span>--}}
								{{--<span>来至于mi狼牙的评价</span>--}}
							{{--</a>--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:#fff"></span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian8.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">米家随身风扇</a></div>--}}
						{{--<div class="jiage">19.9元</div>--}}
						{{--<div class="pingjia">372人评价</div>--}}
					{{--</div>--}}
					{{--<div class="remen fl">--}}
						{{--<div class="xinpin"><span style="background:#fff"></span></div>--}}
						{{--<div class="tu"><a href=""><img src="./image/peijian9.jpg"></a></div>--}}
						{{--<div class="miaoshu"><a href="">红米4X 高透软胶保护套</a></div>--}}
						{{--<div class="jiage">59元</div>--}}
						{{--<div class="pingjia">775人评价</div>--}}
					{{--</div>--}}
					{{--<div class="remenlast fr">--}}
						{{--<div class="hongmi"><a href=""><img src="./image/hongmin4.png" alt=""></a></div>--}}
						{{--<div class="liulangengduo"><a href=""><img src="./image/liulangengduo.png" alt=""></a></div>					--}}
					{{--</div>--}}
					{{--<div class="clear"></div>--}}
				{{--</div>				--}}
			{{--</div>--}}
		{{--</div>--}}
		<footer class="mt20 center">			
			<div class="mt20">小米商城|MIUI|米聊|多看书城|小米路由器|视频电话|小米天猫店|小米淘宝直营店|小米网盟|小米移动|隐私政策|Select Region</div>
			<div>©mi.com 京ICP证110507号 京ICP备10046444号 京公网安备11010802020134号 京网文[2014]0059-0009号</div> 
			<div>违法和不良信息举报电话：185-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</div>
		</footer>
	</body>
</html>
<script src="/indexStatic/js/jquery-1.4.3.js"></script>
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
    });
    function member_del(obj,goods_id){
            //发异步删除数据
            $.get('index/add',{goods_id:goods_id},function(res){
                // console.log(res);return false;
                if(res==2){
                    alert('抢购成功');
                }else if(res==3){
                   alert('抢购失败');
                }else{
                    alert('您还没有登录，请先去登录');
				}
            });
    }
    $("button").click(function(){
        $(this).attr("disabled","disabled");
    });
</script>