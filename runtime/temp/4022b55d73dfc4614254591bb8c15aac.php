<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\mainset.html";i:1534346042;s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\layout.html";i:1533918960;s:70:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/common\layout.html";i:1534520952;s:67:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\left.html";i:1564049553;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if(config('zz_nmusicoff') == 1): ?>
 <!-- Your XlchPlayerKey -->
<script>XlchKey="<?php echo config('zz_musickey'); ?>";</script>
<!-- font-awesome 4.2.0 -->
<link href="//lib.baomitu.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- JQuery 2.2.4 -->
<script src="//lib.baomitu.com/jquery/2.2.4/jquery.min.js"></script>
<!-- JQuery-mousewheel 3.1.9 -->
<script src="//lib.baomitu.com/jquery-mousewheel/3.1.9/jquery.mousewheel.min.js"></script>
<!-- Scrollbar -->
<script src="//static.badapple.top/BadApplePlayer/js/scrollbar.js"></script>
<!-- BadApplePlayer -->
<script src="//static.badapple.top/BadApplePlayer/Player.js"></script>
<?php endif; ?>
  <meta charset="utf-8" />
  <title><?php echo $webTitle; ?>-<?php echo config('web_name'); ?></title>
  <meta name="keywords" content="代挂平台,加速代挂,QQ等级加速,免费代挂秒赞,全套加速,代挂宝,全民代挂,勋章墙,电脑管家,qq音乐分享,iphone在线" />
  <meta name="description" content="提供最快最稳定的免费等级加速代挂服务，让自己的QQ等级飞起来！刻不容缓，快加入我们吧！" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="renderer" content="webkit" />
    <!-- CSS JS文件加载 -->
  <link rel="stylesheet" href="/assets/Public/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/css/font.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/css/app.css" type="text/css" />
  <link rel="stylesheet" href="/assets/Public/Style/sweetalert/sweetalert.css" type="text/css" />
  <script src="/assets/Public/Style/js/jquery-2.1.1.min.js"></script>
  <script src="/assets/Public/Style/js/jquery.pjax.min.js"></script>
  <script src="/assets/Public/Style/layer/layer.js"></script>
  <script src="/assets/Public/Style/laydate/laydate.js"></script>
  <script src="/assets/Public/js/xiaoke-app.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- CSS JS文件结束 -->
	<link href="/assets/style1/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/style1/js/modernizr.min.js"></script>
	<script src="/assets/style1/js/jquery.min.js"></script>
	
	
	
	
	
	
 <!-- build:css /tmp/assets/css/app.min.css -->

    

</head>







<div id="wrapper" class="preload">
    <body>

 <div class="app app-header-fixed">
