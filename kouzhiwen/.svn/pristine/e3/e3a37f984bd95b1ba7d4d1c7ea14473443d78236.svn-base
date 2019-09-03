<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/www/wwwroot/kouzhiwen/public/../application/admin/course/view/questionnaire/problem.html";i:1544955977;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<?php if(($type==1)): ?>
<link rel="stylesheet" href="/static/admin/css/reset.css?v=2" type="text/css">
<link rel="stylesheet" href="/static/admin/css/index.css?v=2" type="text/css">
<script src="/static/admin/js/require.js?v=1" type="text/javascript" data-main="/static/admin/js/edit_main"></script>
<?php endif; ?>
<div id="right_content">
    <ul class="clearfix menu">
        <li><a href="<?php echo url('',['id'=>$id,'type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>添加试题</a></li>
        <li><a href="<?php echo url('',['id'=>$id,'type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>导入试题</a></li>
    </ul>
    <?php if(($type==2)): ?>
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th class='msg'>模板</th>
                <td>
                    <div><a href="/templet/questionnaire.xlsx" >下载模板</a></div>
                </td>
            </tr>
            <tr>
                <th class='msg'>文件</th>
                <td>
                    <div id="import">上传文件</div>
                    <div id="import-list" class="uploader-list">
                        <div class="upload-ts">
                            <input type="hidden" name="file" value="" datatype="*" nullmsg="请上传文件">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </td>
            </tr>

        </table>
    </form>
    <?php else: ?>
<div id="edit">
    <div id="edit_title">
        <label >问卷提交</label>
    </div>
    <div id="edit_body">
        <div id="edit_body_list"></div>
        <div id="edit_body_se">
            <div id="edit_select">
                <input type="button" value="单选" id="single">
                <input type="button" value="文本" id="text">
            </div>
            <div id="edit_add">+&nbsp&nbsp添加问题</div>
        </div>
    </div>
    <div id="edit_footer">
        <div id="edit_footer_right" data-url="<?php echo url('',['id'=>$id,'type'=>1]); ?>"><button >发布问卷</button></div>
    </div>
</div>
    <?php endif; ?>
</div>

<?php if(($type==2)): ?>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>

<script>

        $(function(){
            file_upload({
                pick        : '#import',
                container   : '#import-list',
                server      : "<?php echo url('',['id'=>$id,'type'=>2]); ?>",
                mulit       : true,
                inputname   : 'file',
                accept: {
                    title: 'Images',
                    extensions: 'xls,xlsx',
                    mimeTypes: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                },
                callback:function(ret){
                    layer.msg(ret.msg);
                    if (ret.status == 1) {
                        setTimeout(function(){
                            location.reload();
                        }, 500);
                    }
                }
            });
        })
</script>
<?php else: ?>
<script type="text/javascript">
    var paper=<?php echo $data['data']; ?>;
    var paper_type='q';
</script>
<?php endif; ?>
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