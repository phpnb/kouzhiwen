<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/index/index.html";i:1547020261;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1506416450;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
            <li  class="this" >
            <a href="<?php echo url('info/teachernotice/index'); ?>" target="iframe">
                信息通知
            </a>
            </li>
        </ul>
    </div>
<?php use think\Session; $users = Session::get('teacherUser'); if(count($group) > 8): ?>
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

    <?php  $one = 1;?>

        <h2 <?php if($one == 1): ?> class="this" <?php endif; ?>><i class="glyphicon glyphicon-home"></i>管理</h2>
        <p <?php if($one == 1): ?> style="display: block;" <?php endif; ?>>
            <?php if((in_array(2,$identity))): ?>
                <a href="<?php echo url('course/study/index',['id'=>$user['id']]); ?>" target="iframe">班级列表</a>
                <a href="<?php echo url('course/study/class_notice',['id'=>$user['id']]); ?>" target="iframe">班级通知</a>
                <a href="<?php echo url('info/teacherarticle/index',['type'=>2]); ?>" target="iframe">班级热点</a>
            <?php endif; if((in_array(1,$identity) || in_array(2,$identity))): ?>
                <a href="<?php echo url('course/study/questionnaire_user',['id'=>$user['id']]); ?>" target="iframe">问卷列表</a>
                <a href="<?php echo url('course/study/paper',['id'=>$user['id']]); ?>" target="iframe">阅卷列表</a>
            <?php endif; if((in_array(1,$identity) || in_array(3,$identity))): ?>
                <a href="<?php echo url('info/teacherarticle/index',['type'=>1]); ?>" target="iframe">研究动态</a>
                <a href="<?php echo url('course/study/user_quiz',['id'=>$user['id']]); ?>" target="iframe">留言列表</a>
                <a href="<?php echo url('course/broadcast/index',['id'=>$user['id']]); ?>" target="iframe">直播管理</a>
                <a href="<?php echo url('course/study/teacher_pay',['id'=>$user['id']]); ?>" target="iframe">提现列表</a>
            <?php endif; ?>
                <a href="<?php echo $url; ?>/ims/im.html?id=<?php echo $user['id']; ?>" target="_blank">IM聊天</a>
                <a href="<?php echo url('root/login/updetail'); ?>" target="iframe">个人信息</a>
        </p>
        <?php $one = 0;?>
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