<section id="containerdemo">
    <!-- 导航部分开始 -->
    <div class="app-header navbar">
        <div class="navbar-header bg-info dk">
            <button class="pull-right visible-xs" data-toggle="class:off-screen" data-target=".app-aside" ui-scroll="app">
                <i class="fa fa-bars"></i>
            </button>
            <button class="pull-right visible-xs" data-toggle="class:show" data-target=".navbar-collapse">
                <i class="fa fa-gear"></i>
            </button>
            <a href="/" class="navbar-brand text-lt text-center">
                <i class="fa fa-rocket"></i>
                <span class="hidden-folded m-l-xs"><?php echo config('web_name'); ?></span>
            </a>
        </div>

        <div class="collapse pos-rlt navbar-collapse box-shadow bg-info dk">
            <div class="nav navbar-nav hidden-xs">
                <a href="javascript:;" class="btn no-shadow navbar-btn" data-toggle="class:app-aside-folded" data-target=".app">
                    <i class="fa fa-dedent fa-fw text"></i>
                    <i class="fa fa-indent fa-fw text-active"></i>
                </a>
                <a href="<?php echo url('index'); ?>" class="btn no-shadow navbar-btn" >
                    <i class="fa fa-user-circle"></i>
                </a>
            </div>

        
            <ul class="nav navbar-nav navbar-right">
                               
                <li class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
                        <span class="hidden-sm hidden-md">商城</span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight w">
                        <li><a href="/index/panel/recharge" ><i class="fa fa-cny"></i> &nbsp;&nbsp;账户充值</a></li>
                        <li><a href="/index/panel/shop" ><i class="fa fa-eur"></i> &nbsp;&nbsp;开通代理</a></li>
                        <li><a href="<?php echo url('ktfz'); ?>" ><i class="fa fa-chain"></i> &nbsp;&nbsp;搭建分站</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                            <img alt="image" class="img-full" src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $userInfo['qq']; ?>&spec=40" style="width:70px;">
                            <i class="on md b-white bottom"></i>
                        </span>
                        <span class="hidden-sm hidden-md"><?php echo $userInfo['user']; ?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight w">
                        <li class="wrapper b-b m-b-sm bg-light m-t-n-xs">
                            <div>
                                <p class="text-center"><?php echo $userInfo['user']; ?></p>
                            </div>
                            <progressbar value="60" class="progress-xs m-b-none bg-white"></progressbar>
                        </li>
                        <li><a href="/index/panel/profile" ><i class="fa fa-user-circle-o"></i> &nbsp;&nbsp;账户资料</a></li>
                        <li><a href="/index/panel/profile"><i class="fa fa-chain"></i> &nbsp;&nbsp;密码修改</a></li>
                        <li class="divider"></li>
                      <li><a href="/index/index/logout.html" ><i class="fa fa-sign-out"></i> &nbsp;&nbsp;退出登陆</a></li>
                    </ul>
                </li>
            </ul>
            

        </div>
        <div id="loading" class="app-footer" style="display:none">
            <div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
        </div>
    </div>

    <div class="app-aside hidden-xs bg-white b-r">
        <div class="aside-wrap">
            <div class="navi-wrap">
            
                <div class="clearfix text-center">
                    <div class="dropdown wrapper">
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                            <span class="thumb-lg w-auto-folded avatar">
                                <img alt="image" class="img-full b b-3x b-white" src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $userInfo['qq']; ?>&spec=100" style="width:70px;border:1px solid #B5B5B5;padding:3px;">
                            </span>
                        </a>
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                            <span class="clear">
                                <span class="block m-t-sm">
                                    <strong class="font-bold text-lt"><?php echo $userInfo['user']; ?></strong> 
                                    <b class="caret"></b>
                                </span>
                                <span class="text-muted text-xs block">UID<?php echo $userInfo['uid']; ?></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                            <li class="wrapper b-b m-b-sm bg-info m-t-n-xs">
                                <span class="arrow top hidden-folded arrow-info"></span>
                                <div>
                                  <p class="text-center"><?php echo $userInfo['user']; ?></p>
                                </div>
                                <progressbar value="60" type="white" class="progress-xs m-b-none dker"></progressbar>
                            </li>
                            <li><a href="/index/panel/profile" ><i class="fa fa-user-circle-o"></i> &nbsp;&nbsp;账户资料</a></li>
                        <li><a href="/index/panel/profile"><i class="fa fa-chain"></i> &nbsp;&nbsp;密码修改</a></li>
                        <li class="divider"></li>
                      <li><a href="/index/index/logout.html" ><i class="fa fa-sign-out"></i> &nbsp;&nbsp;退出登陆</a></li>
                        </ul>
                    </div>
                    <div class="line dk hidden-folded"></div>
                </div>

                
                <nav ui-nav class="navi">
                    <ul class="nav">
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>用户后台</span>
                        </li>
						
						 
                        <li class="active">
                            <a href="/index/admin/index.html" >
                                <i class="fa fa-dashboard"></i>
                                <span class="font-bold">站长后台</span>
                            </a>
                        </li>    
						  <li class="hidden-folded padder text-muted text-xs">
                            <span>用户中心</span>
                        </li>
                        <li>
                            <a href="/index/panel/index.html" class="auto" >
                                <i class="fa fa-camera-retro fa-lg"></i>
                                <span class="font-bold">用户面板</span>
                            </a>
                        </li>
                                                                   <li class="line dk"></li>
          
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>数据管理</span>
                        </li>
                        
                  
                        <li >
                            <a href="javascript:;" class="auto">      
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-globe"></i>
                                <span class="font-bold">卡密管理</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li >
                                  <a href="<?php echo url('kmList'); ?>" >
                                    <span>余额卡密</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="<?php echo url('kami'); ?>" >
                                    <span>代挂卡密</span>
                                  </a>
                                </li>
                                   
                            </ul>
                        </li>
						
					
                        

						
						
						
						
						
						
						<li >
                            <a href="javascript:;" class="auto">      
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-reorder"></i>
                                <span class="font-bold">数据管理</span>
                            </a>
                            <ul class="nav nav-sub dk">
							<?php if(ZID == 1): ?>
                                <li >
                                  <a href="<?php echo url('qqList'); ?>" >
                                    <span>QQ列表</span>
                                  </a>
                                </li>
								
								<?php endif; ?>
								 <li >
                                  <a href="<?php echo url('userList'); ?>" >
                                    <span>用户列表</span>
                                  </a>
                                </li>     
                                <li >
                                  <a href="<?php echo url('webList'); ?>" >
                                    <span>分站列表</span>
                                  </a>
                                </li>     
                            </ul>
                        </li>
                        
						
						<li >
                            <a href="<?php echo url('ktfz'); ?>" >
                                <i class="fa fa-share-alt"></i>
                                <span class="font-bold">开通分站</span>
                            </a>
                        </li>
						
						<li class="hidden-folded padder text-muted text-xs">
                            <span>网站管理</span>
                        </li>
                        <li >
                            <a href="javascript:;" class="auto">      
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-cog"></i>
                                <span class="font-bold">网站配置</span>
                            </a>
                            <ul class="nav nav-sub dk">
							<?php if(ZID == 1): ?>
                                <li >
                                  <a href="<?php echo url('mainSet'); ?>" >
                                    <span>主站配置</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="<?php echo url('emailSet'); ?>" >
                                    <span>邮箱设置</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="<?php echo url('selectMb'); ?>" >
                                    <span>模板切换</span>
                                  </a>
                                </li>
                              
							 <li >
                                  <a href="<?php echo url('payset'); ?>" >
                                    <span>支付配置</span>
                                  </a>
                                </li>
                              
								 <?php endif; ?>
                                <li >
                                  <a href="<?php echo url('webset'); ?>" >
                                    <span>站点设置</span>
                                  </a>
                                </li>
								 <li >
                                  <a href="<?php echo url('appset'); ?>" >
                                    <span>APP设置</span>
                                  </a>
                                </li>
                           
                                <li >
                                  <a href="<?php echo url('priceset'); ?>" >
                                    <span>价格设置</span>
                                  </a>
                                </li>
                                 <li >
                                  <a href="https://jq.qq.com/?_wv=1027&k=557v329" >
                                    <span>交流QQ群</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="http://idc.dmgzs.cn/" >
                                    <span>缔梦云主机</span>
                                  </a>
                                </li>
				
                            </ul>
                        </li>
						<?php if(ZID == 1): ?>
						<li class="hidden-folded padder text-muted text-xs">
                            <span>订单导出</span>
                        </li>
						
						 <li >
                            <a href="javascript:;" class="auto">      
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-ils"></i>
                                <span class="font-bold">数据导出</span>
                            </a>
							
							 <ul class="nav nav-sub dk"> <?php if(is_array($webTools) || $webTools instanceof \think\Collection): $i = 0; $__LIST__ = $webTools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$webTool): $mod = ($i % 2 );++$i;?>
                                <li >
                                 <a href="<?php echo url('export',['tid'=>$webTool['tid']]); ?>" >
                                    <span><?php echo $webTool['name']; ?></span>
                                  </a>
                                </li>  
								<?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
							
							 <li >
                           
								
								
								<li >
                            <a href="javascript:;" class="auto">      
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-circle"></i>
                                <span class="font-bold">数据导入</span>
                            </a>
                            <ul class="nav nav-sub dk">
                               <li >
                                  <a href="<?php echo url('import'); ?>?kind=pwd" >
                                    <span>密码错误QQ</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="<?php echo url('import'); ?>?kind=bh" >
                                    <span>登陆保护QQ</span>
                                  </a>
                                </li>
                                <li >
                                  <a href="<?php echo url('import'); ?>?kind=dj" >
                                    <span>账号冻结QQ</span>
                                  </a>
                                </li>
							
                            </ul>
                        </li>
								
						
						
                        
							
							 <ul class="nav nav-sub dk"><?php if(is_array($webSqs) || $webSqs instanceof \think\Collection): $i = 0; $__LIST__ = $webSqs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$webSq): $mod = ($i % 2 );++$i;?>
                                <li >
                                 <a href="<?php echo url('sqOrder',['sqid'=>$webSq['sqid']]); ?>" >
                                    <span><?php echo $webSq['name']; ?></span>
                                  </a>
                                </li>  
								<?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
							
                          
                        </li>
						 <?php endif; ?>
						

                        <li class="line dk hidden-folded"></li>
						<li class="hidden-folded padder text-muted text-xs">
                            <span>余额管理理</span>
                        </li>
                        <li >
                            <a href="<?php echo url('tixian'); ?>" >
                                <i class="fa fa-bitcoin"></i>
                                <span class="font-bold">余额提现</span>
                            </a>
                        </li>
                        
                        
                        <li class="line dk"></li>
          
                        <li class="hidden-folded padder text-muted text-xs">          
                            <span>快捷连接</span>
                        </li>
                        <li >
                            <a href="/index/panel/help.html" >
                                <i class="fa fa-line-chart"></i>
                                <span class="font-bold">使用帮助</span>
                            </a>
                        </li>
                         <br>
                         <br><br>
						 <br><br><br>
						 <br><br><br><br>
						 <br><br><br><br>
						 <br><br><br><br><br>
						 <br><br><br><br><br><br>
                                              
                    </ul>
                </nav>
          
            </div>
        </div>
    </div>
    <!-- 导航部分结束 -->
	<script type="text/javascript">get_xiaoxi();</script>


    
