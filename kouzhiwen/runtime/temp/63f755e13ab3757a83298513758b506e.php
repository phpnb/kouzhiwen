<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/info/view/teacherarticle/add.html";i:1558601332;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/webuploader.html";i:1534993716;s:82:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/ueditor.html";i:1539155154;s:85:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/dateplugin.html";i:1534993716;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
            <?php if(($type==2)): ?>
            <tr>
                <th class="msg">班级</th>
                <td>
                    <select name="class_id" class="form-control w426" datatype="*">
                        <?php foreach($checkVal['class_idVal'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">关联学员账号</th>
                <td>
                    <input name="phone" type="text" class="form-control w400" maxlength="11" datatype="/^.*?$/" nullmsg="请填写关联学员手机号">
                </td>
            </tr>
            <?php endif; ?>

            <tr>
                <th width="150" class="msg">标题</th>
                <td><input name="name" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>图片</th>
                <td>
                    <div id="photo-picker">上传图片</div>
                    <div id="photo-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="cover_img" value="" datatype="*" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <?php if(($type==1)): ?>
            <tr id="plo">
                <th class='msg'>视频或音频地址</th>
                <td><input name="url" type="text" class="form-control w400"></td>
            </tr>

            <?php endif; if(($type ==2)): ?>
            <tr>
                <th class='msg'>内容</th>
                <td>
                    <textarea name="contents" style="width:800px;height:400px;" datatype="*" id="describeEditor"></textarea>
                </td>
            </tr>
            <?php endif; ?>

            <input type="hidden" name="type" value="<?php echo $type; ?>" />
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