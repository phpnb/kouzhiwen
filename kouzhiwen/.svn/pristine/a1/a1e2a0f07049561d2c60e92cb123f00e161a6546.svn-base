<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:83:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/broadcast/add.html";i:1544955746;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
            <?php if($enterprise_id != '0'): ?>
            <tr>
                <th class="msg">分类</th>
                <td>
                    <select name="type_id" class="form-control w426" datatype="n">
                        <?php foreach($checkVal['type'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <th class="msg">平台分类</th>
                <td>
                    <select name="classify_id" class="form-control w426" datatype="n">
                        <?php foreach($checkVal['classify'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th width="150" class="msg">课程名称</th>
                <td><input name="title" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>图片</th>
                <td>
                    <div id="photo-picker">上传图片</div>
                    <div id="photo-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="photo" value="" datatype="*" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="start">
                <th class='msg'>开始时间</th>
                <td>
                    <input type="text" id="time-start" name="start" class="date-plugin form-control w200" value="" placeholder="选择日期" datatype="/^.*?$/" autocomplete="off">
                </td>
            </tr>
            <tr>
                <th class="msg">描述</th>
                <td><textarea name="describe" datatype="/^.*?$/"></textarea></td>
            </tr>
            <tr>
                <th width="150" class="msg">单价</th>
                <td><input name="price" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/" nullmsg="请填写单价！(0 为免费"></td>
            </tr>
            <tr id="words">
                <th class='msg'>文档地址</th>
                <td>
                    <div id="words-picker">上传PDF文档</div>
                    <div id="words-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="words" value="" datatype="/^.*?$/" nullmsg="请上传PDF文档">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
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
    $('#time-start').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:'zh-CN',
        minView:0,
        autoclose:true,
        minuteStep:1
    });
$(function(){


    file_upload({
    pick        : '#photo-picker',
    container   : '#photo-list',
    server      : '<?php echo url("teacher/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'photo'
});


    file_upload({
        pick        : '#words-picker',
        container   : '#words-list',
        server      : '<?php echo url("teacher/root/upload/AliyunOss"); ?>',
        mulit       : false,
        inputname   : 'words',
        accept: {
            title: 'words',
            extensions: 'pdf',
            mimeTypes: 'application/pdf'
        },
        callback:function(ret){
            $('#words-list').removeClass('uploader-list_video');
            $('#words-list').addClass='ploader-list';
            var info = '<div class="upimg-box">\
                                <span class="glyphicon glyphicon-remove-sign remove-img"></span>\
                                <input type="hidden" name="words" value="'+ret.data.path+'">\
                                <input type="hidden" name="words_name" value="'+ret.data.name+'">\
                                <span style="margin-right: 15%;"><a href='+ret.data.path+' target="_blank">'+ret.data.name+'</a></span>\
                            </div>';
            $('#words-list').html(info);
        }

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