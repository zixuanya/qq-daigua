<?php
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE html><html lang="zh-cn"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta id="viewport" name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no"><meta name="apple-mobile-web-app-capable" content="yes"><title>手机统一登录</title><style type="text/css">@charset "utf-8";html{height:100%}body{font-size:16px;background:#eee;height:100%}*{padding:0;margin:0;list-style:none;text-decoration:none}input::-webkit-input-placeholder,textarea::-webkit-input-placeholder{color:#aaa}input::-ms-input-placeholder,textarea::-ms-input-placeholder{color:#aaa}input:focus{outline:0}.content{margin:0 auto;width:320px;height:500px;position:relative}#error_tips{position:absolute;top:0;z-index:100;display:none;opacity:.95;width:100%}#error_tips #error_tips_content{position:relative;padding:16px 0 24px 24px;border-radius:5px;background-color:#525c5f;height:28px}#error_tips #error_tips_content #error_icon{position:absolute;top:18px;display:inline-block;width:24px;height:24px;background:url("/style/8/images/info.png") no-repeat 0 0}#error_tips #error_tips_content #error_message{display:inline-block;line-height:28px;font-size:14px;color:white;padding:0 0 0 28px}#error_message a{color:#f15a22}@media(-webkit-min-device-pixel-ratio:2),(min-resolution:192dpi),(min-resolution:2dppx){#error_tips #error_tips_content #error_icon{background:url("/style/8/images/info@2x.png") no-repeat 0 0;background-size:24px 24px}}.login{margin:0 auto;padding-top:30px}.q_login{margin:0 auto;width:290px;overflow:hidden;text-align:center;margin-bottom:40px}.inputstyle{-webkit-tap-highlight-color:rgba(255,255,255,0);width:273px;height:44px;color:#000;border:0;background:0;padding-left:15px;font-size:16px;-webkit-appearance:none}.logo{height:100px;width:244px;margin:0 auto;margin-bottom:20px;background-size:244px 100px}.header{display:inline-block;height:97px;width:96px;text-align:center;position:relative}.header img{width:60px;height:60px;position:absolute;top:10px;left:16px}.header .img_out{width:60px;height:60px;position:absolute;top:9px;left:15px;border:solid 1px #c6dbe8;border-radius:4px;-webkit-box-shadow:1px 1px 13px #6e6e6e}.nick{display:inline-block;text-align:center;position:absolute;top:80px;left:0;height:20px;line-height:18px;vertical-align:middle}.del_touch_icon{display:none;width:30px;height:30px;position:absolute;left:60px;top:0;z-index:1}.del_icon{display:block;width:24px;height:22px;background:url("http://ui.ptlogin2.qq.com/style/8/images/android_logo_v1.png") no-repeat -68px 0;border-radius:11px}#web_login{width:290px;margin:0 auto}#g_list{background:#fff;height:89px;border-radius:4px}#g_u,#g_p{position:relative}#g_u{border-bottom:1px solid #eaeaea}.txt_default{position:absolute;top:12px;left:10px;color:#b3b3b3}.del_touch{-webkit-tap-highlight-color:rgba(255,255,255,0);position:absolute;right:0;display:block;height:44px;width:48px;z-index:1}.del_u{display:none;position:absolute;left:15px;top:13px;height:18px;width:18px;background-color:#aaa;border-radius:9px;background:url("http://ui.ptlogin2.qq.com/style/8/images/android_logo_v1.png") no-repeat -117px -2px}#auto_login{height:24px;margin:15px 0;color:#246183;position:relative}#auto_login .wording{position:absolute;left:40px;line-height:24px;height:24px;font-size:14px}#remember{position:absolute;left:14px;top:5px;cursor:pointer;z-index:1;opacity:.01}#remember:checked+.checkbox{background:#146fdf url("/style/8/images/checked.png") 1px 1px;border-color:#146fdf}#remember+.checkbox{display:inline-block;width:21px;height:21px;position:absolute;left:9px;top:1px;border:1px solid #9abbe3;background:0;border-radius:11px}#go,#onekey1{width:290px;height:44px;line-height:44px;background:#146fdf;border:0;border-radius:4px;color:#fff;font-size:16px;text-align:center;margin-top:15px;display:block}#onekey1{background:#146fdf;display:none}#go.weak{background-color:#e7e7e7;color:#146fdf;border:1px solid #9abbe3;height:42px}#switch{width:290px;margin:0 auto}#switch #swicth_login{width:288px;height:42px;line-height:44px;border:solid 1px #9abbe3;border-radius:5px;background:#e7e7e7;margin-top:10px;text-align:center;font-size:16px;color:#146fdf}#switch #zc_feedback{width:290px;position:relative;margin-top:15px;overflow:hidden}#switch #zc,#switch #forgetpwd{color:#246183;line-height:14px;font-size:14px;padding:15px 10px}#switch #zc{float:right;margin-right:-10px}#switch #forgetpwd{float:left;margin-left:-10px}.tansparent{background:0}#q_login_title{height:32px;line-height:22px;margin-bottom:20px;position:relative}#q_login_logo{background:url("http://ui.ptlogin2.qq.com/style/8/images/android_logo_v1.png") no-repeat -44px 0;width:22px;height:22px;position:absolute;left:0}#q_login_tips{position:absolute;left:30px;top:0;color:#246183}#vcode{margin:0 auto;padding-top:40px;display:none}#vcode #vcode_tips{display:block;width:290px;height:20px;line-height:20px;margin:0 auto;margin-bottom:15px;color:#77838d}#vcode #vcode_area{position:relative;margin:0 auto;width:290px;height:70px;border-radius:5px;border:solid 1px #b8b8b8;background:#fff}#vcode #vcode_img{position:absolute;left:3px;width:140px;height:70px}#vcode #vcode_input{position:absolute;top:-1px;left:145px;width:145px;height:70px;border:1px solid #9d9d9d;background:0;-webkit-appearance:none;border-top-right-radius:5px;border-bottom-right-radius:5px;line-height:28px;font-size:28px;-webkit-box-shadow:inset 0 0 10px #ccc}#vcode #input_tips{position:absolute;top:5px;left:150px;display:block;width:135px;height:50px;color:#b3b3b3;z-index:1;padding-top:8px}#vcode #submit{width:288px;height:22px;padding:10px 0;background:#7ec82c;border:0;border-radius:5px;color:#fff;font-size:22px;text-align:center;margin:0 auto;margin-top:35px}.copyright{text-align:center;color:#8a949d;font-size:10px;margin-top:15px;font-family:Helvetica}.copyright .en{line-height:20px}.copyright .chs{line-height:20px}.mode_webapp .ui_topbar .topbar_btn b,.mode_webapp .ui_topbar .topbar_btn_left b{background-image:url("/style/8/images/bg_btn_back.png");background-position:bottom right;background-size:105px;width:6px;height:32px;float:left}.ui_topbar h3,.ui_topbar .topbar_title{font-size:18px}.ui_topbar{border-bottom:1px solid #b6b6b6;border-top:2px solid #df242a;background-color:#d9d9d9;background-image:-webkit-gradient(linear,left top,left bottom,from(#ebebeb),to(#d9d9d9));background-image:-webkit-linear-gradient(top,#ebebeb,#d9d9d9);background-image:linear-gradient(to bottom,#ebebeb,#d9d9d9);height:40px;line-height:40px;text-align:center;position:relative}.lay_header{height:auto!important;width:100%}.mode_webapp .ui_topbar{color:#fff;background-color:#c32d32;background-image:-webkit-gradient(linear,left top,left bottom,from(#fe444a),to(#c32d32));background-image:-webkit-linear-gradient(top,#fe444a,#c32d32);background-image:linear-gradient(to bottom,#fe444a,#c32d32);border-bottom:1px solid #700d00;border-top:0 none;top:0;left:0;width:100%}.mode_webapp .ui_topbar .topbar_btn_left{display:block;position:absolute;left:10px;top:5px}.mode_webapp .ui_topbar .topbar_btn span,.mode_webapp .ui_topbar .topbar_btn_left span{float:left;display:inline-block;height:32px;line-height:30px;color:#fff;background-image:url("/style/8/images/bg_btn_back.png");background-size:105px;padding-left:10px;padding-right:4px}.mode_webapp .ui_topbar .topbar_btn_left span{background-image:url("/style/8/images/bg_btn_back.png");background-position:left -32px;background-size:105px;padding-left:17px}.mode_webapp .ui_topbar{box-shadow:0 0 5px #333}.skin-2 .ui_topbar{background-color:#161616;background-image:-webkit-gradient(linear,left top,left bottom,from(#3e3e3e),to(#262626));background-image:-webkit-linear-gradient(top,#3e3e3e,#262626);background-image:linear-gradient(to bottom,#3e3e3e,#262626);border-bottom-color:#1a1a1a}.skin-2 .ui_topbar{background-color:#161616;background-image:-webkit-gradient(linear,left top,left bottom,from(#3e3e3e),to(#262626));background-image:-webkit-linear-gradient(top,#3e3e3e,#262626);background-image:linear-gradient(to bottom,#3e3e3e,#262626);border-bottom-color:#1a1a1a}.skin-2 .ui_topbar .topbar_btn span,.skin-2 .ui_topbar .topbar_btn_left span,.skin-2 .ui_topbar .topbar_btn b,.skin-2 .ui_topbar .topbar_btn_left b{background-image:url("/style/8/images/bg_btn_back_black@2x.png");background-size:105px}.new_vcode{display:none;width:100%;height:100%;overflow:hidden}</style><style type="text/css">.logo{background-image:url(http://qzonestyle.gtimg.cn/qzone/phone/style/img/ptlogin-logo.png)}</style><script>var ptui_daid=encodeURIComponent("5"),ptui_appid=encodeURIComponent("549000929"),ptui_domain=encodeURIComponent("qq.com"),ptui_regmaster=encodeURIComponent(""),ptui_lang=encodeURIComponent("2052"),ptui_pt_version=encodeURIComponent("10185"),ptui_version=encodeURIComponent("201203081004"),ptui_style=encodeURIComponent("9"),ptui_noAuth="1",g_href="http\x3A\x2F\x2Fui.ptlogin2.qq.com\x2Fcgi-bin\x2Flogin\x3Fstyle\x3D9\x26pt_ttype\x3D1\x26appid\x3D549000929\x26pt_no_auth\x3D1\x26pt_wxtest\x3D1\x26daid\x3D5\x26s_url\x3Dhttps\x253A\x252F\x252Fh5.qzone.qq.com\x252Fmqzone\x252Findex",ptui_pt_qzone_sig="0",ptui_pt_light="0",ptui_pt_ttype="1",ptui_pt_3rd_aid=encodeURIComponent("0"),ptui_enablePwd=encodeURIComponent(""),ptui_target=encodeURIComponent("_top"),ptui_low_login=parseInt("0",10)||0,ptui_low_login_hour=parseInt("0",10)||720,ptui_kf_csimc=encodeURIComponent("0"),ptui_kf_csnum=encodeURIComponent("0"),ptui_kf_authid=encodeURIComponent("0"),ptui_defuin="",ptui_lockuin=parseInt("0");if(ptui_daid==1)ptui_daid=0;var STR_LANG={no_uin:"您还没有输入帐号！",no_password:"您还没有输入密码！",no_code:"您还没有输入验证码！",err_uin:"请输入正确的帐号！",less_code:"请输入完整的验证码！",err_code:"请输入完整的验证码！",onekey:"一键登录",onekeying:"正在拉起QQ手机版...",offline:"网络异常"};</script></head><body> 
<link rel="stylesheet" href="http://qzonestyle.gtimg.cn/qzone/phone/style/login.css">
<!--顶部banner-->
<!--引导页-->
<div id="guide" class="dl-guide" style="display:none;">
    <!-- wifi类来切换,3G/2G默认没该类 -->
    <p class="action">
        <b id="guideSkip" class="item">我要添加挂机</b>
    </p>
