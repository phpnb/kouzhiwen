<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"/www/wwwroot/kouzhiwen/public/../application/headmaster/course/view/study/add_user_qun.html";i:1545806851;s:84:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/header.html";i:1545806856;s:84:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/footer.html";i:1545806856;}*/ ?>
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
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        讨论组成员管理
    </div>
    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('discussuser',['id'=>$id]); ?>" >数据列表</a></li>
        <li><a href="<?php echo url('add_user_qun',['id'=>$id]); ?>" class="this">加入讨论组</a></li>
    </ul>
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">用户</th>
                <td>
                    <select name="user_id" class="form-control w426" datatype="*">
                        <?php foreach($checkVal['user_Val'] as $v): ?>
                        <option value="<?php echo $v['uid']; ?>"><?php echo $v['name']; ?></option>user
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
           <tr>
                <th width="150" class="msg">职位</th>
                <td><input name="call" type="text" class="form-control w400" value="学员" datatype="*"></td>
            </tr>

            <tr>
                <td></td>
                <input type="hidden" name="discuss_id" value="<?php echo $id; ?>" />
                <td><button type="submit" class="btn btn-success">保存</button></td>
            </tr>
        </table>
    </form>
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