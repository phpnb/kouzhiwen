<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\study\kouzhiwen\public/../application/admin/info\view\questions\edit.html";i:1567474240;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1566983226;s:80:"D:\study\kouzhiwen\public/../application/admin/root\view\common/webuploader.html";i:1566983226;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1566983226;}*/ ?>
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
        <table class="table">
            <?php if((!empty($data))): foreach($data AS $v): ?>
            <div>
                <tr>
                    <td width="150"></td>
                    <td></td>
                </tr>
                <tr>
                    <th width="150" class="msg">内容:</th>
                    <td>
                        <?php echo $v['contents']; ?>
                    </td>
                </tr>
                <tr>
                    <th width="150" class="msg">作者:</th>
                    <td>
                        <?php echo $v['name']; ?>
                    </td>
                </tr>
            </div>
        </table>

    <?php if(($v['type']==1)): ?>
    <div>
        <tr>
            <div  class="uploader-list_video" >
                <div class="upimg-box">
                    <notempty name="video">
                        <?php foreach($v['url'] AS $u): ?>
                        <video src="<?php echo $u; ?>" controls="controls"  height="300"></video>
                        <?php endforeach; ?>
                    </notempty>
                </div>
            </div>
        </tr>
    </div>

    <?php endif; if(($v['type']==2)): ?>
            <div>
                <tr>
                    <div id="url-list" class="uploader-list_video" >
                        <div class="upimg-box">
                            <notempty name="video">
                                <?php foreach($v['url'] AS $u): ?>
                                <video src="<?php echo $u; ?>" controls="controls"  height="300"></video>
                                <?php endforeach; ?>
                            </notempty>
                        </div>
                    </div>
                </tr>
            </div>

    <?php endif; if(($v['type']==3)): ?>
    <div>
        <tr>

            <div class="upimg-box">
                <?php foreach($v['url'] AS $u): ?>
                    <img src="<?php echo $u; ?>" height="300"></img>
                <?php endforeach; ?>
            </div>
        </tr>
    </div>
    <?php endif; if(($v['type']==4)): ?>
    <div>
            <tr>
                <?php foreach($v['url'] AS $u): ?>
                <a href="" download="<?php echo $u; ?>">下载</a>
                <?php endforeach; ?>
            </tr>
    </div>

    <?php endif; endforeach; endif; ?>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>

<script type="text/javascript">
    $(function(){
        $("input[name='is_xszd']").click(function(){
            xszdtype(this.value);
        });
        $("input[name='is_zdwy']").click(function(){
            zdwytype(this.value);
        });
        $("input[name='identity[]']").click(function(){
            identity(this.value);
        });
        xszdtype(<?php echo $data['is_xszd']; ?>);
        zdwytype(<?php echo $data['is_zdwy']; ?>);
    })

    function xszdtype(type) {
        if(type==0){
            $("#classify_id").show();
            $("#teacher_type").hide();
            $("#is_zdwy").hide();
            $("#identity").show();

        }else{
            $("#classify_id").hide();
            $("#teacher_type").show();
            $("#is_zdwy").show();
            $("#identity").hide();
            $("input[name='identity[]']").prop({'checked':false}).attr({'checked':false});
        }
    }

    function zdwytype(type) {
        if(type==0){
            $("#teacher_type").show();
        }else{
            $("#teacher_type").hide();
        }
    }

    function identity(val) {
        if($("#identity2").is(':checked') && val==2){
            $("#identity1").prop({'checked':false}).attr({'checked':false});
            $("#identity3").prop({'checked':false}).attr({'checked':false});
        }else{
            $("#identity2").prop({'checked':false}).attr({'checked':false});
        }
    }

file_upload({
    pick        : '#photo-picker',
    container   : '#photo-list',
    server      : '<?php echo url("admin/root/upload/upload"); ?>',
    mulit       : false,
    inputname   : 'photo'
});
file_upload({
    pick        : '#synopsis_img-picker',
    container   : '#synopsis_img-list',
    server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'synopsis_img'
});
file_upload({
    pick        : '#synopsis-picker',
    container   : '#synopsis-list',
    server      : '<?php echo url("admin/root/upload/AliyunOss"); ?>',
    mulit       : false,
    inputname   : 'synopsis',
    accept: {
        title: 'Images',
        extensions: 'mp4,avi,dat,mkv,flv,vob,m4v,mov,3gp,mpg,mpeg,mpe,wmv,asf,asx,mp3',
        mimeTypes: 'video/mp4,video/avi,video/dat,video/mkv,video/flv,video/vob,video/m4v,video/mov,video/3gp,video/mpg,video/mpeg,video/mpe,video/wmv,video/asf,video/asx,audio/mpeg'
    },
    callback:function(ret){
        var matching =/\.(gif|jpg|jpeg|bmp|png)/i;
        if(matching.test(ret.data.path)){
            $('#synopsis-list').removeClass('uploader-list_video');
            $('#synopsis-list').addClass='ploader-list';
            var info = '<div class="upimg-box">\
                                <span class="glyphicon glyphicon-remove-sign remove-img"></span>\
                                <input type="hidden" name="synopsis" value="'+ret.data.path+'">\
                                <img src="'+ret.data.path+'" alt=""  style="width:200px;">\
                            </div>';
        }else{
            $('#synopsis-list').removeClass('uploader-list');
            $('#synopsis-list').addClass='ploader-list_video';
            var info = '<div class="upimg-box">\
                <input type="hidden" name="synopsis" value="'+ret.data.path+'">\
                 <notempty name="video">\
	                <video src="'+ret.data.path+'" controls="controls"  height="300"></video>\
	             </notempty>\
             </div>';
        }
        $('#synopsis-list').html(info);
    }

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