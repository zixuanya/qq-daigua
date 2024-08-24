//function initBackTop() {
//    var $backToTopTxt = "";
//    var w_width = $(window).width();

//    var $backToTopEle = $('<div class="backToTop"></div>').appendTo($("body")).css("right", ((w_width - 960) / 2 - 63) + "px")

//        .text($backToTopTxt).attr("title", $backToTopTxt).click(function () {

//            $("html, body").animate({ scrollTop: 0 }, 120);

//        });
//    var $backToTopFun = function () {

//        var st = $(document).scrollTop(), winh = $(window).height();

//        (st > 500) ? $backToTopEle.show() : $backToTopEle.hide();

//        //IE6下的定位

//        if (!window.XMLHttpRequest) {
//            $backToTopEle.css("top", st + winh - 166);
//        }

//    };

//    $(window).bind("scroll", $backToTopFun);
//    $(function () { $backToTopFun(); });
//}

function loadImage(elem, width, height) {
    $(elem).css({ width: "auto", height: "auto" });

    var smallWidth = $(elem).width();
    var smallHeight = $(elem).height();
    var iwidth = width;
    var iheight = height; 
    if (smallWidth > 0 && smallHeight > 0) {

        if (smallWidth / smallHeight >= iwidth / iheight) {
            if (smallWidth > iwidth) {
                $(elem).width(iwidth).height((smallHeight * iwidth) / smallWidth).css("padding", Math.floor(Math.abs((iheight - $(elem).height()) / 2)) + "px 0px");
            } else {
                $(elem).width(smallWidth).height(smallHeight).css("padding", Math.floor(Math.abs((iheight - $(elem).height()) / 2)) + "px " + Math.floor(Math.abs((iwidth - $(elem).width()) / 2)) + "px");
            }
        }
        else {
            if (smallHeight > iheight) {
                $(elem).width((smallWidth * iheight) / smallHeight).height(iheight).css("padding", "0px " + Math.floor(Math.abs((iwidth - $(elem).width()) / 2)) + "px");
            } else {
                $(elem).width(smallWidth).height(smallHeight).css("padding", Math.floor(Math.abs((iheight - $(elem).height()) / 2)) + "px " + Math.floor(Math.abs((iwidth - $(elem).width()) / 2)) + "px");
            }
        }
    }
}

function loadImageError(elem, selector) {
    selector == undefined ? $(elem).remove() : $(elem).parents(selector + ":first").remove();
}

function addFavorite() {
    try {
        window.external.addFavorite(window.location.href, document.title);
    } catch (e) {
        try {
            window.sidebar.addPanel(document.title, window.location.href, "");
        } catch (ex) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
} 