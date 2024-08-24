<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 消失的彩虹海 <www.cccyun.cc>
// +----------------------------------------------------------------------
// | Date: 2016/6/1
// +----------------------------------------------------------------------


class QQSignIn
{
    private $uin;
    private $skey;
    private $p_skey;
    private $cookie;
    private $g_tk;
    private $g_tk1;
    private $g_tk2;
    private $msg = array();
    public $skeyzt = 0;

    function __construct($uin, $skey, $p_skey)
    {
        $this->uin = $uin;
        $this->skey = $skey;
        $this->p_skey = $p_skey;
        $this->cookie = "pt2gguin=o0{$uin}; uin=o0{$uin}; skey={$skey}; p_uin=o0{$uin}; p_skey={$skey};";
        $this->g_tk = $this->getGTK($skey);
        $this->g_tk1 = $this->getGTK($p_skey);
        $this->g_tk2 = $this->getGTK2($skey);
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function qd(){
        $this->fzqd();
        $this->vipqd();
        $this->lzqd();
        $this->hzqd();
    }

	public function qqgame(){
		$url = 'https://reader.sh.vip.qq.com/cgi-bin/common_async_cgi?g_tk='.$this->g_tk.'&plat=1&version=6.6.6&param=%7B%22key0%22%3A%7B%22param%22%3A%7B%22bid%22%3A13792605%7D%2C%22module%22%3A%22reader_comment_read_svr%22%2C%22method%22%3A%22GetReadAllEndPageMsg%22%7D%7D';
		$data = $this->get_curl($url,0,$url,$this->cookie);
		$arr = json_decode($data, true);
		if(array_key_exists('ecode',$arr) && $arr['ecode']==0){
			$this->msg[]='QQ手游加速0.2天成功！';
		}else{
			$this->msg[]='QQ手游加速失败！'.$data;
		}
	}

	public function pqd(){
		$url="http://proxy.vac.qq.com/cgi-bin/srfentry.fcgi?ts=".time()."9813&g_tk=".$this->g_tk."&data={%2210752%22:{%22giveOpt%22:0}}&pt4_token=";
		$data = $this->get_curl($url,0,'https://i.qianbao.qq.com/wallet/recharge/dist/m/index_v4.html?_wv=1031&noTab=1&tab=fee&payChannel=task_activity&source=sng_308803&taskPlugin=1&pvsrc=311&bottom=50',$this->cookie);
		$arr = json_decode($data, true);
		$arr = $arr['10752'];
		if(array_key_exists('ret',$arr) && $arr['ret']==0){
			$this->msg[]='钱包签到成功！';
		}elseif($arr['ret']==-4){
			$this->msg[]='钱包签到失败！你没有绑定银行卡';
		}elseif($arr['ret']==-5){
			$this->msg[]='你今天已钱包签到！';
		}else{
			$this->msg[]='钱包签到失败！'.$arr['msg'];
		}

		$url="http://proxy.vac.qq.com/cgi-bin/srfentry.fcgi?ts=".time()."9813&g_tk=".$this->g_tk."&data={%2210975%22:{%22sIn%22:{%22uin%22:0}}}&pt4_token=";
		$data = $this->get_curl($url,0,$url,$this->cookie);
		$arr = json_decode($data, true);
		$arr = $arr['10975'];
		if(array_key_exists('ret',$arr) && $arr['ret']==0){
			$this->msg[]='钱包签到2成功！积分+5，连续签到'.$arr['data']['sOut']['continueDays'].'天';
		}elseif($arr['ret']==1){
			$this->msg[]='你今天已钱包签到2！';
		}else{
			$this->msg[]='钱包签到2失败！'.$arr['msg'];
		}
	}

    public function fzqd()
    {
        $url = 'http://x.pet.qq.com/vip_platform?cmd=set_sign_info&format=json&_=' . time() . '9008';
        $data = $this->get_curl($url, 0, $url, $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('result', $arr) && $arr['result'] == 0) {
            $this->msg[] = $this->uin . ' 粉钻签到成功！';
        } elseif ($arr['result'] == -101) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 粉钻签到失败！SKEY已失效';
        } else {
            $this->msg[] = $this->uin . ' 粉钻签到失败！' . $arr['msg'];
        }
    }

