<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\qqadd.html";i:1534160694;s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\layout.html";i:1533918960;s:70:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/common\layout.html";i:1534520952;s:67:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/panel\left.html";i:1533918960;}*/ ?>
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

                        <li><?php echo $webTitle; ?></li>
                    </ul>
                </div>
				
				
				<div class="wrapper">
                    <div class="col-lg-8 col-md-12 col-lg-offset-2 text-center" role="main">
                        <div class="panel panel-info">
                                <div class="list-group-item bg-dark m-b-sm">
                                      <div class="clear"><i class="fa fa-warning text-lt fa m-r-sm"></i> QQ添加须知！</div>
                                </div>
								<div class="list-group-item">站长公告：<?php echo getHtmlCode(config('web_gg_qqadd')); ?></div>
                               <div class="list-group-item">1、首次使用本网站可能会因为异地登陆而被TX临时冻结一次，解冻即可。</div>
                                <div class="list-group-item">2、添加后会提示代挂机房所在地的异地登陆提醒，以及可能被盗号的提醒，介意的新手请勿使用！</div>
                                <div class="list-group-item">3、出现的异地提醒可在QQ安全中心确认是本人登录，可解决帐号被频繁冻结的问题！</div>
                                <div class="list-group-item"><b>添加即代表同意本站协议自愿使用，不同意请关闭，本站不盗号，不信任请关闭。</b></div>

                        </div>
                    </div>


				
				

 <div class="wrapper">
 <div class="col-lg-8 col-md-12 col-lg-offset-2 text-center" role="main"> 
 <div class="panel panel-info">
  <div class="panel-heading font-bold">QQ更新&添加
							<span class="pull-right">
							
						</span>
							
							</div>
                            <div class="panel-body padder-v">

							
						</span>
            </div>
			  
            <div class="panel-body text-center">
			<?php if(config('zz_addqq_mode') == 1): ?>
				<form method="post" class="alert alert-success">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                ＱＱ
                            </div>
                            <input type="text" name="uin" class="form-control" value="<?php if(isset($qqInfo)): ?><?php echo $qqInfo['uin']; endif; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                密码
                            </div>
                            <input type="text" name="pwd" class="form-control" value="" required>
                        </div>
                    </div>
                    <input type="submit" name="submit" value="确认添加" class="btn btn-danger btn-block">
                </form>
			<?php else: ?>
                <Iframe id="iframepage"
                        src="/qlogin/<?php if(isset($qqInfo)): ?>?uin=<?php echo $qqInfo['uin']; ?>&pwd=<?php echo $qqInfo['pwd']; endif; ?>"
                        width="100%" scrolling="no" frameborder="0" name="addFrame"></iframe>
			<?php endif; ?>
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




<script type="text/javascript">
    function reinitIframe() {
        var iframe = document.getElementById("iframepage");
        try {
            iframe.height = iframe.contentWindow.document.documentElement.scrollHeight;
        } catch (ex) {
        }
    }
    window.setInterval("reinitIframe()", 200);
    function showLoad() {
        sweetAlert({
            title: "添加中...",
            text: '请耐心等待，如很长时间都没反应，请刷新网页重新添加！',
            imageUrl: "/assets/load.gif",
            html: true,
            timer: 600000,
            showConfirmButton: false
        });
    }
    function closeLoad() {
        $('.confirm').click();
    }
</script>


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
