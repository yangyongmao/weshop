<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/adminStatic/css/font.css">
        <link rel="stylesheet" href="/adminStatic/css/xadmin.css">
        <script type="text/javascript" src="/adminStatic/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/adminStatic/js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
        <form action="goodsUpdGoods" method="post">
            @csrf
            <div class="layui-row">
                <input type="hidden" value="{{$goodsList->goods_id}}" name="goods_id" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          分类:
                      </label>
                      <div class="layui-form-mid layui-word-aux">
                          <select name="cat_id" id="">
                              <option value="0">顶级分类</option>
                              @foreach( $catList as $k => $v )
                                  <?php if( $goodsList->cat_id == $v->cat_id ){ ?>
                                      <option value="{{$v->cat_id}}" selected="selected">{{$v->cat_name}}</option>
                                  <?php }else{ ?>
                                      <option value="{{$v->cat_id}}">{{$v->cat_name}}</option>
                                  <?php }?>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          品牌:
                      </label>
                      <div class="layui-form-mid layui-word-aux">
                          <select name="brand_id" id="">
                              @foreach( $brandList as $k => $v )
                                  <?php if( $goodsList->brand_id == $v->brand_id ){ ?>
                                  <option value="{{$v->brand_id}}" selected="selected">{{$v->brand_name}}</option>
                                  <?php }else { ?>
                                  <option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                                  <?php } ?>
                              @endforeach
                          </select>
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            库存:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->goods_number}}" name="goods_number" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            警告库存:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->warn_number}}" name="warn_number" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            商品重量:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->goods_weight}}" name="goods_weight" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            售价:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->goods_price}}" name="goods_price" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            描述:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->goods_brief}}" name="goods_brief" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            详细描述:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->goods_desc}}" name="goods_desc" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            商品图片:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            {{--{{$goodsList->goods_brief}}--}}
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            是否上架:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <?php if( $goodsList->is_on_sale == 1 ){ ?>
                                <input type="radio" name="is_on_sale" value="1" checked="checked">是
                                <input type="radio" name="is_on_sale" value="2">否
                            <?php }elseif($goodsList->is_on_sale == 2){ ?>
                                <input type="radio" name="is_on_sale" value="1">是
                                <input type="radio" name="is_on_sale" value="2" checked="checked">否
                            <?php } ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            排序:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->sort}}" name="sort" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            是否推荐:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <div class="layui-form-mid layui-word-aux">
                                <?php if( $goodsList->is_best == 1 ){ ?>
                                    <input type="radio" name="is_best" value="1" checked="checked">是
                                    <input type="radio" name="is_best" value="2">否
                                <?php }elseif($goodsList->is_best == 2){ ?>
                                    <input type="radio" name="is_best" value="1">是
                                    <input type="radio" name="is_best" value="2" checked="checked">否
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            是否新品:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <?php if( $goodsList->is_new == 1 ){ ?>
                                <input type="radio" name="is_new" value="1" checked="checked">是
                                <input type="radio" name="is_new" value="2">否
                            <?php }elseif($goodsList->is_new == 2){ ?>
                                <input type="radio" name="is_new" value="1">是
                                <input type="radio" name="is_new" value="2" checked="checked">否
                            <?php } ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            是否热销:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <?php if( $goodsList->is_hot == 1 ){ ?>
                                <input type="radio" name="is_hot" value="1" checked="checked">是
                                <input type="radio" name="is_hot" value="2">否
                            <?php }elseif($goodsList->is_hot == 2){ ?>
                                <input type="radio" name="is_hot" value="1">是
                                <input type="radio" name="is_hot" value="2" checked="checked">否
                            <?php } ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            是否促销:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <?php if( $goodsList->is_promote == 1 ){ ?>
                                <input type="radio" name="is_promote" value="1" checked="checked">是
                                <input type="radio" name="is_promote" value="2">否
                            <?php }elseif($goodsList->is_promote == 2){ ?>
                                <input type="radio" name="is_promote" value="1">是
                                <input type="radio" name="is_promote" value="2" checked="checked">否
                            <?php } ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            促销价:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            <input type="text" value="{{$goodsList->promote_price}}" name="promote_price" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            促销开始时间:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            {{$goodsList->promote_start_date}}
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            促销结束时间:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            {{$goodsList->promote_end_date}}
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            商品添加时间:
                        </label>
                        <div class="layui-form-mid layui-word-aux">
                            {{$goodsList->add_time}}
                        </div>
                    </div>
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">修改</button>
            </div>
        </form>
        </div>

        <script>
            layui.use(['form', 'layer'],function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                // 自定义验证规则
                // form.verify({
                //     nikename: function(value) {
                //         if (value.length < 5) {
                //             return '昵称至少得5个字符啊';
                //         }
                //     },
                //     pass: [/(.+){6,12}$/, '密码必须6到12位'],
                //     repass: function(value) {
                //         if ($('#L_pass').val() != $('#L_repass').val()) {
                //             return '两次密码不一致';
                //         }
                //     }
                // });

                //监听提交
                // form.on('submit(add)',function(data) {
                    // console.log(data);
                    // //发异步，把数据提交给php
                    // layer.alert("增加成功", {
                    //     icon: 6
                    // },
                    // function() {
                    //     //关闭当前frame
                    //     xadmin.close();
                    //
                    //     // 可以对父窗口进行刷新
                    //     xadmin.father_reload();
                    // });
                    // // return false;
                // });

            });
        </script>
        {{--<script>--}}
            {{--var _hmt = _hmt || []; (function() {--}}
                {{--var hm = document.createElement("script");--}}
                {{--hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";--}}
                {{--var s = document.getElementsByTagName("script")[0];--}}
                {{--s.parentNode.insertBefore(hm, s);--}}
            {{--})();--}}
        {{--</script>--}}
    </body>

</html>
