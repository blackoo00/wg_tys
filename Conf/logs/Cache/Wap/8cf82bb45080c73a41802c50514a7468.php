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

<?php if($ordersCount != 0): if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><ul class="m-uc-order-li">
			<span info_link="<?php echo U('Store/myDetail',array('token'=>$token,'cartid'=>$o['id'],'wecha_id'=>$wecha_id));?>" onclick="order_jump($(this))">
				<li class="p-li">
					<?php if(is_array($o['productInfo'])): $i = 0; $__LIST__ = $o['productInfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Store/product',array('token'=>$token,'id'=>$row['id'],'wecha_id'=>$wecha_id));?>">
						<img title="<?php echo ($row["name"]); ?>" src="<?php echo ($row["logourl"]); ?>" width="45" height="45">
						</a><?php endforeach; endif; else: echo "" ;endif; ?>
				</li>
				<!-- <li>订单编号：<a href="<?php echo U('Store/product',array('token'=>$token,'id'=>$row['id'],'wecha_id'=>$wecha_id));?>"><?php echo ($o["orderid"]); ?></a></li> -->
				<li>支付状态：<?php if($o['paid']){echo '<span style="color:green">已付款</span>';}else{echo '<span style="color:red">待付款</span>';} ?><i class="t"><?php echo (date("Y-m-d H:i:s",$o["time"])); ?></i></li>
				<li>发货状态：<?php if($o['sent']){echo '<span style="color:green">已发货</span>';}else{echo '<span style="color:red">待发货</span>';} ?><i class="t"><?php echo (date("Y-m-d H:i:s",$o["time"])); ?></i></li>
				<li>收货状态：<?php if($o['receive']){echo '<span style="color:green">已收货</span>';}else{echo '<span style="color:red">待收货</span>';} ?><i class="t"><?php echo (date("Y-m-d H:i:s",$o["time"])); ?></i></li>
				<li>订单总额：￥<?php echo ($o["price"]); ?>
					<?php if(($o['returnMoney'] == 0)): if(($o['paid'] == 0) AND ($alipayConfig['open'] == 1)): ?><a href="<?php echo U('Alipay/pay', array('token' => $token, 'wecha_id' => $wecha_id,'success'=>1,'from'=>'Store', 'price' => $o['price'], 'orderName' => $o['orderid'], 'orderid' => $o['orderid']));?>" class="pay-btn">立即付款</a><?php endif; ?>
						<?php if(($o["paid"]) == "1"): if(($o["sent"]) == "1"): if(($o["receive"]) == "0"): ?><a href="javascript:void(0)" onclick="getProduct(<?php echo ($o["id"]); ?>)" class="pay-btn">确认收货</a>
								<?php else: ?>
									<a href="#" class="pay-btn" style="background:#cccccc;border:1px #cccccc solid;color:red">已完成</a><?php endif; ?>
							<?php else: ?>
								<a href="#" class="pay-btn" style="background:#cccccc;border:1px #cccccc solid;color:red">待发货</a><?php endif; endif; ?>
					<?php else: ?>
						<?php if(($o['returnMoney'] == 1)): ?><a href="#" class="pay-btn" style="background:#cccccc;border:1px #cccccc solid;color:red">退款中</a><?php endif; ?>
						<?php if(($o['returnMoney'] == 2)): ?><a href="#" class="pay-btn" style="background:#cccccc;border:1px #cccccc solid">已退款</a><?php endif; endif; ?>
				</li>
			</span>
		</ul><?php endforeach; endif; else: echo "" ;endif; ?>
	<?php if($totalpage > 1) { ?>
		<div class="m-page uc-orderlist">
			<?php if($page == 1): ?><div class="pg-pre pg-grey"><a href="javascript:void(0);">上一页<i><em></em></i></a></div>
			<?php else: ?>
				<div class="pg-pre"><a href="<?php echo U('Store/my',array('token'=>$token,'page'=>intval($page - 1),'wecha_id'=>$wecha_id));?>">上一页<i><em></em></i></a></div><?php endif; ?>
			<div class="pg-num"><?php echo ($page); ?>/<?php echo ($totalpage); ?></div>
			<?php if($page == $totalpage): ?><div class="pg-next pg-grey"><a href="javascript:void(0);">下一页<i><em></em></i></a></div>
			<?php else: ?>
				<div class="pg-next"><a href="<?php echo U('Store/my',array('token'=>$token,'page'=>intval($page + 1),'wecha_id'=>$wecha_id));?>">上一页<i><em></em></i></a></div><?php endif; ?>
		</div>
	<?php }else{} ?>
<?php else: ?>
	<ul style="margin: 15px 10px;border-radius: 4px;line-height: 1.4em;font-size: 16px;border: 1px solid #ddd;background: #f5f5f5;padding: 10px 10px 6px;">
		<span><li class="p-li" style="padding:10px; text-align:center;">没有订单</li></span>
	</ul><?php endif; ?>
<script type="text/javascript">
function order_jump(obj) {
	location.href = $(obj).attr('info_link');
}
</script>
<script type="text/javascript">
function getProduct(id){
	event.cancelBubble=true;
    confirm =floatNotify.confirm("确定该商品收货了吗？", "",
        function(t, n) {
            if(n==true){
				var dataJson = {
					productid:id
				}
                $.ajax({
                	type:"POST",
                	url: "<?php echo U('Store/getProduct',array('token' => $token,'wecha_id' => $_GET['wecha_id']));?>",
					data:dataJson,
                    dataType:"json",
                    success:function(data){
                        if(data.error_code == false){
                            floatNotify.simple('确认收货成功');
                            setTimeout("location.href='<?php echo U('Store/my',array('token' => $token, 'wecha_id' => $_GET['wecha_id']));?>'",1200);  
                        }else{
                           return floatNotify.simple(data.msg);  
                        }
                    },
                    error:function(){
                       return floatNotify.simple("收货失败");
                    }
                });
            }
    	this.hide();
      }),
    confirm.show();
}
</script>
</body>
<script>
function onBridgeReady(){
 WeixinJSBridge.call('hideOptionMenu');
}

if (typeof WeixinJSBridge == "undefined"){
    if( document.addEventListener ){
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    }else if (document.attachEvent){
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
}else{
    onBridgeReady();
}
</script>
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Store",
            "moduleID":"",
            "imgUrl": "", 
            "timeLineLink": "<?php echo C('site_url') . U('Store/my',array('token' => $_GET['token']));?>",
            "sendFriendLink": "<?php echo C('site_url') . U('Store/my',array('token' => $_GET['token']));?>",
            "weiboLink": "<?php echo C('site_url') . U('Store/my',array('token' => $_GET['token']));?>",
            "tTitle": "<?php echo ($metaTitle); ?>",
            "tContent": "<?php echo ($metaTitle); ?>"
        };
</script>
<?php echo ($shareScript); ?>
</html>