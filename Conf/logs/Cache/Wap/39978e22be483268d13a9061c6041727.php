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
	<div id="wrapper" class="consult_allsendpage">
		<div id="allsend">
			<textarea name="" id="addsendcon"></textarea>
			<div>
				<button id="allsendbt" class="button blue">群发</button>
				<a href="javascript:history.go(-1)" class="button blue">取消</a>
			</div>
		</div>
		<script>
			$(function(){
				$("#allsendbt").bind("click",function(){
					var con=$("#addsendcon").val();
					if(con==""){
						console.log(con.length);
						alert("发送信息不能为空");
						return false;
					}
					if(con.length<2){
						alert("发送信息不能少于2个字");
						return false;
					}
					if(window.confirm("确定发出？")){
						$.ajax({
							url:"<?php echo U('Consult/allsend',array('did'=>$did,'token'=>$token,'wecha_id'=>$wecha_id));?>",
							data:{con:con},
							success:function(data){
								console.log(data);
								if(data=="ok"){
									alert("发送成功");
								}
								if(data=="nocustom"){
									alert("您还没有患者");
								}
							}
						})
					}
				})
			})
		</script>
	</div>
</body>
</html>