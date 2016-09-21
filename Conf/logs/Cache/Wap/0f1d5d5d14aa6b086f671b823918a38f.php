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
	<div id="wrapper" class="user_person">
		<section>
			<form action="<?php echo U('User/pinsert',array('token'=>$token,'wecha_id'=>$wecha_id));?>" method="post">
			<ul>
				<li><input name="name" type="text" placeholder="姓名" value="<?php echo ($custom["name"]); ?>"></li>
				<li><input name="tel" type="text" placeholder="电话" value="<?php echo ($custom["tel"]); ?>"></li>
				<li><input name="card" type="text" placeholder="身份证号" value="<?php echo ($custom["card"]); ?>"></li>
				<li><input type="submit" value="提交"></li>
			</ul>
			</form>
		</section>
	</div>
	<footer id="user_foot">
	<ul>
		<!-- <li><a href="<?php echo U('User/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">咨询</a></li> -->
		<li><a href="<?php echo U('User/doctor',array('id'=>$did,'token'=>$token,'wecha_id'=>$wecha_id));?>">医生简介</a></li>
		<li><a href="<?php echo U('User/custom',array('id'=>$cid,'token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></li>
	</ul>
</footer>
</body>
</html>