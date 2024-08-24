<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\qqinfo.html";i:1564448597;s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\layout.html";i:1533918960;s:70:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/common\layout.html";i:1534520952;s:67:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\left.html";i:1533918960;}*/ ?>
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
                        <li><a href="<?php echo url('recharge'); ?>" ><i class="fa fa-cny"></i> &nbsp;&nbsp;账户充值</a></li>
                        <li><a href="<?php echo url('shop'); ?>" ><i class="fa fa-eur"></i> &nbsp;&nbsp;开通代理</a></li>
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
                        <li><a href="<?php echo url('profile'); ?>" ><i class="fa fa-user-circle-o"></i> &nbsp;&nbsp;账户资料</a></li>
                        <li><a href="<?php echo url('profile'); ?>"><i class="fa fa-chain"></i> &nbsp;&nbsp;密码修改</a></li>
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
                            <li><a href="<?php echo url('profile'); ?>" ><i class="fa fa-user-circle-o"></i> &nbsp;&nbsp;账户资料</a></li>
                        <li><a href="<?php echo url('profile'); ?>"><i class="fa fa-chain"></i> &nbsp;&nbsp;密码修改</a></li>
                        <li class="divider"></li>
                      <li><a href="/index/index/logout.html" ><i class="fa fa-sign-out"></i> &nbsp;&nbsp;退出登陆</a></li>
                        </ul>
                    </div>
                    <div class="line dk hidden-folded"></div>
                </div>

                <nav ui-nav class="navi">
                    <ul class="nav">
					
					<?php if($userInfo['power'] == 9): ?>
					 <li class="hidden-folded padder text-muted text-xs">
                            <span>后台中心</span>
                        </li>
                        <li class="active">
                            <a href="<?php echo url('index/Admin/index'); ?>" class="auto" >
                               <i class="fa fa-dashboard"></i>
                                <span class="font-bold">站长后台</span>
                            </a>
                        </li>
					  <?php endif; ?>
					
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>用户中心</span>
                        </li>
                        <li class="active">
                            <a href="<?php echo url('index'); ?>" class="auto" >
                               <i class="fa fa-camera-retro fa-lg"></i>
                                <span class="font-bold">用户中心</span>
                            </a>
                        </li>
						  
                                                                        <li class="line dk"></li>
          
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>代挂中心</span>
                        </li>
                        
                        <li >
                            <a href="<?php echo url('qqlist'); ?>" class="auto" >
                               <i class="fa fa-qq fa-1x"></i>
                                <span class="font-bold">Q Q管理</span>
                            </a>
                        </li>
						
						 
						<li >
                            <a href="<?php echo url('order'); ?>" class="auto" >
                               <i class="fa fa-tag"></i>
                                <span class="font-bold">自助下单</span>
                            </a>
                        </li>
						
						
						<li >
                            <a href="<?php echo url('qqsj'); ?>" class="auto" >
                               <i class="fa fa-sheqel"></i>
                                <span class="font-bold">升级计算</span>
                            </a>
                        </li>
						
                        
                        <li >
                            <a href="<?php echo url('qqadd'); ?>" class="auto" >
                                <i class="fa fa-plus-square fa-1x"></i>
                                <span class="font-bold">添加代挂</span>
                            </a>
                        </li>
						
                        
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>在线商城</span>
                        </li>
                        <li >
                            <a href="<?php echo url('recharge'); ?>" >
                                <i class="fa fa-bitcoin"></i>
                                <span class="font-bold">账户充值</span>
                            </a>
                        </li>
						
						
						
                        <li >
                            <a href="<?php echo url('shop'); ?>" >
                                <i class="fa fa-chain-broken"></i>
                                <span class="font-bold">自助开通</span>
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo url('ktfz'); ?>" >
                                <i class="fa fa-telegram"></i>
                                <span class="font-bold">搭建分站</span>
                            </a>
                        </li>
                        </li>
	
                        
                        <li class="hidden-folded padder text-muted text-xs">
                            <span>会员福利</span>
                        </li>
                               <li >
                            <a href="<?php echo url('qiandao'); ?>" >
                                <i class="fa fa-chain"></i>
                                <b class="badge bg-primary pull-right" style="display:none">0</b>
                                <span class="font-bold">签到活动</span>
                            </a>
                        </li>
					
                        <li >
                            <a href="<?php echo url('rmbList'); ?>" >
                                <i class="fa fa-window-restore"></i>
                                <span class="font-bold">使用记录</span>
                            </a>
                        </li>
						
						
						

						
						
          
                        <li class="hidden-folded padder text-muted text-xs">          
                            <span>其他功能</span>
                        </li>
						<?php if(config('zz_chaoff') == 1): endif; ?>
						<li >
                            <a href="<?php echo url('help'); ?>" >
                                <i class="fa fa-exclamation-circle"></i>
                                <span class="font-bold">使用帮助</span>
                            </a>
                        </li>
                                              
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
						<li><a href="<?php echo url('qqlist'); ?>" >QQ管理</a></li>

                        <li><?php echo $webTitle; ?></li>
                    </ul>
                </div>
                
                <div class="wrapper">
                    <div class="col-lg-8 col-md-12 col-lg-offset-2" role="main">
                        
                        
                        <div class="panel b-a">
                            <div class="panel-heading bg-info dk no-border wrapper-lg"></div>
                            <div class="text-center m-b clearfix">
                                <div class="thumb-lg avatar m-t-n-xl">
                                    <img alt="image" class="b b-3x b-white" src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $info['uin']; ?>&amp;spec=100">
                                    <span class="text-muted text-xs block"><?php echo $info['uin']; ?></span>
                                </div>
                            </div>
                           

                            <div class="hbox text-center b-t b-light">
                                <div class="col padder-v text-muted">
                                    <div class="h4 text-dark m-b-sm"><b>代挂状态：<span id='dgzxzt'><?php echo getQqZt($info['zt']); ?></span></b> </div>
                                     <span><font color="pink">代挂期间修改了QQ的密码,需要来这里更新同步密码</font><br><font color="red">tip:更新密码后，即使上方状态出现密码错误也不会干扰代挂.</font></span>
                                </div>
                            </div>   
                                
                        </div>
                        <div style="width:100%;overflow:hidden;"></div>
                        <div class="panel panel-info" draggable="true">
                            <div class="row wrapper">
                                <div class="col-sm-12">
                                    <div class="btn-group dropdown m-l-xs" style="float:left;">
                                      <button type="button" class="btn btn-info" data-toggle="dropdown" data-toggle="dropdown">
                                        <i class="fa fa-plus"></i> 其他功能
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
									  <td class="text-center" colspan="2"><a href="?action=quan" class="btn-xs btn-success">一键拉圈圈99+</a></td>
                                      </ul>
                                    </div>
                                    <a href="<?php echo url('qqadd'); ?>"  class="btn btn-info m-l-xs">更新密码</a>
                                    <a href="<?php echo url('order'); ?>"  class="btn btn-info m-l-xs">续期代挂</a>
                                    <button class="btn btn-primary m-l-xs" id='dgcronnum'><?php echo count($orderlist); ?></button>   
                                </div>
                            </div>
                            <div class="table-responsive">
                               <table class="table table-bordered table-condensed table-hover table-striped table-vertical-center">
                        <thead>
                        <tr>
                            <th class="text-center">代挂项目</th>
                            <th class="text-center">到期时间</th>
                            <th class="text-center">状态</th>
                            <th class="text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($orderList) || $orderList instanceof \think\Collection): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td class="text-center"><?php echo $order['name']; ?></td>
                            <td class="text-center"><?php echo $order['endtime']; ?></td>
                            <td class="text-center">
                                <?php if($order['zt'] == 0): ?>
                                <font color="green">加速中</font>
                                <?php elseif($order['zt'] == 1): ?>
                                <font color="#d2691e">补挂中</font>
                                <?php elseif($order['zt'] == 2): ?>
                                <font color="#red">已关闭</font>
                                <?php else: ?>
                                <font color="#red">未知</font>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">

                                <?php if($order['zt'] == 1): ?>
                                <a href="?action=qxbu&tid=<?php echo $order['tid']; ?>" class="btn-xs btn-warning">取消补挂</a>
                                <?php else: ?>
                                <a href="?action=bu&tid=<?php echo $order['tid']; ?>" class="btn-xs btn-info">申请补挂</a>
                                <?php endif; if($order['zt'] == 2): ?>
                                <a href="?action=on&tid=<?php echo $order['tid']; ?>" class="btn-xs btn-success">开启</a>
                                <?php else: ?>
                                <a href="?action=off&tid=<?php echo $order['tid']; ?>" class="btn-xs btn-danger">关闭</a>
                                <?php endif; ?>

                            </td>

                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                            </div>
                            
                            <div style="width:100%;overflow:hidden;"></div>
                            <hr>
                            <div class="text-center m-b-md">
                                <a href="javascript:history.back(-1)" class="text-ab">返回上一页</a> &nbsp;|&nbsp; <a href="<?php echo url('qqlist'); ?>" class="text-ab" >返回QQ管理</a>
                            </div>
                        </div>
                        	
                        <div class="clearfix"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>



    

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
