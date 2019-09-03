<?php
/**
 * [ddddd模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-16 14:31:08
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class User extends CommonModel{
    public $err;
    public $data;
    public $pk = 'uid';

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
            'uid.require' => '请填写主键',
            'phone.require' => '请填写账号',
            'password.require' => '请填写密码',
            'nickname.require' => '请填写昵称',
            'email.require' => '请填写邮箱',
            'face.require' => '请填写头像',
            'add_time.require' => '请填写注册时间',
            'logintoken.require' => '请填写用户登录凭证',
            'wechat_openid.require' => '请填写微信openid',
            'login_qq.require' => '请填写QQ登录token',
            'login_wechat.require' => '请填写微信登录',
            'login_sina.require' => '请填写新浪登录',
            'status.require' => '请填写状态 0：禁用，1：启用',
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