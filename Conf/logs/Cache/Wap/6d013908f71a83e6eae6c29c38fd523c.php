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
	<style>
        .refresh{
            display: inline-block;
            width:50px; height:50px; border-radius:50%; border:1px solid #c5c5c5; margin:5px auto; background-color:#fff;
            line-height: 50px; font-size: 2em; text-align: center;
        }
    </style>
	<div id="wrapper" style="padding:0" class="doctor_custom">
		<ul>
			<div class="searchli">
				<div>
					<i class="icon-search"></i>
					<input type="text" id="search" placeholder="输入患者姓名">
				</div>
				<a class="" href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">刷新</a>
			</div>
			<script>
				$(function(){
					$('#search').blur(function(){
						var l=$("#search").val();
						console.log(l);
						var r=$(".doctor_custom ul li").find('#customname').text().indexOf(l);
						$(".doctor_custom ul li").each(function(){
							var t=$(this).find('#customname').text();
							if(t){
								r=t.indexOf(l);
								if(r>=0){
									$(this).show();
								}else{
									$(this).hide();
								}
							}
						})
					})
				})
			</script>
			<div id="qunfa">
				<!-- <a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="refresh"><i class="icon-loop2"></i></a> -->
				<span>患者列表</span>
				<a style="float:right;" href="<?php echo U('Consult/allsendpage',array('did'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>" class="button blue">群发</a>
				<div class="clear"></div>
			</div>
			<div class="clear">	</div>
			<?php if(is_array($custom)): $i = 0; $__LIST__ = $custom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('did'=>$doctor['id'],'cid'=>$list['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">
				<li>
					<div class="prompt">
						<img src="<?php echo ($list["pic"]); ?>">
						<?php if(($list["consult"]["cnew"]) == "1"): ?><font class="newmessage" style="color:red"><span></span></font><?php endif; ?>
						<p id="customname"><?php echo ($list["name"]); ?></p>
					</div>
					<div class="clear"></div>
				</li>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
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

<div style="height:68px;"></div>
<footer id="doctor_foot">
	<ul>
		<!-- <li><a href="<?php echo U('Consult/consultm',array('did'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">我的医信</a></li> -->
		<li>
			<div>
				<a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我的患者<?php if(($check) == "1"): ?><span></span><?php endif; ?>
				</a>
			</div>
		</li>
		<li><div><a href="<?php echo U('Doctor/personal',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我</a></div></li>
	</ul>
</footer>
</body>
</html>