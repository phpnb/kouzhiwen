<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/index.html";i:1547537647;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/header.html";i:1534993716;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/footer.html";i:1534993716;}*/ ?>
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
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        学习班管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="#" class="this">数据列表</a></li>
        <!-- <li>
            <a
                href="<?php echo url('add'); ?>" target="frame_dispose"
                onclick="open_frame('添加', 100, 100, true);">
                添加数据
            </a>
        </li> -->


    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <!--<div class="all-operation fl clearfix">-->
            <!--<button type="button" class="btn btn-danger btn-sm"-->
            <!--onclick="all_operation('<?php echo url('del'); ?>','id[]');">-->
            <!--删除<i class="glyphicon glyphicon-trash ml5"></i>-->
            <!--</button>-->
            <!--</div>-->
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="班级名称">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <!--<th width="20">-->
                <!--<input onclick="check_all('id[]');" name="check_all" type="checkbox" value="">-->
                <!--</th>-->
                <th>ID</th>
                <?php if($checkVal['enterprise_id'] != '0'): ?>
                <th>分类</th>
                <?php else: ?>
                <th>分类</th>
                <?php endif; ?>
                <th>班级名称</th>
                <th>图片</th>
                <th>限定人数</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>价格</th>
                <th>班主任</th>
                <th>类别</th>
                <th>签到二维码</th>
                <th>创建时间</th>

                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
            <tr>
                <!--<td>-->
                <!--<input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">-->
                <!--</td>-->
                <td><?php echo $v['id']; ?></td>
                <?php if($checkVal['enterprise_id'] != '0'): ?>
                <td>
                    <?php if((!empty($checkVal['class_type_idVal'][$v['class_type_id']]))): ?>
                    <?php echo $checkVal['class_type_idVal'][$v['class_type_id']]; endif; ?>
                </td>
                <?php else: ?>
                <td>
                    <?php if((!empty($checkVal['classify_idVal'][$v['classify_id']]))): ?>
                    <?php echo $checkVal['classify_idVal'][$v['classify_id']]; endif; ?>
                </td>
                <?php endif; ?>
                <td><?php echo $v['name']; ?></td>
                <td><img src='<?php echo $v['photo']; ?>' style='max-width:100px;'></td>
                <td><?php echo $v['number']; ?></td>
                <td><?php echo !empty($v['start'])?date('Y-m-d', $v['start']) : '----'; ?></td>
                <td><?php echo !empty($v['end'])?date('Y-m-d', $v['end']) : '----'; ?></td>
                <td><?php echo $v['price']; ?></td>
                <td><?php echo $v['teachername']; ?></td>
                <td>
                    <?php if((!empty($checkVal['typeVal'][$v['type']]))): ?>
                    <?php echo $checkVal['typeVal'][$v['type']]; endif; ?>
                </td>
                <td><img src='<?php echo $v['img_url']; ?>' style='max-width:100px;'></td>

                <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>

                <td class="operation">
                    <a href="<?php echo url('discuss',['id'=>$v['id']]); ?>" target="frame_dispose"
                       onclick="open_frame('讨论组', 100, 100, true)"
                       class="glyphicon glyphicon-comment" title="讨论组"></a>
                    <!--<a href="<?php echo url('edit',['id'=>$v['id']]); ?>" target="frame_dispose"-->
                    <!--onclick="open_frame('修改数据', 100, 100, true)"-->
                    <!--class="glyphicon glyphicon-edit" title="编辑"></a>-->
                    <a href="<?php echo url('user',['id'=>$v['id']]); ?>" target="frame_dispose"
                       onclick="open_frame('班级成员', 100, 100, true)"
                       class="glyphicon glyphicon-user" title="班级成员"></a>
                    <a href="<?php echo url('sign',['id'=>$v['id']]); ?>" target="frame_dispose"
                       onclick="open_frame('签到记录', 100, 100, true)"
                       class="glyphicon glyphicon-list-alt" title="签到记录"></a>
                    <a href="<?php echo $url; ?>/im/im.html?id=<?php echo $v['teacherid']; ?>" target="_blank"
                       class="glyphicon glyphicon-envelope" title="消息"></a>
                    <!--<a class="glyphicon glyphicon-trash"-->
                    <!--onclick="ajax_post('<?php echo url('del'); ?>',{'id':<?php echo $v['id']; ?>});" title="删除"></a>-->

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