<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/www/wwwroot/kouzhiwen/public/../application/admin/finance/view/procedures/index.html";i:1535616244;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        手续费设置
    </div>

    <!-- 菜单 -->
    <!--<ul class="clearfix menu">-->
        <!--<li><a href="" class="this">手续费设置</a></li>-->
    <!--</ul>-->

    <div class="table-box">

    </div>

    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">手续费(%</th>
                <td>
                    <input name="procedures" type="text" value="<?php echo $content; ?>" class="form-control w400" datatype="n" nullmsg="手续费！">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="button" class="btn btn-success" onclick="ajax_post('<?php echo url(); ?>');">保存</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    /**
     * [ajax_post 异步POST请求]
     */
    function ajax_post(url, data, fn){
        // layer.confirm('确定操作吗？', {
        //     btn: ['确定', '取消']
        // }, function(){
            loding = layer.load(2, {
                shade: [0.1,'#fff']
            });
            var procedures=$("input[name='procedures']").val();
            $.ajax({
                url : url,
                type: 'post',
                dataType: 'json',
                data: {procedures:procedures},
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
        // }, function(){
        //
        // });
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