<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:83:"/www/wwwroot/kouzhiwen/public/../application/headmaster/course/view/study/sign.html";i:1545806851;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1506416450;s:89:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/webuploader.html";i:1545806856;s:85:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/ueditor.html";i:1545806856;s:88:"/www/wwwroot/kouzhiwen/public/../application/headmaster/root/view/common/dateplugin.html";i:1545806856;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    <!-- 菜单 -->
    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
                <button type="button" class="btn btn-success btn-sm"
                        onclick="all_export('<?php echo url(''); ?>',<?php echo $id; ?>);">
                    导出<i class="glyphicon glyphicon-cloud-download ml5"></i>
                </button>
            </div>
            <form action="" method="get" class="clearfix fr">
             
                    <input type="text" id="time-start" name="start" class="form-control search-in" value="<?php echo $start; ?>" placeholder="开始时间" datatype="">
                    <input type="text" id="time-end" name="end" class="form-control search-in" value="<?php echo $end; ?>" placeholder="结束时间" datatype="">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="昵称">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <table class="table">
            <tr>
                <th width="20">序号</th>
                <th width="200">姓名</th>
                <th width="200">职称</th>
                <th width="200">电话</th>
                <th width="100">签到时间</th>
                <!-- <th width="100">操作</th> -->
            </tr>
            <!-- </table>-->
            <?php if((!empty($data))): foreach($data AS $k=>$v): ?>
            <tr>
                <td width="20"><?php echo $k+1; ?></td>
                <td width="200"><?php echo $v['name']; ?></td>
                <td width="200"><?php echo $v['unit_title']; ?></td>
                <td width="200"><?php echo $v['tel']; ?></td>
                <td width="100" class="operation">
                    <?php echo date('Y-m-d H:i:s', $v['created_at']); ?>
                </td>
                <!-- <td>
                <a href="<?php echo url('info/user/sign',['uid'=>$v['uid'],'qun_id'=>$v['qun_id']]); ?>" target="frame_dispose"
                           onclick="open_frame('签到记录', 100, 100, true)"
                           class="glyphicon glyphicon-list-alt" title="签到记录"></a>
                        <a href="<?php echo url('info/user/achievement',['uid'=>$v['uid']]); ?>" target="frame_dispose"
                           onclick="open_frame('学员成绩', 100, 100, true)"
                           class="glyphicon glyphicon-list-alt" title="学员成绩"></a>
                        <a href="<?php echo url('info/user/studyrecord',['uid'=>$v['uid']]); ?>" target="frame_dispose"
                           onclick="open_frame('学习记录', 100, 100, true)"
                           class="glyphicon glyphicon-list-alt" title="学习记录"></a>
                        <a href="<?php echo url('info/user/progress',['uid'=>$v['uid']]); ?>" target="frame_dispose"
                           onclick="open_frame('学习进度', 100, 100, true)"
                           class="glyphicon glyphicon-list-alt" title="学习进度"></a>
                        <a href="<?php echo url('info/user/consume',['uid'=>$v['uid']]); ?>" target="frame_dispose"
                           onclick="open_frame('消费记录', 100, 100, true)"
                           class="glyphicon glyphicon-usd" title="消费记录"></a>
                        
                           <a class="glyphicon glyphicon-trash"
                           onclick="ajax_post('<?php echo url('stop'); ?>',{'uid':<?php echo $v['uid']; ?>,'qun_id':<?php echo $v['qun_id']; ?>});" title="禁言"></a>
                           <a class="glyphicon glyphicon-trash"
                           onclick="ajax_post('<?php echo url('getstop'); ?>',{'uid':<?php echo $v['uid']; ?>,'qun_id':<?php echo $v['qun_id']; ?>});" title="解除禁言"></a>
                           <a class="glyphicon glyphicon-trash"
                           onclick="ajax_post('<?php echo url('delgou'); ?>',{'uid':<?php echo $v['uid']; ?>,'qun_id':<?php echo $v['qun_id']; ?>});" title="踢出群组"></a>
                       </td> -->
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td align="center" colspan="20">暂无数据！</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>
<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.config.js?v=3"></script>
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.all.min.js"> </script>
<link href="/static/common/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/static/common/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/common/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/static/common/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
    $(function(){
        if ($('.date-plugin').length > 0) {
            $('.date-plugin').change(function(){
                $(this).blur();
            })
        }
    })
</script>
<script type="text/javascript">
  $('#time-start').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
});

$('#time-end').datetimepicker({
    format: 'yyyy-mm-dd',
    language:'zh-CN',
    minView:2,
    autoclose:true
});
  function all_export(url,id, fn) {
      // 组合批量操作的ID
      location.href=url+"?exl=exl&id="+id;
  }
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