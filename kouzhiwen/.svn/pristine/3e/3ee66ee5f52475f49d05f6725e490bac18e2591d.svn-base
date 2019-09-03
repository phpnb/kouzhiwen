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

class Teacher extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'classify_id' => 'require',
//            'teacher_type' => 'require|number',
//            'is_xszd' => 'require|number',
            'username' => 'require',
            'password' => 'require',
            'name' => ['require'],
            'title' => ['require'],
            'photo' => 'require',
            'phone' => ['require', 'regex' => '/^1[0-9]{10}$/'],
            'module' => 'require',
            'brief' => 'require|max:100',
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
            'enterprise_id.require' => '请填写企业名称',
            'classify_id.require' => '请填写平台分类',
            'teacher_type.number' => '请填写正确的教师分类',
            'teacher_type.require' => '请填写教师分类',
            'is_xszd.number' => '请填写正确的学术指导成员',
            'is_xszd.require' => '请填写学术指导成员',
            'username.require' => '请填写用户名',
            'password.require' => '请填写密码',
            'name.regex' => '请填写正确的姓名',
            'name.require' => '请填写姓名',
            'title.regex' => '请填写正确的称呼',
            'title.require' => '请填写称呼',
            'photo.require' => '请填写头像',
            'phone.regex' => '请填写正确的手机号',
            'phone.require' => '请填写手机号',
            'logintime.require' => '请填写登录时间',
            'loginip.require' => '请填写登录IP',
            'group_id.require' => '请填写所属组',
            'module.require' => '请填写所属模块',
            'money.regex' => '请填写正确的金额',
            'consult_num.require' => '请填写咨询数量',
            'brief.require' => '请填写简介',
            'brief.max' => '简介最多不能超过100字符',
            'status.require' => '请填写状态（1启用 2、停用',
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