    public function vipqd()
    {
        $data=$this->get_curl("http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=79968&format=json&g_tk=" . $this->g_tk2 ."&cachetime=".time(),0,'http://vip.qq.com/',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0)
			$this->msg[] = $this->uin.' 会员面板签到成功！';
		elseif($arr['ret']==10601)
			$this->msg[] = $this->uin.' 会员面板今天已经签到！';
		elseif($arr['ret']==10002){
			$this->skeyzt=1;
			$this->msg[] = $this->uin.' 会员面板签到失败！SKEY过期';
		}elseif($arr['ret']==20101)
			$this->msg[] = $this->uin.' 会员面板签到失败！不是QQ会员！';
		else
			$this->msg[] = $this->uin.' 会员面板签到失败！'.$arr['msg'];

		$data=$this->get_curl("http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=23314&format=json&g_tk=" . $this->g_tk2 ."&cachetime=".time(),0,'http://vip.qq.com/',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0)
			$this->msg[] = $this->uin.' 会员网页版签到成功！';
		elseif($arr['ret']==10601)
			$this->msg[] = $this->uin.' 会员网页版今天已经签到！';
		elseif($arr['ret']==10002){
			$this->skeyzt=1;
			$this->msg[] = $this->uin.' 会员网页版签到失败！SKEY过期';
		}elseif($arr['ret']==20101)
			$this->msg[] = $this->uin.' 会员网页版签到失败！不是QQ会员！';
		else
			$this->msg[] = $this->uin.' 会员网页版签到失败！'.$arr['msg'];

		$data=$this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?actid=52002&rand=0.27489888'.time().'&g_tk='.$this->g_tk2.'&format=json',0,'http://vip.qq.com/',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0)
			$this->msg[] = $this->uin.' 会员手机端签到成功！';
		elseif($arr['ret']==10601)
			$this->msg[] = $this->uin.' 会员手机端今天已经签到！';
		elseif($arr['ret']==10002){
			$this->skeyzt=1;
			$this->msg[] = $this->uin.' 会员手机端签到失败！SKEY过期';
		}else
			$this->msg[] = $this->uin.' 会员手机端签到失败！'.$arr['msg'];

		$data=$this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=54963&isLoadUserInfo=1&format=json&g_tk='.$this->g_tk2,0,'http://vip.qq.com/',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0)
			$this->msg[] = $this->uin.' 会员积分签到成功！';
		elseif($arr['ret']==10601)
			$this->msg[] = $this->uin.' 会员积分今天已经签到！';
		elseif($arr['ret']==10002){
			$this->skeyzt=1;
			$this->msg[] = $this->uin.' 会员积分签到失败！SKEY过期';
		}else
			$this->msg[] = $this->uin.' 会员积分签到失败！'.$arr['msg'];

		$data=$this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=23074&format=json&g_tk='.$this->g_tk2,0,'http://vip.qq.com/',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0)
			$this->msg[] = $this->uin.' 会员积分手机端签到成功！';
		elseif($arr['ret']==10601)
			$this->msg[] = $this->uin.' 会员积分手机端今天已经签到！';
		elseif($arr['ret']==10002){
			$this->skeyzt=1;
			$this->msg[] = $this->uin.' 会员积分手机端签到失败！SKEY过期';
		}else
			$this->msg[] = $this->uin.' 会员积分手机端签到失败！'.$arr['msg'];
    }

