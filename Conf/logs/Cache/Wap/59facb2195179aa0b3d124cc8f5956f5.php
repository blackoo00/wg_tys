<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="msapplication-tap-highlight" content="no">
	<title>后台管理登陆</title>
	<link href="<?php echo RES;?>/css/tys/login.css" rel="stylesheet">
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="<?php echo RES;?>/js/tys/notification.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo RES;?>/css/tys/css/notification.css">
</head>
<body id="scnhtm5">
	<div class="per_login">
		<section class="inner_content">
			<p class="logo">
				<img src="<?php echo RES;?>/css/tys/images/login_logo.png" alt="">
			</p>
			<form id="loginform" name="loginform" method="post" action="<?php echo U('Manager/checklogin');?>">
				<p class="username form_item"><input type="text" name="username" id="username" value="" /></p>
				<p class="pwd form_item"><input type="password" name="password" id="password" value="" /></p>
				<p class="submit_btn form_item"><button id="login_btn">登 录</button></p>
			</form>
		</section>
	</div>
	<script type="text/javascript">
		$('#login_btn').click(function(){
			if($('#username').val()==''){
				alert('帐号不能为空');
				return false;
			}
			if($('#password').val()==''){
				alert('密码不能为空');
				return false;
			}
			$('#loginform').submit();
		});
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