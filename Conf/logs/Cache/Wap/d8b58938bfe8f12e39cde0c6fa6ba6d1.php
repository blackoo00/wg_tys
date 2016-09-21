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
	<div class="doctor_head">
		<div class='hd1 dpic'><img src="<?php echo ($doctor["pic"]); ?>" alt=""></div>
		<div class='hd1 dinfo'>
			<input type="hidden" id="did" value="<?php echo ($doctor["id"]); ?>">
			<div><span><?php echo ($doctor["name"]); ?></span>&nbsp;<span><?php echo ($doctor["persition"]); ?></span></div>
			<div><?php echo ($doctor["hospital"]["name"]); ?></div>
			<!-- <div><a href="#">粉丝:<?php echo ($doctor["followers"]); ?></a>
				 <a href="javascript:if(confirm('确定取消关注吗?'))location='<?php echo U('User/cancel',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>'">取消关注</a>
			</div> -->
			<div><a href="<?php echo U('Consult/index',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">在线咨询</a></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="wrapper" class='comment_index'>
		<section>
			<div>医生评价：</div>
			<script src="<?php echo RES;?>/js/tys/require.js" data-main="<?php echo RES;?>/js/tys/main" type="text/javascript"></script>
				<form method="post" action="<?php echo U('Comment/insert',array('token'=>$token,'wecha_id'=>$wecha_id));?>">
				<input type="hidden" name="did" value="<?php echo ($doctor["id"]); ?>">
				<div id="stars">
					<span data-star="1"></span>
					<span data-star="1"></span>
					<span data-star="1"></span>
					<span data-star="1"></span>
					<span data-star="1"></span>
					<input name="starnum" id="starsnum" type="hidden" value="">
				</div>
				<textarea name="info"></textarea>
				<input type="submit" onclick="return check()" value="提交">
				<script>
					function check(){
						if(window.confirm('确定提交吗？')){
							return true;
						}else{
							return false;
						} 
					} 
				</script>
				</form>
		</section>
	</div>
<div style="height:68px;"></div>
<footer>
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
	<ul>
		<li><a href="<?php echo U('Doctor/details',array('id'=>$doctor['id'],'token'=>$token));?>" title="医生详细">医生首页</a></li>
		<!-- <li id="interactive">
			<div>
				<span id="zxhd">在线互动</span>
				<div class="cc">
					<span><a href="<?php echo U('Consult/index',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">在线提问</a></span>
					<span><a onclick="return checkcomment()" href="<?php echo U('Comment/index',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">在线评价</a><input type="hidden" id="commentcheck"></span>
				</div>
			</div>
		</li> -->
		<li><a href="<?php echo U('User/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">用户中心</a></li>
		<div class="clear"></div>
	</ul>
	<script>
		// $("#zxhd").click(function(){
		// 	if($(this).hasClass("active")){
		// 		$('.cc').show().animate({top:"0"},100,function(){$('.cc').hide()});
		// 		$(this).removeClass("active");
		// 	}else{
		// 		$('.cc').show().animate({top:"-90px"},100);
		// 		$(this).addClass("active");
		// 	}
		// })
		function checkcomment(){
			$.ajax({
				url:'<?php echo U('Comment/checkcomment',array('token'=>$token,'wecha_id'=>$wecha_id));?>',
				async : false,
				data:{id:$('#did').val()},
				success:function(data){
					console.log(data);
					if(data=='1'){
						alert("您已做出过评价");
						$("#commentcheck").val(1);
					}
				}
			})
			if($("#commentcheck").val()==1){
				return false;
			}
		}
	</script>
</footer>
</body>
</html>