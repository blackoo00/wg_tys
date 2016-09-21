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
	<div id="wrapper" class="consult_index">
		<section>
			<div>医患问题提问</div>
			<form class="form" method="post" action="<?php echo U('Consult/insert',array('wecha_id'=>$wecha_id,'token'=>$token));?>" enctype="multipart/form-data" >
				<input type="hidden" name="did" value="<?php echo ($doctor["id"]); ?>">
				<div id="loading" style="display:none"><img src="<?php echo RES;?>/css/tys/photoswipe-loader.gif"></div>
				<table>
					<tr>
						<td><input name="title" type="text" placeholder="标题"></td>
					</tr>
					<tr>
						<td><textarea name="info" name="" id="" cols="30" rows="10" placeholder="咨询内容"></textarea></td>
					</tr>
					<tr>
						<td>患者性别:<input name="sex" type="radio" value="1">男 <input name="sex" type="radio" value="2">女</td>
					</tr>
					<tr>
						<td>出生年份：<select name="born" id="myYear"></select> </td>
						<script language="javascript" type="text/javascript">
							window.onload=function(){
							//设置年份的选择
							var myDate= new Date();
							var startYear=myDate.getFullYear()-100;//起始年份
							var endYear=myDate.getFullYear();//结束年份
							var obj=document.getElementById('myYear')
							for (var i=startYear;i<=endYear;i++)
							{
								obj.options.add(new Option(i+"年",i+"年"));
							}
								obj.options[obj.options.length-51].selected=1;
							}
						</script>
					</tr>
					<tr>
						<td>是否公开:<input name="public" type="radio" value="1">是 <input name="public" type="radio" value="2">否</td>
					</tr>
					<tr>
						<td>上传图片:</td>
					</tr>
					<tr>
						<script src="<?php echo RES;?>/js/tys/require.js" data-main="<?php echo RES;?>/js/tys/main" type="text/javascript"></script>
						<td>
							<span>
								<input id="pic" name="pic" type="file" title="病情图片" onchange="return ajaxFileUpload('<?php echo U('Consult/picupsave');?>')">
								<input id="uppic" name="uppic" type="hidden" value="">
							</span>
							<span style="display:block; float:left; width:75%;">上传疾病相关照片或医院诊断图片有利于医生给您更准确的建议</span>
							<div class="clear"></div>
							<div class="thumbnail">
								<ul>
									
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="向医生提问"></td>
					</tr>
				</table>
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