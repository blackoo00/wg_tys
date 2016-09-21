<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用药记录</title>
</head>
<body>
	<a href="<?php echo U('Steward/minsert',array('token'=>$token));?>">添加</a>
	<ul>
		<?php if(is_array($medicine)): $i = 0; $__LIST__ = $medicine;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Steward/mupdate',array('id'=>$list['id'],'token'=>$token));?>">
				<li>开始时间:<?php echo ($list["starttime"]); ?>结束时间:<?php echo ($list["endtime"]); ?>药物:<?php echo ($list["oralmedicine"]); ?></li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</body>
</html>