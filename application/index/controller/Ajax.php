<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------


namespace app\index\controller;


class Ajax extends Common
{
    public function qqLogin()
    {
        $pwd = input('get.pwd');
        $uin = input('get.u');
        $p = input('get.p');
        $vcode = input('get.verifycode');
        $pt_verifysession_v1 = input('get.pt_verifysession_v1');
        if(strpos('s'.$vcode,'!')){
            $v1=0;
        }else{
            $v1=1;
        }
        $apiurl = config('zz_login_api')?config('zz_login_api'):'http://'.$_SERVER['HTTP_HOST'].'/qlogin/login.php';
        $url = base64_encode("http://ptlogin2.qq.com/login?pt_vcode_v1={$v1}&pt_verifysession_v1={$pt_verifysession_v1}&verifycode={$vcode}&u={$uin}&p={$p}&pt_randsalt=0&ptlang=2052&low_login_enable=0&u1=https%3A%2F%2Fh5.qzone.qq.com%2Fmqzone%2Findex&from_ui=1&fp=loginerroralert&device=2&aid=549000929&daid=5&pt_ttype=1&pt_3rd_aid=0&ptredirect=1&h=1&g=1&pt_uistyle=9&");
        $ret = get_curl_self($apiurl, "url={$url}");
        $json = json_decode($ret, true);
        if (!isset($json['code'])) {
            exit($ret);
        }
        $skey = $json['skey'];
        $p_skey = $json['p_skey'];
        $isUpdate = false;

        if ($row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin))) {
            $this->pdo->execute('update pre_qqs set uid=:uid,pwd=:pwd,cookiezt=0,zt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(':qid' => $row['qid'], ':uid' => $this->uid, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey));
            $isUpdate = true;
        } else {
            //if ($this->pdo->getCount("select qid from pre_qqs where uid=:uid",array(':uid'=>$this->uid)) >= $this->userInfo['peie']){
           //     exit('alert("你的配额已用完，请购买更多配额!");window.parent.location.href="'.url("/index/Panel/shop").'";');
            //}
			$id=strtoupper(substr(md5($uin.time()),0,8).'-'.uniqid());
            $this->pdo->execute("INSERT INTO `pre_qqs` (`uid`, `uin`, `pwd`, `skey`, `p_skey`, `addtime`, `id`) VALUES (:uid, :uin, :pwd, :skey, :p_skey, NOW(), :id)", array(':uid' => $this->uid, ':uin' => $uin, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':id' => $id));
            $row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin));
        }
        $qid = $row['qid'];

        if ($isUpdate) {
            exit('alert("' . $uin . '密码更新成功,查看QQ详情!");window.parent.location.href="'.url("/index/Panel/qqInfo",['qid'=>$qid]).'";');
        } elseif($qid) {
            exit('alert("' . $uin . '添加成功，现在去下单!");window.parent.location.href="'.url("/index/Panel/order",['qid'=>$qid]).'";');
        } else {
            exit('alert("' . $uin . '添加失败，请返回重试!");');
        }

        echo json_encode($arr, true);
    }

	public function recharge()
    {
		$type=isset($_GET['type'])?input('get.type'):exit('No type!');
		$value=isset($_GET['value'])?input('get.value'):exit('No value!');
		$trade_no = date("YmdHis").mt_rand(100000,999999);
		$name = config('web_name').'余额充值';
		if(config('zz_'.$type.'_api')==2)$epay=1;
		else $epay=0;
		if($type=='wxpay' && $epay==0){
			$res=wxpay_submit($value,$trade_no,$name);
			if($res["result_code"]=='SUCCESS'){
				$code_url=$res["code_url"];
			}else{
				exit('{"code":-1,"msg":"['.$res["err_code"].']'.$res["err_code_des"].'"}');
			}
		}elseif($type=='qqpay' && $epay==0){
			$res=qqpay_submit($value,$trade_no,$name);
			if(preg_match("!<token_id>(.*?)</token_id>!",$res,$match)){
				$code_url='https://myun.tenpay.com/mqq/pay/qrcode.html?_wv=1027&_bid=2183&t='.$match[1];
			}else{
				preg_match("!<err_info>(.*?)</err_info>!",$res,$match);
				exit('{"code":-1,"msg":"'.$match[1].'"}');
			}
		}else{
			$code_url=null;
		}
		$sqs=$this->pdo->execute("INSERT INTO `pre_pay` (`trade_no`, `type`, `uid`, `time`, `name`, `money`, `status`) VALUES (:trade_no, :type, :uid, NOW(), :name, :money, 0)", array(':trade_no' => $trade_no, ':type' => $type, ':uid' => $this->uid, ':name' => $name, ':money' => $value));
		if($sqs){
			$result=array('code'=>1,'type'=>$type,'epay'=>$epay,'money'=>$value,'trade_no'=>$trade_no,'name'=>$name,'code_url'=>$code_url);
		}else{
			$result=array('code'=>-1,'msg'=>'生成订单失败，请重试');
		}
		echo json_encode($result, true);
	}

	public function getshop()
    {
		$trade_no=isset($_POST['trade_no'])?input('post.trade_no'):exit('No trade_no!');
		$row = $this->pdo->find('select * from pre_pay where trade_no=:trade_no limit 1', array(':trade_no' => $trade_no));
		if(!$row){
			exit('{"code":-1,"msg":"订单号不存在"}');
		}
		if($row['type']=='wxpay' && config('zz_wxpay_api')==1){
			$data=wxpay_query($trade_no);
			if($data['return_code']=='SUCCESS' && $data['result_code']=='SUCCESS'){
				if($data['trade_state']=='SUCCESS'){
					if($row['status']==0){
						$this->pdo->execute('update pre_pay set status=1 where trade_no=:trade_no limit 1', array(':trade_no' => $row['trade_no']));
						$this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ":point" => $row['money']));
						exit('{"code":2,"msg":"付款成功"}');
					}else{
						exit('{"code":2,"msg":"已经购买过"}');
					}
				}else{
					$msg='['.$data['trade_state'].']'.$data['trade_state_desc'];
					exit('{"code":1,"msg":"'.$msg.'"}');
				}
			}else{
				$msg='['.$data['err_code'].']'.$data['err_code_des'];
				exit('{"code":-1,"msg":"'.$msg.'"}');
			}
		}else{
			if($row['status']==1){
				exit('{"code":2,"msg":"付款成功"}');
			}else{
				exit('{"code":1,"msg":"未付款"}');
			}
		}
	}

	public function chat($do=null)
    {
		if($do=='look'){
			$id=isset($_POST['id'])?intval($_POST['id']):'1';
			if($id==1){
				exit('{"code":-1,"msg":"没有更多聊天内容了！"}');
			}
			$list = $this->pdo->selectAll("select * from pre_chats where id<:id and zid=:zid order by id desc limit 10",array(':id' => $id, ':zid' => ZID));
			if($this->userInfo['power']==9){
				for($i=0;$i<count($list);$i++){
					$list[$i]['message'].='&nbsp;[<a href="#" onclick="deleteid(\''.$list[$i]['id'].'\')">删</a>]';
				}
			}
			$array['code']=0;
			$array['data']=$list;
			exit(json_encode($array));
		}elseif($do=='new'){
			$id=isset($_POST['id'])?intval($_POST['id']):'1';
			$list = $this->pdo->selectAll("select * from pre_chats where id>:id and zid=:zid order by id desc limit 10",array(':id' => $id, ':zid' => ZID));
			if($this->userInfo['power']==9){
				for($i=0;$i<count($list);$i++){
					$list[$i]['message'].='&nbsp;[<a href="#" onclick="deleteid(\''.$list[$i]['id'].'\')">删</a>]';
				}
			}
			$array['code']=0;
			$array['data']=$list;
			exit(json_encode($array));
		}elseif($do=='send'){
			/****发言限制设定****/
			$timelimit = 600; //时间周期(秒)
			$iplimit = 3; //相同用户在1个时间周期内限制发言的次数

			$id=isset($_POST['id'])?intval($_POST['id']):'1';
			$message=strip_tags(input('post.content'));
			if(!$message) {
				exit('{"code":-2,"msg":"聊天内容不能为空！"}');
			} elseif (strlen($message) < 3) {
				exit('{"code":-2,"msg":"聊天内容太短！"}');
			} elseif (!$this->checkChat($message)) {
				$this->assign('alert', sweetAlert('发送失败', '对不起，你的聊天内容含有敏感词汇！', 'warning'));
			}
			$timelimits=date("Y-m-d H:i:s",time()-$timelimit);
			$ipcount=$this->pdo->getCount("SELECT id FROM pre_chats WHERE `addtime`>'$timelimits'");
			if($ipcount>=$iplimit && $this->userInfo['power']<9) {
				exit('{"code":-3,"msg":"你的发言速度太快了，请休息一下稍后重试。"}');
			}
			$message=htmlspecialchars($message, ENT_QUOTES);
			if (!$this->pdo->execute("INSERT INTO `pre_chats` (`zid`, `user`, `qq`, `message`, `addtime`) VALUES (:zid, :user, :qq, :message, NOW())", array(':zid' => ZID, ':user' => $this->userInfo['user'], ':qq' => $this->userInfo['qq'], ':message' => $message))) {
				exit('{"code":-1,"msg":"发送失败，请稍后再试！"}');
			}
			$list = $this->pdo->selectAll("select * from pre_chats where id>:id and zid=:zid order by id desc limit 10",array(':id' => $id, ':zid' => ZID));
			if($this->userInfo['power']==9){
				for($i=0;$i<count($list);$i++){
					$list[$i]['message'].='&nbsp;[<a href="#" onclick="deleteid(\''.$list[$i]['id'].'\')">删</a>]';
				}
			}
			$array['code']=0;
			$array['data']=$list;
			exit(json_encode($array));
		}elseif($do=='delete'){
			if($this->userInfo['power']==9){
				$id=isset($_POST['id'])?intval($_POST['id']):'1';
				$sql=$this->pdo->execute("delete from pre_chats where id=:id and zid=:zid limit 1", array(':id' => $id, ':zid' => ZID));
				if($sql){
					$array['code']=0;
					$array['msg']='删除成功！';
				}else{
					$array['code']=-1;
					$array['msg']='删除失败！';
				}
			}else{
				$array['code']=-2;
				$array['msg']='你没有权限！';
			}
			exit(json_encode($array));
		}
	}

	private function checkChat($message)
    {
        $strs = config('zz_chat_stop');
        if ($strs) {
            $strs = explode(',', $strs);
            foreach ($strs as $str) {
                if (strpos($message, trim($str))!==false) {
                    return false;
                }
            }
        }
        return true;
    }

    protected function klsfCurl($_url,$_post,$ists = false)
    {
        $arr = klsfCurl($_url,$_post);
        if(isset($arr['code'])){
            return $arr;
        }else{
            $this->alert(sweetAlert('网络异常','网络异常，请稍候再试！','warning'));
        }
    }
    /**
     * 弹出警告
     * @param $_msg
     */
    private function alert($_msg)
    {
        exit($_msg);
    }

    /**
     * 移除某个元素
     * @param $_id
     */
    private function remove($_id)
    {
        exit("$('{$_id}').remove();");
    }

    function __construct()
    {
        parent::__construct();
        if (empty($this->userInfo)){
            $this->alert(sweetAlert('温馨提示','请先登录','warning'));
        }
    }
}