<?php
/**
 * [提现管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-30 16:36:53
 * @Copyright:
 */
namespace app\admin\finance\model;  
use think\Validate; 
use app\common\model\CommonModel;

class TeacherPay extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'account' => ['require', 'regex' => '/^(\d{1,8}|\d{1,8}\.\d{1,2})$/'],
            'brokerage' => ['require', 'regex' => '/^(\d{1,8}|\d{1,8}\.\d{1,2})$/'],
            'account_num' => 'require',
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
            'teacher_id.require' => '请填写教师id',
            'pay_type.require' => '请填写提现方式（1、微信 2、支付宝',
            'account.regex' => '请填写正确的提现金额',
            'account.require' => '请填写提现金额',
            'brokerage.regex' => '请填写正确的手续费',
            'brokerage.require' => '请填写手续费',
            'status.require' => '请填写状态（1、未处理 2、已处理',
            'created_at.require' => '请填写创建时间',
            'updated_at.require' => '请填写更新时间',
            'account_num.require' => '请填写打款账号',
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