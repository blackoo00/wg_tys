var OnBegin = function () {
}
var OnSuccess = function (result) {
    var result=eval('('+result+')');
    switch (result.res) {
        case "ok":
            if (result.msg) {
                alert(result.msg);
                if (result.url) {
                    window.location.href = result.url;
                }
                //alert_msg(result.msg, result.url, "alert-success");
            } else {
                window.location.href = result.url;
            }
            break;;
        case "fail":
            alert(result.msg);
            //alert_msg(result.msg, result.url, "alert-warning");
            break;
        default:
    }
}

var setLeftMenu = function (name) {
    if ($.cookie(name) != null) {
        var the = $(".sub-menu a[href='" + $.cookie(name) + "']");
        $(the).closest("li").addClass("active");
        var parent = $(the).parent().parent().parent();
        $(parent).addClass("active").addClass("open");
        $(parent).find(".arrow").addClass("open");
    }
    $(".sub-menu>li>a").click(function () {
        var id = $(this).attr("href");
        $.cookie(name, id, { expires: 365 });
    });
}

var alert_msg = function (msg, url, type) {
    message(msg, url, type);
};
function message(msg, url, type) {
    var modalobj = $("#portlet-config");
    var html = '<div class="modal-dialog "><div class="modal-content"><div class="modal-header ' + type + '"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">系统提示<span id="timeout" class="hidden"></span></h4></div><div class="modal-body ">' + msg + '</div></div></div>';
    if (modalobj.length == 0) {
        $(document.body).append('<div class="modal fade " id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true"></div>');
        modalobj = $("#portlet-config");
    }
    modalobj.html(html);
    $(".modal-dialog ul").addClass("list-unstyled");
    var timer = '';
    var timeout = 3;
    modalobj.find("#timeout").html(timeout);
    modalobj.on('shown.bs.modal', function () { doredirect(); });
    modalobj.on('hide.bs.modal', function () { timeout = 0; doredirect(); });
    modalobj.on('hidden.bs.modal', function () { modalobj.remove(); });
    function doredirect() {
        timer = setTimeout(function () {
            if (timeout <= 0) {
                modalobj.modal('hide');
                clearTimeout(timer);
                if (url) {
                    window.location.href = url;
                }
                return;
            } else {
                timeout--;
                modalobj.find("#timeout").html(timeout);
                doredirect();
            }
        }, 1000);
    }
    return modalobj.modal();
}

var handleUniform = function () {
    if (!jQuery().uniform) {
        return;
    }
    var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
    if (test.size() > 0) {
        test.each(function () {
            if ($(this).parents(".checker").size() == 0) {
                $(this).show();
                $(this).uniform();
            }
        });
    }
}

//设置添加数据验证，弹出框提示
var setModelValidate = function () {
    var showValidationSummaryDialog = function () {
        var msg_error = $(".validation-summary-errors").html();
        if (msg_error != undefined) {
            alert_msg(msg_error, "", "alert-warning");
        }
        $('.validation-summary-errors').hide();
    }
    showValidationSummaryDialog();
    $('form').bind('invalid-form.validate', function (error, element) {
        showValidationSummaryDialog();
    });
};