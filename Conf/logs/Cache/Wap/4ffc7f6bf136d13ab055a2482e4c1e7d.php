<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="format-detection" content="telephone=no"/>
<title><?php echo ($metaTitle); ?></title>
<script src="<?php echo RES;?>/css/store/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/jquery.lazyload.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/notification.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/swiper.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/main.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/store/css/style_touch11.css">
</head>
<body>
<div id="top"></div>
<div id="scnhtm5" class="m-body">
<div class="m-detail-mainout">
<div style="width:100%;height:50px;line-height:50px;background:#fff;text-align:center"><span style="float:right;padding-right:10px;"><a href="<?php echo U('Store/index',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>"><img src="<?php echo RES;?>/css/store/css/img/home1.jpg"></a></span><span style="padding-left:10px;float:left"><a href="javascript:history.go(-1)"><img src="<?php echo RES;?>/css/store/css/img/return1.jpg" ></a></span><span style="font-size:16px"><?php echo (msubstr($metaTitle,0,10)); ?></span></div>
<ul class="sub-menu-list">
<li><a href="<?php echo U('Store/cats',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>">首页</a></li>
<?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hostlist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Store/products',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>"><?php echo ($hostlist["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

<ul class="m-uc-order-p-liv m-cart-list">
<?php if(is_array($products)): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i; if(empty($p['detail']) != true): if(is_array($p['detail'])): $i = 0; $__LIST__ = $p['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><li>
				<span class="pic"><img src="<?php echo ($p["logourl"]); ?>" width="75" height="75"></span>
				<span class="con">
				<i class="t"><?php echo ($p["name"]); ?></i>
				<i class="d"><?php if(empty($p['formatTitle']) != true): echo ($p["formatTitle"]); ?>：<?php echo ($row["formatName"]); endif; ?> <?php if(empty($p['colorTitle']) != true): ?>，<?php echo ($p["colorTitle"]); ?>：<?php echo ($row["colorName"]); endif; ?></i>
				<p><label>数量：</label><?php echo ($row["count"]); ?>　<label>小计：</label><span class="price">￥<?php echo ($row["price"]); ?></span></p>
				<?php if($row['comment'] == 1): ?><a href="<?php echo U('Store/comment',array('token'=>$token,'detailid'=>$row['id'],'wecha_id'=>$wecha_id,'pid'=>$p['id'], 'cartid' => $cartid));?>" style="font-size: 1.4rem;color: #fff;bottom: -1px;right: -1px;background: #ff8a00;border: 1px solid #f26100;padding: 2px 14px;line-height: 24px;border-radius: 4px 0 4px 0;">评论</a><?php endif; ?>
				</span>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	<?php else: ?>
		<li>
			<span class="pic"><img src="<?php echo ($p["logourl"]); ?>" width="75" height="75"></span>
			<span class="con">
			<i class="t"><?php echo ($p["name"]); ?></i>
			<p><label>数量：</label><?php echo ($p["count"]); ?>　<label>小计：</label><span class="price">￥<?php echo ($p["price"]); ?></span></p>
			<?php if($p['comment'] == 1): ?><a href="<?php echo U('Store/comment',array('token'=>$token,'wecha_id'=>$wecha_id,'pid'=>$p['id'], 'cartid' => $cartid));?>" style="font-size: 1.4rem;color: #fff;bottom: -1px;right: -1px;background: #ff8a00;border: 1px solid #f26100;padding: 2px 14px;line-height: 24px;border-radius: 4px 0 4px 0;">评论</a><?php endif; ?>
			</span>
		</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</ul>
<ul class="m-uc-order-v-infobox">
<li><span class="tit">订单状态</span>
<?php if($cartData['paid']){echo '<b class="orderStatus" style="color:green">已付款</b>';}else{echo '<b class="orderStatus">待付款</b>';} ?>/<?php if($cartData['sent']){echo '<b class="orderStatus" style="color:green">已发货</b>';}else{echo '<b class="orderStatus">待发货</b>';} ?>/<?php if($cartData['receive']){echo '<b class="orderStatus" style="color:green">已收货</b>';}else{echo '<b class="orderStatus">待收货</b>';} ?>
</li>
<li>
<p>下单时间：<?php echo (date("Y-m-d H:i:s",$cartData["time"])); ?></p>
<p>订单金额：<b><?php echo ($totalFee); ?>元</b></p>
</li>
<?php if(($cartData['paid'] == 1) AND ($cartData['sent'] == 0) AND ($cartData['returnMoney'] == 0)): ?><li class="act">
<div class="btn-gray">申请退款
<select name="cancel_reason" onchange="cancleorder($(this))" class="cel-opt">
<option value="下单重复">下单重复</option>
<option value="支付问题">支付问题</option>
<option value="快递不到">快递不到</option>
<option value="更改支付方式或商品">更改支付方式或商品</option>
<option value="测试订单">测试订单</option>
<option value="包含缺货商品">包含缺货商品</option>
<option value="价格原因">价格原因</option>
<option value="其它原因">其它原因</option>
</select>
</div>
</li><?php endif; ?>
</ul>
<!-- <ul class="m-uc-order-v-infobox">
<li><span class="tit">物流信息</span></li>
<li id="shipping_wlgs">
<p>物流公司：<?php if($cartData['logistics']){echo $cartData['logistics'] . ';  订单号：' . $cartData['logisticsid'];}else{echo '普通快递';} ?></p>
</li>
</ul> -->
<ul class="m-uc-order-v-infobox">
<li><span class="tit">收货人信息</span></li>
<li>
<p>　收货人：<?php echo ($cartData["truename"]); ?></p>
<p>收货地址：<?php echo ($cartData["province"]); echo ($cartData["city"]); echo ($cartData["county"]); echo ($cartData["address"]); ?></p>
<p>手机/固话：<?php echo ($cartData["tel"]); ?></p>
<p>备注信息：<?php echo ($cartData["remark"]); ?></p>
</li>
</ul>
<ul class="m-uc-order-v-infobox">
<li><span class="tit">支付与配送</span></li>
<li id="shipping_zfhps">
<?php if($cartData['paymode'] == 1): ?><p>支付方式： 微信支付</p>
<?php elseif($cartData['paymode'] == 2): ?>
<p>支付方式： 财付通支付</p>
<?php elseif($cartData['paymode'] == 3): ?>
<p>支付方式： 货到付款</p>
<?php else: ?>
<p>支付方式： 其他方式支付</p><?php endif; ?>
<?php if($cartData['sent'] == 1): ?><p>快递公司：<?php echo ($cartData["logistics"]); ?></p>
<p>快递单号：<?php echo ($cartData["logisticsid"]); ?></p><?php endif; ?>
<p>商品金额：<?php echo ($totalFee); ?>元</p>
<p>　　运费：<?php echo ($mailprice); ?>元　</p>
<p>应付金额：<?php {echo $cartData['price'];} ?>元</p>
</li>
</ul>
</div>
<script type="text/javascript">
function cancleorder(obj){
    confirm =floatNotify.confirm("确定要退款此订单吗？", "",
        function(t, n) {
            if(n==true){
                var _reson=obj.val();
                var _order_id=$("#order_id").val();
				var dataJson = {
					reason:_reson
				}
                $.ajax({
                	type:"POST",
                	url: "<?php echo U('Store/returnCart',array('token' => $token, 'cartid' => $cartid, 'wecha_id' => $_GET['wecha_id']));?>",
					data:dataJson,
                    dataType:"json",
                    success:function(data){
                        if(data.error_code == false){
                            floatNotify.simple('订单退款申请成功，等待处理');
                            setTimeout("location.href='<?php echo U('Store/my',array('token' => $token, 'wecha_id' => $_GET['wecha_id']));?>'",1200);  
                        }else{
                           return floatNotify.simple(data.msg);  
                        }
                    },
                    error:function(){
                       return floatNotify.simple("申请失败");
                    }
                });
            }
    	this.hide();
      }),
    confirm.show();
}
</script>
</body>
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Store",
            "moduleID":"0",
            "imgUrl": "", 
            "timeLineLink": "<?php echo C('site_url') . U('Store/myDetail',array('token' => $_GET['token']));?>",
            "sendFriendLink": "<?php echo C('site_url') . U('Store/myDetail',array('token' => $_GET['token']));?>",
            "weiboLink": "<?php echo C('site_url') . U('Store/myDetail',array('token' => $_GET['token']));?>",
            "tTitle": "<?php echo ($metaTitle); ?>",
            "tContent": "<?php echo ($metaTitle); ?>"
        };
</script>
<?php echo ($shareScript); ?>
</html>