<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------
//公共函数库

/**
 * 快捷生成sweetalert
 *
 * @param      $_title
 * @param      $_text
 * @param      $_type
 * @param null $_url
 *
 * @return string
 */
 
function sweetAlert($_title, $_text, $_type, $_url = null)
{
    if (empty($_url)) {
        return 'swal("' . $_title . '", "' . $_text . '", "' . $_type . '");';
    } else {
        if ($_url == 'REFERER') {
            $_url = '/';
            if (isset($_SERVER['HTTP_REFERER'])) {
                $_url = $_SERVER['HTTP_REFERER'];
            }
        }
        return 'swal({ title: "' . $_title . '",   text: "' . $_text . '",   type: "' . $_type . '",   showCancelButton: false,   confirmButtonColor: "#DD6B55",   confirmButtonText: "OK",   closeOnConfirm: false }, function(){   window.location.href="' . $_url . '"; });';
    }
}


function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $klsf[] = "Accept:*/*";
    $klsf[] = "Accept-Encoding:gzip,deflate,sdch";
    $klsf[] = "Accept-Language:zh-CN,zh;q=0.8";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $klsf);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
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

function get_curl_self($url, $post = 0)
{
    $ch = curl_init();
	$urlarr = parse_url($url);
	if($urlarr['host']==$_SERVER['HTTP_HOST'] && !ini_get('acl.app_id')){
		$url=str_replace('http://'.$_SERVER['HTTP_HOST'].'/','http://127.0.0.1:80/',$url);
		$url=str_replace('https://'.$_SERVER['HTTP_HOST'].'/','https://127.0.0.1:443/',$url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: '.$_SERVER['HTTP_HOST']));
	}
    curl_setopt($ch, CURLOPT_URL, $url);
	if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

/**
 * 用户密码加密
 *
 * @param $pwd
 *
 * @return string
 */
function getPwd($pwd)
{
    return md5(md5($pwd) . md5('815856515'));
    //return md5(md5($pwd.'dad4553faf133as1d34fa34'));
}

/**
 * 获取随机字符串
 *
 * @return string
 */
function getSid()
{
    return md5(uniqid(mt_rand(), 1) . time());
}

/**
 * 获取订单状态
 *
 * @param $zt
 *
 * @return string
 */
function getOrderZt($zt)
{
    switch ($zt) {
        case 0:
            return '<font color="pink">加速中</font>';
        case 1:
            return '<font color="#a0522d">补挂中</font>';
        case 2:
            return '<font color="red">已暂停</font>';
        default:
            return '<font color="#ff7f50">未知</font>';
    }
}

/**
 * 判断是否是VIP
 *
 * @param $date
 *
 * @return bool
 */
function isVip($date)
{
    if (strtotime($date) > time()) {
        return true;
    } else {
        return false;
    }
}


/**
 * 获取商品列表和价格
 *
 * @param $_pdo
 *
 * @return array
 */
function getShopList($_pdo)
{
    $arrList = array();
    $arr = array();
    if ($list = $_pdo->selectAll("select * from pre_prices where zid = " . ZID)) {
        foreach ($list as $value) {
            $arr[$value['aid']] = $value['price'];
        }
    }
    for ($i = 0; $i < 12; $i++) {
        if (!isset($arr[$i])) {
            $arr[$i] = 0;
        }
    }
    //商品列表
    $arrList[] = array('一月VIP', $arr[0], 'vip', 1);
    $arrList[] = array('一季度VIP', $arr[1], 'vip', 3);
    $arrList[] = array('半年VIP', $arr[2], 'vip', 6);
    $arrList[] = array('一年VIP', $arr[3], 'vip', 12);
    $arrList[] = array('一月SVIP', $arr[4], 'svip', 1);
    $arrList[] = array('一季度SVIP', $arr[5], 'svip', 3);
    $arrList[] = array('半年SVIP', $arr[6], 'svip', 6);
    $arrList[] = array('一年SVIP', $arr[7], 'svip', 12);
    $arrList[] = array('1个秒赞配额', $arr[8], 'peie', 1);
    $arrList[] = array('3个秒赞配额', $arr[9], 'peie', 3);
    $arrList[] = array('5个秒赞配额', $arr[10], 'peie', 5);
    $arrList[] = array('10个秒赞配额', $arr[11], 'peie', 10);


    return $arrList;
}

function getHtmlCode($value, $html = false)
{
    $value = stripslashes($value);
    if ($html) {
        $value = htmlspecialchars($value);
    }
    return $value;
}

function getRandStr($len = 12, $type = 0)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str);
    $randstr = '';
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    if ($type == 1) {
        $randstr = strtoupper($randstr);
    } elseif ($type == 2) {
        $randstr = strtolower($randstr);
    }
    return $randstr;
}

