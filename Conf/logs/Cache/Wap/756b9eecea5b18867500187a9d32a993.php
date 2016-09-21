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
	<!-- <div id='custom_head'>
		<img src="<?php echo ($custom["pic"]); ?>">
		<div class="custom_name"><?php echo ($custom["name"]); ?></div>
		<div class="clear"></div>
	</div> -->
		<div id="wrapper" class="steward_info">
			<section>
				<form name="form1" action="<?php echo U('Steward/info',array('token'=>$token,'wecha_id'=>$wecha_id));?>" method="post" accept-charset="utf-8">
					<input type="hidden" name="id" value="<?php echo ($custom["id"]); ?>">
					<ul>
						<li>
							<input class="check" placeholder="姓名" type="text" name="name" value="<?php echo ($custom["name"]); ?>">
							<span>请填写真实姓名方便医生找到你</span>
						</li>
						<li>
							<select class="check" name="sex" id="sex">
								<option value="">--选择性别--</option>
								<option value="1" <?php if(($custom["sex"]) == "1"): ?>selected<?php endif; ?>>男</option>
								<option value="0" <?php if(($custom["sex"]) == "0"): ?>selected<?php endif; ?>>女</option>
							</select>
						</li>
						<li><input class="check" placeholder="年龄" type="text" name="age" value="<?php echo ($custom["age"]); ?>"></li>
						<li><input class="check" placeholder="电话/手机" type="text" name="tel" value="<?php echo ($custom["tel"]); ?>"></li>
						<li><input class="check" placeholder="地址" type="text" name="address" value="<?php echo ($custom["address"]); ?>"></li>
						<li>
							<select class="check" name="diabetes" id="diabetes">
								<option value="">--选择糖尿病类型--</option>
								<option value="1型" <?php if(($custom["diabetes"]) == "1型"): ?>selected<?php endif; ?>>1型</option>
								<option value="2型" <?php if(($custom["diabetes"]) == "2型"): ?>selected<?php endif; ?>>2型</option>
								<option value="妊娠" <?php if(($custom["diabetes"]) == "妊娠"): ?>selected<?php endif; ?>>妊娠</option>
								<option value="其他" <?php if(($custom["diabetes"]) == "其他"): ?>selected<?php endif; ?>>其他</option>
							</select>
						</li>
						<li><input type="button" class="greenbtn" id="save" value="保存"></li>
					</ul>
				</form>
				<script>
					$(function(){
						var check=1;
						$("#save").bind("click",function(){
							// $(".check").each(function(){
							// 	if($(this).val()==""){
							// 		alert("请填写完整信息方便医生诊断");
							// 		return false;
							// 		check=0;
							// 	}
							// })
							if(check==1){
								subForm();
							}
						})
					})
					function subForm(){
						form1.submit();
					}
				</script>
			</section>
		</div>
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