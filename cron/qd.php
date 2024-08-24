<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/6/1
// +----------------------------------------------------------------------
error_reporting(0);
@header('Content-Type: text/html; charset=UTF-8');
@ignore_user_abort(true);
@set_time_limit(0);

$mysql = require_once __DIR__ . '/../application/index/database.php';
require_once 'QQSignIn.class.php';
try {
    $pdo = new PDO("mysql:host={$mysql['hostname']};dbname={$mysql['database']};port={$mysql['hostport']}",$mysql['username'],$mysql['password']);
}catch(Exception $e){
    exit('链接数据库失败:'.$e->getMessage());
}
$pdo->exec("set names utf8");

$cronkey=$pdo->query("SELECT value FROM dg_configs WHERE vkey='cronkey' limit 1")->fetchColumn();
if($_GET['key'] != $cronkey && !empty($cronkey)){
    exit('监控识别码不正确！');
}

$stmt = $pdo->query("select a.id,a.tid,b.* from dg_orders as a left join dg_qqs as b on b.qid=a.qid where b.cookiezt=0 and (a.tid=6 or a.tid=8 or a.tid=9) and a.addtime < DATE_ADD(NOW(),INTERVAL -7 HOUR) order by a.addtime asc limit 10");
while ($row = $stmt->fetch()){
    $qd = new QQSignIn($row['uin'],$row['skey'],$row['p_skey']);
	if($row['tid']==6){ //手游加速
		$qd->qqgame();
	}elseif($row['tid']==8){ //钱包签到
		$qd->pqd();
	}elseif($row['tid']==9){ //QQ会员签到
		$qd->vipqd();
	}
	if($qd->skeyzt==1)$pdo->exec("update dg_qqs set cookiezt=1 where qid='{$row['qid']}' limit 1");
    else $pdo->exec("update dg_orders set addtime=NOW() where id='{$row['id']}' limit 1");
    print_r($qd->getMsg());
}
echo 'ok';