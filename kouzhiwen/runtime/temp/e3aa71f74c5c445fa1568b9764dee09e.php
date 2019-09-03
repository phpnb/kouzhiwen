<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\study\kouzhiwen\public/../application/admin/finance\view\userdetailed\index.html";i:1560313179;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        学员消费记录
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index',['type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>充值记录</a></li>
        <li><a href="<?php echo url('index',['type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>消费记录</a></li>
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <form action="<?php echo url('index',['type'=>$type]); ?>" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="标题">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>用户</th>
                <th>标题</th>
                <th>金额</th>
                <th>创建时间</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['title']; ?></td>
                    <td><?php echo $v['price']; ?></td>
                    <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>

                </tr>
            <?php endforeach; endif; ?>
        </table>
        <div><?php echo $page; ?></div>
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