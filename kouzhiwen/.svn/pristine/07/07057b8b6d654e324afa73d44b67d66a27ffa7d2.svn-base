<?php
/**
 * [企业管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-02 20:24:29
 * @Copyright:
 */
namespace app\admin\info\model;  
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
            'one_name' => 'require',
            'one_img' => 'require',
            'two_name' => 'require',
            'two_img' => 'require',
            'three_name' => 'require',
            'three_img' => 'require',
            'four_name' => 'require',
            'four_img' => 'require',
            'admin_name' => 'require',
            'admin_phone' => ['require', 'regex' => '/^1[0-9]{10}$/'],
            'admin_email' => 'email',
            'address' => 'require',
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
            'one_name.require' => '请填写学习班名称',
            'one_img.require' => '请上传学习班图片',
            'two_name.require' => '请填写专业知识课名称',
            'two_img.require' => '请上传专业知识课图片',
            'three_name.require' => '请填写选修课程名称',
            'three_img.require' => '请上传选修课程图片',
            'four_name.require' => '请填写通讯录名称',
            'four_img.require' => '请上传通讯录图片',
            'admin_name.require' => '请填写管理员姓名',
            'admin_phone.require' => '请填写管理员电话',
            'admin_phone.regex' => '请填写正确的管理员电话',
            'admin_email.email' => '请填写正确的管理员邮箱',
            'address.require' => '请填写企业地址',
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