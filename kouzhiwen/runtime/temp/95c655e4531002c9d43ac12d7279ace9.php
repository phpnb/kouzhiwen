<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\study\kouzhiwen\public/../application/admin/course\view\paper\index.html";i:1566983226;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1566983226;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1566983226;}*/ ?>
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
        考试系统
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('',['type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>班级考试</a></li>
        <li><a href="<?php echo url('',['type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>专业考试</a></li>
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
                <button type="button" class="btn btn-danger btn-sm"
                onclick="all_operation('<?php echo url('del'); ?>','id[]');">
                    删除<i class="glyphicon glyphicon-trash ml5"></i>
                </button>
            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="hidden" value="<?php echo $type; ?>" name="type" >
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="标题">
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
                <th>类型</th>
                <th>班级</th>
                <th>标题</th>
                <th>图片</th>
                <th>题的数量</th>
                <th>考试时间（分钟</th>
                <th>满分</th>
                <th>及格</th>
                <th>开始时间</th>
                <th>结束时间</th>


                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <td>
                        <input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">
                    </td>
                    <td><?php echo $v['id']; ?></td>
                    <td>
                        <?php if((!empty($checkVal['typeVal'][$v['type']]))): ?>
                            <?php echo $checkVal['typeVal'][$v['type']]; endif; ?>
                    </td>
                    <td>
                        <?php if((!empty($checkVal['class_idVal'][$v['class_id']]))): ?>
                            <?php echo $checkVal['class_idVal'][$v['class_id']]; endif; ?>
                    </td>
                    <td><?php echo $v['title']; ?></td>
                    <td><img src='<?php echo $v['photo']; ?>' style='max-width:100px;'></td>
                    <td><?php echo $v['number']; ?></td>
                    <td><?php echo $v['time']; ?></td>
                    <td><?php echo $v['full']; ?></td>
                    <td><?php echo $v['pass']; ?></td>
                    <td><?php echo $v['start_time']; ?></td>
                    <td><?php echo $v['end_time']; ?></td>

                    <td class="operation">
                        <a href="<?php echo url('edit',['id'=>$v['id']]); ?>" target="frame_dispose"
                        onclick="open_frame('修改数据', 100, 100, true)"
                        class="glyphicon glyphicon-edit" title="编辑"></a>
                        <a href="<?php echo url('problem',['id'=>$v['id']]); ?>" target="frame_dispose"
                           onclick="open_frame('试题设置', 100, 100, true)"
                           class="glyphicon glyphicon-education" title="试题设置"></a>
<a class="glyphicon glyphicon-trash"
                        onclick="ajax_post('<?php echo url('del'); ?>',{'id':<?php echo $v['id']; ?>});" title="删除"></a>

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