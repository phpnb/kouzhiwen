<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/course/view/paper/add.html";i:1544955973;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
                <th class="msg">类型</th>
                <td>
                    <?php foreach($checkVal['typeVal'] as $v=>$k): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="type"  value="<?php echo $v; ?>" >
                        &nbsp;&nbsp;<?php echo $k; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th class="msg">班级</th>
                <td>
                    <select name="class_id" class="form-control w426 class_id" datatype="*">
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">标题</th>
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
            <tr>
                <th width="150" class="msg">题的数量</th>
                <td><input name="number" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th width="150" class="msg">考试时间（分钟</th>
                <td><input name="time" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th width="150" class="msg">满分</th>
                <td><input name="full" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th width="150" class="msg">及格</th>
                <td><input name="pass" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th width="150"  class='msg'>开始时间</th>
                <td>
                    <input type="text" id="time-start" name="start_time" class="date-plugin form-control w400" value="" placeholder="选择日期" datatype="*">
                </td>
            </tr>
            <tr>
                <th width="150"  class='msg'>结束时间</th>
                <td>
                    <input type="text" id="time-end" name="end_time" class="date-plugin form-control w400" value="" placeholder="选择日期" datatype="*">
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
$(function(){
    file_upload({
    pick        : '#photo-picker',
    container   : '#photo-list',
    server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'photo'
});
    $("input[name='type']").click(function(){
        $('.class_id').html('');
        $.ajax({
            url: '<?php echo url("admin/course/paper/classlist"); ?>',
            type: 'get',
            dataType: 'json',
            data: {type:this.value},
            success: function(data){
                let html="";
                if(data.data.length>0){
                    data=data.data;
                    for(var i=0;i<data.length;i++){
                        html +="<option value="+data[i]['id']+">"+data[i]['title']+"</option>";
                    }
                }
                $('.class_id').html(html);

            },
            error: function(){

            }
        })
    });
    $('#time-start').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:'zh-CN',
        minView:0,
        autoclose:true,
        minuteStep:1
    });

    $('#time-end').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:'zh-CN',
        minView:0,
        autoclose:true,
        minuteStep:1
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