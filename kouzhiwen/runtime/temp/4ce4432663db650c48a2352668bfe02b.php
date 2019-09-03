<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:80:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/enterprise/add.html";i:1554715804;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
                <th width="150" class="msg">企业名称</th>
                <td><input name="name" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>企业logo</th>
                <td>
                    <div id="logo-picker">上传图片</div>
                    <div id="logo-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="logo" value="" datatype="*" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">学员人数上限</th>
                <td><input name="student" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th class='msg'>到期时间</th>
                <td>
                    <input type="text" id="time-expire" name="expire" class="date-plugin form-control w200" value="" placeholder="选择日期" datatype="*">
                </td>
            </tr>
            <tr>
                <th class='msg'>关联企业</th>
                <td>
                    <?php foreach($checkVal['up'] as $v): ?>
                    <label class="checkbox-inline">
                        <input name="up[]" type="checkbox" value="<?php echo $v['id']; ?>" > <?php echo $v['name']; ?>
                        <u class="Validform_checktip"></u>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">学习班名称</th>
                <td><input name="one_name" type="text" class="form-control w400" value="学习班" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>学习班图片</th>
                <td>
                    <div id="one_img-picker">上传图片</div>
                    <div id="one_img-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="one_img" value="/uploads/enterprise/one.png" datatype="*" nullmsg="请上传图片">
                            <img src="/uploads/enterprise/one.png" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">专业知识课名称</th>
                <td><input name="two_name" type="text" class="form-control w400" value="岗位基本功" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>专业知识课图片</th>
                <td>
                    <div id="two_img-picker">上传图片</div>
                    <div id="two_img-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="two_img" value="/uploads/enterprise/two.png" datatype="*" nullmsg="请上传图片">
                            <img src="/uploads/enterprise/two.png" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">选修课程名称</th>
                <td><input name="three_name" type="text" class="form-control w400" value="选修课程" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>选修课程图片</th>
                <td>
                    <div id="three_img-picker">上传图片</div>
                    <div id="three_img-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="three_img" value="/uploads/enterprise/three.png" datatype="*" nullmsg="请上传图片">
                            <img src="/uploads/enterprise/three.png" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">通讯录名称</th>
                <td><input name="four_name" type="text" class="form-control w400" value="通讯录" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>通讯录图片</th>
                <td>
                    <div id="four_img-picker">上传图片</div>
                    <div id="four_img-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="four_img" value="/uploads/enterprise/four.png" datatype="*" nullmsg="请上传图片">
                            <img src="/uploads/enterprise/four.png" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">管理员姓名</th>
                <td><input name="admin_name" type="text" class="form-control w400" value="" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">管理员电话</th>
                <td><input name="admin_phone" type="text" class="form-control w400" datatype="/^1\d{10}$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">管理员邮箱</th>
                <td><input name="admin_email" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">企业地址</th>
                <td><input name="address" type="text" class="form-control w400" datatype="*"></td>
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
    pick        : '#logo-picker',
    container   : '#logo-list',
    server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'logo'
});
    file_upload({
        pick        : '#one_img-picker',
        container   : '#one_img-list',
        server      : '<?php echo url("admin/root/upload/upload"); ?>',
        mulit       : false,
        inputname   : 'one_img'
    });
    file_upload({
        pick        : '#two_img-picker',
        container   : '#two_img-list',
        server      : '<?php echo url("admin/root/upload/upload"); ?>',
        mulit       : false,
        inputname   : 'two_img'
    });
    file_upload({
        pick        : '#three_img-picker',
        container   : '#three_img-list',
        server      : '<?php echo url("admin/root/upload/upload"); ?>',
        mulit       : false,
        inputname   : 'three_img'
    });
    file_upload({
        pick        : '#four_img-picker',
        container   : '#four_img-list',
        server      : '<?php echo url("admin/root/upload/upload"); ?>',
        mulit       : false,
        inputname   : 'four_img'
    });
$('#time-expire').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
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