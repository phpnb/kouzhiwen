<?php
/**
 * [学习班成员模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:32:03
 * @Copyright:
 */
namespace app\teacher\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class ClassUser extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

}