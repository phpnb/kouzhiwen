<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:82:"/www/wwwroot/kouzhiwen/public/../application/admin/finance/view/recharge/user.html";i:1540285506;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1506416450;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        企业充值
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <?php if(($enterprise_id==0)): ?>
        <li><a href="<?php echo url('user'); ?>" class="this">企业充值</a></li>
        <?php endif; ?>
        <li><a href="<?php echo url('index'); ?>" >学员充值</a></li>
    </ul>

    <div class="table-box">

    </div>

    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">企业名称</th>
                <td>
                    <select name="enterprise" id="enterprise" class="form-control w426" datatype="n">
                        <?php foreach($enterprise as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">学员人数上限</th>
                <td><input name="student" id="student" type="text" class="form-control w400" datatype="n"></td>
            </tr>
            <tr>
                <th class='msg'>到期时间</th>
                <td>
                    <input type="text" id="time-expire" name="expire" class="date-plugin form-control w200" value="" placeholder="选择日期" datatype="*" autocomplete="off">
                </td>
            </tr>
            <!--<tr>-->
                <!--<th width="150" class="msg">充值金额</th>-->
                <!--<td><input name="price" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/" nullmsg="请填写充值金额！"></td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<th class="msg">充值方式</th>-->
                <!--<td>-->
                    <!--<label class="checkbox-inline">-->
                        <!--<input type="radio" name="type" value="1"> 支付宝-->
                    <!--</label>-->
                    <!--<label class="checkbox-inline">-->
                        <!--<input type="radio" name="type" value="2"> 微信-->
                    <!--</label>-->
                <!--</td>-->
            <!--</tr>-->
            <tr>
                <td></td>
                <td><button type="button" class="btn btn-success" onclick="ajax_post('<?php echo url(); ?>');">充值</button></td>
            </tr>
        </table>
    </form>
    <div id="pay"></div>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>
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
    $(function(){
        $('#time-expire').datetimepicker({
            format: 'yyyy-mm-dd',
            language:'zh-CN',
            minView:2,
            autoclose:true
        });
        $("#enterprise").change(function () {
            userlist();
        });
        userlist();
    })

    function userlist() {
        var id=$("#enterprise").val();
        $("#student").val("");
        $("#time-expire").val("");
        $.ajax({
            url: '<?php echo url(""); ?>',
            type: 'get',
            dataType: 'json',
            data: {id:id,type:1},
            success: function(data){
                data=data.data;

                $("#student").val(data.student);
                $("#time-expire").val(data.expire);

            },
            error: function(){

            }
        })
    }
    /**
     * [ajax_post 异步POST请求]
     */
    function ajax_post(url, data, fn){
        layer.confirm('确定充值吗？', {
            btn: ['充值', '取消']
        }, function(){
            loding = layer.load(2, {
                shade: [0.1,'#fff']
            });
            // var price=$("input[name='price']").val();
            // var enterprise=$("input[name='enterprise']:checked").val();
            var enterprise=$("#enterprise").val();
            var student=$("#student").val();
            var expire=$("#time-expire").val();
            // if(type==1){
            //     location.href=url+"?price="+price+"&type="+type;
            //     return true;
            // }
            $.ajax({
                url : url,
                type: 'post',
                dataType: 'json',
                data: {student:student,enterprise:enterprise,expire:expire},
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

                    // if (ret.status == 1 && type==2) {
                    //     // open_frame('班级成员', 100, 100, true);
                    //     var url ="<?php echo url('recharge'); ?>?img="+ret.data;
                    //     var _img = '<img src="'+url+'" style="position:absolute; top:0; bottom:0; left:0; right:0; margin:auto;min-width:50%; min-height:50%; max-width:100%; max-height:100%;">';
                    //
                    //     layer.open({
                    //         type: 1,
                    //         title: false,
                    //         closeBtn: 0,
                    //         area: ['80%', '90%'],
                    //         shade: 0.1,
                    //         skin: 'layui-layer-nobg', //没有背景色
                    //         shadeClose: true,
                    //         content: _img
                    //     });
                    //
                    // }else{
                    //     layer.msg(ret.msg,{'time':1000});
                    // }
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