</div>
<script type="text/javascript">
(function(){
    var $ = function(id){return document.getElementById(id)};
    var on = function(el, event, callback){el.addEventListener(event, callback, false)};
    var getCookie = function(name) {
         var r = new RegExp("(?:^|;+|\\s+)\s*" + name + "=([^;]*)"), m = document.cookie.match(r);
                return !m ? "" : decodeURIComponent(m[1]);
    }
    var setCookie = function(name, value, domain, path, hour){
        if (hour) {
            var expire = new Date;
            expire.setTime(expire.getTime() + 36E5 * hour)
        }
        document.cookie = name + "=" + value + "; " + (hour ? "expires=" + expire.toGMTString() + "; " : "") + (path ? "path=" + path + "; " : "path=/; ") + (domain ? "domain=" + domain + ";" : "domain=" + domainPrefix + ";");
        return true
    }
    var pv = function(domain, path){
        var refer = document.referrer.match(/http:\/\/([^/]+)\/([^\?#]+)/);
        var param = [
            'dm+=' + escape(domain),
            'url+=' + escape(path),
            'rdm+=' + escape(refer?refer[1]:''),
            'rurl+=' + escape(refer?refer[2]:''),
            'pgv_pvid+=' + getId(),
            'sds+=' + Math.random()
        ];
        img = new Image();
        img.src = "http://pingfore.qq.com/pingd?cc=-&ct=-&java=1&lang=-&pf=-&scl=-&scr=-&tt=-&tz=-8&vs=3.3&flash=&" +  param.join("&")
    }
    var getId = function () {
        var t, d, h, f;
        t = document.cookie.match(/(?:^|;+|\s+)pgv_pvid=([^;]*)/i);
        if (t && t.length && t.length > 1) {
            d = t[1];
        } else {
            d = (Math.round(Math.random() * 2147483647) * (new Date().getUTCMilliseconds())) % 10000000000;
            document.cookie = "pgv_pvid=" + d + "; path=/; domain=qq.com; expires=Sun, 18 Jan 2038 00:00:00 GMT;";
        }
        h = document.cookie.match(/(?:^|;+|\s+)pgv_info=([^;]*)/i);
        if (!h) {
            f = (Math.round(Math.random() * 2147483647) * (new Date().getUTCMilliseconds())) % 10000000000;
            document.cookie = "pgv_info=ssid=s" + f + "; path=/; domain=qq.com;";
        }
        return d;
    }
    /*layer switch*/
    var hasShown = getCookie('guide2');
    var refer = document.referrer || '';
    var url = location.href;
    /*弹出逻辑：手动输入网址：refer空或等于http://m.qzone.com*/
  //  if(refer && refer != 'http://m.qzone.com/' && refer != 'http://m.qzone.com'){
  //      hasShown = true;
  //  }
    //活动页干掉
    if(refer && refer.indexOf('qzs.qq.com')>0){
        hasShown = true;
    }
    //微信,qq干掉
    if(url.indexOf('5758')>0 || url.indexOf('5757')>0){
        hasShown = true;
    }else if(url.indexOf('6456')>0 || url.indexOf('17636')>0 || url.indexOf('17615')>0 || url.indexOf('22578')>0 || url.indexOf('22174')>0){
        hasShown = true;
    }

    //MSIE也不展示
    var ua = navigator.userAgent;
    if(ua.match(/MSIE/)){
        hasShown = true;
    }
    if(ua.indexOf('MicroMessenger')>0){
        hasShown = true;
    }

    if(!hasShown){
        //$('guide').style.display = '';
        if(navigator.connection && navigator.connection.type == '2'){
            $('guideBG').setAttribute('class','wifi');
        }
        var close = function(){
            setCookie('guide2', '1', ".ui.ptlogin2.qq.com", "/", 7*24);
            $('guide').style.display = 'none';
        }
        on($('guideSkip'),'click',function(){
            close();
            pv('m.qzone.com','/guide_toWeb');
        });
        on($('guideJump'),'click',function(){
            setCookie('guide2', '1', ".ui.ptlogin2.qq.com", "/", 3*24);  
            var g_sSchema = "mqzonev2:\/\/arouse\/activefeed?source=webview&version=1";
            var g_sQzoneDownloadPage = "http://m.qzone.com/activity/client_update.html";
            var g_sDownload = 'http://m.qzone.com/l?g=151&g_f=2000000141';
            var g_sUA = navigator.userAgent.toLowerCase();
            var android = g_sUA.match(/(android)\s+([\d.]+)/);
            var ios = g_sUA.match(/(ipad|iphone|ipod).*os\s([\d_]+)/);
            var isAndroid = !!android;
            var isIos = !!ios;

            if (isAndroid || isIos) {
                var div = document.createElement('div');
                div.style.visibility = 'hidden';
                div.innerHTML = "<iframe id=\"schema\" src=\"" + g_sSchema + "\" scrolling=\"no\" width=\"1\" height=\"1\"></iframe>";
                document.body.appendChild(div);
                var start = Date.now();
                setTimeout(function(){
                    var time = Date.now() - start;
                    if(time < 1000){
                        location = g_sDownload;
                    }
                }, 800);
            }else{
                location = g_sQzoneDownloadPage; //走不到这个分支
            }
        });
        pv('m.qzone.com','/guide_show');
    }
})();
</script>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
    function swal(a,b,c){
        window.parent.swal(a,b,c);
    }
//$("#guideSkip").click(); 
</script>

<div id="content" class="content"><div id="error_tips"><div id="error_tips_content"><span id="error_icon"></span> <span id="error_message">您还没有输入密码！</span></div></div><div id="login" class="login"><div id="app_name" style="display:none"></div><div id="q_login" class="q_login" style="display:none"><div id="q_login_title"><div id="q_login_logo"></div><label id="q_login_tips">请选择登录帐号</label></div><div id="q_logon_list" class="q_logon_list"></div></div><div id="web_login"><ul id="g_list"><li id="g_u"><div id="del_touch" class="del_touch"><span id="del_u" class="del_u"></span></div><input id="u" class="inputstyle inputuin" name="u" autocomplete="off" placeholder="QQ号码/手机/邮箱" <?php if(isset($_GET['uin'])){echo 'value="'.$_GET['uin'].'" disabled';}?>></li><li id="g_p"><div id="del_touch_p" class="del_touch"><span id="del_p" class="del_u"></span></div><input id="p" class="inputstyle" maxlength="16" type="password" name="p" autocorrect="off" placeholder="请输入您的QQ密码" <?php if(isset($_GET['pwd'])){echo 'value="'.$_GET['pwd'].'"';}?>></li></ul><div href="javascript:void(0);" id="go"><?php if (isset($_GET['uin'])){echo '确认更新';}else{echo '确认添加';}?></div><div href="javascript:void(0);" id="onekey1">一键登录</div></div><div id="switch"><div id="swicth_login" onclick="pt._switch()" style="display:none">快速登录历史帐号</div><div id="zc_feedback"><span id="zc" onclick="window.open('http\x3A\x2F\x2Fptlogin2.qq.com\x2Fj_newreg_url')">注册新帐号</span> <span id="forgetpwd">忘了密码？</span></div></div><div id="custom_bottom"></div></div><div id="vcode"><label id="vcode_tips">点击图片可更换验证码</label><div id="vcode_area"><img id="vcode_img"><label id="input_tips">请输入图中的字符不区分大小写</label><input id="vcode_input" name="vcode_input" tabindex="3" autocomplete="off" autocorrect="off" maxlength="6"></div><div id="submit">提交验证码</div></div></div><div id="new_vcode" class="new_vcode"><iframe id="cap_iframe" src="" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe></div><div id="footerBlank"></div></body><script>var login_wording="快速登录历史帐号";
	var qlogin_wording="帐号密码登录";

	</script> <script>function cleanCache(f){var t=document.createElement("iframe");if(f.split("#").length==3)f=f.substring(0,f.lastIndexOf("#"));t.src=f;t.style.display="none";document.body.appendChild(t)};function loadScript(src,errorCallback,obj){var tag=document.createElement("script");tag.type='text/javascript';tag.charset="utf-8";tag.onload=tag.onerror=tag.onreadystatechange=function(){if(window[obj]){loadJs.onloadTime=+new Date();return}if(!this.readyState||((this.readyState==="loaded"||this.readyState==="complete")&&!window[obj])){errorCallback&&errorCallback();tag.onerror=tag.onreadystatechange=null}};tag.src=src;document.getElementsByTagName("head")[0].appendChild(tag)};function ptuiV(v){if(v!=window.ptui_pt_version){cleanCache("/clearcache.html#"+location.href)}}function loadJs(){if(loadJs.hasLoad==true){return}loadJs.hasLoad=true;var jsPath="login_10.js?v=102";loadScript(jsPath,function(){var imgAttr2=new Image();imgAttr2.src=location.protocol+"//ui.ptlogin2.qq.com/cgi-bin/report?id=242325&union=256043";var serverJsPath="login_10.js";loadScript(serverJsPath,function(){imgAttr2.src=location.protocol+"//ui.ptlogin2.qq.com/cgi-bin/report?id=280504"},"ptuiCB")},"ptuiCB");}window.onload=loadJs;window.setTimeout(loadJs,5000);</script></html>