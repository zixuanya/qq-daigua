<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\export.html";i:1533918960;s:69:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\layout.html";i:1533918960;s:70:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/common\layout.html";i:1534520952;s:67:"C:\phpStudy\PHPTutorial\WWW/application/index/view2/admin\left.html";i:1564448391;}*/ ?>
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
                                  <a href="http://pay.yw52.cn/" >
                                    <span>裕网云支付</span>
                                  </a>
                                </li>
								 <li >
                                  <a href="http://sejima.com.cn/" >
                                    <span>货源商城</span>
                                  </a>
                                </li>
								<li >				
								<a href="https://www.bslyun.com/mall.html" >
                                    <span>APP制作</span>
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
					    <li><i class="fa fa-home"></i> <a href="/"><?php echo $tool['name']; ?>-数据导出</a></li>

                        <li><?php echo $webTitle; ?></li>
                    </ul>
                </div>
				






<div class="wrapper">
                    


  <div class="wrapper">
                                        
                    
                    <div class="col-sm-12">
                        <div class="panel panel-info">
                            <div class="list-group-item bg-dark m-b-sm"><?php echo $tool['name']; ?>-数据导出</div>
            <div class="panel-body">
            <div class="widget-body text-center">
                <div class="spacer spacer-bottom">
                    <h2 class="text-warning">
                        目前总共有&nbsp;
                        <font color=green><?php echo $amount['all']; ?></font>
                        &nbsp;条订单，可导出&nbsp;
                        <font color=green><?php echo $amount['can']; ?></font>
                        &nbsp;条，其中有&nbsp;
                        <font color=red><?php echo $amount['bu']; ?></font>
                        &nbsp;条需要补挂！
                    </h2>
                    <br>
                    <a href="<?php echo url('xz',['tid'=>$tool['tid']]); ?>?type=all" target="_blank" type="button"
                       class="btn btn-space btn-warning btn-rounded"
                       onClick="return confirm('确认导出全部<?php echo $tool['name']; ?>订单')">
                        导出全部订单
                    </a>
                    <a href="<?php echo url('xz',['tid'=>$tool['tid']]); ?>" target="_blank" type="button"
                       class="btn btn-space btn-info btn-rounded"
                       onClick="return confirm('确认导出补挂<?php echo $tool['name']; ?>数据？')">
                        导出补挂订单
                    </a>
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
