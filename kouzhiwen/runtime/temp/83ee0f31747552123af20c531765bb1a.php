<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:78:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/protocol/add.html";i:1533198106;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:84:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/webuploader.html";i:1506306702;s:80:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/ueditor.html";i:1506306702;s:83:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/dateplugin.html";i:1506306702;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            <tr>
                <th width="150" class="msg">类型</th>
                <td>
                    <?php foreach($checkVal['typeVal'] as $v=>$k): ?>
                    <label class="checkbox-inline">
                        <input type="radio" name="type" checked value="<?php echo $v; ?>">
                        &nbsp;&nbsp;<?php echo $k; ?>
                    </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th width="150" class="msg">标题</th>
                <td><input name="title" type="text" class="form-control w400" datatype="*"></td>
            </tr>
            <tr>
                <th width="150" class="msg">内容</th>
                <td>
                    <textarea id="editorEditor" name="content"  style="width:600px;height:300px;" datatype="*"  nullmsg="请填写内容！" ></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">保存</button></td>
            </tr>
        </table>
    </form>
</div>
<!-- Baidu WebUpload -->
<link rel="stylesheet" type="text/css" href="/static/common/webuploader/webuploader.css">
<script type="text/javascript" src="/static/common/webuploader/webuploader.js"></script>
<script type="text/javascript" src="/static/common/upload.js?b=1"></script>
<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="/static/common/ueditor/ueditor.config.js?a=1"></script>
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
<script>
$(function(){
    UE.getEditor('editorEditor', {
        autoHeight: false,
        /* toolbars:[[
             'undo', //撤销
             'redo', //重做
             'bold', //加粗
             'indent', //首行缩进
             'italic', //斜体
             'underline', //下划线
             'strikethrough', //删除线
             'subscript', //下标
             'fontborder', //字符边框
             'superscript', //上标
             'formatmatch', //格式刷
             'pasteplain', //纯文本粘贴模式
             'selectall', //全选
             'preview', //预览
             'horizontal', //分隔线
             'removeformat', //清除格式
             'time', //时间
             'date', //日期
             'inserttitle', //插入标题
             'cleardoc', //清空文档
             'simpleupload', //单图上传
             'fontfamily', //字体
             'fontsize', //字号
             'paragraph', //段落格式
             'link', //超链接
             'emotion', //表情
             'spechars', //特殊字符
             'searchreplace', //查询替换
             'justifyleft', //居左对齐
             'justifyright', //居右对齐
             'justifycenter', //居中对齐
             'justifyjustify', //两端对齐
             'forecolor', //字体颜色
             'backcolor', //背景色
             'insertorderedlist', //有序列表
             'insertunorderedlist', //无序列表
             'fullscreen', //全屏
             'directionalityltr', //从左向右输入
             'directionalityrtl', //从右向左输入
             'rowspacingtop', //段前距
             'rowspacingbottom', //段后距
             'imagenone', //默认
             'imageleft', //左浮动
             'imageright', //右浮动
             'imagecenter', //居中
             'lineheight', //行间距
             'edittip ', //编辑提示
             'customstyle', //自定义标题
             'autotypeset', //自动排版
             'drafts' // 从草稿箱加载
         ]]*/
    });
})
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