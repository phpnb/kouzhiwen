<?php
/**
 * [问卷调查模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-28 16:17:34
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Questionnaire extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'class_id' => 'require',
            'title' => 'require|max:25',
            'photo' => 'require',
            'describe' => 'require',
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
            'class_id.require' => '请填写班级',
            'title.require' => '请填写标题',
            'title.max' => '标题最大长度为25个字符',
            'photo.require' => '请填写图片',
            'describe.require' => '请填写描述',
            'data.require' => '请填写题目',
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