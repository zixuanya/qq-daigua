$(function () {
    $('.sidebar-nav-list').sidebarNav();
    $('#nav').nav();
    $('#J-kf').kf();
    $('.index-top').indexHeader();
    $('body').fullScreen();
    $('.spe_listbox').successList({ topDistance: 88 })
    $('.thin_listbox').successList({ topDistance: 182 })
    $('.dx_fsep').tabSimp()
    //$('.sec_frim .item:odd').css('background', 'blue')
    // $('.sec_frim .item:even').css('background', 'green')
    $('.ability_wrap').phoneClick()
    $('.index-slider').indexTabs()
});
(function ($) {
	$.fn.zdTabs=function(){
		if(this.length == 0) return this;
        
		if(this.length > 1){
			this.each(function(){$(this).memberTabs()});
			return this;
		}	
		var $this=$(this),
			$hd=$this.find('div.zd_tabs_hd>span'),
			$bd=$this.find('div.zd_tabs_bd>div.item');
		$hd.bind('click',function(){
			var index=$(this).index()
			$(this).addClass('curr').siblings().removeClass('curr');
			$bd.eq(index).addClass('curr').siblings().removeClass('curr');
			return false;
		})
		
	}
    $.fn.zxbslider = function () {
        return this.each(function () {
            var $this = $(this),
				$p = $this.find('p'),
				i = 1;
            $p.eq(0).css({ zIndex: 10 })
            function Sliser() {
                $p.css({ position: "absolute", opacity: 0, zIndex: 10 - 1 }).eq(i).css("zIndex", 10).animate({ "opacity": 1 }, function () {
                    if (i >= 2) { i = 0 }
                    else { i++ }
                    setTimeout(Sliser, 3000)
                });
            }
            setTimeout(Sliser, 3000)
        })
    }
    $.fn.indexTabs = function () {
        return this.each(function () {
            var $this = $(this),
				$span = $this.find('div.tabs-hd>div>span'),
				$con = $this.find('div.tabs-bd>div.con')
            $b = $this.find('div.tabs-hd>b');
            $span.bind('click', function () {
                var index = $(this).index(), _el = $(this);
                $b.animate({ 'left': $(this).position().left }, function () {
                    _el.addClass('curr').siblings().removeClass('curr');
                    $con.eq(index).addClass('curr').siblings().removeClass('curr');
                });
            })
        })
    }
    $.fn.fullScreen = function () {
        var $this = $(this),
			mWidth = $(window).width(),
			_size = function () {
			    if (mWidth < 1280) { mWidth = 1280 }
			    $this.css({ 'width': mWidth })
			}
        _size();
        $(window).resize(function () {
            mWidth = $(window).width();
            _size();
        });
    };
    $.fn.indexHeader = function () {
        var $this = $(this),
			wHeight = $(window).height(),
			$header = $('.index-header-wrap'),
			$down = $('.index-down>a'),
			$intro = $('.index-intro'),
			$btn = $('.index-btn>a'),
			_height = function () {
			    if (wHeight < 650) { wHeight = 650 }
			    $this.height(wHeight)
			    _size();
			},
			_size = function () {
			    var mWidth = $(window).width();
			    if (mWidth < 1360) {
			        $intro.addClass('ft')
			    }
			    else {
			        $intro.removeClass('ft')
			    }
			    var mTop = (wHeight - 500) / 2;
			    if (mTop < 100) { mTop = 100 }
			    $intro.css({ 'margin-top': mTop })
			};
        (function init() {
            $('#J-kf').hide();
            _height();
        })();
        $(window).resize(function () {
            wHeight = $(window).height();
            _height();
        });
        $(window).scroll(function () {
            var Top = $(window).scrollTop();
            if (Top >= $(window).height()) {
                $header.addClass('index-scrollTop');
                $('#J-kf').show();
            } else {
                $header.removeClass('index-scrollTop');
                $('#J-kf').hide();
            }
        })
        $down.bind('click', function () {
            $('body,html').animate({ scrollTop: wHeight }, 500);
        })
        $btn.bind('click', function () {
            var ii = $(this).index();
            $('body,html').animate({ scrollTop: $('.index-box-' + (ii + 1)).offset().top }, 500 * (ii + 1));
        })
    }
    $.fn.kf = function () {
        var $this = $(this),
			$button = $this.find('.kf-button>a'),
			$wrap = $this.find('.kf-wrap'),
			$colse = $this.find('.kf-colse>a'),
			$ewm = $this.find('.ewm>a'),
			$top = $this.find('.top>a'),
			$ewmBox = $this.find('.ewm-box'),
			steep = 300;
        $button.bind('click', function () {
            $button.parent().animate({
                opacity: 0
            }, steep, function () {
                $wrap.show().animate({ opacity: 1 }, steep)
            })
        })
        $colse.bind('click', function () {
            $wrap.animate({
                opacity: 0
            }, steep, function () {
                $button.parent().animate({ opacity: 1 }, steep)
            }).hide()
        })
        $top.bind('click', function () {
            $('body,html').animate({ scrollTop: 0 }, steep);
        })
        $ewm.hover(function () {
            $ewmBox.show()
        }, function () {
            $ewmBox.hide()
        })
        var Location = function () {
            if ($(window).width() < 1400) {
                $this.addClass('kf-online-right')
            } else {
                $this.removeClass('kf-online-right')
            }
        }
        Location();
        $(window).resize(function (e) {
            Location()
        });
    };
    $.fn.sidebarNav = function () {
        var $this = $(this);
        var init = function () {
            $this.find('p.curr').next("div.sidebar-nav-body").show()
        }
        init();
        $this.find('p.sidebar-nav-head').click(function () {
            var $p = $(this);
            if ($p.is('.curr')) { return false }
            $p.next("div.sidebar-nav-body").slideToggle(300).siblings("div.sidebar-nav-body").slideUp("slow", function () {
                $p.addClass('curr').siblings().removeClass('curr');
            });
        });
    };

    /**************/
    $.fn.successList = function (options) {
        var opts = $.extend({}, $.fn.successList.defaults, options);
        return this.each(function () {
            var $this = $(this)
            var topDistance = opts.topDistance
            $this.each(function (index, element) {
                $(this).find('li').bind('mouseenter', function () {
                    $(this).addClass('oncurr')
                    $(this).find('.ball_box').stop(false, true).animate({ top: topDistance }, 500, 'easeOutBounce')
                }).bind('mouseleave', function () {
                    $(this).removeClass('oncurr')
                    $(this).find('.ball_box').stop(false, true).animate({ top: -90 }, 200, 'easeInCirc')
                })
            });
        })
    }
    $.fn.successList.defaults = {
        topDistance: ''
    }

    $.fn.tabSimp = function (options) {
        var opts = $.extend({}, $.fn.tabSimp.defaults, options);
        return this.each(function () {
            var $this = $(this)
            var $tabtit = $this.find('.tab_tit')
            var $tabthen = $this.find('.tab_then')
            $tabtit.find('span:first').addClass('cur')
            $tabthen.find('.item').hide()
            $tabthen.find('.item:first').show()

            $tabtit.find('span').each(function (index, element) {
                var Ind = $(this).index()
                $(this).bind('click', function () {
                    var Ind = $(this).index()
                    $(this).addClass('cur')
                    $(this).siblings().removeClass('cur')
                    $tabthen.find('.item').hide()
                    $tabthen.find('.item').eq(Ind).show()
                })
            });
        })
    }
    $.fn.tabSimp.defaults = {
        topDistance: ''
    }

    $.fn.phoneClick = function (options) {
        var opts = $.extend({}, $.fn.phoneClick.defaults, options);
        return this.each(function () {
            var $this = $(this)
            $('.icon_tab').find('.item:first').addClass('oncurrent')
            //$('.sec_frim').find('.item:first').show().siblings().hide()
            //$('.sep_abilitythen').find('.item:first').show().siblings().hide()
            loadContentPage($('.icon_tab').find('.item:first').attr("catid"));
            $('.icon_tab').find('.item').each(function (index, element) {
                $(this).bind('mouseenter', function () {
                    $(this).addClass('current')
                }).bind('mouseleave', function () {
                    $(this).removeClass('current')
                })
                $(this).bind('click', function () {
                    var Ind = index
                    var catid = $(this).attr("catid");
                    loadContentPage(catid);
                    $('.icon_tab').find('.item').removeClass('oncurrent')
                    $(this).addClass('oncurrent')
                    //$('.sec_frim').find('.item').eq(Ind).show().siblings().hide()
                    // $('.sep_abilitythen').find('.item').eq(Ind).show().siblings().hide()
                })
            });
        })
    }
    $.fn.phoneClick.defaults = {
    }

    $.fn.caseFunc = function (options) {
		
        return this.each(function () {
				var defaults = {
						dirLeft: "case-dirlf",
						dirRight: "case-dirrt",
						listClass: "case-scrolist",
						viewLen: 3
					}
				var opts = $.extend({}, defaults, options);
            var $dirLf = $(this).find("." + opts.dirLeft);
            var $dirRt = $(this).find("." + opts.dirRight);
            var $list = $(this).find("." + opts.listClass).eq(0);
            var len = $list.children("li").length;
            var width = $list.children("li").eq(0).outerWidth(true);
            var totalWidth = len * width;
            if (len > opts.viewLen) {
                var $html = $list.html();
                var lfWidth = (len - opts.viewLen) * width + totalWidth;
                var posLf = (len-1) * width;
                $list.append($html);
                $list.css("width", totalWidth * 2).css("left", -totalWidth);

                $dirLf.bind("click", function () {
                    if (!$list.is(":animated")) {
                        $list.stop(true, false).animate({ left: "+=" + width }, 200, function () {
                            if (Math.abs(parseInt($list.css("left"))) <= 0) {
                                $list.css("left", -totalWidth)
                            }
                        })
                    }
                    return false;
                })

                $dirRt.bind("click", function () {
                    if (!$list.is(":animated")) {
                        $list.stop(true, false).animate({ left: "-=" + width }, 200, function () {
							console.log(Math.abs(parseInt($list.css("left"))) +";"+ lfWidth)
                            if (Math.abs(parseInt($list.css("left"))) >= lfWidth) {
                               $list.css("left", -((len-defaults.viewLen-1)*width))
                            }
                        })
                    }
                    return false;
                })
            } else {
                $dirRt.bind("click", function () { return false })
                $dirLf.bind("click", function () { return false })
            }
        });
    }
})(jQuery);

