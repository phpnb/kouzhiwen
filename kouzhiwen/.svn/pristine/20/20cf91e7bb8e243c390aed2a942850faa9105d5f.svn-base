<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"D:\study\kouzhiwen\public/../application/admin/root\view\report\index.html";i:1561034082;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1560313173;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1560313174;}*/ ?>
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


    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="姓名/称呼/手机号">
                <input type="hidden" value="<?php echo $type; ?>" name="type" >
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
                <th>名称</th>
                <th>举报人</th>
                <th>举报说明</th>
                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
            <tr>
                <td>
                    <input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">
                </td>
                <td><?php echo $v['rid']; ?></td>
                <td><?php echo $v['contents']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['content']; ?></td>
                <td class="operation">
                    <a href="<?php echo url('add',['id'=>$v['id']]); ?>" target="frame_dispose"
                       onclick="open_frame('查看', 100, 100, true)"
                       class="glyphicon glyphicon-search" title="查看"></a>
                    <a class="glyphicon glyphicon-retweet"
                       onclick="ajax_post('<?php echo url('del'); ?>',<?php echo $v['rid']; ?>);" title="审核"></a>

                </td>
            </tr>
            <?php endforeach; endif; ?>
        </table>
        <div><?php echo $page; ?></div>
    </div>
</div>
<script type="text/javascript">

    function ajax_post(url, id, fn){
        layer.confirm('确定操作吗？', {
            btn: ['删除','保留', '取消']
        }, function(){
            loding = layer.load(2, {
                shade: [0.1,'#fff']
            });
            $.ajax({
                url : url,
                type: 'post',
                dataType: 'json',
                data: {id:id,status:2},
                success:function(ret){
                    layer.close(loding);
                    // 是否自定义了回调函数
                    if (is_function(fn)) {
                        fn(ret);
                        return;
                    }

                    layer.msg(ret.msg,{'time':1000});
                    if (ret.status == 1) {
                        setTimeout(function(){
                            location.reload();
                        }, 500);
                    }
                }
            })
        }, function(){
            loding = layer.load(2, {
                shade: [0.1,'#fff']
            });
            $.ajax({
                url : url,
                type: 'post',
                dataType: 'json',
                data: {id:id,status:1},
                success:function(ret){
                    layer.close(loding);
                    // 是否自定义了回调函数
                    if (is_function(fn)) {
                        fn(ret);
                        return;
                    }

                    layer.msg(ret.msg,{'time':1000});
                    if (ret.status == 1) {
                        setTimeout(function(){
                            location.reload();
                        }, 500);
                    }
                }
            })
        }, function(){

        });
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