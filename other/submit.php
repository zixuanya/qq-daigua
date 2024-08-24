<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在为您跳转到支付页面，请稍候...</title>
    <style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(../assets/load.gif) no-repeat 20px 26px;
            text-indent:22px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
<script>
function open_without_referrer(link){
document.body.appendChild(document.createElement('iframe')).src='javascript:"<script>top.location.replace(\''+link+'\')<\/script>"';
}
</script>
</head>
<body>
<?php
require 'inc.php';

@header('Content-Type: text/html; charset=UTF-8');

$type=isset($_GET['type'])?daddslashes($_GET['type']):exit('No type!');
$orderid=isset($_GET['orderid'])?daddslashes($_GET['orderid']):exit('No orderid!');
$row=$DB->query("SELECT * FROM ".DB_PREFIX."pay WHERE trade_no='{$orderid}' limit 1")->fetch();
if(!$row['trade_no'])exit('该订单号不存在，请返回来源地重新发起请求！');
if($type=='epay'){
	require_once(SYSTEM_ROOT."epay/epay.config.php");
	require_once(SYSTEM_ROOT."epay/epay_submit.class.php");
	$parameter = array(
		"pid" => trim($conf['epay_pid']),
		"type" => $_GET['type2'],
		"notify_url"	=> 'http://'.$_SERVER['HTTP_HOST'].'/other/epay_notify.php',
		"return_url"	=> 'http://'.$_SERVER['HTTP_HOST'].'/other/epay_return.php',
		"out_trade_no"	=> $orderid,
		"name"	=> $row['name'],
		"money"	=> $row['money'],
		"sitename"	=> '等级代挂系统'
	);
	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转");
	echo $html_text;

}elseif($type=='alipay'){
	require_once(SYSTEM_ROOT."alipay/alipay.config.php");
	require_once(SYSTEM_ROOT."alipay/alipay_submit.class.php");
	$yrow=$DB->query("SELECT * FROM ".DB_PREFIX."webs WHERE domain='{$_SERVER['HTTP_HOST']}' or domain2='{$_SERVER['HTTP_HOST']}' limit 1")->fetch();
	$domain=$yrow['domain']?$yrow['domain']:$_SERVER['HTTP_HOST'];
	//构造要请求的参数数组，无需改动
	if(checkmobile()==true && $conf['alipay2_api']==1){
		$parameter = array(
			"service" => "alipay.wap.create.direct.pay.by.user",
			"partner" => trim($conf['alipay_pid']),
			"seller_id" => trim($conf['alipay_account']),
			"payment_type"	=> "1",
			"notify_url"	=> 'http://'.$domain.'/other/alipay_notify.php',
			"return_url"	=> 'http://'.$domain.'/other/alipay_return.php',
			"out_trade_no"	=> $orderid,
			"subject"	=> $row['name'],
			"total_fee"	=> $row['money'],
			"_input_charset"	=> strtolower('utf-8')
		);
	}else{
		$parameter = array(
			"service" => "create_direct_pay_by_user",
			"partner" => trim($conf['alipay_pid']), //合作身份者id
			"seller_email" => trim($conf['alipay_account']), //收款支付宝账号
			"payment_type"	=> "1", //支付方式
			"notify_url"	=> 'http://'.$domain.'/other/alipay_notify.php', //服务器异步通知页面路径
			"return_url"	=> 'http://'.$domain.'/other/alipay_return.php', //页面跳转同步通知页面路径
			"out_trade_no"	=> $orderid, //商户订单号
			"subject"	=> $row['name'], //订单名称
			"total_fee"	=> $row['money'], //付款金额
			"_input_charset"	=> strtolower('utf-8')
		);
	}

	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转");
	echo $html_text;
}elseif($type=='tenpay'){
	require_once(SYSTEM_ROOT."tenpay/RequestHandler.class.php");

	/* 创建支付请求对象 */
	$reqHandler = new RequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($conf['tenpay_key']);
	$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

	//----------------------------------------
	//设置支付参数 
	//----------------------------------------
	$reqHandler->setParameter("partner", trim($conf['tenpay_pid']));
	$reqHandler->setParameter("out_trade_no", $orderid);
	$reqHandler->setParameter("total_fee", $row['money']*100);  //总金额
	$reqHandler->setParameter("return_url", 'http://'.$_SERVER['HTTP_HOST'].'/other/tenpay_return.php');
	$reqHandler->setParameter("notify_url", 'http://'.$_SERVER['HTTP_HOST'].'/other/tenpay_notify.php');
	$reqHandler->setParameter("body", $row['name']);
	$reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通
	$reqHandler->setParameter("spbill_create_ip", $clientip);//客户端IP
	$reqHandler->setParameter("fee_type", "1");               //币种
	$reqHandler->setParameter("subject",$row['name']);          //商品名称，（中介交易时必填）
	//系统可选参数
	$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
	$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
	$reqHandler->setParameter("input_charset", "utf-8");   	  //字符集
	$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号

	//请求的URL
	$reqUrl = $reqHandler->getRequestURL();

	echo '<script>open_without_referrer("'.$reqUrl.'");</script>';

	//获取debug信息,建议把请求和debug信息写入日志，方便定位问题
	/**/
	//$debugInfo = $reqHandler->getDebugInfo();
	//echo "<br/>" . $reqUrl . "<br/>";
	//echo "<br/>" . $debugInfo . "<br/>";

	/*echo '<form action="'.$reqHandler->getGateUrl().'" method="post" id="tenpay">';

	$params = $reqHandler->getAllParameters();
	foreach($params as $k => $v) {
		echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
	}
	echo '<input type="submit" value="正在跳转"></form><script>document.getElementById("tenpay").submit();</script>';*/
}

?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>