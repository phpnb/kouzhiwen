<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\study\kouzhiwen\public/../application/admin/info\view\enterprise\index.html";i:1560313183;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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
        企业管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index',['type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>数据列表</a></li>
        <li><a href="<?php echo url('index',['type'=>3]); ?>" <?php if(($type==3)): ?>class="this"<?php endif; ?>>快过期</a></li>
        <li><a href="<?php echo url('index',['type'=>4]); ?>" <?php if(($type==4)): ?>class="this"<?php endif; ?>>已过期</a></li>
        <li><a href="<?php echo url('index',['type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>已停用</a></li>
        <li>
            <a
                href="<?php echo url('add'); ?>" target="frame_dispose"
                onclick="open_frame('添加', 100, 100, true);">
                添加数据
            </a>
        </li>

    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
                <?php if(($type==2)): ?>
                <button type="button" class="btn btn-danger btn-sm"
                onclick="all_operation('<?php echo url('del',['status'=>1]); ?>','id[]');">
                    恢复正常<i class="glyphicon glyphicon-ok ml5"></i>
                </button>
                <?php elseif(($type==4)): ?>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="all_operation('<?php echo url('del',['status'=>2]); ?>','id[]');">
                    停用<i class="glyphicon glyphicon-trash ml5"></i>
                </button>
                <?php endif; ?>
            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="hidden" value="<?php echo $type; ?>" name="type"/>
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="企业名称">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th width="20">
                    <input onclick="check_all('id[]');" name="check_all" type="checkbox" value="">
                </th>
                <th>ID</th>
                <th>企业名称</th>
                <th>企业logo</th>
                <th>学员人数上限</th>
                <th>到期时间</th>
                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <td>
                        <input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">
                    </td>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><img src='<?php echo $v['logo']; ?>' style='max-width:100px;'></td>
                    <td><?php echo $v['student']; ?></td>
                    <td><?php echo $v['expire']; ?></td>

                    <td class="operation">
                        <a href="<?php echo url('edit',['id'=>$v['id']]); ?>" target="frame_dispose"
                        onclick="open_frame('修改数据', 100, 100, true)"
                        class="glyphicon glyphicon-edit" title="编辑"></a>
                        <a href="<?php echo url('useradd',['enterprise_id'=>$v['id']]); ?>" target="frame_dispose"
                           onclick="open_frame('添加企业成员', 100, 100, true)"
                           class="glyphicon glyphicon-plus cl-blue" title="添加企业成员"></a>
                        <a href="<?php echo url('user',['id'=>$v['id']]); ?>" target="frame_dispose"
                           onclick="open_frame('企业成员', 100, 100, true)"
                           class="glyphicon glyphicon-user cl-blue" title="企业成员"></a>
                        <?php if(($type==2)): ?>
                        <a class="glyphicon glyphicon-ok"
                        onclick="ajax_post('<?php echo url('del',['status'=>1]); ?>',{'id':<?php echo $v['id']; ?>});" title="恢复正常"></a>
                        <?php elseif((($type==4))): ?>
                        <a class="glyphicon glyphicon-trash"
                           onclick="ajax_post('<?php echo url('del',['status'=>2]); ?>',{'id':<?php echo $v['id']; ?>});" title="停用"></a>
                        <?php endif; ?>
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