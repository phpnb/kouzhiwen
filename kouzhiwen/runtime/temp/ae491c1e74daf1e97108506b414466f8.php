<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/access_group/edit.html";i:1532657736;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<style>
    #right_content table tr td,#right_content table tr th{
        border: solid #f1f1f1 1px;
    }
    #right_content form table th{
        text-align: left; padding-left:30px;
    }
</style>
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <th width="180" class="msg" style="text-align: center;">角色名称</th>
                <td><input type="text" name="name" value="<?php echo $oldData['name']; ?>" class="form-control w300 fl" datatype="*"></td>
            </tr>
        </table>

        <?php foreach($menu AS $topk => $vall): ?>
        <table class="table">
            <h2 class="tc fb" style="color: #ff003a; font-size: 16px; background: #f1f4f7; height: 50px; line-height: 50px;">
                <?php echo $topk; ?>
            </h2>
            <?php foreach($vall AS $k => $v): if(!empty($v['child']) || !empty($v['method_menu'])): ?>
                    <tr class="main_check_<?php echo $k; ?>">
                        <th colspan="20">
                            <label class="checkbox-inline" check-type="0">
                                <input onclick="check_all2('check_<?php echo $k; ?>', $(this))" check-k="<?php echo $k; ?>" is-main="1" name="" type="checkbox" value="option2"> <?php echo $v['name']; ?>
                            </label>
                        </th>
                    </tr>
                    
                    <?php foreach($v['child'] AS $key => $val): ?>
                        <tr class="check_<?php echo $k; ?> all_check">
                            <th width="150">
                                <label style="padding-left: 50px;" class="checkbox-inline all_check_type all_check_type<?php echo $k; ?>" check-type="0">
                                    <input name="" onclick="check_all2('son_check_<?php echo $val['id']; ?>', $(this))" type="checkbox" value="option2"> <?php echo $val['name']; ?>
                                </label>
                            </th>
                            <td class="son_check_<?php echo $val['id']; ?> son_check">
                                <div class="clearfix mt5">
                                    <?php foreach($val['method'] AS $value): ?>
                                        <label class="checkbox-inline">
                                            <?php if(array_key_exists($val['module'] . '/' . $val['controller'], $oldData['access']) AND in_array($value['method'], $oldData['access'][$val['module'] . '/' . $val['controller']])): ?>
                                                <input type="checkbox" checked="checked" name="<?php echo $val['module']; ?>/<?php echo $val['controller']; ?>[]" value="<?php echo $value['method']; ?>"> <?php echo $value['name']; else: ?>
                                                <input type="checkbox" name="<?php echo $val['module']; ?>/<?php echo $val['controller']; ?>[]" value="<?php echo $value['method']; ?>"> <?php echo $value['name']; endif; ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; if(!empty($v['method_menu'])): ?>
                        <tr class="check_<?php echo $k; ?> all_check">
                            <th width="200">
                                <label style="padding-left: 50px; margin-top: -2px;" class="checkbox-inline all_check_type all_check_type<?php echo $k; ?>"  check-type="0">
                                    <input onclick="check_all2('son_check_methodmenu<?php echo $key; ?>', $(this))" name="" type="checkbox" value="option2"> 方法菜单
                                </label>
                            </th>
                            <td class="son_check_methodmenu<?php echo $key; ?> son_check">
                                <?php foreach($v['method_menu'] AS $key => $val): ?>
                                    <label class="checkbox-inline">
                                    <?php if(array_key_exists($val['module'] . '/' . $val['controller'], $oldData['access']) AND in_array($val['address'], $oldData['access'][$val['module'] . '/' . $val['controller']])): ?>
                                        <input type="checkbox" checked="checked" name="<?php echo $val['module']; ?>/<?php echo $val['controller']; ?>[]" value="<?php echo $val['address']; ?>"> <?php echo $val['name']; else: ?>
                                        <input type="checkbox" name="<?php echo $val['module']; ?>/<?php echo $val['controller']; ?>[]" value="<?php echo $val['address']; ?>"> <?php echo $val['name']; endif; ?>
                                    </label>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; endif; endforeach; ?>
        </table>
        <?php endforeach; ?>

        <input name="id" type="hidden" value="<?php echo $oldData['id']; ?>">
        <button type="submit" class="btn btn-success ml100 mb20">保 存</button>
    </form>
