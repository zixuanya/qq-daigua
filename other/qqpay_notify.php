<?php

//---------------------------------------------------------
//QQ钱包支付即时到帐支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once("inc.php");
require (SYSTEM_ROOT."tenpay/ResponseHandler.class.php");
require (SYSTEM_ROOT."tenpay/RequestHandler.class.php");
require (SYSTEM_ROOT."tenpay/client/ClientResponseHandler.class.php");
require (SYSTEM_ROOT."tenpay/client/TenpayHttpClient.class.php");
@header('Content-Type: text/html; charset=UTF-8');

/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($conf['qqpay_key']);

//判断签名
if($resHandler->isTenpaySign()) {

//判断签名及结果（即时到帐）
	if($resHandler->getParameter("pay_result") == "0") {
		//取结果参数做业务处理
		$out_trade_no = $resHandler->getParameter("sp_billno");
		//财付通订单号
		$transaction_id = $resHandler->getParameter("transaction_id");
		//金额,以分为单位
		$total_fee = $resHandler->getParameter("total_fee");
		//币种
		$fee_type = $resHandler->getParameter("fee_type");
		
		//------------------------------
		//处理业务开始
		//------------------------------
		$srow=$DB->query("SELECT * FROM ".DB_PREFIX."pay WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		$uid=$srow['uid'];
		
		if($srow['status']==0){
		$DB->query("update `".DB_PREFIX."pay` set `status` ='1' where `trade_no`='$out_trade_no'");

		$msg = 'OK';
		$DB->query("update ".DB_PREFIX."users set point=point+{$srow['money']} where uid='{$uid}'");
		addPointRecord($uid, $srow['money'], 'QQ钱包');
		}
		//------------------------------
		//处理业务完毕
		//------------------------------
		echo "success";
	} else {
		//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
		//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
	   echo "fail";
	}
	
//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
/*
	echo "<br>------------------------------------------------------<br>";
	echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
	echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
	echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
	echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
	echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
	*/

} else {
    echo "<br/>" . "认证签名失败" . "<br/>";
    echo $resHandler->getDebugInfo() . "<br>";
}

 

?>