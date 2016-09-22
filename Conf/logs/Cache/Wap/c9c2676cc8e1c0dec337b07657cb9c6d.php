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
<div id='custom_head'>
	<a href="<?php echo U('Doctor/modify',array('token'=>$token,'wecha_id'=>$wecha_id));?>">
		<img src="<?php echo ($doctor["pic"]); ?>">
		<div class="custom_name"><?php echo ($doctor["name"]); ?></div>
		<div class="jiantou"><img src="<?php echo RES;?>/css/tys/images/jiantou.png"/></div>
		<div class="clear"></div>
	</a>
</div>
<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/js/tys/jquery.range.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo RES;?>/css/tys/jquery.range.css">
<style>
	input { font-size: 14px; font-weight: bold;  }

	input[type=range]:before { content: attr(min); padding-right: 5px; }
	input[type=range]:after { content: attr(max); padding-left: 5px;}

	output {
	    display: block;
	    font-size: 5.5em;
	    font-weight: bold;
	}
</style>
	<div id="wrapper" class="Doctor_personal">
		<!-- <div id="qrcode">
			<div>
				患者扫一扫与医生建立专属联系
			</div>
			<img src="<?php echo ($doctor["qrcode"]); ?>">
			<div><?php echo ($doctor["name"]); ?></div>
			<div><?php echo ($doctor["hospital"]["name"]); ?></div>
			<div><?php echo ($doctor["persition"]); ?></div>
		</div> -->
		<ul>
			<a id="editinfo" href="<?php echo U('Doctor/modify',array('token'=> $token,'wecha_id'=>$wecha_id));?>">
				<li>个人简介(方便患者了解您)</li>
			</a>
			<a id="editinfo" href="<?php echo U('Doctor/feedback',array('token'=> $token,'wecha_id'=>$wecha_id,'id'=>$doctor[id]));?>">
				<li>反馈建议</li>
			</a>
			<li id="myqrcode"><a style="display:block;" href="<?php echo U('Doctor/myqrcode',array('token'=>$token,'wecha_id'=>$wecha_id,'id'=>$doctor[id]));?>">我的专属二维码</a></li>
			<!-- <a href="<?php echo U('Doctor/consultm',array('token'=> $token,'wecha_id'=>$wecha_id));?>">
				<li>我的回答:(<?php echo ($doctor["consultnums"]); ?>个)</li>
			</a> -->
			<a href="<?php echo U('Doctor/custom',array('token'=> $token,'wecha_id'=>$wecha_id));?>">
				<li>我的患者:(<?php echo ($doctor["followers"]); ?>个)</li>
			</a>
			<li>今日咨询:(<?php echo ($dconsultnums); ?>个)</li>
			<li>总咨询量:(<?php echo ($doctor["consultnums"]); ?>个)</li>
			<li>
				日咨询量
				<input type="text" name="dailyconsult" style="font-size:1.5em; width:15%; color:orange; border:none; background-color:#fff;" readonly="true" id="show" value="<?php echo ($doctor["dailyconsult"]); ?>">			
				<input class="button blue" type="button" value="保存" onclick="saveconsult()">
				<div style="padding:20px 0">
				<input type="hidden" class="single-slider" value="<?php echo ($doctor["dailyconsult"]); ?>"/> 
				</div>
			</li>
			<script type="text/javascript">
			    function saveconsult(){
					$.ajax({
						url:'<?php echo U('Doctor/dailyconsult',array('token'=>$token,'wecha_id'=>$wecha_id));?>',
						data:{dailyconsult:document.getElementById("show").value},
						success:function(data){
							if(data==1){
								alert("修改成功");
							}else{
								alert("系统出错");
							}
						}
					})
			    }
				$(document).ready(function(){
				    console.log("11");
				    $('.single-slider').jRange({
				        from: 0,
				        to: 100,
				        step: 1,
				        scale: [0,25,50,75,100],
				        format: '%s',
				        width: 250,
				        showLabels: true,
				        tag:'#show'
				    });
				});
			</script>
			<!-- <li>
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
			</li> -->
		</ul>
	</div>
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

<div style="height:68px;"></div>
<footer id="doctor_foot">
	<ul>
		<!-- <li><a href="<?php echo U('Consult/consultm',array('did'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">我的医信</a></li> -->
		<li>
			<div>
				<a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我的患者<?php if(($check) == "1"): ?><span></span><?php endif; ?>
				</a>
			</div>
		</li>
		<li><div><a href="<?php echo U('Doctor/personal',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我</a></div></li>
	</ul>
</footer>
</body>
</html>