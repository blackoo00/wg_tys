<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ID=edge, chorome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>我的分店-<?php echo ($level); ?>分店列表</title>
    <link href="<?php echo RES;?>/distri/css/fdlb.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo RES;?>/original/css/jquery-weui.css">
    <link rel="stylesheet" href="<?php echo RES;?>/original/css/style.css">
</head>

<body>
    <div class="container">
        <link href="<?php echo RES;?>/distri/css/fdlb.css" rel="stylesheet" type="text/css" />
        <?php if(is_array($member)): $i = 0; $__LIST__ = $member;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Distribution/memberIndex',array('token'=> $token,'id'=>$vo[id]));?>">
                <div <?php if(($vo["distritime"]) != "0"): ?>class="fd fd1"
                    <?php else: ?>
                    class="fd"<?php endif; ?>
                >
                <div class="tx">
                    <img <?php if(($vo["headimgurl"]) == ""): ?>src="<?php echo RES;?>/distri/images/portrait.jpg"
                    <?php else: ?>
                    src="<?php echo ($vo["headimgurl"]); ?>"<?php endif; ?>
                width="115px;">
            </div>
            <!--tx-->
            <div class="left">
                <ul class="left_ul">
                    <li>分店ID：<?php echo $vo['id']+$set['startNums'];?></li>
                    <li>
                        昵称:
                        <?php if(($vo["headimgurl"]) == ""): ?>未获取
                            <?php else: ?>
                            <?php echo ($vo["nickname"]); endif; ?>
                    </li>
                    <li>关注时间：<?php echo (date('Y-m-d',$vo["createtime"])); ?></li>
                </ul>
            </div>
            <!--left-->
            <div class="right">
                <img src="<?php echo RES;?>/distri/images/jt.png"></div>
                <div class="clear"></div>
            <!--right--> </div>
    </a><?php endforeach; endif; else: echo "" ;endif; ?>

<!--foot开始-->
<div style="height: 60px;"></div>
<div class="public_foot">
  <div class="weui-row weui-no-gutter">
    <div class="weui-col-25">
      <a href="<?php echo U('Store/index');?>" class="public_footer_index">
        <p class="iconfont">&#xe60d;</p>
        <p>首页</p>
      </a>
    </div>
    <div class="weui-col-25">
      <a href="<?php echo U('Store/cats');?>" class="public_footer_products">
        <p class="iconfont">&#xe60c;</p>
        <p>分类</p>
      </a>
    </div>
    <div class="weui-col-25">
      <a href="<?php echo U('Store/cart');?>" class="public_footer_shopcat">
        <p class="iconfont">&#xe60e;</p>
        <p>购物车</p>
      </a>
    </div>
    <div class="weui-col-25">
      <a href="<?php echo U('Distribution/index');?>" class="public_my">
        <p class="iconfont">&#xe6ca;</p>
        <p>我的</p>
      </a>
    </div>
</div>

<script>
    var module = "<?php echo MODULE_NAME;?>";
      var action = "<?php echo ACTION_NAME;?>";
      if(module == "Store" && action == "index"){
        $('.public_footer_index').addClass('public_footer_choose');
      }
      if(module == "Store" && action == "cats"){
        $('.public_footer_products').addClass('public_footer_choose');
      }
      if(module == "Store" && action == "cart"){
        $('.public_footer_shopcat').addClass('public_footer_choose');
      }
      if(module == "Distribution" && action == "index"){
        $('.public_my').addClass('public_footer_choose');
      }
  </script>
<!--foot结束-->

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
<div class="clear"></div>
<?php if((ACTION_NAME) != "herolist"): ?><section class="foot"></section><?php endif; ?>

</div>
<!--container-->
</body>
</html>