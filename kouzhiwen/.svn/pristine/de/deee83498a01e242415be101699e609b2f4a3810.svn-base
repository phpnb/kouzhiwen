<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"/www/wwwroot/kouzhiwen/public/../application/admin/info/view/teacher/research_examine.html";i:1540175612;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        教师管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index'); ?>" >数据列表</a></li>
        <li><a href="<?php echo url('index',['type'=>2]); ?>">信息审核</a></li>
        <li><a href="<?php echo url('research_examine',['type'=>1]); ?>" <?php if(($type=="1")): ?>class="this"<?php endif; ?>>动态审核</a></li>
        <li><a href="<?php echo url('research_examine',['type'=>2]); ?>" <?php if(($type=="2")): ?>class="this"<?php endif; ?>>研究动态</a></li>
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
            <!--<div class="all-operation fl clearfix">-->
                <!--<button type="button" class="btn btn-danger btn-sm"-->
                <!--onclick="all_operation('<?php echo url('research_examine'); ?>','id[]',{'status':1});">-->
                    <!--删除<i class="glyphicon glyphicon-trash ml5"></i>-->
                <!--</button>-->
            <!--</div>-->
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="标题">
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
                <th width="20">序号</th>
                <th width="20">老师姓名</th>
                <th width="20">老师称呼</th>
                <th width="20">老师头像</th>
                <th width="200">标题</th>
                <th width="200">图片</th>
                <th width="200">评论总数</th>
                <th width="200">浏览量</th>
                <th width="200">状态</th>
                <th width="100">创建时间</th>
                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <!--<td>-->
                        <!--<input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">-->
                    <!--</td>-->
                    <td width="200"><?php echo $v['id']; ?></td>
                    <td width="200"><?php echo $v['t_name']; ?></td>
                    <td width="200"><?php echo $v['title']; ?></td>
                    <td width="200"><img src='<?php echo $v['photo']; ?>' style='max-width:100px;'></td>
                    <td width="200"><?php echo $v['name']; ?></td>
                    <td>
                        <img src='<?php echo $v['cover_img']; ?>' style='max-width:100px;'>
                    </td>
                    <td width="200"><?php echo $v['comment_num']; ?></td>
                    <td width="200"><?php echo $v['pv']; ?></td>
                    <td width="200">
                        <?php if(($v['status']==0)): ?>
                        <span class="label label-info f12">待审核</span>
                        <?php elseif(($v['status']==1)): ?>
                        <span class="label label-success f12">正常</span>
                        <?php else: ?>
                        <span class="label label-danger f12">审核未通过</span>
                        <?php endif; ?>
                    </td>
                    <td width="100" class="operation">
                        <?php echo date('Y-m-d H:i:s', $v['add_time']); ?>
                    </td>

                    <td class="operation">
                        <a href="<?php echo url('research_show',['id'=>$v['id']]); ?>" target="frame_dispose"
                           onclick="open_frame('详情', 100, 100, true)"
                           class="glyphicon glyphicon-list-alt" title="详情"></a>
                        <?php if(($v['status']==0)): ?>
                        <a class="glyphicon glyphicon-ok"
                        onclick="ajax_post('<?php echo url('research_examine'); ?>',{'id':<?php echo $v['id']; ?>,'status':1});" title="审核成功"></a>
                        <a class="glyphicon glyphicon-remove"
                           onclick="ajax_post('<?php echo url('research_examine'); ?>',{'id':<?php echo $v['id']; ?>,'status':2});" title="审核失败"></a>
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