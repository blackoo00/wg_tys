<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>会员登陆</title>
    <link rel="stylesheet" href="<?php echo RES;?>/original/css/style.css">

    <script src="<?php echo RES;?>/js/jquery-1.11.1.min.js" type="text/javascript" charset="utf-8"></script>

    <link rel="stylesheet" href="<?php echo RES;?>/original/css/notification.css">
    <script src="<?php echo RES;?>/original/js/notification.js" type="text/javascript" charset="utf-8"></script>

    <style>
*::-webkit-input-placeholder { 
color: #fefefe; 
} 
*:-moz-placeholder { 
color: #fefefe; 
} 
*:-ms-input-placeholder { 
/* IE10+ */ 
color: #fefefe; 
} 
</style>
</head>

<body id="scnhtm5">
    <div class="container">
        <div class="login_content">
            <div class="bg">
                <img src="<?php echo RES;?>/original/images/bg1.jpg">
            </div>
            <div class="xx">
                <div class="top">
                    <div class="tx">
                        <img src="<?php echo ($company["logourl"]); ?>">
                    </div>
                </div>
                <form id="form1" name="form1" method="post" action="#">
                    <div class="text"> <i class="icon1 iconfont">&#xe6ca;</i>
                        <input name="username" id="username" type="text" class="name" value="" placeholder="微信号"/>
                    </div>
                    <div class="text"> <i class="icon1 iconfont">&#xe618;</i>
                        <input name="password" id="password" type="password" class="name" value="" placeholder="密码"/>
                    </div>
                    <input type="hidden" name="nologin" id="nologin" />
                </form>
                <p style="text-align: center;">
                    <input type="checkbox" id="nologin_30"/>
                    &nbsp;&nbsp;
                    <label for="nologin_30" style="color: #ddd;">30天免登陆</label>
                </p>
                <div class="clear"></div>
                <div class="text1">
                    <input type="button" class="tj" id="form-submit" value="登陆"/>
                </div>
                <p style="text-align: center;line-height: 37px;color: #ffffff;">
                    <a href="<?php echo U('Distribution/register');?>">注册账号</a>
                </p>
            </div>
        </div>

        <script>
        (function($){
            //30天免登陆
            $('#nologin_30').on('click',function(){
                if($(this).is(":checked")){
                    $('#nologin').val(1);
                }else{
                    $('#nologin').val(0);
                }
            })
            //登陆操作
            var submit_btn=$("#form-submit");
            submit_btn.on("click",function(){
                var password=$("#password").val();
                var name=$("#name").val();
                if(name==""){
                    return floatNotify.simple('请输入姓名');
                    return false;
                }
                if(password==""){
                    return floatNotify.simple('请输入手机号码');
                    return false;
                }
                $('#form1').submit();
                // $.ajax({
                //     url:"<?php echo U('Distribution/register',array('token'=>$_GET['token'],'wecha_id'=>$wecha_id));?>",
                //     data:{password:password,name:name},
                //     type:"post",
                //     dataType:"json",
                //     success:function(data){
                //         console.log(data);
                //         if(data.status==1){
                //             location.href="<?php echo U('Distribution/index',array('token'=>$_GET['token'],'wecha_id'=>$wecha_id));?>";
                //         }else{
                //             floatNotify.simple(data.info);
                //         }
                //     }
                // });
            })
        })(jQuery)
    </script>

    </div>
</body>
</html>