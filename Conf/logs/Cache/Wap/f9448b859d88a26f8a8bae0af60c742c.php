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
	<div id='custom_head'>
		<img src="<?php echo ($custom["pic"]); ?>">
		<div class="custom_name"><?php echo ($custom["name"]); ?></div>
		<div class="clear"></div>
	</div>
	<div id="wrapper" class="user_consultm">
		<ul>
			<!-- <li>
				<img src="uploads/test.jpg">
				<div><span>咨询标题</span><span>咨询日期</span></div>
				<div>咨询内容</div>
				<div class="clear"></div>
			</li> -->
			<?php if(empty($consult)): ?>还未咨询过<?php endif; ?>
			<?php if(is_array($consult)): $i = 0; $__LIST__ = $consult;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('id'=> $list['id'],'talk'=>'custom','token'=>$token,'wecha_id'=>$wecha_id));?>">
					<li>
						<img src="<?php echo ($list["doctor"]["pic"]); ?>">
						<div><span><?php echo ($list["title"]); ?></span><span><?php echo (friendlydate($list["time"])); ?></span></div>
						<div><?php echo ($list["info"]); ?></div>
						<div class="clear"></div>
					</li>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <?php if(is_array($consult)): $i = 0; $__LIST__ = $consult;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('id'=> $list['id'],'talk'=>'custom','token'=>$token,'wecha_id'=>$wecha_id));?>">
					<li>
						<img src="<?php echo ($list["doctor"]["pic"]); ?>">
						<div><span><?php echo ($list["title"]); ?></span><span><?php echo ($list["info"]); ?></span></div>
						<span class="user_consultm_date"><?php echo (friendlydate($list["time"])); ?></span>
						<div class="clear"></div>
					</li>
				</a><?php endforeach; endif; else: echo "" ;endif; ?> -->
			<div class="wappages"><?php echo ($page); ?></div>
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

	<footer id="user_foot">
	<ul>
		<!-- <li><a href="<?php echo U('User/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">咨询</a></li> -->
		<li><a href="<?php echo U('User/doctor',array('id'=>$did,'token'=>$token,'wecha_id'=>$wecha_id));?>">我的医生</a></li>
		<li><a href="<?php echo U('User/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></li>
	</ul>
</footer>
</body>
</html>