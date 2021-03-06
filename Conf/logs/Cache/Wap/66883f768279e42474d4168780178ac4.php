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
	<title><?php echo ($title); ?></title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/default.css">
    <link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/tys/css/jquery-weui.min.css">
    <div class="htmleaf-container" style="max-width:640px; margin:0 auto; width:100%;">
            <div class="htmleaf-content bgcolor-3">
                <div id="chatbox">

                    <div id="chatview" class="p1" style="display: block;">      
<!--                         <div id="profile" class="animate">
                            <img style="vertical-align:middle; width: 80px; height:80px;" src="<?php echo ($custom["pic"]); ?>" class="floatingImg"> 
                            <p style="display:block; float:left;"><?php echo ($custom["name"]); ?></p>
                            <a href="<?php echo U('Doctor/cdetails',array('id'=>$custom['id'],'token'=>$token,'wecha_id'=>$wecha_id));?>">孕妈<br>详情</a>
                        </div> -->
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
                                    <?php if(is_array($consultb)): $i = 0; $__LIST__ = $consultb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div class="message <?php if(($list["dtalk"]) == "1"): ?>right<?php else: ?>left<?php endif; ?>">
                                           <span><?php echo (friendlydate($list["time"])); ?></span>
                                           <input type="hidden" id="time" value="<?php echo ($list["time"]); ?>">
                                           <?php if(($list["dtalk"]) == "1"): ?><img src="<?php echo ($list["doctor"]["pic"]); ?>" /><?php else: ?><img src="<?php echo ($list["custom"]["pic"]); ?>" /><?php endif; ?>
                                            <div class="bubble">
                                                <?php echo ($list["content"]); ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                            <div id="here"></div>
                        </div>
                        <div id="sendmessage">
                            <input type="hidden" id="cid" value="<?php echo ($custom["id"]); ?>">
                            <input type="hidden" id="did" value="<?php echo ($did); ?>">
                            <input type="hidden" id="checkcm" value="1">
                            <input type="hidden" id="dip" value="<?php echo ($consultm["dip"]); ?>">
                            <input type="hidden" id="cip" value="<?php echo ($consultm["cip"]); ?>">
                            <input type="hidden" id="dpic" value="<?php echo ($doctor["pic"]); ?>">
                            <input type="hidden" id="cpic" value="<?php echo ($custom["pic"]); ?>">
                            <input type="hidden" id="client_type" value="doctor">
                            <textarea rows="1" id="consultcon"></textarea>
                            <!-- <textarea rows="1" id="consultcon"></textarea> -->
                            <!-- <button id="message_send">发送</button> -->
                        </div>
                    </div>      
                </div>  
            </div>
        </div>
</body>
</html>
<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js"></script>
<script src="<?php echo RES;?>/js/tys/jquery-weui.js"></script>
<script src="<?php echo RES;?>/websorcket/fancywebsocket.js"></script>
<script src="<?php echo RES;?>/js/tys/consult.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/websorcket/sorcket.js"></script>
<script>
    $(document).ready(function() {

      //发送
      $('#consultcon').keypress(function(e) {
        if ( e.keyCode == 13 && this.value ) {
          e.preventDefault()
          clearInterval(this.clock);activeobj.style.height='35px';
          var con=$("#consultcon").val();
          var ccm=$("#checkcm").val();
          var cip = $('#cip').val();

          var messgae_data = [{'con':con},{'ip':cip},{'fromid':did},{'toid':cid}];
          send_con = JSON.stringify(messgae_data);

          //判断孕妈是否在聊天框和是否连接上
          if(cip && connect == 1){
            send( send_con );
          }
          $('#consultcon').val('');
          $('#consultcon').focus();


          //当链接上的时候保存聊天记录
          if(con){
            if(connect == 1){
              log( con );
              $.ajax({
                  url:"<?php echo U('Consult/sendconsult2',array('token'=>$token,'wecha_id'=>$wecha_id));?>",
                  data:{cid:cid,did:did,cmid:cmid,con:con,ccm:ccm},
                  async:false,
                  success:function(data){
                      if(data!='error'){
                          $('#checkcm').val(0);
                          chat_nums = messages.find('.message ').length;
                          messages.animate({
                              scrollTop: 71*chat_nums
                          })
                      }
                  }
              })
            }else{
              log( con ,'error');
            }
          }
        }
      });

      //Log any messages sent from server
      Server.bind('message', function( payload ) {
        console.log(payload);
        if (payload.match("^\{(.+:.+,*){1,}\}$"))
        {
            var cip = jQuery.parseJSON(payload).clientID;
            var myip = jQuery.parseJSON(payload).myID;
            var dip =  $('#dip').val();
            var old_cip =  $('#cip').val();
            //更新自己IP
            if(myip && myip != dip){
              $('#dip').val(myip);
              $.ajax({
                  url:"<?php echo U('Consult/updateDip');?>",
                  data:{cmid:cmid,dip:myip},
              })
            }
            //判断新加入的是否是自己的孕妈
            if(cip && cip != old_cip){
              $.ajax({
                  url:"<?php echo U('Consult/judgeCustom');?>",
                  data:{cmid:cmid,cip:cip},
                  async:false,
                  success:function(data){
                      if(data.status == 1){
                        $('#cip').val(cip);
                      }
                  }
              })
            }
        }else{
            var con = eval(payload)[0]['con'];
            var fromid = eval(payload)[2]['fromid'];

            if(fromid && fromid == cid){
              log( con, '' ,'left');
            }
        }
        //判断是否是JSON数据
        // if (!payload.match("^\{(.+:.+,*){1,}\}$"))
        // {
        //     log( payload, '' ,'left');
        // }
      });
    });

    //刷新咨询记录
    function refresh(){
        var time=$('.message').last().find('#time').val();
        var cid=$("#cid").val();
        var did=$("#did").val();
        $.ajax({
            url:"<?php echo U('Consult/refreshconsult2',array('token'=>$token,'wecha_id'=>$wecha_id));?>",
            data:{cid:cid,did:did,time:time},
            async:false,
            success:function(data){
                if(data!="none"){
                    log(data);

                    chat_nums = messages.find('.message ').length;
                    messages.animate({
                        scrollTop: 71*chat_nums
                    })
                }
            }
        })
    }
</script>