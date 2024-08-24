<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------


namespace app\index\controller;


class Api extends Common
{
    public function addqq()
    {
        $pwd = input('get.pwd');
        $uin = input('get.uin');
        $skey = input('get.skey');
		$p_skey = input('get.pskey');

        $isUpdate = false;
		if(!$pwd || !$uin || !$skey || !$p_skey){
			$result=array('code'=>-1,'msg'=>'确保各项不为空');
			exit(json_encode($result));
		}

		if(!checkCookie($uin,$skey,$p_skey)){
			$result=array('code'=>-1,'msg'=>'SKEY已失效');
			exit(json_encode($result));
		}

        if ($row = $this->pdo->find('select qid,id from pre_qqs where uin=:uin limit 1', array(':uin' => $uin))) {
            $this->pdo->execute('update pre_qqs set pwd=:pwd,cookiezt=0,zt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(':qid' => $row['qid'], ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey));
			$id=$row['id'];
            $isUpdate = true;
        } else {
			$id=strtoupper(substr(md5($uin.time()),0,8).'-'.uniqid());
            $this->pdo->execute("INSERT INTO `pre_qqs` (`uid`, `uin`, `pwd`, `skey`, `p_skey`, `id`) VALUES (:uid, :uin, :pwd, :skey, :p_skey, :id)", array(':uid' => $this->uid, ':uin' => $uin, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':id' => $id));
            $row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin));
        }
        $qid = $row['qid'];

        if ($isUpdate) {
			$result=array('code'=>1,'id'=>$id,'qid'=>$qid,'msg'=>'密码更新成功');
        } else {
			$result=array('code'=>1,'id'=>$id,'qid'=>$qid,'msg'=>'添加成功');
        }

        echo json_encode($result);
    }

	public function order()
    {
		$uin = input('get.uin');
		$tid = input('post.tid/d');
		$num = input('post.num/d');

        $price_dx = config('zz_price_dx');
        $price_all = config('zz_price_all');

        $toolList = $this->pdo->selectAll("select * from pre_tools order by tid asc");

		if ($num < 1) $num = 1;
		$need = $price_dx * $num;
		if ($tid == 1) {
			//全套代挂价格
			$need = $price_all * $num;
		}
		if (!$qqrow = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin))) {
			$result=array('code'=>-1,'msg'=>'QQ不存在');
		} elseif (!$tool = $this->isExist($tid, $toolList, 'tid', 'name')) {
			$result=array('code'=>-1,'msg'=>'代挂项目不存在');
		} elseif ($this->userInfo['point'] < $need) {
			$result=array('code'=>-1,'msg'=>'余额不足，请先充值');
		} else {
			$isFinish = $this->addOrder($qqrow['qid'], $tid, $num);

			if ($isFinish) {
				$this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $need));
				//消费记录
				$this->addPointRecord($this->uid, $need, '消费', "通过API成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}元！");

				$result=array('code'=>1,'msg'=>"成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}元！");
			} else {
				$result=array('code'=>-1,'msg'=>'下单失败，请稍后再试！');
			}
		}
		echo json_encode($result);
    }

    private function addOrder($qid, $tid, $num = 1)
    {
        if ($tid == 1) {
            $stmt = $this->pdo->getStmt("select tid from pre_tools where tid in (2,3,4,5,6,7) order by tid asc");
            while ($row = $stmt->fetch()) {
                $this->addOrder($qid, $row['tid'], $num);
            }
            return true;
        }
        $endtime = date("Y-m-d H:i:s", strtotime("+ " . $num . " months", time()));
        if ($order = $this->pdo->find("select * from pre_orders where tid=:tid and qid=:qid limit 1", array(':tid' => $tid, ':qid' => $qid))) {
            if ($order['endtime'] > date("Y-m-d H:i:s")) {
                $endtime = date("Y-m-d H:i:s", strtotime("+ " . $num . " months", strtotime($order['endtime'])));
            }
            if ($this->pdo->execute("update pre_orders set endtime=:endtime where id=:id limit 1", array(':id' => $order['id'], ':endtime' => $endtime))) {
                $isFinish = true;
            }
        } else {
            if ($this->pdo->execute("INSERT INTO `pre_orders` (`tid`, `qid`, `addtime`, `endtime`) VALUES (:tid, :qid, NOW(),:endtime)", array(':tid' => $tid, ':qid' => $qid, ':endtime' => $endtime))) {
                $isFinish = true;
            }
        }
        return true;
    }

	public function qqInfo()
    {
		$uin = input('get.uin');

        if (!$info = $this->pdo->find("select * from pre_qqs where uid=:uid and uin=:uin limit 1", array(':uin' => $uin, ':uid' => $this->uid))) {
            $result=array('code'=>-1,'msg'=>'QQ不存在');
			exit(json_encode($result));
        }
		$qid = $info['qid'];
        $action = input('get.action');
        $tid = input('get.tid/d');
        if ($action == 'bu') {
            $this->pdo->execute("update pre_orders set zt=1 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'qxbu') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'off') {
            $this->pdo->execute("update pre_orders set zt=2 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'on') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        }
		$result=array('code'=>1);

        echo json_encode($result);
    }

	public function qqList()
    {
		$uins = input('get.uins');
		$uins = explode('|',$uins);
		$sql="('1'";
		foreach($uins as $row){
			$sql.=",'".$row."'";
		}
		$sql.=")";
        $qqrow=$this->pdo->selectAll("select * from pre_qqs where uid=:uid and uin in {$sql} order by qid desc", array(':uid' => $this->uid));
		$array=array();
		foreach($qqrow as $row){
			$orders=$this->pdo->selectAll("select * from pre_orders where qid=:qid order by tid asc", array(':qid' => $row['qid']));
			$array[]=array('qid'=>$row['qid'],'uin'=>$row['uin'],'zt'=>$row['zt'],'cookiezt'=>$row['cookiezt'],'orders'=>$orders);
		}
		$result=array('code'=>1,'data'=>$array);
		echo json_encode($result);
    }

    function __construct()
    {
        parent::__construct();
		$apiid = input('get.apiid');
		$apikey = input('get.apikey');
		if ($row = $this->pdo->find('select * from pre_apis where id=:apiid and apikey=:apikey limit 1', array(':apiid' => $apiid,':apikey' => $apikey))) {
			if($row['active']==1){
				$this->uid=$row['uid'];
				return true;
			}else{
				$result=array('code'=>-3,'msg'=>'APIKEY已封禁');
			}
		}else{
			$result=array('code'=>-4,'msg'=>'APIKEY不存在');
		}
		exit(json_encode($result));
    }
}