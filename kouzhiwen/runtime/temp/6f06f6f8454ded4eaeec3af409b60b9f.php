<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/finance/view/recharge/index.html";i:1540195478;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
        学员充值
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <?php if(($enterprise_id==0)): ?>
        <li><a href="<?php echo url('user'); ?>" >企业充值</a></li>
        <?php endif; ?>
        <li><a href="<?php echo url('index'); ?>" class="this">学员充值</a></li>
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
                <th width="150" class="msg">充值金额</th>
                <td><input name="price" type="text" class="form-control w400" datatype="/^(\d{1,8}|\d{1,8}\.\d{1,2})$/" nullmsg="请填写充值金额！"></td>
            </tr>
            <?php if(($enterprise_id==0)): ?>
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
                <th width="150" class="msg">充值学员</th>
                <td>
                    <select name="user" id="user" class="form-control w426" datatype="n">
                    </select>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <th width="150" class="msg">充值学员</th>
                <td>
                    <select name="user" id="user" class="form-control w426" datatype="n">
                        <?php foreach($user as $v): ?>
                        <option value="<?php echo $v['uid']; ?>"><?php echo $v['name']; ?>/<?php echo $v['phone']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; if(($enterprise_id!=0)): ?>
            <tr>
                <th class="msg">充值方式</th>
                <td>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="1"> 支付宝
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" value="2"> 微信
                    </label>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td></td>
                <td><button type="button" class="btn btn-success" onclick="ajax_post('<?php echo url(); ?>');">充值</button></td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
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
            var price=$("input[name='price']").val();
            var type=$("input[name='type']:checked").val();
            var uid=$("#user").val();
            if(price=='' || price<0){
                layer.close(loding);
                layer.msg('请输入充值金额',{'time':1000});
                return true;
            }
            if(uid=='null' || uid==''){
                layer.close(loding);
                layer.msg('请选择充值学员',{'time':1000});
                return true;
            }
            if(<?php echo $enterprise_id; ?>==0){
                rechargepay(price,uid,fn);
            }else{

                if(type==undefined || type==''){
                    layer.close(loding);
                    layer.msg('请选择充值方式',{'time':1000});
                    return true;
                }
                pay(url,price,type,uid,fn);
            }

    }, function(){

        })};

    $(function(){
        if(<?php echo $enterprise_id; ?>==0) {
            $("#enterprise").change(function () {
                userlist();
            });
            userlist();
        }
    })

    function userlist() {
        var id=$("#enterprise").val();
        $("#user").empty();
        $.ajax({
            url: '<?php echo url("userlist"); ?>',
            type: 'get',
            dataType: 'json',
            data: {id:id},
            success: function(data){
                let html="";
                data=data.data;

                if(data.length>0){
                    for(var i=0;i<data.length;i++){
                        html +="<option value="+data[i]['uid']+">"+data[i]['name']+"/"+data[i]['phone']+"</option>";
                    }
                }
                $('#user').html(html);

            },
            error: function(){

            }
        })
    }

    function pay(url,price,type,uid,fn) {
        if(type==1){
            location.href=url+"?price="+price+"&type="+type+"&uid="+uid;
            return true;
        }
        $.ajax({
            url : url,
            type: 'post',
            dataType: 'json',
            data: {price:price,type:type,uid:uid},
            success:function(ret){
                layer.close(loding);
                // 是否自定义了回调函数
                if (is_function(fn)) {
                    fn(ret);
                    return;
                }


                if (ret.status == 1) {
                    // open_frame('班级成员', 100, 100, true);
                    var url ="<?php echo url('recharge'); ?>?img="+ret.data;
                    var _img = '<img src="'+url+'" style="position:absolute; top:0; bottom:0; left:0; right:0; margin:auto;min-width:50%; min-height:50%; max-width:100%; max-height:100%;">';

                    layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['80%', '90%'],
                        shade: 0.1,
                        skin: 'layui-layer-nobg', //没有背景色
                        shadeClose: true,
                        content: _img
                    });

                }else{
                    layer.msg(ret.msg,{'time':1000});
                }
            }
        })
    }
    
    function rechargepay(price,uid,fn) {
        $.ajax({
            url : "<?php echo url('rechargepay'); ?>",
            type: 'post',
            dataType: 'json',
            data: {price:price,uid:uid},
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