<?php
/**
 * [发送短信模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class Code extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * 保存短信验证码
     * @param $data
     * @return int
     */
    public function saveCode($data){
        $data['time'] = time();
        $sql = sql_keyupdate_one($data, 'tpn_code');
        return $this -> execute($sql);
    }

    /**
     * 判断短信验证码是否正确
     * @param $data
     * @return bool
     */
    public function checkCode($data){
        // 判断短信是否存在
        $old = $this -> getOne(['phone'=>$data['phone'],'code'=>$data['code']]);
        if (empty($old)) {
            $this -> err = '验证码错误'; return false;
        }
        if (($old['time'] + 60 * 3) < time()) {
            $this -> err = '验证码已过期'; return false;
        }
        return true;
    }

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
           'phone' => '/^1[0-9]{10}$/',
           'code' => 'require|number|length:4-6',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'id' => '请填写正确的',
            'phone' => '请填写正确的手机号',
            'code' => '请填写正确的验证码',
            'time' => '请填写正确的时间',
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