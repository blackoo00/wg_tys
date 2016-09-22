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
	<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/normalize.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/default.css">
	<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/styles.css">
	<link href='http://fonts.useso.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js"></script>
	<!--[if IE]>
		<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
	<![endif]-->
    <style>
        .refresh{
            display: block;
            width:50px; height:50px; border-radius:50%; border:1px solid #c5c5c5; margin:5px auto; background-color:#fff;
            line-height: 50px; font-size: 2em; text-align: center;
        }
    </style>
    <div class="htmleaf-container">
    		<div class="htmleaf-content bgcolor-3">
    			<div id="chatbox">
    				<div id="friendslist">
    			        <div id="friends">
                            <div id="search">
                                <i class="icon-search"></i>
                                <input type="text" id="searchfield" onblur="search()" placeholder="输入患者名"/>
                            </div>
                            <a href="javascript:location.reload()" class="refresh"><i class="icon-loop2"></i></a>
                            <?php if(is_array($consult1)): $i = 0; $__LIST__ = $consult1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('did'=>$list[doctor][id],'cid'=>$list[custom][id],'cmid'=>$list[id],'token'=>$token,'wecha_id'=>$wecha_id));?>">
            			        	<div class="friend" style="background-color:#fff;border-top:1px solid #c3c3c5;border-bottom:1px solid #c3c3c5;">
                			            	<img src="<?php echo ($list["custom"]["pic"]); ?>" />
                			            	<input type="hidden" id="cid" value="<?php echo ($list["custom"]["id"]); ?>">
                			                <p>
                			                	<strong class="customname"><?php echo ($list["custom"]["name"]); ?>&nbsp;<?php if(($list["new"]) == "1"): ?><font class="newmessage" style="color:red">(有新的消息)</font><?php endif; ?></strong>
                				                <!-- <span><?php echo ($list["title"]); ?></span> -->
                			                </p>
                			                <!-- <div class="status available"></div> -->
                                            <div class="clear"></div>
            			            </div>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php if(is_array($consult2)): $i = 0; $__LIST__ = $consult2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Consult/consultb',array('did'=>$list[doctor][id],'cid'=>$list[custom][id],'cmid'=>$list[id],'token'=>$token,'wecha_id'=>$wecha_id));?>">
                                    <div class="friend" style="background-color:#fff;border-top:1px solid #c3c3c5;border-bottom:1px solid #c3c3c5;">
                                            <img src="<?php echo ($list["custom"]["pic"]); ?>" />
                                            <input type="hidden" id="cid" value="<?php echo ($list["custom"]["id"]); ?>">
                                            <p>
                                                <strong class="customname"><?php echo ($list["custom"]["name"]); ?>&nbsp;<?php if(($list["new"]) == "1"): ?><font class="newmessage" style="color:red">(有新的消息)</font><?php endif; ?></strong>
                                                <!-- <span><?php echo ($list["title"]); ?></span> -->
                                            </p>
                                            <!-- <div class="status available"></div> -->
                                            <div class="clear"></div>
                                    </div>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
    			        </div>                
    			    </div>	
    			    <script>
                          function search(){
                             var l=$("#searchfield").val();
                             $(".friend").each(function(){
                                var t=$(this).find('.customname').text();
                                if(t){
                                    r=t.indexOf(l);
                                    if(r>=0){
                                        $(this).show();
                                    }else{
                                        $(this).hide();
                                    }
                                }
                             })
                          }
                          function refresh(obj){
                            console.log($(obj).attr('href'));
                            var href=$(this).attr('href');
                            var cid=$(obj).find("#cid").val();
                            var did=$(obj).attr("data-did");
                            // console.log(cid+"@"+did);
                            $.ajax({
                                url:"<?php echo U('Consult/ajaxconsultb',array('token'=>$token,'wecha_id'=>$wecha_id));?>",
                                data:{cid:cid,did:did},
                                async: false,
                                success:function(data){
                                  
                                }
                            })
                            return true;
                          }
                    </script>     
    			</div>	
    		</div>
    	</div>
</body>
</html>