</div>
   
<script>
$(function(){
    // 载入时 自动选中子集
    $.each($('.son_check'), function(index, val) {
        // 计算对应的选中数量
        var _clen = 0;
        var _input = $(this).find('input');
        $.each(_input, function(i, v) {
            if ($(this).attr('checked') == 'checked') {
                _clen ++;
            }
        });

        var _class = $(this).attr('class').split(' ');
        // 判断是否为全选中
        if (_clen == _input.length) {
            $('.'+_class[0]).prev('th').find('label input').attr({'check-type':'1'}).prop({'checked':true}).attr({'checked':true});
        } else {
            $('.'+_class[0]).prev('th').find('label input').attr({'check-type':'0'}).prop({'checked':false}).attr({'checked':false});
        }
    });

    // 载入时 自动选中父级
    $.each($('.all_check'), function(index, val) {
        var _class = $(this).attr('class').split(' ');
        var _input = $('.'+_class).find('th input');
        var _clen = 0;
        $.each(_input, function(i, v) {
             if ($(this).attr('checked') == 'checked') {
                _clen ++;
            }
        });

        // 获取父class
        var _main_class = $('.'+_class[0]+':eq(0)').prev('tr').attr('class');
        // 判断是否为全选中
        if (_clen == _input.length) {
            $('.'+_main_class).find('label input').attr({'check-type':'1'}).prop({'checked':true}).attr({'checked':true});
        } else {
            $('.'+_main_class).find('label input').attr({'check-type':'0'}).prop({'checked':false}).attr({'checked':false});
        }
    });

    // 最底层点击
    $('.son_check input').click(function(){
        // 判断该集合有没有未被选中的
        var input_length = $(this).parents('.son_check').find('input');
        var input_check = $(this).parents('.son_check').find('input:checked').length;

        // 判断子集
        if (input_length.length == input_check) {
            $(this).parents('.all_check').find('th input').attr({'check-type':'1'}).prop({'checked':true}).attr({'checked':true});
        } else {
            $(this).parents('.all_check').find('th input').attr({'check-type':'0'}).prop({'checked':false}).attr({'checked':false});
        }

        // 获取元素class
        var _class = $(this).parents('tr').attr('class').split(' ');
        var main_input = $('.'+_class[0]).find('.all_check_type input');
        // 判断父级
        var main_check = 0;
        $.each(main_input, function(index, val) {
            if ($(this).attr('checked') == 'checked') {
                main_check ++;
            }
        });

        var _main_class = $('.'+_class[0]).prev('tr').attr('class');
        if (main_input.length == main_check) {
            $('.'+_main_class).find('th input').attr({'check-type':'1'}).prop({'checked':true}).attr({'checked':true});
        } else {
            $('.'+_main_class).find('th input').attr({'check-type':'0'}).prop({'checked':false}).attr({'checked':false});
        }
    })

    // 二级点击
    $('.all_check_type input').click(function(){
        // 二级选择器
        var to_class = $(this).parents('tr').attr('class').split(' ');
        var to_input = $('.'+to_class[0]).find('th input');
        var to_len = $('.'+to_class[0]).find('th input:checked').length;

        // 主选择器
        var main_class = $('.'+to_class[0]).prev('tr').attr('class');
        if (to_input.length == to_len) {
            $('.'+main_class).find('th input').attr({'check-type':'1'}).prop({'checked':true}).attr({'checked':true});
        } else {
            $('.'+main_class).find('th input').attr({'check-type':'0'}).prop({'checked':false}).attr({'checked':false});
        }
    })
})

/**
 * [check_all 点击全选]
 */
function check_all2(id, obj){
    var _type = obj.attr('check-type');
    if (_type == 0) {
        $('.'+id).find('input').prop({'checked':true}).attr({'checked':true});
        obj.attr({'check-type':'1'});
        if (obj.attr('is-main') == 1) {
            var _ck = obj.attr('check-k');
            $('.all_check_type'+_ck+' input').attr({'check-type':'1'});
        }
        
    } else {
        $('.'+id).find('input').prop({'checked':false}).attr({'checked':false});
        obj.attr({'check-type':'0'});
        if (obj.attr('is-main') == 1) {
            var _ck = obj.attr('check-k');
            $('.all_check_type'+_ck+' input').attr({'check-type':'0'});
        }
    }
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