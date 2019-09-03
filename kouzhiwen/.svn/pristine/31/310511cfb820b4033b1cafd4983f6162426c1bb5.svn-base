<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\study\kouzhiwen\public/../application/admin/root\view\report\add.html";i:1561030664;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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

                <?php if((!empty($data))): foreach($data AS $v): ?>

                <div style="font-size: 20px">
                    <p style="color: red;font-size: 20px">举报人：</p><?php echo $v['name']; ?>
                </div>
        <br>

                <div style="font-size: 20px">
                    <p style="font-size: 20px;color: red">问题内容：</p><?php echo $v['contents']; ?>
                </div>
        <br>
                <div style="font-size: 20px">
                    <p style="font-size: 20px;color: red">举报说明：</p><?php echo $v['content']; ?>
                </div>

        <br>
        <?php if(($v['type']!=3)): ?>
        <div class="upimg-box">
            <input type="hidden" name="url[]" value="<?php echo $v; ?>" datatype="*" >
            <notempty name="video">
                <video src="<?php echo $v['url']; ?>" controls="controls"  height="300"></video>
            </notempty>
        </div>
        
        <?php endif; endforeach; endif; ?>


    </form>
</div>

<script>
    $(function(){

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