function loadContentPage(catid) {
    $.post("/Admin/WebDesign/LoadDataHandler.ajax", { action: "loadContentPage", categoryId: catid }, function (rs) {
        if (rs.success) {
            $("#ifContentPage").attr("src", rs.urlPath);
            $("#contentPage").html(rs.contents);
        }
    }, "json");
}

$(function () {
    var url = location.href;

    if (url.indexOf('/helplist/') > -1) {
        $("#nav > ul > li").eq(5).addClass("current");
    } else if (url.indexOf('/productdetails/') > -1) {
        $("#nav > ul > li").eq(2).addClass("current");
    }
});

(function ($) {
    $.fn.nav = function (options) {
        var opts = $.extend(true, {}, $.fn.nav.defaults, options);
        return this.each(function () {
            var $this = $(this);
            if ($this.length < 1) {
                return false;
            }

            var effect = opts.effect,
 				$listli = $this.children("ul").children("li"),
 				list_width = $this.width(),
 				listli_Left = [],
 				listli_width = [],
				place = null;
            if (opts.topORbottom == "top") { place = "bottom" } else { place = "top"; }
            $this.children("ul").children("li").children("div").css(place, $this.parent().height());
            $this.children("ul").children("li").first().addClass("first");

            switch (opts.xORy.toString()) {
                case "y":
                    $this.find("li ul li a").css("float", "none").css("display", "block");
                    $listli.children("div").addClass("Y");
                    break;
                case "x":
                    $listli.children("div").addClass("X");
                    $this.find("li ul li a").css("float", "left").css("display", "inline");
                    break;
            }
            if (opts.arrowShow) {
                var $arrow = $('<div class="navArrow"><span></span></div>');
                $this.append($arrow);
                /*$this.children(".navArrow").css(opts.topORbottom, opts.arrowTop);*/
            }
            if (opts.navSubbgBox) {
                var $navSubbg = $('<div class="navSubbg"></div>'),
 					$navSubbgBox = $('<div class="navSubbgBox"></div>');
                $navSubbgBox.append($navSubbg);
                $this.append($navSubbgBox);
            }
            $listli.each(function (index, element) {
                listli_Left[index] = $(this).children("a").position().left;
                listli_width[index] = $(this).children("a").width();
                var listli_divLeft = 0,
 					$listli_div = $(this).children("div"),
 					listli_divOnlyWidth = $listli_div.width(),
 					listli_Width = $(this).children("a").outerWidth(true),
 					listli_ulMarginLeft = listli_Left[index] + listli_Width / 2,
 					listli_ulMarginRight = list_width - (listli_Left[index] + listli_Width / 2),
 					divClassName = "",
 					listli_divWidth = listli_divOnlyWidth + parseInt($listli_div.css("padding-left"), 10) + parseInt($listli_div.css("padding-left"), 10) + (parseInt($listli_div.css("border-left-width"), 10) ? parseInt($listli_div.css("border-right-width"), 10) : 0) + (parseInt($listli_div.css("border-right-width"), 10) ? parseInt($listli_div.css("border-right-width"), 10) : 0);

                $listli_div.css("padding-" + opts.topORbottom, opts.MenuSpacing);
                $listli_div.children("ul").children("li").first().addClass("first");

                /***解决IE6BUG***X***begin********/

                if (opts.xORy.toString() === "x" && listli_divOnlyWidth == 1000) {
                    var lisili_ulWidth = $listli_div.children("ul").outerWidth(true);
                    $listli_div.width(lisili_ulWidth);
                    listli_divWidth = $listli_div.width() + parseInt($listli_div.css("padding-left"), 10) + parseInt($listli_div.css("padding-left"), 10) + (parseInt($listli_div.css("border-left-width"), 10) ? parseInt($listli_div.css("border-right-width"), 10) : 0) + (parseInt($listli_div.css("border-right-width"), 10) ? parseInt($listli_div.css("border-right-width"), 10) : 0);
                } /***解决IE6BUG***X***end********/

                (function getlistli_divLeft() {
                    if (listli_divWidth / 2 <= listli_ulMarginLeft && listli_divWidth / 2 <= listli_ulMarginRight) {
                        if (opts.noCenter && opts.xORy.toString() === "y") {
                            if (listli_divWidth > listli_ulMarginRight + listli_Width / 2) {
                                divClassName = "right";
                                listli_divLeft = listli_Left[index] + listli_Width - listli_divWidth;
                            } else {
                                divClassName = "left";
                                listli_divLeft = listli_Left[index];
                            }
                        } else {
                            divClassName = "center";
                            listli_divLeft = listli_ulMarginLeft - listli_divWidth / 2;
                        }
                    } else if ((listli_divWidth / 2 > listli_ulMarginLeft) && (listli_divWidth / 2 <= listli_ulMarginRight) && listli_divWidth < (list_width - listli_Left[index])) {
                        divClassName = "left";
                        listli_divLeft = listli_Left[index];
                    } else if (listli_divWidth / 2 <= listli_ulMarginLeft && listli_divWidth / 2 > listli_ulMarginRight && listli_divWidth < listli_Left[index] + listli_Width) {
                        divClassName = "right";
                        listli_divLeft = listli_Left[index] + listli_Width - listli_divWidth;
                    } else {
                        divClassName = "right";
                        listli_divLeft = list_width - listli_divWidth;
                    }
                    if (listli_divWidth === listli_width[index]) {
                        divClassName = "center";
                    }

                    return true;
                }());

                /*$(this).children("div").css({left: listli_divLeft});*/
                $(this).children("div").css({ width: listli_divWidth });

                if (opts.navSubbgBox) {
                    $navSubbgBox.css("height", $listli_div.css("height"));
                    $navSubbg.css("height", $listli_div.css("height"));
                    $navSubbgBox.css("padding-" + opts.topORbottom, $listli_div.css("padding-" + opts.topORbottom));
                    $navSubbgBox.css(opts.topORbottom, $listli_div.css(opts.topORbottom));
                    $navSubbgBox.css("display", "none");
                    $this.on("mouseenter", function () {
                        $navSubbgBox.css("display", "block");
                    }).on("mouseleave", function () {
                        $navSubbgBox.css("display", "none");
                    });
                }
                $(this).on("mouseenter", function () {
                    $listli_div.addClass(divClassName);
                    $(this).addClass(opts.hoverClass);
                    if (opts.arrowShow) {
                        $arrow.show()
                        $arrow.width(listli_width[index]);
                        $arrow.animate({
                            left: listli_Left[index], top: opts.arrowTop
                        }, 0);
                        $arrow.animate({ top: $this.height() - $arrow.height() }, 0);
                        if ($listli_div.find("ul>li").length == 0) {
                            $arrow.hide()
                        }
                    }

                    $(this).children("div").stop(true, false).animate({
                        left: listli_divLeft
                    }, 0, function () {
                        switch (effect) {
                            case 'toggle':
                                $(this).stop(true, false).hide(0);
                                $(this).stop(true, false).show();
                                break;
                            case 'fadeToggle':
                                $(this).stop(true, false).fadeOut(0);
                                $(this).stop(true, false).fadeIn();
                                break;
                            case 'slideToggle':
                                $(this).stop(true, false).slideUp(0);
                                $(this).stop(true, false).slideDown();
                                break;
                        }
                    });
                }).on("mouseleave", function () {
                    $(this).removeClass(opts.hoverClass);
                    if (opts.arrowShow) {
                        $arrow.stop(true, false).animate({
                            left: "-2000px"
                        }, 0);
                    }

                    $(this).stop(true, false).children("div").stop(true, false).animate({
                        left: "-2000px"
                    }, 0, function () {
                        switch (effect) {
                            case 'toggle':
                                $(this).stop(true, false).hide();
                                break;
                            case 'fadeToggle':
                                $(this).stop(true, false).fadeOut();
                                break;
                            case 'slideToggle':
                                $(this).stop(true, false).slideUp();
                                break;
                        }
                    });
                });
            });
        });
    };
    $.fn.nav.defaults = {
        xORy: "y",
        /**X:横向导航或者Y:纵向导航***/
        topORbottom: "bottom",
        /**二级导航放在下面的就用top,否则用bottom**********************/
        effect: "slideToggle",
        arrowShow: true,
        /*****是否显示箭头************/
        navSubbgBox: true,
        /***二级导航的背景是否显示***********/
        noCenter: false,
        /**是否禁止居中***********/
        hoverClass: "hover",
        /***划过时候的class,与current分开******/
        arrowTop: 0,
        MenuSpacing: 0 /***菜单间距*********/
    };
})(jQuery);

