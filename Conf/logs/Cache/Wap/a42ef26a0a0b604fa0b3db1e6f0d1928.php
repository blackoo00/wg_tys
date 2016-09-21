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
	<title>患者服务</title>
</head>
<body>
	<div id="wrapper" class="manager_operation">
		<ul>
			<?php if(is_array($doctor)): $i = 0; $__LIST__ = $doctor;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Manager/doctor',array('id'=>$list['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>"><?php echo ($list["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="wappages"><?php echo ($page); ?></div>
		<section>
			<a href="<?php echo U('Manager/doctoradd',array('token'=>$token,'wecha_id'=>$wecha_id));?>">添加医生</a>
			<a href="<?php echo U('Manager/loginout',array('token'=>$token,'wecha_id'=>$wecha_id));?>">退出</a>
		</section>
		<style type="text/css" media="screen">
	#surport{
		text-align: center;
		margin: 10px auto 0;
		font-size: 1.2em;
	}
</style>
<div id="surport">技术支持:微广互动</div>

	</div>
</body>
</html>