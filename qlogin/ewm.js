function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)){
		return unescape(arr[2]);
	}else{
		return null;
	}
}
function ptuiCB(code,a,b,c,d,e){
	var msg='请扫描二维码';
	switch(code){
		case '0':
			msg='添加成功';
		case '60':
			//clearInterval(loginrun);
			msg='登录成功，正在保存数据库';
			var url="/user/addqq2?uin="+a+"&superkey="+b+"&supertoken="+c+"&url="+d+"&r="+Date.parse(new Date());
			loadScript(url);
		case '67':
			msg='扫描成功，请在手机上确认是否授权登录';
			break;
		case '66':
			msg='使用QQ手机版扫描二维码';
			break;
		case '65':
			document.getElementById('loginpic').src='/qlogin/captcha.php?do=ptqrshow&appid=549000929&e=2&l=M&s=3&d=72&v=4&daid=147&t=0.' + Date.parse(new Date());
			msg='二维码已过期';
			break;
	}
	document.getElementById('loginmsg').innerHTML = msg;
}
function loadScript(c) {
	c = c || "/qlogin/captcha.php?do=ptqrlogin&u1=http%3A%2F%2Fqzs.qq.com%2Fqzone%2Fv5%2Floginsucc.html%3Fpara%3Dizone&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-2-1442645189033&js_ver=10034&js_type=1&login_sig=&pt_uistyle=32&aid=549000929&daid=147&pt_qzone_sig=1&r=" + Date.parse(new Date());
	var a = document.createElement("script");
	a.onload = a.onreadystatechange = function() {
		if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
			
			a.onload = a.onreadystatechange = null;
			if (a.parentNode) {
				a.parentNode.removeChild(a)
			}
		}
	};
	a.src = c;
	document.getElementsByTagName("head")[0].appendChild(a)
}
function loginload(){
	var load=document.getElementById('loginload').innerHTML;
	var len=load.length;
	if(len>2){
		load='.';
	}else{
		load+='.';
	}
	document.getElementById('loginload').innerHTML=load;
}
window.setInterval(loginload,1000);
var loginrun = window.setInterval(loadScript,3000);