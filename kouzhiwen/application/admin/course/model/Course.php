<?php
/**
 * [视频管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 15:33:43
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Course extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
//            'type_id' => 'require|number',
//            'classify_id' => 'require|number',
            'teacher_id' => 'require|number',
            'title' => 'require',
            'photo' => 'require',
            'start' => 'require',
//            'url'  => 'require',
            'type' => 'require|number',
            'price' => ['require', 'regex' => '/^(\d{1,8}|\d{1,8}\.\d{1,2})$/'],
            'weight' => 'require|number',
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
            'type_id.number' => '请填写正确的分类',
//            'type_id.require' => '请填写分类',
            'classify_id.number' => '请填写正确的平台分类',
            'classify_id.require' => '请填写平台分类',
            'teacher_id.number' => '请填写正确的讲师',
            'teacher_id.require' => '请填写讲师',
//            'title.number' => '请填写正确的课程名称',
            'title.require' => '请填写课程名称',
            'photo.require' => '请填写图片',
//            'url.require' => '请填写视频',
            'type.number' => '请填写正确的类型（1、专业知识课 2、选修课 3、直播课',
            'type.require' => '请填写类型（1、专业知识课 2、选修课 3、直播课',
            'power.require' => '请选择权限',
            'reading.require' => '请填写阅读量',
            'describe.require' => '请填写描述',
            'price.regex' => '请填写正确的单价（0为免费',
            'price.require' => '请填写单价（0为免费',
            'weight.number' => '请填写正确的权重（越大越靠前',
            'weight.require' => '请填写权重（越大越靠前',
            'look_num.require' => '请填写学习量',
            'comment_num.require' => '请填写评论数量',
            'created_at.require' => '请填写创建时间',
            'updated_at.require' => '请填写更新时间',
            'status.require' => '请填写状态 1正常',
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