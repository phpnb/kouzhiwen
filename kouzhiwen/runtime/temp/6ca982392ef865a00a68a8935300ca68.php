<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/index/welcome.html";i:1545806857;s:84:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/header.html";i:1545806856;s:84:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/footer.html";i:1545806856;}*/ ?>
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
<div id="right_content">
    <?php if($id == 1): ?>
        <link rel="stylesheet" href="/static/doc/main.css?1=2">
        <h1 class="cl-blue">ZPF Framework 为快速开发后台和API而设计的高性能框架</h1>

        <h2>
            <a href="http://zpfbasic.zpftech.com/doc/index.html" target="_blank" class="cl-gre">查看完整文档 &gt;&gt;</a>
        </h2>
        
        <h2 class="cl-blue">框架简介</h2>
        <p>
            为快速开发后台和API而设计的高性能框架 <br>
            该框架可以为很方便的构造出基本的CURD、API接口、数据验证 <br>
            该框架基于Thinkphp5.0开发，如果你想要使用该框架，需要对Thinkphp5.0有一定了解 <br>
            不了解也没关系，该框架封装的功能可以让大家很容易的上手！<br><br>
            ZPF Framework 是一个颠覆和重构版本，采用全新的架构思想，引入了更多的PHP新特性，<br>
            优化了核心，减少了依赖，实现了真正的惰性加载，并针对API开发做了大量的优化，包括路由、日志、<br>
            异常、模型、数据库、模板引擎和验证等模块都已经重构，绝对是新项目的首选（无论是WEB还是API开发）。
        </p>    

        <h2 class="cl-blue">功能点</h2>
        <p>
            1.基于角色的权限控制<br>
            2.快速构造后台模板 <br>
            3.快速构造后台对数据表的CURD <br>
            4.快速构造API接口 <br>
            5.快速构造数据验证（模板中JS验证&后台模型中的验证） <br>
            6.框架自动生成好的代码可以很方便修改与扩展 <br>
            7.丰富的第三方扩展类 <br>
            8.丰富的图表插件 <br>
            9.已构建好的微信网页开发模块 
        </p>
    <?php else: ?>
        <div class="top-info">
            <i class="glyphicon glyphicon-home"></i>
            Welcome
        </div>
    <?php endif; ?>
</div>

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