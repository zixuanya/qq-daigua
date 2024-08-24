<?php
namespace app\index\controller;

use think\Cookie;

class Index extends Common
{

	public function siteinfo()
    {
		$app_conf=@unserialize(config('web_app_conf'));
		$siteinfo=array('name'=>config('web_name'),'super'=>config('web_super'),'zzqq'=>config('web_qq'),'app_version'=>$app_conf['app_version'],'app_url'=>$app_conf['app_url'],'app_log'=>$app_conf['app_log'],'app_start_is'=>$app_conf['app_start_is'],'app_start'=>$app_conf['app_start']);
		exit(json_encode($siteinfo));
    }
    public function newPwd()
    {
        $code = input('get.code');
        if (strlen($code) !=32 || !$user = $this->pdo->find("select * from pre_users where zid=:zid and sid=:code limit 1",array(':zid'=>ZID,':code'=>$code))){
            $this->assign('alert',sweetAlert('链接失效','链接已失效！','warning','/'));
            return $this->fetch('common/sweetalert');
        }
        $this->assign('user',$user);
        if (IS_POST){
            $pwd = input('post.pwd');
            if (strlen($pwd) < 5){
                $this->assign('alert',sweetAlert('温馨提示','密码太简单！','warning'));
            }else{
                $sid = getSid();
                $pwd= getPwd($pwd);
                $this->pdo->execute("update pre_users set sid=:sid,pwd=:pwd where uid=:uid limit 1",array(':sid'=>$sid,':pwd'=>$pwd,':uid'=>$user['uid']));
                $this->assign('alert',sweetAlert('重置成功','密码已重置，马上登录！','warning',url('login')));
            }
        }

        return $this->fetch();
    }
    public function findPwd()
    {

        if (IS_POST){
            $qq = input('post.qq');
            $code = input("post.code/d");
            if (strlen($code) != 5 || $_SESSION['vc_code'] != $code){
                $this->assign("alert",sweetAlert("温馨提示","验证码错误！","warning"));
            }elseif (strlen($qq)<5 || strlen($qq)>11) {
                $this->assign('alert', sweetAlert('温馨提示', 'QQ格式不正确！', 'warning'));
            }elseif (!config('zz_email_user')){
                $this->assign('alert',sweetAlert('温馨提示','联系站长，请先进行邮箱配置！','warning'));
            }elseif(!$user = $this->pdo->find("select * from pre_users where qq=:qq and zid=:zid limit 1",array(':qq'=>$qq,':zid'=>ZID))){
                $this->assign('alert',sweetAlert('温馨提示','此QQ不存在！','warning'));
            }else{
                unset($_SESSION['vc_code']);//销毁验证码
                $sid = getSid();
                $this->pdo->execute("update pre_users set sid=:sid where uid=:uid limit 1",array(':uid'=>$user['uid'],':sid'=>$sid));

                @set_time_limit(0);
                $config=array();
				$config['email_cloud']=config('zz_email_cloud');
                $config['email_host']=config('zz_email_host');
                $config['email_port']=config('zz_email_port');
                $config['email_user']=config('zz_email_user');
                $config['email_pwd']=config('zz_email_pwd');
                $config['email_apiuser'] = config('zz_email_apiuser');
				$config['email_apikey'] = config('zz_email_apikey');
				$config['email_nick'] = config('web_name');

                $html=$user['user'].',你好！你正在使用密码找回功能，如不是你本人操作，请忽略此邮件！<br>点击下面链接找回密码！<br><a href="http://'.$_SERVER['HTTP_HOST'].url('newPwd').'?code='.$sid.'">找回密码</a>';
                $send=sendEmail($user['qq'].'@qq.com',$config['email_nick'].'用户找回密码',$html,$config);
                if($send=='success'){
                    $this->assign('alert',sweetAlert('操作成功','重置密码链接已发送至邮箱：'.$user['qq'].'@qq.com！','success'));
                }else{
                    $this->assign('alert',sweetAlert('温馨提示','邮件发送失败！'.$send,'warning'));
                }
            }
        }
        return $this->fetch();
    }
    public function logout()
    {
        Cookie::clear('mzdg_');
        $this->assign('alert',sweetAlert('安全退出','你已成功注销登录！','success','/'));
        return $this->fetch('common/sweetalert');
    }
    public function reg()
    {
        if (IS_POST){
            $user = strip_tags(input("post.user"));
            $pwd = strip_tags(input("post.pwd"));
            $qq = strip_tags(input("post.qq"));
            $code = input("post.code/d");
            $invite = strip_tags(input("post.invite"));
            $sid = getSid();
            $ip = getIP();
            $userRow = $this->pdo->find("select uid from pre_users where invite=:invite limit 1",array(':invite'=>$invite));
            if ($userRow){
                $upid = $userRow['uid'];
            }else{
                $upid = 0;
            }

            if (strlen($qq) <5 || strlen($qq) >12){
                $this->assign("alert",sweetAlert("温馨提示","QQ号码不正确！","warning"));
            }elseif (strlen($code) != 5 || $_SESSION['vc_code'] != strtolower($code)){
                $this->assign("alert",sweetAlert("温馨提示","验证码错误！","warning"));
            }elseif ($this->pdo->find('select uid from pre_users where user=:user limit 1',array(':user'=>$user))){
                $this->assign("alert",sweetAlert("温馨提示","此用户名已存在！","warning"));
            }elseif ($this->pdo->find('select uid from pre_users where qq=:qq where limit 1',array(':qq'=>$qq))) {
                $this->assign("alert", sweetAlert("温馨提示", "此QQ已经注册过！", "warning"));
            }elseif ($this->pdo->find("select uid from pre_users where regip=:ip and zid=:zid limit 1",array(':ip'=>$ip,':zid'=>ZID))) {
                $this->assign("alert", sweetAlert("温馨提示", "对不起，此IP已注册过账号！", "warning"));
            }elseif ($invite && strlen($invite) != 8) {
                $this->assign("alert", sweetAlert("温馨提示", "邀请码格式不正确！", "warning"));
            }elseif ($invite && !$userRow){
                $this->assign("alert", sweetAlert("温馨提示", "邀请码不存在！", "warning"));
            }elseif ($this->pdo->execute("INSERT INTO `pre_users` (`zid`, `upid`, `user`, `pwd`, `sid`, `qq`, `peie`, `regip`, `regtime`) VALUES (:zid, :upid, :user, :pwd, :sid, :qq, '1', :ip, NOW())",array(':zid'=>ZID,':user'=>$user,':pwd'=>getPwd($pwd),':sid'=>$sid,':qq'=>$qq,':upid'=>$upid,':ip'=>$ip))){
                if ($invite){
                    $row = $this->pdo->find('select uid,upid from pre_users where sid=:sid limit 1',array(':sid'=>$sid));
					//获取邀请奖励
                    if (config('zz_point_invite1')) {
						$this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1",array(':point'=>config('zz_point_invite1'),':uid'=>$row['uid']));
						$this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())",array(':uid'=>$row['uid'],':point'=>config('zz_point_invite1'),':action'=>'提成',':bz'=>'填写邀请码获得奖励！'));
					}
					//邀请人获得奖励
                    if (config('zz_point_invite2')) {
						$this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1",array(':point'=>config('zz_point_invite2'),':uid'=>$row['upid']));
						$this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())",array(':uid'=>$row['upid'],':point'=>config('zz_point_invite2'),':action'=>'提成',':bz'=>'邀请用户UID:'.$row['uid'].'获得奖励！'));
					}
                }
                $this->assign("alert",sweetAlert("注册成功","恭喜你，注册成功！马上登录！","success",url('login')));
            }else{
                $this->assign("alert",sweetAlert("温馨提示","注册失败，请稍候再试！","warning"));
            }
            unset($_SESSION['vc_code']);//销毁验证码，不然会刷注册！

        }
        return $this->fetch();
    }
    public function login()
    {
        if (IS_POST){
            $user = input("post.user");
            $pwd = input("post.pwd");
            if(strlen($user)<3 || strlen($pwd)<5){
                $this->assign("alert",sweetAlert("温馨提示","用户名或者密码格式不正确！","warning"));
            }elseif ($row = $this->pdo->find('select uid,pwd from pre_users where zid=:zid and (user=:user or qq=:user) limit 1',array(':zid'=>ZID,':user'=>$user))){
				if($row['pwd']==getPwd($pwd)){
					$ctime=2592000;
					$expiretime=time()+$ctime;
					$session=md5($row['uid'].md5($row['pwd']));
					$token=authcode("{$row['uid']}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
					Cookie::set('userSid',$token,['prefix'=>'mzdg_','path'=>'/','expire'=>$ctime]);
					$this->assign("alert", sweetAlert("登录成功", "你已成功登录，进入控制面板！", "success", url("/index/Panel/index")));
				}else{
					$this->assign("alert",sweetAlert("温馨提示","用户名或者密码不正确！","warning"));
				}
            }else{
                $this->assign("alert",sweetAlert("温馨提示","此用户不存在！","warning"));
            }
        }
        return $this->fetch();
    }
	public function qqInfo($uin)
    {

        if (!$info = $this->pdo->find("select * from pre_qqs where uin=:uin limit 1", array(':uin' => $uin))) {
            $this->assign('alert', sweetAlert('温馨提示', 'QQ不存在！', 'warning', url('qqList')));
            return $this->fetch('common/sweetalert');
        }
		$qid = $info['qid'];

        $this->assign('info', $info);
        $this->assign('orderList', $this->pdo->selectAll("select a.*,b.name from pre_orders as a left join pre_tools as b on b.tid=a.tid where a.qid=:qid order by a.tid asc", array(':qid' => $info['qid'])));

        $this->assign('webTitle', $info['uin'] . '-订单详情');
        return $this->fetch();
    }

	public function query()
    {
		if (IS_POST){
            $uin = input("post.qq");
			if ($info = $this->pdo->find("select * from pre_qqs where uin=:uin limit 1", array(':uin' => $uin))) {
				$result=array('code'=>1);
			}else{
				$result=array('code'=>2);
			}
			exit(json_encode($result));
		}
        $this->assign('webTitle', '订单查询');
        return $this->fetch();
    }

    public function index()
    {
        //数据统计
        $amount['user'] = $this->pdo->getCount("select uid from pre_users");
        $amount['juser'] = $this->pdo->getCount("select uid from pre_users where TO_DAYS(regtime) = TO_DAYS(NOW())");
        $amount['web'] = $this->pdo->getCount("select zid from pre_webs");
        $amount['jweb'] = $this->pdo->getCount("select uid from pre_webs where TO_DAYS(regtime) = TO_DAYS(NOW())");
        $this->assign('amount',$amount);
        return $this->fetch();
    }
}
