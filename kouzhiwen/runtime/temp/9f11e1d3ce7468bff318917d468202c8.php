<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/user/avgscore.html";i:1533647140;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    <ul class="clearfix menu">
        <li><a href="<?php echo url('studyrecord',['uid'=>$uid,'type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>发表发现文章记录</a></li>
        <li><a href="<?php echo url('article',['uid'=>$uid,'type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>发表班级热点文章记录</a></li>
        <li><a href="<?php echo url('share',['uid'=>$uid,'type'=>3]); ?>" <?php if(($type==3)): ?>class="this"<?php endif; ?>>分享记录</a></li>
        <li><a href="<?php echo url('achievement',['uid'=>$uid,'type'=>4]); ?>"  <?php if(($type==4)): ?>class="this"<?php endif; ?>>成绩记录</a></li>
        <li><a href="<?php echo url('avgscore',['uid'=>$uid,'type'=>5]); ?>" <?php if(($type==5)): ?>class="this"<?php endif; ?>>学习班考试平均成绩</a></li>
    </ul>
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
                <th width="200">班级名称</th>
                <th width="200">平均名称</th>
            </tr>
            <!-- </table>-->
            <?php if((!empty($data))): foreach($data AS $k=>$v): ?>
            <tr>
                <td width="20"><?php echo $k+1; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['avg_score']; ?></td>
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