<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:74:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/user/add.html";i:1551927104;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">姓名</th>
                <td><input name="name" type="text" class="form-control w400"></td>
            </tr>
            <tr>
                <th width="150" class="msg">账号</th>
                <td><input name="phone" type="text" class="form-control w400" datatype="/^1\d{10}$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">密码</th>
                <td><input name="password" type="text" class="form-control w400" datatype="*"></td>
            </tr>


            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">保存</button></td>
            </tr>
        </table>
    </form>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>
<link href="/static/common/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/static/common/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/common/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/static/common/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
    $(function(){
        if ($('.date-plugin').length > 0) {
            $('.date-plugin').change(function(){
                $(this).blur();
            })
        }
    })
</script>

<script>
$(function(){
    file_upload({
    pick        : '#face-picker',
    container   : '#face-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
    mulit       : false,
    inputname   : 'face',
});

$('#time-birth').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
});

file_upload({
    pick        : '#id_photo_pos-picker',
    container   : '#id_photo_pos-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
    mulit       : false,
    inputname   : 'id_photo_pos'
});

file_upload({
    pick        : '#id_photo_neg-picker',
    container   : '#id_photo_neg-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
    mulit       : false,
    inputname   : 'id_photo_neg'
});


})
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