function wxapi() {
	var t = location.href,
		e = t.indexOf("#");
	e > 0 && (t = t.substr(0, e)), $.http.loadScript((pt.isHttps ? "https://ssl." : "http://") + "ptlogin2.qq.com/weixin_sig?callback=weixin_sig_cb&url=" + encodeURIComponent(t))
}
function ptui_qrcode_CB(t) {
	clearTimeout(pt._timer), t && 0 == t.ec && pt.qrcode.polling(t.qrcode)
}
function weixin_sig_cb(t) {
	t && window.wx && (wx.config({
		beta: !0,
		appId: t.appId,
		timestamp: t.timestamp,
		nonceStr: t.nonceStr,
		signature: t.signature,
		jsApiList: ["getNetworkType", "getInstallState"]
	}), wx.ready(function() {
		wx.invoke("getInstallState", {
			packageName: "com.tencent.mobileqq",
			packageUrl: "mqq://"
		}, function(t) {
			var e, n = t && t.err_msg;
			if (n && (e = n.match(/:yes(?:_(\d+))?/))) {
				var i = 336;
				(pt.isIPhone || pt.isAndroid && e[1] >= i) && pt.showOneKey("justshow")
			}
		})
	}))
}
function ptui_checkVC(t, e, n, i, o) {
	clearTimeout(pt._timer), pt.cb_checkVC(t, e, n, i, o)
}
function ptui_changeImg() {}
function ptuiCB(t, e, n, i, o, r) {
	parent.closeLoad();
	clearTimeout(pt._timer), pt.cb(t, e, n, i, o, r)
}
function imgLoadReport() {}
function ptui_checkValidate() {
	return pt.checkValidate()
}
function ptui_auth_CB(t, e) {
	switch (parseInt(t)) {
	case 0:
		pt.isHulian ? pt.setCookieLogin() : pt.showAuth(e), pt.qqBrowserQlogin();
		break;
	case 1:
		var n = navigator.userAgent,
			i = n.match(/QQ\/(\d\.\d\.\d)/i);
		if (i && i[1] >= "5.9" && pt.accessCount() < 5) {
			top.location.href = (pt.isHttps ? "https://ssl." : "http://") + "ptlogin2.qq.com/jump?clientuin=$UIN&clientkey=$KEY&keyindex=$KEYINDEX&u1=" + encodeURIComponent(pt.s_url);
			break
		}
		pt.qqBrowserQlogin(), pt.isHulian && pt.cancel_cookielogin();
		break;
	case 2:
		if (pt.isHulian) {
			pt.setCookieLogin(), pt.qqBrowserQlogin();
			break
		}
		var o = e + "&regmaster=" + window.ptui_regmaster + "&aid=" + window.ptui_appid + "&s_url=" + encodeURIComponent(pt.s_url);
		1 == pt.low_login_enable && (o += "&low_login_enable=1&low_login_hour=" + window.ptui_low_login_hour), "1" == window.ptui_pt_ttype && (o += "&pt_ttype=1"), "1" == window.ptui_pt_light && (o += "&pt_light=1"), pt.redirect(pt.target, o);
		break;
	default:
		pt.qqBrowserQlogin()
	}
}
function ptui_qlogin_CB(t, e, n) {
	switch (t + "") {
	case "0":
		pt.redirect(pt.target, e);
		break;
	case "5":
		if (MTT.refreshToken) {
			var i = setTimeout(function() {
				pt.showErr(n)
			}, 3e3);
			MTT.refreshToken(pt.qqBrowserInfo.uin, function(t) {
				MTT.refreshToken = null, t.stweb && ($.report.monitor("624562"), clearTimeout(i), pt.qqBrowserInfo.loginkey = t.stweb, pt.qlogin_submit())
			}), $.report.monitor("624561")
		} else pt.showErr(n);
		break;
	default:
		$.report.nlog("qq浏览器快速登录失败," + t, "443881", pt.qqBrowserInfo.uin), pt.showErr(n)
	}
}
function OneKey(t) {
	if (OneKey.done = !1, OneKey.TIMEOUT = 3e3, pt.isWX) {
		OneKey.TIMEOUT = 5e3, OneKey.qrcode = !0;
		for (var e in OneKey.ERRMSG) OneKey.ERRMSG.hasOwnProperty(e) && (OneKey.ERRMSG[e] = OneKey.ERRMSG[e].replace(/<a.*>([^<]*)<\/a>/, "$1"));
		pt.qrcode.get()
	} else setTimeout(function() {
		openApp(t)
	}, 100)
}
function openApp(t, e, n) {
	if (!OneKey.done && !pt.isLaunching) {
		pt.isLaunching = !0;
		var i = OneKey.TIMEOUT,
			o = new Date;
		pt.btnOnekey.innerHTML = STR_LANG.onekeying, setTimeout(function() {
			e && e(), pt.isLaunching = !1, pt.btnOnekey.innerHTML = STR_LANG.onekey, pt.qrcode.done || new Date - o <= i + 200 && (n && n(), pt.showErr(OneKey.ERRMSG[ptui_lang], 5e3), $.report.nlog("callApp failed:" + navigator.userAgent, 424783))
		}, i), pt.isWX && pt.isAndroid ? setTimeout(function() {
			doOpenApp(t)
		}, 100) : doOpenApp(t)
	}
}
function doOpenApp(t) {
	var e = $.detectBrowser(),
		n = e[0] && e[0].toLowerCase(),
		i = {};
	if (pt.isAndroid) {
		var o = e[1] || "location";
		switch (n && (i = {
			ucbrowser: "ucweb",
			meizu: "mzbrowser",
			liebaofast: "lb"
		}, i[n] && (t += "&schemacallback=" + encodeURIComponent(i[n] + "://"))), o) {
		case "iframe":
			openApp.iframe ? openApp.iframe.src = t : (openApp.iframe = document.createElement("iframe"), openApp.iframe.src = t, openApp.iframe.style.display = "none", document.body.appendChild(openApp.iframe)), openApp.flag = "iframe";
			break;
		case "open":
			var r = window.open(t, "_blank");
			setTimeout(function() {
				r.close()
			}, 0), openApp.flag = "open";
			break;
		case "location":
			location.href = t, openApp.flag = "location"
		}
	} else n && (i = {
		ucbrowser: "ucbrowser://",
		liebao: "lb://u/100/"
	}, i[n] && (t += "&schemacallback=" + encodeURIComponent(i[n]))), pt.isInIframe ? top.location.href = t : location.href = t, openApp.flag = "location"
}
function openSDKCallBack(t) {
	var e = t.result,
		n = t.data,
		i = t.sn;
	switch (i) {
	case 4:
		openSDK.md5Pwd = n, openSDK.result = e, openSDK.callbackArray[i].call()
	}
}
function get_app_basicinfo(t) {
	pt.open.fillAppInfo(t)
}
var $ = window.Simple = function(t) {
		return "string" == typeof t ? document.getElementById(t) : t
	};
