<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理</title>
</head>
<body>
	<form action="<?php echo U('Doctor/msave',array('token'=>$token,'wecha_id'=>$wecha_id));?>" enctype="multipart/form-data" method="post">
	<input name="id" type="hidden" value="<?php echo ($doctor["id"]); ?>">
	<ul>
		<li>姓名：<input name="name" type="text" value="<?php echo ($doctor["name"]); ?>"></li>
		<li>
			<select name="hid">
				<?php if(is_array($hospital)): $i = 0; $__LIST__ = $hospital;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hospital): $mod = ($i % 2 );++$i;?><option value="<?php echo ($hospital["id"]); ?>" <?php if(($hospital["id"]) == $doctor["hid"]): ?>selected<?php endif; ?> ><?php echo ($hospital["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</li>
		<li>职位：<input type="text" name="persition" value="<?php echo ($doctor["persition"]); ?>"></li>
		<li>专业特长：<textarea name="profession"><?php echo ($doctor["profession"]); ?></textarea></li>
		<li>医生简介：<textarea name="info"><?php echo ($doctor["info"]); ?></textarea></li>
		<li>二维码上传：<input name="pic" type="file" value="选择图片"></li>
		<li><a href="<?php echo U('Doctor/modify',array('token'=>$token,'wecha_id'=>$wecha_id));?>">修改登陆信息</a></li>
		<li><a href="<?php echo U('Doctor/loginout',array('token'=>$token,'wecha_id'=>$wecha_id));?>">退出</a></li>
	</ul>
	<input type="submit" value="提交">
	</form>
</body>
</html>