function sendEmail($to, $title, $html, $config)
{
    $mail_api=0; //是否使用邮件API
	if($mail_api!=0) {
		$mail_api_url='http://auth.cccyun.cc/mail/';
		$post['sendto']=$to;
		$post['title']=$title;
		$post['content']=$html;
		$post['user']=$config['email_user'];
		$post['pwd']=$config['email_pwd'];
		$post['nick']=$config['email_nick'];
		$post['host']=$config['email_host'];
		$post['port']=$config['email_port'];
		$post['ssl'] = $config['email_port'] == 465?'1':'0';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$mail_api_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		if($ret=='1')return 'success';
		else return $ret;
	} else {
		if($config['email_cloud']==1){
			$url='http://sendcloud.sohu.com/webapi/mail.send.json';
			$data=array(
				'api_user' => $config['email_apiuser'],
				'api_key' => $config['email_apikey'],
				'from' => $config['email_user'],
				'fromname' => $config['email_nick'],
				'to' => $to,
				'subject' => $title,
				'html' => $html);
			$json=get_curl($url,$data);
			$arr=json_decode($json,true);
			if($arr['message']=='success'){
				return 'success';
			}else{
				return implode(";",$arr['errors']);
			}
		}else{
		require_once 'util/smtp.class.php';
		$From = $config['email_user'];
		$Host = $config['email_host'];
		$Port = $config['email_port'];
		$SMTPAuth = 1;
		$Username = $config['email_user'];
		$Password = $config['email_pwd'];
		$Nickname = $config['email_nick'];
		$SSL = $config['email_port'] == 465?true:false;
		$mail = new SMTP($Host , $Port , $SMTPAuth , $Username , $Password , $SSL);
		$mail->att = array();
		if($mail->send($to , $From , $title , $html, $Nickname)) {
			return 'success';
		} else {
			return $mail->log;
		}
		}
	}
}

function getLevel($level)
{
    if ($level == 9) {
        return '站长';
    } elseif ($level > 0) {
        return '代理';
    }
    return '普通会员';
}

function getRandQQ($num)
{
    return ceil($num / 1.85 + rand(1, 24));
}

function getQqZt($zt)
{
    if ($zt == 0) {
        return '<font color="green">正常</font>';
    } elseif ($zt == 1) {
        return '<font color="red">密码错误</font>';
    } elseif ($zt == 2) {
        return '<font color="red">账号冻结</font>';
    } elseif ($zt == 3) {
        return '<font color="red">登录保护</font>';
    } else {
        return '<font color="red">需更新密码</font>';
    }

}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function getg_tk($skey){
    $len = strlen($skey);
	$hash = 5381;
	for($i = 0; $i < $len; $i++){
		$hash += (($hash << 5) & 0xffffffff) + ord($skey[$i]);
	}
	return $hash & 0x7fffffff;//计算g_tk
}


function checkCookie($uin,$skey,$pskey){
	$gtk=getg_tk($pskey);
	$cookie='uin=o0'.$uin.'; skey='.$skey.'; p_skey='.$pskey.'; p_uin='.$uin.';';
	$url=get_curl('http://base.s21.qzone.qq.com/cgi-bin/user/cgi_userinfo_get_all?uin='.$uin.'&vuin='.$uin.'&fupdate=1&format=json&rd=0.516339'.time().'&g_tk='.$gtk,0,'http://cnc.qzs.qq.com/qzone/v6/setting/profile/profile.html',$cookie);
	$arr=json_decode($url, true);
	if($arr['code']==-3000)return false;
	else return true;
}

function getIP(){
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
}
return $ip;
}
function checkIfActive($string) {
	$array=explode(',',$string);
	if (in_array(ACTION_NAME,$array)){
		return 'active';
	}else
		return null;
}
function wxpay_submit($value,$trade_no,$name){
	define("SYSTEM_ROOT",APP_PATH."../other/");
	require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
	require_once SYSTEM_ROOT."wxpay/WxPay.NativePay.php";
	$notify = new NativePay();
	$input = new WxPayUnifiedOrder();
	$input->SetBody($name);
	$input->SetOut_trade_no($trade_no);
	$input->SetTotal_fee($value*100);
	$input->SetSpbill_create_ip(getIP());
	$input->SetTime_start(date("YmdHis"));
	$input->SetTime_expire(date("YmdHis", time() + 600));
	$input->SetGoods_tag("test");
	$input->SetNotify_url('http://'.$_SERVER['HTTP_HOST'].'/other/wxpay_notify.php');
	$input->SetTrade_type("NATIVE");
	$result = $notify->GetPayUrl($input);
	return $result;
}
function wxpay_query($orderid){
	define("SYSTEM_ROOT",APP_PATH."../other/");
	require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
	$input = new WxPayOrderQuery();
	$input->SetOut_trade_no($orderid);
	$data=WxPayApi::orderQuery($input);
	return $data;
}
function qqpay_submit($money,$trade_no,$name){
	define("SYSTEM_ROOT",APP_PATH."../other/");
	require_once SYSTEM_ROOT."tenpay/RequestHandler.class.php";
	/* 创建支付请求对象 */
	$reqHandler = new RequestHandler();
	$reqHandler->init();
	$reqHandler->setKey(config('zz_qqpay_key'));
	$reqHandler->setGateUrl("https://myun.tenpay.com/cgi-bin/wappayv2.0/wappay_init.cgi");

	//----------------------------------------
	//设置支付参数 
	//----------------------------------------
	$reqHandler->setParameter("ver", "2.0"); //版本号，ver默认值是1.0
	$reqHandler->setParameter("charset", "1"); //1 UTF-8, 2 GB2312
	$reqHandler->setParameter("bank_type", "0"); //银行类型
	$reqHandler->setParameter("desc", $name); //商品描述，32个字符以内
	$reqHandler->setParameter("pay_channel", "1"); //描述支付渠道
	$reqHandler->setParameter("bargainor_id", trim(config('zz_qqpay_pid')));
	$reqHandler->setParameter("sp_billno", $trade_no);
	$reqHandler->setParameter("total_fee", $money*100);  //总金额
	$reqHandler->setParameter("fee_type", "1");               //币种
	$reqHandler->setParameter("notify_url", 'http://'.$_SERVER['HTTP_HOST'].'/other/qqpay_notify.php');

	//请求的URL
	$reqUrl = $reqHandler->getRequestURL();
	$data = get_curl($reqUrl);
	return $data;
}