<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/admin/index.html";i:1532657808;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        后台管理员
    </div>
    
    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li>
            <a href="#" class="this">数据列表</a>
        </li>
        <li>
            <a 
                href="<?php echo url('add'); ?>" 
                target="frame_dispose" 
                onclick="open_frame('添加', 100, 100, true);">
                添加数据
            </a>
        </li>
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="账号">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <table class="table">
            <tr>
                <th width="20">#</th>
                <th width="200">用户名</th>
                <th width="200">是否锁定</th>
                <!--<th width="200">模块</th>-->
                <th>所属角色</th>
                <th width="100">操作</th>
            </tr>
       <!-- </table>-->
        <?php if((!empty($data))): foreach($data AS $key => $val): ?>
        <!--<h2 class="tableshow"><?php echo $key; ?></h2>-->
           <!-- <table class="table">-->
                <?php foreach($val AS $v): ?>
                <tr>
                    <td width="20"></td>
                    <td width="200"><?php echo $v['username']; ?></td>
                    <td width="200">
                        <?php if($v['islock'] == 0): ?>
                        <span class="label label-info f12">否</span>
                        <?php else: ?>
                        <span class="label label-danger f12">是</span>
                        <?php endif; ?>
                    </td>
                    <!--<td width="200"><?php echo $v['module']; ?></td>-->
                    <td>
                        <?php foreach($v['name'] AS $val): ?>
                            <?php echo $val['name']; ?> ,
                        <?php endforeach; ?>
                    </td>
                    <td width="100" class="operation">
                        <a href="<?php echo url('edit',['aid'=>$v['aid']]); ?>" target="frame_dispose"
                        onclick="open_frame('编辑', 100, 100, true)"
                        class="glyphicon glyphicon-edit" title="编辑"></a>
                        <?php if($v['aid']!=1): ?>
                        <a class="glyphicon glyphicon-trash"
                        onclick="ajax_post('<?php echo url('del'); ?>',{'aid':<?php echo $v['aid']; ?>});" title="删除"></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>

            </table>
        <?php endforeach; else: ?>
        <tr>
            <td align="center" colspan="20">暂无数据！</td>
        </tr>
        <?php endif; ?>
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