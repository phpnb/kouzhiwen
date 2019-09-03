<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:79:"D:\study\kouzhiwen\public/../application/admin/course\view\classcourse\add.html";i:1560313181;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:80:"D:\study\kouzhiwen\public/../application/admin/root\view\common/webuploader.html";i:1560313173;s:79:"D:\study\kouzhiwen\public/../application/admin/root\view\common/dateplugin.html";i:1560313174;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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
                    <?php foreach($checkVal['typeVal'] as $k=>$v): ?>
                        <label class="checkbox-inline">
                        <input type="radio" name="type" value="<?php echo $k; ?>"> <?php echo $v; ?>
                        </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th class="msg">班级</th>
                <td>
                    <select name="class_id" class="form-control w426" datatype="*">
                        <?php foreach($checkVal['class_idVal'] as $k=>$v): ?>
                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <!--<tr id="teacher_id">-->
                <!--<th class="msg">讲师</th>-->
                <!--<td>-->
                    <!--<select name="teacher_id" class="fastbannerform__country form-control w426" >-->
                        <!--<?php foreach($checkVal['teacher'] as $v): ?>-->
                        <!--<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>-->
                        <!--<?php endforeach; ?>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->
            <!--<tr id="teacher_id">-->
                <!--<th class="msg">讲师</th>-->
                <!--<td>-->
                    <!--<select name="teacher_id" class="form-control w426" datatype="n">-->
                        <!--<?php foreach($checkVal['teacher'] as $v): ?>-->
                        <!--<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>-->
                        <!--<?php endforeach; ?>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->
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
            <!--<tr>-->
                <!--<th class="msg">状态</th>-->
                <!--<td>-->
                    <!--<?php foreach($checkVal['statusVal'] as $k=>$v): ?>-->
                    <!--<label class="checkbox-inline">-->
                        <!--<input type="radio" name="status" value="<?php echo $k; ?>"> <?php echo $v; ?>-->
                    <!--</label>-->
                    <!--<?php endforeach; ?>-->
                <!--</td>-->
            <!--</tr>-->
            <tr id="url1">
                <th class='msg'>视频或音频地址</th>
                <td><input name="url[]" type="text" class="form-control w400"></td>
            </tr>
            <tr id="url">
                <th class='msg'>视频或音频</th>
                <td>
                    <div id="url-picker">上传视频或音频</div>
                    <div id="url-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="url[]" value="" datatype="/^.*?$/" nullmsg="请上传视频或音频">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="start">
                <th class='msg'>开始时间</th>
                <td>
                    <input type="text" id="time-start" name="start" class="date-plugin form-control w200" value="" placeholder="选择日期" datatype="/^.*?$/">
                </td>
            </tr>
            <tr>
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
                <th width="150" class="msg">权重</th>
                <td><input name="sort" type="text" class="form-control w400" datatype="*"></td>
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

file_upload({
    pick        : '#url-picker',
    container   : '#url-list',
    server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
    mulit       : true,
    inputname   : 'url[]',
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png,mp4,avi,dat,mkv,flv,vob,m4v,mov,3gp,mpg,mpeg,mpe,wmv,asf,asx,mp3',
        mimeTypes: 'image/jpg,image/jpeg,image/png,video/mp4,video/avi,video/dat,video/mkv,video/flv,video/vob,video/m4v,video/mov,video/3gp,video/mpg,video/mpeg,video/mpe,video/wmv,video/asf,video/asx,audio/mpeg'
    },
    callback:function(ret){
        var matching =/\.(gif|jpg|jpeg|bmp|png)/i;
        var video =/\.(mp4|avi|dat|mkv|flv|vob|m4v|mov|3gp|mpg|mpeg|mpe|wmv|asf|asx|mp3)/i;
        var status=$('input[name="status"]:checked').val();
        var type=$('input[name="type"]:checked').val();
        if(type==undefined){
            layer.msg('请先选择类型',{'time':1000});
            return false;
        }else if(type==1){
            if(!matching.test(ret.data.path)){
                layer.msg('直播课只能是图片',{'time':1000});
                return false;
            }
        }
        // else{
        //     if(!video.test(ret.data.path)){
        //         layer.msg('复习与直播只能是视频',{'time':1000});
        //         return false;
        //     }
        // }
        if(matching.test(ret.data.path)){
            $('#url-list').removeClass('uploader-list_video');
            $('#url-list').addClass='ploader-list';
            var info = '<div class="upimg-box">\
                                <span class="glyphicon glyphicon-remove-sign remove-img"></span>\
                                <input type="hidden" name="url[]" value="'+ret.data.path+'">\
                                <img src="'+ret.data.path+'" alt=""  style="height:120px;">\
                            </div>';
            $('#url-list').find('.allimg-verify-del').remove();
            $('#url-list').find('.upload-ts').remove();
            $('#url-list').find('.Validform_checktip').remove();
            $('#url-list').append(info);
        }else if(video.test(ret.data.path)){
            $('#url-list').removeClass('uploader-list');
            $('#url-list').addClass='ploader-list_video';
            var info = '<div class="upimg-box">\
                <input type="hidden" name="url[]" value="'+ret.data.path+'">\
                 <notempty name="video">\
	                <video src="'+ret.data.path+'" controls="controls"  height="300"></video>\
	             </notempty>\
             </div>';
            $('#url-list').html(info);
        }

    }
});

$('#time-start').datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    language:'zh-CN',
    minView:0,
    autoclose:true,
    minuteStep:1
});
    file_upload({
        pick        : '#words-picker',
        container   : '#words-list',
        server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
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
    $("input[name='type']").click(function(){
        pricetype(this.value);
    });

})

function pricetype(type) {
    if(type==2){
        $("#start").hide();
        $("#url1").show();
    }else{
        $("#start").show();
        $("#url1").hide();

    }

}
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