<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/teacher/add.html";i:1553049242;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
                <th width="150" class="msg">用户名</th>
                <td><input name="username" type="text" class="form-control w400" datatype="s"></td>
            </tr>
            <tr>
                <th width="150" class="msg">密码</th>
                <td><input name="password" type="password" class="form-control w400" datatype="s"></td>
            </tr>
            <?php if($checkVal['enterprise_id'] == '0'): ?>

            <!--<tr id="classify_id">-->
                <!--<th class="msg">频道</th>-->
                <!--<td>-->

                    <!--<select name="classify_id"  class="form-control w426" datatype="n">-->
                        <!--<?php foreach($checkVal['classify_idVal'] as $v): ?>-->
                        <!--<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>-->
                        <!--<?php endforeach; ?>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->

            <tr id="classify_id">
                <th class="msg">频道</th>
                <td>
                    <div class="clearfix mt5">
                        <?php foreach($checkVal['classify_idVal'] as $v): ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="classify_id[]" value="<?php echo $v['id']; ?>"> <?php echo $v['name']; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>

            <tr>
                <th class="msg">是否叩之问学会</th>
                <td>
                    <?php foreach($checkVal['is_xszdVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="is_xszd" value="<?php echo $k; ?>" <?php if((0 == $k)): ?> checked="checked"<?php endif; ?>> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr id="teacher_type">
                <th class="msg">分类</th>
                <td>
                    <select name="teacher_type" class="form-control w426" datatype="n">
                        <?php foreach($checkVal['teacher_typeVal'] as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr id="is_zdwy">
                <th class="msg">是否学术指导委员</th>
                <td>
                    <?php foreach($checkVal['is_zdwyVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="is_zdwy" value="<?php echo $k; ?>" <?php if((0 == $k)): ?> checked="checked"<?php endif; ?>> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th width="150" class="msg">姓名</th>
                <td><input name="name" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">昵称</th>
                <td><input name="nickname" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">称呼</th>
                <td><input name="title" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">邮箱</th>
                <td><input name="email" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class='msg'>头像</th>
                <td>
                    <div id="photo-picker">上传图片</div>
                    <div id="photo-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="photo" value="" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">手机号</th>
                <td><input name="phone" type="text" class="form-control w400"></td>
            </tr>
            <tr>
                <th class="msg">性别</th>
                <td>
                    <?php foreach($checkVal['sexVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="sex" value="<?php echo $k; ?>"> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <!--<tr>-->
                <!--<th width="150" class="msg">所属组</th>-->
                <!--<td>-->
                    <!--<select name="group_id" class="form-control w426" datatype="n">-->
                        <!--<?php foreach($checkVal['group_idVal'] as $v): ?>-->
                        <!--<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>-->
                        <!--<?php endforeach; ?>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->

            <tr>
                <th class='msg'>视频简介</th>
                <td>
                    <div id="synopsis-picker">上传视频</div>
                    <div id="synopsis-list" class="uploader-list_video">
                        <div class="upload-ts">
                            <input type="hidden" name="synopsis" value="" datatype="/^.*?$/" nullmsg="请上传视频">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th class='msg'>视频简介图片</th>
                <td>
                    <div id="synopsis_img-picker">上传图片</div>
                    <div id="synopsis_img-list" class="uploader-list">
                        <div class="upimg-box upload-ts">
                            <input type="hidden" name="synopsis_img" value="" datatype="/^.*?$/" nullmsg="请上传图片">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">公司职位</th>
                <td><input name="unit_title" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">公司名称</th>
                <td><input name="company_name" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th class="msg">简介</th>
                <td><textarea name="brief" datatype="/^.*?$/"></textarea></td>
            </tr>
            <tr>
                <th width="150" class="msg">咨询价格</th>
                <td><input name="price" type="text" class="form-control w400" datatype="/^.*?$/" nullmsg="请填写咨询价格！(0 为免费"></td>
            </tr>
            <tr>
                <th width="150" class="msg">助理邮箱</th>
                <td><input name="assistant_email" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">助理手机</th>
                <td><input name="assistant_phone" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <tr>
                <th width="150" class="msg">助理电话</th>
                <td><input name="assistant_tel" type="text" class="form-control w400" datatype="/^.*?$/"></td>
            </tr>
            <?php if($checkVal['enterprise_id'] != '0'): ?>
            <tr>
                <th class="msg">是否推荐</th>
                <td>
                    <?php foreach($checkVal['is_recommendVal'] as $k=>$v): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="is_recommend" value="<?php echo $k; ?>"> <?php echo $v; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
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
    xszdtype(0);
    zdwytype(0);
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

})

    function xszdtype(type) {
        if(type==0){
            $("#teacher_type").hide();
        }else{

            $("#teacher_type").show();
        }
        //     $("#classify_id").show();
        //     $("#classify_id").find("input").attr("datatype","n");
        //
        //     // $("#teacher_type").hide();
        //     // $("#teacher_type").find("select").removeAttr("datatype");
        //
        //     $("#is_zdwy").hide();
        //     $("#is_zdwy").find("input").removeAttr("datatype");
        //
        //     $("#identity").show();
        //     // $("#identity").find("input").attr("datatype","*");
        //
        // }else{
        //     $("#classify_id").hide();
        //     $("#classify_id").find("input").removeAttr("datatype");
        //
        //     // $("#teacher_type").show();
        //     // $("#teacher_type").find("select").attr("datatype","n");
        //
        //     $("#is_zdwy").show();
        //     $("#is_zdwy").find("input").attr("datatype","*");
        //
        //     $("#identity").hide();
        //     // $("#identity").find("input").removeAttr("datatype");
        //     $("input[name='identity[]']").prop({'checked':false}).attr({'checked':false});
        // }
    }

    function zdwytype(type) {
        // if(type==0){
        //     $("#teacher_type").show();
        //     $("#teacher_type").find("select").attr("datatype","n");
        // }else{
        //     $("#teacher_type").hide();
        //     $("#teacher_type").find("select").removeAttr("datatype");
        // }
    }

    function identity(val) {
        if($("#identity2").is(':checked') && val==2){
            $("#identity1").prop({'checked':false}).attr({'checked':false});
            $("#identity3").prop({'checked':false}).attr({'checked':false});
        }else{
            $("#identity2").prop({'checked':false}).attr({'checked':false});
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