<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/4/27
// +----------------------------------------------------------------------


namespace app\index\controller;


use app\util\Page;

class Panel extends Common
{

    public function gdInfo($id)
    {
        $id = intval($id);

        if (!$info = $this->pdo->find("select * from pre_gongdan where id=:id limit 1", array(':id' => $id))) {
            $this->assign('alert', sweetAlert('温馨提示', '工单不存在！', 'warning'));
            return $this->fetch('common/sweetalert');
        }

        if (IS_POST) {
            $code = input('post.deal');
            if ($this->pdo->execute("update pre_gongdan set state=:state where id=:id limit 1", array(':id' => $id, ':state' => $code))) {
                $this->assign('alert', sweetAlert('温馨提示', '修改工单成功 ，请耐心等待客服处理！', 'success'));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '修改工单失败 ，请稍后再试！', 'warning'));
            }

        }

        $this->assign('info', $info);
        $this->assign('webTitle', '工单回复ID-' . $info['id']);
        return $this->fetch();
    }


    public function lottery()
    {
        $uid = $this->uid;
        $need = config('zz_lottery_price');
        $arrlist = explode(",", config('zz_lottery_list'));
        $arrchance = explode(",", config('zz_lottery_chance'));
        $arrcount = count($arrchance);
        $arrcountfor = $arrcount - 1;

        if (IS_POST) {
            if (config('zz_lottery_of') == 0) {
                $this->assign('alert', sweetAlert('温馨提示', '欢乐抽奖已关闭', 'warning'));
            } elseif (config('zz_lottery_of') == 1) {
                if ($this->userInfo['point'] < $need) {
                    $this->assign('alert', sweetAlert('温馨提示', '余额不足', 'warning'));
                } else {
                    $now = mt_rand(1, 100);
                    $state = '0';
                    $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $need));
                    $this->addPointRecord($this->uid, $need, '消费', "你抽奖消费了{$need}积分！");
                    for ($i = 0; $i <= $arrcountfor; $i++) {
                        $i2 = $i - 1;
                        if ($now <= $arrchance[$i]) {
                            $this->assign('alert', sweetAlert('中奖了', '恭喜你获得' . $arrlist[$i] . '，请联系站长兑奖!', 'success'));
                            $this->pdo->execute("INSERT INTO `pre_lotlist` (`uid`, `state`, `name`, `addtime`) VALUES (:uid, :state, :name, NOW())", array(':uid' => $uid, ':state' => $state, ':name' => $arrlist[$i]));
                            break;
                        } else {
                            $this->assign('alert', sweetAlert('好可惜', '没有获奖? 赶紧再来试试吧', 'success'));
                        }
                    }
                }
            } elseif (config('zz_lottery_of') == 2) {
                if ($this->userInfo['jf'] < $need) {
                    $this->assign('alert', sweetAlert('温馨提示', '积分不足', 'warning'));
                } else {
                    $now = mt_rand(1, 100);
                    $state = '0';
                    $this->pdo->execute("update pre_users set jf=jf-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $need));
                    $this->addPointRecord($this->uid, $need, '消费', "你抽奖消费了{$need}积分！");
                    for ($i = 0; $i <= $arrcountfor; $i++) {
                        $i2 = $i - 1;
                        if ($now <= $arrchance[$i]) {
                            $this->assign('alert', sweetAlert('中奖了', '恭喜你获得' . $arrlist[$i] . '，请联系站长兑奖!', 'success'));
                            $this->pdo->execute("INSERT INTO `pre_lotlist` (`uid`, `state`, `name`, `addtime`) VALUES (:uid, :state, :name, NOW())", array(':uid' => $uid, ':state' => $state, ':name' => $arrlist[$i]));
                            break;
                        } else {
                            $this->assign('alert', sweetAlert('好可惜', '没有获奖? 赶紧再来试试吧', 'success'));
                        }
                    }
                }
            }
        }

        $pageList = new Page($this->pdo->getCount("select id from pre_lotlist where uid=:uid", array(':uid' => $this->uid)), 10);
        $cjList = $this->pdo->selectAll("select * from pre_lotlist where uid=:uid order by id desc " . $pageList->limit, array(':uid' => $this->uid));

        $this->assign('pageList', $pageList);
        $this->assign('cjList', $cjList);
        $this->assign('arrlist', $arrlist);
        $this->assign('arrchance', $arrchance);
        $this->assign('webTitle', '欢乐抽奖');
        return $this->fetch();
    }


    public function dsyw()
    {
        if (config('zz_dsyw_of') == 0) {
            $this->assign('alert', sweetAlert('温馨提示', '代刷社区已关闭', 'warning', url("/index/Panel/index")));
        }

        if (IS_POST) {
            $uid = $this->userInfo['uid'];
            $state = '0';
            $qq = input('post.qq');
            $pwd = input('post.pwd');
            $num = input('post.num');
            $arr = explode('|', input('post.sqid'));
            $price = $arr['1'];
            $name = $arr['0'];
            $priceAll = $price * $num;
            if ($this->userInfo['point'] < $priceAll) {
                $this->assign('alert', sweetAlert('温馨提示', '账户余额不足' . $priceAll . '，请充值！', 'warning'));
            } else {
                if ($this->pdo->execute("INSERT INTO `pre_shuas` (`uid`, `name`, `qq`, `pwd`, `num`, `price`, `state`, `addtime`) VALUES (:uid, :name, :qq, :pwd, :num, :price, :state, NOW())", array(':uid' => $uid, ':name' => $name, ':qq' => $qq, ':pwd' => $pwd, ':num' => $num, ':price' => $priceAll, ':state' => $state))) {
                    $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $uid, ':point' => $priceAll));
                    $this->addPointRecord($this->uid, $priceAll, '消费', "你在代刷社区消费了{$priceAll}元！");
                    $this->assign('alert', sweetAlert('温馨提示', '下单成功 ，请耐心等待订单交易！', 'success', url("/index/Panel/dsyw")));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '下单失败 ，请稍后再试！', 'warning'));
                }
            }
        }

        $ywList = $this->pdo->selectAll("select * from pre_ywlist where zid=:zid order by id desc", array(':zid' => '1'));
        $pageList = new Page($this->pdo->getCount("select id from pre_shuas where uid=:uid", array(':uid' => $this->uid)), 10);
        $dsList = $this->pdo->selectAll("select * from pre_shuas where uid=:uid order by id desc " . $pageList->limit, array(':uid' => $this->uid));

        $this->assign('ywList', $ywList);
        $this->assign('pageList', $pageList);
        $this->assign('dsList', $dsList);
        $this->assign('webTitle', "代刷社区");
        return $this->fetch();
    }


    public function freeKm()
    {
        $amount = array();
        $amount['total'] = $this->pdo->getCount("select kid from pre_freekms");
        $amount['finish'] = $this->pdo->getCount("select kid from pre_freekms where useid!=0");
        $this->assign('amount', $amount);
        $isFinish = false;
        if ($kmRow = $this->pdo->find("select * from pre_freekms where useid=:uid limit 1", array(':uid' => $this->uid))) {
            $this->assign('kmRow', $kmRow);
            $isFinish = true;
        }
        if (IS_GET) {
            $action = input('get.action');
            if ($action == 'freekm') {
                if ($isFinish) {
                    $this->assign('alert', sweetAlert('温馨提示', '对不起，你已领取过免费卡密！', 'warning', url('freeKm')));
                } else {
                    if ($row = $this->pdo->find("select * from pre_freekms where useid=0 order by kid asc limit 1")) {
                        $this->pdo->execute("update pre_freekms set useid=:uid,usetime=NOW() where kid=:kid limit 1", array(':kid' => $row['kid'], ':uid' => $this->uid));
                        $this->assign('alert', sweetAlert('领取成功', '你已成功领取一张卡密！', 'success', url('freeKm')));
                    } else {
                        $this->assign('alert', sweetAlert('温馨提示', '对不起，你来晚了，卡密已领完！', 'warning', url('freeKm')));
                    }
                }
            }
        }

        //获取卡密列表
        $pageList = new Page($this->pdo->getCount("select kid from pre_freekms"), 10);
        $kmList = $this->pdo->selectAll("select * from pre_freekms order by kid desc " . $pageList->limit);
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select kid from pre_freekms where km like '%{$s}%'"), 10);
                $kmList = $this->pdo->selectAll("select * from pre_freekms where km like '%{$s}%' order by kid desc " . $pageList->limit);
            }
        }


        $this->assign('kmList', $kmList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', "免费代挂卡密");
        return $this->fetch();
    }


    public function query()
    {
        if (IS_POST) {
            $uin = input("post.qq");
            if ($info = $this->pdo->find("select * from pre_qqs where uin=:uin limit 1", array(':uin' => $uin))) {
                $result = array('code' => 1);
            } else {
                $result = array('code' => 2);
            }
            exit(json_encode($result));
        }
        $this->assign('webTitle', '订单查询');
        return $this->fetch();
    }


    public function orderzan()
    {
        $power = $this->userInfo['power'];
        if ($power == 9) {
            $price_zan = 0;
        } else {
            $price_zan = explode("|", config('web_price_zan'));
            $price_zan = isset($price_zan[$power]) && $price_zan[$power] >= config('zz_price_zan') ? $price_zan[$power] : config('zz_price_zan');
        }
        $qqList = $this->pdo->selectAll("select qid,uin from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
        $this->assign('qqList', $qqList);
        $toolList = $this->pdo->selectAll("select * from pre_tools order by tid asc");
        $this->assign('toolList', $toolList);
        $this->assign('price_zan', $price_zan);
        if (IS_POST) {
            $h = date("G");

            $tid = input('post.tid');
            $qid = input('post.qid');
            $num = input('post.num');
            if ($num < 1) $num = 1;
            $need = $price_zan * $num;
            if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
            } elseif (!$tool = $this->isExist('10', $toolList, 'tid', 'name')) {
                $this->assign('alert', sweetAlert('温馨提示', '选择代挂项目不存在！', 'warning'));
            } elseif ($this->userInfo['point'] < $need) {
                $this->assign('alert', sweetAlert('余额不足', "账户余额不足{$need}，请先充值！", 'warning'));
            } else {
                $isFinish = $this->addOrder($qid, '10', $num);
                if ($isFinish) {
                    $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $need));
                    //消费记录
                    $this->addPointRecord($this->uid, $need, '消费', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}元！");
                    //消费站长获利
                    $tc_point = $tid == 1 ? $price_all - config('zz_price_zan') : $price_zan - config('zz_price_dx');
                    if ($tc_point > 0) {
                        $tc_point = round($tc_point * $num, 2);
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $tc_point));
                        $this->addPointRecord(config('web_uid'), $tc_point, '获利', "你的站点用户{$this->uid}下单消费{$need}元，你获得了{$tc_point}元利润！");
                        //$this->addTc($this->uid, $this->userInfo['upid'], $need);
                    }
                    //消费上级提成
                    if ($this->userInfo['upid'] && config('zz_invite_rate') > 0 && $upRow = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $this->userInfo['upid']))) {
                        $tc_point = round(config('zz_invite_rate') * $need / 100, 2);
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                        $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}消费{$need}元，你获得了{$tc_point}元提成！");
                    }

                    $this->assign('alert', sweetAlert('下单成功', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}元！", 'success', url('qqInfo', ['qid' => $qid])));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                }
            }
        }
        $this->assign('webTitle', '秒赞下单');
        return $this->fetch();
    }

    public function qqSJ()
    {
        if (IS_POST) {
            $uin = input("post.uin");
            $day = input("post.day");
            $sd = input("post.sd");
            $level = input("post.level/d");
            $needall = ceil($level * $level + 4 * $level - $day);
            $need = ceil(($level * $level + 4 * $level - $day) / $sd);
            $arr = array();
            //$arr['code'] = 0;
            $arr['uin'] = $uin;
            $arr['day'] = $day;
            $arr['sd'] = $sd;
            $arr['level_now'] = floor(sqrt($day - 4) - 2);
            $arr['level'] = $level;
            $arr['needall'] = $needall;
            $arr['need'] = $need;
        } else {
            $arr = array();
            $arr['uin'] = "";
            $arr['day'] = "";
            $arr['sd'] = "";
            $arr['level_now'] = "";
            $arr['level'] = "";
            $arr['needall'] = "";
            $arr['need'] = "";
        }

        $this->assign('arr', $arr);
        $this->assign('webTitle', "QQ等级升级计算");
        return $this->fetch();
    }


    public function cj()
    {

        $pageList = new Page($this->pdo->getCount("select *,a.zid as azid ,a.id as aid from pre_audits as a join pre_prizes as b on a.pid=b.id where uid=:uid", array(':uid' => $this->uid)), 20);
        $PList = $this->pdo->selectAll("select *,a.zid as azid ,a.id as aid from pre_audits as a join pre_prizes as b on a.pid=b.id where uid=:uid order by aid desc " . $pageList->limit, array(':uid' => $this->uid));
        $this->assign('pList', $PList);
        $this->assign('pageList', $pageList);


        if (!config('zz_cjoff')) {
            $this->assign('alert', sweetAlert('温馨提示', '未开启抽奖功能', 'warning'));
        } else {
            //$List = $this->pdo->execute("select * from pre_audits as a left join pre_prizes as b on a.pid=b.id where `a.uid`=:uid",array(':uid'=>$this->uid));

            $need = config('zz_cj_need');
            $free = 0;
            $rfree = (config('zz_cj_free_day') - $this->pdo->getCount("select id from pre_free where uid=:uid and `type`=0 and TO_DAYS(date)=TO_DAYS(NOW())", array(':uid' => $this->uid)));
            if ($rfree <= 0) {
                $rfree = 0;
            }
            if ($rfree > 0) {
                $need = 0;
            }
            $ip = getIP();
            if ($this->userInfo['power'] == 9) {
                $vip = 9;
            } else {
                $vip = $this->userInfo['power'];
            }
            if ($vip == 9) {
                //只有站长级别才能获取到卡密奖品
                $sql = "select * from pre_prizes";
            } else {
                $sql = "select * from pre_prizes where `type`<>1";
            }
            if (IS_POST) {
                if ($this->userInfo['power'] == 9) {
                    $vip = 9;
                } else {
                    $vip = $this->userInfo['power'];
                }
                if ($need > $this->userInfo['point']) {
                    $this->assign('alert', sweetAlert('温馨提示', '余额不足', 'warning'));
                } else if (config('zz_cj_vip') > $vip) {
                    $this->assign('alert', sweetAlert('温馨提示', '你不满足领取身份', 'warning'));
                } else {
                    if (config('zz_ipxzcj') != 0 && $need == 0) {
                        $last = $this->pdo->selectAll("select * from pre_free where `ip`='{$ip}' and TO_DAYS(date)=TO_DAYS(NOW()) and DATE_FORMAT(date,'%H')=DATE_FORMAT(CURRENT_TIME(),'%H') order date asc");
                        if (count($last) >= config('zz_ipxzcj')) {
                            exit("<script>alert('你的设备抽奖次数已达上限，请稍候再试!');history.go(-1);</script>");
                        }
                    }
                    if ($need > 0 && !$this->pdo->execute("update pre_users set point=point-:need where uid=:uid limit 1", array(':uid' => $this->uid, ':need' => $need))) {
                        exit("<script>alert('余额不足，抽奖失败！');history.go(-1);</script>");
                    }
                    $this->pdo->execute("insert into pre_free (`uid`,`type`,`date`,`ip`) values(:uid,0,:date,'{$ip}')", array(':uid' => $this->uid, ':date' => date('Y-m-d H:i:s')));
                    $prize_arr = $this->pdo->selectAll($sql);
                    $i = 1;
                    foreach ($prize_arr as $key => $val) {
                        $arr[$i] = $val['p'];
                        $i++;
                    }

                    $rid = $this->get_rand($arr); //根据概率获取奖项id
                    $prize = $prize_arr[$rid - 1];
                    $this->addPointRecord($this->uid, $need, '消费', "抽奖消费{$need}元");
                    if ($prize['type'] == 1) {
                        $km = getRandStr();
                        $this->pdo->execute("INSERT INTO `pre_dgkms` (`zid`, `uid`, `km`, `value`, `addtime`) VALUES (:zid, :uid, :km, :value, NOW())", array(':zid' => ZID, ':uid' => $this->uid, ':km' => $km, ':value' => $prize['value']));
                        $alert = '恭喜你，抽中"' . $prize['name'] . '"!卡密\n' . $km . '\n已成功保存至你的卡密列表！请到卡密列表查看';
                    } else if ($prize['type'] == 2) {
                        $rmb = $prize['value'] ?: 0;

                        $this->pdo->execute("update pre_users set point=point+:rmb where uid=:uid limit 1", array(':uid' => $this->uid, ':rmb' => $rmb));
                        $this->addPointRecord($this->uid, $rmb, '奖励', "抽奖获得{$rmb}元");
                        $alert = '恭喜你，抽中"' . $prize['name'] . '"!' . $rmb . '元已经充入账户余额！';
                    } else if ($prize['type'] == 3) {
                        $this->pdo->execute("insert into pre_audits (`zid`,`uid`,`addtime`,`pid`,`zt`) values(:zid,:uid,NOW(),:pid,0)", array(
                            ':uid' => $this->userInfo['uid'],
                            ':pid' => $prize['id'],
                            ':zid' => ZID,
                        ));
                        $alert = '恭喜你，抽中"' . $prize['name'] . '"!请尽快联系总站长领奖!';
                    } else {
                        $alert = "很遗憾，未中奖";
                    }
                    exit("<script>alert('{$alert}');history.go(-1);</script>");
                }
            }


            $List = $this->pdo->selectAll($sql);
            $this->assign('List', $List);
            $this->assign('rfree', $rfree);
        }
        $this->assign('webTitle', "幸运抽奖");
        return $this->fetch();
    }

    public function dfflist()
    {
        $act = input('act');
        if ($act == "del") {
            $this->pdo->execute("delete from pre_audits where id=:id and uid=:uid limit 1", array(':id' => input('id/d'), ':uid' => $this->uid));
            $this->assign('alert', sweetAlert('温馨提示', '删除成功', 'success', url()));
            return $this->fetch('common/sweetalert');
        }

        $pageList = new Page($this->pdo->getCount("select *,a.zid as azid ,a.id as aid from pre_audits as a join pre_prizes as b on a.pid=b.id where uid=:uid", array(':uid' => $this->uid)), 20);
        $PList = $this->pdo->selectAll("select *,a.zid as azid ,a.id as aid from pre_audits as a join pre_prizes as b on a.pid=b.id where uid=:uid order by aid desc " . $pageList->limit, array(':uid' => $this->uid));
        $this->assign('pList', $PList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', "待发奖品列表");
        return $this->fetch();
    }

    function get_rand($proArr)
    {
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }


    public function chat()
    {
        if (IS_POST) {
            $action = input("post.action");
            if ($action == 'send') {
                $message = strip_tags(input("post.message"));
                //$timelimits=date("Y-m-d H:i:s",time()+$timelimit);
                //$ipcount=$this->pdo->getCount("SELECT id FROM pre_chats WHERE `addtime`<:time limit ".$iplimit);
                if (strlen($message) < 3) {
                    $this->assign('alert', sweetAlert('发送失败', '聊天内容太短！', 'warning'));
                } elseif (!$this->checkChat($message)) {
                    $this->assign('alert', sweetAlert('发送失败', '对不起，你的聊天内容含有敏感词汇！', 'warning'));
                } else {
                    if (!$this->pdo->execute("INSERT INTO `pre_chats` (`zid`, `user`, `qq`, `message`, `addtime`) VALUES (:zid, :user, :qq, :message, NOW())", array(':zid' => ZID, ':user' => $this->userInfo['user'], ':qq' => $this->userInfo['qq'], ':message' => $message))) {
                        $this->assign('alert', sweetAlert('发送失败', '发送失败，请稍后再试！', 'warning'));
                    }
                }

            }
        }

        $chatList = $this->pdo->selectAll("select * from pre_chats where zid=:zid order by id desc limit 10", array(':zid' => ZID));
        if (!$lastchat = @$chatList[0]['id']) $lastchat = 0;
        $chatList = array_reverse($chatList);
        if (!$startchat = @$chatList[0]['id']) $startchat = 1;
        $this->assign('chatList', $chatList);
        $this->assign('lastchat', $lastchat);
        $this->assign('startchat', $startchat);
        $this->assign('webTitle', "公共聊天室");
        return $this->fetch();
    }

    private function checkChat($message)
    {
        $strs = config('zz_chat_stop');
        if ($strs) {
            $strs = explode(',', $strs);
            foreach ($strs as $str) {
                if (strpos('z' . $message, trim($str))) {
                    return false;
                }
            }
        }
        return true;
    }

    public function ybdh()
    {
        if ($this->userInfo['power'] == 9) {
            $degree = '站长';
        } elseif ($this->userInfo['power'] > 0) {
            $degree = 'VIP' . $this->userInfo['power'];
        } else {
            $degree = '普通会员';
        }
        $rate = config('zz_rate_vip' . $this->userInfo['power']);
        if (!$rate) $rate = 1;

        if (IS_POST) {
            $num = intval(input('post.num'));
            if ($num < 1) $num = 1;
            if ($this->userInfo['coin'] < $num) {
                $this->assign('alert', sweetAlert('温馨提示', '账户剩余元宝不足' . $num . '！', 'warning'));
            } else {
                $point = $rate * $num;
                if ($this->pdo->execute("update pre_users set point=point+:point,coin=coin-:rmb where uid=:uid limit 1", array(':point' => $point, ':rmb' => $num, ':uid' => $this->uid))) {
                    //记录兑换记录
                    $this->addPointRecord($this->uid, $point, '兑换', "成功用{$num}个元宝兑换{$point}金币！");
                    $this->assign('alert', sweetAlert('兑换成功', "成功用{$num}个元宝兑换{$point}金币！", 'success', url('ybdh')));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '兑换失败,请稍后再试！', 'warning'));
                }
            }
        }

        $this->assign('degree', $degree);
        $this->assign('rate', $rate);
        $this->assign('webTitle', "元宝兑换");
        return $this->fetch();
    }

    public function help()
    {
        $this->assign('webTitle', "帮助中心");
        return $this->fetch();
    }

    public function chajian()
    {


        $this->assign('webTitle', "插件系统");
        return $this->fetch();
    }

    public function lye()
    {
        $isFinish = false;
        return false;
        if ($this->pdo->find("select * from pre_hongbaos where TO_DAYS(hbdate) = TO_DAYS(NOW()) and uid=:uid limit 1", array(':uid' => $this->uid))) {

            $pageList = new Page($this->pdo->getCount("select id from pre_hongbaos where TO_DAYS(hbdate) = TO_DAYS(NOW()) and uid!=0"), 10);
            $hbList = $this->pdo->selectAll("select a.*,b.user from pre_hongbaos as a left join pre_users as b on b.uid=a.uid where TO_DAYS(a.hbdate) = TO_DAYS(NOW()) and a.uid!=0 order by a.id asc " . $pageList->limit);
            $this->assign('pageList', $pageList);
            $this->assign('hbList', $hbList);
            $isFinish = true;
        }
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'lye') {
                if ($isFinish) {
                    $this->assign('alert', sweetAlert('温馨提示', '对不起，你今天已经领过了！', 'warning', url('lye')));
                } else {
                    if (!$this->pdo->find("select * from pre_hongbaos where TO_DAYS(hbdate) = TO_DAYS(NOW()) limit 1")) {
                        //不存在则重新分配
                        $hb = array();
                        $znum = config('zz_hb_num');
                        $num = $znum - 1;
                        $hbPoint = config('zz_hb_point') - $znum;
                        $max = config('zz_hb_point_one') - 1;
                        for ($i = 0; $i < $num; $i++) {
                            $point = $this->getHbPoint($hbPoint, $max);
                            if ($point < 0) $point = 0;
                            $hbPoint = $hbPoint - $point;
                            $hb[$i] = $point + 1;
                        }
                        $hb[$znum] = $hbPoint + 1;
                        if ($hb[$znum] > $max) {
                            $pj = ceil(($hb[$znum] - $max) / $num);
                            foreach ($hb as $k => $value) {
                                $hb[$k] = $hb[$k] + $pj;
                                $hb[$znum] = $hb[$znum] - $pj;
                                if ($hb[$znum] <= $max) break;
                            }
                        }
                        shuffle($hb);
                        foreach ($hb as $k => $value) {
                            $this->pdo->execute("INSERT INTO `pre_hongbaos` (`uid`, `point`, `hbdate`) VALUES ('0', :point, NOW())", array(':point' => $value));
                        }
                    }

                    //抢红包
                    if ($this->pdo->execute("update pre_hongbaos set uid=:uid,lqtime=NOW() where TO_DAYS(hbdate) = TO_DAYS(NOW()) and uid=0 order by id asc limit 1", array(':uid' => $this->uid))) {
                        if ($row = $this->pdo->find("select * from pre_hongbaos where TO_DAYS(hbdate) = TO_DAYS(NOW()) and uid=:uid limit 1", array(':uid' => $this->uid))) {
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $row['point']));
                            $this->addPointRecord($this->uid, $row['point'], '奖励', date("Y-m-d") . " 领金币所得");
                            $this->assign('alert', sweetAlert('恭喜你', '你已成功领到' . $row['point'] . '金币！', 'success', url('lye')));
                        } else {
                            $this->assign('alert', sweetAlert('来晚了', '对不起，金币已被抢完！', 'warning', url('lye')));
                        }
                    } else {
                        $this->assign('alert', sweetAlert('来晚了', '对不起，金币已被抢完！', 'warning', url('lye')));
                    }
                }
            }
        }
        $this->assign('webTitle', "每日领金币");
        return $this->fetch();
    }

    private function getHbPoint($point, $max)
    {
        if ($point < 1) return 0;
        if ($max > $point) return rand(1, $point);
        return rand(1, $max);
    }

    public function qiandao()
    {

        $isQd = false;
        if ($qdRow = $this->pdo->find("select num from pre_qiandaos where uid=:uid and TO_DAYS(qdtime)=TO_DAYS(NOW()) limit 1", array(':uid' => $this->uid))) {
            $isQd = true;
        }
        if ($row = $this->pdo->find("select num from pre_qiandaos where uid=:uid and TO_DAYS(NOW()) - TO_DAYS(qdtime) = 1 order by id desc limit 1", array(':uid' => $this->uid))) {
            $day = $row['num'];
        } else {
            $day = 0;
        }
        if ($isQd) $day = $qdRow['num'];
        $this->assign('day', $day);
        $rule = $this->qdRule();
        $num = config('zz_qiandao_num') ? config('zz_qiandao_num') : 999999;
        $this->assign('rule', $rule);
        $this->assign('num', $num);
        $this->assign('day', $day);
        if (IS_POST) {
            if ($isQd) {
                $this->assign('alert', sweetAlert('温馨提示', "你今天已经签过到了！", 'warning', url('qiandao')));
            } else {
                $day++;
                $max = isset($rule['max']) ? $rule['max'] : 0;
                if ($day > $max) {
                    $point = $rule[$max];
                } else {
                    $point = $rule[$day];
                }
                $count = $this->pdo->getCount("select id from pre_qiandaos where TO_DAYS(qdtime)=TO_DAYS(NOW()) ");
                $this->pdo->execute("INSERT INTO `dg_qiandaos` (`uid`, `num`, `qdtime`) VALUES (:uid, :num, NOW())", array(':uid' => $this->uid, ':num' => $day));
                if ($count < $num) {
                    $count++;
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':point' => $point, ':uid' => $this->uid));
                    $this->addPointRecord($this->uid, $point, '签到', date("Y-m-d") . "-签到获取奖励！");
                    $this->assign('alert', sweetAlert('签到成功', "你已连续签到{$day}天。恭喜你，你是今天第{$count}个签到的用户，特奖励你{$point}！", 'success', url('qiandao')));
                } else {
                    $this->assign('alert', sweetAlert('签到成功', "你已连续签到{$day}天。很遗憾，你今天来晚了，没能领到奖励！", 'warning', url('qiandao')));
                }
            }
        }
        $this->assign('qdList', $this->pdo->selectAll("select a.*,b.user from pre_qiandaos as a left join pre_users as b on b.uid=a.uid order by a.id desc limit 10"));
        $this->assign('isQd', $isQd);

        $this->assign('webTitle', '每日签到');
        return $this->fetch();
    }

    private function qdRule()
    {
        if ($rows = explode(',', config('zz_qiandao_rule'))) {
            $array = array();
            foreach ($rows as $row) {
                if ($arr = explode(':', $row)) {
                    $key = trim($arr[0]);
                    $array["$key"] = trim($arr[1]);
                    $max = $key;
                }
            }
            if ($array) {
                $narr = array();
                $jf = 0;
                for ($i = 1; $i <= $max; $i++) {
                    if (isset($array[$i]) && $num = $array[$i]) {
                        $narr[$i] = $num;
                        $jf = $num;
                    } else {
                        $narr[$i] = $jf;
                    }
                }
                $narr['max'] = $max;
                return $narr;
            } else {
                return array(0, 1);
            }
        } else {
            return array(0, 1);
        }
    }

    public function recharge()
    {
        if (IS_POST) {

            $km = input('post.km');
            if (strlen($km) != 16) {
                $this->assign('alert', sweetAlert('温馨提示', '卡密格式不正确！', 'warning'));
            } elseif (!$row = $this->pdo->find('select * from pre_kms where (zid=:zid or zid=1) and km=:km limit 1', array(':zid' => ZID, ':km' => $km))) {
                $this->assign('alert', sweetAlert('温馨提示', '卡密不存在！', 'warning'));
            } else {
                if ($row['useid']) {
                    $this->assign('alert', sweetAlert('温馨提示', '卡密已被使用！', 'warning'));
                } else {
                    if ($this->pdo->execute("update pre_kms set useid=:uid,usetime=NOW() where kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $row['kid']))) {
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ":point" => $row['value']));
                        //取消充值提成
                        if ($this->userInfo['upid'] && config('zz_invite_rate') > 0) {
                            $tc_point = round(config('zz_invite_rate') * $row['value'] / 100, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                            $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}充值{$row['value']}，你获得了{$tc_point}提成！");
                        }
                        //记录充值记录
                        $this->addPointRecord($this->uid, $row['value'], '充值', "成功使用卡密{$km}充值{$row['value']}！");

                        //充值送分站活动
                        if (config('zz_price_sfz') && $row['value'] >= config('zz_price_sfz')) {
                            if ($this->userInfo['power'] != 9) {
                                $this->pdo->execute("update pre_users set fzpe = 1 where uid=:uid limit 1", array(':uid' => $this->uid));
                            }
                        }

                        $this->assign('alert', sweetAlert('充值成功', '卡密使用成功，成功充值' . $row['value'] . '！', 'success', url('recharge')));
                    } else {
                        $this->assign('alert', sweetAlert('温馨提示', '充值失败，请稍后再试！', 'warning'));
                    }
                }
            }

        }
        $this->assign('webTitle', '金币充值');
        return $this->fetch();
    }

    public function shop()
    {
        $price_dx = explode("|", config('web_price_dx'));
        $price_all = explode("|", config('web_price_all'));
        $price_vip = explode("|", config('web_price_vip'));

        $action = input('get.action');
        $vipname = array('普通用户', 'VIP①', 'VIP②', 'VIP③', 'VIP④', 'VIP⑤', 'VIP⑥', 'VIP⑦', 'VIP⑧', '站长');
        if ($action == 'buy') {
            $id = input('get.id/d');
            $price = $price_vip[$id - 1];
            if ($id > count($price_vip)) {
                $this->assign('alert', sweetAlert('温馨提示', '本站无此级别的VIP会员开通！', 'warning'));
            } elseif ($id <= $this->userInfo['power']) {
                $this->assign('alert', sweetAlert('温馨提示', '你现在已经是 ' . $vipname[$this->userInfo['power']] . ' 了，请勿重复开通或选择更高级别的VIP开通！', 'warning'));
            } elseif ($price > $this->userInfo['point']) {
                $this->assign('alert', sweetAlert('温馨提示', '您当前的金币不足，请充值！', 'warning'));
            } else {
                $this->pdo->execute("update pre_users set point=point-:point,power=:power where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $price, ':power' => $id));
                //消费记录
                $this->addPointRecord($this->uid, $price, '消费', '购买' . $vipname[$id]);

                $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $price));
                $this->addPointRecord(config('web_uid'), $price, '获利', "你的站点用户{$this->uid}开通{$vipname[$id]}，你获得了{$price}利润！");
                $this->assign('alert', sweetAlert('开通成功', "成功开通{$vipname[$id]}", 'success', url('shop')));
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

        $this->assign('webTitle', '自助购买');
        return $this->fetch();
    }

    public function profile()
    {
        if (IS_POST) {
            $qq = input('post.qq');
            $pwd = input('post.pwd');
            if ($pwd && strlen($pwd) < 5) {
                $this->assign('alert', sweetAlert('温馨提示', '新密码太简单！', 'warning'));
            } else {
                if ($pwd) {
                    $pwd = getPwd($pwd);
                } else {
                    $pwd = $this->userInfo['pwd'];
                }
                if ($this->pdo->execute('update pre_users set qq=:qq,pay_account=:pay_account,pay_name=:pay_name,pwd=:pwd where uid=:uid limit 1', array(':qq' => $qq, ':pwd' => $pwd, ':pay_account' => input('post.pay_account'), ':pay_name' => input('post.pay_name'), ':uid' => $this->uid))) {
                    $this->assign('alert', sweetAlert('更新成功', '修改成功！', 'success', url('profile')));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '修改失败,请稍候再试！', 'warning'));
                }
            }
        }
        $this->assign('webTitle', '个人资料修改');
        return $this->fetch();
    }

    public function rank($kind = 'invite')
    {
        if ($kind == 'order') {
            $name = '分站订单数排行';
            $this->assign('rankList', $this->pdo->selectAll("select a.zid,a.name,(select count(c.qid) from pre_orders as b left join pre_qqs as c on c.qid=b.qid left join pre_users as d on d.uid=c.uid where d.zid=a.zid) as count from pre_webs as a order by count desc limit 10"));
        } else {
            $kind = 'invite';
            $name = '邀请人数排行';
            $this->assign('rankList', $this->pdo->selectAll("select a.uid,a.user,(select count(b.uid) from pre_users as b where b.upid = a.uid) as count  from pre_users as a order by count desc limit 10"));
        }
        $this->assign('kind', $kind);


        $this->assign('webTitle', $name);
        return $this->fetch();
    }

    public function daili()
    {
        return false;

        if ($this->userInfo['power'] < 1) {
            $this->assign('alert', sweetAlert('权限不够', '你不是代理！', 'warning'));
            return $this->fetch();
        }
        if (IS_POST) {
            $action = input('post.action');
            if ($action == 'add') {
                $value = input('post.value/d');
                $num = input('post.num/d');
                $depoint = round($value * config('zz_daili_rate') / 100, 2);
                if ($value < 1 || $value > 1000) {
                    $this->assign('alert', sweetAlert('温馨提示', '金额数不符合要求！', 'warning'));
                } elseif ($num > 100) {
                    $this->assign('alert', sweetAlert('温馨提示', '生成数量不能大于100！', 'warning'));
                } else {
                    $kms = '';
                    for ($i = 0; $i < $num; $i++) {
                        $km = getRandStr(16);
                        if ($this->userInfo['point'] < $depoint) {
                            $kms .= '<font color="red">金币不足，请充值！</font>';
                            $this->assign('alert', sweetAlert('温馨提示', '剩余金币不足，请充值！', 'warning'));
                            break;
                        }
                        if ($this->pdo->execute("INSERT INTO `pre_kms` (`zid`, `uid`, `km`, `value`, `addtime`) VALUES (:zid, :uid, :km, :value, NOW())", array(':zid' => ZID, ':uid' => $this->uid, ':km' => $km, ':value' => $value))) {
                            //扣金币
                            $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $depoint));
                            $this->userInfo['point'] = $this->userInfo['point'] - $depoint;
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
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']},由于该卡密未使用，已退回{$row['value']}至你账户！", 'success', 'REFERER'));
                } else {
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']}！", 'success', 'REFERER'));
                }
                $this->pdo->execute("delete from pre_kms where uid=:uid and kid=:kid limit 1", array(':uid' => $this->uid, ':kid' => $kid));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '要删除的卡密已不存在！', 'warning', 'REFERER'));
            }
        }
        //获取卡密列表
        $pageList = new Page($this->pdo->getCount("select kid from pre_kms where uid=:uid", array(':uid' => $this->uid)), 10);
        $kmList = $this->pdo->selectAll("select * from pre_kms where uid=:uid order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
        if (IS_POST) {
            if (input('post.action') == 'search') {
                $s = input('post.s');
                $pageList = new Page($this->pdo->getCount("select kid from pre_kms where uid=:uid and km like '%{$s}%'", array(':uid' => $this->uid)), 10);
                $kmList = $this->pdo->selectAll("select * from pre_kms where uid=:uid and km like '%{$s}%' order by kid desc " . $pageList->limit, array(':uid' => $this->uid));
            }
        }


        $this->assign('kmList', $kmList);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '代理卡密管理');
        return $this->fetch();
    }

    public function ktfz()
    {
        if (IS_POST) {
            $qz = strtolower(input('post.qz'));
            $domain = input('post.domain');
            $name = input('post.name');
            $qq = input('post.qq');
            $domain = $qz . '.' . $domain;

            $type = input('post.type/d');
            $price = config('web_price_ktfz');
            if ($this->userInfo['fzpe']) {
                $price = 0;
            }
            $super = 0;
            if ($type == 1) {
                $super = 1;


            } elseif ($type == 2) {
                $super = 2;
            } elseif ($type == 3) {
                $super = 3;
            } elseif ($type == 4) {
                $super = 4;
                $price = config('zz_price_ktfz_super');
            }

            if (strlen($qz) < 2 || strlen($qz) > 8) {
                $this->assign('alert', sweetAlert('温馨提示', '域名前缀不合格！', 'warning'));
            } elseif (strlen($name) < 2) {
                $this->assign('alert', sweetAlert('温馨提示', '网站名称太短！', 'warning'));
            } elseif (strlen($qq) < 5) {
                $this->assign('alert', sweetAlert('温馨提示', 'QQ格式不正确！', 'warning'));
            } elseif ($this->pdo->find("select zid from pre_webs where domain=:domain or domain2=:domain limit 1", array(':domain' => $domain))) {
                $this->assign('alert', sweetAlert('温馨提示', '此前缀已被使用！', 'warning'));
            } elseif ($this->userInfo['power'] == 9) {
                $this->assign('alert', sweetAlert('温馨提示', '你已经是站长，不能再开通分站！', 'warning'));
            } elseif ($this->userInfo['point'] < $price) {
                $this->assign('alert', sweetAlert('温馨提示', '账户剩余金币不足，请充值！', 'warning'));
            } else {
                $endtime = date("Y-m-d H:i:s", strtotime("+ 12 months", time()));
                if ($this->pdo->execute("INSERT INTO `pre_webs` (`upzid`, `super`, `uid`, `domain`, `qq`, `name`, `price_dx`, `price_all`, `price_vip`, `addtime`, `endtime`) VALUES ('" . ZID . "', :super, '" . $this->uid . "', :domain, :qq, :name, :price_dx, :price_all, :price_vip, NOW(), :endtime)", array(':domain' => $domain, ':name' => $name, ':qq' => $qq, ':endtime' => $endtime, ':super' => $super, ':price_dx' => config('web_price_dx'), ':price_all' => config('web_price_all'), ':price_vip' => config('web_price_vip')))) {
                    $row = $this->pdo->find("select zid from pre_webs where domain=:domain and qq=:qq limit 1", array(':domain' => $domain, ':qq' => $qq));
                    $this->pdo->execute("update pre_users set zid=:zid,point=point-:point,power=9 where uid=:uid limit 1", array(':zid' => $row['zid'], ':point' => $price, ':uid' => $this->uid));
                    //消费记录
                    $this->addPointRecord($this->uid, $price, '消费', '开通分站消费！');
                    //分站提成
                    if (config('web_super') == 1 && $type == 0) {
                        $tc_point = $price;
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ':point' => $tc_point));
                        $this->addPointRecord(config('web_uid'), $tc_point, '提成', "你的站点用户{$this->uid}开通分站，你获得了{$tc_point}提成！");
                    } elseif (config('zz_ktfz_rate')) {
                        $tc_point = round(config('zz_ktfz_rate') * $price / 100, 2);
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ':point' => $tc_point));
                        $this->addPointRecord(config('web_uid'), $tc_point, '提成', "你的站点用户{$this->uid}开通分站，你获得了{$tc_point}提成！");
                        //$tcPoint = $price * config('zz_tc_rate');
                        //$this->addTc($this->uid, config('web_uid'), $tcPoint, '用户UID:' . $this->uid . '开通分站获得提成！');
                    }
                    if ($this->userInfo['fzpe']) {
                        $this->pdo->execute("update pre_users set fzpe=0 where uid=:uid limit 1", array(':uid' => $this->uid));
                    }
                    $this->assign('alert', sweetAlert("分站开通成功", "恭喜你！分站" . $domain . "已经成功开通，马上进入你自己的代挂网！", "success", 'http://' . $domain));
                    return $this->fetch('common/sweetalert');
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '开通失败，请稍后再试！', 'warning'));
                }
            }

        }
        $this->assign('domains', explode(',', config('zz_domains')));
        $this->assign('webTitle', '自助开通分站');
        return $this->fetch();
    }

    public function invite()
    {
        if (IS_GET) {
            $action = input('get.action');
            if ($action == 'getInvite') {
                if (!$this->userInfo['invite']) {
                    $this->pdo->execute("update pre_users set invite=:invite where uid=:uid limit 1", array(':uid' => $this->uid, ':invite' => getRandStr(8, 1)));
                    $this->assign('alert', sweetAlert('获取成功', '获取邀请码成功！', 'success', url('invite')));
                }
            }
        } elseif (IS_POST) {
            $action = input('post.action');
            if ($action == 'invite') {
                $invite = input('post.invite');
                if ($this->userInfo['upid']) {
                    $this->assign('alert', sweetAlert('温馨提示', '你已经完成过邀请任务！', 'warning'));
                } elseif (strlen($invite) != 8) {
                    $this->assign('alert', sweetAlert('温馨提示', '邀请码格式不正确！', 'warning'));
                } elseif ($invite == $this->userInfo['invite']) {
                    $this->assign('alert', sweetAlert('温馨提示', '不能自己邀请自己！', 'warning'));
                } elseif (!$inviteUser = $this->pdo->find("select uid,upid from pre_users where invite=:invite limit 1", array(':invite' => $invite))) {
                    $this->assign('alert', sweetAlert('温馨提示', '邀请码不存在！', 'warning'));
                } elseif ($inviteUser['upid'] == $this->uid) {
                    $this->assign('alert', sweetAlert('温馨提示', '不能互相邀请！', 'warning'));
                } else {
                    $this->pdo->execute("update pre_users set upid=:upid,invitetime=NOW() where uid=:uid limit 1", array(':uid' => $this->uid, ':upid' => $inviteUser['uid']));
                    //获取邀请奖励
                    if (config('zz_point_invite1')) {
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => config('zz_point_invite1')));
                        $this->addPointRecord($this->uid, config('zz_point_invite1'), '奖励', '完成邀请任务获得奖励！');
                    }
                    //邀请人获得奖励
                    if (config('zz_point_invite2')) {
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $inviteUser['uid'], ':point' => config('zz_point_invite2')));
                        $this->addPointRecord($inviteUser['uid'], config('zz_point_invite2'), '奖励', "邀请用户UID:" . $this->uid . "获得奖励！");
                    }
                    $this->assign('alert', sweetAlert('完成邀请', '完成邀请任务！你获得奖励' . config('zz_point_invite1') . '', 'success', url('invite')));
                }
            }
        }
        //获取邀请记录
        $pageList = new Page($this->pdo->getCount("select uid from pre_users where upid=" . $this->uid), 10);
        $invites = $this->pdo->selectAll("select uid,user,invitetime from pre_users where upid=" . $this->uid . " order by invitetime desc " . $pageList->limit);

        $this->assign('invites', $invites);
        $this->assign('pageList', $pageList);
        $this->assign('webTitle', '邀请管理');
        return $this->fetch();
    }

    public function rmbList()
    {
        //获取金币明细记录
        $pageList = new Page($this->pdo->getCount("select id from pre_points where uid=" . $this->uid), 10);
        $points = $this->pdo->selectAll("select * from pre_points where uid=" . $this->uid . " order by id desc " . $pageList->limit);

        $this->assign('pageList', $pageList);
        $this->assign('points', $points);
        $this->assign('webTitle', '收支明细');
        return $this->fetch();
    }

    public function qqInfo($qid)
    {
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
        $qqList = $this->pdo->selectAll("select qid,uin from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
        $this->assign('qqList', $qqList);

        if (IS_POST) {
            $mod = input('post.mod');
            $qid = input('post.qid/d');
            if ($mod == 'kami') {
                $km = input('post.km');
                if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
                } elseif (strlen($km) != 16) {
                    $this->assign('alert', sweetAlert('温馨提示', '卡密格式不正确！', 'warning'));
                } elseif (!$row = $this->pdo->find('select * from pre_dgkms where (zid=:zid or zid=:upzid or zid=1) and km=:km limit 1', array(':zid' => ZID, ':upzid' => config('web_upzid'), ':km' => $km))) {
                    $this->assign('alert', sweetAlert('温馨提示', '卡密不存在！', 'warning'));
                } else {
                    if ($row['user']) {
                        $this->assign('alert', sweetAlert('温馨提示', '卡密已被使用！', 'warning'));
                    } else {
                        $this->pdo->execute("update pre_dgkms set user=:uin,usetime=NOW() where kid=:kid limit 1", array(':uin' => $uin, ':kid' => $row['kid']));
                        $num = $row['value'];
                        $isFinish = $this->addOrder($qid, 1, $num);
                        if ($isFinish) {
                            $this->assign('alert', sweetAlert('下单成功', "成功使用卡密为QQ:{$uin}下单{$num}月全套代挂！", 'success', url('qqInfo', ['qid' => $qid])));
                        } else {
                            $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                        }
                    }
                }
            } else {
                $tid = input('post.tid/d');
                $num = input('post.num/d');
                if ($num < 1) $num = 1;
                $need = $price_dx * $num;
                if ($tid == 1) {
                    //全套代挂价格
                    $need = $price_all * $num;
                }
                if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
                } elseif (!$tool = $this->isExist($tid, $toolList, 'tid', 'name')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择代挂项目不存在！', 'warning'));
                } elseif ($this->userInfo['point'] < $need) {
                    $this->assign('alert', sweetAlert('金币不足', "账户金币不足{$need}，请先充值！", 'warning'));
                } else {
                    $isFinish = $this->addOrder($qid, $tid, $num);

                    if ($isFinish) {
                        $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $need));
                        //消费记录
                        $this->addPointRecord($this->uid, $need, '消费', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}金币！");
                        //消费站长获利
                        $tc_point = $tid == 1 ? $price_all - config('zz_price_all') : $price_dx - config('zz_price_dx');
                        if ($tc_point > 0) {
                            $tc_point = round($tc_point * $num, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $tc_point));
                            $this->addPointRecord(config('web_uid'), $tc_point, '获利', "你的站点用户{$this->uid}下单消费{$need}金币，你获得了{$tc_point}金币利润！");
                            //$this->addTc($this->uid, $this->userInfo['upid'], $need);
                        }
                        //消费上级提成
                        if ($this->userInfo['upid'] && config('zz_invite_rate') > 0 && $upRow = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $this->userInfo['upid']))) {
                            $tc_point = round(config('zz_invite_rate') * $need / 100, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                            $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}消费{$need}金币，你获得了{$tc_point}金币提成！");
                        }

                        $this->assign('alert', sweetAlert('下单成功', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}金币！", 'success', url('qqInfo', ['qid' => $qid])));
                    } else {
                        $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                    }
                }
            }
        }
        //信息界面下单代挂，获取数据MYSQL信息


        $qid = intval($qid);

        if (!$info = $this->pdo->find("select * from pre_qqs where uid=:uid and qid=:qid limit 1", array(':qid' => $qid, ':uid' => $this->uid))) {
            $this->assign('alert', sweetAlert('温馨提示', 'QQ不存在！', 'warning', url('qqList')));
            return $this->fetch('common/sweetalert');
        }
        $action = input('get.action');
        $tid = input('get.tid/d');
        if ($action == 'quan') {
            get_curl(config('zz_quan_api') . $info['uin']);
            $this->assign('alert', sweetAlert('成功提示', 'QQ已提交 正在为您排队,可能需要一段时间 请稍后查看圈圈增长情况', 'success', 'REFERER'));
            return $this->fetch('common/sweetalert');
        } elseif ($action == 'bu') {
            $this->pdo->execute("update pre_orders set zt=1 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'qxbu') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'off') {
            $this->pdo->execute("update pre_orders set zt=2 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'on') {
            $this->pdo->execute("update pre_orders set zt=0 where qid=:qid and tid=:tid limit 1", array(':qid' => $qid, ':tid' => $tid));
        } elseif ($action == 'auto') {
            $price = config('zz_price_auto');
            $price = (is_numeric($price) && $price > 0) ? $price : 0;
            if (strtotime($info['autotime']) > time()) {
                $this->assign('alert', sweetAlert('温馨提示', '你已经开通自动更新，无需重复开通！', 'warning', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            } elseif ($this->userInfo['point'] < $price) {
                $this->assign('alert', sweetAlert('温馨提示', '你账户金币不足，请充值！', 'warning', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            } else {
                $endtime = date("Y-m-d H:i:s", strtotime("+ 1 months", time()));
                $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $price));
                $this->pdo->execute("update pre_qqs set autotime=:endtime where qid=:qid limit 1", array(':qid' => $qid, ':endtime' => $endtime));
                $this->assign('alert', sweetAlert('开通成功', '开启自动更新成功，有效期一月！到期时间：' . $endtime . '！', 'success', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            }
        } elseif ($action == 'yc') {
            $price = config('zz_price_yc');
            $price = (is_numeric($price) && $price > 0) ? $price : 0;
            if (strtotime($info['yc_time']) > time()) {
                $this->assign('alert', sweetAlert('温馨提示', '你已经开通自动检测，无需重复开通！', 'warning', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            } elseif ($this->userInfo['point'] < $price) {
                $this->assign('alert', sweetAlert('温馨提示', '你账户金币不足，请充值！', 'warning', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            } else {
                $endtime = date("Y-m-d H:i:s", strtotime("+ 1 months", time()));
                $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $price));
                $this->pdo->execute("update pre_qqs set yc_time=:endtime,last_yc=NOW() where qid=:qid limit 1", array(':qid' => $qid, ':endtime' => $endtime));
                $this->assign('alert', sweetAlert('开通成功', '开启自动检测成功，有效期一月！到期时间：' . $endtime . '！', 'success', url('qqInfo', ['qid' => $qid])));
                return $this->fetch('common/sweetalert');
            }
        }

		$ret = get_curl("http://mc.vip.qq.com/card/grow", 0, 0, "uin=o{$info['uin']}; skey={$info['skey']};");
		if (strlen($ret) > 0) {
			$start = strpos($ret, "window.growInfo = ");
			$end = strpos($ret, "window.num");
			if ($start > 0 && $end > $start) {
				$ret = substr($ret, $start, $end - $start);
				$ret = str_replace([
					'window.growInfo =', '};'
				], [
					'', '}'
				], $ret);
				$ret = trim($ret);
				if ($ret = json_decode($ret, true)) {
					$info['qqlevel'] = $ret['iQQLevel'];
					$info['nowday'] = $ret['iRealDays'];
					$info['needday'] = $ret['iNextLevelDay'];
				}
			}
		}


        $this->assign('info', $info);
        $this->assign('orderList', $this->pdo->selectAll("select a.*,b.name from pre_orders as a left join pre_tools as b on b.tid=a.tid where a.qid=:qid order by a.tid asc", array(':qid' => $info['qid'])));

        $this->assign('webTitle', $info['uin'] . '-订单详情');
        return $this->fetch();
    }

    public function qqList()
    {
        $this->assign('info', $info);
        $this->assign('orderList', $this->pdo->selectAll("select a.*,b.name from pre_orders as a left join pre_tools as b on b.tid=a.tid where a.qid=:qid order by a.tid asc", array(':qid' => $info['qid'])));
        //QQ订单统计

        $action = input('get.action');
        if ($action == 'del') {
            $qid = input('get.qid/d');
            $this->pdo->execute("delete from pre_qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $this->uid));
            $this->pdo->execute("update pre_orders set zt=2 where qid=:qid", array(':qid' => $qid));
            $this->assign('alert', sweetAlert('删除成功', 'QQ删除成功！', 'success', url('qqList')));
            return $this->fetch('common/sweetalert');
        } elseif ($action == 'search') {
            $uin = input('get.uin');
            $qqList = $this->pdo->selectAll("select * from pre_qqs where uin=:uin and uid=:uid limit 1", array(':uin' => $uin, ':uid' => $this->uid));
        } else {
            $qqList = $this->pdo->selectAll("select * from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
        }
        //获取QQ列表
        $this->assign('qqList', $qqList);
        $this->assign('webTitle', 'QQ列表');
        return $this->fetch();
    }

    public function order()
    {
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
        $qqList = $this->pdo->selectAll("select qid,uin from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
        $this->assign('qqList', $qqList);

        if (IS_POST) {
            $mod = input('post.mod');
            $qid = input('post.qid/d');
            if ($mod == 'kami') {
                $km = input('post.km');
                if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
                } elseif (!$row = $this->pdo->find('select * from pre_dgkms where (zid=:zid or zid=:upzid or zid=1) and km=:km limit 1', array(':zid' => ZID, ':upzid' => config('web_upzid'), ':km' => $km))) {
                    $this->assign('alert', sweetAlert('温馨提示', '卡密不存在！', 'warning'));
                } else {
                    if ($row['user']) {
                        $this->assign('alert', sweetAlert('温馨提示', '卡密已被使用！', 'warning'));
                    } else {
                        $this->pdo->execute("update pre_dgkms set user=:uin,usetime=NOW() where kid=:kid limit 1", array(':uin' => $uin, ':kid' => $row['kid']));
                        $num = $row['value'];
                        $isFinish = $this->addOrder($qid, 1, $num);
                        if ($isFinish) {
                            $this->assign('alert', sweetAlert('下单成功', "成功使用卡密为QQ:{$uin}下单{$num}月全套代挂！", 'success', url('qqInfo', ['qid' => $qid])));
                        } else {
                            $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                        }
                    }
                }
            } elseif ($mod == 'pl') {
                //批量下单
                $con = input('post.con');
                $tid = input('post.tid/d');
                $orders = explode('
', $con);
                $list = array();
                $need = 0;
                $num = 0;
                foreach ($orders as $order) {
                    $order=trim($order);
                    $order = explode('----', $order);
                    if (count($order) === 3 && preg_match('/^[1-9][0-9]{4,9}$/', $order[0]) && is_numeric($order[2]) && $order[2] > 0) {
                        $order[2] = intval($order[2]);
                        $list[] = $order;
                        if ($tid == 1) {
                            //全套代挂价格
                            $need += $price_all * $order[2];
                        } else {
                            $need += $price_dx * $order[2];
                        }
                        $num += $order[2];
                    }
                }

                if (count($list) == 0) {
                    $this->assign('alert', sweetAlert('温馨提示', '未匹配出正确下单数据！', 'warning'));
                } elseif (!$tool = $this->isExist($tid, $toolList, 'tid', 'name')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择代挂项目不存在！', 'warning'));
                } elseif ($this->userInfo['point'] < $need) {
                    $this->assign('alert', sweetAlert('金币不足', "账户金币不足{$need}，请先充值！", 'warning'));
                } else {
                    $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $need));
                    //消费记录
                    $this->addPointRecord($this->uid, $need, '消费', "批量下单{$tool}，消费{$need}金币！");

                    $isFinish = true;
                    foreach ($list as $order) {
                        if ($qid = $this->addQQ($order[0], $order[1])) {
                            if ($this->addOrder($qid, $tid, $order[2])) {
                                continue;
                            }
                        }
                        $isFinish = false;
                    }

                    if ($isFinish) {
                        //消费站长获利
                        $tc_point = $tid == 1 ? $price_all - config('zz_price_all') : $price_dx - config('zz_price_dx');
                        if ($tc_point > 0) {
                            $tc_point = round($tc_point * $num, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $tc_point));
                            $this->addPointRecord(config('web_uid'), $tc_point, '获利', "你的站点用户{$this->uid}批量下单消费{$need}金币，你获得了{$tc_point}金币利润！");
                            //$this->addTc($this->uid, $this->userInfo['upid'], $need);
                        }
                        //消费上级提成
                        if ($this->userInfo['upid'] && config('zz_invite_rate') > 0 && $upRow = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $this->userInfo['upid']))) {
                            $tc_point = round(config('zz_invite_rate') * $need / 100, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                            $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}消费{$need}金币，你获得了{$tc_point}金币提成！");
                        }

                        $this->assign('alert', sweetAlert('下单成功', "批量下单{$tool}，消费{$need}金币！", 'success', url('qqInfo', ['qid' => $qid])));
                    } else {
                        $this->assign('alert', sweetAlert('温馨提示', '批量下单失败，请稍后再试！', 'warning'));
                    }
                }

            } else {
                $tid = input('post.tid/d');
                $num = input('post.num/d');
                if ($num < 1) $num = 1;
                $need = $price_dx * $num;
                if ($tid == 1) {
                    //全套代挂价格
                    $need = $price_all * $num;
                }
                if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
                } elseif (!$tool = $this->isExist($tid, $toolList, 'tid', 'name')) {
                    $this->assign('alert', sweetAlert('温馨提示', '选择代挂项目不存在！', 'warning'));
                } elseif ($this->userInfo['point'] < $need) {
                    $this->assign('alert', sweetAlert('金币不足', "账户金币不足{$need}，请先充值！", 'warning'));
                } else {
                    $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $need));
                    //消费记录
                    $this->addPointRecord($this->uid, $need, '消费', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}金币！");

                    $isFinish = $this->addOrder($qid, $tid, $num);
                    if ($isFinish) {
                        //消费站长获利
                        $tc_point = $tid == 1 ? $price_all - config('zz_price_all') : $price_dx - config('zz_price_dx');
                        if ($tc_point > 0) {
                            $tc_point = round($tc_point * $num, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $tc_point));
                            $this->addPointRecord(config('web_uid'), $tc_point, '获利', "你的站点用户{$this->uid}下单消费{$need}金币，你获得了{$tc_point}金币利润！");
                            //$this->addTc($this->uid, $this->userInfo['upid'], $need);
                        }
                        //消费上级提成
                        if ($this->userInfo['upid'] && config('zz_invite_rate') > 0 && $upRow = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $this->userInfo['upid']))) {
                            $tc_point = round(config('zz_invite_rate') * $need / 100, 2);
                            $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                            $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}消费{$need}金币，你获得了{$tc_point}金币提成！");
                        }

                        $this->assign('alert', sweetAlert('下单成功', "成功为QQ:{$uin}下单{$num}月{$tool}，消费{$need}金币！", 'success', url('qqInfo', ['qid' => $qid])));
                    } else {
                        $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                    }
                }
            }
        }

        $this->assign('webTitle', '自助下单');
        return $this->fetch();
    }

    private function addQQ($uin, $pwd)
    {
        $skey = 'no';
        $p_skey = 'no';
        $cookiezt = 1;
        if ($row = $this->pdo->find("select qid from pre_qqs where uin=:uin limit 1", array(':uin' => $uin))) {
            $this->pdo->execute('update pre_qqs set uid=:uid,pwd=:pwd,cookiezt=:cookiezt,zt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(':qid' => $row['qid'], ':uid' => $this->uid, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':cookiezt' => $cookiezt));
        } else {
            $id = strtoupper(substr(md5($uin . time()), 0, 8) . '-' . uniqid());
            $this->pdo->execute("INSERT INTO `pre_qqs` (`uid`, `uin`, `pwd`, `zt`, `cookiezt`, `skey`, `p_skey`, `addtime`, `id`) VALUES (:uid, :uin, :pwd, 0, :cookiezt, :skey, :p_skey, NOW(), :id)", array(':uid' => $this->uid, ':uin' => $uin, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':id' => $id, ':cookiezt' => $cookiezt));
            $row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin));
            $qid = $row['qid'];
        }
        return $row['qid'];
    }

    public function shequ()
    {

        $power = $this->userInfo['power'];
        $sqList = $this->pdo->selectAll("select * from pre_shequs order by sqid asc");
        foreach ($sqList as $k => $v) {
            $price = $v['price'];
            if ($row = $this->pdo->find("select * from pre_shequ_prices where zid=:zid and sqid=:id limit 1", array(':zid' => ZID, ':id' => $v['sqid']))) {
                $price = (isset($row['p' . $power])) ? $row['p' . $power] : $price;
            } else {
                $this->pdo->execute("INSERT INTO `pre_shequ_prices` (`zid`, `sqid`) VALUES (:zid, :id)", array(':zid' => ZID, ':id' => $v['sqid']));
            }
            $sqList[$k]['p'] = $price;
        }
        $this->assign('sqList', $sqList);
        $qqList = $this->pdo->selectAll("select qid,uin from pre_qqs where uid=:uid order by qid desc", array(':uid' => $this->uid));
        $this->assign('qqList', $qqList);

        if (IS_POST) {
            $qid = input('post.qid/d');
            $pwd = input('post.pwd');
            $sqid = input('post.sqid/d');
            $num = input("post.num/d");
            $num = ($num > 1) ? $num : 1;
            if (!$uin = $this->isExist($qid, $qqList, 'qid', 'uin')) {
                $this->assign('alert', sweetAlert('温馨提示', '选择QQ不存在！', 'warning'));
            } elseif (!$sqRow = $this->isExist($sqid, $sqList, 'sqid', 'array')) {
                $this->assign('alert', sweetAlert('温馨提示', '选择代刷项目不存在！', 'warning'));
            } elseif ($this->userInfo['point'] < ($sqRow['p'] * $num)) {
                $this->assign('alert', sweetAlert('金币不足', "账户金币不足" . ($sqRow['p'] * $num) . "，请先充值！", 'warning'));
            } else {
                $sqName = $sqRow['name'];
                $price = $sqRow['p'] * $num;
                $isFinish = false;

                if ($row = $this->pdo->find("select * from pre_shequ_orders where qid=:qid and sqid=:sqid and status=0 limit 1", array(':qid' => $qid, ':sqid' => $sqid))) {
                    if ($this->pdo->execute("update pre_shequ_orders set num=num+:num where id=:id limit 1", array(':num' => $num, ':id' => $row['id']))) {
                        $isFinish = true;
                    }
                } else {
                    if ($this->pdo->execute("INSERT INTO `pre_shequ_orders` (`qid`, `pwd`,`uid`, `sqid`, `num`, `addtime`) VALUES (:qid, :pwd,:uid, :sqid, :num, NOW())", array(':qid' => $qid, ':pwd' => $pwd, ':uid' => $this->uid, ':sqid' => $sqid, ':num' => $num))) {
                        $isFinish = true;
                    }
                }


                if ($isFinish) {
                    $this->pdo->execute('update pre_users set point=point-:point where uid=:uid limit 1', array(':uid' => $this->uid, ':point' => $price));
                    //消费记录
                    $this->addPointRecord($this->uid, $price, '消费', "成功为QQ:{$uin}下单{$num}份{$sqName}，消费{$price}金币！");
                    //消费站长获利
                    $tc_point = ($sqRow['p'] - $sqRow['price']) * $num;
                    if ($tc_point > 0) {
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => config('web_uid'), ":point" => $tc_point));
                        $this->addPointRecord(config('web_uid'), $tc_point, '获利', "你的站点用户{$this->uid}下单消费{$price}金币，你获得了{$tc_point}金币利润！");
                    }
                    //消费上级提成
                    if ($this->userInfo['upid'] && config('zz_invite_rate') > 0 && $upRow = $this->pdo->find("select * from pre_users where uid=:uid limit 1", array(':uid' => $this->userInfo['upid']))) {
                        $tc_point = round(config('zz_invite_rate') * $price / 100, 2);
                        $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->userInfo['upid'], ":point" => $tc_point));
                        $this->addPointRecord($this->userInfo['upid'], $tc_point, '提成', "你的下级用户{$this->uid}消费{$price}金币，你获得了{$tc_point}金币提成！");
                    }

                    $this->assign('alert', sweetAlert('下单成功', "成功为QQ:{$uin}下单{$num}份{$sqName}，消费{$price}金币！", 'success'));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '下单失败，请稍后再试！', 'warning'));
                }

            }
        }

        $pageList = new Page($this->pdo->getCount("select * from pre_shequ_orders where uid=:uid", array(':uid' => $this->uid)), 10);
        $orderList = $this->pdo->selectAll("select a.*,b.uin,c.name from pre_shequ_orders as a left join pre_qqs as b on b.qid=a.qid left join pre_shequs as c on c.sqid=a.sqid where a.uid=:uid order by a.id desc " . $pageList->limit, array(':uid' => $this->uid));

        $this->assign('pageList', $pageList);
        $this->assign('orderList', $orderList);
        $this->assign('webTitle', '代刷下单');
        return $this->fetch();
    }

	public function daishua()
    {
        $this->assign('webTitle', '代刷系统');
        return $this->fetch();
    }

    public function msg()
    {
        $pageList = new Page($this->pdo->getCount("select id from pre_message where uid=:uid", array(':uid' => $this->uid)), 10);
        $msgList = $this->pdo->selectAll("select * from pre_message where uid=:uid or uid<2 order by id desc " . $pageList->limit, array(':uid' => $this->uid));

        $this->assign('zzqq', config('web_qq'));
        $this->assign('pageList', $pageList);
        $this->assign('msgList', $msgList);
        $this->assign('webTitle', '站内信系统');
        return $this->fetch();
    }

    public function msginfo($id)
    {
        $id = intval($id);
        if (!$info = $this->pdo->find("select * from pre_message where id=:id limit 1", array(':id' => $id))) {
            $this->assign('alert', sweetAlert('温馨提示', '消息不存在！', 'warning'));
            return $this->fetch('common/sweetalert');
        }
        $code = '1';
        $this->pdo->execute("update pre_message set state=:state where id=:id limit 1", array(':id' => $id, ':state' => $code));

        $this->assign('info', $info);
        $this->assign('webTitle', '站内信-' . $info['id']);
        return $this->fetch();
    }


    public function gongdan()
    {
        if (IS_POST) {
            $uid = $this->uid;
            $state = '0';
            $type = input('post.type');
            $title = input('post.title');
            $text = input('post.msg');
            if ($this->pdo->execute("INSERT INTO `pre_gongdan` (`uid`, `state`, `title`, `text`, `type`, `addtime`) VALUES (:uid, :state, :title, :text, :type, NOW())", array(':uid' => $uid, ':state' => $state, ':title' => $title, ':text' => $text, ':type' => $type))) {
                $this->assign('alert', sweetAlert('温馨提示', '提交工单成功 ，请耐心等待客服处理！', 'success'));
            } else {
                $this->assign('alert', sweetAlert('温馨提示', '提交失败 ，请稍后再试！', 'warning'));
            }
        }

        $pageList = new Page($this->pdo->getCount("select id from pre_gongdan where uid=:uid", array(':uid' => $this->uid)), 10);
        $gdList = $this->pdo->selectAll("select * from pre_gongdan where uid=:uid order by id desc " . $pageList->limit, array(':uid' => $this->uid));

        $this->assign('pageList', $pageList);
        $this->assign('gdList', $gdList);
        $this->assign('webTitle', "工单系统");
        return $this->fetch();
    }


    private function addOrder($qid, $tid, $num = 1)
    {
        if ($tid == 1) {
            $stmt = $this->pdo->getStmt("select tid from pre_tools where tid in (2,3,4,5,6,7,8,9) order by tid asc");
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

    public function qqAdd($qid = 0)
    {
		$qid = intval($qid);
        if ($qid && $row = $this->pdo->find("select uin,pwd from pre_qqs where uid=:uid and qid=:qid limit 1", array(':qid' => $qid, ':uid' => $this->uid))) {
            $this->assign('qqInfo', $row);
        }
		if(IS_POST){
			$uin = input('post.uin');
			$pwd = input('post.pwd');
			if(isset($_POST['skey']) && isset($_POST['pskey'])){
				$skey = input('post.skey');
				$p_skey = input('post.pskey');
				$cookiezt = 0;
			}else{
				$skey = 'no';
				$p_skey = 'no';
				$cookiezt = 1;
			}
			
			if ($row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin))) {
				$this->pdo->execute('update pre_qqs set uid=:uid,pwd=:pwd,cookiezt=:cookiezt,zt=0,skey=:skey,p_skey=:p_skey where qid=:qid limit 1', array(':qid' => $qid, ':uid' => $this->uid, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':cookiezt' => $cookiezt));
				$isUpdate = true;
			} else {
				if(strlen($uin)<5 || !is_numeric($uin)){
					$this->assign('alert', sweetAlert('添加失败', '你所添加的QQ格式错误！', 'warning', 'REFERER'));
					return $this->fetch('common/sweetalert');
				}
				$id=strtoupper(substr(md5($uin.time()),0,8).'-'.uniqid());
				$this->pdo->execute("INSERT INTO `pre_qqs` (`uid`, `uin`, `pwd`, `cookiezt`, `skey`, `p_skey`, `addtime`, `id`) VALUES (:uid, :uin, :pwd, :cookiezt, :skey, :p_skey, NOW(), :id)", array(':uid' => $this->uid, ':uin' => $uin, ':pwd' => $pwd, ':skey' => $skey, ':p_skey' => $p_skey, ':id' => $id, ':cookiezt' => $cookiezt));
				$row = $this->pdo->find('select qid from pre_qqs where uin=:uin limit 1', array(':uin' => $uin));
				$isUpdate = false;
			}
			$qid = $row['qid'];

			if ($isUpdate) {
				$this->assign('alert', sweetAlert('更新密码成功', $uin.'密码更新成功,查看QQ详情!', 'success', url("/index/Panel/qqInfo",['qid'=>$qid])));
			} elseif($qid) {
				$this->assign('alert', sweetAlert('添加QQ成功', $uin.'添加成功，现在去下单!', 'success', url("/index/Panel/order",['qid'=>$qid])));
			} else {
				$this->assign('alert', sweetAlert('添加失败', $uin.'添加失败，请返回重试', 'warning', 'REFERER'));
			}
		}
        
        $this->assign('webTitle', '添加/更新QQ');
        return $this->fetch();
    }

    public function apicontrol()
    {
        //加载商品列表
        $this->assign('webTools', $this->pdo->selectAll("select * from pre_tools where tid !=1 order by tid asc"));

        if (IS_POST && $_POST['apply'] == 1) {
            $this->pdo->execute("INSERT INTO `pre_apis` (`uid`, `apikey`, `active`, `time`) VALUES (:uid, :apikey, 1,NOW())", array(':uid' => $this->uid, ':apikey' => getSid()));
            $this->assign('alert', sweetAlert('申请APIKey成功', '申请APIKey成功', 'success', 'REFERER'));
        }
        if ($row = $this->pdo->find("select * from pre_apis where uid=:uid limit 1", array(':uid' => $this->uid))) {
            $this->assign('apirow', $row);
            $isapi = true;
        } else {
            $isapi = false;
        }
        $this->assign('isapi', $isapi);
        $this->assign('webTitle', 'API管理');
        return $this->fetch();
    }

    public function kami()
    {
        $power = $this->userInfo['power'];
        $price_all = explode("|", config('web_price_all'));
        $priceAll = isset($price_all[$power]) && $price_all[$power] >= config('zz_price_all') ? $price_all[$power] : config('zz_price_all');
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
                    $this->assign('alert', sweetAlert('温馨提示', '生成' . $num . '张卡密需要' . $need . '金币，你当前只有' . $this->userInfo['point'] . '金币，请充值！', 'warning'));
                } else {
                    $kms = '';
                    for ($i = 0; $i < $num; $i++) {
                        $km = getRandStr(16);
                        if ($this->pdo->execute("INSERT INTO `pre_dgkms` (`zid`, `uid`, `km`, `value`, `addtime`) VALUES (:zid, :uid, :km, :value, NOW())", array(':zid' => ZID, ':uid' => $this->uid, ':km' => $km, ':value' => $value))) {
                            //扣金币
                            $this->pdo->execute("update pre_users set point=point-:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $priceAll * $value));
                            $this->userInfo['point'] = $this->userInfo['point'] - $priceAll * $value;
                            $kms .= $km . '<br>';
                        }
                    }
                    $this->addPointRecord($this->uid, $need, '消费', "你生成全套代挂卡密消费了{$need}！");
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
                    $backpoint = $priceAll * $row['value'];
                    $this->pdo->execute("update pre_users set point=point+:point where uid=:uid limit 1", array(':uid' => $this->uid, ':point' => $backpoint));
                    $this->assign('alert', sweetAlert('删除成功', "成功删除卡密{$row['km']},由于该卡密未使用，已退回{$backpoint}金币至你账户！", 'success', 'REFERER'));
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

        if (IS_POST) {
            $action = input("post.action");
            if ($action == 'send') {
                $message = strip_tags(input("post.message"));
                //$timelimits=date("Y-m-d H:i:s",time()+$timelimit);
                //$ipcount=$this->pdo->getCount("SELECT id FROM pre_chats WHERE `addtime`<:time limit ".$iplimit);
                if (strlen($message) < 3) {
                    $this->assign('alert', sweetAlert('发送失败', '聊天内容太短！', 'warning'));
                } elseif (!$this->checkChat($message)) {
                    $this->assign('alert', sweetAlert('发送失败', '对不起，你的聊天内容含有敏感词汇！', 'warning'));
                } else {
                    if (!$this->pdo->execute("INSERT INTO `pre_chats` (`zid`, `user`, `qq`, `message`, `addtime`) VALUES (:zid, :user, :qq, :message, NOW())", array(':zid' => ZID, ':user' => $this->userInfo['user'], ':qq' => $this->userInfo['qq'], ':message' => $message))) {
                        $this->assign('alert', sweetAlert('发送失败', '发送失败，请稍后再试！', 'warning'));
                    }
                }

            }
        }
        //首页聊天数据发送


        if (IS_POST) {
            $qq = input('post.qq');
            $pwd = input('post.pwd');
            //$this->assign('alert', sweetAlert('温馨提示', '测试站点禁止修改密码！', 'warning'));
            if ($pwd && strlen($pwd) < 5) {
                $this->assign('alert', sweetAlert('温馨提示', '新密码太简单！', 'warning'));
            } else {
                if ($pwd) {
                    $pwd = getPwd($pwd);
                } else {
                    $pwd = $this->userInfo['pwd'];
                }
                if ($this->pdo->execute('update pre_users set qq=:qq,pay_account=:pay_account,pay_name=:pay_name,pwd=:pwd where uid=:uid limit 1', array(':qq' => $qq, ':pwd' => $pwd, ':pay_account' => input('post.pay_account'), ':pay_name' => input('post.pay_name'), ':uid' => $this->uid))) {
                    $this->assign('alert', sweetAlert('更新成功', '修改成功！', 'success'));
                } else {
                    $this->assign('alert', sweetAlert('温馨提示', '修改失败,请稍候再试！', 'warning'));
                }
            }
        }

        //数据统计
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
        $this->assign('amount', $amount);

        $zzqq = config('web_qq');

        $this->assign('amount', $amount);
        $this->assign('zzqq', $zzqq);


        $ggall = explode('|', config('web_gg_panel'));
        if ($ggall[0]==null) $ggall = array('没有公告内容,请到后台设置');

        $this->assign('ggall', $ggall);


        $this->assign('webTitle', '用户控制面板');
        return $this->fetch();
    }

    private function isExist($value, $arr, $key, $return = null)
    {
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

    private function addTc($uid, $upid = 0, $point, $rate, $bz = null)
    {
        if (!$upid) {
            return false;
        }
        if (!$rate) {
            return false;
        }
        $tcPoint = sprintf("%.2f", $point * $rate / 100);
        if (!$bz) {
            $bz = "获得下级UID:{$uid}消费{$point}金币的提成，提成{$tcPoint}金币！";
        }
        $this->addPointRecord($upid, $tcPoint, '提成', $bz);
    }

    private function addPointRecord($uid, $point = 0, $action = '消费', $bz = null)
    {
        $this->pdo->execute("INSERT INTO `pre_points` (`uid`, `action`, `point`, `bz`, `addtime`) VALUES (:uid, :action, :point, :bz, NOW())", array(':uid' => $uid, ':point' => $point, ':action' => $action, ':bz' => $bz));
    }

    private function getMessage()
    {
        $rows = $this->pdo->selectAll("select a.*,b.user,b.qq from pre_messages as a left join pre_users as b on b.uid=a.fid where a.uid=:uid order by a.id desc limit 5", array(':uid' => $this->uid));
        $look = 0;
        $forceId = 0;
        foreach ($rows as $row) {
            if (!$row['islook']) {
                if (!$forceId && $row['force']) {
                    $forceId = $row['id'];
                }
                $look++;
            }
        }
        $this->assign('forceId', $forceId);
        $this->assign('message_look', $look);
        $this->assign('message_list', $rows);
    }

    function __construct()
    {
        parent::__construct();
        //判断是否已登录
        if (empty($this->userInfo)) {
            $this->assign('alert', sweetAlert('未登录', '请先登录！', 'warning', url('/index/Index/login')));
            exit($this->fetch('common/sweetalert'));
        }
		$app_conf = @unserialize(config('web_app_conf'));
		$this->assign('app_url', $app_conf['app_url']);
        $this->getMessage();
    }
}