    public function lzqd()
    {
        $url = 'http://share.music.qq.com/fcgi-bin/dmrp_activity/fcg_feedback_send_lottery.fcg?activeid=110&rnd=' . time() . '157&g_tk=' . $this->g_tk . '&uin=' . $this->uin . '&hostUin=0&format=json&inCharset=UTF-8&outCharset=UTF-8&notice=0&platform=activity&needNewCode=1';
        $data = $this->get_curl($url, 0, 'http://y.qq.com/vip/fuliwo/index.html', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('code', $arr) && $arr['code'] == 0) {
            if ($arr['data']['alreadysend'] == 1)
                $this->msg[] = '您今天已经签到过了！';
            else
                $this->msg[] = '绿钻签到成功！';
        } elseif ($arr['code'] == -200017) {
            $this->msg[] = '你不是绿钻无法签到！';
        } else {
            $this->msg[] = '绿钻签到失败！';
        }

        $url = 'http://share.music.qq.com/fcgi-bin/dmrp_activity/fcg_dmrp_draw_lottery.fcg?activeid=159&rnd=' . time() . '482&g_tk=' . $this->g_tk . '&uin=' . $this->uin . '&hostUin=0&format=json&inCharset=UTF-8&outCharset=UTF-8&notice=0&platform=activity&needNewCode=1';
        $data = $this->get_curl($url, 0, 'http://y.qq.com/vip/fuliwo/index.html', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '绿钻抽奖成功！';
        } elseif ($arr['code'] == 200008) {
            $this->msg[] = '您没有抽奖机会！';
        } else {
            $this->msg[] = '绿钻抽奖失败！';
        }

    }

    public function hzqd()
    {
		$url = 'http://vip.qzone.qq.com/fcg-bin/v2/fcg_mobile_vip_site_checkin?t=0.89457'.time().'&g_tk='.$this->g_tk.'&qzonetoken=423659183';
		$post = 'uin='.$this->uin.'&format=json';
		$referer='http://h5.qzone.qq.com/vipinfo/index?plg_nld=1&source=qqmail&plg_auth=1&plg_uin=1&_wv=3&plg_dev=1&plg_nld=1&aid=jh&_bid=368&plg_usr=1&plg_vkey=1&pt_qzone_sig=1';
		$data = $this->get_curl($url,$post,$referer,$this->cookie);
		$arr = json_decode($data, true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='黄钻签到成功！';
		}elseif(array_key_exists('code',$arr) && $arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='黄钻签到失败！SKEY已失效';
		}elseif(array_key_exists('code',$arr)){
			$this->msg[]='黄钻签到失败！'.$arr['message'];
		}else{
			$this->msg[]='黄钻签到失败！'.$data;
		}

		$url = 'http://activity.qzone.qq.com/fcg-bin/fcg_huangzuan_daily_signing?t=0.'.time().'906035&g_tk='.$this->g_tk.'&qzonetoken=-1';
		$post = 'option=sign&uin='.$this->uin.'&format=json';
		$data = $this->get_curl($url,$post,$url,$this->cookie);
		$arr = json_decode($data, true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='黄钻公众号签到成功！';
		}elseif(array_key_exists('code',$arr) && $arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='黄钻公众号签到失败！SKEY已失效';
		}elseif($arr['code']==-90002){
			$this->msg[]='黄钻公众号签到失败！非黄钻用户无法签到';
		}elseif(array_key_exists('code',$arr)){
			$this->msg[]='黄钻公众号签到失败！'.$arr['message'];
		}else{
			$this->msg[]='黄钻公众号签到失败！'.$data;
		}
    }


    private function getGTK($skey)
    {
        $len = strlen($skey);
        $hash = 5381;
        for ($i = 0; $i < $len; $i++) {
            $hash += (($hash << 5) & 0xffffffff) + ord($skey[$i]);
        }
        return $hash & 0x7fffffff;//计算g_tk
    }

    private function getGTK2($skey)
    {
        $salt = 5381;
        $md5key = 'tencentQQVIP123443safde&!%^%1282';
        $hash = array();
        $hash[] = ($salt << 5);
        $len = strlen($skey);
        for ($i = 0; $i < $len; $i++) {
            $ASCIICode = mb_convert_encoding($skey[$i], 'UTF-32BE', 'UTF-8');
            $ASCIICode = hexdec(bin2hex($ASCIICode));
            $hash[] = (($salt << 5) + $ASCIICode);
            $salt = $ASCIICode;
        }
        $md5str = md5(implode($hash) . $md5key);
        return $md5str;
    }

    private function get_curl($url, $post = 0, $referer = 1, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept:application/json";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        //$ret=mb_convert_encoding($ret, "UTF-8", "UTF-8");
        return $ret;
    }


}