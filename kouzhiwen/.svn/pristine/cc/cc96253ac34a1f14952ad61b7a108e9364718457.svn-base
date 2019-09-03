<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/user/edit.html";i:1538207178;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
                <th width="150" class="msg">账号</th>
                <td><input name="phone" value="<?php echo $data['phone']; ?>" type="text" class="form-control w400" datatype="/^1\d{10}$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">密码</th>
                <td><input name="password" value="" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">姓名</th>
                <td><input name="name" value="<?php echo $data['name']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">昵称</th>
                <td><input name="nickname" value="<?php echo $data['nickname']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class='msg'>头像</th>
                <td>
                    <div id="face-picker">上传图片</div>
                    <div id="face-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="face" value="<?php echo $data['face']; ?>" datatype="/^.*?$/" nullmsg="请上传图片">
                            <img src="<?php echo $data['face']; ?>" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">身份证</th>
                <td><input name="identity" value="<?php echo $data['identity']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class="msg">性别</th>
                <td>
                    <?php foreach($checkVal['sexVal'] AS $n => $m): if(($n ==1)): ?>
                    <label class="radio-inline">
                        <input type="radio" name="sex" value="<?php echo $n; ?>" datatype="/^.*?$/" <?php if(($data['sex'] == $n)): ?> checked="checked"<?php endif; ?>> <?php echo $m; ?>
                        <u class="Validform_checktip"></u>
                    </label>
                    <?php else: ?>
                    <label class="radio-inline">
                        <input type="radio" name="sex" value="<?php echo $n; ?>" <?php if(($data['sex'] == $n)): ?> checked="checked"<?php endif; ?>> <?php echo $m; ?>
                    </label>
                    <?php endif; endforeach; ?>
                </td>
            </tr>
            <tr>
                <th class='msg'>出生年月</th>
                <td>
                    <input type="text" id="time-birth" name="birth" class="date-plugin form-control w200" value="<?php echo $data['birth']; ?>" placeholder="选择日期" datatype="/^.*?$/">
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">办公电话</th>
                <td><input name="oph" value="<?php echo $data['oph']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">手机</th>
                <td><input name="tel" value="<?php echo $data['tel']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">邮箱</th>
                <td><input name="email" value="<?php echo $data['email']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">学校</th>
                <td><input name="school" value="<?php echo $data['school']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class="msg">学历</th>
                <td>
                    <?php foreach($checkVal['educationVal'] AS $n => $m): if(($n ==3)): ?>
                        <label class="radio-inline">
                            <input type="radio" name="education" value="<?php echo $n; ?>" datatype="/^.*?$/" <?php if(($data['education'] == $n)): ?> checked="checked"<?php endif; ?>> <?php echo $m; ?>
                            <u class="Validform_checktip"></u>
                        </label>
                   <?php else: ?>
                        <label class="radio-inline">
                            <input type="radio" name="education" value="<?php echo $n; ?>" <?php if(($data['education'] == $n)): ?> checked="checked"<?php endif; ?>> <?php echo $m; ?>
                        </label>
                    <?php endif; endforeach; ?>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">单位职称</th>
                <td><input name="unit_title" value="<?php echo $data['unit_title']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">公司名称</th>
                <td><input name="company_name" value="<?php echo $data['company_name']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class="msg">公司介绍</th>
                <td><textarea name="company_introduce" datatype="/^.*?$/"><?php echo $data['company_introduce']; ?></textarea></td>
            </tr>
            <tr>
                <th width="150" class="msg">公司详细地址</th>
                <td><input name="company_adddetailed" value="<?php echo $data['company_adddetailed']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">家庭详细地址</th>
                <td><input name="address_detailed" value="<?php echo $data['address_detailed']; ?>" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class='msg'>证件照 正面</th>
                <td>
                    <div id="id_photo_pos-picker">上传图片</div>
                    <div id="id_photo_pos-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="id_photo_pos" value="<?php echo $data['id_photo_pos']; ?>" datatype="/^.*?$/" nullmsg="请上传图片">
                            <img src="<?php echo $data['id_photo_pos']; ?>" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th class='msg'>证件照 反面</th>
                <td>
                    <div id="id_photo_neg-picker">上传图片</div>
                    <div id="id_photo_neg-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="id_photo_neg" value="<?php echo $data['id_photo_neg']; ?>" datatype="/^.*?$/" nullmsg="请上传图片">
                            <img src="<?php echo $data['id_photo_neg']; ?>" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <input name="uid" type="hidden" value="<?php echo $data['uid']; ?>">
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
    pick        : '#face-picker',
    container   : '#face-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
    mulit       : false,
    inputname   : 'face'
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