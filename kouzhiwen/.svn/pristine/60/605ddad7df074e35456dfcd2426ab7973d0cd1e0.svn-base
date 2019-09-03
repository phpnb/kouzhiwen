<?php
/**
 * [考试系统模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-02 16:59:27
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Paper extends CommonModel{
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
            'title' => 'require|max:25',
            'photo' => 'require',
            'number' => 'require|number',
            'time' => 'require|number',
            'full' => 'require|number',
            'pass' => 'require|number',
            'start_time' => 'require',
            'end_time' => 'require',
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
            'type.require' => '请填写类型',
            'class_id.require' => '请填写班级',
            'title.require' => '请填写标题',
            'title.max' => '标题最大长度为25个字符',
            'photo.require' => '请填写图片',
            'number.number' => '请填写正确的题的数量',
            'number.require' => '请填写题的数量',
            'time.number' => '请填写正确的考试时间（分钟',
            'time.require' => '请填写考试时间（分钟',
            'full.number' => '请填写正确的满分',
            'full.require' => '请填写满分',
            'pass.number' => '请填写正确的及格',
            'pass.require' => '请填写及格',
            'data.require' => '请填写题目',
            'start_time.require' => '请填写开始时间',
            'end_time.require' => '请填写结束时间',
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

    public function study(){
        return $this->morphTo(['type','class_id'],[
            1=>'app\admin\course\model\Study',
            2=>'app\admin\course\model\Course',
        ]);
    }
}