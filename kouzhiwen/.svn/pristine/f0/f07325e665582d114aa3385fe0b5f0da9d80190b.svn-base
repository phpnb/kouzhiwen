<?php
/**
 * 【用户通知模型】
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-23
 * Time: 下午3:35
 */
namespace app\common\model;
use think\Validate;

class UserNotice extends CommonModel{

    public function NoticeCollect($where){
        $field=array(
            'n.id',
            'n.title',
            'n.content',
            'n.reading',
            'n.type',
            'n.type_id',
            'n.created_at',
            '(SELECT IF(COUNT(*)>0,1,0) FROM `tpn_user_collect` WHERE TYPE =4 AND type_id=n.id) is_collect ',
        );
        $mode=$this->alias('n')
            ->field($field)
            ->where($where)
            ->order('n.created_at desc');
        return $mode;
    }
}
