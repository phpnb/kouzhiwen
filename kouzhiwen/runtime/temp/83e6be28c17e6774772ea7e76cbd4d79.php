<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"/www/wwwroot/kouzhiwen/public/../application/admin/course/view/study/adduser.html";i:1557479267;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        选择学员
    </div>
    <div class="table-box">
        <div class="table-header clearfix">
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="账号/姓名/昵称">
                <input type="hidden" value="<?php echo $allot; ?>" name="allot" >
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th width="20">
                    <input onclick="check_all('uid[]');" name="check_all" type="checkbox" value="">
                </th>
                <th>账号</th>
                <th>姓名</th>
                <th>昵称</th>
                <th>头像</th>
                <th>手机</th>
                <th>部门</th>
                <th>职位</th>
                <th>用户余额</th>

                <th width="100">操作</th>
            </tr>
            <?php if((!empty($data))): ?>
            <form action="" class="verify-form rform">
            <?php foreach($data AS $v): ?>
            <tr>
                <td>
                    <input name="uid[]" type="checkbox"
                           <?php foreach($anyu AS $k): if(($v['uid'] ==$k)): ?>
                           checked
                           <?php endif; endforeach; ?> value="<?php echo $v['uid']; ?>">
                </td>
                <td><?php echo $v['phone']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['nickname']; ?></td>
                <td><img src='<?php echo $v['face']; ?>' style='max-width:100px;'></td>
                <td><?php echo $v['phone']; ?></td>
                <td><?php echo $v['company_name']; ?></td>
                <td><?php echo $v['unit_title']; ?></td>
                <td><?php echo $v['balance']; ?></td>
                <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>
            </tr>
            <?php endforeach; endif; ?>
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">保存</button></td>
            </tr>
            </form>
        </table>
    </div>
</div>

<script type="text/javascript">
    function all_export(url, inputName, data, fn) {
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
        data.id = id;
        if(data.id==''){
            data.id=0;
        }
        location.href=url+"?id="+data.id;
    }

    function ajax_post_auditing(url, id, fn){
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
                data: {id:id,allot:2},
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
                data: {id:id,allot:3},
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
    function all_operation_auditing(url, inputName, data, fn){
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
        ajax_post_auditing(url, id, fn);
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