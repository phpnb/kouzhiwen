<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/index/index.html";i:1538979364;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<script>
    var mr = 1;
</script>
<!-- 顶部 -->
<div id="top" class="clearfix">
    <div class="logo fl">
        <h2><span>ZPF</span> Framework Pro</h2>
    </div>
    <a href="javascript:;" class="fl glyphicon glyphicon-chevron-left menu-morel vh"></a>
    <div id="top-menu" class="clearfix fl">
        <ul class="fl clearfix">
            <?php foreach($group AS $k => $v): ?>
            <li <?php if($v['id'] == $gid): ?> class="this" <?php endif; ?> >
            <a href="<?php echo url('',['id'=>$v['id']]); ?>">
                <?php echo $v['name']; ?>
            </a>
            </li>

            <?php if($v['id'] == $gid): $tk = floor($k / 8)?>
            <script>
                var tk = <?php echo $tk; ?>;
                if (tk > 0) {
                    $('#top-menu ul').css({
                        'left': '-' + 800 * <?php echo $tk; ?> + 'px'
                    });
                    $('.menu-morel').removeClass('vh');
                    mr += 1;
                }
            </script>
            <?php endif; endforeach; ?>
        </ul>
    </div>

    <?php if(count($group) > 8): ?>
    <a href="javascript:;" class="fl glyphicon glyphicon-chevron-right menu-morer"></a>
    <?php endif; ?>

    <div class="fr">
        <p>
            <i class="glyphicon glyphicon-user"></i> <?php echo $user['username']; ?>
            <a href="<?php echo url('root/login/login_out'); ?>">[退出]</a>
            <a href="<?php echo url('root/login/edit_pwd'); ?>" target="iframe">[改密]</a>
        </p>
    </div>
</div>

<!-- 左侧导航 -->
<div id="menu">
    <!--<h2><i class="glyphicon glyphicon-check"></i>Framework UI</h2>-->
    <!--<p>-->
        <!--<a href="<?php echo url('admin/root/index/table'); ?>" target="iframe">table</a>-->
        <!--<a href="<?php echo url('admin/root/index/form'); ?>" target="iframe">form</a>-->
        <!--<a href="<?php echo url('admin/root/index/chart'); ?>" target="iframe">chart</a>-->
    <!--</p>-->
    <p></p>
    <?php $one = 1;foreach($menu AS $k => $v): ?>
        <h2 <?php if($one == 1): ?> class="this" <?php endif; ?>><i class="<?php echo $mc[$k]['icon']; ?>"></i><?php echo $mc[$k]['name']; ?></h2>
        <p <?php if($one == 1): ?> style="display: block;" <?php endif; ?>>
            <?php if(is_array($v) || $v instanceof \think\Collection || $v instanceof \think\Paginator): $i = 0; $__LIST__ = $v;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;if(($val['is_show'] == 1)): if(($val['address'] == '')): ?>
                        <a href="<?php echo url($val['module'] . '/' . $val['controller'] . '/index'); ?>" target="iframe"><?php echo $val['name']; ?></a>
                    <?php else: ?>
                        <a href="<?php echo url($val['module'] . '/' . $val['controller'] . '/' . $val['address']); ?>" target="iframe"><?php echo $val['name']; ?></a>
                    <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
        </p>
        <?php $one = 0;endforeach; ?>
</div>

<div id="content">
    <iframe src="<?php echo url('index/welcome',['id'=>$id]); ?>" scrolling="auto" frameborder="0" name="iframe"></iframe>
</div>
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