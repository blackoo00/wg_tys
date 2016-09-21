<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>个人中心-咨询列表</title>
</head>
<body>
	<ul>
		<?php if(is_array($consult)): $i = 0; $__LIST__ = $consult;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li><?php echo ($list["title"]); ?><br><?php echo ($list["info"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</body>
</html>