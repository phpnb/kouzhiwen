<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/kouzhiwen/public/../application/admin/finance/view/pay/index.html";i:1535619324;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        提现管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index',['status'=>1]); ?>"  <?php if(($status==1)): ?>class="this"<?php endif; ?>>资金分配</a></li>
        <li><a href="<?php echo url('index',['status'=>2]); ?>"  <?php if(($status==2)): ?>class="this"<?php endif; ?>>提现记录</a></li>

    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <form action="" method="get" class="clearfix fr">
                <input type="hidden" value="<?php echo $status; ?>" name="status" >
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="打款账号/老师名称">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>企业名称</th>
                <th>教师名称</th>
                <th>打款账号</th>
                <th>提现方式</th>
                <th>提现金额</th>
                <th>手续费</th>
                <th>创建时间</th>
                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo (isset($v['enterprisename']) && ($v['enterprisename'] !== '')?$v['enterprisename']:"平台"); ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['account_num']; ?></td>
                    <td>
                        <?php if((!empty($checkVal['pay_typeVal'][$v['pay_type']]))): ?>
                            <?php echo $checkVal['pay_typeVal'][$v['pay_type']]; endif; ?>
                    </td>
                    <td><?php echo $v['account']; ?></td>
                    <td><?php echo $v['brokerage']; ?></td>
                    <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>

                    <td class="operation">
                        <a class="glyphicon glyphicon-saved"
                           onclick="ajax_post('<?php echo url('pay'); ?>',{'id':<?php echo $v['id']; ?>});" title="打款"></a>
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