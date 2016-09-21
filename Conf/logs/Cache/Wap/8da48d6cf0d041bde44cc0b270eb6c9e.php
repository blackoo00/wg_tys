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
	<link href="<?php echo RES;?>/bsuger/Content/comm/css/weixin.css" rel="stylesheet" />
	<link href="<?php echo RES;?>/bsuger/Content/css/diabetes.css" rel="stylesheet" />
	<style>
	a.button{    display: inline-block;
    width: 30%;
    height: 30px;
    background-color: #00adef;
    border-radius: 8px;
    line-height: 30px;
    text-align: center;
    color: #fff;
    font-weight: bold;
    font-size: 1.3em;}
	.infoshow{width:80%;margin:0 auto;border:1px solid #eee;border-radius:15px;text-align:center;position:fixed;top:20%;left:10%;background:#00C07B;padding:20px 0;display:none}
	#login_btn{border-radius:2px; width:100%; background:#289ED7; border:0; height:38px; line-height:38px; font-size:16px; color:#FFF;}
	</style>
    <script src="<?php echo RES;?>/js/tys/require.js" data-main="<?php echo RES;?>/js/tys/main" type="text/javascript"></script>
    <script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js"></script>
    <script src="<?php echo RES;?>/js/tys/iscroll.js"></script>
    <script src="<?php echo RES;?>/js/tys/date.js"></script>
    <link href="<?php echo RES;?>/css/tys/common.css" rel="stylesheet" />
    <script type="text/javascript">
      $(function(){
        $('#bmibutton').date({
          beginnum:40,                 //最低体重
          endnum:100,                   //最高体重
          beginnum2:150,                   //身高
          endnum2:200,                    //身高
          title1:"体重(kg)",
          title2:"身高(cm)",
        },bmi);
        $('#bpressure').date({
          beginnum:70,                 //最低体重
          endnum:240,                   //最高体重
          beginnum2:40,                   //身高
          endnum2:200,                    //身高
          title1:"收缩压(高压)",
          title2:"舒张压(低压)",
        },bpressure);
        function bmi(data1,data2){
          var b=(data2/100)*(data2/100);
          var a=data1;
          var datestr=(a/b).toFixed(2);
          $("#bmi").val(datestr);
          return datestr;
        }
        function bpressure(data1,data2){
          var datestr=data1+'/'+data2;
          $('#presure').val(datestr);
          return datestr;
        }
      });
    </script>
    <div id="datePlugin"></div><!-- BIM 血压弹出框 -->
    <div class="steward_bprotein">
        <div class="title" style="line-height: 2.4em">
            重要指标
        </div>
        <section style="padding:4%">
            <form action="<?php echo U('Steward/bprotein', array('token'=>$token,'wecha_id'=>$wecha_id));?>" method="post">
                <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
                <ul>
                    <li><span>用药情况：</span><textarea name="note" id="" rows="5" placeholder="用药情况" style="font-size:1em"><?php echo ($info["note"]); ?></textarea></li>
                </ul>
				<article class="f1  bc1">
                <section class="record " style="padding-top: 10px;">
                    <dl>
                       <!--  <dt class="ul">
                            <div class="title">记录时间：</div>
                            <div class="f1 title2">
                                
                                <input type="text" class="f1" id="now" />
                                <input data-val="true" data-val-date="字段 记录时间 必须是日期。" data-val-required="The 记录时间 field is required." id="RecordTime" name="RecordTime" type="hidden" value="" />
                            </div>
                        </dt> -->
                        <dt class="ul">
                          <div class="title front">糖化血红蛋白(HbA1c):</div>
                          <div class="f1 title2 sel_f">
                            <input type="hidden" class="medicine" name="hbaic" id="hbaic" value="<?php echo ($info["hbaic"]); ?>">                        
                            <span id="hbaic1"><?php if(empty($info["hbaic"])): ?>请选择<?php else: echo ($info["hbaic"]); endif; ?></span>
                            <select onchange="medicine2()" name="hbaic1" id="medicine"></select>
                          </div>
                        </dt>
                        <dt class="ul">
                          <div class="title front">BMI:</div>
                          <div class="f1 title2 sel_f">
                            <input type="hidden" class="bmi" name="bmi" id="bmi" value="<?php echo ($info["bmi"]); ?>">                        
                            <span id="bmibutton"><?php if(empty($info["bmi"])): ?>请选择<?php else: echo ($info["bmi"]); endif; ?></span>
                          </div>
                        </dt>
                        <dt class="ul">
                          <div class="title front">血压(mmHg):</div>
                          <div class="f1 title2 sel_f">
                            <input type="hidden" class="presure" name="presure" id="presure" value="<?php echo ($info["presure"]); ?>">                        
                            <span id="bpressure"><?php if(empty($info["presure"])): ?>请选择<?php else: echo ($info["presure"]); endif; ?></span>
                          </div>
                        </dt>
                        <dt class="ul">
                          <div class="title front">甘油三脂(mmol/L):</div>
                          <div class="f1 title2 sel_f">
                            <input type="hidden" class="xiezhi" name="xiezhi" id="xiezhi" value="<?php echo ($info["xiezhi"]); ?>">                        
                            <span id="xiezhi1"><?php if(empty($info["xiezhi"])): ?>请选择<?php else: echo ($info["xiezhi"]); endif; ?></span>
                            <select onchange="xiezhi2()" name="xiezhi1" id="xiezhiselect"></select>
                          </div>
                        </dt>
                        
                        </dl>
                    <!-- <dl>
                        <dt>
                            <div class="title">备注：</div>
                        </dt>
                        <dd>
                            <div class="input">
                                
                                <textarea cols="20" id="Remark" name="Remark" placeholder="今天情况特殊，等等" rows="2">
</textarea>
                            </div>
                        </dd>
                    </dl> -->
                </section>
            </article>
			<div id="bmiInfo" class="infoshow">
				<ul style="width:100%">
						<li style="width:50%;float:left;text-align:center;line-height:40px;">
				        体重<br/>
                        <select name="" id="weight" style="margin:0 auto">
						</select>
                        </li> 
						<li  style="width:50%;float:left;text-align:center;line-height:40px;">
                        
                        身高<br/>
                        <select name="" id="height" style="margin:0 auto">
                            
                        </select>
						</li>
				 </ul>
				 <div class="clear"></div>
				 <br/>
				<a onclick="bmi2()" href="javacript:void(0)" class="button">确定</a>&nbsp;&nbsp;
                <a onclick="closeInfo('bmiInfo')" href="javacript:void(0)" class="button">关闭</a>
			</div>
			<div id="presureInfo" class="infoshow">
				<ul style="width:100%">
						<li style="width:50%;float:left;text-align:center;line-height:40px;">
				        收缩压(高压)<br/>
                        <select name="" id="highp" style="margin:0 auto">
						</select>
                        </li> 
						<li  style="width:50%;float:left;text-align:center;line-height:40px;">
                        
                        舒张压(低压)<br/>
                        <select name="" id="lowp" style="margin:0 auto">
                            
                        </select>
						</li>
				 </ul>
				 <div class="clear"></div>
				 <br/>
				<a onclick="presure2()" href="javacript:void(0)" class="button">确定</a>&nbsp;&nbsp;
                <a onclick="closeInfo('presureInfo')" href="javacript:void(0)" class="button">关闭</a>
			</div>
			<button type="submit" id="login_btn" onclick="return checkbprotein()">保存记录</button>
        <script>
          function checkbprotein(){
            if(window.confirm('确认提交？')){
              return true;
            }else{
              return false;
            }
          }
        </script>
            </form>
            <script>
				function closeInfo(id){
					$('#'+id).slideUp();
				}
                function medicine2(){
                    $('.medicine').val($('#medicine').val());
                }
                function bmi2(){
                    var b=($('#height').val()/100)*($('#height').val()/100);
                    var a=$('#weight').val();
                    var c=(a/b).toFixed(2);
                    $('.bmi').val(c);
					$('#bmi1').text(c);
					$('#bmiInfo').slideUp();
                }
                function presure2(){
                    $('.presure').val($('#highp').val()+'/'+$('#lowp').val());
					$('#presure1').text($('#highp').val()+'/'+$('#lowp').val());
					$('#presureInfo').slideUp();
                }
                function xiezhi2(){
                    $('.xiezhi').val($("#xiezhi").val())
                }
                $(function(){
                    var m=3.9,w=39,h=149,hp=69,lp=39,xz=0;
                    var op;
                    do
                      {
                          m=m+0.1;
                          op="<option value="+m.toFixed(1)+">"+m.toFixed(1)+"</option>";
                          if(m.toFixed(1)==10.0){
                            op="<option selected='true' value="+m.toFixed(1)+">"+m.toFixed(1)+"</option>";
                          }else{
                            op="<option value="+m.toFixed(1)+">"+m.toFixed(1)+"</option>";
                          }
                          $("#medicine").append(op);
                      }
                    while (m<17.9);

                    do
                      {
                          w=w+1;
                          op="<option value="+w+">"+w+"</option>";
                          $("#weight").append(op);
                      }
                    while (w<100);

                    do
                      {
                          h=h+1;
                          op="<option value="+h+">"+h+"</option>";
                          $("#height").append(op);
                      }
                    while (h<200);

                    do
                      {
                          hp=hp+1;
                          op="<option value="+hp+">"+hp+"</option>";
                          $("#highp").append(op);
                      }
                    while (hp<240);

                    do
                      {
                          lp=lp+1;
                          op="<option value="+lp+">"+lp+"</option>";
                          $("#lowp").append(op);
                      }
                    while (lp<200);

                    do
                      {
                          xz=xz+0.1;
                          if(xz.toFixed(1)==7.0){
                            op="<option selected='true' value="+xz.toFixed(1)+">"+xz.toFixed(1)+"</option>";
                          }else{
                            op="<option value="+xz.toFixed(1)+">"+xz.toFixed(1)+"</option>";
                          }
                          $("#xiezhiselect").append(op);
                      }
                    while (xz<=30);

                })
            </script>
			<script>
			$(function () {
				if($('#hbaic').val()!=0){
					$('#hbaic1').html($('#hbaic').val());
				}
				if($('#bmi').val()!=0){
					$('#bmi1').html($('#bmi').val());
				}
				if($('#presure').val()!=''){
					$('#presure1').html($('#presure').val());
				}
				if($('#xiezhi').val()!=0){
					$('#xiezhi1').html($('#xiezhi').val());
				}
				$('#hbaic1').click(function(){
					$('.infoshow').slideUp();
				});
				$('#bmi1').click(function(){
					$('.infoshow').slideUp();
					$('#bmiInfo').slideDown();
				});
				$('#presure1').click(function(){
					$('.infoshow').slideUp();
					$('#presureInfo').slideDown();
				});
				$('#presure1').click(function(){
					$('.infoshow').slideUp();
					$('#presureInfo').slideDown();
				});
				$('[name=hbaic1]').change(function () {
					$('#hbaic1').html($('[name=hbaic1] option:selected').text());
					$('#hbaic').val($('[name=hbaic1] option:selected').val());
				});
				$('[name=xiezhi1]').change(function () {
					$('#xiezhi1').html($('[name=xiezhi1] option:selected').text());
					$('#xiezhi').val($('[name=xiezhi1] option:selected').val());
				});
			});
		</script>
        </section>
        
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

    </div>
</body>
</html>