<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/discussuseredit.html";i:1539165188;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/header.html";i:1534993716;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/footer.html";i:1534993716;}*/ ?>
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
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
           <tr>
                <th width="150" class="msg">职位</th>
                <td><input name="call" type="text" class="form-control w400" value="<?php echo $data['call']; ?>" datatype="*"></td>
            </tr>

            <tr>
                <td></td>
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
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