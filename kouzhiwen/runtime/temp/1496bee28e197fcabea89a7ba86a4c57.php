<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/editn.html";i:1544955756;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/header.html";i:1534993716;s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/webuploader.html";i:1534993716;s:82:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/ueditor.html";i:1539155154;s:85:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/dateplugin.html";i:1534993716;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/footer.html";i:1534993716;}*/ ?>
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
                <th class="msg">班级</th>
                <td>
                    <select name="class_id" class="form-control w426" datatype="*">
                        <?php foreach($checkVal as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['class_id'] == $v['id']): ?>checked <?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <tr>
                <th width="150" class="msg">活动名称</th>
                <td><input name="title" value="<?php echo $data['title']; ?>" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>图片</th>
                <td>
                    <div id="photo-picker">上传图片</div>
                    <div id="photo-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="photo" value="<?php echo $data['photo']; ?>" datatype="*" nullmsg="请上传图片">
                            <img src="<?php echo $data['photo']; ?>" alt="" style="width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th class='msg'>描述</th>
                <td>
                    <textarea name="describe" style="width:400px;height:100px;" datatype="*"  value="<?php echo $data['describe']; ?>" ><?php echo $data['describe']; ?></textarea>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">价格</th>
                <td><input name="price" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/" value="<?php echo $data['price']; ?>" ></td>
            </tr>
            <tr>
                <th class='msg'>内容</th>
                <td>
                    <textarea name="content" style="width:800px;height:400px;" datatype="*" id="describeEditor"><?php echo $data['content']; ?></textarea>
                </td>
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
    inputname   : 'photo'
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