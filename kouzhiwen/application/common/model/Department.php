<?php


namespace app\common\model;

use think\Validate;
use app\common\model\CommonModel;

class Department extends CommonModel
{
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
            'enterprise_id.require' => '请填写公司id  0为机构发布',
            'department.require' => '请填写分类名称',
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