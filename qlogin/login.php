<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/5/22
// +----------------------------------------------------------------------
error_reporting(0);
$autoaction = isset($_GET['do'])?$_GET['do']:null;

if($autoaction == 'checkvc'){
	$uin=$_GET['uin'];
	$url='http://check.ptlogin2.qq.com/check?pt_tea=2&uin='.$uin.'&appid=549000929&ptlang=2052&regmaster=&pt_uistyle=9&r=0.071823'.time();
	exit(get_curl($url));
}elseif($autoaction == 'login'){
	$uin=$_POST['uin'];
	$p=$_POST['p'];
	$code=$_POST['code'];
	$session=$_POST['session'];
	$v1=isset($_POST['v1'])?$_POST['v1']:0;
	$url = "http://ptlogin2.qq.com/login?pt_vcode_v1={$v1}&pt_verifysession_v1={$session}&verifycode={$code}&u={$uin}&p={$p}&pt_randsalt=0&ptlang=2052&low_login_enable=0&u1=https%3A%2F%2Fh5.qzone.qq.com%2Fmqzone%2Findex&from_ui=1&fp=loginerroralert&device=2&aid=549000929&daid=5&pt_ttype=1&pt_3rd_aid=0&ptredirect=1&h=1&g=1&pt_uistyle=9&";
	
	$ret = get_curl($url,0,0,0,0);
	$json = array();
	if(preg_match("/ptuiCB\('(.*?)'\);/", $ret, $arr)) {
		$r = explode("','", $arr[1]);
		if ($r[0] == 0) {
			try{
				$url = $r[2];
				$ret = get_curl($url, 0, 0, 0, 1);
				preg_match('/skey=(.{10});/', $ret, $skey);
				$skey = $skey[1];
				preg_match('/p_skey=(.{44});/', $ret, $p_skey);
				$p_skey = $p_skey[1];
			}catch(Exception $e){
				$json['code']=-2;
				$json['message']='获取COOKIE值失败!';
				exit(json_encode($json,true));
			}
			$json['code']=0;
			$json['message']='登录成功!';
			$json['skey']=$skey;
			$json['p_skey']=$p_skey;
			exit(json_encode($json,true));
		}else{
			$json['code']=$r[0];
			$json['message']=$r[4];
		}
	}else{
		$json['code']=-1;
		$json['message']='解析登录结果失败!';
	}
	exit(json_encode($json,true));
}else{
	$url = base64_decode($_POST['url']);
	$ret = get_curl($url,0,0,0,0);
	if(preg_match("/ptuiCB\('(.*?)'\);/", $ret, $arr)) {
		$r = explode("','",str_replace("', '","','",$arr[1]));
		if ($r[0] == 0) {
			$arr = array();
			$arr['code'] = 0;
			$arr['msg'] = 'success';
			$url = $r[2];
			$ret = get_curl($url, 0, 0, 0, 1);
			preg_match('/skey=(.{10});/', $ret, $skey);
			$skey = $skey[1];
			preg_match('/p_skey=(.{44});/', $ret, $p_skey);
			$p_skey = $p_skey[1];
			$arr['skey'] = $skey;
			$arr['p_skey'] = $p_skey;

			exit(json_encode($arr,true));
		}
	}
	echo $ret;
}








function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept:application/json";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        if ($referer == 1) {
            curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);//主要头部
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//跟随重定向
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;

}