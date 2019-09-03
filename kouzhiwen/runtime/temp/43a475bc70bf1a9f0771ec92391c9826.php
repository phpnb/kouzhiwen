<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/paper_user.html";i:1544955759;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        热题管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="#" class="this">数据列表</a></li>

    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <form action="" method="get" class="clearfix fr">
            </form>
        </div>

        <table class="table">
            <tr>
                <!-- <th width="20">
                    <input onclick="check_all('id[]');" name="check_all" type="checkbox" value="">
                </th> -->
                <th>ID</th>
                <th>考生</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>更新时间</th>

                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <!-- <td>
                        <input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">
                    </td> -->
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['nickname']; ?></td>
                    <td>
                        <?php if(($v['status'] == 1)): ?>
                        及格
                        <?php elseif(($v['status'] == 2)): ?>
                        未及格
                        <?php else: ?>
                        阅卷中
                        <?php endif; ?>
                    </td>
                    <td width="100" class="operation">
                    <?php echo date('Y-m-d H:i:s', $v['created_at']); ?>
                </td>
                <td width="100" class="operation">
                    <?php echo date('Y-m-d H:i:s', $v['updated_at']); ?>
                </td>

                    <td class="operation">
                        <a href="<?php echo url('up_puser',['id'=>$v['id']]); ?>" target="frame_dispose"
                        onclick="open_frame('修改数据', 100, 100, true)"
                        class="glyphicon glyphicon-edit" title="编辑"></a>

                    </td>
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