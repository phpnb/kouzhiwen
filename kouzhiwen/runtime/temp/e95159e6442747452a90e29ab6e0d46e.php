<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/enterprise/useradd.html";i:1540365090;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    <form action="" class="verify-form rform">
        <table class="table">
            <input type="password" style="position:absolute; z-index:-1;">
            <tr>
                <th width="150" class="msg">用户名</th>
                <td><input type="text" name="username" class="form-control w300" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">密码</th>
                <td><input type="password" name="password" class="form-control w300" datatype="*"></td>
            </tr>

            <tr style="display: none;">
                <th width="150" class="msg">所属模块</th>
                <td>
                    <input type="text" name="module" value="admin/<?php echo $mname; ?>" class="form-control w300" readonly>
                </td>
            </tr>

            <input type="hidden" name="enterprise_id" value="<?php echo $id; ?>" />
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">保 存</button></td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">

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