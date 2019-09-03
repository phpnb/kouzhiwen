<?php
/**
 * [企业管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-02 20:24:29
 * @Copyright:
 */
namespace app\teacher\info\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Enterprise extends CommonModel{
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
            'logo' => 'require',
            'student' => 'require|number',
            'expire' => 'require',
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
            'name.require' => '请填写企业名称',
            'logo.require' => '请填写企业logo',
            'student.number' => '请填写正确的学员人数上限',
            'student.require' => '请填写学员人数上限',
            'up.require' => '请填写关联企业',
            'expire.require' => '请填写到期时间',
            'status.require' => '请填写状态（1正常 2、停用',
            'created_at.require' => '请填写创建时间',
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