; (function ($) {
    $.fn.bannerSlider = function (options) {
        var defaults = {
            width: 950,
            height: 355,
            auto: true,
            effect: "slider",
            Pause: 3000,
            animTime: 250,
            zIndex: 10,
            parentClass: "cs-bannerWrap",
            pagination: {
                show: true,
                evtType: "click",
                className: "banner-numlist"
            },
            btn: {
                show: true,
                dynamic: true
            },
            describe: {
                show: true,
                left: 0,
                bottom: 0
            }
        };

        var opts = $.extend(true, defaults, options), $this = this;
        var Index = 0,
            $this = this,
            len,
            isLock = false,
            animDir = 1,
            Timer = null,
            isFirst = true,
            effectArray = ["slider", "fade"],
            isIE6 = !-[1, ] && !window.XMLHttpRequest,
            animationWay;
        var $prevBtn, $nextBtn, $pagination, $pagination_lis, $slider_lis, $parent, $describe;
        $slider_lis = this.children("li");
        $parent = this.parent();
        len = $slider_lis.length;

        //传进来的效果
        function getAnimWay(effect) {
            try {
                if (effect.constructor !== String) {
                    throw new Error(effect + "must be String");
                } else {
                    var index = $.inArray(effect, effectArray)
                    if (index >= 0) {
                        animWayInit(effect);
                        return effect;
                    } else {
                        alert(effect + " effects is not defined in the plugin");
                        return false;
                    }
                }
            } catch (e) {
                alert(e.message)
            }
        };

        function animWayInit(effect) {
            if (effect == effectArray[0]) {
                $slider_lis.css("position", "absolute").eq(Index).css({ zIndex: opts.zIndex, display: "block" }).siblings().css({ zIndex: opts.zIndex - 1 }).hide();
            } else if (effect == effectArray[1]) {
                $slider_lis.css({ position: "absolute", opacity: 0, zIndex: opts.zIndex - 1 }).eq(Index).css("zIndex", opts.Index).animate({ "opacity": 1 });
                if (isIE6) {
                    $slider_lis.css("display", "none").eq(Index).css("display", "block")
                }
            }
        }

        function btnInit() {
            if (opts.btn.show) {
                $prevBtn = $('<a href="#" class="banner-ui-prev" style="display:none"></a>');
                $nextBtn = $('<a href="#" class="banner-ui-next" style="display:none"></a>');
                $prevBtn.css("zIndex", opts.zIndex + 1).addClass("banner-ui-prev");
                $nextBtn.css("zIndex", opts.zIndex + 1).addClass("banner-ui-next");

                $prevBtn.appendTo($parent);
                $nextBtn.appendTo($parent);
                if (opts.btn.dynamic) {
                    $prevBtn.hide();
                    $nextBtn.hide();
                } else {
                    $prevBtn.show();
                    $nextBtn.show();
                }
                $prevBtn.bind("mouseover", thisMouseover).bind("mouseout", thisMouseout).bind("click", prevBtnScroll);
                $nextBtn.bind("mouseover", thisMouseover).bind("mouseout", thisMouseout).bind("click", nextBtnScroll);
            }
        };

        function thisMouseover(event) {
            clearTimeout(Timer);
            var relateElem = event.relatedTarget;
            if ($(relateElem).closest($parent).length > 0) {
                return;
            } else {
                if (opts.btn.dynamic) {
                    $prevBtn.stop(false, true).fadeIn();
                    $nextBtn.stop(false, true).fadeIn();
                }
                isLock = true;
                animDir = 1;
            }
        };
        function thisMouseout(event) {
            var relateElem = event.relatedTarget;
            if ($(relateElem).closest($parent).length > 0) {
                return;
            } else {
                if (opts.btn.dynamic) {
                    $prevBtn.stop(false, true).fadeOut();
                    $nextBtn.stop(false, true).fadeOut();
                }
                isLock = false;
                isFirst = true;
                animDir = 1;
                beginStart()
            }
        }
        function prevBtnScroll() {
            if (!$this.is(":animated")) {
                clearTimeout(Timer)
                Index--;
                animDir = 0;
                beginStart();
            }
            return false;
        }
        function nextBtnScroll() {
            if (!$this.is(":animated")) {
                clearTimeout(Timer)
                Index++;
                animDir = 1;
                beginStart()
            }
            return false;
        }

        function paginationInit() {
            var strLis = "";
            if (opts.pagination.show) {
                if (len > 1) {
                    $pagination = $('<ul></ul>');
                    $pagination.addClass(opts.pagination.className).css({ "zIndex": opts.zIndex + 1, "position": "absolute" })
                    for (var i = 0; i < len; i++) {
                        strLis += "<li><span>" + (i + 1) + "</span></li>";
                    }
                    $pagination.append(strLis);
                    $pagination.appendTo($parent)
                    $pagination_lis = $pagination.find("li");
                    $pagination_lis.eq(Index).addClass("oncurr");
                    $pagination_lis.each(function () {
                        $(this).bind(opts.pagination.evtType, paginationEvt);
                        $(this).bind("mouseover", thisMouseover).bind("mouseout", thisMouseout);
                    })
                }
            }
        };
        function paginationEvt() {
            var prevIndex = Index;
            isLock = true;
            clearTimeout(Timer);
            Index = $pagination_lis.index(this);
            if (prevIndex < Index) {
                animDir = 1;
                beginStart()
            } else if (prevIndex > Index) {
                animDir = 0;
                beginStart()
            } else {
                return
            }
        }
        function descInit() {
            if (opts.describe.show) {
                $describe = $('<div class="banner-ui-desc"></div>');
                $describe.appendTo($parent).css({ zIndex: opts.zIndex + 1, position: "absolute", left: opts.describe.left, bottom: opts.describe.bottom });
                if ($.trim($slider_lis.eq(Index).attr("data-title")) == "") {
                    $describe.hide()
                } else {
                    $describe.text($slider_lis.eq(Index).attr("data-title"));
                }
                $describe.bind("mouseout", thisMouseout)
            }
        };
        function switchAnimDir(animDir, animationWay) {
            if (animationWay == "slider") {
                var childrenAnimW = null, parentAnimW = null;
                switch (animDir) {
                    case 0://左按钮
                        childrenAnimW = -opts.width;//子元素右移
                        parentAnimW = opts.width;//父元素左移动
                        slideScroll(childrenAnimW, parentAnimW);
                        break;
                    case 1://右按钮
                        childrenAnimW = opts.width;
                        parentAnimW = -opts.width;
                        slideScroll(childrenAnimW, parentAnimW)
                        break;
                }
            } else if (animationWay == "fade") {
                $slider_lis.css("zIndex", opts.zIndex - 1).stop(true).animate({ opacity: 0 }).eq(Index).css("zIndex", opts.zIndex).stop(true).animate({ opacity: 1 });
                if (isIE6) {
                    $slider_lis.css("display", "none").eq(Index).css("display", "block")
                }
            }
        };
        function slideScroll(childrenAnimW, parentAnimW) {
            $slider_lis.eq(Index).css({ left: childrenAnimW, zIndex: opts.zIndex, display: "block" });
            $this.stop(false, true).animate({ left: parentAnimW }, opts.animTime, function () {
                $slider_lis.eq(Index).css("left", 0).siblings().css({ zIndex: opts.zIndex - 1, display: "none" });
                $(this).css("left", 0);
            })
        };
        function beginStart() {
            if (Index < 0) {
                Index = len - 1;
            } else if (Index == len) {
                Index = 0
            }
            scrolling();
        };
        function scrolling() {
            if (isFirst) {
                isFirst = false
            } else {
                switchAnimDir(animDir, animationWay)
                if (opts.pagination.show) {
                    $pagination_lis.eq(Index).addClass("oncurr").siblings().removeClass("oncurr")
                }
            }
            if (opts.describe.show) {
                if ($.trim($slider_lis.eq(Index).attr("data-title")) == "") {
                    $describe.fadeOut();
                } else {
                    $describe.text($slider_lis.eq(Index).attr("data-title")).fadeIn()
                }
            }
            if (!isLock && opts.auto) {
                Timer = setTimeout(function () { Index++; beginStart(); }, opts.Pause)
            }
        };
        var Init = function () {
            //初始化父元素
            $parent.addClass(opts.parentClass).css({ width: opts.width, height: opts.height, position: "relative", overflow: "hidden", margin: "0 auto" });
            //初始化ul
            $this.css({ width: opts.width, height: opts.height, position: "relative" });
            //获取效果的方式
            if (len > 1) {
                animationWay = getAnimWay(opts.effect);
                btnInit();
                paginationInit();

                descInit();
                $this.bind("mouseover", thisMouseover);
                $this.bind("mouseout", thisMouseout);
                beginStart()
            }
        };

        Init();
    }
})(jQuery)