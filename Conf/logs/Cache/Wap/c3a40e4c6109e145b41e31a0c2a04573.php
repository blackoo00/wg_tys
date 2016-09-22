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
<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/js/tys/notification.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo RES;?>/css/tys/css/notification.css">
<body id="scnhtm5">
	<div id="wrapper" class="manager_doctoradd">
		<section>
			<form action="<?php echo U('Manager/doctoradd',array('token'=>$token,'wecha_id'=>$wecha_id));?>" method="post" enctype="multipart/form-data" id="doctor_add_form">
				<ul>
					<li><input placeholder="*姓名" name="name" type="text" value="" class="validation" data-warn="请输入姓名"></li>
					<li><input placeholder="医生照片" type="file" name="pic" id="pic"></li>
					<li>
						<!-- <input placeholder="所属医院" type="text" name="hname" id="hname"> -->
						<select name="hid">
							<option>--请选择医院--</option>
							<?php if(is_array($hospital)): $i = 0; $__LIST__ = $hospital;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hospital): $mod = ($i % 2 );++$i;?><option value="<?php echo ($hospital["id"]); ?>"><?php echo ($hospital["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</li>
					<li><input placeholder="科室" type="text" name="profession" value=""></li>
					<li><input placeholder="职称" type="text" name="persition" value="" class="validation" data-warn="请输入职称"></li>
					<!--li><textarea placeholder="专业特长" name="profession"></textarea></li-->
					<li><textarea placeholder="医生简介" name="info"></textarea></li>
					<li><input placeholder="登陆账号" type="text" id="username" value="" name="username" class="validation" data-warn="请输入登陆账号"></li>
					<li><input placeholder="登陆密码" type="password" id="password" value="" name="password" class="validation" data-warn="请输入登陆密码"></li>
					<li><input placeholder="重复密码" type="password" id="arepassword" value="" name="arepassword" class="validation" data-warn="请输入重复密码"></li>
					<li>
						<style>#cztable tr td[data-cz]{color: red}</style>
<div class="title1">出诊时间表</div>
<table id="cztable">
	<input type="hidden" name="visitstime" id="chuzhen" value="">		
	<input type="hidden" id="clcikaccess" value="<?php echo ($click); ?>">		
	<tr>
		<td>出诊</td>
		<td>星期一</td>
		<td>星期二</td>
		<td>星期三</td>
		<td>星期四</td>
		<td>星期五</td>
		<td>星期六</td>
		<td>星期日</td>
	</tr>
	<tr>
		<td>上午</td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
	</tr>
	<tr>
		<td>下午</td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
	</tr>
	<tr>
		<td>晚上</td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
		<td data-cz="0"></td>
	</tr>
</table>
<script type="text/javascript">
			//显示
			$(function(){
				if($("#clcikaccess").val()!="manager"){
					$.ajax({
						url:'<?php echo U('Doctor/showvisits',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>',
						async:'false',
						success:function(data){
							$("#chuzhen").val(data);
							//读取
							var arr=data.split("@");
							arr.forEach(function(e){  
							    var arr2=e.split(",");
							    if(arr2['2']==1){
							    	$("#cztable tr").eq(arr2['1']).find('td').eq(arr2['0']).attr('data-cz','1').html("<i class='icon-checkmark'></i>");
							    }
							    // if(arr2['2']==2){
							    // 	$("table tr").eq(arr2['1']).find('td').eq(arr2['0']).attr('data-cz','2').text('普通');
							    // }
							}) 
						}
					})
				}
				var week,day,chuzhen,str;
				//修改
				if($("#clcikaccess").val()=="yes"||$("#clcikaccess").val()=="manager"){
					$("#cztable tr td:empty").bind('click',function(){
						//1专家门诊 2普通 0为空
						// var newcz=$(this).attr('data-cz')>1?0:parseInt($(this).attr('data-cz'))+1;
						// $(this).attr('data-cz',newcz);
						// if($(this).attr('data-cz')==1){//专家门诊
						// 	$(this).text('专家');
						// }
						// if($(this).attr('data-cz')==2){//普通门诊
						// 	$(this).text('普通');
						// }
						// if($(this).attr('data-cz')==0){//为空
						// 	$(this).text('');
						// }
						var cz=parseInt($(this).attr('data-cz'));
						if(cz==0){
							$(this).attr('data-cz',1)
							$(this).html("<i class='icon-checkmark'></i>");
						}
						if(cz==1){
							$(this).attr('data-cz',0)
							$(this).html('');
						}

						//获取单一字符串 例1,1,1
						week=$(this).index();//星期
						day=$(this).parent('tr').index();//上中晚
						chuzhen=$(this).attr('data-cz');//出诊
						var str=$("#chuzhen").val();//原字符串
						var str1//单个字符串
						if(chuzhen==0){
							str1='';
						}else{
							str1=week+","+day+","+chuzhen;
						}
						var regular=week+","+day+",";//正则匹配用
						//AJAX对长字符串进行修改 例 加入点击结果为1,1,0 字符串为1,1,1@2,2,2 即变为1,1,0@2,2,2
						$.ajax({
							url:'<?php echo U('Doctor/editvisits',array('token'=>$token,'wecha_id'=>$wecha_id));?>',
							data:{str:str,str1:str1,regular:regular},
							success:function(data){
								$("#chuzhen").val(data);
								console.log(data);
							}
						})
					}) 
				}
			})
			</script>
					</li>
					<li><input type="button" id="doctor_add_submit" value="提交"></li>
				</ul>
			</form>
			<style type="text/css" media="screen">
	#surport{
		text-align: center;
		margin: 10px auto 0;
		font-size: 1.2em;
	}
</style>
<script>
function onBridgeReady(){
 WeixinJSBridge.call('hideOptionMenu');
}

if (typeof WeixinJSBridge == "undefined"){
    if( document.addEventListener ){
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    }else if (document.attachEvent){
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
}else{
    onBridgeReady();
}
</script>
<!-- <div id="surport">技术支持:微广互动</div> -->

		</section>
	</div>
</body>
</html>
<script>
	$('#doctor_add_submit').click(function(){
		var success = 1;
		$('.validation').each(function(index, el) {
			if($(this).val() == ''){
				floatNotify.simple($(this).data('warn'));
				success = 0;
				return false;
			}
		});
		//判断账号是否存在
		var username = $('#username').val();
		$.ajax({
			url:"<?php echo U('Manager/judgeDoctorByUsernameAjax');?>",
			data:{username:username},
			async:false,
			dataType:'json',
			success:function(data){
				if(data.status == 2){
					success = 0;
					floatNotify.simple(data.info);
				}
			}
		})
		if(success == 1){
			$('#doctor_add_form').submit();
		}
	})
</script>