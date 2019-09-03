<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\notice\record.html";i:1560313175;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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
    <link rel="stylesheet" href="/static/select/css/min/reset.css"/>
    <link rel="stylesheet" href="/static/select/css/select_gj.css">
    <script src="/static/select/js/min/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/static/select/js/select_gj.min.js"></script>
    <script src="/static/select/js/select2_1.js"></script>



</head>
<body>
<div id="right_content">
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        通知管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index'); ?>" >用户列表</a></li>
        <li><a href="<?php echo url('record'); ?>" class="this">推送记录</a></li>
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">

            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="账号/姓名/昵称">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th>账号</th>
                <th>姓名</th>
                <th>昵称</th>
                <th>头像</th>
                <th>关联类型</th>
                <th>标题</th>
                <th>描述</th>
                <th>推送时间</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
            <tr>
                <td><?php echo $v['phone']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['nickname']; ?></td>
                <td><img src='<?php echo $v['face']; ?>' style='max-width:100px;'></td>
                <td>
                    <?php if((!empty($checkVal['noticetypeVal'][$v['type']]))): ?>
                    <?php echo $checkVal['noticetypeVal'][$v['type']]; endif; ?>
                </td>
                <td><?php echo $v['title']; ?></td>
                <td><?php echo $v['describe']; ?></td>
                <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>
            </tr>
            <?php endforeach; endif; ?>
        </table>
        <div><?php echo $page; ?></div>
    </div>
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