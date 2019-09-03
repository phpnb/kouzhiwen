<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\study\kouzhiwen\public/../application/teacher/root\view\login\login.html";i:1560313160;s:77:"D:\study\kouzhiwen\public/../application/teacher/root\view\common\header.html";i:1560313159;s:77:"D:\study\kouzhiwen\public/../application/teacher/root\view\common\footer.html";i:1560313160;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZPF Framework</title>
	<link rel="stylesheet" href="/static/common/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/static/common/css/base.css">
    <link rel="stylesheet" href="/static/common/css/Validform.css">
    <link rel="stylesheet" href="/static/admin/css/main.css?b=9">
    <link rel="stylesheet" href="/static/admin/css/status_text_color.css">
    <script type="text/javascript" src="/static/common/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/static/common/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/common/Validform.js"></script>
    <script type="text/javascript" src="/static/common/layer/layer.js"></script>
	<script type="text/javascript" src="/static/admin/js/admin.js?b=6"></script>
</head>
<body>
<style>
	.Validform_checktip{ display: none; }
	#Validform_msg{ display: none; }
</style>
<div id="login"></div>
<div class="bgz"></div>
<div id="login_box_bg"></div>

<div id="login_box">
	<h2>Welcome</h2>
	<form action="" class="verify-form" go="go_module">
		<input type="password" style="position: absolute; top: -999px;">
		<input type="text" name="username" class="form-control" placeholder="Username" datatype="*" nullmsg="请填写用户名" autocomplete="off">
		<input type="password" name="password" class="form-control" placeholder="Password" datatype="*" nullmsg="请填写密码" autocomplete="off">
		<button type="submit" class="btn btn-info">Log in</button>
	</form>
</div>
<script>
	$(function(){
		// 表单获得焦点
		$('form input').focus(function() {
			$(this).css({'color':'#5bc0de'});
			$(this).animate({'padding' : '6px 20px'}, 300);
		});
		// 表单失去焦点
		$('form input').blur(function() {
			$(this).css({'color' : '#5bc0de'});
			$(this).animate({'padding' : '6px 12px'}, 300);
		});
	})

	// 跳转至对应模块
	function go_module(res){
	    location.href = res.data.url;
	}
</script>
<!-- frame操作框 -->
<div id="show_frame">
	<h2 class="clearfix">
		<p class="title fl">标题部分</p>
		<span class="fr" onclick="close_frame();">X</span>
	</h2>
	<iframe id="frame_disposeid" src="" scrolling="auto" frameborder="0" name="frame_dispose"></iframe>
</div>
<div id="loding-bg">
    
</div>
</body>
</html>