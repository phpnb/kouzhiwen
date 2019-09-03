<?php
/**
 * [极光推送记录模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-16 14:31:08
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class UserJgpush extends CommonModel{
    public $err;
    public $data;
    public $pk = 'uid';


}