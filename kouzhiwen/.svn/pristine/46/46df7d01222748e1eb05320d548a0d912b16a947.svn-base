<?php
/**
 * [user模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-03 18:00:03
 * @Copyright:
 */
namespace app\teacher\info\model;  
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
            'phone' => ['require', 'regex' => '/^1[0-9]{10}$/'],
            'password' => 'require',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'uid.require' => '请填写ID',
            'enterprise_id.require' => '请填写企业id',
            'phone.regex' => '请填写正确的账号',
            'phone.require' => '请填写账号',
            'password.require' => '请填写密码',
            'name.require' => '请填写姓名',
            'name_hide.require' => '请填写姓名是否隐藏（1显示 2 隐藏',
            'nickname.require' => '请填写昵称',
            'face.require' => '请填写头像',
            'identity.require' => '请填写身份证',
            'sex.require' => '请填写性别',
            'birth.require' => '请填写出生年月',
            'oph.require' => '请填写办公电话',
            'tel.require' => '请填写手机',
            'email.require' => '请填写邮箱',
            'school.require' => '请填写学校',
            'education.require' => '请填写学历',
            'unit_title.require' => '请填写单位职称',
            'company_name.require' => '请填写公司名称',
            'company_introduce.require' => '请填写公司介绍',
            'company_add.require' => '请填写公司地址',
            'company_adddetailed.require' => '请填写公司详细地址',
            'address.require' => '请填写家庭地址',
            'address_detailed.require' => '请填写家庭详细地址',
            'id_photo_pos.require' => '请填写证件照 正面',
            'id_photo_neg.require' => '请填写证件照 反面',
            'balance.require' => '请填写用户余额',
            'logintoken.require' => '请填写用户登录凭证',
            'allot.require' => '请填写是否分配企业（1、未分配 2 已分配',
            'status.require' => '请填写状态 0：禁用，1：启用',
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