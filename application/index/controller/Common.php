<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------


namespace app\index\controller;


use app\util\PdoHelper;
use think\Controller;
use think\Cookie;

class Common extends Controller
{
    protected $userInfo;
    protected $pdo;
    protected $uid = 0;

    function __construct()
    {
        parent::__construct();
        //获取PDO对象
        $this->pdo = new PdoHelper();
        $this->loadWebConfig();

        $userSid = Cookie::get("userSid","mzdg_");
        if($userSid !== null){
			if($token=authcode($userSid, 'DECODE', SYS_KEY)){
				list($uid, $sid, $expiretime) = explode("\t", $token);
				$user = $this->pdo->find("select * from pre_users where zid=:zid and uid=:uid limit 1",array(':zid'=>ZID,":uid"=>$uid));
				$session=md5($user['uid'].md5($user['pwd']));
				if($session==$sid && $expiretime>time()) {
					$this->userInfo = $user;
					$this->uid = $this->userInfo['uid'];
				}
			}
        }

        $this->assign('userInfo',$this->userInfo);
    }

    private function loadWebConfig()
    {
        //加载主站配置
        $stmt = $this->pdo->getStmt("select * from pre_configs");
        while ($row = $stmt->fetch()){
            config("zz_{$row['vkey']}",$row['value']);
        }
		if(!config("zz_syskey")){
			$syskey = random(32);
			config("zz_syskey",$syskey);
			$this->pdo->execute("INSERT INTO `dg_configs` (`vkey`, `value`) VALUES ('syskey', '$syskey')");
		}
		define("SYS_KEY",config("zz_syskey"));
        
        //加载站点配置
        if ($web = $this->pdo->find('select * from pre_webs where domain=:domain or domain2=:domain limit 1',array(':domain'=>$_SERVER['HTTP_HOST']))){
            define("ZID",$web['zid']);
            foreach ($web as $key=>$value){
                config("web_{$key}",$value);
            }
			if(($web['super']>=1||ZID==1) && ACTION_NAME!='mainset'){
				config("zz_price_dx",config('zz_price_dx2')?config('zz_price_dx2'):config('zz_price_dx'));
				config("zz_price_all",config('zz_price_all2')?config('zz_price_all2'):config('zz_price_all'));
			}
        }else{
            $this->assign('alert',sweetAlert('站点未开通','此站点未开通！','warning','http://'.config('zz_domain')));
            exit($this->fetch('common/sweetalert'));
        }
        if (strtotime($web['endtime']) < time()){
            $this->assign('alert',sweetAlert('站点已到期','请站长联系QQ：'.config('zz_qq').'续费！','warning','http://'.config('zz_domain')));
            exit($this->fetch('common/sweetalert'));
        }
        
    }

    protected function klsfCurl($_url,$_post,$_ists=false)
    {
        $arr = klsfCurl($_url,$_post);
        if(!isset($arr['code'])) {
            $this->assign('alert', sweetAlert('网络异常', '网络异常，请稍候再试！', 'warning', 'REFERER'));
            exit($this->fetch('common/sweetalert'));
        }elseif ($_ists && $arr['code'] != 0 ){
            $this->assign('alert', sweetAlert('温馨提示',$arr['msg'], 'warning', 'REFERER'));
            exit($this->fetch('common/sweetalert'));
        }else{
            return $arr;
        }
    }
}