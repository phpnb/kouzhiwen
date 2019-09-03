<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/banner/edit.html";i:1539849302;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
            <?php if($checkVal['enterprise_id'] == '0'): ?>
            <tr id="classify_id">
                <th class="msg">分类</th>
                <td>
                    <select name="classify_id" class="form-control w426" datatype="n">
                        <?php foreach($checkVal['classify_idVal'] as $k=>$v): ?>
                        <option value="<?php echo $k; ?>" <?php if(($data['classify_id']==$k)): ?> selected <?php endif; ?>><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th width="150" class="msg">banner位置</th>
                <td>
                    <?php foreach($checkVal['type'] as $v=>$k): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="<?php echo $v; ?>" <?php if(($data['type']==$v)): ?> checked <?php endif; ?>>
                        &nbsp;&nbsp;<?php echo $k; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">跳转位置</th>
                <td>
                    <?php foreach($checkVal['mold'] as $v=>$k): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="mold" value="<?php echo $v; ?>" <?php if(($data['mold']==$v)): ?> checked <?php endif; ?>>
                        &nbsp;&nbsp;<?php echo $k; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">关联数据</th>
                <td>
                    <select name="pid" class="form-control w426 pid" datatype="*">
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">图片</th>
                <td>
                    <div id="filePicker">上传图片</div>
                    <div id="fileList" class="uploader-list" datnum="all">
                        <div class="upload-ts">
                            <input type="hidden" name="img_url" value="<?php echo $data['img_url']; ?>" datatype="*" nullmsg="请上传图片">
                            <img src="<?php echo $data['img_url']; ?>" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>

            </tr>

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
<script type="text/javascript"  src="/static/admin/js/plugin.js"></script>
<script>
    $(function(){
        FloatNumber(".floatNumber",2);
        inputIntNumber(".intNumber");
        file_upload({
            pick        : '#filePicker',
            container   : '#fileList',
            server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
            mulit       : false,
            inputname   : 'img_url',
            len:6
        });
        $("input[name='mold']").click(function () {
            classlist(this.value);
        });
        $("input[name='type']").click(function(){
            pricetype(this.value);
        });
    })

    function classlist(type) {
            $('.class_id').html('');
            $.ajax({
                url: '<?php echo url("admin/root/banner/typelist"); ?>',
                type: 'get',
                dataType: 'json',
                data: {type: type},
                success: function (data) {
                    let html = "";
                    if (data.data.length > 0) {
                        data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            let selected='';
                            if(<?php echo $data['pid']; ?>==data[i]['id']){
                                selected='selected';
                            }

                            html += "<option value=" + data[i]['id'] + " "+selected+">" + data[i]['title'] + "</option>";
                        }
                    }
                    $('.pid').html(html);

                },
                error: function () {

                }
            })
    }

    function pricetype(type) {
        var enterprise_id=<?php echo $checkVal['enterprise_id']; ?>;
        if(enterprise_id !=0){
            return true;
        }
        if(type==4){
            $("#classify_id").show();
        }else{
            $("#classify_id").hide();
        }
    }

    classlist(<?php echo $data['mold']; ?>);
    pricetype(<?php echo $data['type']; ?>);
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