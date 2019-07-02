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

	<!-- end banner_x -->
	<!-- self_info -->
		@include('index.layouts.personleft')


		<form action="updatemyself" method="post" enctype="multipart/form-data">
		<div class="rtcont fr">
			<div class="grzlbt ml40">编辑我的资料</div>
			<div class="subgrzl ml40">
				<span>昵称</span>
				<input type="text" class="" name="uname" value="{{$thisUser['uname']}}" style="width: auto;height: 20px;border-left-width:0px;border-top-width:0px;border-right-width:0px;border-bottom-color:green;" disabled>
			</div>
			<div class="subgrzl ml40"><span>手机号</span>
				<input type="text" class="" name="uphone" value="{{$thisUser['uphone']}}" style="width: auto;height: 20px;border-left-width:0px;border-top-width:0px;border-right-width:0px;border-bottom-color:green;">
			</div>
			<div class="subgrzl ml40">
				<span>密码</span>
				<input type="text" class="" name="upwd" value="{{$thisUser['upwd']}}" style="width: 300px;height: 20px;border-left-width:0px;border-top-width:0px;border-right-width:0px;border-bottom-color:green;">
			</div>
			<div class="subgrzl ml40">
				<span>邮箱</span>
				<input type="text" class="" name="uemail" value="{{$thisUser['uemail']}}" style="width: 300px;height: 20px;border-left-width:0px;border-top-width:0px;border-right-width:0px;border-bottom-color:green;">
			</div>
			<div class="subgrzl ml40">
				<span>性别</span>
				<input type="radio" class="" name="usex" value="1" checked>男
				<input type="radio" class="" name="usex" value="2">女
			</div>
			<div class="subgrzl ml40">
				<span>头像</span>
				<input type="file" class="" name="uheader" style="width: 300px;height: 20px;border-left-width:0px;border-top-width:0px;border-right-width:0px;border-bottom-color:green;">
				<img src="{{asset('/storage/userhead'.$thisUser['uheader'])}}" style="width: 50px;height: 50px;border-radius: 50%;float: left;position: absolute;">
			</div>
			<div class="subgrzl ml40">
				<span>收货地址</span>

				<span class="addr_select" style="width: 700px;">

					<select name="addr_1" id="addr_1">
						<option value="0">请选择...</option>
						@foreach($addr as $k => $v)
								<option value="{{$v->area_id}}">{{$v->area_name}}</option>
						@endforeach
					</select>

					<select name="addr_2" id="addr_2">
						<option value="0">请选择...</option>
					</select>

					<select name="addr_3" id="addr_3">
						<option value="0">请选择...</option>
					</select>

					<select name="addr_4" id="addr_4">
						<option value="0">请选择...</option>
					</select>

					<input type="text" name="addr_5" id="addr_5" placeholder="请输入村庄、街道等信息..." style="width: 200px;height:20px;margin-bottom: 1px;">

				</span>
			</div>
			<div style="margin-left: 100px;">
				<button id="sure_update">保存编辑</button>
				<button id="no_update" type="button">取消编辑</button>
			</div>
		</div>
			<input type="hidden" name="uid" value="{{$thisUser['uid']}}">@csrf
			</form>

			<div class="clear"></div>
		</div>
	</div>
<!-- self_info -->
		{{--<footer class="mt20 center">			--}}
			{{--<div class="mt20">小米商城|MIUI|米聊|多看书城|小米路由器|视频电话|小米天猫店|小米淘宝直营店|小米网盟|小米移动|隐私政策|Select Region</div>--}}
			{{--<div>©mi.com 京ICP证110507号 京ICP备10046444号 京公网安备11010802020134号 京网文[2014]0059-0009号</div> --}}
			{{--<div>违法和不良信息举报电话：185-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</div>--}}
		{{--</footer>--}}
	</body>
</html>
<script src="/indexStatic/js/jquery-3.4.1.js"></script>
<script>

	//提交更新
	$("#sure_update").click(function () {
	    let addr_1 = $("#addr_1").val();
	    let addr_2 = $("#addr_2").val();
	    let addr_3 = $("#addr_3").val();
	    let addr_4 = $("#addr_4").val();
	    let addr_5 = $("#addr_5").val();

	    if(addr_1==0 || addr_2==0 || addr_3==0 || addr_4==0 || addr_5==0){
	        alert("请选择默认收货地址");return false;
		}
    });

	//取消编辑
	$("#no_update").click(function () {
		history.back(-1);
    });

	//一级地址被选中
	$("#addr_1").on('change',function () {
		let area_id = $(this).val();
		if(area_id == 0){
		    alert("请选择地址");
		}else{
		    let option = '';
		    $.get('/getaddr',{area_id:area_id},function (jsonMsg) {
				let objMsg = $.parseJSON(jsonMsg);
				$.each(objMsg,function (k,v) {
					option += 	"<option value=\""+v.area_id+"\">"+v.area_name+"</option>";
                });
				$("#addr_2").empty().append("<option value=\"0\">请选择...</option>\n");
				$("#addr_3").empty().append("<option value=\"0\">请选择...</option>\n");
				$("#addr_4").empty().append("<option value=\"0\">请选择...</option>\n");

				$("#addr_2").append(option);
            });
		}
    });

	//二级地址被选中
    $("#addr_2").on('change',function () {
        let area_id = $(this).val();
        if(area_id == 0){
            alert("请选择地址");
        }else{
            let option = '';
            $.get('/getaddr',{area_id:area_id},function (jsonMsg) {
                let objMsg = $.parseJSON(jsonMsg);
                $.each(objMsg,function (k,v) {
                    option += 	"<option value=\""+v.area_id+"\">"+v.area_name+"</option>";
                });
                $("#addr_3").empty().append("<option value=\"0\">请选择...</option>\n");
                $("#addr_4").empty().append("<option value=\"0\">请选择...</option>\n");

                $("#addr_3").append(option);
            });
        }
    });

    //三级地址被选中
    $("#addr_3").on('change',function () {
        let area_id = $(this).val();
        if(area_id == 0){
            alert("请选择地址");
        }else{
            let option = '';
            $.get('/getaddr',{area_id:area_id},function (jsonMsg) {
                let objMsg = $.parseJSON(jsonMsg);
                $.each(objMsg,function (k,v) {
                    option += 	"<option value=\""+v.area_id+"\">"+v.area_name+"</option>";
                });
                $("#addr_4").empty().append("<option value=\"0\">请选择...</option>\n");
                $("#addr_4").append(option);
            });
        }
    });




</script>