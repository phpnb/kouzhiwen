<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/access_group/index.html";i:1532657752;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    .top-module{
        text-align: left;
        height: 40px; line-height: 40px;
        background-color: #fff;
        font-size:16px; font-weight: bold;
        color: red;
    }
</style>
<div id="right_content">
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        角色管理
    </div>
    
    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="#" class="this">数据列表</a></li>
        <li>
            <a 
                href="<?php echo url('add'); ?>" target="frame_dispose" 
                onclick="open_frame('添加', 100, 100, true);">
                添加新角色
            </a>
        </li>

    </ul>

    <div class="table-box">

        <table class="table">
            <tr>
                <th width="20">#</th>
                <th>角色名称</th>
                <th width="200">添加时间</th>
                <th width="200">修改时间</th>

                <th width="100">操作</th>
            </tr>
       <!-- </table>-->

            <?php if((!empty($data))): foreach($data AS $k => $val): ?>
               <!-- <h2 class="tableshow"><?php echo $k; ?></h2>
                <table class="table">-->
                    <?php foreach($val AS $v): ?>
                        <tr>
                            <td width="20"></td>
                            <td><?php echo $v['name']; ?></td>
                            <td width="200"><?php echo date('Y-m-d H:i:s', $v['add_time']); ?></td>
                            <td width="200"><?php echo !empty($v['edit_time'])?date('Y-m-d H:i:s', $v['edit_time']) : '----'; ?></td>

                            <td width="100" class="operation">
                                <a href="<?php echo url('edit',['id'=>$v['id']]); ?>?module_name=<?php echo $k; ?>" target="frame_dispose"
                                onclick="open_frame('修改数据', 100, 100, true)"
                                class="glyphicon glyphicon-edit" title="编辑"></a>
                                <a href="<?php echo url('user',['id'=>$v['id']]); ?>" target="frame_dispose"
                                onclick="open_frame('角色成员', 100, 100, true)"
                                class="glyphicon glyphicon-user cl-blue" title="角色成员"></a>
                                <a class="glyphicon glyphicon-trash"
                                onclick="ajax_post('<?php echo url('del'); ?>',{'id':<?php echo $v['id']; ?>});" title="删除"></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; endif; ?>
        </table>
        <div></div>
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