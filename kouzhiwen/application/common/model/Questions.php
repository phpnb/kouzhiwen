<?php
/**
 * [ÌáÎÊÄ£¿é]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */

namespace app\common\model;

use think\Validate;
use think\db\Query;

class Questions extends CommonModel
{

    public function collection($id,$uid){
        $where = [
            'id'=>$id,
        ];
        $data =  $this->where($where)->find();
        if(!$data) return false;
        $data['collec']    = $data->userCollec()->where(['type'=>5,'uid'=>$uid,'type_id'=>$data['id']])->find()?true:false;
        return $data;
    }

    public function userCollec(){
        return  $this->hasOne('UserCollect','type_id');
    }

}