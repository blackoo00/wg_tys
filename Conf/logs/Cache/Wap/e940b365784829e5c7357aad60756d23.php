<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/style.css?time=<?php echo time();?>" />
	<title><?php echo ($wxuser["wxname"]); ?></title>
</head>
<body>
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
	<div id="tys_steward">
		<ul>
			<li><a href="<?php echo U('Steward/info',array('token'=>$token,'wecha_id'=>$wecha_id));?>"><img src="<?php echo RES;?>/css/tys/images/gjj1.jpg"></a></li>
			<li><a href="<?php echo U('Steward/bsuger',array('token'=>$token,'wecha_id'=>$wecha_id));?>"><img src="<?php echo RES;?>/css/tys/images/gjj2.jpg"></a></li>
			<li><a href="<?php echo U('Steward/bprotein',array('token'=>$token,'wecha_id'=>$wecha_id));?>"><img src="<?php echo RES;?>/css/tys/images/gjj3.jpg"></a></li>
			<li><a href="<?php echo U('Steward/laboratory',array('token'=>$token,'wecha_id'=>$wecha_id));?>"><img src="<?php echo RES;?>/css/tys/images/gjj4.jpg"></a></li>
			<!-- <li><a href="<?php echo U('Steward/medicine',array('token'=>$token));?>">用药记录</a></li>
			<li><a href="<?php echo U('Steward/insulin',array('token'=>$token));?>">胰岛素记录</a></li> -->
			<div class="clear"></div>
			<div class="tishi">数据添加完整才能让医生更好地指导</div>
		</ul>
	</div>
	<script>
		// $(function(){
		// 	$('#tys_steward')
		// })
	</script>
	<style type="text/css" media="screen">
	#surport{
		text-align: center;
		margin: 10px auto 0;
		font-size: 1.2em;
	}
</style>
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
<!-- <div id="surport">技术支持:微广互动</div> -->

</body>
</html>