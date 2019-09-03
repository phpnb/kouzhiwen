<?php
/**
 * [课程分类模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 15:54:30
 * @Copyright:
 */
namespace app\teacher\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class ClassNotice extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'class_id' => 'require',
            'teacher_id' => 'require',
            'title' => 'require|max:50',
            'photo' => 'require',
            'describe' => 'require|max:100',
            'content' => 'require',
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
            'class_id.require' => '请选择班级',
            'teacher_id.require' => '请选择老师',
            'title.require' => '请填写标题',
            'title.max' => '标题最大为50个字符',
            'photo.require' => '请上传图片',
            'describe.require' => '请填写描述',
            'describe.max' => '描述最大为100个字符',
            'content.require' => '请填写内容',
            'price.regex' => '请填写正确的价格（0 免费',
            'price.require' => '请填写价格（0 免费',
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