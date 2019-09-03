<?php
/**
 * [关键字管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-10-15 15:12:46
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Keyword extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'title' => 'require',
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
            'title.require' => '请填写关键字',
            'replace.require' => '请填写替换值',
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