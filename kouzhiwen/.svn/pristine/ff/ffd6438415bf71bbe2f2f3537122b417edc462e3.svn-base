<?php
/**
 * [消费明细模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-29 16:14:56
 * @Copyright:
 */
namespace app\admin\finance\model;  
use think\Validate; 
use app\common\model\CommonModel;

class EnterpriseDetailed extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'price' => ['require', 'regex' => '/^(\d{1,8}|\d{1,8}\.\d{1,2})$/'],
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
            'type.require' => '请填写类型（1、消费 2、充值',
            'title.require' => '请填写标题',
            'price.regex' => '请填写正确的金额',
            'price.require' => '请填写金额',
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