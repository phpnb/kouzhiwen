<?php
/**
 * [班级通知模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:32:03
 * @Copyright:
 */
namespace app\admin\course\model;  
use think\Validate; 
use app\common\model\CommonModel;

class ClassNotice extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

}