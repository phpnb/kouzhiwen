<?php
/**
 * [评论管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:08:34
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Comment extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'id.require' => '请填写ID',
            'enterprise_id.require' => '请填写企业id',
            'type.require' => '请填写评论位置 1专业知识 2班级课 3、班级热点',
            'type_id.require' => '请填写关联id [专业知识id,教师id,班级id]',
            'is_reply.require' => '请填写是否是回复 1是 0不是',
            'uid.require' => '请填写发表评论用户uid',
            'pid.require' => '请填写父级id',
            'be_uid.require' => '请填写被评论用户uid',
            'contents.require' => '请填写评论内容',
            'add_time.require' => '请填写评论时间',
            'like_num.require' => '请填写点赞数量',
            'comment_num.require' => '请填写评论数量',
            'status.require' => '请填写状态 1有效 ',
        ];

        // 创建验证
        if (!empty($rule) && !empty($message)) {
            // 创建验证规则
            $validate = new Validate($rule, $message);
            // 执行验证
            if (!$validate -> check($data)) {
                // 保存错误信息
                $this -> err = $validate -> getError();
                return false;
            }
        }

        // 保存验证过的数据
        $this -> data = $data;
        return true;
    }
}