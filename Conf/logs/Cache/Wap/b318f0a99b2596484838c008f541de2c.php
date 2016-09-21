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
	<!--[if IE]>
		<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
	<![endif]-->
    <div class="htmleaf-container">
    		<div class="htmleaf-content bgcolor-3">
    			<div id="chatbox">
    				<div id="friendslist">
    			        <div id="friends">
    			        	<div class="friend">
    			            	<img src="<?php echo RES;?>/css/tys/images/1_copy.jpg" />
    			                <p>
    			                	<strong>Miro Badev<br></strong>
    				                <span>mirobadev@gmail.commirobadev@gmail.commirobadev@gmail.com</span>
    			                </p>
    			                <div class="status available"></div>
    			            </div>
    			            <div id="search">
    				            <input type="text" id="searchfield" value="Search contacts..." />
    			            </div>
    			            
    			        </div>                
    			        
    			    </div>	
    			    
    			    <div id="chatview" class="p1">    	
    			        <div id="profile">

    			            <div id="close">
    			                <div class="cy"></div>
    			                <div class="cx"></div>
    			            </div>
    			            
    			            <p>Miro Badev</p>
    			            <span>miro@badev@gmail.com</span>
    			        </div>
    			        <div id="chat-messages">
    			        	<label>Thursday 02</label>
    			            
    			            <div class="message">
    			            	<img src="<?php echo RES;?>/css/tys/images/1_copy.jpg" />
    			                <div class="bubble">
    			                	Really cool stuff!
    			                    <div class="corner"></div>
    			                    <span>3 min</span>
    			                </div>
    			            </div>
    			            
    			            <div class="message right">
    			            	<img src="<?php echo RES;?>/css/tys/images/2_copy.jpg" />
    			                <div class="bubble">
    			                	Can you share a link for the tutorial?
    			                    <div class="corner"></div>
    			                    <span>1 min</span>
    			                </div>
    			            </div>
    			            
    			        </div>
    			    	
    			        <div id="sendmessage">
    			        	<input type="text" value="Send message..." />
    			            <button id="send">发送</button>
    			        </div>
    			    
    			    </div>        
    			</div>	
    		</div>
    	</div>
    	
    	<script src="<?php echo RES;?>/js/tys/jquery-1.11.1.min.js"></script>
    	<script>
    	$(document).ready(function () {
    	    var preloadbg = document.createElement('img');
    	    preloadbg.src = 'img/timeline1.png';
    	    $('#searchfield').focus(function () {
    	        if ($(this).val() == 'Search contacts...') {
    	            $(this).val('');
    	        }
    	    });
    	    $('#searchfield').focusout(function () {
    	        if ($(this).val() == '') {
    	            $(this).val('Search contacts...');
    	        }
    	    });
    	    $('#sendmessage input').focus(function () {
    	        if ($(this).val() == 'Send message...') {
    	            $(this).val('');
    	        }
    	    });
    	    $('#sendmessage input').focusout(function () {
    	        if ($(this).val() == '') {
    	            $(this).val('Send message...');
    	        }
    	    });
    	    $('.friend').each(function () {
    	        $(this).click(function () {
    	            var childOffset = $(this).offset();
    	            var parentOffset = $(this).parent().parent().offset();
    	            var childTop = childOffset.top - parentOffset.top;
    	            var clone = $(this).find('img').eq(0).clone();
    	            var top = childTop + 12 + 'px';
    	            $(clone).css({ 'top': top }).addClass('floatingImg').appendTo('#chatbox');
    	            setTimeout(function () {
    	                $('#profile p').addClass('animate');
    	                $('#profile').addClass('animate');
    	            }, 100);
    	            setTimeout(function () {
    	                $('#chat-messages').addClass('animate');
    	                $('.cx, .cy').addClass('s1');
    	                setTimeout(function () {
    	                    $('.cx, .cy').addClass('s2');
    	                }, 100);
    	                setTimeout(function () {
    	                    $('.cx, .cy').addClass('s3');
    	                }, 200);
    	            }, 150);
    	            $('.floatingImg').animate({
    	                'width': '68px',
    	                'left': '108px',
    	                'top': '20px'
    	            }, 200);
    	            var name = $(this).find('p strong').html();
    	            var email = $(this).find('p span').html();
    	            $('#profile p').html(name);
    	            $('#profile span').html(email);
    	            $('.message').not('.right').find('img').attr('src', $(clone).attr('src'));
    	            $('#friendslist').fadeOut();
    	            $('#chatview').fadeIn();
    	            $('#close').unbind('click').click(function () {
    	                $('#chat-messages, #profile, #profile p').removeClass('animate');
    	                $('.cx, .cy').removeClass('s1 s2 s3');
    	                $('.floatingImg').animate({
    	                    'width': '40px',
    	                    'top': top,
    	                    'left': '12px'
    	                }, 200, function () {
    	                    $('.floatingImg').remove();
    	                });
    	                setTimeout(function () {
    	                    $('#chatview').fadeOut();
    	                    $('#friendslist').fadeIn();
    	                }, 50);
    	            });
    	        });
    	    });
    	});
    	</script>
</body>
</html>