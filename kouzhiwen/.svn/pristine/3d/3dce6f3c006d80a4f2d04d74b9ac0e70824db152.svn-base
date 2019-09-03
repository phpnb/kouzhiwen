<?php
/**
 * [平台用户分类模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class ClassifyUser extends CommonModel{
    public $err;
    public $data;

    public function UserType($field,$where,$order){
        $data=$this->alias('u')
            ->field($field)
            ->join('classify c','c.id=u.classify_id')
            ->where($where)
            ->order($order)
            ->select()
            ->toArray();
        return $data;
    }

}