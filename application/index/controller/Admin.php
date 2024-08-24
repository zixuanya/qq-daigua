<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/28
// +----------------------------------------------------------------------


namespace app\index\controller;


use app\util\Page;
use think\Cookie;

class Admin extends Common
{
    public function setDhbl()
    {
        $this->isSuper();
        if (IS_POST) {
            $sql = "insert into pre_configs set `vkey`=:vkey,`value`=:value on duplicate key update `value`=:value";
            foreach ($_POST as $k => $value) {
                $this->pdo->execute($sql, array(':vkey' => $k, ':value' => $value));
            }
            $this->assign('alert', sweetAlert('保存成功', '保存成功', 'success', url('setDhbl')));
        }
        $this->assign('webTitle', '设置元宝兑换比例');
        return $this->fetch();
    }

    public function selectMb()
    {
        if (IS_POST){
            $mb = input('post.mb');
            $mbArr = array('mb'=>$mb);
            @file_put_contents(APP_PATH.'index/mb.php','<?php'.PHP_EOL.'return '.var_export($mbArr,true).';'.PHP_EOL.PHP_EOL.'?>');
            $this->assign('alert', sweetAlert('更改成功', '模板更改成功！', 'success',url('selectMb')));
        }
        $mbList = $this->getDir(APP_PATH . 'index/');
        $this->assign('mbList',$mbList);
        $this->assign('xzmb',VIEW_LAYER);

        $this->assign('webTitle', '选择模板');
        return $this->fetch();
    }

    private function getDir($dir)
    {
        $dirArray[] = NULL;
        if (false != ($handle = opendir($dir))) {
            $i = 0;
            while (false !== ($file = readdir($handle))) {
                //去掉"“.”、“..”以及带“.xxx”后缀的文件
                if ($file != "." && $file != ".." && $file != "controller" && !strpos($file, ".")) {
                    $dirArray[$i] = $file;
                    $i++;
                }
            }
            //关闭句柄
            closedir($handle);
        }
        return $dirArray;
    }

    public function import()
    {
        $this->isSuper();
        $kind = input('get.kind');
        if ($kind == 'bh') {
            $title = '登录保护';
            $zt = 3;
        } elseif ($kind == 'dj') {
            $title = '账号冻结';
            $zt = 2;
        } else {
            $title = '密码错误';
            $zt = 1;
        }
        if (IS_POST) {
            $qqs = input('post.qqs');
            $list = '';
            $num = 0;
            if ($_FILES["qqfile"]["error"] == 0) {
                $qqs .= '||' . file_get_contents($_FILES["qqfile"]["tmp_name"]);
            }
            if ($qqs) {
                if (preg_match_all('/\d{5,11}/', $qqs, $arr)) {
                    $list = implode(',', array_unique($arr[0]));
                }
            }
            $list = trim($list, ',');
            if ($list) {
                $num = $this->pdo->execute("update pre_qqs set zt={$zt} where uin in ({$list})");
                $this->assign('alert', sweetAlert('导入成功', '成功更改' . $num . '个QQ的状态！', 'success'));
            }
        }

        $this->assign('title', $title);
        $this->assign('webTitle', '数据导入');
        return $this->fetch();
    }

    public function xz($tid)
    {
        $this->isSuper();
        $type = input('get.type');
        $tid = intval($tid);
        if (!$tool = $this->pdo->find("select * from pre_tools where tid=:tid limit 1", array(':tid' => $tid))) {
            $this->assign('alert', sweetAlert('温馨提示', '该项目不存在！', 'warning', url('index')));
            return $this->fetch('common/sweetalert');
        }
        if ($type == 'all') {
            $filename = $tool['name'] . '_all.txt';
            $stmt = $this->pdo->getStmt("select b.uin,b.pwd,a.zt,a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt != 2 order by a.id desc");
        } else {
            $filename = $tool['name'] . '_bu.txt';
            $stmt = $this->pdo->getStmt("select b.uin,b.pwd,a.zt,a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt = 1 order by a.id desc");
        }
        $txt = '';
        while ($row = $stmt->fetch()) {
            if ($row['zt'] == 1) {
                $this->pdo->execute("update pre_orders set zt=0 where id={$row['id']} limit 1");
            }
            $txt .= $row['uin'] . '----' . $row['pwd'] . "\r\n";
        }
		$file_size = strlen($txt);
		header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
		header("Content-Length: {$file_size}");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo $txt;
        exit();
    }

    public function export($tid)
    {
        $this->isSuper();
        $tid = intval($tid);
        if (!$tool = $this->pdo->find("select * from pre_tools where tid=:tid limit 1", array(':tid' => $tid))) {
            $this->assign('alert', sweetAlert('温馨提示', '该项目不存在！', 'warning', url('index')));
            return $this->fetch('common/sweetalert');
        }
        $amount['all'] = $this->pdo->getCount("select id from pre_orders where tid={$tid} and endtime>NOW() and zt!=2");
        $amount['can'] = $this->pdo->getCount("select a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt != 2");
        $amount['bu'] = $this->pdo->getCount("select a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid where a.tid={$tid} and b.zt=0 and a.endtime>NOW() and a.zt = 1");
        $this->assign('tool', $tool);
        $this->assign('amount', $amount);
        $this->assign('webTitle', $tool['name'] . '-数据导出');
        return $this->fetch();
    }

