<?php
/**
 * [平台分类模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-27 17:47:28
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Classify extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

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
            'id.require' => '请填写ID',
            'enterprise_id.require' => '请填写公司id  0为机构发布',
            'name.require' => '请填写分类名称',
            'icon.require' => '请填写图标',
            'add_time.require' => '请填写时间',
            'status.require' => '请填写状态',
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