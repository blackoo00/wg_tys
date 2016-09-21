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
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
	<style>
        .refresh{
            display: block;
            width:50px; height:50px; border-radius:50%; border:1px solid #c5c5c5; margin:5px auto; background-color:#fff;
            line-height: 50px; font-size: 2em; text-align: center;
        }
    </style>
	<div id="wrapper" style="padding:0" class="doctor_custom">
		<ul>
			<li class="searchli">
				<div>
					<i class="icon-search"></i>
					<input type="text" id="search" placeholder="搜索">
				</div>
				<a href="<?php echo U('User/doctorlist',array('token'=>$token,'wecha_id'=>$wecha_id));?>">刷新</a>
			</li>
			<script>
				$(function(){
					$('#search').blur(function(){
						var l=$("#search").val();
						console.log(l);
						var r=$(".doctor_custom ul li").find('#customname').text().indexOf(l);
						$(".doctor_custom ul li").each(function(){
							var t=$(this).find('#customname').text();
							if(t){
								r=t.indexOf(l);
								if(r>=0){
									$(this).show();
								}else{
									$(this).hide();
								}
							}
						})
					})
				})
			</script>
			<!-- <a href="<?php echo U('User/doctorlist',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="refresh"><i class="icon-loop2"></i></a> -->
			<?php if(is_array($doctor)): $i = 0; $__LIST__ = $doctor;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('User/customconsultb',array('did'=>$list['id'],'cid'=>$cid,'token'=>$token,'wecha_id'=>$wecha_id));?>">
				<li>
					<div class="prompt">
						<img src="<?php echo ($list["pic"]); ?>">
						<?php if(($custom["consult"]["dnew"]) == "1"): ?><span></span><?php endif; ?>
						<p><?php echo ($list["name"]); ?></p>
					</div>
					<!-- <div class="doctor_custom_details">
						<span id="customname"><?php echo ($list["name"]); ?></span>
						<span>性别:<?php if($list["sex"] == 1): ?>男<?php else: ?>女<?php endif; ?></span>
						<span>糖尿病类型:<?php if(!empty($list['diabetes'])): echo ($list["diabetes"]); endif; ?></span>
						<span>起病方式:<?php if(!empty($list['disease'])): echo ($list["disease"]); endif; ?></span>
					</div> -->
					<div class="clear"></div>
				</li>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
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