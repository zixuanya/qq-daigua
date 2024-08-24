<?php
/**
 * Created by PhpStorm.
 * User: 烟雨寒云
 * Date: 2018/6/5
 * Time: 2:11
 * 水不撩不知深浅，人不拼怎知输赢！
 */
namespace app\index\controller;
use think\Cookie;
use app\util\Oauth;
use app\util\Page;
use think\Config;
class user extends Common {
    public function help() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $this->assign('webTitle', "帮助中心");
        return $this->fetch();
    }
    private function getHbPoint($point, $max) {
        if ($point < 1) {
            return 0;
        }
        if ($max > $point) {
            return rand(1, $point);
        }
        return rand(1, $max);
    }
    public function qiandao() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $isQd = false;
        if ($qdRow = $this->pdo->find("select num from pre_qiandaos where uid=:uid and TO_DAYS(qdtime)=TO_DAYS(NOW()) limit 1", array(
            ':uid' => $this->uid
        ))) {
            $isQd = true;
        }
        if ($row = $this->pdo->find("select num from pre_qiandaos where uid=:uid and TO_DAYS(NOW()) - TO_DAYS(qdtime) = 1 order by id desc limit 1", array(
            ':uid' => $this->uid
        ))) {
            $day = $row['num'];
        } else {
            $day = 0;
        }
        if ($isQd) {
            $day = $qdRow['num'];
        }
        $this->assign('day', $day);
        $rule = $this->qdRule();
        $num = config('zz_qiandao_num') ? config('zz_qiandao_num') : 999999;
        $this->assign('rule', $rule);
        $this->assign('num', $num);
        $this->assign('day', $day);
        if (!config('zz_qd')) {
          $this->assign('alert', yydgtc('温馨提示', '每日签到功能未开放！', 'warning', 'REFERER'));
        }
        if (IS_POST) {
            if ($isQd) {
                $this->assign('alert', yydgtc('温馨提示', "你今天已经签过到了！", 'warning', url('qiandao')));
            } else {
                $day++;
                $max = isset($rule['max']) ? $rule['max'] : 0;
                if ($day > $max) {
                    $point = $rule[$max];
                } else {
                    $point = $rule[$day];
                }
                $count = $this->pdo->getCount("select id from pre_qiandaos where TO_DAYS(qdtime)=TO_DAYS(NOW()) ");
                $this->pdo->execute("INSERT INTO `dg_qiandaos` (`uid`, `num`, `qdtime`) VALUES (:uid, :num, NOW())", array(
                    ':uid' => $this->uid,
                    ':num' => $day
                ));
                if ($count < $num) {
                    $count++;
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(
                        ':point' => $point,
                        ':uid' => $this->uid
                    ));
                    $this->addPointRecord($this->uid, $point, '签到', date("Y-m-d") . "-签到获取奖励！");
                    $this->assign('alert', yydgtc('签到成功', "你已连续签到{$day}天。恭喜你，你是今天第{$count}个签到的用户，特奖励你{$point}！", 'success', url('qiandao')));
                } else {
                    $this->assign('alert', yydgtc('签到成功', "你已连续签到{$day}天。很遗憾，你今天来晚了，没能领到奖励！", 'warning', url('qiandao')));
                }
            }
        }
        $this->assign('qdList', $this->pdo->selectAll("select a.*,b.user from pre_qiandaos as a left join pre_users as b on b.uid=a.uid order by a.id desc limit 10"));
        $this->assign('isQd', $isQd);
        $this->assign('webTitle', '每日签到');
        return $this->fetch();
    }
    private function qdRule() {
        if ($rows = explode(',', config('zz_qiandao_rule'))) {
            $array = array();
            foreach ($rows as $row) {
                if ($arr = explode(':', $row)) {
                    $key = trim($arr[0]);
                    $array["{$key}"] = trim($arr[1]);
                    $max = $key;
                }
            }
            if ($array) {
                $narr = array();
                $jf = 0;
                for ($i = 1; $i <= $max; $i++) {
                    if (isset($array[$i]) && ($num = $array[$i])) {
                        $narr[$i] = $num;
                        $jf = $num;
                    } else {
                        $narr[$i] = $jf;
                    }
                }
                $narr['max'] = $max;
                return $narr;
            } else {
                return array(
                    0,
                    1
                );
            }
        } else {
            return array(
                0,
                1
            );
        }
    }
    public function recharge() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $this->assign('webTitle', '余额充值');
        return $this->fetch();
    }
    public function shop() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $price_dx = explode("|", config('web_price_dx'));
        $price_all = explode("|", config('web_price_all'));
        $price_vip = explode("|", config('web_price_vip'));
        $action = input('get.action');
        $vipname = array(
            '普通用户',
            'VIP①',
            'VIP②',
            'VIP③',
            'VIP④',
            'VIP⑤',
            'VIP⑥',
            'VIP⑦',
            'VIP⑧',
            '站长'
        );
        if ($action == 'buy') {
            $id = input('get.id/d');
            $price = $price_vip[$id - 1];
            if ($id > count($price_vip)) {
                $this->assign('alert', yydgtc('温馨提示', '本站无此级别的VIP会员开通！', 'warning', 'REFERER'));
            } elseif ($id <= $this->userInfo['power']) {
                $this->assign('alert', yydgtc('温馨提示', '你现在已经是 ' . $vipname[$this->userInfo['power']] . ' 了，请勿重复开通或选择更高级别的VIP开通！', 'warning', 'REFERER'));
            } elseif ($price > $this->userInfo['point']) {
                $this->assign('alert', yydgtc('温馨提示', '您当前的余额不足，请充值！', 'warning', 'REFERER'));
            } else {
                $this->pdo->execute("update pre_users set point=point-:point,power=:power where uid=:uid limit 1", array(
                    ':uid' => $this->uid,
                    ':point' => $price,
                    ':power' => $id
                ));
                $this->addPointRecord($this->uid, $price, '消费', '购买' . $vipname[$id]);
                $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(
                    ':uid' => config('web_uid') ,
                    ":point" => $price
                ));
                $this->addPointRecord(config('web_uid') , $price, '获利', "你的站点用户{$this->uid}开通{$vipname[$id]}，你获得了{$price}利润！");
                $this->assign('alert', yydgtc('开通成功', "成功开通{$vipname[$id]}", 'success', url('shop')));
            }
        }
        foreach ($price_vip as $k => $v) {
            $data['id'] = $k + 1;
            $data['name'] = $vipname[$k + 1];
            $data['price_all'] = isset($price_all[$k + 1]) ? $price_all[$k + 1] : $price_all[0];
            $data['price_dx'] = isset($price_dx[$k + 1]) ? $price_dx[$k + 1] : $price_dx[0];
            $data['price_vip'] = $v;
            $viplist[] = $data;
        }
        $this->assign('viplist', $viplist);
        $this->assign('power', $vipname[$this->userInfo['power']]);
        $this->assign('webTitle', '开通vip');
        return $this->fetch();
    }
    public function profile() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        if (IS_POST) {
            $qq = input('post.qq');
            $pwd = input('post.pwd');
            if ($pwd && strlen($pwd) < 5) {
                $this->assign('alert', yydgtc('温馨提示', '新密码太简单！', 'warning', 'REFERER'));
            } else {
                if ($pwd) {
                    $pwd = getPwd($pwd);
                } else {
                    $pwd = $this->userInfo['pwd'];
                }
                if ($this->pdo->execute('update pre_users set qq=:qq,pay_account=:pay_account,pay_name=:pay_name,pwd=:pwd where uid=:uid limit 1', array(
                    ':qq' => $qq,
                    ':pwd' => $pwd,
                    ':pay_account' => input('post.pay_account') ,
                    ':pay_name' => input('post.pay_name') ,
                    ':uid' => $this->uid
                ))) {
                    $this->assign('alert', yydgtc('更新成功', '修改成功！', 'success', url('profile')));
                } else {
                    $this->assign('alert', yydgtc('温馨提示', '修改失败,请稍候再试！', 'warning', 'REFERER'));
                }
            }
        }
        $qqdl = $this->pdo->find("select access_token from pre_users where zid=:zid and uid=:uid limit 1", array(
            ':zid' => ZID,
            ":uid" => $this->uid
          ));
        if (empty($qqdl)) {
        	$amount['qqdl'] = 1;
        } else {
        	$amount['qqdl'] = 0;
        }
        $this->assign('amount', $amount);
        $this->assign('webTitle', '资料修改');
        return $this->fetch();
    }
    public function ktfz() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        if (config('web_super') == 1) {
            $this->assign('p0', config('web_price_ktfz'));
            $this->assign('p1', config('zz_price_ktfz_sec'));
            $this->assign('p2', config('zz_price_ktfz_sup'));
            $this->assign('p3', config('zz_price_ktfz_cp'));
            $this->assign('p4', config('zz_price_ktfz_da'));
        } elseif (config('web_super') == 2) {
            $this->assign('p0', config('web_price_ktfz'));
            $this->assign('p1', config('web_price_ktfz_sec'));
            $this->assign('p2', config('zz_price_ktfz_sup'));
            $this->assign('p3', config('zz_price_ktfz_cp'));
            $this->assign('p4', config('zz_price_ktfz_da'));
        } elseif (config('web_super') == 3) {
            $this->assign('p0', config('web_price_ktfz'));
            $this->assign('p1', config('web_price_ktfz_sec'));
            $this->assign('p2', config('web_price_ktfz_sup'));
            $this->assign('p3', config('zz_price_ktfz_cp'));
            $this->assign('p4', config('zz_price_ktfz_da'));
        } elseif (config('web_super') == 4) {
            $this->assign('p0', config('web_price_ktfz'));
            $this->assign('p1', config('web_price_ktfz_sec'));
            $this->assign('p2', config('web_price_ktfz_sup'));
            $this->assign('p3', config('web_price_ktfz_cp'));
            $this->assign('p4', config('zz_price_ktfz_da'));
        } else {
            $this->assign('p0', config('zz_price_ktfz'));
            $this->assign('p1', config('zz_price_ktfz_sec'));
            $this->assign('p2', config('zz_price_ktfz_sup'));
            $this->assign('p3', config('zz_price_ktfz_cp'));
            $this->assign('p4', config('zz_price_ktfz_da'));
        }
        if (IS_POST) {
            $qz = strtolower(input('post.qz'));
            if (strpos($qz, '.') !== false) {
                $this->assign('alert', yydgtc('温馨提示', '域名前缀不允许有 . ！', 'warning', 'REFERER'));
            }
            $domain = input('post.domain');
            $name = input('post.name');
            $qq = input('post.qq');
            $domain = $qz . '.' . $domain;
            $type = input('post.type/d');
            if ($type == 0) {
                $super = 0;
                if (config('web_super') >= 0) {
                    $price = config('web_price_ktfz');
                } else {
                    $price = config('zz_price_ktfz');
                }
            } elseif ($type == 1) {
                $super = 1;
                if (config('web_super') >= 1) {
                    $price = config('web_price_ktfz_sec');
                } else {
                    $price = config('zz_price_ktfz_sec');
                }
            } elseif ($type == 2) {
                $super = 2;
                if (config('web_super') >= 2) {
                    $price = config('web_price_ktfz_sup');
                } else {
                    $price = config('zz_price_ktfz_sup');
                }
            } elseif ($type == 3) {
                $super = 3;
                if (config('web_super') >= 3) {
                    $price = config('web_price_ktfz_cp');
                } else {
                    $price = config('zz_price_ktfz_cp');
                }
            } elseif ($type == 4) {
                $super = 4;
                if (config('web_super') >= 4) {
                    $price = config('zz_price_ktfz_da');
                } else {
                    $price = config('zz_price_ktfz_da');
                }
            }
            if (strlen($qz) < 2 || strlen($qz) > 10) {
                $this->assign('alert', yydgtc('温馨提示', '域名前缀不合格！', 'warning', 'REFERER'));
            } elseif (strlen($name) < 2) {
                $this->assign('alert', yydgtc('温馨提示', '网站名称太短！', 'warning', 'REFERER'));
            } elseif (strlen($qq) < 5) {
                $this->assign('alert', yydgtc('温馨提示', 'QQ格式不正确！', 'warning', 'REFERER'));
            } elseif ($this->pdo->find("select zid from pre_webs where domain=:domain or domain2=:domain limit 1", array(
                ':domain' => $domain
            ))) {
                $this->assign('alert', yydgtc('温馨提示', '此前缀已被使用！', 'warning', 'REFERER'));
            } elseif ($this->userInfo['power'] >= 9) {
                $this->assign('alert', yydgtc('温馨提示', '你已经是站长，如需开通分站请到后台开通！', 'warning', 'REFERER'));
            } elseif ($this->userInfo['point'] < $price) {
                $this->assign('alert', yydgtc('温馨提示', '账户剩余余额不足，请充值！', 'warning', 'REFERER'));
            } else {
                $endtime = date("Y-m-d H:i:s", strtotime("+ 12 months", time()));
                if ($this->pdo->execute("INSERT INTO `pre_webs` (`upzid`, `super`, `uid`, `domain`, `qq`, `name`, `price_dx`, `price_all`, `price_vip`, `price_ktfz`,`price_ktfz_sec`,`price_ktfz_sup`,`price_ktfz_cp`,`price_ktfz_da`,`addtime`, `endtime`) VALUES ('" . ZID . "', :super, '" . $this->uid . "', :domain, :qq, :name, :price_dx, :price_all, :price_vip, :price_ktfz, :price_ktfz_sec, :price_ktfz_sup, :price_ktfz_cp, :price_ktfz_da, NOW(), :endtime)", array(
                    ':domain' => $domain,
                    ':name' => $name,
                    ':qq' => $qq,
                    ':endtime' => $endtime,
                    ':super' => $super,
                    ':price_dx' => config('web_price_dx') ,
                    ':price_all' => config('web_price_all') ,
                    ':price_vip' => config('web_price_vip') ,
                    ':price_ktfz' => config('zz_price_ktfz') ,
                    ':price_ktfz_sec' => config('zz_price_ktfz_sec') ,
                    ':price_ktfz_sup' => config('zz_price_ktfz_sup') ,
                    ':price_ktfz_cp' => config('zz_price_ktfz_cp') ,
                    ':price_ktfz_da' => config('zz_price_ktfz_da')
                ))) {
                    $row = $this->pdo->find("select zid from pre_webs where domain=:domain and qq=:qq limit 1", array(
                        ':domain' => $domain,
                        ':qq' => $qq
                    ));
                    $this->pdo->execute("update pre_users set zid=:zid,point=point-:point,power=9 where uid=:uid limit 1", array(
                        ':zid' => $row['zid'],
                        ':point' => $price,
                        ':uid' => $this->uid
                    ));
                    $this->addPointRecord($this->uid, $price, '消费', '开通分站消费！');
                    $tc_point = round($price * config('tc_rate') / 100, 2);
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(
                        ':point' => $tc_point,
                        ':uid' => config('web_uid')
                    ));
                    $this->addPointRecord(config('web_uid') , $tc_point, '提成', "你的站点用户{$this->uid}开通分站，你获得了{$tc_point}余额提成！");
                    $this->assign('alert', yydgtc("分站开通成功", "恭喜你！分站" . $domain . "已经成功开通，马上进入你自己的代挂网！", "success", 'http://' . $domain));
                    $this->assign('webTitle', '站点提示');
                    return $this->fetch('common/layout');
                } else {
                    $this->assign('alert', yydgtc('温馨提示', '开通失败，请稍后再试！', 'warning', 'REFERER'));
                }
            }
        } elseif (IS_AJAX) {
            $qz = strtolower(input('get.qz'));
            $domain = input('get.domain');
            $domain = $qz . '.' . $domain;
            if ($this->pdo->find("select zid from pre_webs where domain=:domain or domain2=:domain limit 1", array(
                ':domain' => $domain
            ))) {
                exit('1');
            } else {
                exit('0');
            }
        }
        $this->assign('domains', explode(',', config('zz_domains')));
        $this->assign('webTitle', '开通分站');
        return $this->fetch();
    }
    public function rmbList() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $pageList = new Page($this->pdo->getCount("select id from pre_points where uid=" . $this->uid) , 10);
        $points = $this->pdo->selectAll("select * from pre_points where uid=" . $this->uid . " order by id desc " . $pageList->limit);
        $this->assign('pageList', $pageList);
        $this->assign('points', $points);
        $this->assign('webTitle', '收支明细');
        return $this->fetch();
    }
    public function qqInfo($qid) {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $qid = intval($qid);
        if (!($info = $this->pdo->find("select * from pre_qqs where qid=:qid and uid=:uid limit 1", array(
            ':qid' => $qid,
            ':uid' => $this->uid
        )))) {
            $this->assign('alert', yydgtc('温馨提示', '该QQ账号可能已在其他账号添加，请联系总站长解决！', 'warning', url('qqList')));
            return $this->fetch('common/yydgtc');
        }
        $action = input('get.action');
        $tid = input('get.tid/d');
        if ($action == 'bu') {
            $this->pdo->execute("update pre_orders set zt=1 where qid=:qid and tid=:tid limit 1", array(
                ':qid' => $qid,
                ':tid' => $tid
            ));
        } elseif ($action == 'qxbu') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(
                ':qid' => $qid,
                ':tid' => $tid
            ));
        } elseif ($action == 'off') {
            $this->pdo->execute("update pre_orders set zt=2 where qid=:qid and tid=:tid limit 1", array(
                ':qid' => $qid,
                ':tid' => $tid
            ));
        } elseif ($action == 'on') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(
                ':qid' => $qid,
                ':tid' => $tid
            ));
        }
        $ret = get_curl("http://mc.vip.qq.com/card/grow", 0, 0, "uin=o{$info['uin']}; skey={$info['skey']};");
        if (strlen($ret) > 0) {
            $start = strpos($ret, "window.growInfo = ");
            $end = strpos($ret, "window.num");
            if ($start > 0 && $end > $start) {
                $ret = substr($ret, $start, $end - $start);
                $ret = str_replace(['window.growInfo =', '};'], ['', '}'], $ret);
                $ret = trim($ret);
                if ($ret = json_decode($ret, true)) {
                    $info['qqlevel'] = $ret['iQQLevel'];
                    $info['nowday'] = $ret['iRealDays'];
                    $info['needday'] = $ret['iNextLevelDay'];
                    $info['huoday'] = $ret['iTotalActiveDay'];
                    $info['vip'] = $ret['iVip'];
                    $info['svip'] = $ret['iSVip'];
                    $info['yearvip'] = $ret['iYearVip'];
                    $info['vipdj'] = $ret['iVipLevel'];
                    $info['vipjs'] = round($ret['iVipSpeedRate'] * 1 / 10, 1);
                    $info['maxjs'] = $ret['iMaxLvlTotalDays'];
                    $info['kj'] = $ret['QzoneVisitor'];
                    $info['ws'] = $ret['WeishiVideoview'];
                    $info['mq'] = $ret['iMobileQQOnline'];
                    $info['pq'] = $ret['iPCQQOnline'];
                    $info['gj'] = $ret['iPCSafeOnline'];
                    $info['yx'] = $ret['iMobileGameOnline'];
                    $info['yy'] = $ret['iUseQQMusic'];
                    $info['xz'] = $ret['iMedal'];
                    $info['ys'] = $ret['iNoHideOnline'];
                    $info['qb'] = $ret['iQWalletSign'];
                    $info['yd'] = $ret['iQQSportStep'];
                }
            }
        }
        $QQ = "{$info['uin']}";
        $urlPre = 'http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?g_tk=1518561325&uins=';
        $data = file_get_contents($urlPre . $QQ);
        $data = iconv("GB2312", "UTF-8", $data);
        $pattern = '/portraitCallBack\\((.*)\\)/is';
        preg_match($pattern, $data, $result);
        $result = $result[1];
        $result = json_decode($result, true);
        $info['qname'] = $result["{$QQ}"][6];
        $this->assign('info', $info);
        $this->assign('orderList', $this->pdo->selectAll("select a.*,b.name from pre_orders as a left join pre_tools as b on b.tid=a.tid where a.qid=:qid order by a.tid asc", array(
            ':qid' => $info['qid']
        )));
        $this->assign('webTitle', $info['uin'] . '-订单详情');
        return $this->fetch();
    }
    public function qqList() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $action = input('get.action');
        if ($action == 'del') {
            $qid = input('get.qid/d');
            $this->pdo->execute("delete from pre_qqs where qid=:qid and uid=:uid limit 1", array(
                ':qid' => $qid,
                ':uid' => $this->uid
            ));
            $this->pdo->execute("update pre_orders set zt=2 where qid=:qid", array(
                ':qid' => $qid
            ));
            $this->assign('alert', yydgtc('删除成功', 'QQ删除成功！', 'success', url('qqList')));
            $this->assign('webTitle', '站点提示');
            return $this->fetch('common/layout');
        } elseif ($action == 'search') {
            $uin = input('get.uin');
            $qqList = $this->pdo->selectAll("select * from pre_qqs where uin=:uin and uid=:uid limit 1", array(
                ':uin' => $uin,
                ':uid' => $this->uid
            ));
        } else {
            $qqList = $this->pdo->selectAll("select * from pre_qqs where uid=:uid order by qid desc", array(
                ':uid' => $this->uid
            ));
        }
        $this->assign('ql', $ql);
        $this->assign('qqList', $qqList);
        $this->assign('webTitle', 'QQ列表');
        return $this->fetch();
    }
    public function order() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $aqid = input('get.qid/d');
        $this->assign('aqid', $aqid);
        $power = $this->userInfo['power'];
        $price_dx = explode("|", config('web_price_dx'));
        $price_all = explode("|", config('web_price_all'));
        $price_vip = explode("|", config('web_price_vip'));
        $price_dx = isset($price_dx[$power]) && $price_dx[$power] >= config('zz_price_dx') ? $price_dx[$power] : config('zz_price_dx');
        $price_all = isset($price_all[$power]) && $price_all[$power] >= config('zz_price_all') ? $price_all[$power] : config('zz_price_all');
        $this->assign('price_dx', $price_dx);
        $this->assign('price_all', $price_all);
        $toolList = $this->pdo->selectAll("select * from pre_tools order by tid asc");
        $this->assign('toolList', $toolList);
        $qqList = $this->pdo->selectAll("select qid,uin from pre_qqs where uid=:uid order by qid desc", array(
            ':uid' => $this->uid
        ));
        $this->assign('qqList', $qqList);
        if (IS_POST) {
            $mod = input('post.mod');
            $qid = input('post.qid/d');
            if ($mod == 'kami') {
                $km = input('post.km');
                if (!($uin = $this->isExist($qid, $qqList, 'qid', 'uin'))) {
                    $this->assign('alert', yydgtc('温馨提示', '选择QQ不存在！', 'warning', 'REFERER'));
                } elseif (!($row = $this->pdo->find('select * from pre_dgkms where (zid=:zid or zid=:upzid or zid=1) and km=:km limit 1', array(
                    ':zid' => ZID,
                    ':upzid' => config('web_upzid') ,
                    ':km' => $km
                )))) {
                    $this->assign('alert', yydgtc('温馨提示', '卡密不存在！', 'warning', 'REFERER'));
                } else {
                    if ($row['user']) {
                        $this->assign('alert', yydgtc('温馨提示', '卡密已被使用！', 'warning', 'REFERER'));
                    } else {
                        $this->pdo->execute("update pre_dgkms set user=:uin,usetime=NOW() where kid=:kid limit 1", array(
                            ':uin' => $uin,
                            ':kid' => $row['kid']
                        ));
                        $num = $row['value'];
                        $isFinish = $this->addOrder($qid, 1, $num);
                        if ($isFinish) {
                            $this->assign('alert', yydgtc('下单成功', "成功使用卡密为QQ:{$uin}下单{$num}月全套代挂！", 'success', url('qqInfo', ['qid' => $qid])));
                        } else {
                            $this->assign('alert', yydgtc('温馨提示', '下单失败，请稍后再试！', 'warning', 'REFERER'));
                        }
                    }
                }
            } else {
                $tid = input('post.tid/d');
                $num = input('post.num/d');
                if ($num < 1) {
                    $num = 1;
                }
                $need = $price_dx * $num;
                if ($tid == 1) {
                    $need = $price_all * $num;
                }
                if (!($uin = $this->isExist($qid, $qqList, 'qid', 'uin'))) {
                    $this->assign('alert', yydgtc('温馨提示', '选择QQ不存在！', 'warning', 'REFERER'));
                } elseif (!($tool = $this->isExist($tid, $toolList, 'tid', 'name'))) {
                    $this->assign('alert', yydgtc('温馨提示', '选择代挂项目不存在！', 'warning', 'REFERER'));
                } elseif ($this->userInfo['point'] < $need) {
                    $this->assign('alert', yydgtc('余额不足', "账户余额不足{$need}，请先充值！", 'warning', 'REFERER'));
                } else {
                    $isFinish = $this->addOrder($qid, $tid, $num);
                    if ($isFinish) {
                        $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(
                            ':uid' => $this->uid,
                            ':point' => $need
                        ));
                        $this->addPointRecord($this->uid, $need, '消费', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}余额！");
                        $tc_point = $tid == 1 ? $price_all - config('zz_price_all') : $price_dx - config('zz_price_dx');
                        if ($tc_point > 0) {
                            $tc_point = round($tc_point * $num, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(
                                ':uid' => config('web_uid') ,
                                ":point" => $tc_point
                            ));
                            $this->addPointRecord(config('web_uid') , $tc_point, '获利', "你的站点用户{$this->uid}下单消费{$need}余额，你获得了{$tc_point}余额利润！");
                        }
                        $this->assign('alert', yydgtc('下单成功', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}余额！", 'success', url('qqInfo', ['qid' => $qid])));
                    } else {
                        $this->assign('alert', yydgtc('温馨提示', '下单失败，请稍后再试！', 'warning', 'REFERER'));
                    }
                }
            }
        }
        $this->assign('webTitle', '自助下单');
        return $this->fetch();
    }
    public function msg() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $pageList = new Page($this->pdo->getCount("select id from pre_message where uid=:uid", array(
            ':uid' => $this->uid
        )) , 10);
        $msgList = $this->pdo->selectAll("select * from pre_message where uid=:uid or uid<2 order by id desc " . $pageList->limit, array(
            ':uid' => $this->uid
        ));
        $this->assign('zzqq', config('web_qq'));
        $this->assign('pageList', $pageList);
        $this->assign('msgList', $msgList);
        $this->assign('webTitle', '站内通知');
        return $this->fetch();
    }
    public function msginfo($id) {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $id = intval($id);
        if (!($info = $this->pdo->find("select * from pre_message where id=:id limit 1", array(
            ':id' => $id
        )))) {
            $this->assign('alert', yydgtc('温馨提示', '消息不存在！', 'warning', 'REFERER'));
            $this->assign('webTitle', '站点提示');
            return $this->fetch('common/layout');
        }
        $code = '1';
        $this->pdo->execute("update pre_message set state=:state where id=:id limit 1", array(
            ':id' => $id,
            ':state' => $code
        ));
        $this->assign('info', $info);
        $this->assign('webTitle', '站内通知-' . $info['id']);
        return $this->fetch();
    }
    private function addOrder($qid, $tid, $num = 1) {
        if ($tid == 1) {
            $stmt = $this->pdo->getStmt("select tid from pre_tools where tid in (2,3,4,5,6,7,8,9,10,11,12) order by tid asc");
            while ($row = $stmt->fetch()) {
                $this->addOrder($qid, $row['tid'], $num);
            }
            return true;
        }
        $endtime = date("Y-m-d H:i:s", strtotime("+ " . $num . " months", time()));
        if ($order = $this->pdo->find("select * from pre_orders where tid=:tid and qid=:qid limit 1", array(
            ':tid' => $tid,
            ':qid' => $qid
        ))) {
            if ($order['endtime'] > date("Y-m-d H:i:s")) {
                $endtime = date("Y-m-d H:i:s", strtotime("+ " . $num . " months", strtotime($order['endtime'])));
            }
            if ($this->pdo->execute("update pre_orders set endtime=:endtime where id=:id limit 1", array(
                ':id' => $order['id'],
                ':endtime' => $endtime
            ))) {
                $isFinish = true;
            }
        } else {
            if ($this->pdo->execute("INSERT INTO `pre_orders` (`tid`, `qid`, `addtime`, `endtime`) VALUES (:tid, :qid, NOW(),:endtime)", array(
                ':tid' => $tid,
                ':qid' => $qid,
                ':endtime' => $endtime
            ))) {
                $isFinish = true;
            }
        }
        return true;
    }
    public function qqAdd($qid = 0) {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $qid = intval($qid);
        if ($qid && ($row = $this->pdo->find("select uin,pwd from pre_qqs where uid=:uid and qid=:qid limit 1", array(
            ':qid' => $qid,
            ':uid' => $this->uid
        )))) {
            $this->assign('qqInfo', $row);
        }
        if (IS_POST) {
            $uin = input('post.uin');
            $pwd = input('post.pwd');
            $skey = 'no';
            $p_skey = 'no';
            $cookiezt = 1;
            if ($row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(
                ':uin' => $uin
            ))) {
                $this->pdo->execute('update pre_qqs set uid=:uid,pwd=:pwd,cookiezt=:cookiezt,zt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(
                    ':qid' => $qid,
                    ':uid' => $this->uid,
                    ':pwd' => $pwd,
                    ':skey' => $skey,
                    ':p_skey' => $p_skey,
                    ':cookiezt' => $cookiezt
                ));
                $isUpdate = true;
            } else {
                if (strlen($uin) < 5 || !is_numeric($uin)) {
                    $this->assign('alert', yydgtc('添加失败', '你所添加的QQ格式错误！', 'warning', 'REFERER'));
                    return $this->fetch('common/yydgtc');
                }
                $id = strtoupper(substr(md5($uin . time()) , 0, 8) . '-' . uniqid());
                $this->pdo->execute("INSERT INTO `pre_qqs` (`uid`, `uin`, `pwd`, `cookiezt`, `skey`, `p_skey`, `addtime`, `id`) VALUES (:uid, :uin, :pwd, :cookiezt, :skey, :p_skey, NOW(), :id)", array(
                    ':uid' => $this->uid,
                    ':uin' => $uin,
                    ':pwd' => $pwd,
                    ':skey' => $skey,
                    ':p_skey' => $p_skey,
                    ':id' => $id,
                    ':cookiezt' => $cookiezt
                ));
                $row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(
                    ':uin' => $uin
                ));
                $isUpdate = false;
            }
            $qid = $row['qid'];
            if ($isUpdate) {
                $this->assign('alert', yydgtc('更新密码成功', $uin . '密码更新成功,查看QQ详情!', 'success', url("/user/qqInfo", ['qid' => $qid])));
            } elseif ($qid) {
                $this->assign('alert', yydgtc('添加QQ成功', $uin . '添加成功，现在去下单!', 'success', url("/user/order", ['qid' => $qid])));
            } else {
                $this->assign('alert', yydgtc('添加失败', $uin . '添加失败，请返回重试', 'warning', 'REFERER'));
            }
        }
        $this->assign('webTitle', '添加/更新QQ');
        return $this->fetch();
    }
    public function UpdateCookies() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $uin = input('get.qq');
        $skey = input('get.skey');
        $p_skey = input('get.pskey');
        if ($uin && $skey && $p_skey) {
        if ($row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(
            ':uin' => $uin
        ))) {
            $sqs = $this->pdo->execute('update pre_qqs set cookiezt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(
                ':qid' => $row['qid'],
                ':skey' => $skey,
                ':p_skey' => $p_skey
            ));
        }
        if ($sqs) {
            $this->assign('alert', yydgtc('更新COOKIES成功', $uin . '更新成功，开始享受代挂吧!', 'success', url("/user/qqInfo", ['qid' => $row['qid']])));
        } elseif (!$row) {
            $this->assign('alert', yydgtc('更新COOKIES失败', $uin . '还未在本站进行添加!', 'warning', 'REFERER'));
         } else {
            $this->assign('alert', yydgtc('更新COOKIES失败', $uin . '更新失败，请稍后重试!', 'warning', url("/user/qqInfo", ['qid' => $row['qid']])));
        }
        }
        $this->assign('webTitle', '更新COOKIES状态码');
        return $this->fetch();
    }
    public function kami() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $power = $this->userInfo['power'];
        $price_all = explode("|", config('web_price_all'));
        $priceAll = isset($price_all[$power]) && $price_all[$power] >= config('zz_price_all') ? $price_all[$power] : config('zz_price_all');
        $costp = isset($price_all[$power]) && $price_all[$power] >= config('zz_price_all') ? $price_all[$power] : config('zz_price_all');
        $this->assign('priceAll', $priceAll);
        $infinite = $this->userInfo['infinite'];
        if ($infinite == 1) {
            $priceAll = 0;
            $costp = 0;
        }
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'add') {
                $value = input('post.value/d');
                $num = input('post.num/d');
                $need = $priceAll * $num * $value;
                if ($value < 1 || $value > 12) {
                    $this->assign('alert', yydgtc('温馨提示', '月数不能大于12个月！', 'warning', 'REFERER'));
                } elseif ($num > 100) {
                    $this->assign('alert', yydgtc('温馨提示', '生成数量不能大于100！', 'warning', 'REFERER'));
                } elseif ($this->userInfo['point'] < $need) {
                    $this->assign('alert', yydgtc('温馨提示', '生成' . $num . '张卡密需要' . $need . '余额，你当前只有' . $this->userInfo['point'] . '余额，请充值！', 'warning', 'REFERER'));
                } else {
                    $kms = '';
                    for ($i = 0; $i < $num; $i++) {
                        $km = getRandStr(16);
                        $costp2 = $priceAll * $value;
                        if ($this->pdo->execute("INSERT INTO `pre_dgkms` (`zid`, `uid`, `km`, `value`, `addtime`, `need`) VALUES (:zid, :uid, :km, :value, NOW(), :need)", array(
                            ':zid' => ZID,
                            ':uid' => $this->uid,
                            ':km' => $km,
                            ':value' => $value,
                            ':need' => $costp2
                        ))) {
                            $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(
                                ':uid' => $this->uid,
                                ':point' => $priceAll * $value
                            ));
                            $this->userInfo['point'] = $this->userInfo['point'] - $priceAll * $value;
                            $kms.= $km . '<br>';
                        }
                    }
                    $this->addPointRecord($this->uid, $need, '消费', "你生成全套代挂卡密消费了{$need}余额！");
                    $this->assign('userInfo', $this->userInfo);
                    $this->assign('kms', $kms);
                }
            }
        }
        $action = input('get.action');
        if ($action == 'del') {
            $kid = input('get.kid/d');
            if ($row = $this->pdo->find("select * from pre_dgkms where uid=:uid and kid=:kid limit 1", array(
                ':uid' => $this->uid,
                ':kid' => $kid
            ))) {
                if (!$row['user']) {
                    $backpoint = $row['need'];
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(
                        ':uid' => $this->uid,
                        ':point' => $backpoint
                    ));
                    $this->assign('alert', yydgtc('删除成功', "成功删除卡密{$row['km']},由于该卡密未使用，已退回{$backpoint}余额至你账户！", 'success', 'REFERER'));
                } else {
                    $this->assign('alert', yydgtc('删除成功', "成功删除卡密{$row['km']}！", 'success', 'REFERER'));
                }
                $this->pdo->execute("delete from pre_dgkms where uid=:uid and kid=:kid limit 1", array(
                    ':uid' => $this->uid,
                    ':kid' => $kid
                ));
            } else {
                $this->assign('alert', yydgtc('温馨提示', '要删除的卡密已不存在！', 'warning', 'REFERER'));
            }
        } elseif ($action == 'clean') {
            $this->pdo->execute("delete from pre_dgkms where uid=:uid and user!=0", array(
                ':uid' => $this->uid
            ));
            $this->assign('alert', yydgtc('删除成功', "已删除所有已使用的卡密！", 'success', url("/user/kami")));
        }
        $pageList = new Page($this->pdo->getCount("select kid from pre_dgkms where uid=:uid", array(
            ':uid' => $this->uid
        )) , 5);
        $kmList = $this->pdo->selectAll("select * from pre_dgkms where uid=:uid order by kid desc " . $pageList->limit, array(
            ':uid' => $this->uid
        ));
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select kid from pre_dgkms where uid=:uid and km like '%{$s}%'", array(
                    ':uid' => $this->uid
                )) , 10);
                $kmList = $this->pdo->selectAll("select * from pre_dgkms where uid=:uid and km like '%{$s}%' order by kid desc " . $pageList->limit, array(
                    ':uid' => $this->uid
                ));
            }
        }
        $this->assign('kmList', $kmList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '代挂卡密生成');
        return $this->fetch();
    }
    public function connect() {
        $Oauth = new Oauth();
        if (input('get.code')) {
            $array = $Oauth->callback();
            $media_type = $array['media_type'];
            $access_token = $array['access_token'];
            $social_uid = $array['social_uid'];
            if (empty($this->userInfo)) {
                $row = $this->pdo->find("SELECT * FROM pre_users WHERE social_uid=:social_uid limit 1", array(
                    ':social_uid' => $social_uid
                ));
                if (!$row) {
                    $this->assign('alert', yydgtc('登录失败', "该QQ尚未绑定本站任何账号,无法快捷登录！", 'warning', url("./Index/login")));
                    exit($this->fetch('common/yydgtc'));
                } else {
                    if ($row['social_token'] != $access_token) {
                        $this->pdo->execute("update pre_users` set `social_token` =:access_token where `uid`=:uid", array(
                            ':uid' => $this->uid,
                            ':access_token' => $access_token
                        ));
                    }
                    $yydg = getSid();
                        cookie('usersid', $yydg);
                        $this->pdo->execute("update pre_users set yydg=:yydg where uid=:uid limit 1", array(
                        ':uid' => $row['uid'] ,
                        ":yydg" => $yydg
                         ));
                    $this->assign('alert', yydgtc('登录成功', "QQ快捷登录成功，欢迎回来！", 'success', url("./user")));
                    exit($this->fetch('common/yydgtc'));
                }
            } else {
                $srow = $this->pdo->find("SELECT * FROM pre_users WHERE social_uid=:social_uid limit 1", array(
                    ':social_uid' => $social_uid
                ));
                if ($srow['user'] == '') {
                    $this->pdo->execute("UPDATE pre_users SET social_uid=:social_uid,social_token=:access_token WHERE uid = :uid", array(
                        ':uid' => $this->uid,
                        ':social_uid' => $social_uid,
                        ':access_token' => $access_token
                    ));
                    unset($_SESSION['Oauth_access_token']);
                    unset($_SESSION['Oauth_social_uid']);
                    $this->assign('alert', yydgtc('绑定成功', "恭喜您已经成功将QQ绑定至代挂网账号！", 'success', url("/user/profile")));
                    exit($this->fetch('common/yydgtc'));
                } else {
                    unset($_SESSION['Oauth_access_token']);
                    unset($_SESSION['Oauth_social_uid']);
                    exit("<script language='javascript'>window.location.href='./';</script>");
                }
            }
        } else {
            $Oauth->login();
        }
    }
    public function index() {
        if (IS_PJAX) {
            Config::set('default_ajax_return', 'html');
        }
        $amount['zkm'] = $this->pdo->getCount("select kid from pre_kms");
        $amount['zqq'] = $this->pdo->getCount("select qid from pre_qqs");
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
        $amount['tongji'] = $this->pdo->selectAll("select * from pre_users where zid='" . ZID . "' limit 20");
        $this->assign('amount', $amount);
        $zzqq = config('web_qq');
        $this->assign('zzqq', $zzqq);
        $this->assign('webTitle', '用户中心');
        return $this->fetch();
    }
    private function isExist($value, $arr, $key, $return = null) {
        foreach ($arr as $arr2) {
            if ($arr2[$key] == $value) {
                if ($return) {
                    if ($return == 'array') {
                        return $arr2;
                    } else {
                        return $arr2[$return];
                    }
                }
                return true;
            }
        }
        return false;
    }
    private function addPointRecord($uid, $point = 0, $action = '消费', $bz = null) {
        $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(
            ':uid' => $uid,
            ':point' => $point,
            ':action' => $action,
            ':bz' => $bz
        ));
    }
    function __construct() {
        parent::__construct();
        if (empty($this->userInfo) && ACTION_NAME != 'connect') {
            $this->assign('alert', yydgtc('未登录', '你还没有登录哦！', 'warning', url('/Index/login')));
            exit($this->fetch('common/yydgtc'));
        } elseif ($this->userInfo['active'] == 0 && ACTION_NAME != 'connect') {
            $this->assign("alert", yydgtc("温馨提示", "该账号已被冻结,请用绑定QQ" . $this->userInfo['qq'] . "联系管理员解封!", "warning"));
            exit($this->fetch('common/yydgtc'));
        }
    }
}