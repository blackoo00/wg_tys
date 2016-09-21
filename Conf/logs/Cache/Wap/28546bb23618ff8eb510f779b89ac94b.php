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
	<div id="wrapper" class="consult_consultb">
		<div id="talkcontent">
			<form action="<?php echo U('Doctor/insertFeedback',array('id'=>$id,'token'=>$token,'wecha_id'=>$wecha_id));?>" method="post">
				<textarea name="content" placeholder='非常感谢您的建议，我们将认真对待每一个建议和反馈，并给予答复'></textarea><br>
				<input type="submit" value="提交反馈">
			</form>
		</div>
		<ul>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
					<input type="hidden" id="consultb_id" value="<?php echo ($list["id"]); ?>">
						<div class="left_talk">
							<span><img src="<?php echo ($doctor["pic"]); ?>"></span>
							<span><?php echo ($list["info"]); ?></span>
							<div class="clear"></div>
						</div>
					<div class="clear"></div>
					<div class="talk_time"><?php echo (friendlydate($list["time"])); ?></div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
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

<div style="height:68px;"></div>
<footer id="doctor_foot">
	<ul>
		<!-- <li><a href="<?php echo U('Consult/consultm',array('did'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">我的医信</a></li> -->
		<li>
			<div>
				<a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我的患者
					<?php if(($check) == "1"): ?><span></span><?php endif; ?>
				</a>
			</div>
		</li>
		<li><div><a href="<?php echo U('Doctor/personal',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></div></li>
	</ul>
</footer>
</body>
</html>