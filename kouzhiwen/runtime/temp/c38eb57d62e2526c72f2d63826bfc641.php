<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:91:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/add_teacher_pay.html";i:1544955752;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/header.html";i:1534993716;s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/webuploader.html";i:1534993716;s:82:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/ueditor.html";i:1539155154;s:85:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/dateplugin.html";i:1534993716;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/footer.html";i:1534993716;}*/ ?>
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
                <th class="msg">收款方式</th>
                <td>
                    <select name="pay_type" class="form-control w426" datatype="*">
                        <option value="1">微信</option>
                        <option value="2">支付宝</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">收款账号</th>
                <td><input name="account_num" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">提现金额</th>
                <td><input name="account" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">手续费</th>
                <td><input type="text" value="<?php echo $data['content']; ?>%" class="form-control w400" disabled="disabled"></td>
            </tr>
            <tr>
                <th width="150" class="msg">余额</th>
                <td><input type="text" value="<?php echo $user['money']; ?>" class="form-control w400" disabled="disabled"></td>
            </tr>
            <tr>
                <th width="150" class="msg">提现最大金额</th>
                <td><input type="text" value="<?php echo $money; ?>" class="form-control w400" disabled="disabled"></td>
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
<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.config.js?v=3"></script>
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.all.min.js"> </script>
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
    pick        : '#photo-picker',
    container   : '#photo-list',
    server      : '<?php echo url("teacher/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'cover_img'
});

$('#time-start').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
});

$('#time-end').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
});

setTimeout(function(){
        UE.getEditor('describeEditor', {
            autoHeight: false,
        });
    },500);


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