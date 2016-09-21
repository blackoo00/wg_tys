(function ($) {      
    $.fn.date = function (options,fcallback) {   
        //插件默认选项
        var that = $(this);
        var docType = $(this).is('input');
        var indexY=1,indexM=1;
        var initY=0;
        var initM=1;
        var yearScroll=null,monthScroll=null;
        $.fn.date.defaultOptions = {
            beginnum:150,                 //日期--年--份开始
            endnum:190,                   //日期--年--份结束
            interval:1,             
            beginnum2:1,                   //日期--月--份结束
            endnum2:12,                    //日期--月--份结束
            interval2:1,
            mode:null,                       //操作模式（滑动模式）
            event:"click",                    //打开日期插件默认方式为点击后后弹出日期 
            show:true
        }
        //用户选项覆盖插件默认选项   
        var opts = $.extend( true, {}, $.fn.date.defaultOptions, options);
        if(!opts.show){
            that.unbind('click');
        }
        else{
            //绑定事件（默认事件为获取焦点）
            that.bind(opts.event,function () {
                createUL();      //动态生成控件显示的日期
                init_iScrll();   //初始化iscrll
                extendOptions(); //显示控件
                that.blur();
                refreshDate();
                bindButton();
            })  
        };
        function refreshDate(){
            yearScroll.refresh();
            monthScroll.refresh();

            resetInitDete();
            yearScroll.scrollTo(0, initY*40, 100, true);
            monthScroll.scrollTo(0, initM*40-40, 100, true);
        }
    function resetIndex(){
            indexY=1;
            indexM=1;
        }
        function resetInitDete(){
            var num1=Math.floor(($("#yearwrapper ul li").length-2)/2);
            var num2=Math.floor(($("#monthwrapper ul li").length-2)/2);
            initY = num1-1;
            initM = num2;
        }
        function bindButton(){
            resetIndex();
            $("#dateconfirm").unbind('click').click(function () {   
                // var datestr = $("#yearwrapper ul li:eq("+indexY+")").html()+"-"+
                //           $("#monthwrapper ul li:eq("+indexM+")").html();
                var datestr=fcallback($("#yearwrapper ul li:eq("+indexY+")").html(),$("#monthwrapper ul li:eq("+indexM+")").html());
                that.val(datestr);
                that.html(datestr);
                $("#test").val(datestr);

                $("#datePage").hide(); 
                $("#dateshadow").hide();
            });
            $("#datecancle").click(function () {
                $("#datePage").hide(); 
            $("#dateshadow").hide();
            });
        }       
        function extendOptions(){
            $("#datePage").show(); 
            $("#dateshadow").show();
        }
        //日期滑动
        function init_iScrll() { 
              yearScroll = new iScroll("yearwrapper",{snap:"li",vScrollbar:false,
                  onScrollEnd:function () {
                       indexY = (this.y/40)*(-1)+1;
                  }});
              monthScroll = new iScroll("monthwrapper",{snap:"li",vScrollbar:false,
                  onScrollEnd:function (){
                      indexM = (this.y/40)*(-1)+1;
                  }});
        }
        function  createUL(){
            CreateDateUI();
            $("#yearwrapper ul").html(createYEAR_UL());
            $("#monthwrapper ul").html(createMONTH_UL());
        }
        function CreateDateUI(){
            var str = ''+
                '<div id="dateshadow"></div>'+
                '<div id="datePage" class="page">'+
                    '<section>'+
                        '<div id="datetitle"><h1>'+opts.title1+'</h1><h1>'+opts.title2+'</h1></div>'+
                        '<div id="datemark"><a id="markyear"></a><a id="markmonth"></a></div>'+
                        '<div id="datescroll">'+
                            '<div id="yearwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                            '<div id="monthwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                        '</div>'+
                    '</section>'+
                    '<footer id="dateFooter">'+
                        '<div id="setcancle">'+
                            '<ul>'+
                                '<li id="dateconfirm">确定</li>'+
                                '<li id="datecancle">取消</li>'+
                            '</ul>'+
                        '</div>'+
                    '</footer>'+
                '</div>'
            $("#datePlugin").html(str);
        }
        //创建 --年-- 列表
        function createYEAR_UL(){
            var str="<li>&nbsp;</li>";
            // for(var i=opts.beginnum; i<=opts.endnum;i++){
            //     str+='<li>'+i+'</li>'
            // }
            i=opts.beginnum;
            do{
                str+='<li>'+i+'</li>';
                i=i+opts.interval;
            }
            while (i<=opts.endnum) 
            return str+"<li>&nbsp;</li>";;
        }
        //创建 --月-- 列表
        function createMONTH_UL(){
            var str="<li>&nbsp;</li>";
            // for(var i=opts.beginmonth;i<=opts.endmonth;i++){
            //     if(i<10){
            //         i="0"+i
            //     }
            //     str+='<li>'+i+'</li>'
            // }
            i=opts.beginnum2;
            do{
                str+='<li>'+i+'</li>';
                i=i+opts.interval2;
            }
            while (i<=opts.endnum2) 
            return str+"<li>&nbsp;</li>";;
        }
    }
})(jQuery);  
