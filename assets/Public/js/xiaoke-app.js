// 飞腾网络科技系统 JS


/*** PJAX a标签***/
$(document).pjax('a[data-pjax]', '#container',{  
	type:'get',
	scrollTo:false,
	timeout: 20000,
});
$(document).pjax('a[data-pjaxdemo]', '#containerdemo',{  
	type:'get',
	scrollTo:false,
	timeout: 20000,
});


/*** PJAX 表单提交***/
$(document).on('submit', 'form', function(event) {
	$.pjax.submit(event, '#container', {scrollTo:false,timeout: 20000,});
	$('form').attr("disabled", true);
});

/*** PJAX 主动调用***/
function pjax(url) {
	if(!url || url==""){
		$.pjax.reload({container:"#container",scrollTo:false,timeout: 20000,});
	}else{
		$.pjax({url: url, container: '#container',scrollTo:false,timeout: 20000,});
	}
}

/*** PJAX 主动调用***/
function pjaxdemo(url) {
	if(!url || url==""){
		$.pjax.reload({container:"#containerdemo",scrollTo:false,timeout: 20000,});
	}else{
		$.pjax({url: url, container: '#containerdemo',scrollTo:false,timeout: 20000,});
	}
}

/*** PJAX 加载动画***/
$(document).on('pjax:send', function() {   //pjax连接开始
	$("#loading").css("display", "block");   //开启加载动画
	$("[data-toggle='popover']").popover('hide')  //关闭页面的部分元素
	layer.closeAll();
});
$(document).on('pjax:complete', function() {   //pjax连接结束
	$("#loading").css("display", "none");   //隐藏加载动画
	$("button[data-dismiss='modal']").click();
	chongzai();
});

/*** 重载部分JS，避免失效 ***/
function chongzai(){
	$("[data-toggle='tooltip']").tooltip();
	$("[data-toggle='popover']").popover({html:true});
}


/*** 通用JS按钮数据提交 ***/
function ouch(page,post,zt){
	if(zt=='1'){
		layer.confirm('删除代挂不退余额,您确定要删除吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			ouch_bot(page,post)
		});
	}else if(zt=='2'){
		layer.confirm('删除QQ会同时删除掉添加的功能,您确定要删除吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			ouch_bot(page,post)
		});
	}else if(zt=='3'){
		layer.confirm('您确定要删除吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			ouch_bot(page,post)
		});
	}else{
		ouch_bot(page,post)
	}
}


function ouch_bot(page,post){   //JS按钮数据提交
	layer.load(1,{shade: false});
	var url="/Ajax/"+page+".html";
	xiaoke.postData(url, post, function(d) {
		layer.closeAll();
		$("#ajaxshow").html(d);
		return false
	});
}


function add_dg(page,act,qid){   //添加代挂
	layer.load(1,{shade: false});
	var hasChk = $('#jifen').is(':checked');
	if (hasChk){var jifen = '1';}else{var jifen = '0';}
	var is = $('input:radio[name="is"]:checked').val();
	var post = "act="+act+"&qid="+qid+"&is="+is+"&jifen="+jifen;
	ouch_bot(page,post);
}


function add_dl(page,obj){  //开通代理
	layer.load(1,{shade: false});
	var hasChk = $('#jifen').is(':checked');
	if (hasChk){var jifen = '1';}else{var jifen = '0';}
	var id = $(obj).find("option:selected").val();
	var post = "id="+id+"&jifen="+jifen;
	ouch_bot(page,post);
}


function add_fz(page){  //开通分站
	layer.load(1,{shade: false});
	var hasChk = $('#jifen').is(':checked');
	if (hasChk){var jifen = '1';}else{var jifen = '0';}
	var is = $('input:radio[name="is"]:checked').val();
	var id = $('#num').find("option:selected").val();
	var post = "id="+id+"&is="+is+"&jifen="+jifen;
	ouch_bot(page,post);
}


function get_qqztsj(qid){   //QQ详细信息获取
	var url="/Ajax/qqset.html";
	var post="act=getmsg&qid="+qid
	xiaoke.postData(url, post, function(d) {
		$("#ajaxshow").html(d);
		return false
	});
}

