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
        <img src="<?php echo ($doctor["pic"]); ?>">
        <div class="custom_name"><?php echo ($doctor["name"]); ?></div>
        <div class="clear"></div>
    </div>
<body>
	<div id="wrapper" class="doctor_consultm">
		<ul>
			<?php if(empty($consult)): ?>暂时没有咨询！<?php else: ?>
				<?php if(is_array($consult)): $i = 0; $__LIST__ = $consult;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('id'=> $list['id'],'talk'=>'doctor','token'=>$token,'wecha_id'=>$wecha_id));?>">
						<li>
							<img src="<?php echo ($list["custom"]["pic"]); ?>">
							<div><span>标题：<?php echo ($list["title"]); ?></span><span><?php echo (friendlydate($list["time"])); ?></span></div>
							<div>内容：<?php echo ($list["info"]); ?></div>	
							<div class="clear"></div>
						</li>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wappages"><?php echo ($page); ?></div><?php endif; ?>
		</ul>
	</div>
	<style type="text/css" media="screen">
	#surport{
		text-align: center;
		margin: 10px auto 0;
		font-size: 1.2em;
	}
</style>
<div id="surport">技术支持:微广互动</div>

<div style="height:68px;"></div>
<footer id="doctor_foot">
	<ul>
		<li><a href="<?php echo U('Doctor/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我的医信</a></li>
		<li><a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我的患者</a></li>
		<li><a href="<?php echo U('Doctor/personal',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></li>
	</ul>
</footer>
</body>
</html>