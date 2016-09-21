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
    <script src="<?php echo RES;?>/js/tys/require.js" data-main="<?php echo RES;?>/js/tys/main" type="text/javascript"></script>
    <div class="steward_laboratory">
        <div>
            化验数据
        </div>
        <div>
            <ul>
                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Steward/showbigpic',array('id'=>$list[id], 'src'=>$list['pic'],'token'=>$token,'wecha_id'=>$wecha_id));?>">
                    <li class="labpic">
                        <input type="hidden" id="labid" name="labid" value="<?php echo ($list["id"]); ?>">
                        <img src="<?php echo ($list["pic"]); ?>">
                        <span><?php echo (friendlydate($list["recordtime"],ymd,false)); ?></span>
                        <span><?php echo (friendlydate($list["recordtime"],his,false)); ?></span>
                    </li>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
                <div id="loading" style="display:none">
                    <img src="<?php echo RES;?>/css/tys/photoswipe-loader.gif">
                </div>
            </ul>
            <div class="showbigpic">
                <div>
                    <img src="">
                    <a onclick="return closepic()" href="#">返回</a>
                    <a onclick="return delpic()" class="delpic" data-id="" href="#">删除</a>
                </div>
            </div>
        </div>
        <script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js" type="text/javascript"></script>
        <script>
            // $(function(){
            //     $('.labpic').click(function(){
            //         var id=$(this).find("#labid").val();
            //         var src=$(this).find("img").attr("src");
            //         $('.delpic').attr('data-id',id);
            //         $('.showbigpic').find("img").attr("src",src);
            //         $('.showbigpic').show();
            //     })
            // })
            // function closepic(){
            //     $('.showbigpic').hide();
            //     return false;
            // }
            // function delpic(){
            //     if(window.confirm('确定删除吗')){
            //         $.ajax({
            //             url:'<?php echo U('Steward/dellaboratorypic',array('token'=>$token,'wecha_id'=>$wecha_id));?>',
            //             data:{id:$('.delpic').attr('data-id')},
            //             success:function(data){
            //                 if(data==1);
            //                 alert("删除成功！");
            //                 location.reload();
            //             }
            //         })
            //     }
            // }
        </script>
        <div>
            <button class="greenbtn">上传化验图片</button>
            <input id="pic" name="pic" type="file" title="化验图片" onchange="return laboratorypic('<?php echo U('Steward/laboratorypic',array('token'=>$token,'wecha_id'=>$wecha_id));?>')"> 
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

    </div>
</body>
</html>