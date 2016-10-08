requirejs.config({//设置别名
	paths:{
		jquery:'jquery-1.11.1.min',
		fileup:'ajaxfileupload',
	}
});

requirejs(['jquery','fileup'],function($,fileup){
	// $("#stars span").click(function(){
	// 	var ltindex=$(this).index()+1;
	// 	var gtindex=$(this).index();
	// 	$("#stars span:lt("+ltindex+")").css('background-position','0 0').attr('data-star','1');
	// 	$("#stars span:gt("+gtindex+")").css('background-position','0 17px').attr('data-star','0');
	// 	var starnum=$(this).parent().children("span[data-star=1]").size();
	// 	$(this).siblings("input").val(starnum);
	// })
})
//图片上传Ajax
// function ajaxFileUpload(action){
// 	if($(".thumbnail ul li").length>4){
// 		alert("最多上传5张图片");
// 		return false;
// 	}
// 	$("#loading").show();
// 	$.ajaxFileUpload ({
// 		 url:action,
// 		 secureuri:false,
// 		 fileElementId:'pic',
// 		 dataType: 'json',
// 		 success: function (data){
// 		 	$("#loading").hide();
// 			$(".thumbnail ul").append("<li style='display:inline-block;'><img src="+data.split("@")['1']+"></li>");
// 			$('#uppic').val($('#uppic').val()+data+",");
// 		 }
		 
// 		 }) 
// 		 return false;
// }
//上传孕育师头像
function headpic(url,did){
	$("#loading").show();
	$.ajaxFileUpload ({
		 url: url,
		 type: 'post',//如果有自定义数据DATA需要设置POST 不能使用GET
		 data: {id: did},
		 secureuri:false,
		 fileElementId:'pic',
		 dataType: 'json',
		 success: function (data){
		 	 $("#loading").hide();
		 	 $("#doctorpic").attr("src",data);
		 }
	}) 
		 return false;
}
//上传化验图片
function laboratorypic(url){
	console.log(url);
	$("#loading").show();
	$.ajaxFileUpload ({
		 url: url,
		 secureuri:false,
		 fileElementId:'pic',
		 dataType:'json',
		 success: function (data){
		 	 console.log(data);
		 	 $("#loading").hide();
		 	 if(data=="ok"){
		 	 	location.reload()
		 	 }
		 }
	}) 
		 return false;
}