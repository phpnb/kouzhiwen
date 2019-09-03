<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/course/view/course/edit.html";i:1553482652;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<style>
    .hide{
        display: none !important;
    }
</style>
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
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="1" <?php if($data['type'] == '1'): ?>checked<?php endif; ?>> 专业知识课
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="2" <?php if($data['type'] == '2'): ?>checked<?php endif; ?>> 选修课
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="3" <?php if($data['type'] == '3'): ?>checked<?php endif; ?>> 直播课
                    </label>
                </td>
            </tr>
            <?php if($enterprise_id != '0'): ?>
            <tr>
                <th class="msg">分类</th>
                <td>
                    <select name="type_id" class="form-control w426 type_id" datatype="n">
                    </select>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <th class="msg">平台分类</th>
                <td>
                    <select name="classify_id" class="form-control w426" datatype="n">
                        <?php foreach($checkVal['classify'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['classify_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
            <!--<tr id="teacher_id">-->
                <!--<th class="msg">讲师</th>-->
                <!--<td>-->
                    <!--<select name="teacher_id" class="form-control w426" datatype="n">-->
                        <!--<?php foreach($checkVal['teacher'] as $v): ?>-->
                        <!--<option value="<?php echo $v['id']; ?>"  <?php if($data['teacher_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>-->
                        <!--<?php endforeach; ?>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->
            <tr id="teacher_id">
                <th class="msg">讲师</th>
                <td>
                    <select name="teacher_id" class="fastbannerform__country form-control w426" >
                        <?php foreach($checkVal['teacher'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($data['teacher_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">课程名称</th>
                <td><input name="title" value="<?php echo $data['title']; ?>" type="text" class="form-control w400" datatype="*"></td>
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

            <tr id="start">
                <th class='msg'>开始时间</th>
                <td>
                    <input type="text" id="time-start" name="start" class="date-plugin form-control w200" value="<?php echo !empty($data['start'])?date('Y-m-d H:i', $data['start']) : ''; ?>" placeholder="选择日期" datatype="/^.*?$/" autocomplete="off">
                </td>
            </tr>
            <tr id="plo">
                <th class='msg'>视频或音频地址</th>
                <td>
                    <input type="text" name="url2" class="form-control w400">
                </td>
            </tr>
            <tr id="url">
                <th class='msg'>视频或音频</th>
                <td>
                    <div id="url-picker">上传视频或音频</div>
                    <?php if($checkVal['video'] == '2'): ?>
                    <div id="url-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img"></span>
                            <input type="hidden" name="url">
                            <img src="" style="max-width:200px;">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                    <?php else: ?>
                    <div id="url-list" class="uploader-list_video" >
                        <div class="upimg-box">
                            <input type="hidden" name="url" value="<?php echo $data['url']; ?>">
                            <notempty name="video">
                                <video src="<?php echo $data['url']; ?>" controls="controls"  height="300"></video>
                            </notempty>
                        </div>
                    </div>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th class="msg">描述</th>
                <td><textarea name="describe" datatype="/^.*?$/"><?php echo $data['describe']; ?></textarea></td>
            </tr>
            <tr>
                <th width="150" class="msg">单价</th>
                <td><input name="price" value="<?php echo $data['price']; ?>" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/" nullmsg="请填写单价！(0 为免费"></td>
            </tr>
            <tr>
                <th width="150" class="msg">权重</th>
                <td><input name="weight" value="<?php echo $data['weight']; ?>" type="text" class="form-control w400" datatype="n" nullmsg="请填写权重！（越大越靠前"></td>
            </tr>
            <tr id="is_recommend">
                <th class="msg">是否推荐</th>
                <td>
                    <?php foreach($checkVal['is_recommendVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="is_recommend" value="<?php echo $k; ?>" <?php if(($data['is_recommend'] == $k)): ?> checked="checked"<?php endif; ?>> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php if(($enterprise_id>0)): ?>
            <tr id="power">
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
            <tr id="words">
                <th class='msg'>文档地址</th>
                <td>
                    <div id="words-picker">上传上传PDF文档</div>
                    <div id="words-list" class="uploader-list" data-align="words">
                        <div class="upimg-box upload-ts">
                            <span class="glyphicon glyphicon-remove-sign remove-img" ></span>
                            <input type="hidden" name="words" value="<?php echo $data['words']; ?>" datatype="/^.*?$/" nullmsg="请上传上传PDF文档">
                            <input type="hidden" name="words_name" value="<?php echo $data['words_name']; ?>" datatype="/^.*?$/" >
                            <span style="margin-right: 15%;"><a href="<?php echo $data['words']; ?>" target="_blank" ><?php echo $data['words_name']; ?></a></span>
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
    mulit       : false,
    inputname   : 'url',
    accept: {
        title: 'Images',
        extensions: 'mp4,avi,dat,mkv,flv,vob,m4v,mov,3gp,mpg,mpeg,mpe,wmv,asf,asx,mp3',
        mimeTypes: 'video/mp4,video/avi,video/dat,video/mkv,video/flv,video/vob,video/m4v,video/mov,video/3gp,video/mpg,video/mpeg,video/mpe,video/wmv,video/asf,video/asx,audio/mpeg'
    },
    callback:function(ret){
        var matching =/\.(gif|jpg|jpeg|bmp|png)/i;
        if(matching.test(ret.data.path)){
            $('#url-list').removeClass('uploader-list_video');
            $('#url-list').addClass='ploader-list';
            var info = '<div class="upimg-box">\
                                <span class="glyphicon glyphicon-remove-sign remove-img"></span>\
                                <input type="hidden" name="url" value="'+ret.data.path+'">\
                                <img src="'+ret.data.path+'" alt=""  style="width:200px;">\
                            </div>';
        }else{
            $('#url-list').removeClass('uploader-list');
            $('#url-list').addClass='ploader-list_video';
            var info = '<div class="upimg-box">\
                <input type="hidden" name="url" value="'+ret.data.path+'">\
                 <notempty name="video">\
	                <video src="'+ret.data.path+'" controls="controls"  height="300"></video>\
	             </notempty>\
             </div>';
        }
        $('#url-list').html(info);
    }

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

    function pricetype(type) {
        if(type==2){
            $("input[name='price']").val('0.00');
            $("input[name='price']").attr("readonly","readonly");
        }else{
            $("input[name='price']").removeAttr("readonly");
        }
        if(type==2){
            $("#teacher_id").hide();
        }else{
            $("#teacher_id").show();
        }
        if(type==3){
            $("input[name='url']").val('(NULL)');
            $("#is_recommend").show();
            $("#words").show();
            $("#start").show();
            $("#url").hide();
            $("#power").hide();
            $("#plo").hide();
        }else{
            $("#is_recommend").hide();
            $("#start").hide();
            $("#url").show();
            $("#power").show();
        }

        $('.type_id').html('');
        $.ajax({
            url: '<?php echo url("admin/course/course/type_list"); ?>',
            type: 'get',
            dataType: 'json',
            data: {type:type},
            success: function(data){
                let html="";
                if(data.data.length>0){
                    data=data.data;
                    for(var i=0;i<data.length;i++){
                        let selected='';
                        if(<?php echo $data['type_id']; ?>==data[i]['id']){
                            selected='selected';
                        }
                        html +="<option value="+data[i]['id']+" "+selected+">"+data[i]['name']+"</option>";
                    }
                }
                $('.type_id').html(html);

            },
            error: function(){

            }
        })
    }
    pricetype('<?php echo $data['type']; ?>');

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