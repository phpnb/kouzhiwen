<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/introduce/add.html";i:1539779206;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:80:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/ueditor.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
                <th width="150" class="msg">资讯分类</th>
                <td>
                    <select name="type" class="form-control w400" style="width: 425px;">
                        <?php foreach($checkVal['type'] as $v=>$k): ?>
                        <option value="<?php echo $v; ?>"><?php echo $k; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>封面图</th>
                <td>
                    <div id="filePicker">上传图片</div>
                    <div id="fileList" class="uploader-list" datnum="all">
                        <div class="upload-ts">
                            <input type="hidden" name="cover_img" value="" datatype="*" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <th width="150" class="msg">标题</th>
                <td><input name="name" type="text" class="form-control w400" maxlength="50" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">作者</th>
                <td><input name="author" type="text" class="form-control w400"maxlength="20" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">关联学员账号</th>
                <td>
                    <input name="phone" type="text" class="form-control w400" maxlength="11" datatype="/^.*?$/" nullmsg="请填写关联学员手机号">

                </td>
            </tr>
            <tr>
                <th width="150" class="msg">内容</th>
                <td>
                    <textarea name="contents" style="width:600px;height:300px;" datatype="*" id="contentsEditor"></textarea>
                </td>
            </tr>

            <tr>
                <th width="150" class="msg">是否推荐</th>
                <td>
                    <?php foreach($checkVal['is_recommend'] as $v=>$k): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="is_recommend" checked value="<?php echo $v; ?>">
                        &nbsp;&nbsp;<?php echo $k; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">保 存</button></td>
            </tr>
        </table>
    </form>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>
<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.config.js?a=1"></script>
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.all.min.js"> </script>
<script>
    file_upload({
        pick        : '#filePicker',
        container   : '#fileList',
        server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
        mulit       : false,
        inputname   : 'cover_img'
    });

    setTimeout(function(){
        UE.getEditor('contentsEditor', {
            autoHeight: false,
        });
    },500);


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