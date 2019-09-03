<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/www/wwwroot/kouzhiwen/public/../application/headmaster/info/view/user/consume.html";i:1545806853;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1506416450;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
</head>
<body>
<div id="right_content">
    <!-- 菜单 -->
    <div class="table-box">
        <div class="table-header clearfix">
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="标题">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <table class="table">
            <tr>
                <th width="20">序号</th>
                <th width="200">类型</th>
                <th width="200">标题</th>
                <th width="200">金额</th>
                <th width="100">考试时间</th>
            </tr>
            <!-- </table>-->
            <?php if((!empty($data))): foreach($data AS $k=>$v): ?>
            <tr>
                <td width="20"><?php echo $k+1; ?></td>
                <td width="200">
                    <?php if((!empty($checkVal['typeVal'][$v['type']]))): ?>
                    <?php echo $checkVal['typeVal'][$v['type']]; endif; ?>
                </td>
                <td><?php echo $v['title']; ?></td>
                <td><?php echo $v['price']; ?></td>
                <td width="100" class="operation">
                    <?php echo date('Y-m-d H:i:s', $v['created_at']); ?>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td align="center" colspan="20">暂无数据！</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<script type="text/javascript">

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