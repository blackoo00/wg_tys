/*
	cmid : 聊天房ID
	did  : 孕育师ID
	cid  : 孕妈ID

 */
var cmid=$("#cmid").val();
var did=$("#did").val();
var cid=$("#cid").val();
/*
	messages ：聊天外框
	message_list ：聊天信息列表
	chat_nums ：页面聊天条数(滚动到底部用)

 */
var messages = $('#chat-messages');
var messageslist = messages.find('.message_list');
var chat_nums = messages.find('.message ').length;

var dpic = $('#dpic').val();
var cpic = $('#cpic').val();

var client_type = $('#client_type').val();

$(function(){
	$('#consultcon').on('keydown',function(){
	    window.activeobj=this;
	    var con = $("#consultcon").val();
	    if(con != ''){
	      this.clock=setInterval(function(){
	        activeobj.style.height=activeobj.scrollHeight +'px';
	      },10);
	    }
	})

	$('#consultcon').on('blur',function(){
	    clearInterval(this.clock);
	})
	//设置聊天框高度
	// var top_h = $('#profile').height();
	var bot_h = $('#sendmessage').height();
	var w_h = $(window).height();
	var log_h = w_h-bot_h+18;
	$('#chat-messages').height(log_h);
})


//写入聊天版
function log(text,type,direction,lpic,rpic){
  var str = '';
  str += "<div class='message ";
  if(direction == 'left'){
    str += "left'>";
  }else{
    str += "right'>";
  }
  if(direction == 'left'){
  	if(client_type == 'doctor'){
    	str +=   "<img src='"+cpic+"' />";
  	}else{
  		str +=   "<img src='"+dpic+"' />";
  	}
  }else{
	if(client_type == 'doctor'){
  	str +=   "<img src='"+dpic+"' />";
	}else{
		str +=   "<img src='"+cpic+"' />";
	}
  }
  str +=     "<div class='bubble'>";
  str +=       text;
  str +=     "</div>";
  if(type == 'error'){
    str += '<div class="send_error iconfont">&#xe604;</div>';
  }
  str +=     "<div class='clear'></div>";
  str += "</div>";

  messageslist.append(str);

  chat_nums = messages.find('.message ').length;
  messages.animate({
      scrollTop: 71*chat_nums
  })
}

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
             url:"/wg_tys/index.php?g=Wap&m=Consult&a=loadmore",
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