<div class="app-content">
    <section id="ajaxshow"></section>
    <section id="container">
    
	<script>document.title="<?php echo $webTitle; ?> - <?php echo config('web_name'); ?>";</script>
    <div class="app-content-body animated fadeInUp">
        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">  
                <div class="bg-light lter b-b wrapper-sm ng-scope">
                    <ul class="breadcrumb">
					    <li><i class="fa fa-home"></i> <a href="/"><?php echo config('web_name'); ?></a></li>

                        <li><?php echo $webTitle; ?></li>
                    </ul>
                </div>
				






<div class="wrapper">
                    


  <div class="wrapper">
                                        
                    
                    <div class="col-sm-12">
                        <div class="panel panel-info">
                            <div class="list-group-item bg-dark m-b-sm"><?php echo $webTitle; ?></div>
                            <form role="form" class="form-horizontal" method="post">
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">主站地址</span>
                                        <input type="text" name="domain" class="form-control"
                                           value="<?php echo config('zz_domain'); ?>">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">分站可选择域名</span>
                                        <input type="text" name="domains" class="form-control"
                                           value="<?php echo config('zz_domains'); ?>">
                                    </div>
									    <pre>多个域名用“,”隔开！</pre>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">主站长QQ</span>
                                         <input type="test" size="11" name="qq" class="form-control" value="<?php echo config('zz_qq'); ?>">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">主站长邮箱</span>
                                       <input type="text" name="zqq" class="form-control" value="<?php echo config('zz_zqq'); ?>">
                                    </div>
                                </div>
							
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">绚丽彩虹首页播放器</span>
                                      <select name="musicoff" class="form-control">
		                            <option value="0" <?php if(config('zz_musicoff') == 0): ?>selected<?php endif; ?>>关闭</option>
		                            <option value="1" <?php if(config('zz_musicoff') == 1): ?>selected<?php endif; ?>>开启</option>
		                            </select>
                                    </div>
                                </div>
								<div class="list-group-item">
								 <div class="input-group">
                                    <span class="input-group-addon">绚丽彩虹内页播放器</span>
                                     <select name="nmusicoff" class="form-control">
		                            <option value="0" <?php if(config('zz_nmusicoff') == 0): ?>selected<?php endif; ?>>关闭</option>
		                            <option value="1" <?php if(config('zz_nmusicoff') == 1): ?>selected<?php endif; ?>>开启</option>
		                            </select>
                                </div>
				 </div>
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">绚丽彩虹key</span>
                                      <input type="test" size="11" name="musickey" class="form-control" value="<?php echo config('zz_musickey'); ?>">
                                    </div>
									<pre>可以设置歌单KEY，<a href="http://www.badapple.top/">点击设置</a></pre>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">QQ登录调用API地址</span>
                                       <input type="text" name="login_api" class="form-control" value="<?php echo config('zz_login_api'); ?>">
                                    </div>
                                </div>
								
							
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">添加QQ模式</span>
                                      <select name="addqq_mode" class="form-control">
									<option value="0" <?php if(config('zz_addqq_mode') == 0): ?>selected<?php endif; ?>>登录并验证QQ密码</option>
									<option value="1" <?php if(config('zz_addqq_mode') == 1): ?>selected<?php endif; ?>>无需验证QQ密码</option>
									</select>
                                    </div>
                                </div>
								
								
						
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">监控密匙</span>
                                       <input type="text" name="cronkey" class="form-control" value="<?php echo config('zz_cronkey'); ?>" placeholder="不可留空">
	 </div>								   
