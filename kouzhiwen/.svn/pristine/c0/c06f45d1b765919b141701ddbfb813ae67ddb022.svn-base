<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/notice/index.html";i:1540784774;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<style type="text/css">
    .table_left{
        float: left;
        margin-right: 10px;
    }
</style>
<div id="right_content">
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        通知管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('index'); ?>" class="this">用户列表</a></li>
        <li><a href="<?php echo url('record'); ?>" >推送记录</a></li>
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
                <a
                        href="<?php echo url('push'); ?>" class="btn btn-success btn-sm table_left" id="push" target="frame_dispose"
                        onclick="push('<?php echo url('push'); ?>','uid[]');">
                    推送<i class="glyphicon glyphicon-send ml5"></i>
                </a>
                <!--<button type="button" class="btn btn-success btn-sm table_left"-->
                        <!--onclick="all_export('<?php echo url('notice'); ?>','uid[]');">-->
                    <!--推送<i class="glyphicon glyphicon-send ml5"></i>-->
                <!--</button>-->

            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="账号/姓名/昵称">
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
                <?php if((empty($enterprise_id) && $allot==2)): ?>
                <th>所属企业</th>
                <?php endif; ?>
                <th>账号</th>
                <th>姓名</th>
                <th>昵称</th>
                <th>头像</th>
                <th>身份证</th>
                <th>性别</th>
                <th>出生年月</th>
                <th>手机</th>
                <th>创建时间</th>
            </tr>
            <?php if((!empty($data))): foreach($data AS $v): ?>
            <tr>
                <td>
                    <input name="uid[]" type="checkbox" value="<?php echo $v['uid']; ?>">
                </td>
                <?php if((empty($enterprise_id) && $allot==2)): ?>
                <td>
                    <?php if((!empty($checkVal['enterprisedata'][$v['enterprise_id']]))): ?>
                    <?php echo $checkVal['enterprisedata'][$v['enterprise_id']]; else: ?>
                    平台
                    <?php endif; ?>
                </td>
                <?php endif; ?>
                <td><?php echo $v['phone']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['nickname']; ?></td>
                <td><img src='<?php echo $v['face']; ?>' style='max-width:100px;'></td>
                <td><?php echo $v['identity']; ?></td>
                <td>
                    <?php if((!empty($checkVal['sexVal'][$v['sex']]))): ?>
                    <?php echo $checkVal['sexVal'][$v['sex']]; endif; ?>
                </td>
                <td><?php echo $v['birth']; ?></td>
                <td><?php echo $v['tel']; ?></td>
                <td><?php echo !empty($v['created_at'])?date('Y-m-d H:i:s', $v['created_at']) : '----'; ?></td>
            </tr>
            <?php endforeach; endif; ?>
        </table>
        <div><?php echo $page; ?></div>
    </div>
</div>
<script type="text/javascript">
    // $(function(){
    //         $("#type").change(function () {
    //             datalist();
    //         });
    //         datalist();
    // })
    //
    // function datalist() {
    //     var type=$("#type").val();
    //     $("#type_id").empty();
    //     $.ajax({
    //         url: '<?php echo url("data_list"); ?>',
    //         type: 'get',
    //         dataType: 'json',
    //         data: {type:type},
    //         success: function(data){
    //             let html="";
    //             data=data.data;
    //
    //             if(data.length>0){
    //                 for(var i=0;i<data.length;i++){
    //                     html +="<option value="+data[i]['id']+">"+data[i]['title']+"</option>";
    //                 }
    //             }
    //             $('#type_id').html(html);
    //
    //         },
    //         error: function(){
    //
    //         }
    //     })
    // }
    function push(url, inputName, data, fn) {
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
        data.type = $('#type option:selected') .val();
        data.type_id = $('#type_id option:selected') .val();
        data.time = $('#time') .val();

        // layer.confirm('确定操作吗？', {
        //     btn: ['推送全部','推送选中', '取消']
        // }, function(){
        //     url=url+"?id=all";
        //     $("#push").attr("href",url);
        //     open_frame('添加', 100, 100, true);
        // },function(){
            url=url+"?id="+id;
            $("#push").attr("href",url);
            open_frame('添加', 100, 100, true);
        // }, function(){
        //
        // });

        // post 请求
        // ajax_post(url, data, fn);
    }

    // function all_export(url, inputName, data, fn) {
    //     if (!is_var(data)) {
    //         data = {};
    //     }
    //     // 组合批量操作的ID
    //     var id = '';
    //     var d  = '';
    //
    //     $.each($('input[name="'+inputName+'"]:checked'), function(index, val) {
    //         id += d + $(this).val();
    //         d = ',';
    //     });
    //     data.id = id;
    //     data.type = $('#type option:selected') .val();
    //     data.type_id = $('#type_id option:selected') .val();
    //     data.time = $('#time') .val();
    //
    //     // post 请求
    //     ajax_post(url, data, fn);
    // }
    // $('#time').datetimepicker({
    //     format: 'yyyy-mm-dd hh:ii:ss',
    //     language:'zh-CN',
    //     minView:0,
    //     autoclose:true,
    //     minuteStep:1
    // });

    // function ajax_post(url, data, fn){
    //     layer.confirm('确定操作吗？', {
    //         btn: ['推送全部','推送选中', '取消']
    //     }, function(){
    //         loding = layer.load(2, {
    //             shade: [0.1,'#fff']
    //         });
    //         data.id = 'all';
    //
    //         $.ajax({
    //             url : url,
    //             type: 'post',
    //             dataType: 'json',
    //             data: data,
    //             success:function(ret){
    //                 layer.close(loding);
    //                 // 是否自定义了回调函数
    //                 if (is_function(fn)) {
    //                     fn(ret);
    //                     return;
    //                 }
    //
    //                 layer.msg(ret.msg,{'time':1000});
    //                 if (ret.status == 1) {
    //                     setTimeout(function(){
    //                         location.reload();
    //                     }, 500);
    //                 }
    //             }
    //         })
    //     },function(){
    //         loding = layer.load(2, {
    //             shade: [0.1,'#fff']
    //         });
    //         $.ajax({
    //             url : url,
    //             type: 'post',
    //             dataType: 'json',
    //             data: data,
    //             success:function(ret){
    //                 layer.close(loding);
    //                 // 是否自定义了回调函数
    //                 if (is_function(fn)) {
    //                     fn(ret);
    //                     return;
    //                 }
    //
    //                 layer.msg(ret.msg,{'time':1000});
    //                 if (ret.status == 1) {
    //                     setTimeout(function(){
    //                         location.reload();
    //                     }, 500);
    //                 }
    //             }
    //         })
    //     }, function(){
    //
    //     });
    // }
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