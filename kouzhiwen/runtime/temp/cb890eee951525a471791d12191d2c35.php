<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/notice/push.html";i:1540780596;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    #type, #type_id{
        margin-right: 10px;
    }
    /*#type{*/
        /*width:30%;*/
        /*width-max:10%;*/
    /*}*/
    /*#type_id{*/
        /*width:60%;*/
        /*width-max:20%;*/
    /*}*/
</style>
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">标题</th>
                <td><input name="title" id="title"  type="text" class="form-control w400"  datatype="*"></td>
            </tr>
            <tr>
                <th class="msg">描述</th>
                <td><textarea name="describe" id="describe" datatype="*"></textarea></td>
            </tr>
            <tr>
                <th class="msg">关联数据</th>
                <td>
                    <select name="type"  id="type" class="form-control w150 table_left">
                        <?php foreach($checkVal['noticetypeVal'] as $k=>$v): ?>
                        <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="type_id"  id="type_id" class="form-control w150 table_left">
                    </select>
                </td>
            </tr>
            <tr>
                <th class="msg">推送时间</th>
                <td>
                    <input type="text" id="time" name="time" class="date-plugin form-control w200 table_left" value="" placeholder="选择日期" datatype="/^.*?$/" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm table_left"
                            onclick="ajax_post('<?php echo url('notice'); ?>',{'id':'<?php echo $id; ?>'});">
                        推送<i class="glyphicon glyphicon-send ml5"></i>
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>
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
<script>
$(function(){
    $("#type").change(function () {
        datalist();
    });
    datalist();
})

function datalist() {
    var type=$("#type").val();
    $("#type_id").empty();
    $.ajax({
        url: '<?php echo url("data_list"); ?>',
        type: 'get',
        dataType: 'json',
        data: {type:type},
        success: function(data){
            let html="";
            data=data.data;

            if(data.length>0){
                for(var i=0;i<data.length;i++){
                    html +="<option value="+data[i]['id']+">"+data[i]['title']+"</option>";
                }
            }
            $('#type_id').html(html);

        },
        error: function(){

        }
    })
}

$('#time').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    language:'zh-CN',
    minView:0,
    autoclose:true,
    minuteStep:1
});

function ajax_post(url, data, fn){
    data.title = $('#title') .val();
    data.describe = $('#describe') .val();
    data.type = $('#type option:selected') .val();
    data.type_id = $('#type_id option:selected') .val();
    data.time = $('#time') .val();

    layer.confirm('确定操作吗？', {
        btn: ['推送全部','推送选中', '取消']
    }, function(){
        loding = layer.load(2, {
            shade: [0.1,'#fff']
        });
        data.id = 'all';

        $.ajax({
            url : url,
            type: 'post',
            dataType: 'json',
            data: data,
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
    },function(){
        loding = layer.load(2, {
            shade: [0.1,'#fff']
        });
        $.ajax({
            url : url,
            type: 'post',
            dataType: 'json',
            data: data,
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