<pre>
自动执行签到，需要监控http://<?php echo $_SERVER['HTTP_HOST']; ?>/cron/qd.php?key=<?php echo config('zz_cronkey'); ?>      频率:10800s
</br>自动执行更新，需要监控http://<?php echo $_SERVER['HTTP_HOST']; ?>/cron/autoupdate.php?key=<?php echo config('zz_cronkey'); ?>     频率:10800s								</br>自动补挂，需要监控http://<?php echo $_SERVER['HTTP_HOST']; ?>/cron/checkfinish.php?key=<?php echo config('zz_cronkey'); ?>      频率:10800s</pre>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">选择对接接口</span>
                                  <select name="getway_api" class="form-control">
		                            <option value="0" <?php if(config('zz_getway_api') == 0): ?>selected<?php endif; ?>>本地代挂接口（适合拥有代挂软件能够自己代挂用户选择）</option>
                                    <option value="1" <?php if(config('zz_getway_api') == 1): ?>selected<?php endif; ?>>管家对接接口（一键对接）</option>
		                            </select>
                                    </div>
									
									  <pre><a href="<?php echo url('admin/syskey'); ?>">查看接口密钥</a></pre>

                                </div>
						
									<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">一次性充值送分站金额</span>
                                       <input type="text" name="price_sfz" class="form-control" value="<?php echo config('zz_price_sfz'); ?>">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">全套代挂提卡价格</span>
                                     <input type="test" name="price_all" class="form-control"
		                                   value="<?php echo config('zz_price_all'); ?>" placeholder="设置普通分站">
										    <input type="test" name="price_all2" class="form-control"
		                                   value="<?php echo config('zz_price_all2'); ?>" placeholder="设置二级主站以及超级主站">
										    <input type="test" name="price_all3" class="form-control"
		                                   value="<?php echo config('zz_price_all3'); ?>" placeholder="设置合作伙伴站">
										    <input type="test" name="price_all4" class="form-control"
		                                   value="<?php echo config('zz_price_all4'); ?>" placeholder="设置分销代理商">
                                    </div>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">单项代挂提卡价格</span>
                                      <input type="test" name="price_dx" class="form-control"
		                                   value="<?php echo config('zz_price_dx'); ?>" placeholder="设置普通分站">
										   <input type="test" name="price_dx2" class="form-control"
		                                   value="<?php echo config('zz_price_dx2'); ?>" placeholder="设置二级主站以及超级主站">
										     <input type="test" name="price_dx3" class="form-control"
		                                   value="<?php echo config('zz_price_dx3'); ?>" placeholder="设置合作伙伴站">
										    <input type="test" name="price_dx4" class="form-control"
		                                   value="<?php echo config('zz_price_dx4'); ?>" placeholder="设置分销代理商">
                                    </div>
                                </div>
						
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">开通各级别网站价格</span>
										 <input type="test" name="price_ktfz" class="form-control"
		                                   value="<?php echo config('zz_price_ktfz'); ?>" placeholder="设置普通分站" >
										   <input type="test" name="price_ktfz_sec" class="form-control"
		                                   value="<?php echo config('zz_price_ktfz_sec'); ?>" placeholder="设置二级主站"> 
                                               <input type="test" name="price_ktfz_sup" class="form-control"
		                                   value="<?php echo config('zz_price_ktfz_sup'); ?>" placeholder="设置超级主站">
										   <input type="test" name="price_ktfz_cp" class="form-control"
		                                   value="<?php echo config('zz_price_ktfz_cp'); ?>" placeholder="设置合作伙伴">
										    <input type="test" name="price_ktfz_da" class="form-control"
		                                   value="<?php echo config('zz_price_ktfz_da'); ?>" placeholder="设置分销代理">
                                    </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">申请提现余额比例</span>
                                   <input type="test" name="tixian_rate" class="form-control"
		                                   value="<?php echo config('zz_tixian_rate'); ?>" placeholder="填写百分数，例如90">
                                    </div>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">申请提现最低余额</span>
                                        <input type="test" name="tixian_min" class="form-control"
		                                   value="<?php echo config('zz_tixian_min'); ?>">
                                    </div>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">分站开分站提成比例(百分数)</span>
                                        <input type="test" name="ktfz_rate" class="form-control"
		                                   value="<?php echo config('zz_ktfz_rate'); ?>" placeholder="填写百分数，例如10">
                                    </div>
                                </div>
			<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">被邀请人下单提成比例(百分数)</span>
                                         <input type="test" name="invite_rate" class="form-control"
		                                   value="<?php echo config('zz_invite_rate'); ?>" placeholder="填写百分数，例如10">
                                    </div>
                                </div>
						
						<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">填写邀请码被邀请方获得奖励</span>
                                        <input type="test" name="invite_rate" class="form-control"
		                                   value="<?php echo config('zz_invite_rate'); ?>" placeholder="填写百分数，例如10">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">填写邀请码邀请方获得奖励</span>
                                       <input type="test" name="point_invite1" class="form-control"
		                                   value="<?php echo config('zz_point_invite1'); ?>">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">每天签到奖励人数</span>
                                         <input type="test" name="qiandao_num" class="form-control" value="<?php echo config('zz_qiandao_num'); ?>" placeholder="0为无限制">
                                    </div>
                                </div>
								
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">签到送余额规则</span>
                                         <input type="text" name="qiandao_rule" class="form-control" value="<?php echo config('zz_qiandao_rule'); ?>">
								   </div>
								    <pre>1:10 代表连续签到1天送10金币，多条规则用1:10,3:20,5:30 代表连续签到第一天送10，第二天送10，第三天送20，第4天送20，第五天送30，以后都是送30。以此类推！</a></pre>
                                </div>
						
						
						 <div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">前台弹窗</span>
                                         <select name="qttcoff" class="form-control">
		                            <option value="0" <?php if(config('zz_qttcoff') == 0): ?>selected<?php endif; ?>>关闭</option>
		                            <option value="1" <?php if(config('zz_qttcoff') == 1): ?>selected<?php endif; ?>>开启</option>
		                            </select>
                                    </div>
									 <pre>开启后刷新页面显示内容设置!</pre>
                                </div>
								<?php if(config('zz_qttcoff') == 1): ?>
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">前台弹窗内容</span>
                                         <textarea name="qttc" rows="3" class="form-control"><?php echo getHtmlCode(config('zz_qttc'),true); ?></textarea>
                                    </div>
                                </div>
													<?php endif; ?>
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">后台弹窗</span>
                                      <select name="tcoff" class="form-control">
		                            <option value="0" <?php if(config('zz_tcoff') == 0): ?>selected<?php endif; ?>>关闭</option>
		                            <option value="1" <?php if(config('zz_tcoff') == 1): ?>selected<?php endif; ?>>开启</option>
		                            </select>
                                    </div>
                                </div>
								<?php if(config('zz_tcoff') == 1): ?>
								<div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">后台弹窗内容</span>
                                          <textarea name="fztc" rows="3" class="form-control"><?php echo getHtmlCode(config('zz_fztc'),true); ?></textarea>
                                    </div>
                                </div>
						<?php endif; ?>
						
						
						
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon">分站后台公告</span>
                                         <textarea name="gg_admin" rows="5" class="form-control"><?php echo getHtmlCode(config('zz_gg_admin'),true); ?></textarea>
                                    </div>
                                </div>
                                
                                
                                <div class="list-group-item">
                                    <button class="btn btn-info btn-block" type="submit">确认保存</button>
                                </div>
                            </form>
							<div class="alert alert-info">提示：所有价格单位均为RMB/元，可精确到小数点后两位；所有比例均为不大于100的正整数
                    </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<script>
