<?php
/**
 * Created by PhpStorm.
 * User: 烟雨寒云
 * Date: 2018/6/5
 * Time: 2:11
 * 水不撩不知深浅，人不拼怎知输赢！
 */
error_reporting(0);
$mysql = require_once __DIR__ . '/../dg/APP/index/database.php';
require_once __DIR__ . '/../dg/APP/functions.php';
try {
    $pdo = new PDO("mysql:host={$mysql['hostname']};dbname={$mysql['database']};port={$mysql['hostport']}",$mysql['username'],$mysql['password']);
}catch(Exception $e){
    exit('链接数据库失败:'.$e->getMessage());
}
$pdo->exec("set names utf8");

$syskey=$pdo->query("SELECT value FROM dg_configs WHERE vkey='syskey' limit 1")->fetchColumn();
$cronkey=$pdo->query("SELECT value FROM dg_configs WHERE vkey='cronkey' limit 1")->fetchColumn();
$getway_api=$pdo->query("SELECT value FROM dg_configs WHERE vkey='getway_api' limit 1")->fetchColumn();


$act=isset($_GET['act'])?daddslashes($_GET['act']):exit('{"code":-6,"msg":"No Act!"}');
$key=isset($_GET['key'])?daddslashes($_GET['key']):exit('{"code":-6,"msg":"No Key!"}');
$format=isset($_GET['format'])?daddslashes($_GET['format']):'json';

if($format=='json'){
@header('Content-Type: application/json; charset=UTF-8');
}else{
@header('Content-Type: text/plain; charset=UTF-8');
}

if(!$getway_api){
	exit('{"code":-5,"msg":"当前站点未开启代挂管家接口"}');
}elseif(!empty($key) && $key==md5($syskey.md5($cronkey))){
	if($act=='list'){
		$tid=isset($_GET['tid'])?intval($_GET['tid']):exit('{"code":-6,"msg":"No tid!"}');
		$type=isset($_GET['type'])?daddslashes($_GET['type']):'all';
		$cleanbg=isset($_GET['cleanbg'])?intval($_GET['cleanbg']):0;
		if (!$tool = $pdo->query("select * from dg_tools where tid={$tid} limit 1")->fetch()) {
            exit('{"code":-4,"msg":"该代挂项目不存在"}');
        }
		if ($type == 'all') {
            $stmt = $pdo->query("select b.uin,b.pwd,a.zt,a.id from dg_orders as a left join dg_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt != 2 order by a.id desc");
        } else {
            $stmt = $pdo->query("select b.uin,b.pwd,a.zt,a.id from dg_orders as a left join dg_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt = 1 order by a.id desc");
        }
		$result['code']=0;
		$result['tid']=$tid;
		$result['name']=$tool['name'];
        $data = array();
        while ($row = $stmt->fetch()) {
            if ($row['zt'] == 1 && $cleanbg == 1) {
                $pdo->exec("update dg_orders set zt=0 where id={$row['id']} limit 1");
            }
            $data[] = array('uin'=>$row['uin'], 'pwd'=>$row['pwd']);
        }
		$result['data']=$data;
		$result['count']=count($data);
		$result['msg']='succ';

		if($format=='text'){
			$txt = '';
			foreach($data as $row){
				$txt .= $row['uin'] . '----' . $row['pwd'] . "\r\n";
			}
			exit($txt);
		}else{
			exit(json_encode($result));
		}
	}elseif($act=='import'){
		$uins=isset($_POST['uins'])?daddslashes($_POST['uins']):exit('{"code":-6,"msg":"No uins!"}');
		$zt=isset($_GET['zt'])?intval($_GET['zt']):exit('{"code":-6,"msg":"No zt!"}');
		$uins = trim($uins, ',');
		$num = $pdo->exec("update dg_qqs set zt={$zt} where uin in ({$uins})");

        if ($zt == '3') {
            $title = '登录保护';
        } elseif ($kind == '2') {
            $title = '账号冻结';
        } else {
            $title = '密码错误';
        }
            if ($zt != '0') {
                $config = array();
                $config['email_cloud'] = $pdo->query("SELECT value FROM dg_configs WHERE vkey='zz_email_cloud' limit 1")->fetchColumn();
                $config['email_host'] = $pdo->query("SELECT value FROM dg_configs WHERE vkey='zz_email_host' limit 1")->fetchColumn();
                $config['email_port'] = $pdo->query("SELECT value FROM dg_configs WHERE vkey='zz_email_port' limit 1")->fetchColumn();
                $config['email_user'] = $pdo->query("SELECT value FROM dg_configs WHERE vkey='zz_email_user' limit 1")->fetchColumn();
                $config['email_pwd'] = $pdo->query("SELECT value FROM dg_configs WHERE vkey='zz_email_pwd' limit 1")->fetchColumn();
                $html = '您好,您的QQ在执行任务时QQ账号检测到' . $title . ',请更新密码后提交补挂!';
                $needsends = explode(',', $uin);
                for ($times = 0; $times < count($num) + 1; $times++) {
                $send = sendEmail($needsends[$times] . '@qq.com', '代挂任务提醒', $html, $config);
                }
		               }
		$result = array('code'=>0,'count'=>$num,'msg'=>'成功更改' . $num . '个QQ的状态！');
		exit(json_encode($result));
	}elseif($act=='cleanbg'){
		$ok=isset($_GET['ok'])?intval($_GET['ok']):exit('{"code":-6,"msg":"No ok!"}');
		$num = $pdo->exec("update dg_orders set zt=0 where zt=1");
		$result = array('code'=>0,'count'=>$num,'msg'=>'成功清空补挂状态！');
		exit(json_encode($result));
	}elseif($act=='query'){
		$uin=isset($_GET['uin'])?daddslashes($_GET['uin']):exit('{"code":-6,"msg":"No uin!"}');
		$row = $pdo->query("select * from dg_qqs where uin='{$uin}' limit 1")->fetch();
		$orders = $pdo->query("select * from dg_orders where qid={$row['qid']} order by tid asc")->fetchAll(PDO::FETCH_ASSOC);
		$data = array('qid'=>$row['qid'],'uin'=>$row['uin'],'zt'=>$row['zt'],'cookiezt'=>$row['cookiezt'],'orders'=>$orders);
		$result = array('code'=>0,'data'=>$data,'msg'=>'succ');
		exit(json_encode($result));
	}
}else{
	exit('{"code":-5,"msg":"密钥验证失败"}');
}