<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:87:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/teacher/research_show.html";i:1540176464;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    #right_content table tr td,#right_content table tr th{
        border: solid #f1f1f1 1px;
    }
    #right_content form table th{
        text-align: left; padding-left:30px;
    }
</style>
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <th width="150" class="msg">标题</th>
                <td><?php echo $data['name']; ?></td>
            </tr>
            <tr>
                <th width="150" class="msg">图片</th>
                <td>
                    <img src="<?php echo $data['cover_img']; ?>" width="200">
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">内容</th>
                <td>
                    <?php echo $data['contents']; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <!--<button type="submit" class="btn btn-success">保存</button>-->
                    <?php if(($data['status']==0)): ?>
                    <a class="btn btn-success glyphicon glyphicon-ok"
                       onclick="ajax_post('<?php echo url('research_examine'); ?>',{'id':<?php echo $data['id']; ?>,'status':1});" title="审核成功"></a>
                    <a class="btn btn-success glyphicon glyphicon-remove"
                       onclick="ajax_post('<?php echo url('research_examine'); ?>',{'id':<?php echo $data['id']; ?>,'status':2});" title="审核失败"></a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </form>
</div>
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