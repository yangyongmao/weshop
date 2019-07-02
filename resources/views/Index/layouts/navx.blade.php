<div class="banner_x center">
    <a href="./index.html" target="_blank"><div class="logo fl"></div></a>
    <a href=""><div class="ad_top fl"></div></a>
    <div class="nav fl">
        <ul>
            <li><a href="goodslist?cat_id=1&brand_id=1&sear_title=小米手机" target="_blank">小米手机</a></li>
            <li><a href="goodslist?cat_id=1&brand_id=2&sear_title=红米手机" target="_blank">红米</a></li>
            <li><a href="">平板·笔记本</a></li>
            <li><a href="goodslist?cat_id=3&brand_id=1&sear_title=小米电视" target="_blank">电视</a></li>
            <li><a href="">盒子·影音</a></li>
            <li><a href="">路由器</a></li>
            <li><a href="">智能硬件</a></li>
            <li><a href="">服务</a></li>
            <li><a href="">社区</a></li>
        </ul>
    </div>
    <div class="search fr">
        <form action="seargoodslist" method="get">
            <div class="text fl">
                <input type="text" class="shuru"  name="sear_name" placeholder="小米9&nbsp;红米Note现货" value="{{isset($searValue)?$searValue:''}}">
            </div>
            <div class="submit fl">
                <input type="submit" class="sousuo" value="搜索"/>
            </div>
            <div class="clear"></div>
        </form>
        <div class="clear"></div>
    </div>
</div>