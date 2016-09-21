<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>后台管理登陆</title>
	<link href="<?php echo RES;?>/css/tys/login.css?time=<?php echo time();?>" rel="stylesheet">
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<style>
body{background:#BCDAF2;}
li{list-style-type:none;padding:0}
.submit_btn{margin-top:10px;}
</style>
<body>
	<div class="per_login">
		<section class="inner_content">
		<form id="loginform" name="loginform" method="post" action="<?php echo U('Manager/checklogin',array('token'=>$token,'wecha_id'=>$wecha_id));?>">
		<li class="username"><input type="text" name="username" placeholder="账号" id="username" value="" /></li>
		<li class="pwd"><input type="password" name="password" placeholder="密码" id="password" value="" /></li>
		<li class="submit_btn"><button type="submit" id="login_btn">登 录</button></li>
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
		$('loginform').submit();
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