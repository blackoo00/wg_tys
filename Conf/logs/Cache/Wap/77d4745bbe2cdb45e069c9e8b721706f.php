<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="format-detection" content="telephone=no"/>
<title><?php echo ($company["name"]); ?></title>
<script src="<?php echo RES;?>/css/store/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/jquery.lazyload.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/notification.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/swiper.min.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/css/store/js/main.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/store/css/style_touch11.css">
</head>
<body>
<div id="top"></div>
<div id="scnhtm5" class="m-body">
<div class="m-detail-mainout">
<!--div><img src="http://tzhrmy.tzwg.net/uploads/m/mhfcjx1421158741/e/d/f/f/thumb_557ba1890ffb2.jpg" width="100%"></div-->
<!--轮播--->
<div class="focusPic">
	<div class="views">
		<ul class="warp" id="fd">
			<?php if(is_array($banner)): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="li"><a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo ($vo["picurl"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
		<ul class="tabs" style="display:none">
			<?php if(is_array($banner)): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="li"><?php echo ($i); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
</div>
<script>
var focusPic = new Swiper('.focusPic .views',{pagination: '.focusPic .tabs',autoplay:2000})
</script>
<div class="m-hd" style="position:relative">
<div style="position:absolute;top:-44px;left:10px;"><img src="<?php echo ($company["logourl"]); ?>" style="width:80px;border-radius:8px;border:1px solid #C9C9C9"></div>
<div style="position:absolute;top:-34px;left:100px;font-size:20px;color:#fff; font-family:Microsoft YaHei;text-shadow:#000 5px 5px 5px;"><?php echo ($company["name"]); ?></div>
<!--div><a href="javascript:history.go(-1);" class="back">返回</a></div-->
<div class="tit"></div>
<div><a href="<?php echo U('Store/products',array('token'=>$_GET['token'],'mid'=>$my['id']));?>" class="all"><span style="display:block;padding-top:40px;text-align:center">全部宝贝</span></a></div>
<div><a href="<?php echo U('Store/cart',array('token'=>$_GET['token'],'mid'=>$my['id']));?>" class="cart"><span style="display:block;padding-top:40px;text-align:center">购物车</span><i class="cart_com"><?php if($totalProductCount != 0): echo ($totalProductCount); endif; ?></i></a></div>
<div><a href="<?php echo U('Store/my',array('token'=>$_GET['token'],'mid'=>$my['id']));?>" class="uc"><span style="display:block;padding-top:40px;text-align:center">我的订单</span></a></div>
<div><a href="<?php echo U('Store/cats',array('token'=>$_GET['token'],'mid'=>$my['id']));?>" class="cat"><span style="display:block;padding-top:40px;text-align:center">商品分类</span></a></div>
<span style="width:10px;display:block"></span>
</div>
<ul class="sub-menu-list">
<li><a href="<?php echo U('Store/cats',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>">首页</a></li>
<?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hostlist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Store/products',array('token' => $_GET['token'], 'catid' => $hostlist['id'],'mid'=>$my['id']));?>"><?php echo ($hostlist["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

<!--form id="search_form" name="search_form" action="" method="post">
	<div class="m-l-search">
		<input type="hidden" name="wecha_id" value="<?php echo ($wecha_id); ?>">
		<input type="hidden" name="token" value="<?php echo ($token); ?>">
		<input id="search_name" class="inp-search" name="search_name" type="search" value="" placeholder="输入关键字搜索">
		<input class="btn-search" name="search-btn" type="submit" value="">
	</div>
</form-->

<!--div class="m-select c666 order_control">
<span><a href="javascript:" order="time" class="arrow-down">时间<i><em></em></i></a></span>
<span><a href="javascript:" order="salecount">销量<i><em></em></i></a></span>
<span><a href="javascript:" order="price">价格<i><em></em></i></a></span>
<span><a href="javascript:" order="discount">折扣<i><em></em></i></a></span>
<input type="hidden" id="view_list" value="">
<!-- <span class="filter"><a href="javascript:;" class="ary li">排列</a><a href="javascript:;" class="flt">筛选</a></span> -->
</div-->
<?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><div class="cate"><span class="more"><a href="<?php echo U('Store/products',array('token' => $_GET['token'], 'catid' => $cat['id'],'mid'=>$my['id']));?>" style="color:#fff">更多></a></span><span class="title"><?php echo ($cat["name"]); ?></span></div>
<ul id="m_list" class="m-list " style="overflow:hidden">
<?php if(is_array($cat["products"])): $i = 0; $__LIST__ = $cat["products"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hostlist): $mod = ($i % 2 );++$i;?><li>
		<div style="width:95%;margin:0 auto;background:#fff;">
		<span class="pic">
			<a href="<?php echo U('Store/product',array('token' => $_GET['token'], 'id' => $hostlist['id'],'mid'=>$my['id']));?>">
			<img src="<?php echo ($hostlist["logourl"]); ?>" data-original="<?php echo ($hostlist["logourl"]); ?>" style="width:100%;height:120px;">
			</a>
			<a class="t" href="<?php echo U('Store/product',array('token' => $_GET['token'], 'id' => $hostlist['id'],'mid'=>$my['id']));?>"><?php echo (msubstr($hostlist["name"],0,15)); ?></a><br/>
			<b>￥<?php echo ($hostlist["vprice"]); ?></b><del>￥<?php echo ($hostlist["oprice"]); ?></del>
		</span>
		</div>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul><?php endforeach; endif; else: echo "" ;endif; ?> 
</body>
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Store",
            "moduleID":"<?php echo ($res['id']); ?>",
            "imgUrl": "<?php echo ($res['pic']); ?>", 
            "timeLineLink": "<?php echo C('site_url') . U('Store/index',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "sendFriendLink": "<?php echo C('site_url') . U('Store/index',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "weiboLink": "<?php echo C('site_url') . U('Store/products',array('token' => $_GET['token'],'mid'=>$my['id']));?>",
            "tTitle": "<?php echo ($metaTitle); ?>",
            "tContent": "<?php echo ($res["text"]); ?>"
        };
</script>
<?php echo ($shareScript); ?>
</html>