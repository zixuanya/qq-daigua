// JavaScript Document
function urlredirect() {
	var sUserAgent = navigator.userAgent.toLowerCase();	
	if ((sUserAgent.match(/(ipod|iphone os|midp|ucweb|android|windows ce|windows mobile)/i))) {
		// 只适用盘古建站，PC跳转移动端
		var thisUrl = window.location.href;
		window.location.href = thisUrl.substr(0,thisUrl.lastIndexOf('/')+1)+'wap/';
		
	}
}
urlredirect();