    public function ktfz()
    {
        if (ZID != 1 && !config('web_super')) {
            $this->assign('alert', $this->sweetAlert('无权限', '无权限！', 'warning', url('index')));
            exit($this->fetch('common/$this->sweetAlert'));
        }

        if (IS_POST) {
            $uid = input('post.uid/d');
            $qz = input('post.qz');
            $domain = input('post.domain');
            $name = input('post.name');
            $qq = input('post.qq');
			$type = input('post.type/d');
            $domain = $qz . '.' . $domain;
			$super = 0;
            if ($type == 1 && (config('web_super')==2 || ZID==1)) {
                $super = 1;


            }elseif ($type == 2 && ZID > 1) {
				$super = 2;
                        }elseif ($type == 3 && ZID > 1) {
				$super = 3;
			}elseif ($type == 4 && ZID == 1) {
				$super = 4;
			}
            if (!$user = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $uid))) {
                $this->assign('alert', sweetAlert('温馨提示', '用户不存在！', 'warning'));
            } elseif (strlen($qz) < 2 || strlen($qz) > 10) {
                $this->assign('alert', sweetAlert('温馨提示', '域名前缀不合格！', 'warning'));
            } elseif (strlen($name) < 2) {
                $this->assign('alert', sweetAlert('温馨提示', '网站名称太短！', 'warning'));
            } elseif (strlen($qq) < 5) {
                $this->assign('alert', sweetAlert('温馨提示', 'QQ格式不正确！', 'warning'));
            } elseif ($this->pdo->find("select zid from pre_webs where domain=:domain or domain2=:domain limit 1", array(':domain' => $domain))) {
                $this->assign('alert', sweetAlert('温馨提示', '此前缀已被使用！', 'warning'));
            } elseif ($user['power'] == 9) {
                $this->assign('alert', sweetAlert('温馨提示', '用户已经是站长，不能再开通分站！', 'warning'));
            }elseif (ZID != 1 && $user['zid'] != ZID){
                $this->assign('alert', sweetAlert('温馨提示', '此用户不属于你站点，无权为他开通分站！', 'warning'));
            } else {
                $endtime = date("Y-m-d H:i:s", strtotime("+ 12 months", time()));
                if ($this->pdo->execute("INSERT INTO `pre_webs` (`upzid`, `super`, `uid`, `domain`, `qq`, `name`, `price_dx`, `price_all`, `price_vip`, `price_ktfz`, `addtime`, `endtime`) VALUES ('" . ZID . "', :super, '" . $uid . "', :domain, :qq, :name, :price_dx, :price_all, :price_vip, :price_ktfz, NOW(), :endtime)", array(':domain' => $domain, ':name' => $name, ':qq' => $qq, ':endtime' => $endtime, ':super'=>$super, ':price_dx'=>config('web_price_dx'), ':price_all'=>config('web_price_all'), ':price_vip'=>config('web_price_vip'), ':price_ktfz'=>config('web_price_ktfz')))) {
                    $row = $this->pdo->find("select zid from pre_webs where domain=:domain and qq=:qq limit 1", array(':domain' => $domain, ':qq' => $qq));
                    $this->pdo->execute("update pre_users set zid=:zid,power=9 where uid=:uid limit 1", array(':zid' => $row['zid'], ':uid' => $uid));
                    $this->assign('alert', sweetAlert("分站开通成功", "分站开通成功！", "success", url('webList')));
                    return $this->fetch('common/sweetalert');
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '开通失败，请稍后再试！', 'warning'));
                }
            }
        }elseif(IS_AJAX){
			$qz = strtolower(input('get.qz'));
            $domain = input('get.domain');
			$domain = $qz . '.' . $domain;
			if($this->pdo->find("select zid from pre_webs where domain=:domain or domain2=:domain limit 1", array(':domain' => $domain))){
				exit('1');
			}else{
				exit('0');
			}
		}
        $this->assign('domains', explode(',', config('zz_domains')));
        $this->assign('webTitle', '快速开通分站');
        return $this->fetch();
    }

    public function priceSet()
    {
        if (IS_POST) {
			$sp = input('post.sp');
            if ($sp == 'all') {
                $price = config('zz_price_all');
            } elseif ($sp == 'dx') {
                $price = config('zz_price_dx');
            } elseif ($sp == 'vip') {
				$price = 0;
			}
            $p0 = input('post.p0');
            $p1 = input('post.p1');
            $p2 = input('post.p2');
            $p3 = input('post.p3');
            $p4 = input('post.p4');
            $p5 = input('post.p5');
            if (!is_numeric($p0) || $p0 < $price) $p0 = $price;
            if (!is_numeric($p1) || $p1 < $price) $p1 = $price;
            if (!is_numeric($p2) || $p2 < $price) $p2 = $price;
            if (!is_numeric($p3) || $p3 < $price) $p3 = $price;
            if (!is_numeric($p4) || $p4 < $price) $p4 = $price;
            if (!is_numeric($p5) || $p5 < $price) $p5 = $price;
			if ($sp == 'all') {
				$vkey = 'price_all';
                $value = $p0.'|'.$p1.'|'.$p2.'|'.$p3.'|'.$p4.'|'.$p5;
            } elseif ($sp == 'dx') {
				$vkey = 'price_dx';
                $value = $p0.'|'.$p1.'|'.$p2.'|'.$p3.'|'.$p4.'|'.$p5;
            } elseif ($sp == 'vip') {
				$vkey = 'price_vip';
				$value = $p1.'|'.$p2.'|'.$p3.'|'.$p4.'|'.$p5;
			}

            $this->pdo->execute("update pre_webs set {$vkey}=:value where zid=:zid", array(':value' => $value, ':zid' => ZID));

            $this->assign('alert', sweetAlert('保存成功', '保存成功', 'success', url('priceSet')));
        }

        $this->assign('pall', explode("|",config('web_price_all')));
        $this->assign('pdx', explode("|",config('web_price_dx')));
		$this->assign('pvip', explode("|",config('web_price_vip')));

        $this->assign('webTitle', '代挂价格设置');
        return $this->fetch();
    }


    public function webList()
    {
        if(ZID!=1 && config('web_super')==0){
			$this->assign('alert', sweetAlert('无权限', '需要主站站长权限！', 'warning', url('index')));
            exit($this->fetch('common/sweetalert'));
		}
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'cz') {
                $uid = input('post.uid/d');
                $point = input('post.point');
                //if ($point < 1) $point = 1;
				if ($point < 0 || !is_numeric($point)) {
					$this->assign('alert', sweetAlert('温馨提示', "充值余额不能为负！", 'warning'));
					return $this->fetch('common/sweetalert');
				}
                if (ZID != 1 && $this->userInfo['point'] < $point) {
                    $this->assign('alert', sweetAlert('温馨提示', '账户余额不足，请充值！', 'warning'));
                } else {
                    if (ZID != 1) {
                        $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $point));
                    }
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $uid, ':point' => $point));
                    //记录充值
                    $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => '充值', ':bz' => '站长后台为你充值' . $point . '元！'));

                    $this->assign('alert', sweetAlert('充值成功', '充值成功！', 'success'));
                }
            }
        }

        $action = input('get.action');
        if ($action == 'del') {
            $zid = input('get.zid/d');
            if ($zid == 1) $zid = 0;
			if (ZID != 1) {
				if ($user = $this->pdo->find("select uid from pre_webs where zid=:zid and upzid=:upzid limit 1", array(':zid' => $zid, ':upzid' => ZID))) {
					$this->pdo->execute("delete from pre_webs where zid=:zid limit 1", array(':zid' => $zid));
					$this->pdo->execute("update pre_users set power=0,zid=1 where uid=:uid limit 1", array(':uid' => $user['uid']));
					$this->pdo->execute("update pre_users set zid=:upzid where zid=:zid and power<9", array(':zid' => $zid, ':upzid' => ZID));
				}
			}else{
				if ($user = $this->pdo->find("select uid from pre_webs where zid=:zid limit 1", array(':zid' => $zid))) {
					$this->pdo->execute("delete from pre_webs where zid=:zid limit 1", array(':zid' => $zid));
					$this->pdo->execute("update pre_users set power=0,zid=1 where uid=:uid limit 1", array(':uid' => $user['uid']));
					$this->pdo->execute("update pre_users set zid=1 where zid=:zid and power<9", array(':zid' => $zid));
				}
			}
            $this->assign('alert', sweetAlert('删除成功', '删除成功！', 'success', 'REFERER'));
        }

		if (ZID != 1) {
			$pageList = new Page($this->pdo->getCount("select zid from pre_webs where upzid=".ZID), 10);
			$webList = $this->pdo->selectAll("select a.*,b.point from pre_webs as a left join pre_users as b on b.uid=a.uid where a.upzid=".ZID." order by a.zid desc " . $pageList->limit);
		}else{
			$pageList = new Page($this->pdo->getCount("select zid from pre_webs"), 10);
			$webList = $this->pdo->selectAll("select a.*,b.point from pre_webs as a left join pre_users as b on b.uid=a.uid order by a.zid desc " . $pageList->limit);
		}
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
				if (ZID != 1) {
					$pageList = new Page($this->pdo->getCount("select zid from pre_webs where (name like '%{$s}%' or qq like '%{$s}%' or domain like '%{$s}%' or domain2 like '%{$s}%') and upzid=".ZID), 10);
					$webList = $this->pdo->selectAll("select a.*,b.point from pre_webs as a left join pre_users as b on b.uid=a.uid where (a.name like '%{$s}%' or a.domain like '%{$s}%' or a.domain2 like '%{$s}%' or a.qq like '%{$s}%') and a.upzid=".ZID." order by a.zid desc " . $pageList->limit);
				}else{
					$pageList = new Page($this->pdo->getCount("select zid from pre_webs where name like '%{$s}%' or qq like '%{$s}%' or domain like '%{$s}%' or domain2 like '%{$s}%' "), 10);
					$webList = $this->pdo->selectAll("select a.*,b.point from pre_webs as a left join pre_users as b on b.uid=a.uid where a.name like '%{$s}%' or a.domain like '%{$s}%' or a.domain2 like '%{$s}%' or a.qq like '%{$s}%' order by a.zid desc " . $pageList->limit);
				}
            }
        }

        $this->assign('webList', $webList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '分站列表');
        return $this->fetch();
    }

    public function userInfo($uid)
    {
        if (ZID == 1) {
            $where = '((zid=:zid and power<9) or zid != 1)';
        } else {
            $where = 'zid=:zid and power<9';
        }
        $uid = intval($uid);
        if (!$user = $this->pdo->find("select * from pre_users where {$where} and uid=:uid limit 1", array(':zid' => ZID, ':uid' => $uid))) {
            $this->assign('alert', sweetAlert('温馨提示', '用户不存在！', 'warning', 'REFERER'));
            return $this->fetch('common/sweetalert');
        }
        if (IS_POST) {
            $qq = input('post.qq');
            $pwd = input('post.pwd');
            if ($pwd && strlen($pwd) < 5) {
                $this->assign('alert', sweetAlert('温馨提示', '新密码太简单！', 'warning'));
            } else {
                if ($pwd) {
                    $pwd = getPwd($pwd);
                } else {
                    $pwd = $user['pwd'];
                }
                if ($this->pdo->execute('update pre_users set qq=:qq,pwd=:pwd where uid=:uid limit 1', array(':qq' => $qq, ':pwd' => $pwd, ':uid' => $uid))) {
                    $this->assign('alert', sweetAlert('更新成功', '修改成功！', 'success', url('userInfo', ['uid' => $uid])));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '修改失败,请稍候再试！', 'warning'));
                }
            }
        }
        $this->assign('user', $user);
        $this->assign('webTitle', $user['user'] . '-用户详情');
        return $this->fetch();
    }

    public function kmList()
    {
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'add') {
                $value = input('post.value/d');
                $num = input('post.num/d');
                if ($value < 1 || $value > 1000) {
                    $this->assign('alert', sweetAlert('温馨提示', '金额数不符合要求！', 'warning'));
                } elseif ($num > 100) {
                    $this->assign('alert', sweetAlert('温馨提示', '生成数量不能大于100！', 'warning'));
                } else {
                    $kms = '';
                    for ($i = 0; $i < $num; $i++) {
                        $km = getRandStr(16);
                        if ($this->userInfo['point'] < $value && ZID != 1) {
                            $kms .= '<font color="red">点数不足，请充值！</font>';
                            $this->assign('alert', sweetAlert('温馨提示', '剩余余额不足，请充值！', 'warning'));
                            break;
                        }
                        if ($this->pdo->execute("INSERT INTO `pre_kms` (`zid`, `uid`, `km`, `value`, `addtime`) VALUES (:zid, :uid, :km, :value, NOW())", array(':zid' => ZID, ':uid' => $this->uid, ':km' => $km, ':value' => $value))) {
                            //扣点数
                            if (ZID != 1) {
                                $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $value));
                                $this->userInfo['point'] = $this->userInfo['point'] - $value;
                            }
                            $kms .= $km . '<br>';
                        }
                    }
                    $this->assign('userInfo', $this->userInfo);
                    $this->assign('kms', $kms);
                }
            }
        }

        $action = input('get.action');
        if ($action == 'del') {
            $kid = input('get.kid/d');
            if ($row = $this->pdo->find("select * from pre_kms where uid=:uid and kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $kid))) {
                if (!$row['useid']) {
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $row['value']));
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']},由于该卡密未使用，已退回{$row['value']}元至你账户！", 'success', 'REFERER'));
                } else {
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']}！", 'success', 'REFERER'));
                }
                $this->pdo->execute("delete from pre_kms where uid=:uid and kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $kid));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '要删除的卡密已不存在！', 'warning', 'REFERER'));
            }
        } elseif ($action == 'clean') {
			$this->pdo->execute("delete from pre_kms where uid=:uid and useid!=0", array(':uid' => $this->uid));
			$this->assign('alert', sweetAlert('清空成功', "已清空所有已使用的卡密！", 'success', 'REFERER'));
		}
        //获取卡密列表
        $pageList = new Page($this->pdo->getCount("select kid from pre_kms where uid=:uid", array(':uid' => $this->uid)), 20);
        $kmList = $this->pdo->selectAll("select * from pre_kms where uid=:uid order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select kid from pre_kms where uid=:uid and km like '%{$s}%'", array(':uid' => $this->uid)), 20);
                $kmList = $this->pdo->selectAll("select * from pre_kms where uid=:uid and km like '%{$s}%' order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
            }
        }


        $this->assign('kmList', $kmList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '余额卡密列表');
        return $this->fetch();
    }

    public function userList($type = 'all')
    {
        if (ZID == 1) {
            $where = '((zid=:zid and power<9) or zid != 1)';
        } else {
            $where = 'zid=:zid and power<9';
        }


        $action = input('param.action');
        if ($action == 'del') {
            $uid = input('get.uid/d');
            $this->pdo->execute("delete from pre_users where uid=:uid and {$where} limit 1", array(':uid' => $uid, ':zid' => ZID));
            $this->assign('alert', sweetAlert('删除用户成功', '删除用户成功！', 'success', 'REFERER'));
        }

        if (IS_POST) {
            if ($action == 'cz') {
                $uid = input('post.uid/d');
                $point = input('post.point');
                if ($point < 0 || !is_numeric($point)) {
					$this->assign('alert', sweetAlert('温馨提示', "充值余额不能为负！", 'warning'));
					return $this->fetch('common/sweetalert');
				}
                if (ZID != 1 && $this->userInfo['point'] < $point) {
                    $this->assign('alert', sweetAlert('温馨提示', '账户可用余额不足，请充值！', 'warning'));
                } else {
                    if (ZID != 1) {
                        $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':point' => $point, ':uid' => $this->uid));
                    }
                    $this->pdo->execute("update pre_users set point=point+:point where {$where} and uid=:uid limit 1", array(':zid' => ZID, ':point' => $point, ':uid' => $uid));
                    //记录充值记录
                    $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => '充值', ':bz' => '站长后台为你充值' . $point . '金币！'));
                    $this->assign('alert', sweetAlert('充值成功', "为用户UID:{$uid}成功充值{$point}元！", 'warning'));
                }
            }elseif ($action == 'kc') {
				$this->isSuper();
                $uid = input('post.uid/d');
                $point = input('post.point');
				//if (ZID != 1) {
				//	$this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':point' => $point, ':uid' => $this->uid));
				//}
				$this->pdo->execute("update pre_users set point=point-:point where {$where} and uid=:uid limit 1", array(':zid' => ZID, ':point' => $point, ':uid' => $uid));
				//记录充值记录
				$this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => '扣除', ':bz' => '站长后台为你扣除' . $point . '金币！'));
				$this->assign('alert', sweetAlert('扣除成功', "为用户UID:{$uid}成功扣除{$point}元！", 'warning'));
            }elseif ($action == 'czyb') {
                $uid = input('post.uid/d');
                $point = input('post.point');
                if ($point < 1) $point = 1;
                if (ZID != 1 && $this->userInfo['coin'] < $point) {
                    $this->assign('alert', sweetAlert('温馨提示', '账户可用元宝不足，请充值！', 'success'));
                } else {
                    if (ZID != 1) {
                        $this->pdo->execute("update pre_users set coin=coin-:point where uid=:uid limit 1", array(':point' => $point, ':uid' => $this->uid));
                    }
                    $this->pdo->execute("update pre_users set coin=coin+:point where {$where} and uid=:uid limit 1", array(':zid' => ZID, ':point' => $point, ':uid' => $uid));
                    //记录充值记录
                    $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => '充值', ':bz' => '站长后台为你充值' . $point . '元宝！'));
                    $this->assign('alert', sweetAlert('充值成功', "为用户UID:{$uid}成功充值{$point}元宝！", 'warning'));
                }
            }elseif ($action == 'daili'){
                $power = input('post.power/d');
                $uid = input('post.uid');
				if (ZID == 1) {
					$this->pdo->execute("update pre_users set power=:power where uid=:uid limit 1",array(':uid'=>$uid,':power'=>$power));
				}else{
					$this->pdo->execute("update pre_users set power=:power where uid=:uid and zid=:zid limit 1",array(':uid'=>$uid,':power'=>$power,':zid'=>ZID));
				}
                $this->assign('alert', sweetAlert('设置成功', "设置成功", 'success'));
            }
        }

        //获取用户列表
        if ($type == 'daili') {
            $pageList = new Page($this->pdo->getCount("select uid from pre_users where zid=:zid and power > 1 and power < 9", array(':zid' => ZID)), 10);
            $userList = $this->pdo->selectAll("select * from pre_users where zid=:zid and power > 1 and power < 9 order by uid desc " . $pageList->limit, array(':zid' => ZID));
        } else {
            $pageList = new Page($this->pdo->getCount("select uid from pre_users where {$where}", array(':zid' => ZID)), 10);
            $userList = $this->pdo->selectAll("select * from pre_users where {$where} order by uid desc " . $pageList->limit, array(':zid' => ZID));
        }

		if (IS_POST) {
            if ($action == 'search') {
                $s = input('post.s');
                if ($type == 'daili') {
                    $pageList = new Page($this->pdo->getCount("select uid from pre_users where zid=:zid and power = 1 and (uid='{$s}' or user like '%{$s}%' or qq like '%{$s}%')", array(':zid' => ZID)), 10);
                    $userList = $this->pdo->selectAll("select * from pre_users where zid=:zid and power = 1 and (uid='{$s}' or user like '%{$s}%' or qq like '%{$s}%') order by uid desc " . $pageList->limit, array(':zid' => ZID));
                } else {
                    $pageList = new Page($this->pdo->getCount("select uid from pre_users where {$where} and (uid='{$s}' or user like '%{$s}%' or qq like '%{$s}%')", array(':zid' => ZID)), 10);
                    $userList = $this->pdo->selectAll("select * from pre_users where {$where} and (uid='{$s}' or user like '%{$s}%' or qq like '%{$s}%') order by uid desc " . $pageList->limit, array(':zid' => ZID));
                }
            }
        }

        $this->assign('pageList', $pageList);
        $this->assign('userList', $userList);
        $this->assign('webTitle', '用户列表');
        return $this->fetch();
	}

	public function qqList($type = 'all')
    {
        $this->isSuper();

        $action = input('param.action');
        if ($action == 'del') {
            $qid = input('get.qid/d');
            $this->pdo->execute("delete from pre_qqs where qid=:qid limit 1", array(':qid' => $qid));
            $this->assign('alert', sweetAlert('删除QQ成功', '删除QQ成功！', 'success', 'REFERER'));
        }

        $pageList = new Page($this->pdo->getCount("select uid from pre_qqs where 1"), 10);
        $qqList = $this->pdo->selectAll("select * from pre_qqs where 1 order by qid desc " . $pageList->limit);


        if (IS_POST) {
            if ($action == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select uid from pre_qqs where uin='{$s}' or uid='{$s}'"), 10);
                $qqList = $this->pdo->selectAll("select * from pre_qqs where uin='{$s}' or uid='{$s}' order by qid desc " . $pageList->limit);
            }
        }

        $this->assign('pageList', $pageList);
        $this->assign('qqList', $qqList);
        $this->assign('webTitle', 'ＱＱ列表');
        return $this->fetch();
    }

    public function emailSet()
    {
        $this->isSuper();
        if (IS_POST) {
            $email = array();
			$email['email_cloud'] = input('post.email_cloud');
            $email['email_host'] = input('post.email_host');
            $email['email_port'] = input('post.email_port');
            $email['email_user'] = input('post.email_user')?input('post.email_user'):input('post.email_user2');
            $email['email_pwd'] = input('post.email_pwd');
			$email['email_apiuser'] = input('post.email_apiuser');
			$email['email_apikey'] = input('post.email_apikey');
            $email['email_nick'] = config('web_name');
            $send = sendEmail(config('web_qq') . '@qq.com', '测试邮箱配置!', '看到这封邮件，说明邮箱配置已成功！', $email);
            if ($send == 'success') {
                $sql = "insert into pre_configs set `vkey`=:vkey,`value`=:value on duplicate key update `value`=:value";
                foreach ($email as $k => $value) {
                    $this->pdo->execute($sql, array(':vkey' => $k, ':value' => $value));
                }
                $this->assign('alert', sweetAlert('保存成功', '保存成功', 'success', url('emailSet')));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', "邮箱配置不正确！{$send}", 'success'));
            }
        }
        $this->assign('webTitle', '邮箱配置');
        return $this->fetch();
    }

    public function webSet($zid = 0)
    {
        $zid = intval($zid);
        if ($zid) {
            $this->isSuper();
            if (!$web = $this->pdo->find("select * from pre_webs where zid=:zid limit 1", array(':zid' => $zid))) {
                $this->assign('alert', sweetAlert('温馨提示', '站点不存在！', 'warning', 'REFERER'));
                return $this->fetch('common/sweetalert');
            }
        } else {
            $web = $this->pdo->find("select * from pre_webs where zid=:zid limit 1", array(':zid' => ZID));
        }
        if (IS_POST) {
            $sql = "update pre_webs set ";
            $arr = array();
            $arr[':zid'] = $web['zid'];
            foreach ($_POST as $k => $v) {
				if (ZID != 1 && $k=='super' && $v==2)continue;
				if (ZID != 1 && config('web_super')!=2 && $k=='super')continue;
                $sql .= "{$k}=:{$k},";
                $arr[":{$k}"] = input("post.{$k}");
            }
			if(isset($arr[":price_ktfz"]) && $arr[":price_ktfz"]<=0) {
				$this->assign('alert', sweetAlert('温馨提示', '开通分站价格不能为负数！', 'warning', 'REFERER'));
				return $this->fetch('common/sweetalert');
			}
			/*$price_all=explode("|",str_replace("｜","|",trim($arr[":price_all"])));
			$price_dx=explode("|",str_replace("｜","|",trim($arr[":price_dx"])));
			$price_vip=explode("|",str_replace("｜","|",trim($arr[":price_vip"])));
			foreach($price_all as $row){
				if($row<config('zz_price_all')) {
					$this->assign('alert', sweetAlert('温馨提示', '全套代挂价格不得低于成本价格！', 'warning', 'REFERER'));
					return $this->fetch('common/sweetalert');
				}
			}
			foreach($price_dx as $row){
				if($row<config('zz_price_dx')) {
					$this->assign('alert', sweetAlert('温馨提示', '单向代挂价格不得低于成本价格！', 'warning', 'REFERER'));
					return $this->fetch('common/sweetalert');
				}
			}
			if($arr[":price_all"]<=$arr[":price_dx"]) {
                $this->assign('alert', sweetAlert('温馨提示', '全套代挂价格不得低于单项代挂价格！', 'warning', 'REFERER'));
                return $this->fetch('common/sweetalert');
            }*/
            $sql = trim($sql, ',');
            $sql .= " where zid=:zid limit 1";

            if ($this->pdo->execute($sql, $arr)) {
                $this->assign('alert', sweetAlert('保存成功', '保存成功！', 'success', 'REFERER'));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '保存失败，请稍候再试！', 'warning'));
            }
        }

        $this->assign('web', $web);
		$this->assign('zid', $zid);
        $this->assign('webTitle', '站点设置');
        return $this->fetch();
    }

    public function mainSet()
    {
        $this->isSuper();
        if (IS_POST) {
            $sql = "insert into pre_configs set `vkey`=:vkey,`value`=:value on duplicate key update `value`=:value";
            foreach ($_POST as $k => $value) {
                $this->pdo->execute($sql, array(':vkey' => $k, ':value' => $value));
            }
            $this->assign('alert', sweetAlert('保存成功', '保存成功', 'success', url('mainSet')));
        }
        $this->assign('webTitle', '主站设置');
        return $this->fetch();
    }

	public function appSet($zid = 0)
    {
		$zid = intval($zid);
		if ($zid) {
            $this->isSuper();
            if (!$web = $this->pdo->find("select * from pre_webs where zid=:zid limit 1", array(':zid' => $zid))) {
                $this->assign('alert', sweetAlert('温馨提示', '站点不存在！', 'warning', 'REFERER'));
                return $this->fetch('common/sweetalert');
            }
        } else {
            $web = $this->pdo->find("select * from pre_webs where zid=:zid limit 1", array(':zid' => ZID));
        }
		$app_conf = @unserialize($web['app_conf']);
        if (IS_POST) {
            $arr = array();
            $arr['app_version'] = input('post.app_version');
			$arr['app_url'] = input('post.app_url');
			$arr['app_log'] = input('post.app_log');
			$arr['app_start_is'] = input('post.app_start_is');
			$arr['app_start'] = input('post.app_start');

            if ($this->pdo->execute("update pre_webs set app_conf=:app_conf where zid=:zid", array(':app_conf' => serialize($arr), ':zid' => $web['zid']))) {
                $this->assign('alert', sweetAlert('保存成功', '保存成功！', 'success', 'REFERER'));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '保存失败，请稍候再试！', 'warning'));
            }
        }

        $this->assign('app', $app_conf);
		$this->assign('zid', $zid);
        $this->assign('webTitle', 'APP设置');
        return $this->fetch();
    }

	public function paySet()
    {
        $this->isSuper();
        if (IS_POST) {
            $sql = "insert into pre_configs set `vkey`=:vkey,`value`=:value on duplicate key update `value`=:value";
            foreach ($_POST as $k => $value) {
                $this->pdo->execute($sql, array(':vkey' => $k, ':value' => $value));
            }
            $this->assign('alert', sweetAlert('保存成功', '保存成功', 'success', url('paySet')));
        }
        $this->assign('webTitle', '在线支付配置');
        return $this->fetch();
    }
	public function syskey()
    {
        $this->isSuper();
		$key=md5(SYS_KEY.md5(config('zz_cronkey')));
        $this->assign('alert', sweetAlert('代挂管家接口密钥查看', '密钥：'.$key.'\r\n提示：修改监控密钥可同时重置代挂管家接口密钥', 'success', url('mainset')));
		return $this->fetch('common/sweetalert');
    }

	private function addPointRecord($uid, $point = 0, $action = '消费', $bz = null)
    {
        $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => $action, ':bz' => $bz));
    }

	public function txxz()
    {
        $this->isSuper();
        $stmt = $this->pdo->getStmt("select a.*,b.pay_account,b.pay_name from pre_tixian as a left join pre_users as b on b.uid=a.uid where a.status=0 order by id desc ");

        $txt = '';
        while ($row = $stmt->fetch()) {
            $txt .= $row['pay_account'] . '----' . $row['pay_name'] . '----' . $row['realmoney'] . "\r\n";
        }
        $file_size = strlen($txt);
        header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
        header("Content-Length: {$file_size}");
        header("Content-Disposition: attachment; filename=tixian_".date("YmdHis").".txt");
        echo $txt;
        exit();
    }

	public function tixian()
    {
		if(!config('zz_tixian_rate')) {
			$this->assign('alert', sweetAlert('温馨提示', '当前站点未开放提现功能，如需开启，请管理员在后台主站配置里设置提现余额比例！', 'warning', 'REFERER'));
			return $this->fetch('common/sweetalert');
		}
		if (IS_POST) {
			$money = input('post.money/d');
			$realmoney = round($money*config('zz_tixian_rate')/100,2);
			if(empty($this->userInfo['pay_account'])||empty($this->userInfo['pay_name'])) {
				$this->assign('alert', sweetAlert('温馨提示', '您还未设置收款账号！', 'warning', url('panel/profile')));
				return $this->fetch('common/sweetalert');
			}
			if($money>$this->userInfo['point'] || $money<0) {
				$this->assign('alert', sweetAlert('温馨提示', '所输入的提现金额大于你所拥有的余额！', 'warning', 'REFERER'));
				return $this->fetch('common/sweetalert');
			}
			if($money<config('zz_tixian_min')) {
				$this->assign('alert', sweetAlert('温馨提示', '单笔提现金额不能低于'.config('zz_tixian_min').'元！', 'warning', 'REFERER'));
				return $this->fetch('common/sweetalert');
			}
			$this->pdo->execute("update pre_users set point=point-:point where uid=:uid", array(':uid' => $this->uid, ':point' => $money));
			$this->pdo->execute("INSERT INTO `pre_tixian` (`uid`, `money`, `realmoney`, `pay_account`, `pay_name`, `status`, `addtime`) VALUES (:uid, :money, :realmoney, :pay_account, :pay_name, '0', NOW())", array(':uid' => $this->uid, ':money' => $money, ':realmoney' => $realmoney, ':pay_account' => $this->userInfo['pay_account'], ':pay_name' => $this->userInfo['pay_name']));
			$this->addPointRecord($this->uid, $money, '提现', "申请提现{$money}元！");
			$this->assign('alert', sweetAlert('提现成功', '提现操作成功，本次实际提现金额:'.$realmoney.'元，请等待管理员人工转账！', 'success', url('tixian')));
            return $this->fetch('common/sweetalert');
		}
		$action = input('get.action');
		if($action == 'complete' && ZID==1){
			$id = input('get.id/d');
			$this->pdo->execute("update pre_tixian set status=1,endtime=NOW() where id=:id", array(':id' => $id));
			$this->assign('alert', sweetAlert('修改成功', "已变更为已提现状态", 'success', 'REFERER'));
		}elseif($action == 'reset' && ZID==1){
			$id = input('get.id/d');
			$this->pdo->execute("update pre_tixian set status=0,endtime=NULL where id=:id", array(':id' => $id));
			$this->assign('alert', sweetAlert('修改成功', "已变更为未提现状态", 'success', 'REFERER'));
		}elseif($action == 'del' && ZID==1){
			$id = input('get.id/d');
			$this->pdo->execute("delete from pre_tixian where id=:id", array(':id' => $id));
			$this->assign('alert', sweetAlert('删除成功', "已已删除此条提现记录", 'success', 'REFERER'));
		}
        //获取提现列表
		if(ZID==1){
			$pageList = new Page($this->pdo->getCount("select id from pre_tixian"), 20);
			$this->assign('List', $this->pdo->selectAll("select * from pre_tixian order by id desc"));
		}else{
			$pageList = new Page($this->pdo->getCount("select id from pre_tixian where uid=:uid", array(':uid' => $this->uid)), 20);
			$this->assign('List', $this->pdo->selectAll("select * from pre_tixian where uid=:uid order by id desc", array(':uid' => $this->uid)));
		}
		if (input('get.action')=='search' && ZID==1) {
			$s = input('get.value');
			$pageList = new Page($this->pdo->getCount("select id from pre_tixian"), 20);
			$txList = $this->pdo->selectAll("select a.*,b.zid,b.user,b.pay_account,b.pay_name from pre_tixian as a left join pre_users as b on b.uid=a.uid where a.pay_account like '%{$s}%' or a.pay_name like '%{$s}%' order by id desc " . $pageList->limit);
        }
		$this->assign('pageList', $pageList);
		$this->assign('tixian_fee', 100-config('zz_tixian_rate'));
        $this->assign('webTitle', '余额提现');
        return $this->fetch();
    }

	public function apicontrol()
    {
		//加载商品列表
        $this->assign('webTools', $this->pdo->selectAll("select * from pre_tools where tid !=1 order by tid asc"));

		if(IS_POST && $_POST['apply']==1){
			$this->pdo->execute("INSERT INTO `pre_apis` (`uid`, `apikey`, `active`, `time`) VALUES (:uid, :apikey, 1,NOW())", array(':uid' => $this->uid, ':apikey' => getSid()));
            $this->assign('alert', sweetAlert('申请APIKey成功', '申请APIKey成功', 'success', 'REFERER'));
        }
		if($row = $this->pdo->find("select * from pre_apis where uid=:uid limit 1", array(':uid' => $this->uid))){
			$this->assign('apirow', $row);
			$isapi=true;
		}else{
			$isapi=false;
		}
		$this->assign('isapi', $isapi);
        $this->assign('webTitle', 'API管理');
        return $this->fetch();
    }

	public function kami()
    {
		$power=$this->userInfo['power'];
		$price_all = explode("|",config('web_price_all'));
        $priceAll = isset($price_all[$power])&&$price_all[$power]>=config('zz_price_all') ? $price_all[$power] : config('zz_price_all');
		$this->assign('priceAll', $priceAll);
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'add') {
                $value = input('post.value/d');
                $num = input('post.num/d');
				$need = $priceAll * $num * $value;
                if ($value < 1 || $value > 12) {
                    $this->assign('alert', sweetAlert('温馨提示', '月数不能大于12个月！', 'warning'));
                } elseif ($num > 100) {
                    $this->assign('alert', sweetAlert('温馨提示', '生成数量不能大于100！', 'warning'));
                } elseif ($this->userInfo['point'] < $need) {
					$this->assign('alert', sweetAlert('温馨提示', '生成'.$num.'张卡密需要'.$need.'元，你当前只有'.$this->userInfo['point'].'元，请充值！', 'warning'));
				} else {
                    $kms = '';
                    for ($i = 0; $i < $num; $i++) {
                        $km = getRandStr(16);
                        if ($this->pdo->execute("INSERT INTO `pre_dgkms` (`zid`, `uid`, `km`, `value`, `addtime`) VALUES (:zid, :uid, :km, :value, NOW())", array(':zid' => ZID, ':uid' => $this->uid, ':km' => $km, ':value' => $value))) {
                            //扣余额
                            $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $priceAll * $value));
                            $this->userInfo['point'] = $this->userInfo['point'] - $priceAll * $value;
                            $kms .= $km . '<br>';
                        }
                    }
					$this->addPointRecord($this->uid, $need, '消费', "你生成全套代挂卡密消费了{$need}元！");
                    $this->assign('userInfo', $this->userInfo);
                    $this->assign('kms', $kms);
                }
            }
        }

        $action = input('get.action');
        if ($action == 'del') {
            $kid = input('get.kid/d');
            if ($row = $this->pdo->find("select * from pre_dgkms where uid=:uid and kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $kid))) {
                if (!$row['user']) {
					$backpoint=$priceAll*$row['value'];
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $backpoint));
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']},由于该卡密未使用，已退回{$backpoint}元至你账户！", 'success', 'REFERER'));
                } else {
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']}！", 'success', 'REFERER'));
                }
                $this->pdo->execute("delete from pre_dgkms where uid=:uid and kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $kid));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '要删除的卡密已不存在！', 'warning', 'REFERER'));
            }
        } elseif ($action == 'clean') {
			$this->pdo->execute("delete from pre_dgkms where uid=:uid and user!=0", array(':uid' => $this->uid));
			$this->assign('alert', sweetAlert('清空成功', "已清空所有已使用的卡密！", 'success', 'REFERER'));
		}
        //获取卡密列表
        $pageList = new Page($this->pdo->getCount("select kid from pre_dgkms where uid=:uid", array(':uid' => $this->uid)), 10);
        $kmList = $this->pdo->selectAll("select * from pre_dgkms where uid=:uid order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select kid from pre_dgkms where uid=:uid and km like '%{$s}%'", array(':uid' => $this->uid)), 10);
                $kmList = $this->pdo->selectAll("select * from pre_dgkms where uid=:uid and km like '%{$s}%' order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
            }
        }

        $this->assign('kmList', $kmList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '全套代挂卡密管理');
        return $this->fetch();
    }

    public function index()
    {
        //数据统计
        $amount['zuser'] = $this->pdo->getCount("select uid from pre_users");
        $amount['user'] = $this->pdo->getCount("select uid from pre_users where zid='" . ZID . "'");
        $amount['juser'] = $this->pdo->getCount("select uid from pre_users where zid='" . ZID . "' and TO_DAYS(regtime) = TO_DAYS(NOW())");
        $amount['zweb'] = $this->pdo->getCount("select zid from pre_webs");
        $amount['web'] = $this->pdo->getCount("select zid from pre_webs where upzid='" . ZID . "'");
        $amount['jweb'] = $this->pdo->getCount("select zid from pre_webs where upzid='" . ZID . "' and TO_DAYS(addtime) = TO_DAYS(NOW())");
        $amount['zorder'] = $this->pdo->getCount("select id from pre_orders");
        $amount['order'] = $this->pdo->getCount("select a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid left join pre_users as c on c.uid=b.uid where c.zid='" . ZID . "'");
        $amount['jorder'] = $this->pdo->getCount("select a.id from pre_orders as a left join pre_qqs as b on b.qid=a.qid left join pre_users as c on c.uid=b.uid where c.zid='" . ZID . "' and TO_DAYS(a.addtime) = TO_DAYS(NOW())");
        $amount['qq'] = $this->pdo->getCount("select a.qid from pre_qqs as a left join pre_users as b on b.uid=a.uid where b.zid='" . ZID . "'");
        $amount['jqq'] = $this->pdo->getCount("select a.qid from pre_qqs as a left join pre_users as b on b.uid=a.uid where b.zid='" . ZID . "' and TO_DAYS(a.addtime) = TO_DAYS(NOW())");

        $this->assign('amount', $amount);
        $this->assign('webTitle', '管理后台');
        return $this->fetch();
    }

    private function isSuper()
    {
        if (ZID != 1) {
            $this->assign('alert', sweetAlert('无权限', '需要主站站长权限！', 'warning', url('index')));
            exit($this->fetch('common/sweetalert'));
        }
    }

    private function isLogin()
    {

        $adminSid = Cookie::get("adminSid", "mzdg_");
        if ($adminSid !== null && $this->userInfo = $this->pdo->find("select * from pre_users where zid=:zid and power=9 and htsid=:sid limit 1", array(':zid' => ZID, ":sid" => $adminSid))) {
            $this->uid = $this->userInfo['uid'];
            $this->assign('userInfo', $this->userInfo);
        } else {
            $this->assign('alert', sweetAlert('请登录', '请先登录管理员账号！', 'warning', url('/index/Index/adminlogin')));
            exit($this->fetch('common/sweetalert'));
        }
    }

    function __construct()
    {
        parent::__construct();

        //判断是否已登录
        if (empty($this->userInfo) || $this->userInfo['power'] != 9) {
            $this->assign('alert', sweetAlert('无权限', '无权限！', 'warning', url('/index/Panel/index')));
            exit($this->fetch('common/sweetalert'));
        }
        //加载商品列表
        $this->assign('webTools', $this->pdo->selectAll("select * from pre_tools where tid !=1 order by tid asc"));

    }
}