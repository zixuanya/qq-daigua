<?php
/* * 
 * 功能：彩虹易支付页面跳转同步通知页面
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见epay_notify_class.php中的函数verifyReturn
 */

require_once("inc.php");
require_once(SYSTEM_ROOT."epay/epay.config.php");
require_once(SYSTEM_ROOT."epay/epay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

	//支付方式
	$type = $_GET['type'];

	$srow=$DB->query("SELECT * FROM ".DB_PREFIX."pay WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
	$uid=$srow['uid'];

    if($_GET['trade_status'] == 'TRADE_SUCCESS') {
		if($srow['status']==0){
			$DB->query("update `".DB_PREFIX."pay` set `status` ='1' where `trade_no`='$out_trade_no'");

			$DB->query("update ".DB_PREFIX."users set point=point+{$srow['money']} where uid='{$uid}'");
			addPointRecord($uid, $srow['money'], '易支付');
			showmsg('成功充值'.$srow['money'].'元！',1,'shop');
		}else{
			showmsg('您所购买的商品已成功到账，感谢购买！',1,'shop');
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
    showmsg('验证失败！',4,'shop');
}
?>