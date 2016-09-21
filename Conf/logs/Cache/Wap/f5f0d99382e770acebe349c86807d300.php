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
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/css/jquery-weui.min.css">
<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js"></script>
<div class="htmleaf-container" style="max-width:640px; margin:0 auto; width:100%;">
    <div class="htmleaf-content bgcolor-3">
        <div id="chatbox">

            <div id="chatview" class="p1" style="display: block;">
                <div id="profile" class="animate">
                    <img style="vertical-align:middle; width: 80px; height:80px;" src="<?php echo ($doctor["pic"]); ?>" class="floatingImg">
                    <p style="display:block; float:left;"><?php echo ($doctor["name"]); ?></p>
                    <a href="<?php echo U('User/doctor',array('id'=> $doctor['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">医生<br>详情</a>
            </div>
            <!-- <div id="loading" style="text-align:center;display:none;">
                <img src="<?php echo RES;?>/css/tys/loading.gif"></div> -->
            <input type="hidden" id="cmid" value="<?php echo ($cmid); ?>">
            <input type="hidden" id="noconsult" value="1">
            <div id="twrapper" style="overflow: hidden;">
                <div id="chat-messages" class="animate">
                    <div class="weui-pull-to-refresh-layer">
                      <div class='pull-to-refresh-arrow'></div>
                      <div class='pull-to-refresh-preloader'></div>
                      <div class="down">下拉刷新</div>
                      <div class="up">释放刷新</div>
                      <div class="refresh">正在刷新</div>
                    </div>
                    <div class="message_list">
                        <?php if(is_array($consultb)): $i = 0; $__LIST__ = $consultb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div class="message <?php if(($list["ctalk"]) == "1"): ?>right<?php else: ?>left<?php endif; ?>">
                                    <span><?php echo (friendlydate($list["time"])); ?></span>
                                    <input type="hidden" id="time" value="<?php echo ($list["time"]); ?>">
                                    <img src="<?php echo ($list["pic"]); ?>" />
                                    <div class="bubble">
                                        <?php echo ($list["content"]); ?>
                                </div>
                                <div class="clear"></div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
    <div id="sendmessage">
        <input type="hidden" id="cid" value="<?php echo ($custom["id"]); ?>">
        <input type="hidden" id="did" value="<?php echo ($doctor["id"]); ?>">
        <input type="hidden" id="checkcm" value="1">
        <input type="text" id="consultcon" value="" palceholder="发送信息" />
        <button onclick="send()" id="send">发送</button>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>
<script src="<?php echo RES;?>/js/tys/jquery-weui.js"></script>
<script>
    var messages = $('#chat-messages');
    var messageslist = messages.find('.message_list');
    var chat_nums = messages.find('.message ').length;
    //发送
    function send(){
        var con=$("#consultcon").val();
        var cid=$("#cid").val();
        var did=$("#did").val();
        var cmid=$("#cmid").val();
        var ccm=$("#checkcm").val();
        if(con){
            $.ajax({
                url:"<?php echo U('Consult/sendconsult',array('did'=>$doctor[id],'token'=>$token,'wecha_id'=>$wecha_id));?>",
                data:{cid:cid,did:did,cmid:cmid,con:con,ccm:ccm},
                success:function(data){
                    if(data!='error'){
                        messageslist.append(data);
                        $('#consultcon').val('');
                        $('#checkcm').val(0);

                        chat_nums = messages.find('.message ').length;
                        messages.animate({
                            scrollTop: 71*chat_nums
                        })
                    }
                }
            })
        }
    }
    //刷新咨询记录
    function refresh(){
        var time=$('.message').last().find('#time').val();
        var cid=$("#cid").val();
        var did=$("#did").val();
        $.ajax({
            url:"<?php echo U('Consult/refreshconsult',array('token'=>$token,'wecha_id'=>$wecha_id));?>",
            data:{cid:cid,did:did,time:time},
            async:false,
            success:function(data){
                if(data!="none"){
                    messageslist.append(data);

                    chat_nums = messages.find('.message ').length;
                    messages.animate({
                        scrollTop: 71*chat_nums
                    })
                }
            }
        })
    }
    $(function(){
        setInterval("refresh()",5000);
    })
    //下拉刷新
    $("#chat-messages").pullToRefresh().on("pull-to-refresh", function() {
      setTimeout(function() {
        $("#chat-messages").pullToRefreshDone();
        laodmore();
      }, 500);
    });
    //首次登陆滚动到最新位置
    messages.animate({
        scrollTop: 71*chat_nums
    })
    function laodmore(){
         var cmid=$("#cmid").val();
         var cnums = messages.find('.message ').length;
         var noconsult=$("#noconsult").val();
         if(noconsult==1){
             $.ajax({
                url:"<?php echo U('Consult/loadmore',array('token'=>$token,'wecha_id'=>$wecha_id));?>",
                data:{cmid:cmid,cnums:cnums},
                async:false,
                success:function(data){
                    if(data=="none"){
                        $("#noconsult").val(0);
                    }else{
                        messageslist.prepend(data);
                    }
                }
             })
         }
    }
</script>