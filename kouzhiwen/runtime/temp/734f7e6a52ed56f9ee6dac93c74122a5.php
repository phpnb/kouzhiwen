<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/broadcast/index.html";i:1544955746;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/header.html";i:1548252300;s:79:"/www/wwwroot/kouzhiwen/public/../application/admin/root/view/common/footer.html";i:1506306702;}*/ ?>
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
<script type="text/javascript" src="/static/admin/js/jquery.zclip.js"></script>
<div id="right_content">
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        直播管理
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        <li><a href="<?php echo url('',['type'=>1]); ?>" <?php if(($type==1)): ?>class="this"<?php endif; ?>>班级直播</a></li>
        <li><a href="<?php echo url('',['type'=>2]); ?>" <?php if(($type==2)): ?>class="this"<?php endif; ?>>课程直播</a></li>
        <li>
            <a
                    href="<?php echo url('add'); ?>" target="frame_dispose"
                    onclick="open_frame('创建直播', 100, 100, true);">
                创建直播
            </a>
        </li>
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
                    <a href="https://help.aliyun.com/document_detail/45212.html" target="_blank" class="cl-gre">如何直播 &gt;&gt;</a>
            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="<?php echo $keywords; ?>" name="keywords" class="form-control search-in" placeholder="课程名称">
                <input type="hidden" value="<?php echo $type; ?>" name="type" />
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <?php if(($type==1)): ?>
            <tr>
                <th>ID</th>
                <th>班级</th>
                <th>课程名</th>
                <th>图片</th>
                <th>状态</th>
                <th>开始时间</th>
                <th width="100">操作</th>
            </tr>
            <?php else: ?>
            <tr>
                <th>ID</th>
                <th>课程名</th>
                <th>图片</th>
                <th>阅读量</th>
                <th>单价</th>
                <th>学习量</th>
                <th>评论数量</th>
                <th>状态</th>
                <th>开始时间</th>
                <th width="100">操作</th>
            </tr>
            <?php endif; if((!empty($data))): if(($type==1)): foreach($data AS $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['title']; ?></td>
                    <td><img src='<?php echo $v['photo']; ?>' style='max-width:100px;'></td>
                    <td>
                        <?php if(($v['status']==1)): ?>
                        <span class="label label-info f12">预习</span>
                        <?php elseif(($v['status']==2)): ?>
                        <span class="label label-primary f12">直播</span>
                        <?php else: ?>
                        <span class="label label-success f12">复习</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo !empty($v['start'])?date('Y-m-d H:i:s', $v['start']) : '----'; ?></td>

                    <td class="operation">
                        <!--<a href="http://kouzhiwenteacher.zpftech.com/web_live/liveroom.html?id=<?php echo $v['id']; ?>&type=1" target="frame_dispose"-->
                           <!--onclick="open_frame('开播', 100, 100, true)"-->
                           <!--class="glyphicon glyphicon-edit" title="开播"></a>-->
                        <a href="" target="frame_dispose" data-id="<?php echo $v['id']; ?>" data-start="<?php echo $v['start']; ?>" data-push="<?php echo $v['aliyun_push']; ?>" class="glyphicon glyphicon-paperclip" title="复制"></a>

                    </td>
                </tr>
            <?php endforeach; else: foreach($data AS $v): ?>
            <tr>
                <td><?php echo $v['id']; ?></td>
                <td><?php echo $v['title']; ?></td>
                <td><img src='<?php echo $v['photo']; ?>' style='max-width:100px;'></td>
                <td><?php echo $v['reading']; ?></td>
                <td><?php echo $v['price']; ?></td>
                <td><?php echo $v['look_num']; ?></td>
                <td><?php echo $v['comment_num']; ?></td>
                <td>
                    <?php if(($v['scene']==1)): ?>
                    <span class="label label-info f12">正在直播</span>
                    <?php elseif(($v['scene']==0)): ?>
                    <span class="label label-danger f12">待直播</span>
                    <?php else: ?>
                    <span class="label label-success f12">已直播</span>
                    <?php endif; ?>
                </td>
                <td><?php echo !empty($v['start'])?date('Y-m-d H:i:s', $v['start']) : '----'; ?></td>

                <td class="operation">
                    <!--<a href="http://kouzhiwenteacher.zpftech.com/web_live/liveroom.html?id=<?php echo $v['id']; ?>&type=2" target="frame_dispose"-->
                       <!--onclick="open_frame('开播', 100, 100, true)"-->
                       <!--class="glyphicon glyphicon-edit" title="开播"></a>-->
                    <a href="" target="frame_dispose" data-id="<?php echo $v['id']; ?>" data-start="<?php echo $v['start']; ?>" data-push="<?php echo $v['aliyun_push']; ?>" class="glyphicon glyphicon-paperclip" title="复制"></a>

                 </td>
             </tr>
             <?php endforeach; endif; else: endif; ?>
         </table>
         <div><?php echo $page; ?></div>
     </div>
 </div>
<script type="text/javascript">
    $(function(){
        var time=<?php echo $time; ?>;
        var url="<?php echo url('web',['type'=>$type]); ?>";
        var data="";
        $('.glyphicon-paperclip').zclip({        　 //copy_input表示 按钮
            path: '/static/admin/js/ZeroClipboard.swf',
            copy: function(){
                // $.ajax({
                //     url : url,
                //     type: 'post',
                //     dataType: 'json',
                //     data: {id:$(this).data('id')},
                //     success:function(ret){
                //         // 是否自定义了回调函数
                //         data= ret.data;
                //         console.log('data');
                //         console.log(data);
                //     }
                // });
                if($(this).data('start')>time){
                    layer.msg('此直播还未到开始时间', {time:1000});
                    return '';
                }

                return $(this).data('push');  　 //mytext表示 内容
            },
            afterCopy: function(){ //复制成功
                // $("<span id='msg'/>").insertAfter($('#copy_input')).text('复制成功');
            }
        });
    });
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