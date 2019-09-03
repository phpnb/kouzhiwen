<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:91:"/www/wwwroot/kouzhiwen/public/../application/teacher/info/view/teacherarticle/evaluate.html";i:1558315854;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/webuploader.html";i:1534993716;s:82:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/ueditor.html";i:1539155154;s:85:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/dateplugin.html";i:1534993716;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<div class="look">
    <?php foreach($data AS $v): ?>
    <tr>
        <td><?php echo $v['contents']; ?></td>
    </tr>
    <?php endforeach; ?>
</div>
<hr>
<form action="" method="post" class="verify-form rform" go="">

    <div>评语：</div> <textarea name="comment" style="width:800px;height:400px;" datatype="*"><?php foreach($data AS $k): ?><?php echo $k['comment']; endforeach; ?></textarea><br>
    <label class="checkbox-inline" style="margin-left: 30px;">
        点评:
        <input type="radio" name="lookeva" value="1"<?php foreach($data AS $k): if(($k['lookeva'] ==1)): ?>
               checked
               <?php endif; endforeach; ?>>差
        <input type="radio" name="lookeva" value="2"<?php foreach($data AS $k): if(($k['lookeva'] ==2)): ?>
               checked
               <?php endif; endforeach; ?>>合格
        <input type="radio" name="lookeva" value="3"<?php foreach($data AS $k): if(($k['lookeva'] ==3)): ?>
               checked
               <?php endif; endforeach; ?>>良
        <input type="radio" name="lookeva" value="4"<?php foreach($data AS $k): if(($k['lookeva'] ==4)): ?>
               checked
               <?php endif; endforeach; ?>>优
    </label><br>
    <label class="checkbox-inline" style="margin-left: 30px;">
        是否查看:
        <input type="radio" name="alook" value="1"<?php foreach($data AS $k): if(($k['alook'] ==1)): ?>
               checked
               <?php endif; endforeach; ?>>是
        <input type="radio" name="alook" value="2"<?php foreach($data AS $k): if(($k['alook'] ==2)): ?>
               checked
               <?php endif; endforeach; ?>>否
    </label><br>
    <button type="submit" class="btn btn-success ml100 mb20">保 存</button>
</form>
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