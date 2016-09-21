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
	<div id="wrapper">
		<div>总共<?php echo ($hospitalnum); ?>家医院  <?php echo ($doctornum); ?>位医生</div>
		<section>
			<div class="hospital_list">
				<ul>
					<?php if(is_array($hospital)): $i = 0; $__LIST__ = $hospital;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
							<a href="<?php echo U('Doctor/index',array('id'=>$list['id']));?>" title="<?php echo ($list["name"]); ?>"><?php echo ($list["name"]); ?></a>
							<span>(<?php echo ($list["doctornum"]); ?>)</span>
							<div class="clear"></div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</section>
	</div>
</body>
</html>