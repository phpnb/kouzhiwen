<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/www/wwwroot/kouzhiwen/public/../application/teacher/course/view/study/up_puser.html";i:1544955761;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/header.html";i:1534993716;s:81:"/www/wwwroot/kouzhiwen/public/../application/teacher/root/view/common/footer.html";i:1534993716;}*/ ?>
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
<style type="text/css">
    .table td p{
        width: 40%;
        position: relative;
        word-wrap: break-word;
        height: auto;
    }
</style>
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <!--<tr>-->
                <!--<th>试题</th>-->
                <!--<th>选项</th>-->
                <!--<th>结果</th>-->
                <!--<th>得分</th>-->
            <!--</tr>-->
            <?php if((!empty($data['data']))): foreach($data['data'] AS $v): ?>
            <tr>
                <th class="msg"><?php echo $v['id']; ?></th>
                <?php if(($v['type']=='adio')): $a=""; $aa=array(); ?>
                    <td>
                        <p>问题：<?php echo $v['title']; ?></p>
                        <p>选项：<br />
                        <?php foreach($v['answer'] AS $d): ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span <?php if(($d['status'])): ?> style="color:#00FF00;" <?php $a=$d['id']; endif; ?>><?php echo $d['id']; ?>、<?php echo $d['title']; ?>  </span><br />

                        <?php endforeach; ?>
                        </p>
                        <p>答案：<?php if((empty($data['result'][$v['id']]) || $data['result'][$v['id']] =='null')): ?><span style="color: red">超时未做答</span> <?php else: ?><?php echo $data['result'][$v['id']]; endif; ?></p>
                        <p>得分：<?php if(($data['result'][$v['id']]==$a)): ?><?php echo $v['score']; else: ?>0<?php endif; ?></p>
                    </td>
                <?php elseif(($v['type']=='checkbox')): ?>
                    <td>
                        <p>问题：<?php echo $v['title']; ?></p>
                        <p>选项：<br />
                            <?php foreach($v['answer'] AS $d): ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span <?php if(($d['status'])): ?> style="color:#00FF00;" <?php $aa[]=$d['id']; endif; ?>><?php echo $d['id']; ?>、<?php echo $d['title']; ?></span><br />

                            <?php endforeach; ?>
                        </p>
                        <p>答案：<?php if((empty($data['result'][$v['id']]) || $data['result'][$v['id']] =='null')): ?>
                            <span style="color: red">超时未做答</span>
                            <?php else: foreach($data['result'][$v['id']] as $d): ?>
                                <?php echo $d; ?> &nbsp;&nbsp;
                            <?php endforeach; endif; ?>
                        </p>
                        <p>得分：<?php if(($data['result'][$v['id']]==$aa)): ?><?php echo $v['score']; else: ?>0<?php endif; ?></p>
                    </td>
                <?php else: ?>
                <td>
                    <p>问题：<?php echo $v['title']; ?></p>
                    <p>答案：
                        <?php if((empty($data['result'][$v['id']]) || $data['result'][$v['id']] =='null')): ?><span style="color: red">超时未做答</span> <?php else: ?><?php echo $data['result'][$v['id']]; endif; ?>
                    </p>
                    <p>满分：<?php echo $v['score']; ?></p>
                    <p><input name="score[]" type="number" max="<?php echo $v['score']; ?>"  min="0" value="0" class="form-control w40" datatype="n" nullmsg="请设置得分"></p>
                </td>
                <!--<td class="form-control w400">-->
                    <!--<?php echo $data['result'][$v['id']]; ?>-->
                <!--</td>-->
                <?php endif; ?>
            </tr>
            <?php endforeach; endif; ?>
            <!--<tr>-->
                <!--<th class="msg">试卷</th>-->
                <!--<td class="form-control w400">-->
                    <!--<?php foreach($data['data'] as $key => $v){ ?>-->
                <!--问：<?php echo $v['title'];?>-->
                <!--<br>-->

                <!--<?php foreach($v['answer'] as $key => $v1){ ?>-->
                <!--选项：<?php if($v1['status'] == false){ ?>-->
                <!--<i><?php echo $v1['id'].'.'.$v1['title']; ?></i>-->
                <!--<?php }else{ ?>-->
                <!--<i style="color:#00FF00;"><?php echo $v1['id'].'.'.$v1['title']; ?></i>-->
                    <!--<?php } } ?>-->
                <!--<br>-->
                <!--&lt;!&ndash;  &ndash;&gt;-->
                <!--学员答案:<?php echo $data['result'][$v['id']]; ?>-->
                <!--<br>-->
                <!--<br>-->
                <!--<br>-->
                <!--<?php } ?>-->
                <!--</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!---->

                <!---->
                <!--<th class="msg">状态</th>-->
                <!--<td colspan="3">-->
                    <!--<select name="status" class="form-control w426" datatype="*">-->
                        <!--<option value="<?php echo $data['status']; ?>"><?php if($data['status'] == 1){echo '及格';}else if($data['status' == 2]){echo '未及格';}else{echo '阅卷中';} ?></option>-->

                        <!--<option value="1">及格</option>-->
                        <!--<option value="2">未及格</option>-->
                        <!--<option value="3">阅卷中</option>-->
                    <!--</select>-->
                <!--</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<th width="150" class="msg">打分</th>-->
                <!--<td colspan="3"><input name="score" type="int" class="form-control w400" datatype="*"></td>-->
            <!--</tr>-->
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <tr>
                <td></td>
                <td colspan="3"><button type="submit" class="btn btn-success">保存</button></td>
            </tr>
        </table>
    </form>
</div>
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