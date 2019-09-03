<?php
/**
 * [教师管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 16:38:31
 * @Copyright:
 */
namespace app\admin\info\model;
use think\Validate;
use app\common\model\CommonModel;

class Headmaster extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'username' => 'require',
            'password' => 'require',
            'name' => ['require'],
            'photo' => 'require',
            'phone' => ['require', 'regex' => '/^1[0-9]{10}$/'],
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
            'username.require' => '请填写用户名',
            'password.require' => '请填写密码',
            'name.regex' => '请填写正确的姓名',
            'name.require' => '请填写姓名',
            'photo.require' => '请填写头像',
            'phone.regex' => '请填写正确的手机号',
            'phone.require' => '请填写手机号',
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