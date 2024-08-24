<?php
error_reporting(E_ALL & ~E_NOTICE);
header("Content-Type: text/html;charset=utf-8");
$prams='';
$uin=$_GET['uin'];
foreach($_GET as $k=>$get){
	if($k=='do')continue;
	$prams.="$k=$get&";
}
$post="";
if($_GET['do']=='ptqrshow'){
	$url="http://ptlogin2.qq.com/ptqrshow?".$prams;
	$get=get_curl($url);
	preg_match('/qrsig=([0-9a-zA-Z\_\-\*]+)\;/i',$get,$a);
	$qrsig=$a[1];
	$arr=explode('

',$get);
	$get=$arr[1];
	setcookie('qrsig',$qrsig,time()+60*30,'/');
	exit($get);
}elseif($_GET['do']=='ptqrlogin'){
	$post="qrsig=".$_COOKIE['qrsig'];
}elseif($_GET['do']=='verify'){
	$post='';
	foreach($_POST as $k=>$get){
		if($k=='do')continue;
		$post.="$k=$get&";
	}
	$url="http://captcha.qq.com/cap_union_new_verify";
	$get=get_curl($url,$post);
	exit($get);
}elseif($_GET['do']=='getsig'){
	$post='';
	foreach($_POST as $k=>$get){
		if($k=='do')continue;
		$post.="$k=$get&";
	}
	$url="http://captcha.qq.com/cap_union_new_getsig";
	$get=get_curl($url,$post);
	exit($get);
}elseif($_GET['do']=='getpic'){
	header('content-type:image/jpeg');
	$url="http://captcha.qq.com/cap_union_new_getcapbysig?".$prams;
}else{
	$url="http://captcha.qq.com/cap_union_new_show?".$prams;
}
$get=get_curl($url);

//$get=str_replace('wireless_union_char_cap.css','http://captcha.qq.com/wireless_union_char_cap.css',$get);
//$get=str_replace('cap_common.js','http://captcha.qq.com/cap_common.js',$get);
$get=str_replace('/wireless_union_char_clear_input.png','http://captcha.qq.com/wireless_union_char_clear_input.png',$get);
$get=str_replace('#0000ff">0','#0000ff">'.$uin,$get);
$get=str_replace('/cap_union_new_verify','captcha.php?do=verify',$get);
$get=str_replace('/cap_union_new_getsig','captcha.php?do=getsig&',$get);
$get=str_replace('/cap_union_new_getcapbysig','captcha.php?do=getpic&',$get);
$get=preg_replace('!<script src="//tajs.qq.com(.*?)"></script>!i','',$get);

echo $get;



function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_TIMEOUT,60);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$klsf[] = "Accept:*";
	$klsf[] = "Accept-Encoding:gzip,deflate,sdch";
	$klsf[] = "Accept-Language:zh-CN,zh;q=0.8";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $klsf);
	if($post){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if($header){
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
	}
	if($cookie){
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if($ua){
		curl_setopt($ch, CURLOPT_USERAGENT,$ua);
	}else{
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
	}
	if($nobaody){
		curl_setopt($ch, CURLOPT_NOBODY,1);//主要头部
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//跟随重定向
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;

}

function getcookie($ret,$cookie=array(),$type=0){
	if($type){
		$ret=get_curl($ret,0,0,0,1);
	}
	$ret=str_replace(array('p_uin=;','p_skey=;','pt4_token=;'),array('','',''),$ret);
	if(preg_match_all('/Set\-Cookie\:(\s[a-zA-Z0-9\_\-]+)\=([a-zA-Z0-9\=\_\-\@\:\*]*)\;/iu',$ret,$arr)){
		foreach($arr[1] as $k=>$row){
			$cookie[trim($row)]=$arr[2][$k];
		}
	}
	return $cookie;
}

function array2str($arr){
	$str='';
	foreach ($arr as $k=>$row){
		$str.=' '.$k."=".$row.";";
	}
	return $str;
}