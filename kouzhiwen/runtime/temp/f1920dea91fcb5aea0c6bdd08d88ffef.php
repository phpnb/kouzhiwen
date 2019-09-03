<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\study\kouzhiwen\public/../application/admin/info\view\questions\index.html";i:1567474397;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/header.html";i:1566983226;s:75:"D:\study\kouzhiwen\public/../application/admin/root\view\common/footer.html";i:1566983226;}*/ ?>
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
        提问管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index',['type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>提问列表</a></li>
        <li><a href="<?php echo url('index',['type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>分享列表</a></li>
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
                <th>内容</th>
                <th>评论数</th>
                <th>点赞数</th>
                <th>作者</th>
                <th>创建时间</th>
                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
                <tr>
                    <td>
                        <input name="id[]" type="checkbox" value="<?php echo $v['id']; ?>">
                    </td>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['contents']; ?></td>
                    <td><?php echo $v['comment_num']; ?></td>
                    <td><?php echo $v['zan']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo !empty($v['add_time'])?date('Y-m-d H:i:s', $v['add_time']) : '----'; ?></td>

                    <td class="operation">
                        <a href="<?php echo url('edit',['id'=>$v['id']]); ?>"
                           class="glyphicon glyphicon-eye-open" title="查看"></a>
                            <a class="glyphicon glyphicon-trash"
                        onclick="ajax_post('<?php echo url('del'); ?>',{'id':<?php echo $v['id']; ?>,'status':0});" title="删除"></a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </table>
        <div><?php echo $page; ?></div>
    </div>
</div>
<?php if(($type==2)): ?>
<script type="text/javascript">

    function ajax_post(url, id, fn){
        layer.confirm('确定操作吗？', {
            btn: ['审核成功','审核失败', '取消']
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
            loding = layer.load(2, {
                shade: [0.1,'#fff']
            });
            $.ajax({
                url : url,
                type: 'post',
                dataType: 'json',
                data: {id:id,status:3},
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
    /**
     * [all_operation 批量操作]
     */
    function all_operation(url, inputName, data, fn){
        if (!is_var(data)) {
            data = {};
        }
        // 组合批量操作的ID
        var id = '';
        var d  = '';

        $.each($('input[name="'+inputName+'"]:checked'), function(index, val) {
            id += d + $(this).val();
            d = ',';
        });
        if (id == '') {
            layer.msg('请选择要操作的内容', {time:1000});
            return;
        }
        // post 请求
        ajax_post(url, id, fn);
    }
</script>
<?php endif; ?>
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