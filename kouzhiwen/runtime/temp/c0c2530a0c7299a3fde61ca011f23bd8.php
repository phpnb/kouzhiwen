<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:74:"D:\study\kouzhiwen\public/../application/admin/course\view\study\edit.html";i:1562722082;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:80:"D:\study\kouzhiwen\public/../application/admin/root\view\common/webuploader.html";i:1560313173;s:76:"D:\study\kouzhiwen\public/../application/admin/root\view\common/ueditor.html";i:1560313174;s:79:"D:\study\kouzhiwen\public/../application/admin/root\view\common/dateplugin.html";i:1560313174;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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
            <?php if($checkVal['enterprise_id'] != '0'): ?>
            <tr>
                <th class="msg">分类</th>
                <td>
                    <select name="class_type_id" class="form-control w426">
                        <?php foreach($checkVal['class_type_idVal'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['class_type_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <th class="msg">分类</th>
                <td>
                    <select name="classify_id" class="form-control w426">
                        <?php foreach($checkVal['classify_idVal'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['classify_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th width="150" class="msg">班级名称</th>
                <td><input name="name" value="<?php echo $data['name']; ?>" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th class='msg'>图片</th>
                <td>
                    <div id="photo-picker">上传图片</div>
                    <div id="photo-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="photo" value="<?php echo $data['photo']; ?>" datatype="*" nullmsg="请上传图片">
                            <img src="<?php echo $data['photo']; ?>" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">限定人数</th>
                <td><input name="number" value="<?php echo $data['number']; ?>" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th class='msg'>开始时间</th>
                <td>
                    <input type="text" id="time-start" name="start" class="date-plugin form-control w200" value="<?php echo !empty($data['start'])?date('Y-m-d', $data['start']) : '----'; ?>" placeholder="选择日期" datatype="*">
                </td>
            </tr>
            <tr>
                <th class='msg'>结束时间</th>
                <td>
                    <input type="text" id="time-end" name="end" class="date-plugin form-control w200" value="<?php echo !empty($data['end'])?date('Y-m-d', $data['end']) : '----'; ?>" placeholder="选择日期" datatype="*">
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">价格</th>
                <td><input name="price" value="<?php echo $data['price']; ?>" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/"></td>
            </tr>
            <tr>
                <th class="msg">班主任</th>
                <td>
                    <select name="teacher_id" class="form-control w426" datatype="*">
                        <?php foreach($checkVal['teacher'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['teacher_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class='msg'>描述</th>
                <td>
                    <textarea name="describe" style="width:600px;height:300px;" datatype="*" id="describeEditor"><?php echo $data['describe']; ?></textarea>
                </td>
            </tr>
            <tr>
                <th class="msg">类别</th>
                <td>
                    <?php foreach($checkVal['typeVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="<?php echo $k; ?>" <?php if($data['type'] == $k): ?>checked<?php endif; ?> /> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php if(($checkVal['enterprise_id']>0)): ?>
            <tr>
                <th class="msg">权限</th>
                <td>
                    <label class="checkbox-inline">
                        <input type="radio" name="power" value="0" <?php if($data['power'] == '0'): ?>checked<?php endif; ?>>查看
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="power" value="1" <?php if($data['power'] == '1'): ?>checked<?php endif; ?>>禁止
                    </label>

                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>
                    <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                </td>
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
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.config.js?a=1"></script>
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
file_upload({
    pick        : '#photo-picker',
    container   : '#photo-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
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