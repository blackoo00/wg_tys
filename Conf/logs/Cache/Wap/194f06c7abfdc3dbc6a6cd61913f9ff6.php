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
    <!-- <div id='custom_head'>
        <img src="<?php echo ($custom["doctor"]["pic"]); ?>">
        <div class="custom_name"><?php echo ($custom["doctor"]["name"]); ?></div>
        <div class="clear"></div>
    </div> -->
    <style>
        .title{
            color:#33C80E;
            line-height: 30px;
            height: 30px;
            text-indent: 1.3em;
            border-bottom: 2px solid #F0F0F0;
        }
        .bloodsuger{width: 100%; border:solid #add9c0; border-width:1px 0px 0px 1px; margin-top: 5px;}
        .bloodsuger th,.bloodsuger td{border:solid #add9c0; border-width:0px 1px 1px 0px; height: 30px;}
        .bloodsuger td{text-align: center; font-size: 1.2em;}
        .xtjl{color:red;}
        .textare{
            width: 100%;
            height: 50px;
            border-radius: 6px;
            padding: 3px;
            box-sizing:border-box;
            text-indent: 12px;
            background-color: #fff;
        }
    </style>
    <div id="wrapper" class="doctor_cdetails">
        <section>
            <div class="title">基本信息</div>
            <ul>
                <li>患者姓名：<?php echo ($custom["name"]); ?></li>
                <li>患者性别:<?php if(($custom["sex"]) == "1"): ?>男<?php else: ?>女<?php endif; ?></li>
                <li>年龄:<?php echo ($custom["age"]); ?></li>
                <li>电话/手机:<?php echo ($custom["tel"]); ?></li>
                <li>地址:
                    <textarea readonly="true" class="textare"><?php echo ($custom["address"]); ?></textarea>
                </li>
                <li>糖尿病类型:<?php echo ($custom["diabetes"]); ?></li>
            </ul>
        </section>
        <section>
            <div class="title">血糖详情</div>
            <table class="bloodsuger">
                <tr>
                    <td rowspan="2">日期</td>
                    <td></td>
                    <td colspan="2">早餐</td>
                    <td colspan="2">午餐</td>
                    <td colspan="2">晚餐</td>
                    <td></td>
                </tr>
                <tr>
                    <td>凌晨</td>
                    <td>空腹</td>
                    <td>餐后</td>
                    <td>餐前</td>
                    <td>餐后</td>
                    <td>餐前</td>
                    <td>餐后</td>
                    <td>睡前</td>
                </tr>
                <?php if(is_array($bsuger)): $i = 0; $__LIST__ = $bsuger;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                        <td class="xtjl"><?php echo (friendlydate($list["recordtime"],md,false)); ?></td>
                        <td class="xtjl"><?php echo ($list["lctxs"]); ?></td>
                        <td class="xtjl"><?php echo ($list["kf"]); ?></td>
                        <td class="xtjl"><?php echo ($list["zchtxs"]); ?></td>
                        <td class="xtjl"><?php echo ($list["acq"]); ?></td>
                        <td class="xtjl"><?php echo ($list["achtxs"]); ?></td>
                        <td class="xtjl"><?php echo ($list["wcq"]); ?></td>
                        <td class="xtjl"><?php echo ($list["wchtxs"]); ?></td>
                        <td class="xtjl"><?php echo ($list["sq"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </section>
        <section>
            <div class="title">重要指标</div>
            <ul>
                <li><span>糖化血红蛋白(HbA1c):<font class="xtjl"><?php echo ($bprotein["hbaic"]); ?></font></span><span></span></li>
                <li><span>BMI:<font class="xtjl"><?php echo ($bprotein["bmi"]); ?></font></span><span></span></li>
                <li><span>血压(mmHg):<font class="xtjl"><?php echo ($bprotein["presure"]); ?></font></span><span></span></li>
                <li><span>甘油三脂(mmol/L):<font class="xtjl"><?php echo ($bprotein["xiezhi"]); ?></font></span><span></span></li>
                <li><span>用药情况:</span>
                    <textarea readonly="true" class="textare" style="color:red"><?php echo ($bprotein["note"]); ?></textarea>
                </li>
            </ul>
        </section>
        <section>
            <div class="title">化验单</div>
            <ul>
                <?php if(is_array($laboratory)): $i = 0; $__LIST__ = $laboratory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Doctor/bigpic',array('src'=>$list['pic'],'token'=>$token,'wecha_id'=>$wecha_id));?>"><img style="width: 100%;" src="<?php echo ($list["pic"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </section>
    </div>
    <div id="user_foot">
	<ul>
		<!-- <li><a href="<?php echo U('User/consultm',array('token'=>$token,'wecha_id'=>$wecha_id));?>">咨询</a></li> -->
		<li><a href="<?php echo U('User/doctor',array('id'=>$did,'token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我的医生</a></li>
		<li><a href="<?php echo U('Steward/index',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我的数据</a></li>
		<li><a href="<?php echo U('User/custom',array('token'=>$token,'wecha_id'=>$wecha_id));?>" class="iconfont">我</a></li>
	</ul>
</div>
</body>
</html>