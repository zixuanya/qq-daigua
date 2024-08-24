<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------


namespace app\index\controller;


class Client extends Common
{
	public function userinfo()
    {
		$vipname = array('普通用户','VIP①','VIP②','VIP③','VIP④','VIP⑤','VIP⑥','VIP⑦','VIP⑧','站长');
		$userinfo=array('uid'=>$this->userInfo['uid'],'zid'=>$this->userInfo['zid'],'upid'=>$this->userInfo['upid'],'user'=>$this->userInfo['user'],'power'=>$this->userInfo['power'],'powername'=>$vipname[$this->userInfo['power']],'point'=>$this->userInfo['point'],'qq'=>$this->userInfo['qq'],'invite'=>$this->userInfo['invite'],'invitetime'=>$this->userInfo['invitetime'],'regip'=>$this->userInfo['regip'],'regtime'=>$this->userInfo['regtime']);
		exit(json_encode($userinfo));
    }
    public function qdlist()
    {
		$qdlist=$this->pdo->selectAll("select a.*,b.user from pre_qiandaos as a left join pre_users as b on b.uid=a.uid order by a.id desc limit 10");
        echo json_encode($qdlist);
    }

	public function viplist()
    {
		$price_dx = explode("|",config('web_price_dx'));
		$price_all = explode("|",config('web_price_all'));
		$price_vip = explode("|",config('web_price_vip'));
		$vipname = array('普通用户','VIP①','VIP②','VIP③','VIP④','VIP⑤','VIP⑥','VIP⑦','VIP⑧','站长');
		foreach($price_vip as $k=>$v){
			$data['id']=$k+1;
			$data['name']=$vipname[$k+1];
			$data['price_all']=isset($price_all[$k+1])?$price_all[$k+1]:$price_all[0];
			$data['price_dx']=isset($price_dx[$k+1])?$price_dx[$k+1]:$price_dx[0];
			$data['price_vip']=$v;
			$viplist[]=$data;
		}
        echo json_encode($viplist);
    }

	public function rank($kind = 'invite')
    {
		if ($kind == 'order') {
            $name = '分站订单数排行';
            $rankList=$this->pdo->selectAll("select a.zid,a.name,(select count(c.qid) from pre_orders as b left join pre_qqs as c on c.qid=b.qid left join pre_users as d on d.uid=c.uid where d.zid=a.zid) as count from pre_webs as a order by count desc limit 10");
        } else {
            $kind = 'invite';
            $name = '邀请人数排行';
            $rankList=$this->pdo->selectAll("select a.uid,a.user,(select count(b.uid) from pre_users as b where b.upid = a.uid) as count  from pre_users as a order by count desc limit 10");
        }
		$result=array('code'=>0,'name'=>$name,'data'=>$rankList);
        echo json_encode($result);
    }

	public function invite()
    {
		$invites = $this->pdo->selectAll("select uid,user,invitetime from pre_users where upid=" . $this->uid . " order by invitetime desc");
        echo json_encode($invites);
    }

	public function rmbList()
	{
		$points = $this->pdo->selectAll("select * from pre_points where uid=" . $this->uid . " order by id desc");
		echo json_encode($points);
	}

	public function qqInfo($qid)
    {
        $qid = intval($qid);
		$info = $this->pdo->find("select * from pre_qqs where uid=:uid and qid=:qid limit 1", array(':qid' => $qid, ':uid' => $this->uid));
		$orderList = $this->pdo->selectAll("select a.*,b.name from pre_orders as a left join pre_tools as b on b.tid=a.tid where a.qid=:qid order by a.tid asc", array(':qid' => $info['qid']));
		$result=array('code'=>0,'info'=>$info,'order'=>$orderList);
		echo json_encode($result);
	}

	public function qqList()
    {
		$action = input('get.action');
		if ($action == 'search') {
			$uin = input('get.uin');
			$qqList = $this->pdo->selectAll("select * from pre_qqs where uin=:uin and uid=:uid limit 1", array(':uin' => $uin, ':uid' => $this->uid));
		} else {
			$qqList = $this->pdo->selectAll("select * from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
		}
		echo json_encode($qqList);
	}

	public function toolList()
    {
		$toolList = $this->pdo->selectAll("select * from pre_tools order by tid asc");
		echo json_encode($toolList);
	}

	

    function __construct()
    {
        parent::__construct();
        //判断是否已登录
        if (empty($this->userInfo)) {
			$result=array('code'=>-4,'msg'=>'未登录');
			exit(json_encode($result));
        }
    }
}