<?php
/**
 * [教师分类模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-10 15:08:42
 * @Copyright:
 */
namespace app\admin\info\model;  
use think\Validate; 
use app\common\model\CommonModel;

class TeacherType extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'name' => 'require',
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
            'name.require' => '请填写名称',
            'created_at.require' => '请填写创建时间',
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