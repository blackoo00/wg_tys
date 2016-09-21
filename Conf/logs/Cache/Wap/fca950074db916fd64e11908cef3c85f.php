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
	<!-- <div id='custom_head'>
		<img src="<?php echo ($doctor["pic"]); ?>">
		<div class="custom_name"><?php echo ($doctor["name"]); ?></div>
		<div class="clear"></div>
	</div> -->
	<style>
		.newinput{
			display: block; height: 25px; line-height: 25px; width: 100%; background-color: #fff; border: none;
			text-indent: 12px;
		}
	</style>
	<div id="wrapper" class="doctor_modify" style="padding:0">
			<div id="fankuiboxwrap">
				<div id="fankuibox">
					<div>如需修改，请在反馈建议提交</div>
					<div><span class="button grey" id="fankui_cancel">取消</span><span><a class="button blue" href="<?php echo U('Doctor/feedback',array('token'=>$token,'wecha__id'=>$wecha_id));?>">反馈建议</a></span></div>
				</div>
			</div>
			<script src="<?php echo RES;?>/js/tys/require.js" data-main="<?php echo RES;?>/js/tys/main" type="text/javascript"></script>
			<section id="dpic">
				<div class="cflow"><?php echo ($doctor["name"]); ?></div>
				<div id="loading">
					<img src="<?php echo RES;?>/css/tys/photoswipe-loader.gif">
				</div>
					<img id="doctorpic" src="<?php echo ($doctor["pic"]); ?>"/>
				<input id="pic" name="pic" type="file" title="医生头像" onchange="return headpic('<?php echo U('Doctor/headpic',array('token'=>$token,'wecha_id'=>$wecha_id));?>',<?php echo ($doctor["id"]); ?>)">
				<div class="clear"></div>
			</section>
			<section>
			<ul id="fankui">
				<li><span>医院</span><span><?php echo ($doctor["hname"]); ?>&nbsp;<i class="icon-circle-right"></i></span></li><div class="clear"></div>
				<li><span>科室</span><span><?php echo ($doctor["profession"]); ?>&nbsp;<i class="icon-circle-right"></i></span></li><div class="clear"></div>
				<li><span>职称</span><span><?php echo ($doctor["persition"]); ?>&nbsp;<i class="icon-circle-right"></i></span></li><div class="clear"></div>
			</ul>
			<script>
				$(function(){
					$("#fankui li").bind("click",function(){
						$("#fankuiboxwrap").show();
					})
					$("#fankui_cancel").bind("click",function(){
						$("#fankuiboxwrap").hide();
					})
				})
			</script>
		<form action="<?php echo U('Doctor/modify',array('token'=>$token,'wecha_id'=>$wecha_id));?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo ($doctor["id"]); ?>">
			<input type="hidden" value="<?php echo ($doctor["info"]); ?>" id="checktext">
			<div style="padding-left:2%; font-size:1.2em;">个人简介</div>
			<textarea name="info" id="info" placeholder="请介绍您的执业经历，学术成就、擅长等信息，让患者更好地了解您。"><?php echo ($doctor["info"]); ?></textarea></section>
			<section><style>#cztable tr td[data-cz]{color: red}</style>
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
			</script></section>
			<section>
				<input class="newinput" name="note" id="note" type="text" placeholder="备注" value="<?php echo ($doctor["note"]); ?>">
			</section>
			<input class="greenbtn" id="send" type="submit" value="保存">
		</form>
		<script>
			$(function(){
				$("#send").bind("click",function(){
					if($("#info").val()==""){
						alert("医生简历不能为空");
						return false;
					}else if($("#info").val().length<10){
						alert("内容不得少于10个字");
						return false;
					}
					// }else if($("#info").val()==$("#checktext").val()){
					// 	alert("简历内容没有修改过");
					// 	return false;
					// }
				})
			})
		</script>
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
				<a href="<?php echo U('Doctor/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我的患者
					<?php if(($check) == "1"): ?><span></span><?php endif; ?>
				</a>
			</div>
		</li>
		<li><div><a href="<?php echo U('Doctor/personal',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></div></li>
	</ul>
</footer>
</body>
</html>