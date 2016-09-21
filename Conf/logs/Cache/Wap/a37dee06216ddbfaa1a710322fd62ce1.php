<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>咨询支表</title>
</head>
<body>
	<ul>
		<?php if(is_array($consultb)): $i = 0; $__LIST__ = $consultb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
				<?php if($list["dtalk"] == 1): echo ($doctorname); ?>:<?php else: echo ($customname); ?>:<?php endif; ?>
				<?php echo ($list["content"]); ?><br><?php echo (friendlydate($list["time"])); ?>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<form action="<?php echo U('Doctor/insert',array('id'=>$cmid,'token'=>$token,'wecha_id'=>$wecha_id));?>" method="post">
		<textarea name="content"></textarea><br>
		<input type="submit" value="发送">
	</form>
</body>
</html>