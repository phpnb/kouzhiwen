<?php
/**
 * [教师文章模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午4:32
 */
namespace app\common\model;
use think\Validate;

class TeacherArticle extends CommonModel{

    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'enterprise_id' => 'require|number',
            'class_id' => 'require|number',
            'teacher_id' => 'require|number',
//            'cover_img' => 'require',
            'name' => 'require',
//            'contents' => 'require',
            'add_time' => 'require',
        ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'enterprise_id.require' => '请填写企业名称',
            'enterprise_id.number' => '请填写企业名称',
            'class_id.require' => '请填写班级',
            'class_id.number' => '请填写正确的班级',
            'teacher_id.require' => '请填写教师',
            'teacher_id.number' => '请填写正确的教师',
//            'cover_img.require' => '请上传图片',
            'name.require' => '请填写标题',
//            'contents.require' => '请填写内容',
            'add_time.require' => '请填写添加时间',
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