var items = $("select[default]") || 0;
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}

</script>


    

    <!--Modal-->
    <div class="modal fade" id="newFolder">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>Create new folder</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="folderName">Folder Name</label>
                            <input type="text" class="form-control input-sm" id="folderName"
                                   placeholder="Folder name here...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
                    <a href="#" class="btn btn-danger btn-sm">Save changes</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /wrapper -->



    <div class="app-footer wrapper-sm b-t bg-light text-xs">
        <span class="pull-right"> <a href="#" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
        <strong>Copyright 2018 </strong><?php echo config('web_name'); ?> &copy;
    </div>
<script>
    $(document).pjax('a[target!=_blank]', '#content', {fragment:'#content', timeout:8000});
</script>




<!-- 通用JS开始 -->

<script src="/assets/Public/Style/js/bootstrap.min.js"></script>
<script src="/assets/Public/Style/sweetalert/sweetalert.min.js"></script>
<script src="/assets/Public/Style/js/app-tooltip-demo.js"></script>
<script type="text/javascript">
  +function ($) {
	$(function(){
	  // class
	  $(document).on('click', '[data-toggle^="class"]', function(e){
		e && e.preventDefault();
		console.log('abc');
		var $this = $(e.target), $class , $target, $tmp, $classes, $targets;
		!$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
		$class = $this.data()['toggle'];
		$target = $this.data('target') || $this.attr('href');
		$class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
		$target && ($targets = $target.split(','));
		$classes && $classes.length && $.each($targets, function( index, value ) {
		  if ( $classes[index].indexOf( '*' ) !== -1 ) {
			var patt = new RegExp( '\\s' + 
				$classes[index].
				  replace( /\*/g, '[A-Za-z0-9-_]+' ).
				  split( ' ' ).
				  join( '\\s|\\s' ) + 
				'\\s', 'g' );
			$($this).each( function ( i, it ) {
			  var cn = ' ' + it.className + ' ';
			  while ( patt.test( cn ) ) {
				cn = cn.replace( patt, ' ' );
			  }
			  it.className = $.trim( cn );
			});
		  }
		  ($targets[index] !='#') && $($targets[index]).toggleClass($classes[index]) || $this.toggleClass($classes[index]);
		});
		$this.toggleClass('active');
	  });
	  
	

	  // collapse nav
	  $(document).on('click', 'nav a', function (e) {
		var $this = $(e.target), $active;
		$this.is('a') || ($this = $this.closest('a'));
		
		$active = $this.parent().siblings( ".active" );
		$active && $active.toggleClass('active').find('> ul:visible').slideUp(200);
		
		($this.parent().hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
		$this.parent().toggleClass('active');
		
		$this.next().is('ul') && e.preventDefault();

		setTimeout(function(){ $(document).trigger('updateNav'); }, 300);      
	  });
	});
  }(jQuery);
  </script>
<!-- 通用JS结束 -->


<!-- 模态窗口组件 -->
<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModa" id="modal" style="display:none;"></button>
<div class="modal inmodal fade" id="myModa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title" id="biaoti"></h4>
            </div>
            <div class="modal-body" id="showInfo">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- 模态窗口组件 -->




<?php if(isset($alert)): ?>
<script type="text/javascript"><?php echo $alert; ?></script>
<?php endif; ?>
</body>
<?php if(config('zz_bgset') == 1): ?>
<body style="background-image:url(<?php echo config('zz_common_bg'); ?>)"> 
<?php endif; if(config('zz_bgset') == 2): ?>
<body style="background-image:url(http://ihuan.me/bing)"> 
<?php endif; ?>
</html>
