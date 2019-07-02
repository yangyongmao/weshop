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


<div class="rtcont fr" style="overflow-y:scroll">

    <div class="grzlbt ml40">我的收藏夹</div>
    <div class="danpin center">
        <div class="main center">
            @foreach($collectionList as $k => $v)
            <div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
                <div class="sub_mingxing"><a href="goodsdetail?goods_id={{$v->goods_id}}" target="_blank"><img src="{{asset("/storage/goodsImg/".$v->goods_img)}}" alt=""></a></div>
                <div class="pinpai"><a href="goodsdetail?goods_id={{$v->goods_id}}" target="_blank">{{$v->goods_name}}</a></div>
                <div class="jiage">{{$v->goods_price}}元</div><br>
                <div class="jiage"><button class="delcollec" data-collection_id="{{$v->id}}">取消收藏</button></div>
            </div>
            @endforeach
            <div class="clear"></div>
        </div>
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
<script src="/indexStatic/js/jquery-3.4.1.js"></script>
<script>

    //收藏
    $(".delcollec").on('click',function () {
        let collecid = $(this).attr('data-collection_id');
        // $.get("collection",)
        var _this = $(this);
        $.ajax({
            url:'delcollect',
            data:{collecid:collecid},
            type:'get',
            dataType:'json',
            success:function(e){
                if(e.code == 1){
                    _this.parent().parent().remove();
                    alert(e.msg);
                }else{
                    alert(e.msg);
                }
            }
        })


    });

</script>