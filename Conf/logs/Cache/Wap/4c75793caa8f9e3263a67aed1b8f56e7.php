<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>咨询支表</title>
</head>
<body>
	<ul>
		<li>咨询标题:<?php echo ($consultm["title"]); ?></li>
		<li>咨询内容:<?php echo ($consultm["info"]); ?></li>
		<li>姓名:<?php echo ($consultm["custom"]["name"]); ?></li>
		<li>性别:<?php if($consultm["sex"] == 1): ?>男<?php else: ?>女<?php endif; ?></li>
		<li>出生年份:<?php echo ($consultm["born"]); ?></li>
		<li>病情照片:
			<?php if(is_array($consultm["spic"])): $i = 0; $__LIST__ = $consultm["spic"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><!-- <?php if(($$list) != ""): ?><li><img src="<?php echo ($list); ?>"></li><?php endif; ?> -->
				<?php if(!empty($list)): ?><li><img src="<?php echo ($list); ?>"></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</li>
	</ul>
	<ul>
		<?php if(is_array($consultb)): $i = 0; $__LIST__ = $consultb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
				<?php if($list["dtalk"] == 1): echo ($doctorname); ?>:<?php else: echo ($customname); ?>:<?php endif; ?>
				<?php echo ($list["content"]); ?><br><?php echo (friendlydate($list["time"])); ?>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<form action="<?php echo U('User/insert',array('id'=>$cmid,'token'=>$token,'wecha_id'=>$wecha_id));?>" method="post">
		<textarea name="content"></textarea><br>
		<input type="submit" value="发送">
	</form>
</body>
</html>