$.cookie = {
	get: function(t) {
		var e, n = function(t) {
				if (!t) return t;
				for (; t != unescape(t);) t = unescape(t);
				for (var e = ["<", ">", "'", '"', "%3c", "%3e", "%27", "%22", "%253c", "%253e", "%2527", "%2522"], n = ["&#x3c;", "&#x3e;", "&#x27;", "&#x22;", "%26%23x3c%3B", "%26%23x3e%3B", "%26%23x27%3B", "%26%23x22%3B", "%2526%2523x3c%253B", "%2526%2523x3e%253B", "%2526%2523x27%253B", "%2526%2523x22%253B"], i = 0; i < e.length; i++) t = t.replace(new RegExp(e[i], "gi"), n[i]);
				return t
			};
		return n((e = document.cookie.match(RegExp("(^|;\\s*)" + t + "=([^;]*)(;|$)"))) ? unescape(e[2]) : "")
	},
	set: function(t, e, n, i, o) {
		var r = new Date;
		o ? (r.setTime(r.getTime() + 36e5 * o), document.cookie = t + "=" + e + "; expires=" + r.toGMTString() + "; path=" + (i ? i : "/") + "; " + (n ? "domain=" + n + ";" : "")) : document.cookie = t + "=" + e + "; path=" + (i ? i : "/") + "; " + (n ? "domain=" + n + ";" : "")
	},
	del: function(t, e, n) {
		document.cookie = t + "=; expires=Mon, 26 Jul 1997 05:00:00 GMT; path=" + (n ? n : "/") + "; " + (e ? "domain=" + e + ";" : "")
	},
	uin: function() {
		var t = $.cookie.get("uin");
		return t ? parseInt(t.substring(1, t.length), 10) : null
	}
}, $.http = {
	jsonp: function(t) {
		var e = document.createElement("script");
		e.src = t, document.getElementsByTagName("head")[0].appendChild(e)
	},
	loadScript: function(t, e) {
		var n = document.createElement("script");
		n.onload = n.onreadystatechange = function() {
			this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || ("function" == typeof e && e(), n.onload = n.onreadystatechange = null, n.parentNode && n.parentNode.removeChild(n))
		}, n.src = t, document.getElementsByTagName("head")[0].appendChild(n)
	},
	ajax: function(url, para, cb, method, type) {
		var xhr = new XMLHttpRequest;
		return xhr.open(method, url), xhr.onreadystatechange = function() {
			4 == xhr.readyState && ((xhr.status >= 200 && xhr.status < 300 || 304 === xhr.status || 1223 === xhr.status || 0 === xhr.status) && cb("undefined" == typeof type && xhr.responseText ? eval("(" + xhr.responseText + ")") : xhr.responseText), xhr = null)
		}, xhr.send(para), xhr
	},
	get: function(t, e, n, i) {
		if (e) {
			var o = [];
			for (var r in e) e.hasOwnProperty(r) && o.push(r + "=" + e[r]); - 1 == t.indexOf("?") && (t += "?"), t += o.join("&")
		}
		return $.http.ajax(t, null, n, "GET", i)
	},
	preload: function(t) {
		var e = document.createElement("img");
		e.src = t, e = null
	}
}, $.get = $.http.get, $.post = $.http.post, $.jsonp = $.http.jsonp, $.browser = function(t) {
	if ("undefined" == typeof $.browser.info) {
		var e = {
			type: ""
		},
			n = navigator.userAgent.toLowerCase();
		/chrome/.test(n) ? e = {
			type: "chrome",
			version: /chrome[\/ ]([\w.]+)/
		} : /opera/.test(n) ? e = {
			type: "opera",
			version: /version/.test(n) ? /version[\/ ]([\w.]+)/ : /opera[\/ ]([\w.]+)/
		} : /msie/.test(n) ? e = {
			type: "msie",
			version: /msie ([\w.]+)/
		} : /mozilla/.test(n) && !/compatible/.test(n) ? e = {
			type: "ff",
			version: /rv:([\w.]+)/
		} : /safari/.test(n) && (e = {
			type: "safari",
			version: /safari[\/ ]([\w.]+)/
		}), e.version = (e.version && e.version.exec(n) || [0, "0"])[1], $.browser.info = e
	}
	return $.browser.info[t]
}, $.e = {
	_counter: 0,
	_uid: function() {
		return "h" + $.e._counter++
	},
	add: function(t, e, n) {
		if ("object" != typeof t && (t = $(t)), document.addEventListener) t.addEventListener(e, n, !1);
		else if (document.attachEvent) {
			if (-1 != $.e._find(t, e, n)) return;
			var i = function(e) {
					e || (e = window.event);
					var i = {
						_event: e,
						type: e.type,
						target: e.srcElement,
						currentTarget: t,
						relatedTarget: e.fromElement ? e.fromElement : e.toElement,
						eventPhase: e.srcElement == t ? 2 : 3,
						clientX: e.clientX,
						clientY: e.clientY,
						screenX: e.screenX,
						screenY: e.screenY,
						altKey: e.altKey,
						ctrlKey: e.ctrlKey,
						shiftKey: e.shiftKey,
						keyCode: e.keyCode,
						data: e.data,
						origin: e.origin,
						stopPropagation: function() {
							this._event.cancelBubble = !0
						},
						preventDefault: function() {
							this._event.returnValue = !1
						}
					};
					Function.prototype.call ? n.call(t, i) : (t._currentHandler = n, t._currentHandler(i), t._currentHandler = null)
				};
			t.attachEvent("on" + e, i);
			var o = {
				element: t,
				eventType: e,
				handler: n,
				wrappedHandler: i
			},
				r = t.document || t,
				a = r.parentWindow,
				p = $.e._uid();
			a._allHandlers || (a._allHandlers = {}), a._allHandlers[p] = o, t._handlers || (t._handlers = []), t._handlers.push(p), a._onunloadHandlerRegistered || (a._onunloadHandlerRegistered = !0, a.attachEvent("onunload", $.e._removeAllHandlers))
		}
	},
	remove: function(t, e, n) {
		if (document.addEventListener) t.removeEventListener(e, n, !1);
		else if (document.attachEvent) {
			var i = $.e._find(t, e, n);
			if (-1 == i) return;
			var o = t.document || t,
				r = o.parentWindow,
				a = t._handlers[i],
				p = r._allHandlers[a];
			t.detachEvent("on" + e, p.wrappedHandler), t._handlers.splice(i, 1), delete r._allHandlers[a]
		}
	},
	_find: function(t, e, n) {
		var i = t._handlers;
		if (!i) return -1;
		for (var o = t.document || t, r = o.parentWindow, a = i.length - 1; a >= 0; a--) {
			var p = i[a],
				s = r._allHandlers[p];
			if (s.eventType == e && s.handler == n) return a
		}
		return -1
	},
	_removeAllHandlers: function() {
		var t = this;
		for (id in t._allHandlers) {
			var e = t._allHandlers[id];
			e.element.detachEvent("on" + e.eventType, e.wrappedHandler), delete t._allHandlers[id]
		}
	},
	src: function(t) {
		return t ? t.target : event.srcElement
	},
	stopPropagation: function(t) {
		t ? t.stopPropagation() : event.cancelBubble = !0
	}
}, $.bom = {
	query: function(t) {
		var e = window.location.search.match(new RegExp("(\\?|&)" + t + "=([^&]*)(&|$)"));
		return e ? decodeURIComponent(e[2]) : ""
	}
}, $.winName = {
	set: function(t, e) {
		var n = window.name || "";
		window.name = n.match(new RegExp(";" + t + "=([^;]*)(;|$)")) ? n.replace(new RegExp(";" + t + "=([^;]*)"), ";" + t + "=" + e) : n + ";" + t + "=" + e
	},
	get: function(t) {
		var e = window.name || "",
			n = e.match(new RegExp(";" + t + "=([^;]*)(;|$)"));
		return n ? n[1] : ""
	},
	clear: function(t) {
		var e = window.name || "";
		window.name = e.replace(new RegExp(";" + t + "=([^;]*)"), "")
	}
}, $.localStorage = {
	isSupport: function() {
		try {
			return window.localStorage ? !0 : !1
		} catch (t) {
			return !1
		}
	},
	get: function(t) {
		var e = "";
		try {
			e = window.localStorage.getItem(t)
		} catch (n) {
			e = ""
		}
		return e
	},
	set: function(t, e) {
		try {
			window.localStorage.setItem(t, e)
		} catch (n) {}
	},
	remove: function(t) {
		try {
			window.localStorage.removeItem(t)
		} catch (e) {}
	}
}, $.str = function() {
	var htmlDecodeDict = {
		quot: '"',
		lt: "<",
		gt: ">",
		amp: "&",
		nbsp: " ",
		"#34": '"',
		"#60": "<",
		"#62": ">",
		"#38": "&",
		"#160": " "
	},
		htmlEncodeDict = {
			'"': "#34",
			"<": "#60",
			">": "#62",
			"&": "#38",
			" ": "#160"
		};
	return {
		decodeHtml: function(t) {
			return t += "", t.replace(/&(quot|lt|gt|amp|nbsp);/gi, function(t, e) {
				return htmlDecodeDict[e]
			}).replace(/&#u([a-f\d]{4});/gi, function(t, e) {
				return String.fromCharCode(parseInt("0x" + e))
			}).replace(/&#(\d+);/gi, function(t, e) {
				return String.fromCharCode(+e)
			})
		},
		encodeHtml: function(t) {
			return t += "", t.replace(/["<>& ]/g, function(t) {
				return "&" + htmlEncodeDict[t] + ";"
			})
		},
		trim: function(t) {
			t += "";
			for (var t = t.replace(/^\s+/, ""), e = /\s/, n = t.length; e.test(t.charAt(--n)););
			return t.slice(0, n + 1)
		},
		uin2hex: function(str) {
			var maxLength = 16;
			str = parseInt(str);
			for (var hex = str.toString(16), len = hex.length, i = len; maxLength > i; i++) hex = "0" + hex;
			for (var arr = [], j = 0; maxLength > j; j += 2) arr.push("\\x" + hex.substr(j, 2));
			var result = arr.join("");
			return eval('result="' + result + '"'), result
		},
		bin2String: function(t) {
			for (var e = [], n = 0, i = t.length; i > n; n++) {
				var o = t.charCodeAt(n).toString(16);
				1 == o.length && (o = "0" + o), e.push(o)
			}
			return e = "0x" + e.join(""), e = parseInt(e, 16)
		},
		utf8ToUincode: function(t) {
			var e = "";
			try {
				var n = t.length,
					o = [];
				for (i = 0; i < n; i += 2) o.push("%" + t.substr(i, 2));
				e = decodeURIComponent(o.join("")), e = $.str.decodeHtml(e)
			} catch (r) {
				e = ""
			}
			return e
		},
		json2str: function(t) {
			var e = "";
			if ("undefined" != typeof JSON) e = JSON.stringify(t);
			else {
				var n = [];
				for (var i in t) n.push("'" + i + "':'" + t[i] + "'");
				e = "{" + n.join(",") + "}"
			}
			return e
		},
		time33: function(t) {
			for (var e = 0, n = 0, i = t.length; i > n; n++) e = 33 * e + t.charCodeAt(n);
			return e % 4294967296
		},
		hash33: function(t) {
			for (var e = 0, n = 0, i = t.length; i > n; ++n) e += (e << 5) + t.charCodeAt(n);
			return 2147483647 & e
		}
	}
}(), $.css = function() {
	return {
		show: function(t) {
			"string" == typeof t && (t = $(t)), t.style.display = "block"
		},
		hide: function(t) {
			"string" == typeof t && (t = $(t)), t.style.display = "none"
		},
		getElementViewTop: function(t) {
			for (var e = $(t), n = e.offsetTop, i = e.offsetParent; null !== i;) n += i.offsetTop, i = i.offsetParent;
			if ("BackCompat" == document.compatMode) var o = document.body.scrollTop;
			else var o = document.documentElement.scrollTop;
			return n - o
		}
	}
}(), $.check = {
	isHttps: function() {
		return "https:" == document.location.protocol
	},
	isSsl: function() {
		var t = document.location.host;
		return /^ssl./i.test(t)
	},
	isIpad: function() {
		var t = navigator.userAgent.toLowerCase();
		return /ipad/i.test(t)
	},
	isQQ: function(t) {
		return /^[1-9]{1}\d{4,9}$/.test(t)
	},
	isNullQQ: function(t) {
		return /^\d{1,4}$/.test(t)
	},
	isNick: function(t) {
		return /^[a-zA-Z]{1}([a-zA-Z0-9]|[-_]){0,19}$/.test(t)
	},
	isName: function(t) {
		return "<请输入帐号>" == t ? !1 : /[一-龥]{1,8}/.test(t)
	},
	isPhone: function(t) {
		return /^(?:86|886|)1\d{10}\s*$/.test(t)
	},
	isDXPhone: function(t) {
		return /^(?:86|886|)1(?:33|53|80|81|89)\d{8}$/.test(t)
	},
	isSeaPhone: function(t) {
		return /^(00)?(?:852|853|886(0)?\d{1})\d{8}$/.test(t)
	},
	isMail: function(t) {
		return /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(t)
	},
	isPassword: function(t) {
		return t && t.length >= 16
	},
	isForeignPhone: function(t) {
		return /^00\d{7,}/.test(t)
	},
	needVip: function(t) {
		for (var e = ["21001601", "21000110", "21000121", "46000101", "716027609", "716027610", "549000912", "717016513"], n = !0, i = 0, o = e.length; o > i; i++) if (e[i] == t) {
			n = !1;
			break
		}
		return n
	},
	isPaipai: function() {
		return /paipai.com$/.test(window.location.hostname)
	},
	isPaipaiDuokefu: function(t) {
		return /^.+@.+$/.test(t)
	},
	is_weibo_appid: function(t) {
		return 46000101 == t || 607000101 == t || 558032501 == t ? !0 : !1
	}
}, $.report = {
	monitor: function(t, e) {
		if (!(Math.random() > (e || 1))) {
			var n = location.protocol + "//ui.ptlogin2.qq.com/cgi-bin/report?id=" + t;
			$.http.preload(n)
		}
	},
	nlog: function(t, e, n) {
		var i = "https:" == location.protocol ? "https://ssl.qq.com/ptlogin/cgi-bin/ptlogin_report?" : "http://log.wtlogin.qq.com/cgi-bin/ptlogin_report?",
			o = encodeURIComponent(t + "|_|" + location.href + "|_|" + window.navigator.userAgent);
		e = e ? e : 0, n && (i += "u=" + n + "&"), i += "id=" + e + "&msg=" + o + "&v=" + Math.random(), $.http.preload(i)
	},
	log: function(t) {
		$.http.preload("http://console.log?msg=" + encodeURIComponent("string" == typeof t ? t : JSON.stringify(t)))
	}
}, $.detectBrowser = function() {
	var c = navigator.userAgent;
	var a;
	if (/android/i.test(c)) {
		if (a = c.match(/MQQBrowser|UCBrowser|360Browser|Firefox/i)) {
			a[1] = "location"
		} else {
			if (a = c.match(/baidubrowse|SogouMobileBrowser|LieBaoFast|XiaoMi\/MiuiBrowser|opr/i)) {
				a[1] = "iframe"
			} else {
				if (a = c.match(/Chrome/i)) {
					var b = c.match(/chrome\/([\d]+)/i);
					if (b) {
						b = b[1]
					}
					if (b != 40) {
						a[1] = "open"
					}
				}
			}
		}
	} else {
		if (/iphone|ipod/ig.test(c)) {
			if (a = c.match(/MQQBrowser|UCBrowser|baidubrowse|Opera|360Browser|LieBao/i)) {} else {
				if (a = c.match(/CriOS|Chrome/i)) {
					(a[0].toLowerCase() == "crios") && (a[0] = "Chrome")
				}
			}
		}
	}
	return a || ["others", ""]
}, function() {
	var t = "nohost_guid",
		e = "/nohost_htdocs/js/SwitchHost.js";
	"" != $.cookie.get(t) && $.http.loadScript(e, function() {
		var t = window.SwitchHost && window.SwitchHost.init;
		t && t()
	})
}(), setTimeout(function() {
	var t = "http://isdspeed.qq.com/cgi-bin/r.cgi?";
	$.check.isHttps() && (t = "https://huatuospeed.weiyun.com/cgi-bin/r.cgi?"), t += "flag1=7808&flag2=1&flag3=9";
	var e = .01;
	Math.random() < (e || 1) && (t += "undefined" != typeof window.postMessage ? "&2=2000" : "&2=1000", t += "&v=" + Math.random(), $.http.preload(t))
}, 500), $ = window.$ || {};
$pt = window.$pt || {};
$.RSA = $pt.RSA = function() {
	function h(z, t) {
		return new au(z, t)
	}
	function aj(aC, aD) {
		var t = "";
		var z = 0;
		while (z + aD < aC.length) {
			t += aC.substring(z, z + aD) + "\n";
			z += aD
		}
		return t + aC.substring(z, aC.length)
	}
	function u(t) {
		if (t < 16) {
			return "0" + t.toString(16)
		} else {
			return t.toString(16)
		}
	}
	function ah(aD, aG) {
		if (aG < aD.length + 11) {
			uv_alert("Message too long for RSA");
			return null
		}
		var aF = new Array();
		var aC = aD.length - 1;
		while (aC >= 0 && aG > 0) {
			var aE = aD.charCodeAt(aC--);
			aF[--aG] = aE
		}
		aF[--aG] = 0;
		var z = new af();
		var t = new Array();
		while (aG > 2) {
			t[0] = 0;
			while (t[0] == 0) {
				z.nextBytes(t)
			}
			aF[--aG] = t[0]
		}
		aF[--aG] = 2;
		aF[--aG] = 0;
		return new au(aF)
	}
	function N() {
		this.n = null;
		this.e = 0;
		this.d = null;
		this.p = null;
		this.q = null;
		this.dmp1 = null;
		this.dmq1 = null;
		this.coeff = null
	}
	function q(z, t) {
		if (z != null && t != null && z.length > 0 && t.length > 0) {
			this.n = h(z, 16);
			this.e = parseInt(t, 16)
		} else {
			uv_alert("Invalid RSA public key")
		}
	}
	function Y(t) {
		return t.modPowInt(this.e, this.n)
	}
	function r(aC) {
		var t = ah(aC, (this.n.bitLength() + 7) >> 3);
		if (t == null) {
			return null
		}
		var aD = this.doPublic(t);
		if (aD == null) {
			return null
		}
		var z = aD.toString(16);
		if ((z.length & 1) == 0) {
			return z
		} else {
			return "0" + z
		}
	}
	N.prototype.doPublic = Y;
	N.prototype.setPublic = q;
	N.prototype.encrypt = r;
	var ay;
	var ak = 244837814094590;
	var ab = ((ak & 16777215) == 15715070);

	function au(z, t, aC) {
		if (z != null) {
			if ("number" == typeof z) {
				this.fromNumber(z, t, aC)
			} else {
				if (t == null && "string" != typeof z) {
					this.fromString(z, 256)
				} else {
					this.fromString(z, t)
				}
			}
		}
	}
	function j() {
		return new au(null)
	}
	function b(aE, t, z, aD, aG, aF) {
		while (--aF >= 0) {
			var aC = t * this[aE++] + z[aD] + aG;
			aG = Math.floor(aC / 67108864);
			z[aD++] = aC & 67108863
		}
		return aG
	}
	function aA(aE, aJ, aK, aD, aH, t) {
		var aG = aJ & 32767,
			aI = aJ >> 15;
		while (--t >= 0) {
			var aC = this[aE] & 32767;
			var aF = this[aE++] >> 15;
			var z = aI * aC + aF * aG;
			aC = aG * aC + ((z & 32767) << 15) + aK[aD] + (aH & 1073741823);
			aH = (aC >>> 30) + (z >>> 15) + aI * aF + (aH >>> 30);
			aK[aD++] = aC & 1073741823
		}
		return aH
	}
	function az(aE, aJ, aK, aD, aH, t) {
		var aG = aJ & 16383,
			aI = aJ >> 14;
		while (--t >= 0) {
			var aC = this[aE] & 16383;
			var aF = this[aE++] >> 14;
			var z = aI * aC + aF * aG;
			aC = aG * aC + ((z & 16383) << 14) + aK[aD] + aH;
			aH = (aC >> 28) + (z >> 14) + aI * aF;
			aK[aD++] = aC & 268435455
		}
		return aH
	}
	if (ab && (navigator.appName == "Microsoft Internet Explorer")) {
		au.prototype.am = aA;
		ay = 30
	} else {
		if (ab && (navigator.appName != "Netscape")) {
			au.prototype.am = b;
			ay = 26
		} else {
			au.prototype.am = az;
			ay = 28
		}
	}
	au.prototype.DB = ay;
	au.prototype.DM = ((1 << ay) - 1);
	au.prototype.DV = (1 << ay);
	var ac = 52;
	au.prototype.FV = Math.pow(2, ac);
	au.prototype.F1 = ac - ay;
	au.prototype.F2 = 2 * ay - ac;
	var ag = "0123456789abcdefghijklmnopqrstuvwxyz";
	var ai = new Array();
	var ar, x;
	ar = "0".charCodeAt(0);
	for (x = 0; x <= 9; ++x) {
		ai[ar++] = x
	}
	ar = "a".charCodeAt(0);
	for (x = 10; x < 36; ++x) {
		ai[ar++] = x
	}
	ar = "A".charCodeAt(0);
	for (x = 10; x < 36; ++x) {
		ai[ar++] = x
	}
	function aB(t) {
		return ag.charAt(t)
	}
	function C(z, t) {
		var aC = ai[z.charCodeAt(t)];
		return (aC == null) ? -1 : aC
	}
	function aa(z) {
		for (var t = this.t - 1; t >= 0; --t) {
			z[t] = this[t]
		}
		z.t = this.t;
		z.s = this.s
	}
	function p(t) {
		this.t = 1;
		this.s = (t < 0) ? -1 : 0;
		if (t > 0) {
			this[0] = t
		} else {
			if (t < -1) {
				this[0] = t + DV
			} else {
				this.t = 0
			}
		}
	}
	function c(t) {
		var z = j();
		z.fromInt(t);
		return z
	}
	function y(aG, z) {
		var aD;
		if (z == 16) {
			aD = 4
		} else {
			if (z == 8) {
				aD = 3
			} else {
				if (z == 256) {
					aD = 8
				} else {
					if (z == 2) {
						aD = 1
					} else {
						if (z == 32) {
							aD = 5
						} else {
							if (z == 4) {
								aD = 2
							} else {
								this.fromRadix(aG, z);
								return
							}
						}
					}
				}
			}
		}
		this.t = 0;
		this.s = 0;
		var aF = aG.length,
			aC = false,
			aE = 0;
		while (--aF >= 0) {
			var t = (aD == 8) ? aG[aF] & 255 : C(aG, aF);
			if (t < 0) {
				if (aG.charAt(aF) == "-") {
					aC = true
				}
				continue
			}
			aC = false;
			if (aE == 0) {
				this[this.t++] = t
			} else {
				if (aE + aD > this.DB) {
					this[this.t - 1] |= (t & ((1 << (this.DB - aE)) - 1)) << aE;
					this[this.t++] = (t >> (this.DB - aE))
				} else {
					this[this.t - 1] |= t << aE
				}
			}
			aE += aD;
			if (aE >= this.DB) {
				aE -= this.DB
			}
		}
		if (aD == 8 && (aG[0] & 128) != 0) {
			this.s = -1;
			if (aE > 0) {
				this[this.t - 1] |= ((1 << (this.DB - aE)) - 1) << aE
			}
		}
		this.clamp();
		if (aC) {
			au.ZERO.subTo(this, this)
		}
	}
	function Q() {
		var t = this.s & this.DM;
		while (this.t > 0 && this[this.t - 1] == t) {
			--this.t
		}
	}
	function s(z) {
		if (this.s < 0) {
			return "-" + this.negate().toString(z)
		}
		var aC;
		if (z == 16) {
			aC = 4
		} else {
			if (z == 8) {
				aC = 3
			} else {
				if (z == 2) {
					aC = 1
				} else {
					if (z == 32) {
						aC = 5
					} else {
						if (z == 4) {
							aC = 2
						} else {
							return this.toRadix(z)
						}
					}
				}
			}
		}
		var aE = (1 << aC) - 1,
			aH, t = false,
			aF = "",
			aD = this.t;
		var aG = this.DB - (aD * this.DB) % aC;
		if (aD-- > 0) {
			if (aG < this.DB && (aH = this[aD] >> aG) > 0) {
				t = true;
				aF = aB(aH)
			}
			while (aD >= 0) {
				if (aG < aC) {
					aH = (this[aD] & ((1 << aG) - 1)) << (aC - aG);
					aH |= this[--aD] >> (aG += this.DB - aC)
				} else {
					aH = (this[aD] >> (aG -= aC)) & aE;
					if (aG <= 0) {
						aG += this.DB;
						--aD
					}
				}
				if (aH > 0) {
					t = true
				}
				if (t) {
					aF += aB(aH)
				}
			}
		}
		return t ? aF : "0"
	}
	function T() {
		var t = j();
		au.ZERO.subTo(this, t);
		return t
	}
	function an() {
		return (this.s < 0) ? this.negate() : this
	}
	function I(t) {
		var aC = this.s - t.s;
		if (aC != 0) {
			return aC
		}
		var z = this.t;
		aC = z - t.t;
		if (aC != 0) {
			return aC
		}
		while (--z >= 0) {
			if ((aC = this[z] - t[z]) != 0) {
				return aC
			}
		}
		return 0
	}
	function l(z) {
		var aD = 1,
			aC;
		if ((aC = z >>> 16) != 0) {
			z = aC;
			aD += 16
		}
		if ((aC = z >> 8) != 0) {
			z = aC;
			aD += 8
		}
		if ((aC = z >> 4) != 0) {
			z = aC;
			aD += 4
		}
		if ((aC = z >> 2) != 0) {
			z = aC;
			aD += 2
		}
		if ((aC = z >> 1) != 0) {
			z = aC;
			aD += 1
		}
		return aD
	}
	function w() {
		if (this.t <= 0) {
			return 0
		}
		return this.DB * (this.t - 1) + l(this[this.t - 1] ^ (this.s & this.DM))
	}
	function at(aC, z) {
		var t;
		for (t = this.t - 1; t >= 0; --t) {
			z[t + aC] = this[t]
		}
		for (t = aC - 1; t >= 0; --t) {
			z[t] = 0
		}
		z.t = this.t + aC;
		z.s = this.s
	}
	function Z(aC, z) {
		for (var t = aC; t < this.t; ++t) {
			z[t - aC] = this[t]
		}
		z.t = Math.max(this.t - aC, 0);
		z.s = this.s
	}
	function v(aH, aD) {
		var z = aH % this.DB;
		var t = this.DB - z;
		var aF = (1 << t) - 1;
		var aE = Math.floor(aH / this.DB),
			aG = (this.s << z) & this.DM,
			aC;
		for (aC = this.t - 1; aC >= 0; --aC) {
			aD[aC + aE + 1] = (this[aC] >> t) | aG;
			aG = (this[aC] & aF) << z
		}
		for (aC = aE - 1; aC >= 0; --aC) {
			aD[aC] = 0
		}
		aD[aE] = aG;
		aD.t = this.t + aE + 1;
		aD.s = this.s;
		aD.clamp()
	}
	function n(aG, aD) {
		aD.s = this.s;
		var aE = Math.floor(aG / this.DB);
		if (aE >= this.t) {
			aD.t = 0;
			return
		}
		var z = aG % this.DB;
		var t = this.DB - z;
		var aF = (1 << z) - 1;
		aD[0] = this[aE] >> z;
		for (var aC = aE + 1; aC < this.t; ++aC) {
			aD[aC - aE - 1] |= (this[aC] & aF) << t;
			aD[aC - aE] = this[aC] >> z
		}
		if (z > 0) {
			aD[this.t - aE - 1] |= (this.s & aF) << t
		}
		aD.t = this.t - aE;
		aD.clamp()
	}
	function ad(z, aD) {
		var aC = 0,
			aE = 0,
			t = Math.min(z.t, this.t);
		while (aC < t) {
			aE += this[aC] - z[aC];
			aD[aC++] = aE & this.DM;
			aE >>= this.DB
		}
		if (z.t < this.t) {
			aE -= z.s;
			while (aC < this.t) {
				aE += this[aC];
				aD[aC++] = aE & this.DM;
				aE >>= this.DB
			}
			aE += this.s
		} else {
			aE += this.s;
			while (aC < z.t) {
				aE -= z[aC];
				aD[aC++] = aE & this.DM;
				aE >>= this.DB
			}
			aE -= z.s
		}
		aD.s = (aE < 0) ? -1 : 0;
		if (aE < -1) {
			aD[aC++] = this.DV + aE
		} else {
			if (aE > 0) {
				aD[aC++] = aE
			}
		}
		aD.t = aC;
		aD.clamp()
	}
	function F(z, aD) {
		var t = this.abs(),
			aE = z.abs();
		var aC = t.t;
		aD.t = aC + aE.t;
		while (--aC >= 0) {
			aD[aC] = 0
		}
		for (aC = 0; aC < aE.t; ++aC) {
			aD[aC + t.t] = t.am(0, aE[aC], aD, aC, 0, t.t)
		}
		aD.s = 0;
		aD.clamp();
		if (this.s != z.s) {
			au.ZERO.subTo(aD, aD)
		}
	}
	function S(aC) {
		var t = this.abs();
		var z = aC.t = 2 * t.t;
		while (--z >= 0) {
			aC[z] = 0
		}
		for (z = 0; z < t.t - 1; ++z) {
			var aD = t.am(z, t[z], aC, 2 * z, 0, 1);
			if ((aC[z + t.t] += t.am(z + 1, 2 * t[z], aC, 2 * z + 1, aD, t.t - z - 1)) >= t.DV) {
				aC[z + t.t] -= t.DV;
				aC[z + t.t + 1] = 1
			}
		}
		if (aC.t > 0) {
			aC[aC.t - 1] += t.am(z, t[z], aC, 2 * z, 0, 1)
		}
		aC.s = 0;
		aC.clamp()
	}
	function G(aK, aH, aG) {
		var aQ = aK.abs();
		if (aQ.t <= 0) {
			return
		}
		var aI = this.abs();
		if (aI.t < aQ.t) {
			if (aH != null) {
				aH.fromInt(0)
			}
			if (aG != null) {
				this.copyTo(aG)
			}
			return
		}
		if (aG == null) {
			aG = j()
		}
		var aE = j(),
			z = this.s,
			aJ = aK.s;
		var aP = this.DB - l(aQ[aQ.t - 1]);
		if (aP > 0) {
			aQ.lShiftTo(aP, aE);
			aI.lShiftTo(aP, aG)
		} else {
			aQ.copyTo(aE);
			aI.copyTo(aG)
		}
		var aM = aE.t;
		var aC = aE[aM - 1];
		if (aC == 0) {
			return
		}
		var aL = aC * (1 << this.F1) + ((aM > 1) ? aE[aM - 2] >> this.F2 : 0);
		var aT = this.FV / aL,
			aS = (1 << this.F1) / aL,
			aR = 1 << this.F2;
		var aO = aG.t,
			aN = aO - aM,
			aF = (aH == null) ? j() : aH;
		aE.dlShiftTo(aN, aF);
		if (aG.compareTo(aF) >= 0) {
			aG[aG.t++] = 1;
			aG.subTo(aF, aG)
		}
		au.ONE.dlShiftTo(aM, aF);
		aF.subTo(aE, aE);
		while (aE.t < aM) {
			aE[aE.t++] = 0
		}
		while (--aN >= 0) {
			var aD = (aG[--aO] == aC) ? this.DM : Math.floor(aG[aO] * aT + (aG[aO - 1] + aR) * aS);
			if ((aG[aO] += aE.am(0, aD, aG, aN, 0, aM)) < aD) {
				aE.dlShiftTo(aN, aF);
				aG.subTo(aF, aG);
				while (aG[aO] < --aD) {
					aG.subTo(aF, aG)
				}
			}
		}
		if (aH != null) {
			aG.drShiftTo(aM, aH);
			if (z != aJ) {
				au.ZERO.subTo(aH, aH)
			}
		}
		aG.t = aM;
		aG.clamp();
		if (aP > 0) {
			aG.rShiftTo(aP, aG)
		}
		if (z < 0) {
			au.ZERO.subTo(aG, aG)
		}
	}
	function P(t) {
		var z = j();
		this.abs().divRemTo(t, null, z);
		if (this.s < 0 && z.compareTo(au.ZERO) > 0) {
			t.subTo(z, z)
		}
		return z
	}
	function M(t) {
		this.m = t
	}
	function X(t) {
		if (t.s < 0 || t.compareTo(this.m) >= 0) {
			return t.mod(this.m)
		} else {
			return t
		}
	}
	function am(t) {
		return t
	}
	function L(t) {
		t.divRemTo(this.m, null, t)
	}
	function J(t, aC, z) {
		t.multiplyTo(aC, z);
		this.reduce(z)
	}
	function aw(t, z) {
		t.squareTo(z);
		this.reduce(z)
	}
	M.prototype.convert = X;
	M.prototype.revert = am;
	M.prototype.reduce = L;
	M.prototype.mulTo = J;
	M.prototype.sqrTo = aw;

	function D() {
		if (this.t < 1) {
			return 0
		}
		var t = this[0];
		if ((t & 1) == 0) {
			return 0
		}
		var z = t & 3;
		z = (z * (2 - (t & 15) * z)) & 15;
		z = (z * (2 - (t & 255) * z)) & 255;
		z = (z * (2 - (((t & 65535) * z) & 65535))) & 65535;
		z = (z * (2 - t * z % this.DV)) % this.DV;
		return (z > 0) ? this.DV - z : -z
	}
	function g(t) {
		this.m = t;
		this.mp = t.invDigit();
		this.mpl = this.mp & 32767;
		this.mph = this.mp >> 15;
		this.um = (1 << (t.DB - 15)) - 1;
		this.mt2 = 2 * t.t
	}
	function al(t) {
		var z = j();
		t.abs().dlShiftTo(this.m.t, z);
		z.divRemTo(this.m, null, z);
		if (t.s < 0 && z.compareTo(au.ZERO) > 0) {
			this.m.subTo(z, z)
		}
		return z
	}
	function av(t) {
		var z = j();
		t.copyTo(z);
		this.reduce(z);
		return z
	}
	function R(t) {
		while (t.t <= this.mt2) {
			t[t.t++] = 0
		}
		for (var aC = 0; aC < this.m.t; ++aC) {
			var z = t[aC] & 32767;
			var aD = (z * this.mpl + (((z * this.mph + (t[aC] >> 15) * this.mpl) & this.um) << 15)) & t.DM;
			z = aC + this.m.t;
			t[z] += this.m.am(0, aD, t, aC, 0, this.m.t);
			while (t[z] >= t.DV) {
				t[z] -= t.DV;
				t[++z]++
			}
		}
		t.clamp();
		t.drShiftTo(this.m.t, t);
		if (t.compareTo(this.m) >= 0) {
			t.subTo(this.m, t)
		}
	}
	function ao(t, z) {
		t.squareTo(z);
		this.reduce(z)
	}
	function B(t, aC, z) {
		t.multiplyTo(aC, z);
		this.reduce(z)
	}
	g.prototype.convert = al;
	g.prototype.revert = av;
	g.prototype.reduce = R;
	g.prototype.mulTo = B;
	g.prototype.sqrTo = ao;

	function k() {
		return ((this.t > 0) ? (this[0] & 1) : this.s) == 0
	}
	function A(aH, aI) {
		if (aH > 4294967295 || aH < 1) {
			return au.ONE
		}
		var aG = j(),
			aC = j(),
			aF = aI.convert(this),
			aE = l(aH) - 1;
		aF.copyTo(aG);
		while (--aE >= 0) {
			aI.sqrTo(aG, aC);
			if ((aH & (1 << aE)) > 0) {
				aI.mulTo(aC, aF, aG)
			} else {
				var aD = aG;
				aG = aC;
				aC = aD
			}
		}
		return aI.revert(aG)
	}
	function ap(aC, t) {
		var aD;
		if (aC < 256 || t.isEven()) {
			aD = new M(t)
		} else {
			aD = new g(t)
		}
		return this.exp(aC, aD)
	}
	au.prototype.copyTo = aa;
	au.prototype.fromInt = p;
	au.prototype.fromString = y;
	au.prototype.clamp = Q;
	au.prototype.dlShiftTo = at;
	au.prototype.drShiftTo = Z;
	au.prototype.lShiftTo = v;
	au.prototype.rShiftTo = n;
	au.prototype.subTo = ad;
	au.prototype.multiplyTo = F;
	au.prototype.squareTo = S;
	au.prototype.divRemTo = G;
	au.prototype.invDigit = D;
	au.prototype.isEven = k;
	au.prototype.exp = A;
	au.prototype.toString = s;
	au.prototype.negate = T;
	au.prototype.abs = an;
	au.prototype.compareTo = I;
	au.prototype.bitLength = w;
	au.prototype.mod = P;
	au.prototype.modPowInt = ap;
	au.ZERO = c(0);
	au.ONE = c(1);
	var o;
	var W;
	var ae;

	function d(t) {
		W[ae++] ^= t & 255;
		W[ae++] ^= (t >> 8) & 255;
		W[ae++] ^= (t >> 16) & 255;
		W[ae++] ^= (t >> 24) & 255;
		if (ae >= O) {
			ae -= O
		}
	}
	function V() {
		d(new Date().getTime())
	}
	if (W == null) {
		W = new Array();
		ae = 0;
		var K;
		if (navigator.appName == "Netscape" && navigator.appVersion < "5" && window.crypto && window.crypto.random) {
			var H = window.crypto.random(32);
			for (K = 0; K < H.length; ++K) {
				W[ae++] = H.charCodeAt(K) & 255
			}
		}
		while (ae < O) {
			K = Math.floor(65536 * Math.random());
			W[ae++] = K >>> 8;
			W[ae++] = K & 255
		}
		ae = 0;
		V()
	}
	function E() {
		if (o == null) {
			V();
			o = aq();
			o.init(W);
			for (ae = 0; ae < W.length; ++ae) {
				W[ae] = 0
			}
			ae = 0
		}
		return o.next()
	}
	function ax(z) {
		var t;
		for (t = 0; t < z.length; ++t) {
			z[t] = E()
		}
	}
	function af() {}
	af.prototype.nextBytes = ax;

	function m() {
		this.i = 0;
		this.j = 0;
		this.S = new Array()
	}
	function f(aE) {
		var aD, z, aC;
		for (aD = 0; aD < 256; ++aD) {
			this.S[aD] = aD
		}
		z = 0;
		for (aD = 0; aD < 256; ++aD) {
			z = (z + this.S[aD] + aE[aD % aE.length]) & 255;
			aC = this.S[aD];
			this.S[aD] = this.S[z];
			this.S[z] = aC
		}
		this.i = 0;
		this.j = 0
	}
	function a() {
		var z;
		this.i = (this.i + 1) & 255;
		this.j = (this.j + this.S[this.i]) & 255;
		z = this.S[this.i];
		this.S[this.i] = this.S[this.j];
		this.S[this.j] = z;
		return this.S[(z + this.S[this.i]) & 255]
	}
	m.prototype.init = f;
	m.prototype.next = a;

	function aq() {
		return new m()
	}
	var O = 256;

	function U(aD, aC, z) {
		aC = "F20CE00BAE5361F8FA3AE9CEFA495362FF7DA1BA628F64A347F0A8C012BF0B254A30CD92ABFFE7A6EE0DC424CB6166F8819EFA5BCCB20EDFB4AD02E412CCF579B1CA711D55B8B0B3AEB60153D5E0693A2A86F3167D7847A0CB8B00004716A9095D9BADC977CBB804DBDCBA6029A9710869A453F27DFDDF83C016D928B3CBF4C7";
		z = "3";
		var t = new N();
		t.setPublic(aC, z);
		return t.encrypt(aD)
	}
	return {
		rsa_encrypt: U
	}
}();
(function(t) {
	var u = "",
		a = 0,
		h = [],
		z = [],
		A = 0,
		w = 0,
		o = [],
		v = [],
		p = true;

	function f() {
		return Math.round(Math.random() * 4294967295)
	}
	function k(E, F, B) {
		if (!B || B > 4) {
			B = 4
		}
		var C = 0;
		for (var D = F; D < F + B; D++) {
			C <<= 8;
			C |= E[D]
		}
		return (C & 4294967295) >>> 0
	}
	function b(C, D, B) {
		C[D + 3] = (B >> 0) & 255;
		C[D + 2] = (B >> 8) & 255;
		C[D + 1] = (B >> 16) & 255;
		C[D + 0] = (B >> 24) & 255
	}
	function y(E) {
		if (!E) {
			return ""
		}
		var B = "";
		for (var C = 0; C < E.length; C++) {
			var D = Number(E[C]).toString(16);
			if (D.length == 1) {
				D = "0" + D
			}
			B += D
		}
		return B
	}
	function x(C) {
		var D = "";
		for (var B = 0; B < C.length; B += 2) {
			D += String.fromCharCode(parseInt(C.substr(B, 2), 16))
		}
		return D
	}
	function c(E, B) {
		if (!E) {
			return ""
		}
		if (B) {
			E = m(E)
		}
		var D = [];
		for (var C = 0; C < E.length; C++) {
			D[C] = E.charCodeAt(C)
		}
		return y(D)
	}
	function m(E) {
		var D, F, C = [],
			B = E.length;
		for (D = 0; D < B; D++) {
			F = E.charCodeAt(D);
			if (F > 0 && F <= 127) {
				C.push(E.charAt(D))
			} else {
				if (F >= 128 && F <= 2047) {
					C.push(String.fromCharCode(192 | ((F >> 6) & 31)), String.fromCharCode(128 | (F & 63)))
				} else {
					if (F >= 2048 && F <= 65535) {
						C.push(String.fromCharCode(224 | ((F >> 12) & 15)), String.fromCharCode(128 | ((F >> 6) & 63)), String.fromCharCode(128 | (F & 63)))
					}
				}
			}
		}
		return C.join("")
	}
	function j(D) {
		h = new Array(8);
		z = new Array(8);
		A = w = 0;
		p = true;
		a = 0;
		var B = D.length;
		var E = 0;
		a = (B + 10) % 8;
		if (a != 0) {
			a = 8 - a
		}
		o = new Array(B + a + 10);
		h[0] = ((f() & 248) | a) & 255;
		for (var C = 1; C <= a; C++) {
			h[C] = f() & 255
		}
		a++;
		for (var C = 0; C < 8; C++) {
			z[C] = 0
		}
		E = 1;
		while (E <= 2) {
			if (a < 8) {
				h[a++] = f() & 255;
				E++
			}
			if (a == 8) {
				r()
			}
		}
		var C = 0;
		while (B > 0) {
			if (a < 8) {
				h[a++] = D[C++];
				B--
			}
			if (a == 8) {
				r()
			}
		}
		E = 1;
		while (E <= 7) {
			if (a < 8) {
				h[a++] = 0;
				E++
			}
			if (a == 8) {
				r()
			}
		}
		return o
	}
	function s(F) {
		var E = 0;
		var C = new Array(8);
		var B = F.length;
		v = F;
		if (B % 8 != 0 || B < 16) {
			return null
		}
		z = n(F);
		a = z[0] & 7;
		E = B - a - 10;
		if (E < 0) {
			return null
		}
		for (var D = 0; D < C.length; D++) {
			C[D] = 0
		}
		o = new Array(E);
		w = 0;
		A = 8;
		a++;
		var G = 1;
		while (G <= 2) {
			if (a < 8) {
				a++;
				G++
			}
			if (a == 8) {
				C = F;
				if (!g()) {
					return null
				}
			}
		}
		var D = 0;
		while (E != 0) {
			if (a < 8) {
				o[D] = (C[w + a] ^ z[a]) & 255;
				D++;
				E--;
				a++
			}
			if (a == 8) {
				C = F;
				w = A - 8;
				if (!g()) {
					return null
				}
			}
		}
		for (G = 1; G < 8; G++) {
			if (a < 8) {
				if ((C[w + a] ^ z[a]) != 0) {
					return null
				}
				a++
			}
			if (a == 8) {
				C = F;
				w = A;
				if (!g()) {
					return null
				}
			}
		}
		return o
	}
	function r() {
		for (var B = 0; B < 8; B++) {
			if (p) {
				h[B] ^= z[B]
			} else {
				h[B] ^= o[w + B]
			}
		}
		var C = l(h);
		for (var B = 0; B < 8; B++) {
			o[A + B] = C[B] ^ z[B];
			z[B] = h[B]
		}
		w = A;
		A += 8;
		a = 0;
		p = false
	}
	function l(B) {
		var C = 16;
		var H = k(B, 0, 4);
		var G = k(B, 4, 4);
		var J = k(u, 0, 4);
		var I = k(u, 4, 4);
		var F = k(u, 8, 4);
		var E = k(u, 12, 4);
		var D = 0;
		var K = 2654435769 >>> 0;
		while (C-- > 0) {
			D += K;
			D = (D & 4294967295) >>> 0;
			H += ((G << 4) + J) ^ (G + D) ^ ((G >>> 5) + I);
			H = (H & 4294967295) >>> 0;
			G += ((H << 4) + F) ^ (H + D) ^ ((H >>> 5) + E);
			G = (G & 4294967295) >>> 0
		}
		var L = new Array(8);
		b(L, 0, H);
		b(L, 4, G);
		return L
	}
	function n(B) {
		var C = 16;
		var H = k(B, 0, 4);
		var G = k(B, 4, 4);
		var J = k(u, 0, 4);
		var I = k(u, 4, 4);
		var F = k(u, 8, 4);
		var E = k(u, 12, 4);
		var D = 3816266640 >>> 0;
		var K = 2654435769 >>> 0;
		while (C-- > 0) {
			G -= ((H << 4) + F) ^ (H + D) ^ ((H >>> 5) + E);
			G = (G & 4294967295) >>> 0;
			H -= ((G << 4) + J) ^ (G + D) ^ ((G >>> 5) + I);
			H = (H & 4294967295) >>> 0;
			D -= K;
			D = (D & 4294967295) >>> 0
		}
		var L = new Array(8);
		b(L, 0, H);
		b(L, 4, G);
		return L
	}
	function g() {
		var B = v.length;
		for (var C = 0; C < 8; C++) {
			z[C] ^= v[A + C]
		}
		z = n(z);
		A += 8;
		a = 0;
		return true
	}
	function q(F, E) {
		var D = [];
		if (E) {
			for (var C = 0; C < F.length; C++) {
				D[C] = F.charCodeAt(C) & 255
			}
		} else {
			var B = 0;
			for (var C = 0; C < F.length; C += 2) {
				D[B++] = parseInt(F.substr(C, 2), 16)
			}
		}
		return D
	}
	t.TEA = {
		encrypt: function(E, D) {
			var C = q(E, D);
			var B = j(C);
			return y(B)
		},
		enAsBase64: function(G, F) {
			var E = q(G, F);
			var D = j(E);
			var B = "";
			for (var C = 0; C < D.length; C++) {
				B += String.fromCharCode(D[C])
			}
			return btoa(B)
		},
		decrypt: function(D) {
			var C = q(D, false);
			var B = s(C);
			return y(B)
		},
		initkey: function(B, C) {
			u = q(B, C)
		},
		bytesToStr: x,
		strToBytes: c,
		bytesInStr: y,
		dataFromStr: q
	};
	var d = {};
	d.PADCHAR = "=";
	d.ALPHA = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	d.getbyte = function(D, C) {
		var B = D.charCodeAt(C);
		if (B > 255) {
			throw "INVALID_CHARACTER_ERR: DOM Exception 5"
		}
		return B
	};
	d.encode = function(F) {
		if (arguments.length != 1) {
			throw "SyntaxError: Not enough arguments"
		}
		var C = d.PADCHAR;
		var H = d.ALPHA;
		var G = d.getbyte;
		var E, I;
		var B = [];
		F = "" + F;
		var D = F.length - F.length % 3;
		if (F.length == 0) {
			return F
		}
		for (E = 0; E < D; E += 3) {
			I = (G(F, E) << 16) | (G(F, E + 1) << 8) | G(F, E + 2);
			B.push(H.charAt(I >> 18));
			B.push(H.charAt((I >> 12) & 63));
			B.push(H.charAt((I >> 6) & 63));
			B.push(H.charAt(I & 63))
		}
		switch (F.length - D) {
		case 1:
			I = G(F, E) << 16;
			B.push(H.charAt(I >> 18) + H.charAt((I >> 12) & 63) + C + C);
			break;
		case 2:
			I = (G(F, E) << 16) | (G(F, E + 1) << 8);
			B.push(H.charAt(I >> 18) + H.charAt((I >> 12) & 63) + H.charAt((I >> 6) & 63) + C);
			break
		}
		return B.join("")
	};
	if (!window.btoa) {
		window.btoa = d.encode
	}
})(window);
$ = window.$ || {};
$pt = window.$pt || {};
$.Encryption = $pt.Encryption = function() {
	var hexcase = 1;
	var b64pad = "";
	var chrsz = 8;
	var mode = 32;

	function md5(s) {
		return hex_md5(s)
	}
	function hex_md5(s) {
		return binl2hex(core_md5(str2binl(s), s.length * chrsz))
	}
	function str_md5(s) {
		return binl2str(core_md5(str2binl(s), s.length * chrsz))
	}
	function hex_hmac_md5(key, data) {
		return binl2hex(core_hmac_md5(key, data))
	}
	function b64_hmac_md5(key, data) {
		return binl2b64(core_hmac_md5(key, data))
	}
	function str_hmac_md5(key, data) {
		return binl2str(core_hmac_md5(key, data))
	}
	function core_md5(x, len) {
		x[len >> 5] |= 128 << ((len) % 32);
		x[(((len + 64) >>> 9) << 4) + 14] = len;
		var a = 1732584193;
		var b = -271733879;
		var c = -1732584194;
		var d = 271733878;
		for (var i = 0; i < x.length; i += 16) {
			var olda = a;
			var oldb = b;
			var oldc = c;
			var oldd = d;
			a = md5_ff(a, b, c, d, x[i + 0], 7, -680876936);
			d = md5_ff(d, a, b, c, x[i + 1], 12, -389564586);
			c = md5_ff(c, d, a, b, x[i + 2], 17, 606105819);
			b = md5_ff(b, c, d, a, x[i + 3], 22, -1044525330);
			a = md5_ff(a, b, c, d, x[i + 4], 7, -176418897);
			d = md5_ff(d, a, b, c, x[i + 5], 12, 1200080426);
			c = md5_ff(c, d, a, b, x[i + 6], 17, -1473231341);
			b = md5_ff(b, c, d, a, x[i + 7], 22, -45705983);
			a = md5_ff(a, b, c, d, x[i + 8], 7, 1770035416);
			d = md5_ff(d, a, b, c, x[i + 9], 12, -1958414417);
			c = md5_ff(c, d, a, b, x[i + 10], 17, -42063);
			b = md5_ff(b, c, d, a, x[i + 11], 22, -1990404162);
			a = md5_ff(a, b, c, d, x[i + 12], 7, 1804603682);
			d = md5_ff(d, a, b, c, x[i + 13], 12, -40341101);
			c = md5_ff(c, d, a, b, x[i + 14], 17, -1502002290);
			b = md5_ff(b, c, d, a, x[i + 15], 22, 1236535329);
			a = md5_gg(a, b, c, d, x[i + 1], 5, -165796510);
			d = md5_gg(d, a, b, c, x[i + 6], 9, -1069501632);
			c = md5_gg(c, d, a, b, x[i + 11], 14, 643717713);
			b = md5_gg(b, c, d, a, x[i + 0], 20, -373897302);
			a = md5_gg(a, b, c, d, x[i + 5], 5, -701558691);
			d = md5_gg(d, a, b, c, x[i + 10], 9, 38016083);
			c = md5_gg(c, d, a, b, x[i + 15], 14, -660478335);
			b = md5_gg(b, c, d, a, x[i + 4], 20, -405537848);
			a = md5_gg(a, b, c, d, x[i + 9], 5, 568446438);
			d = md5_gg(d, a, b, c, x[i + 14], 9, -1019803690);
			c = md5_gg(c, d, a, b, x[i + 3], 14, -187363961);
			b = md5_gg(b, c, d, a, x[i + 8], 20, 1163531501);
			a = md5_gg(a, b, c, d, x[i + 13], 5, -1444681467);
			d = md5_gg(d, a, b, c, x[i + 2], 9, -51403784);
			c = md5_gg(c, d, a, b, x[i + 7], 14, 1735328473);
			b = md5_gg(b, c, d, a, x[i + 12], 20, -1926607734);
			a = md5_hh(a, b, c, d, x[i + 5], 4, -378558);
			d = md5_hh(d, a, b, c, x[i + 8], 11, -2022574463);
			c = md5_hh(c, d, a, b, x[i + 11], 16, 1839030562);
			b = md5_hh(b, c, d, a, x[i + 14], 23, -35309556);
			a = md5_hh(a, b, c, d, x[i + 1], 4, -1530992060);
			d = md5_hh(d, a, b, c, x[i + 4], 11, 1272893353);
			c = md5_hh(c, d, a, b, x[i + 7], 16, -155497632);
			b = md5_hh(b, c, d, a, x[i + 10], 23, -1094730640);
			a = md5_hh(a, b, c, d, x[i + 13], 4, 681279174);
			d = md5_hh(d, a, b, c, x[i + 0], 11, -358537222);
			c = md5_hh(c, d, a, b, x[i + 3], 16, -722521979);
			b = md5_hh(b, c, d, a, x[i + 6], 23, 76029189);
			a = md5_hh(a, b, c, d, x[i + 9], 4, -640364487);
			d = md5_hh(d, a, b, c, x[i + 12], 11, -421815835);
			c = md5_hh(c, d, a, b, x[i + 15], 16, 530742520);
			b = md5_hh(b, c, d, a, x[i + 2], 23, -995338651);
			a = md5_ii(a, b, c, d, x[i + 0], 6, -198630844);
			d = md5_ii(d, a, b, c, x[i + 7], 10, 1126891415);
			c = md5_ii(c, d, a, b, x[i + 14], 15, -1416354905);
			b = md5_ii(b, c, d, a, x[i + 5], 21, -57434055);
			a = md5_ii(a, b, c, d, x[i + 12], 6, 1700485571);
			d = md5_ii(d, a, b, c, x[i + 3], 10, -1894986606);
			c = md5_ii(c, d, a, b, x[i + 10], 15, -1051523);
			b = md5_ii(b, c, d, a, x[i + 1], 21, -2054922799);
			a = md5_ii(a, b, c, d, x[i + 8], 6, 1873313359);
			d = md5_ii(d, a, b, c, x[i + 15], 10, -30611744);
			c = md5_ii(c, d, a, b, x[i + 6], 15, -1560198380);
			b = md5_ii(b, c, d, a, x[i + 13], 21, 1309151649);
			a = md5_ii(a, b, c, d, x[i + 4], 6, -145523070);
			d = md5_ii(d, a, b, c, x[i + 11], 10, -1120210379);
			c = md5_ii(c, d, a, b, x[i + 2], 15, 718787259);
			b = md5_ii(b, c, d, a, x[i + 9], 21, -343485551);
			a = safe_add(a, olda);
			b = safe_add(b, oldb);
			c = safe_add(c, oldc);
			d = safe_add(d, oldd)
		}
		if (mode == 16) {
			return Array(b, c)
		} else {
			return Array(a, b, c, d)
		}
	}
	function md5_cmn(q, a, b, x, s, t) {
		return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b)
	}
	function md5_ff(a, b, c, d, x, s, t) {
		return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t)
	}
	function md5_gg(a, b, c, d, x, s, t) {
		return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t)
	}
	function md5_hh(a, b, c, d, x, s, t) {
		return md5_cmn(b ^ c ^ d, a, b, x, s, t)
	}
	function md5_ii(a, b, c, d, x, s, t) {
		return md5_cmn(c ^ (b | (~d)), a, b, x, s, t)
	}
	function core_hmac_md5(key, data) {
		var bkey = str2binl(key);
		if (bkey.length > 16) {
			bkey = core_md5(bkey, key.length * chrsz)
		}
		var ipad = Array(16),
			opad = Array(16);
		for (var i = 0; i < 16; i++) {
			ipad[i] = bkey[i] ^ 909522486;
			opad[i] = bkey[i] ^ 1549556828
		}
		var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
		return core_md5(opad.concat(hash), 512 + 128)
	}
	function safe_add(x, y) {
		var lsw = (x & 65535) + (y & 65535);
		var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
		return (msw << 16) | (lsw & 65535)
	}
	function bit_rol(num, cnt) {
		return (num << cnt) | (num >>> (32 - cnt))
	}
	function str2binl(str) {
		var bin = Array();
		var mask = (1 << chrsz) - 1;
		for (var i = 0; i < str.length * chrsz; i += chrsz) {
			bin[i >> 5] |= (str.charCodeAt(i / chrsz) & mask) << (i % 32)
		}
		return bin
	}
	function binl2str(bin) {
		var str = "";
		var mask = (1 << chrsz) - 1;
		for (var i = 0; i < bin.length * 32; i += chrsz) {
			str += String.fromCharCode((bin[i >> 5] >>> (i % 32)) & mask)
		}
		return str
	}
	function binl2hex(binarray) {
		var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
		var str = "";
		for (var i = 0; i < binarray.length * 4; i++) {
			str += hex_tab.charAt((binarray[i >> 2] >> ((i % 4) * 8 + 4)) & 15) + hex_tab.charAt((binarray[i >> 2] >> ((i % 4) * 8)) & 15)
		}
		return str
	}
	function binl2b64(binarray) {
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		var str = "";
		for (var i = 0; i < binarray.length * 4; i += 3) {
			var triplet = (((binarray[i >> 2] >> 8 * (i % 4)) & 255) << 16) | (((binarray[i + 1 >> 2] >> 8 * ((i + 1) % 4)) & 255) << 8) | ((binarray[i + 2 >> 2] >> 8 * ((i + 2) % 4)) & 255);
			for (var j = 0; j < 4; j++) {
				if (i * 8 + j * 6 > binarray.length * 32) {
					str += b64pad
				} else {
					str += tab.charAt((triplet >> 6 * (3 - j)) & 63)
				}
			}
		}
		return str
	}
	function hexchar2bin(str) {
		var arr = [];
		for (var i = 0; i < str.length; i = i + 2) {
			arr.push("\\x" + str.substr(i, 2))
		}
		arr = arr.join("");
		eval("var temp = '" + arr + "'");
		return temp
	}
	function __monitor(mid, probability) {
		if (Math.random() > (probability || 1)) {
			return
		}
		try {
			var url = location.protocol + "//ui.ptlogin2.qq.com/cgi-bin/report?id=" + mid;
			var s = document.createElement("img");
			s.src = url
		} catch (e) {}
	}
	function getEncryption(password, salt, vcode, isMd5) {
		vcode = vcode || "";
		password = password || "";
		var md5Pwd = isMd5 ? password : md5(password),
			h1 = hexchar2bin(md5Pwd),
			s2 = md5(h1 + salt),
			rsaH1 = $pt.RSA.rsa_encrypt(h1),
			rsaH1Len = (rsaH1.length / 2).toString(16),
			hexVcode = TEA.strToBytes(vcode.toUpperCase(), true),
			vcodeLen = Number(hexVcode.length / 2).toString(16);
		while (vcodeLen.length < 4) {
			vcodeLen = "0" + vcodeLen
		}
		while (rsaH1Len.length < 4) {
			rsaH1Len = "0" + rsaH1Len
		}
		TEA.initkey(s2);
		var saltPwd = TEA.enAsBase64(rsaH1Len + rsaH1 + TEA.strToBytes(salt) + vcodeLen + hexVcode);
		TEA.initkey("");
		setTimeout(function() {
			__monitor(488358, 1)
		}, 0);
		return saltPwd.replace(/[\/\+=]/g, function(a) {
			return {
				"/": "-",
				"+": "*",
				"=": "_"
			}[a]
		})
	}
	function getRSAEncryption(password, vcode, isMd5) {
		var str1 = isMd5 ? password : md5(password);
		var str2 = str1 + vcode.toUpperCase();
		var str3 = $.RSA.rsa_encrypt(str2);
		return str3
	}
	return {
		getEncryption: getEncryption,
		getRSAEncryption: getRSAEncryption,
		md5: md5
	}
}();
try {
	window.MTT = function() {
		function t() {
			try {
				if (!o) return !1;
				var t = navigator.userAgent,
					e = /msie/i.test(t) && "notify" in window.external;
				if (e) return !0;
				var n = s && o >= 42,
					i = c && o >= 32,
					r = p && o >= 42;
				return n || i || r
			} catch (a) {
				return !1
			}
		}
		function e(t) {
			var e = 5 != $.cookie.get("pt_qlogincode") && MTT.canQlogin();
			"function" == typeof t && (e ? /msie/i.test(window.navigator.userAgent) ? (window.external.notify("#@getUserInfoWT@#pt.qqBrowserCallback"), pt.qqBrowserCallbackClock = setTimeout(function() {
				pt.init()
			}, pt.qqBrowserCallbackTime)) : (p ? browser.login.getLoginInfo ? browser.login.getLoginInfo(t, t) : t("") : (s || c) && (browser.login.getUinAndSidInfo ? browser.login.getUinAndSidInfo(t, t) : t("")), pt.qqBrowserCallbackClock = setTimeout(function() {
				pt.init()
			}, pt.qqBrowserCallbackTime)) : (t(""), 5 == $.cookie.get("pt_qlogincode") && $.report.nlog("快速登录异常：pt_qlogincode=5", "276650")))
		}
		function n(t, e) {
			if (!o) return e && e(), !1;
			if (p) {
				if (!browser.app.getApkInfo) return e && e();
				browser.app.getApkInfo(function(n) {
					try {
						n = JSON.parse(JSON.parse(n)), o >= 51 && n && n.versionname >= "4.7" ? t && t() : e && e()
					} catch (i) {
						e && e()
					}
				}, "com.tencent.mobileqq")
			} else(s || c) && window.x5 && x5.exec(function(n) {
				n && n.isSupportApp ? t && t() : e && e()
			}, e, "app", "getMobileAppSupport", [{
				scheme: "wtloginmqq2://"
			}]);
			return !1
		}
		function i(t, e) {
			p && browser.login.refreshToken ? browser.login.refreshToken({
				uin: t
			}, e) : (c || s) && window.x5 && x5.exec(e, e, "login", "refreshToken", [{
				uin: t
			}])
		}
		var o = 0,
			r = "";
		try {
			"undefined" != typeof window.browser ? o = browser.env && browser.env.version : window.browser = {
				env: {},
				app: {},
				login: {}
			}, r = browser.env && browser.env.platForm
		} catch (a) {
			$.report.nlog("browser_env:ver(" + window.ptui_pt_version + ")" + a.message, "647126")
		}
		var p = "ADR" == r,
			s = "I" == r,
			c = "IP" == r;
		return {
			version: o,
			isAndroid: p,
			isIPhone: s,
			canQlogin: t,
			QLogin4PT: e,
			canOneKey: n,
			refreshToken: i
		}
	}()
} catch (e) {
	$.report.nlog("QB Exception:ver(" + window.ptui_pt_version + ")" + e.message, "647127"), window.MTT = {}
}
var pt = {
	pageState: 1,
	login_href: g_href,
	domain: window.ptui_domain,
	isHttps: $.check.isHttps(),
	errTipClock: 0,
	lang: window.STR_LANG,
	submit_o: {},
	auto_login: !1,
	switch_position_x: 0,
	touchstartTime: 0,
	longTouchTime: 500,
	default_face_url: "",
	is_qlogin: !1,
	lang_num: window.ptui_lang,
	action: [0, 0],
	vcode: "",
	verifysession: "",
	deviceType: 2,
	login_uin: "",
	login_pwd: "",
	needAt: "",
	appid: "",
	s_url: "",
	low_login_enable: window.ptui_low_login,
	style: 9,
	t_type: 0,
	t_appid: 46000101,
	isSubmiting: !1,
	key_interval: 0,
	keyindex: 19,
	qqBrowserInfo: null,
	qqBrowserCallbackTime: 3e3,
	qqBrowserCallbackTimeOut: 0,
	authInfo: null,
	authUin: "",
	authNick: "",
	authLoginUrl: "",
	qlogin_list_data: [],
	checkUrl: "",
	loginUrl: "",
	cookieInfo: null,
	cookieLogin: !1,
	regTmp: '<span id="#uin#" pwd="#pwd#" type="#type#" class="header">\r\n                    <div id="del_touch_#uin#" class="del_touch_icon" >\r\n                        <span id="del_#uin#" class="del_icon" ></span>\r\n                    </div>\r\n                    <img  id="img_#uin#" src="#src#" onerror="pt.face_error();" /> \r\n                    <div id="img_out_#uin#" class="img_out" onclick="pt.clickHeader(event);"></div>\r\n                    <label id="nick_#uin#" class="nick">#nick# </label>\r\n                </span>',
	hulianRegTmp: '<div class="useravatar">\r\n                    <img id="img_#uin#" src="#src#" onerror="pt.face_error();" alt="#nick#" />\r\n                  </div>\r\n                  <div class="userinfo">\r\n                        <div class="usernick" id="hl_usernick">#nick#</div>\r\n                        <div class="userqq">#uin#</div>\r\n                  </div>\r\n                  <button id="userSwitch" class="switch" tabindex="5" href="javascript:void(0)";>切换帐号</button>',
	new_vcode: !1,
	clickEvent: "touchstart",
	checkErr: {
		2052: "网络繁忙，请稍后重试。",
		1028: "網絡繁忙，請稍後重試。",
		1033: "The network is busy, please try again later."
	},
	isHulian: 716027609 == window.ptui_appid,
	isOffice: 39 == window.ptui_style,
	isWtlogin: 42 == window.ptui_style,
	isInIframe: 38 == window.ptui_style,
	is3gNews: 37 == window.ptui_style,
	isMail: 522005705 == window.ptui_appid,
	lockedAccount: 1 == window.ptui_lockuin ? window.ptui_defuin : "",
	ua: navigator.userAgent.toLowerCase(),
	isWX: navigator.userAgent.match(/micromessenger\/(\d\.\d\.\d)/i),
	isMQQ: navigator.userAgent.match(/qq\/(\d\.\d\.\d)/i),
	isAndroid: /android/i.test(navigator.userAgent),
	isIos: /iphone|ipad/i.test(navigator.userAgent),
	isIPhone: /iphone/i.test(navigator.userAgent),
	uInput: $("u"),
	pInput: $("p"),
	btnGo: $("go"),
	btnOnekey: $("onekey"),
	redirect: function(t, e) {
		switch (t + "") {
		case "0":
			pt.isInIframe ? location.replace(e) : location.href = e;
			break;
		case "1":
			top.location.href = e;
			break;
		default:
			top.location.href = e
		}
	},
	init: function() {
		pt.hasInit || (pt.hasInit = !0, pt.default_face_url = pt.isHttps ? "https://ui.ptlogin2.qq.com/style/0/images/1.gif" : "http://imgcache.qq.com/ptlogin/v4/style/0/images/1.gif", pt.initSURL(), pt.setClickEvent(), pt.isOffice && pt.open.loadAppInfo(), pt.isHulian || pt.isWtlogin ? pt.setCookieLogin() : (pt.is3gNews || pt.build_qlogin_list(), pt.initFace()), pt.bindEvent(), pt.bindInput(), pt.hideURLBar(), pt.setVcodeFlag(), pt.setUrl(), pt.showAutoLogin(), $.winName.set("login_href", encodeURIComponent(pt.login_href)), pt.checkIframe(), pt.checkPostMessage(), window.setTimeout(function() {
			"549000929" != window.ptui_appid && pt.webLoginReport(), $.report.monitor(412020, .05), navigator.cookieEnabled || ($.report.monitor(410030), $.cookie.get("ptcz") && $.report.monitor(410031))
		}, 2e3), $.http.loadScript((pt.isHttps ? "https://ssl.captcha.qq.com/" : "http://captcha.qq.com/") + "template/TCapIframeApi.js?aid=" + window.ptui_appid + "&rand=" + Math.random() + "&clientype=1&lang=" + pt.lang_num + "&apptype=2", function() {}))
	},
	vcodeMessage: function(t) {
		var data = JSON.parse(t.data);
		data = data.message;
		pt.submitNewVcode(data);
	},
	setUrl: function() {
		var t = pt.isHttps ? "https://ssl." : "http://",
			e = pt.isHttps ? "https://ssl." : "http://check.";
		switch (pt.checkUrl = e + "ptlogin2." + pt.domain + "/check?", pt.loginUrl = t + "ptlogin2." + pt.domain + "/", parseInt(window.ptui_regmaster)) {
		case 2:
			pt.checkUrl = "http://check.ptlogin2.function.qq.com/check?", pt.loginUrl = "http://ptlogin2.function.qq.com/";
			break;
		case 3:
			pt.checkUrl = e + "ptlogin2.crm2.qq.com/check?", pt.loginUrl = t + "ptlogin2.crm2.qq.com/";
			break;
		case 4:
			pt.checkUrl = "https://ssl.ptlogin2.mail.qq.com/check?", pt.loginUrl = "https://ssl.ptlogin2.mail.qq.com/";
			break;
		case 5:
			pt.checkUrl = e + "ptlogin2.mp.qq.com/check?", pt.loginUrl = t + "ptlogin2.mp.qq.com/";
			break;
		case 6:
			pt.loginUrl = (pt.isHttps ? "https" : "http") + "://ptlogin2.vip.qq.com/"
		}
	},
	ptui_speedReport: function(t) {
		var e = "http://isdspeed.qq.com/cgi-bin/r.cgi?flag1=7808&flag2=8",
			n = 1;
		if (pt.isHttps) e = "https://huatuospeed.weiyun.com/cgi-bin/r.cgi?flag1=7808&flag2=8", n = 2;
		else if ("MQQBrowser" == $.detectBrowser()[0]) {
			var i = navigator.connection;
			if (i && i.type) {
				var o = i.type;
				n = 1 == o ? 3 : 2 == o ? 4 : 3 == o ? 5 : 4 == o ? 6 : 5 == o ? 7 : 8
			} else n = 8
		} else n = 1;
		e += "&flag3=" + n;
		for (var r in t) t[r] > 15e3 || t[r] < 0 || (e += "&" + r + "=" + (t[r] || 1));
		var a = new Image;
		a.src = e
	},
	webLoginReport: function() {
		try {
			if (Math.random() > .2 && "MQQBrowser" != $.detectBrowser()[0]) return;
			var t = ["navigationStart", "unloadEventStart", "unloadEventEnd", "redirectStart", "redirectEnd", "fetchStart", "domainLookupStart", "domainLookupEnd", "connectStart", "connectEnd", "requestStart", "responseStart", "responseEnd", "domLoading", "domInteractive", "domContentLoadedEventStart", "domContentLoadedEventEnd", "domComplete", "loadEventStart", "loadEventEnd"],
				e = {},
				n = window.performance ? window.performance.timing : null;
			if (n) {
				for (var i = n[t[0]], o = 1, r = t.length; r > o; o++) n[t[o]] && (e[o] = n[t[o]] - i);
				loadJs && loadJs.onloadTime && (e[o++] = loadJs.onloadTime - i);
				var a = n.connectEnd >= n.connectStart && n.responseEnd >= n.responseStart && n.domComplete >= n.domInteractive && n.domInteractive >= n.domLoading && n.loadEventStart >= n.domComplete && n.loadEventEnd >= n.loadEventStart;
				a && pt.ptui_speedReport(e)
			}
		} catch (p) {}
	},
	setClickEvent: function() {
		!/iphone|ipad|android/.test(navigator.userAgent.toLowerCase());
		pt.clickEvent = "click"
	},
	saveLastUin: function(t) {
		$.localStorage.set("last_uin", t)
	},
	getLastUin: function() {
		return $.localStorage.get("last_uin")
	},
	object2param: function(t) {
		var e = [];
		for (var n in t) e.push(n + "=" + t[n] + "&");
		return e.join("")
	},
	showErr: function(t, e) {
		clearTimeout(pt.errTipClock);
		var n = 3e3;
		"number" == (typeof e).toLocaleLowerCase() && (n = parseInt(e, 10), e = null), $("error_message").innerHTML = t, $.css.show("error_tips"), pt.isHulian ? (navigator.userAgent.match(/iphone/i) && pt.btnGo.focus(), pt.errTipClock = setTimeout(function() {
			pt.hideErr(e)
		}, n)) : (e && e(), pt.errTipClock = setTimeout(function() {
			pt.hideErr()
		}, n))
	},
	hideErr: function(t) {
		$.css.hide("error_tips"), t && t()
	},
	checkIframe: function() {
		try {
			top == self || pt.isHulian || $.report.nlog("iphone登录框被iframe;referer=" + document.referrer, "347748")
		} catch (t) {}
	},
	checkPostMessage: function() {
		"undefined" == typeof window.postMessage && $.report.nlog("iphone登录框不支持postMessage;", "350525"), "undefined" == typeof window.JSON && $.report.nlog("iphone登录框不支持JSON;", "362678")
	},
	setVcodeFlag: function() {
		pt.new_vcode = "undefined" == typeof window.postMessage || "undefined" == typeof window.JSON ? !1 : !0
	},
	getAuthUrl: function() {
		var t = (pt.isHttps ? "https://ssl." : "http://") + "ptlogin2." + pt.domain + "/pt4_auth?daid=" + window.ptui_daid + "&appid=" + window.ptui_appid + "&auth_token=" + $.str.time33($.cookie.get("supertoken"));
		return "1" == window.ptui_pt_qzone_sig && (t += "&pt_qzone_sig=1"), t
	},
	auth: function() {
		pt.getParam(), pt.initSURL();
		var t = pt.getAuthUrl(),
			e = $.cookie.get("superuin"),
			n = $.str.hash33(e);
		!parseInt($.cookie.get("supertoken")) && n && $.cookie.set("supertoken", $.str.hash33(e), "ptlogin2." + pt.domain), window.ptui_daid && "1" != window.ptui_noAuth && "" != e && !pt.isWtlogin ? $.http.loadScript(t) : pt.qqBrowserQlogin()
	},
	showAuth: function(t) {
		var e = t.substr(t.indexOf("?") + 1),
			n = e.match(RegExp("(^|&)uin=([^&]*)(&|$)"));
		pt.authUin = n ? decodeURIComponent(n[2]) : "", pt.authLoginUrl = t, pt.authNick = $.str.utf8ToUincode($.cookie.get("ptnick_" + pt.authUin)) || pt.authUin, pt.authUin && (pt.authInfo = {
			uin: $.str.encodeHtml(pt.authUin),
			nick: $.str.encodeHtml(pt.authNick),
			authUrl: pt.authUrl,
			type: 3
		})
	},
	setCookieLogin: function() {
		var t = $.cookie.get("skey"),
			e = $.cookie.get("supertoken"),
			n = $.cookie.uin(),
			i = $.str.utf8ToUincode($.cookie.get("ptnick_" + n)) || n,
			o = window.pt_skey_valid && t || window.ptui_daid && e;
		return o && n ? (pt.cookieInfo = {
			uin: $.str.encodeHtml(n),
			nick: $.str.encodeHtml(i),
			superkey: e,
			skey: t,
			type: 4
		}, !0) : !1
	},
	qqBrowserQlogin: function() {
		try {
			self === top || MTT.isAndroid ? MTT.QLogin4PT(pt.qqBrowserCallback) : pt.init()
		} catch (t) {
			pt.init(), $.report.nlog("快速登录异常,qqBrowserQlogin," + t.message, "276650")
		}
	},
	qqBrowserCallback: function(t) {
		window.clearTimeout(pt.qqBrowserCallbackClock);
		try {
			t && "string" == typeof t && (t = JSON.parse(t)), t && $.check.isQQ(t.uin) && 0 != t.loginkey.length && t.loginkey.length > 10 ? (pt.qqBrowserInfo = {}, pt.qqBrowserInfo.uin = $.str.encodeHtml(t.uin), pt.qqBrowserInfo.nick = $.str.encodeHtml(t.nickname), pt.qqBrowserInfo.loginkey = t.loginkey, pt.qqBrowserInfo.type = 2) : t && 0 == t.uin.length ? $.report.nlog("快速登录异常：数据返回异常,没有uin", "276650") : t && 0 == t.loginkey.length ? $.report.nlog("快速登录异常：数据返回异常,没有loginkey", "276650") : t && $.report.nlog("快速登录异常：数据返回异常:" + t.loginkey.length, "276650")
		} catch (e) {
			$.report.nlog("快速登录异常： qqBrowserCallback " + e.message, "276650")
		}
		pt.init()
	},
	initSURL: function() {
		pt.s_url = $.bom.query("s_url"), pt.isMail && 1 == pt.low_login_enable && (pt.s_url = pt.addParamToUrl(pt.s_url, "ss", 1))
	},
	addParamToUrl: function(t, e, n) {
		var i = t.split("#"),
			o = i[0].indexOf("?") > 0 ? "&" : "?";
		return "?" == i[0].substr(i[0].length - 1, 1) && (o = ""), i[1] = i[1] ? "#" + i[1] : "", i[0] + o + e + "=" + n + i[1]
	},
	getParam: function() {
		if (pt.appid = window.ptui_appid, pt.isInIframe) switch (window.ptui_target) {
		case "_self":
			pt.target = 0;
			break;
		case "_top":
			pt.target = 1;
			break;
		default:
			pt.target = 1
		} else pt.target = 1;
		pt.style = window.ptui_style ? window.ptui_style : 9, pt.isHulian && (window.pt_skey_valid = parseInt($.bom.query("pt_skey_valid")) || 0)
	},
	build_qlogin_list: function() {
		var t = pt.get_qlogin_list();
		pt.qlogin_list_data = t;
		var e = t.length;
		if (e > 0) {
			pt._switch(), pt.hideOneKey();
			for (var n = "", i = 0; e > i; i++)"" != t[i].uin && (n += pt.regTmp.replace(/#uin#/g, t[i].uin).replace(/#nick#/g, t[i].nick).replace(/#pwd#/g, t[i].pwd).replace(/#type#/g, t[i].type).replace(/#src#/g, pt.default_face_url));
			$("q_logon_list").innerHTML = n;
			for (var i = 0; e > i; i++) pt.getShortWord($("nick_" + t[i].uin), t[i].nick, 95);
			$("swicth_login") && ($("swicth_login").style.display = "block")
		} else $("web_login") && ($("web_login").style.display = "block"), $("swicth_login") && ($("swicth_login").style.display = "none")
	},
	fill_usernick: function() {
		window.mqq && mqq.data && mqq.data.getUserInfo && mqq.data.getUserInfo(function(t) {
			var e = $("hl_usernick");
			e && t && t.nick && (e.innerHTML = $.str.encodeHtml(t.nick))
		})
	},
	build_office_qlogin: function() {
		return $.report.monitor(2123219), pt.cookieInfo || pt.setCookieLogin(), pt.cookieInfo ? (pt.cookieLogin = !0, $("hl_avatar").style.backgroundImage = "url(https://q4.qlogo.cn/g?b=qq&nk=" + pt.cookieInfo.uin + "&s=100)", $("hl_usernick").innerHTML = pt.cookieInfo.nick || pt.cookieInfo.uin, $("hl_qqnum").innerHTML = "(" + pt.cookieInfo.uin + ")", void pt.fill_usernick()) : $.report.monitor(2123220)
	},
	build_hulian_qlogin_list: function(t) {
		if (t.nick && pt.cookieInfo && (pt.cookieInfo.nick = $.str.encodeHtml(t.nick)), pt.isOffice) return void pt.build_office_qlogin(t);
		var e = pt.get_qlogin_list();
		pt.qlogin_list_data = e;
		var n = window.ptui_daid && 1 == t.superkey || t.skey,
			i = e.length;
		if (i > 0) {
			pt.hideOneKey();
			for (var o = "", r = 0; i > r; r++) {
				var a = e[r];
				if (n || !pt.cookieInfo || pt.cookieInfo.uin != a.uin) {
					"" != a.uin && (o += pt.hulianRegTmp.replace(/#uin#/g, a.uin).replace(/#nick#/g, a.nick).replace(/#type#/g, a.type).replace(/#src#/g, pt.default_face_url));
					break
				}
			}
			setTimeout(function() {
				var t = $("q_logon_list");
				t.innerHTML = o, $.css.show(t), $.css.hide($("form_outter_wrap")), pt.cookieLogin = n, pt.fill_usernick();
				var e = $("userSwitch");
				window.ptui_lockuin ? e && $.css.hide(e) : e && $.e.add(e, "click", function() {
					pt.showOneKey.ever && pt.showOneKey(), pt.qqBrowserInfo = null, pt.open.authListDone && (xMsg.call("connect", "userSwitch", {}, function() {}), pt.cancel_cookielogin(!0), $.report.monitor(2106346))
				})
			}, 0)
		}
	},
	_switch: function() {
		"none" == $("q_login").style.display ? ($("q_login").style.display = "block", $("web_login").style.display = "none", $("swicth_login") && ($("swicth_login").innerHTML = $.str.encodeHtml(qlogin_wording)), pt.hideURLBar(), pt.pageState = 2) : (pt.showOneKey.ever && pt.showOneKey(), $("q_login").style.display = "none", $("web_login").style.display = "block", $("swicth_login") && ($("swicth_login").innerHTML = $.str.encodeHtml(login_wording)), pt.uInput.focus(), pt.pageState = 1), pt.showAutoLogin(), pt.isInIframe && window.setTimeout(function() {
			pt.ptui_notifySize("content")
		}, 0)
	},
	checkNetwork: function() {
		return navigator.onLine ? pt._timer = setTimeout(function() {
			$.report.monitor(2114669), pt.showErr(STR_LANG.offline)
		}, 3e3) : void pt.showErr(STR_LANG.offline)
	},
	submitEvent: function() {
		pt.checkNetwork(), pt.isHulian ? pt.open.getAuthData() : pt.check(!1), pt.qrcode.used = !1
	},
	showOneKey: function(t) {
		var e = $("onekey");
		if (pt.showOneKey.ever || ($.e.add(e, pt.clickEvent, pt.doOneKey), $.e.add(e, "blur", pt.cancelAutoOneKey)), pt.showOneKey.ever = !0, t ? pt.btnGo.className += " weak" : e.className += " weak", e && $.css.show(e), e.focus(), $.report.monitor(414089), pt.isInIframe && window.setTimeout(function() {
			pt.ptui_notifySize("content")
		}, 0), t && "justshow" != t) {
			var n = e.innerHTML,
				i = 3,
				o = n + "中({{second}}秒...)";
			e.innerHTML = o.replace("{{second}}", i--), pt.showOneKey.tid = setInterval(function() {
				e.innerHTML = o.replace("{{second}}", i--), 0 > i && (i = 3, clearInterval(pt.showOneKey.tid), e.innerHTML = n, pt.doOneKey())
			}, 1e3)
		}
	},
	cancelAutoOneKey: function() {
		clearInterval(pt.showOneKey.tid);
		var t = pt.btnOnekey;
		t && (t.innerHTML = STR_LANG.onekey)
	},
	hideOneKey: function() {
		pt.cancelAutoOneKey(), pt.btnGo.className = pt.btnGo.className.replace("weak", ""), pt.btnOnekey && $.css.hide(pt.btnOnekey), pt.isInIframe && window.setTimeout(function() {
			pt.ptui_notifySize("content")
		}, 0)
	},
	bindEvent: function() {
		var t = pt.uInput,
			e = pt.pInput;
		$.e.add(pt.btnGo, pt.clickEvent, pt.submitEvent), e && $.e.add(e, "keydown", function(t) {
			var e = t.keyCode;
			13 == e && pt.submitEvent()
		}), t && $.e.add(t, "keydown", function(t) {
			var e = t.keyCode;
			13 == e && pt.check(!1)
		});
		var n = navigator.userAgent.toLowerCase(),
			i = pt.isWX || pt.isMQQ || n.match(/meizu_m9|IEMobile/i) || 46000101 == window.ptui_appid || pt.s_url.indexOf("//openmobile.qq.com/api/check") >= 0,
			o = pt.btnOnekey;
		if (!i && o) if (pt.isHulian) n.match(/iphone|ipad/i) && (document.addEventListener("touchmove", function() {
			pt.btnGo.focus()
		}, !1), document.addEventListener("touchstart", function(t) {
			(pt.uInput != t.target || pt.pInput != t.target) && pt.btnGo.focus()
		}, !1)), pt.open.waiting("authlist", function() {
			MTT.canOneKey(function() {
				pt.qqBrowserInfo || pt.showOneKey(!0)
			}, function() {
				pt.hideOneKey()
			})
		});
		else if (self === top && MTT.version) MTT.canOneKey(function() {
			pt.qqBrowserInfo || pt.showOneKey("justshow")
		}, function() {
			pt.hideOneKey()
		});
		else {
			var n = navigator.userAgent,
				r = n.indexOf("Windows NT") > -1 || n.indexOf("Macintosh") > -1;
			r || pt.showOneKey()
		} else pt.hideOneKey();
		if ($("show_pwd") && $.e.add($("show_pwd"), "change", function() {
			var t = pt.pInput;
			this.checked ? t.setAttribute("type", "text") : t.setAttribute("type", "password")
		}), $("forgetpwd") && $.e.add($("forgetpwd"), pt.clickEvent, function() {
			var t = pt.uInput && pt.uInput.value,
				e = "http://ptlogin2.qq.com/ptui_forgetpwd_mobile?ptlang=" + pt.lang_num;
			"1033" != pt.lang_num && (e += "&account=" + t), window.open(e)
		}), $.e.add(window, "orientationchange", function(t) {
			pt.hideURLBar(t)
		}), $.e.add(window, "message", function(d) {
			pt.vcodeMessage(d)
		}), pt.isMail) {
			var a = $("remember");
			if (!a) return;
			$.e.add(a, "change", function() {
				pt.s_url = a.checked ? pt.addParamToUrl(pt.s_url, "ss", 1) : pt.s_url.replace(/&?ss=1/, ""), pt.low_login_enable = a.checked ? 1 : 0
			})
		}
	},
	bindInput: function() {
		if (!pt.isOffice) {
			var t = window.ptui_defuin || pt.lockedAccount || pt.getLastUin(),
				e = pt.uInput,
				n = pt.pInput,
				i = $("del_u"),
				o = $("del_p"),
				r = $("del_touch"),
				a = $("del_touch_p");
			t && (e.value = e.value || t), pt.lockedAccount && (r && (r.parentNode.removeChild(r), r = null), i = null, e.readOnly = !0, n.focus());
			var p = function() {
					i && ("" != e.value ? $.css.show(i) : $.css.hide(i))
				},
				s = function() {
					"" != n.value ? $.css.show(o) : $.css.hide(o);
					var t = 0;
					(n.selectionStart || "0" == n.selectionStart) && (t = Math.max(n.selectionStart, n.selectionEnd)), window.openSDK && window.openSDK.curPosFromJS && window.openSDK.curPosFromJS(t)
				};
			$.e.add(n, "focus", function() {
				"" != this.value && $.css.show(o), window.openSDK && window.openSDK.isPasswordEdit && window.openSDK.isPasswordEdit(1)
			}), $.e.add(n, "blur", function() {
				"" == this.value && $.css.hide(o), window.openSDK && window.openSDK.isPasswordEdit && window.openSDK.isPasswordEdit(0)
			}), $.e.add(n, "input", function() {
				window.setTimeout(function() {
					s()
				}, 0)
			}), $.e.add(e, "focus", function() {
				i && "" != this.value && $.css.show(i)
			}), $.e.add(e, "blur", function() {
				/^\+/.test(this.value) && (this.value = this.value.replace(/^\+/, ""), /^00/.test(this.value) || (this.value = "00" + this.value)), "" == this.value ? i && $.css.hide(i) : pt.checkQQUin(this.value)
			}), $.e.add(e, "input", function() {
				p()
			}), r && $.e.add(r, "click", function(t) {
				t && t.preventDefault(), e.value = "", e.focus(), i && $.css.hide(i)
			}), a && $.e.add(a, "click", function(t) {
				t && t.preventDefault(), n.value = "", n.focus(), o && $.css.hide(o)
			}), (pt.isHulian || pt.isWtlogin) && (i && $.e.add(i, "click", function(t) {
				t && t.preventDefault(), e.value = "", e.focus(), $.css.hide(i)
			}), o && $.e.add(o, "click", function(t) {
				t && t.preventDefault(), n.value = "", window.openSDK && window.openSDK.clearAllEdit && window.openSDK.clearAllEdit(), n.focus(), $.css.hide(o)
			}))
		}
	},
	bindVcodeEvent: function() {
		$("input_tips") && $.e.add($("input_tips"), "click", function(t) {
			$("vcode_input").focus(), $.css.hide("input_tips"), t.stopPropagation()
		}), $("vcode_input") && $.e.add($("vcode_input"), "focus", function(t) {
			$.css.hide("input_tips"), t.stopPropagation()
		}), $("vcode_input") && $.e.add($("vcode_input"), "blur", function() {
			"" == this.value && $.css.show("input_tips")
		}), $("vcode_img") && $.e.add($("vcode_img"), "click", function(t) {
			$("vcode_input").focus(), $.css.hide("input_tips"), pt.changeCodeImg(), t.stopPropagation()
		}), $("submit") && $.e.add($("submit"), "click", function() {
			pt.submitVcode()
		})
	},
	hideURLBar: function() {
		setTimeout(function() {
			window.scrollTo(0, 1)
		}, 0)
	},
	showAutoLogin: function() {
		if (pt.isMail) {
			var t = $("auto_login");
			if (t) {
				var e = pt.btnGo;
				if (1 == pt.pageState) $("web_login").insertBefore(t, e);
				else {
					var n = $("q_login");
					n.insertBefore(t, n.lastChild)
				}
				$.css.show(t)
			}
		}
	},
	doOneKey: function() {
		if (!pt.doOneKey.ing) {
			pt.doOneKey.ing = !0, setTimeout(function() {
				pt.doOneKey.ing = !1
			}, 5e3);
			var t = navigator.userAgent.toLowerCase(),
				e = pt.loginUrl + "jump?u1=" + encodeURIComponent(pt.s_url) + "&pt_report=1";
			"1" == window.ptui_pt_ttype && (e += "&pt_ttype=1"), window.ptui_daid && (e += "&daid=" + ptui_daid), pt.low_login_enable && (e += "&low_login_enable=1&low_login_hour=" + window.ptui_low_login_hour), e += "&style=" + window.ptui_style;
			var n = $.detectBrowser()[0];
			n && (e += "&pt_ua=" + $.Encryption.md5(t), e += "&pt_browser=" + n);
			var i = $.bom.query("pt_appname");
			i && (e += "&pt_appname=" + i);
			var o = $.bom.query("pt_package");
			if (/android/i.test(navigator.userAgent)) o && (e += "&pt_package=" + o);
			else {
				var r = $.bom.query("pt_bundleid") || o;
				r && (e += "&pt_bundleid=" + r)
			}
			$.report.monitor(414090), pt.isHulian ? pt.open.waiting("authdata", function() {
				window.ptui_pt_3rd_aid && (e += "&pt_3rd_aid=" + window.ptui_pt_3rd_aid), pt.submit_o.openlogin_data && (e += "&pt_openlogin_data=" + pt.submit_o.openlogin_data), OneKey("wtloginmqq://ptlogin/qlogin?p=" + encodeURIComponent(e))
			}) : OneKey("wtloginmqq://ptlogin/qlogin?p=" + encodeURIComponent(e))
		}
	},
	addToSet: function(t, e) {
		if (e) {
			for (var n = e.uin, i = !0, o = 0, r = t.length; r > o; o++) t[o].uin == n && (i = !1);
			i && t.push(e)
		} else;
	},
	get_qlogin_list: function() {
		var t = [];
		return pt.isHulian ? pt.cookieInfo && pt.addToSet(t, pt.cookieInfo) : pt.authInfo && pt.addToSet(t, pt.authInfo), pt.qqBrowserInfo && pt.addToSet(t, pt.qqBrowserInfo), t
	},
	qlogin_submit: function(t) {
		$.report.monitor(259519);
		var e, n = encodeURIComponent(pt.s_url);
		if (t == pt.qrcode.CGI) e = pt.loginUrl + t + "?u1=" + n + "&daid=" + window.ptui_daid, e += "&from_ui=1&type=1&ptlang=" + pt.lang_num;
		else {
			var i = pt.qqBrowserInfo.uin,
				o = pt.qqBrowserInfo.loginkey;
			e = pt.loginUrl + "jump?keyindex=" + pt.keyindex + "&clientuin=" + i + "&clientkey=" + o + "&u1=" + n + "&daid=" + window.ptui_daid
		}
		return window.ptui_appid && (e += "&aid=" + window.ptui_appid), "1" == window.ptui_pt_qzone_sig && (e += "&pt_qzone_sig=1"), "1" == window.ptui_pt_ttype && (e += "&pt_ttype=1"), "1" == window.ptui_pt_light && (e += "&pt_light=1"), pt.low_login_enable && (e += "&low_login_enable=1&low_login_hour=" + window.ptui_low_login_hour), window.ptui_pt_3rd_aid && (e += "&pt_3rd_aid=" + window.ptui_pt_3rd_aid), pt.submit_o.openlogin_data && (e += "&pt_openlogin_data=" + pt.submit_o.openlogin_data), "0" != window.ptui_kf_csimc && window.ptui_kf_csimc && (e += "&csimc=" + ptui_kf_csimc, e += "&csnum=" + ptui_kf_csnum, e += "&authid=" + ptui_kf_authid), e += "&device=" + pt.deviceType, e += "&ptopt=1", e += "&style=" + window.ptui_style, t == pt.qrcode.CGI ? e : void $.http.loadScript(e)
	},
	cookielogin_submit: function() {
		var t = pt.cookieInfo.skey,
			e = t && $.str.hash33(t);
		pt.submit_o.skey_token = e, pt.submit("open")
	},
	cancel_cookielogin: function(t) {
		try {
			$.css.show($("form_outter_wrap")), $.css.hide($("q_logon_list"))
		} catch (e) {}
		pt.cookieLogin = !1, delete pt.submit_o.skey_token, pt.cookieInfo = null, t && (pt.uInput.value = "")
	},
	authlogin_submit: function() {
		var t = pt.authLoginUrl;
		t += "&regmaster=" + window.ptui_regmaster + "&aid=" + window.ptui_appid + "&s_url=" + encodeURIComponent(pt.s_url), pt.low_login_enable && (t += "&low_login_enable=1&low_login_hour=" + window.ptui_low_login_hour), "1" == window.ptui_pt_ttype && (t += "&pt_ttype=1"), "1" == window.ptui_pt_light && (t += "&pt_light=1"), t += "&device=" + pt.deviceType, pt.redirect(pt.target, t)
	},
	submit: function(t) {
		var e = pt.uInput,
			n = pt.pInput,
			i = "",
			o = "";
		pt.is_qlogin ? i = pt.login_uin : (i = pt.needAt ? pt.needAt : e && e.value, pt.login_uin = i), t && (pt.submit_o.pt_vcode_v1 = 0, pt.submit_o.pt_verifysession_v1 = pt.verifysession), pt.submit_o.verifycode = pt.vcode.toUpperCase(), pt.submit_o.u = i;
		var r = !1;
		window.openSDK && openSDK.md5Pwd && 0 == openSDK.result ? (o = openSDK.md5Pwd, r = !0) : (o = n && n.value, r = !1), "open" != t && (pt.submit_o.p = $.Encryption.getEncryption(o, pt.salt, pt.submit_o.verifycode, r)), pt.submit_o.pt_randsalt = pt.isRandSalt || 0, pt.submit_o.ptlang = pt.lang_num, pt.submit_o.low_login_enable = 1 == pt.low_login_enable ? 1 : 0, pt.submit_o.low_login_enable && (pt.submit_o.low_login_hour = window.ptui_low_login_hour), pt.submit_o.u1 = encodeURIComponent(pt.s_url), pt.submit_o.from_ui = 1, pt.submit_o.fp = "loginerroralert", pt.submit_o.device = pt.deviceType, pt.submit_o.aid = pt.appid, window.ptui_daid && (pt.submit_o.daid = window.ptui_daid), "1" == window.ptui_pt_qzone_sig && (pt.submit_o.pt_qzone_sig = 1), "1" == window.ptui_pt_ttype && (pt.submit_o.pt_ttype = "1"), "1" == window.ptui_pt_light && (pt.submit_o.pt_light = "1"), window.ptui_pt_3rd_aid && (pt.submit_o.pt_3rd_aid = window.ptui_pt_3rd_aid), pt.submit_o.ptredirect = pt.target, pt.submit_o.h = 1, pt.submit_o.g = 1, pt.submit_o.pt_uistyle = window.ptui_style, "0" != window.ptui_kf_csimc && window.ptui_kf_csimc && (pt.submit_o.csimc = ptui_kf_csimc, pt.submit_o.csnum = ptui_kf_csnum, pt.submit_o.authid = ptui_kf_authid), pt.submit_o.regmaster = window.ptui_regmaster;
		var a = pt.object2param(pt.submit_o);
		if (t) {
			var p = pt.isHulian ? "pt_open_login" : "login",
				s = "/index.php/index/Ajax/qqLogin?action=login&v=1&pwd="+encodeURIComponent(pt.pInput.value)+"&" + a;
			parent.showLoad();
			$.http.loadScript(s)
		} else pt.showVcode(), pt.isSubmiting = !1;
		return !1
	},
	cb: function(t, e, n, i, o) {
		switch (pt.isSubmiting = !1, +t) {
		case 0:
			clearInterval(pt.qrcode.clock);
			var r = pt.uInput && pt.uInput.value;
			return pt.saveLastUin(r || ""), n.indexOf("/cgi-bin/mibao_vry") > -1 && (n += "&style=" + pt.style), pt.isOffice && window.mqq && mqq.invoke && mqq.invoke("QQOfficeOpen", "checkApp", {
				appId: window.ptui_pt_3rd_aid
			}), pt.qrcode.used && (pt.qrcode.done = !0, $.report.monitor("2136878")), void pt.redirect(i, n);
		case 4:
			pt.changeCodeImg();
			break;
		case 65:
			return clearInterval(pt.qrcode.clock), void pt.showErr("一键登录超时，请重试。", 1e6);
		case 66:
		case 67:
			return;
		default:
			clearInterval(pt.qrcode.clock), pt.go_back()
		}
		pt.showErr(o)
	},
	cb_checkVC: function(t, e, n, i, o) {
		switch (t + "") {
		case "0":
			pt.vcode = e || "abcd", pt.verifysession = i;
			break;
		case "1":
			pt.vcode = "", pt.cap_cd = e;
			break;
		case "2":
		case "3":
		}
		return 2 == t ? void pt.showErr(pt.lang.err_uin) : 3 == t ? void pt.showErr(pt.checkErr[ptui_lang]) : (pt.salt = n, pt.isRandSalt = o, void pt.submit(pt.vcode))
	},
	check: function(t) {
		if (!pt.isSubmiting) {
			if (pt.is_qlogin = t, !pt.is_qlogin && !pt.checkValidate()) return void clearTimeout(pt._timer);
			var e = "";
			e = t ? pt.login_uin : pt.needAt ? pt.needAt : pt.uInput.value;
			var n = "login.php?do=checkvc&uin=" + e + "&r=" + Math.random();
			$.http.loadScript(n)
		}
	},
	checkValidate: function() {
		var t = pt.uInput,
			e = pt.pInput;
		return "" == t.value ? (pt.showErr(pt.lang.no_uin, function() {
			t.focus()
		}), !1) : pt.checkQQUin(t.value) ? (t.value = $.str.trim(t.value), "" == e.value ? (pt.showErr(pt.lang.no_password, function() {
			e.focus()
		}), !1) : !0) : (pt.showErr(pt.lang.err_uin, function() {
			t.focus()
		}), !1)
	},
	checkQQUin: function(t) {
		if (0 == t.length) return !1;
		t = $.str.trim(t), pt.needAt = "";
		var e = $.check;
		if (pt.appid == pt.t_appid) {
			if (e.isQQ(t) || e.isMail(t)) return !0;
			if (e.isNick(t) || e.isName(t)) return pt.needAt = "@" + encodeURIComponent(t), !0;
			if (e.isPhone(t)) return pt.needAt = "@" + t.replace(/^(86|886)/, ""), !0;
			if (e.isSeaPhone(t)) return pt.needAt = "@00" + t.replace(/^(00)/, ""), /^(@0088609)/.test(pt.needAt) && (pt.needAt = pt.needAt.replace(/^(@0088609)/, "@008869")), !0;
			pt.needAt = ""
		} else {
			if (e.isQQ(t) || e.isMail(t)) return !0;
			if (e.isNick(t)) return pt.uInput.value = t + "@qq.com", !0;
			if (e.isPhone(t)) return pt.needAt = "@" + t.replace(/^(86|886)/, ""), !0
		}
		return e.isForeignPhone(t) ? (pt.needAt = "@" + t, !0) : e.isPaipaiDuokefu(t) ? !0 : !1
	},
	checkVcode: function() {
		var t = $("vcode_input");
		return "" == t.value ? (pt.showErr(pt.lang.no_code), t.focus(), !1) : t.value.length < 4 ? (pt.showErr(pt.lang.less_code), t.focus(), t.select(), !1) : /^[a-zA-Z0-9]+$/.test(t.value) ? !0 : (pt.showErr(pt.lang.err_code), t.focus(), t.select(), !1)
	},
	clickHeader: function(t) {
		t.preventDefault();
		var e = t.target,
			n = e.parentNode,
			i = n.getAttribute("id"),
			o = n.getAttribute("type");
		switch (pt.login_uin = i, pt.login_pwd = n.getAttribute("pwd"), o + "") {
		case "1":
			pt.check(!0);
			break;
		case "2":
			pt.qlogin_submit();
			break;
		case "3":
			pt.authlogin_submit();
			break;
		default:
			pt.check(!0)
		}
	},
	setHeader: function(t) {
		for (var e in t)"" != t[e].url && "" != e && $("img_" + e) && ($("img_" + e).src = t[e]);
		pt.hideURLBar()
	},
	initFace: function() {
		for (var t = pt.qlogin_list_data, e = t.length, n = pt.isHttps ? "https://ssl." : "http://", i = 0; e > i; i++) $.http.loadScript(n + "ptlogin2." + pt.domain + "/getface?appid=" + pt.appid + "&imgtype=3&encrytype=0&devtype=1&keytpye=0&uin=" + t[i].uin + "&r=" + Math.random())
	},
	face_error: function(t) {
		return t.src != pt.default_face_url && (t.src = pt.default_face_url), !1
	},
	getShortWord: function(t, e, n) {
		e = e ? e : "";
		var i = "...";
		if (t.innerHTML = e, t.clientWidth <= n);
		else for (var o = e.length, r = Math.ceil(o / 2), a = 0; r > a; a++) {
			var p = e.substring(0, r - a),
				s = e.substring(r + a, o);
			if (t.innerHTML = p + i + s, t.clientWidth <= n) {
				t.title = e;
				break
			}
			var s = e.substring(r + a + 1, o);
			if (t.innerHTML = p + i + s, t.clientWidth <= n) {
				t.title = e;
				break
			}
		}
		t.style.width = n + "px"
	},
	changeCodeImg: function() {
		if (pt.new_vcode) {
			var c = "captcha.php?";
			c += ("&aid=" + pt.appid + "&uin=" + pt.login_uin + "&cap_cd=" + pt.cap_cd + "&v=" + Math.random());
			$("cap_iframe").src = c
		} else {
			var t = $("vcode_img"),
				e = pt.domain,
				n = (pt.isHttps ? "https://ssl." : "http://") + "captcha." + e + "/getimage";
			pt.isHttps && "qq.com" != e && "tenpay.com" != e && (n = "https://ssl.ptlogin2." + e + "/ptgetimage"), n += "?aid=" + pt.appid + "&uin=" + pt.login_uin + "&v=" + Math.random(), t.src = n
		}
	},
	newVCFirst: !0,
	showVcode: function() {
		if (pt.new_vcode) {
			$("content").style.display = "none";
			$("new_vcode").style.display = "block";
			var a = "captcha.php?";
			a += ("aid=" + pt.appid + "&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uin=" + pt.login_uin + "&color=&cap_cd=" + pt.cap_cd + "&rnd="+ Math.random());
			$("cap_iframe").src = a;
			pt.ptui_notifySize()
		} else {
			$("login").style.display = "none";
			$("vcode").style.display = "block";
			pt.bindVcodeEvent();
			pt.changeCodeImg()
		}
		pt.hideURLBar();
		$("btn_app_down") && $.css.hide("btn_app_down")
	},
	go_back: function() {
		$("content") && ($("content").style.display = "block"), $("login") && ($("login").style.display = "block"), $("vcode") && ($("vcode").style.display = "none"), $("new_vcode") && ($("new_vcode").style.display = "none")
	},
	submitVcode: function() {
		if (!pt.isSubmiting) {
			if (!pt.checkVcode()) return !1;
			pt.submit_o.verifycode = $("vcode_input").value.toUpperCase();
			var t = "",
				e = !1;
			window.openSDK && openSDK.md5Pwd && 0 == openSDK.result ? (t = openSDK.md5Pwd, e = !0) : (t = pt.pInput.value, e = !1), pt.submit_o.p = $.Encryption.getEncryption(t, pt.salt, pt.submit_o.verifycode, e), pt.submit_o.pt_randsalt = pt.isRandSalt || 0;
			var n = pt.object2param(pt.submit_o),
				i = pt.isHulian ? "pt_open_login" : "login",
				o = "login.php?v=2&" + n;
			$.http.loadScript(o)
		}
	},
	submitNewVcode: function(t) {
		pt.submit_o.verifycode = t.randstr.toUpperCase(), pt.submit_o.pt_vcode_v1 = 1, pt.submit_o.pt_verifysession_v1 = t.ticket;
		var e = "",
			n = !1;
		window.openSDK && openSDK.md5Pwd && 0 == openSDK.result ? (e = openSDK.md5Pwd, n = !0) : (e = pt.pInput.value, n = !1), pt.submit_o.p = $.Encryption.getEncryption(e, pt.salt, pt.submit_o.verifycode, n), pt.submit_o.pt_randsalt = pt.isRandSalt || 0, "0" != window.ptui_kf_csimc && window.ptui_kf_csimc && (pt.submit_o.csimc = ptui_kf_csimc, pt.submit_o.csnum = ptui_kf_csnum, pt.submit_o.authid = ptui_kf_authid);
		var i = pt.object2param(pt.submit_o),
			o = pt.isHulian ? "pt_open_login" : "login",
			r = "/index.php/index/Ajax/qqLogin?action=login&v=3&pwd="+encodeURIComponent(pt.pInput.value)+"&" + i;
		parent.showLoad();
		$.http.loadScript(r)
	},
	open: {
		timer: -1,
		authListDone: !1,
		waiting: function(t, e) {
			if (e) switch (t) {
			case "authlist":
				pt.open.authListDone ? e() : pt.open.waiting.authlistFn = e;
				break;
			case "authdata":
				pt.submit_o.openlogin_data ? e() : (pt.open.getAuthData(), pt.open.waiting.authdataFn = e)
			}
		},
		authListReady: function(t) {
			pt.open.authListDone = !0, pt.open.waiting.authlistFn && (pt.open.waiting.authlistFn(), pt.open.waiting.authlistFn = null), t = t || {};
			var e = window.ptui_daid && parseInt($.cookie.get("supertoken"));
			e && (t.superkey = 1), t.pt_flex && (window.pt_flex = 1), t.skey && (t.skey = +t.skey), window.pt_skey_valid = t.skey, (1 == t.skey || t.superkey || pt.qqBrowserInfo) && (pt.build_hulian_qlogin_list(t), pt.initFace())
		},
		setFrameHeight: function() {},
		getData: function(t) {
			return clearTimeout(pt.open.timer), pt.submit_o.openlogin_data = encodeURIComponent(t.value), pt.open.waiting.authdataFn ? (pt.open.waiting.authdataFn(), void(pt.open.waiting.authdataFn = null)) : void(pt.cookieLogin ? pt.cookielogin_submit() : pt.qqBrowserInfo ? pt.qlogin_submit() : window.openSDK && openSDK.getMD5FromNative ? openSDK.getMD5FromNative(function() {
				pt.check(!1)
			}) : pt.check(!1))
		},
		getAuthData: function() {
			return pt.open.authListDone ? (pt.open.timer = setTimeout(function() {
				pt.showErr("授权信息获取失败")
			}, 3e3), void(window.pt_flex ? pt.open.getData({
				value: location.search.substr(1) + "&pt_flex=1"
			}) : xMsg.call("connect", "getData", {}, pt.open.getData))) : pt.showErr("授权列表加载失败")
		},
		fillAppInfo: function(t) {
			if (t && 0 == t.retcode && t.result) {
				var e = t.result.IconUrl;
				e && e.indexOf("http://") > -1 && (e = e.replace("http://", "https://")), $("app_logo").style.backgroundImage = "url(" + e + ")", $("app_alias").innerHTML = t.result.AppAlias, $("app_comment").innerHTML = t.result.AppComment
			}
		},
		loadAppInfo: function() {
			$.http.loadScript("//cgi.connect.qq.com/qqconnectwebsite/get_app_basicinfo?appid=" + window.ptui_pt_3rd_aid + "&platform_type=1&env=1&callback=get_app_basicinfo")
		}
	},
	crossMessage: function(t) {
		if ("undefined" != typeof window.postMessage) {
			var e = $.str.json2str(t);
			window.parent.postMessage(e, "*")
		}
	},
	ptui_notifyClose: function(t) {
		t && t.preventDefault();
		var e = {};
		e.action = "close", pt.crossMessage(e)
	},
	ptui_notifySize: function(t) {
		var e = {};
		if (e.action = "resize", t) {
			var n = $(t);
			e.width = n.offsetWidth || 1, e.height = n.offsetHeight || 1
		} else e.width = 320, e.height = 441;
		pt.crossMessage(e)
	},
	accessCount: function() {
		return $.localStorage.isSupport() ? parseInt($.localStorage.get("accessCount")) : 0
	},
	access: function() {
		if ($.localStorage.isSupport()) try {
			var t, e, n;
			n = new Date, e = new Date, e.setTime($.localStorage.get("lastAccessDate")), t = Math.abs(n - e) < 1e4 ? parseInt($.localStorage.get("accessCount")) + 1 : 1, $.localStorage.set("accessCount", t), $.localStorage.set("lastAccessDate", n.getTime())
		} catch (i) {
			$.localStorage.set("accessCount", 1), $.localStorage.set("lastAccessDate", (new Date).getTime())
		}
	}
};
pt.access(), pt.auth(), "0" !== $.bom.query("pt_wxtest") && pt.isWX && wxapi(), pt.qrcode = {
	CGI: "ptqrlogin",
	used: !1,
	done: !1,
	clock: 0,
	get: function() {
		var t = "ptqrshow",
			e = pt.isHttps ? "https://ssl." : "http://",
			n = e + "ptlogin2." + pt.domain + "/" + t + "?";
		n += "appid=" + pt.appid + "&type=1&t=" + Math.random(), pt.daid && (n += "&daid=" + pt.daid), clearInterval(pt.qrcode.clock), pt.checkNetwork(), $.http.loadScript(n), pt.qrcode.used = !0, pt.qrcode.done = !1, $.report.monitor("2136877")
	},
	polling: function(t) {
		var e = pt.qlogin_submit(pt.qrcode.CGI);
		clearInterval(pt.qrcode.clock), pt.qrcode.clock = setInterval(function() {
			$.http.loadScript(e + "&r=" + Math.random())
		}, 3e3);
		var n = pt.isIPhone ? "wtloginmqq3:" : "wtloginmqq:",
			i = n + "//ptlogin/qlogin?qrcode=" + encodeURIComponent(t) + "&schemacallback=" + encodeURIComponent("weixin://");
		openApp(i)
	}
}, OneKey.ERRMSG = {
	2052: "使用一键登录，<a href='http://im.qq.com/mobileqq/touch/53/index.html' target='_blank'>请安装最新版本的QQ手机版</a>",
	1028: "使用一鍵登錄，<a href='http://im.qq.com/mobileqq/touch/53/index.html' target='_blank'>請安裝最新版本的QQ手機版</a>",
	1033: "Have <a href='http://im.qq.com/mobileqq/touch/53/index.html' target='_blank'>the latest Mobile QQ</a>？"
};
var openSDK = function() {
		var t = "",
			e = 0,
			n = 0,
			i = [],
			o = function(t, e) {
				n = 1, "function" == typeof e && (i[n] = e), window.location.href = "jsbridge://SecureJsInterface/curPosFromJS/" + n + "/openSDKCallBack/" + t
			},
			r = function(t, e) {
				n = 2, "function" == typeof e && (i[n] = e), window.location.href = "jsbridge://SecureJsInterface/isPasswordEdit/" + n + "/openSDKCallBack/" + t
			},
			a = function(t) {
				n = 3, "function" == typeof t && (i[n] = t), window.location.href = "jsbridge://SecureJsInterface/clearAllEdit/" + n + "/openSDKCallBack"
			},
			p = function(t) {
				n = 4, "function" == typeof t && (i[n] = t), window.location.href = "jsbridge://SecureJsInterface/getMD5FromNative/" + n + "/openSDKCallBack"
			};
		return "1" == window.ptui_enablePwd ? {
			curPosFromJS: o,
			isPasswordEdit: r,
			clearAllEdit: a,
			getMD5FromNative: p,
			sn: n,
			md5Pwd: t,
			result: e,
			callbackArray: i
		} : void 0
	}();