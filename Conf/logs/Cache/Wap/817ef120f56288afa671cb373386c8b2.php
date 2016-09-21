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
<style>
	.newinput{
		display: block; height: 25px; line-height: 35px; width: 100%; background-color: #fff; border: none;
		text-indent: 12px; box-sizeing:border-box;
	}
</style>
<body>
	<div class="doctor_head">
		<div class='hd1 dpic'><img src="<?php echo ($doctor["pic"]); ?>" alt=""></div>
		<div class='hd1 dinfo'>
			<input type="hidden" id="did" value="<?php echo ($doctor["id"]); ?>">
			<div><span><?php echo ($doctor["name"]); ?></span>&nbsp;<span><?php echo ($doctor["persition"]); ?></span></div>
			<div><?php echo ($doctor["hname"]); ?></div>
			<div><?php echo ($doctor["profession"]); ?></div>
			<!-- <div><a href="#">粉丝:<?php echo ($doctor["followers"]); ?></a>
				 <a href="javascript:if(confirm('确定取消关注吗?'))location='<?php echo U('User/cancel',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>'">取消关注</a>
			</div> -->
		</div>
		<div class="clear"></div>
	</div>
	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
	<div id="wrapper" class='doctor_details' style="padding-bottom:60px">
		<!--section>
			<div>专业特长</div>
			<div><?php echo ($doctor["profession"]); ?></div>
		</section-->
		<section>
			<a href="<?php echo U('User/customconsultb',array('did'=>$doctor['id'],'cid'=>$cid,'token'=>$token,'wecha_id'=>$wecha_id));?>">在线咨询</a>
		</section>
		<section>
			<div>医生简介</div>
			<div><?php echo ($doctor["info"]); ?></div>
		</section>
		<section>
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
		</section>
		<section>
			<input class="newinput" readonly="true" type="text" placeholder="备注" value="<?php echo ($doctor["note"]); ?>">
		</section>
		<section>
			<a href="javascript:if(confirm('取消关注后将无法和医生进行互动?'))location='<?php echo U('User/cancel',array('id'=>$doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>'">取消关注</a>
		</section>
	</div>
<footer id="user_foot">
	<ul>
		<!-- <li><a href="<?php echo U('User/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">咨询</a></li> -->
		<li><a href="<?php echo U('User/doctor',array('id'=>$did,'token'=>$token,'wecha_id'=>$wecha_id));?>">我的医生</a></li>
		<li><a href="<?php echo U('User/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>">我</a></li>
	</ul>
</footer>
</body>
</html>