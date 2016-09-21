<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><meta charset="utf-8" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="format-detection" content="telephone=no"/>
<title><?php echo ($metaTitle); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
<meta name="format-detection" content="telephone=no" />
<script src="<?php echo RES;?>/css/store/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/jquery.lazyload.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/notification.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/swiper.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/main.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/store/css/touch_index1.css">
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/store/css/style.css" />
</head>
<body>
<div style="width:100%;height:50px;line-height:50px;background:#fff;text-align:center"><span style="float:right;padding-right:10px;"><a href="<?php echo U('Store/index',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>"><img src="<?php echo RES;?>/css/store/css/img/home1.jpg"></a></span><span style="padding-left:10px;float:left"><a href="javascript:history.go(-1)"><img src="<?php echo RES;?>/css/store/css/img/return1.jpg" ></a></span><span style="font-size:16px;"><?php echo (msubstr($metaTitle,0,10)); ?></span></div>
<div id="scnhtm5" class="m-body"> 
<!--主体-->
<?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hostlist): $mod = ($i % 2 );++$i; if ($i > 6) {$k = $i % 6;} else {$k = $i;} ?>
	<div class="m-floor" style="padding-bottom:0px;width:80%">
	<ul class="ulsel" url="<?php echo U('Store/products',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>">
	<li class="tit bgf<?php echo ($k); ?>">
	<?php echo ($hostlist["name"]); ?>
	</li>
	</ul>
	</div><?php endforeach; endif; else: echo "" ;endif; ?> 
</div>
<div style="padding-top:1rem"></div>
</body>
<script type="text/javascript">
$(document).ready(function(){
	$(".m-floor").click(function(){
		location.href = $(this).children("ul").attr("url");
	});
});
window.shareData = {  
            "moduleName":"Store",
            "moduleID":"<?php echo ($products[0]['id']); ?>",
            "imgUrl": "<?php echo ($products[0]['logourl']); ?>", 
            "timeLineLink": "<?php echo C('site_url') . U('Store/cats',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "sendFriendLink": "<?php echo C('site_url') . U('Store/cats',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "weiboLink": "<?php echo C('site_url') . U('Store/products',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "tTitle": "<?php echo ($metaTitle); ?>",
            "tContent": "<?php echo ($metaTitle); ?>"
        };
</script>
<?php echo ($shareScript); ?>
</html>