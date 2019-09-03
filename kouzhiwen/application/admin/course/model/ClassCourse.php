<?php
/**
 * [课程管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-27 15:11:04
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class ClassCourse extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'type' => 'require',
            'class_id' => 'require',
//            'teacher_id' => 'require',
            'title' => 'require',
            'photo' => 'require',
            'start' => 'require',
            'status' => 'require',
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
            'type.require' => '请选择类型',
//            'class_id.require' => '请填写班级id',
//            'teacher_id.require' => '请填写讲师',
            'title.require' => '请填写课程名称',
            'photo.require' => '请填写图片',
            'reading.require' => '请填写阅读量',
            'start.require' => '请填写开始时间',
            'status.require' => '请填写状态（1、预习 2、直播 3、复习',
            'comment_num.require' => '请填写评论id',
            'updated_at.require' => '请填写更新时间',
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