/*** 列表调用 ***/
function get_list(url){
	$("#bodys").html("<tr><td colspan=10><p style='text-align: center;'><img src='/Public/Style/img/load.gif' height=25></p></td></tr>");
	$.ajax({
		url:url,
		type:"GET",
		timeout:10000,
		success:function(data){
			$("#bodys").html(data);
			chongzai();
			return false
		},
		error:function(error){
			if(status=="timeout"){
				$("#bodys").html("<tr><td colspan=10><p style='text-align: center;'><b>获取列表超时，请刷新页面重试！</b></p></td></tr>")
			}else{
				$("#bodys").html("<tr><td colspan=10><p style='text-align: center;'><b>获取列表失败，请刷新页面重试！</b></p></td></tr>")
			}
			return false
		},
	})
}


/*** 模态窗口调用 ***/
function get_url(url,bt){
	$("#biaoti").html(bt);
	$("#showInfo").html("<p style='text-align: center;'><img src='/Public/Style/img/load.gif' height=25></p>");
	$.ajax({
		url:url,
		type:"GET",
		timeout:10000,
		success:function(data){
			$("#showInfo").html(data);
			chongzai();
			return false
		},
		error:function(error){
			if(status=="timeout"){
				$("#showInfo").html("<p style='text-align: center;margin-top:20px;'><b>打开超时，请重试！</b></p>")
			}else{
				$("#showInfo").html("<p style='text-align: center;margin-top:20px;'><b>链接失败，请刷新页面重试！</b></p>")
			}
			return false
		},
	})
}

 /*** 通用请求 ***/
var xiaoke={
	postData: function(url, parameter, callback, dataType, ajaxType) {
		if(!dataType) dataType='html';
		$.ajax({
			type: "POST",
			url: url,
			async: true,
			dataType: dataType,
			json: "callback",
			data: parameter,
			timeout : 15000, //超时时间设置，单位毫秒
			success: function(data) {
				if (callback == null) {
					return;
				} 
				callback(data);
			},
			error: function(request,status,err) {
				layer.closeAll('loading');
				if (status == "timeout"){
					layer.alert('请求超时，请重试！')
				}else{
					layer.alert('链接失败，请重试！')
				}
				return false;
			}
		});
	}
}

function gonggao(gid){
	var bt = '公告详情';
	var url = "/Xinxi/xiangxi/gid/"+gid+".html";
	get_url(url,bt); 
	$("#modal").click();
	$(".hide"+gid).hide();
};


function get_xiaoxi(){
	var url = "/Xinxi/xiaoxi.html";
	$.ajax({
		url:url,
		type:"GET",
		timeout:10000,
		success:function(data){
			if(!isNaN(data)){
				if(data != '0'){
					$(".xiaoxi").html(data);
					$(".xiaoxi2").html(data+'条');
					$(".xiaoxi").show();
					return false
				}else{
					$(".xiaoxi").html(data);
					$(".xiaoxi").hide();
					return false
				}
			}
		},
	})
}

function get_xiaoxi2(){
	var url = "/Xinxi/xiaoxi.html";
	$.ajax({
		url:url,
		type:"GET",
		timeout:10000,
		success:function(data){
			if(!isNaN(data)){
				$(".xiaoxi2").html(data+'条');
				return false
			}
		},
	})
}

function get_gongdan(){
	var url = "/Xinxi/gongdan.html";
	$.ajax({
		url:url,
		type:"GET",
		timeout:10000,
		success:function(data){
			if(!isNaN(data)){
				if(data != '0'){
					$(".gongdan").html(data);
					$(".gongdan").show();
					return false
				}else{
					$(".gongdan").html(data);
					$(".gongdan").hide();
					return false
				}
			}
			return false
		},
	})
}


function trim(str){ //去掉头尾空格
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function shop(zfid){   
	layer.msg('支付提交中，请稍等...', {icon: 16,shade: 0.01,time: 15000});
	var rmb = trim($('#rmb').val());
	var yid = trim($('#yid').val());
	if(rmb==null || rmb==0){
		layer.alert("请输入要充值的金额！");
		return false;
	}else if(rmb[0]=='.'){
		layer.alert("金额不能以点开头，请重新填写！");
		return false;
	}else if(rmb<0.01){
		layer.alert("充值的金额最低不能低于0.01元！");
		return false;
	}else if(rmb>9999){
		layer.alert("单次充值金额最高9999元，请重新填写！");
		return false;
	}
	var url = "/Dxpay/shop.html";
	var post = "yid="+yid+"&rmb="+rmb+"&zfid="+zfid
	xiaoke.postData(url, post, function(d) {
		layer.closeAll('loading');
		$(".clearfix2").html(d);
		return false
	});
}