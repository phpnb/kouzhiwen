<?php
/**
 * [获奖记录模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-09-20 15:25:40
 * @Copyright:
 */
namespace app\admin\finance\model;  
use think\Validate; 
use app\common\model\CommonModel;

class UserGift extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'uid' => 'require|number',
            'contents' => 'require',
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
            'uid.number' => '请填写正确的用户',
            'uid.require' => '请填写用户',
            'gift_id.require' => '请填写获取的礼物id',
            'contents.require' => '请填写获取内容',
            'created_at.require' => '请填写创建时间',
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