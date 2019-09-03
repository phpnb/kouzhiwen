<?php
/**
 * [学习班管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:32:03
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Study extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';
    public $name='class';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
//            'class_type_id' => 'require',
//            'classify_id' => 'require',
            'name' => 'require',
            'photo' => 'require',
            'number' => 'require|number',
            'start' => 'require',
            'end' => 'require',
            'price' => ['require', 'regex' => '/^(\d{1,8}|\d{1,8}\.\d{1,2})$/'],
            'teacher_id' => 'require',
            'describe' => 'require',
            'type' => 'require',
            'power' => 'require',
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
//            'class_type_id.require' => '请填写班级类别',
//            'classify_id.require' => '请填写平台分类id',
            'name.require' => '请填写班级名称',
            'photo.require' => '请填写图片',
            'number.number' => '请填写正确的限定人数',
            'number.require' => '请填写限定人数',
            'start.require' => '请填写开始时间',
            'end.require' => '请填写结束时间',
            'price.regex' => '请填写正确的价格（0 免费',
            'price.require' => '请填写价格（0 免费',
            'teacher_id.require' => '请填写班主任',
            'describe.require' => '请填写描述',
            'type.require' => '请填写类别（1线上 2线下',
            'created_at.require' => '请填写创建时间',
            'updated_at.require' => '请填写更新时间',
            'type.require' => '请选择类别',
            'power.require' => '请选择权限',
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