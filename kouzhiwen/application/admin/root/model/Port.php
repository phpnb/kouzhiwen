<?php
/**
 * [接口列表模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-23 13:48:56
 * @Copyright:
 */
namespace app\admin\root\model;
use app\common\model\CommonModel;
use think\Validate;

class Port extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * 创建参数
     * @param $data
     * @return string
     */
    public function createparam($data){
        // 组合JSON方便存储
        $json = "{";
        $t = '';
        foreach ($data['type'] as $k => $v) {
            $json .= "{$t}\"{$k}\":{\"name\":\"{$data['name'][$k]}\",\"type\":\"{$data['type'][$k]}\",\"must\":\"{$data['must'][$k]}\",\"value\":\"{$data['value'][$k]}\",\"msg\":\"{$data['msg'][$k]}\"}";
            $t = ',';
        }
        $json .= "}";
        return $json;
    }

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [];

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