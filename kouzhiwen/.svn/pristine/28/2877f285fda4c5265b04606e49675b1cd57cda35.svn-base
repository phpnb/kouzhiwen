<?php
/**
 * [平台公开课和扣之问资讯模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class Introduce extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    public function user_Introduce($where,$field="*"){
        return $this->where($where)->field($field)->limit(0,3)->select()->toArray();
    }

}