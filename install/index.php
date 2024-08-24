<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/23
// +----------------------------------------------------------------------
//程序安装文件
$databaseFile = '../application/index/database.php';//数据库配额文件

@header('Content-Type: text/html; charset=UTF-8');
$step=isset($_GET['step'])?$_GET['step']:1;
$action=isset($_POST['action'])?$_POST['action']:null;
if(file_exists($databaseFile)){
    exit('你已经成功安装，如需重新安装，请手动删除application/index目录下database.php配置文件！');
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
if($action=='install'){
    $host=isset($_POST['host'])?$_POST['host']:null;
    $port=isset($_POST['port'])?$_POST['port']:null;
    $user=isset($_POST['user'])?$_POST['user']:null;
    $pwd=isset($_POST['pwd'])?$_POST['pwd']:null;
    $database=isset($_POST['database'])?$_POST['database']:null;
    if(empty($host) || empty($port) || empty($user) || empty($pwd) || empty($database)){
        $errorMsg='请填完所有数据库信息';
    }else{
        $mysql['hostname']=$host;
        $mysql['hostport']=$port;
        $mysql['database']=$database;
        $mysql['username']=$user;
        $mysql['password']=$pwd;
        try{
            $db=new PDO("mysql:host=".$mysql['hostname'].";dbname=".$mysql['database'].";port=".$mysql['hostport'],$mysql['username'],$mysql['password']);
        }catch(Exception $e){
            $errorMsg='链接数据库失败:'.$e->getMessage();
        }
        if(empty($errorMsg)){
            @file_put_contents($databaseFile,'<?php'.PHP_EOL.'return '.var_export($mysql,true).';'.PHP_EOL.PHP_EOL.'?>');
            $db->exec("set names utf8");
            $sqls=file_get_contents('install.sql');
            $sqls=explode(';', $sqls);
            $sqls[]="INSERT INTO `dg_webs` (`zid`, `uid`, `domain`, `qq`, `name`, `title`, `endtime`) VALUES ('1', '10000', '{$_SERVER['HTTP_HOST']}', '10000', '裕网云代挂系统', '裕网云代挂系统','2030-12-31 08:00:00')";
			$syskey = random(32);
			$sqls[]="INSERT INTO `dg_configs` (`vkey`, `value`) VALUES ('syskey', '$syskey')";
            $success=0;$error=0;$errorMsg=null;
            foreach ($sqls as $value) {
                $value=trim($value);
                if(!empty($value)){
                    if($db->exec($value)===false){
                        $error++;
                        $dberror=$db->errorInfo();
                        $errorMsg.=$dberror[2]."<br>";
                    }else{
                        $success++;
                    }
                }
            }
            $step=3;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>裕网云代挂系统-安装程序</title>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container"><br>
    <div class="row">
        <div class="col-xs-12">
            <pre><h4>裕网云代挂系统</h4></pre>
        </div>
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <?php
                if(isset($errorMsg)){
                    echo '<div class="alert alert-danger text-center" role="alert">'.$errorMsg.'</div>';
                }
                if($step==2){
                ?>
                <div class="panel-heading text-center">MYSQL数据库信息配置</div>
                <div class="panel-body">
                    <div class="list-group text-success">
                        <form class="form-horizontal" action="#" method="post">
                            <input type="hidden" name="action" class="form-control" value="install">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库地址</label>
                                <div class="col-sm-10">
                                    <input type="text" name="host" class="form-control" value="127.0.0.1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库端口</label>
                                <div class="col-sm-10">
                                    <input type="text" name="port" class="form-control" value="3306">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库库名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="database" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="user" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="pwd" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success btn-block">确认无误，下一步</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <?php }elseif($step==3){ ?>
                <div class="panel-heading text-center">数据导入完毕</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">成功执行SQL语句<?php echo $success;?>条，失败<?php echo $error;?>条！</li>
                        <li class="list-group-item">1、系统已成功安装完毕！</li>
                        <li class="list-group-item">2、超级管理员账号为 用户名：admin 密码:123456</li>
                        <li class="list-group-item">3、请将域名泛解析至目前服务器！</li>
                        <a href="/" class="btn list-group-item">进入网站首页</a>
                    </ul>
                </div>
                <?php }else{ ?>
                <div class="panel-heading text-center">安装环境检测</div>
                <div class="panel-body">
                    <?php
                    $install=true;
                    if(!file_exists('../application/index/database.php')){
                        $check[2]='<span class="badge">未锁定</span>';
                    }else{
                        $check[2]='<span class="badge">已锁定</span>';
                        $install=false;
                    }
                    if(class_exists("PDO")){
                        $check[0]='<span class="badge">支持</span>';
                    }else{
                        $check[0]='<span class="badge">不支持</span>';
                        $install=false;
                    }
                    if($fp = @fopen("../application/index/test.txt", 'w')) {
                        @fclose($fp);
                        @unlink("../application/index/test.txt");
                        $check[1]='<span class="badge">支持</span>';
                    }else{
                        $check[1]='<span class="badge">不支持</span>';
                        $install=false;
                    }
                    if(version_compare(PHP_VERSION,'5.4.0','<')){
                        $check[3]='<span class="badge">不支持</span>';
                    }else{
                        $check[3]='<span class="badge">支持</span>';
                    }

                    ?>
                    <ul class="list-group">
                        <li class="list-group-item">检测安装是否锁定 <?php echo $check[2];?></li>
                        <li class="list-group-item">PDO_MYSQL组件 <?php echo $check[0];?></li>
                        <li class="list-group-item">INC目录写入权限 <?php echo $check[1];?></li>
                        <li class="list-group-item">PHP版本>=5.4 <?php echo $check[3];?></li>
                        <li class="list-group-item">成功安装后安装文件就会锁定，如需重新安装，请手动删除application/index目录下database.php配置文件！</li>
                        <?php
                        if($install) echo'<a href="?step=2" class="btn list-group-item">检测通过，下一步</a>';
                        ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <pre><center>Powered by 裕网云</center></pre>
    </footer>
</div>
</body>
</html>
