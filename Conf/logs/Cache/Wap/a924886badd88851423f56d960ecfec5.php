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
	<title><?php echo ($title); ?></title>
</head>
<body>
	<style type="text/css" media="screen">
		#qrcode{
			width: 100%;
			height: 1600px;
			background-color: #fff;
			color: #000;
			font-size: 1.3em;
		}

		#qrcode img{
			display: block;
			width: 80%;
			margin: 2% auto;
		}
		#qrcode div{
			padding-top: 10px;
			box-sizing:border-box;
			text-align: center;
			margin: 0 auto;
			font: 1.3em;
			font-weight: bold;
			line-height: 18px;
		}
	</style>
	<div id="wrapper" style="padding:0" class="doctor_myqrcode">
		<div id="qrcode">
			<div style="font-size:1.3em;">美好孕育助手</div>
			<div>
				孕妈扫一扫与孕育师建立专属联系
			</div>
			<img src="<?php echo ($doctor["qrcode"]); ?>">
			<div style="font-size:1.3em;"><?php echo ($doctor["name"]); ?></div>
			<!-- <div><?php echo ($doctor["hname"]); ?></div> -->
			<div><?php echo ($doctor["profession"]); ?></div>
			<div><?php echo ($doctor["persition"]); ?></div>
		</div>
	</div>
	<script type="text/javascript">
		function onBridgeReady(){
		 WeixinJSBridge.call('showOptionMenu');
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
</body>
</html>