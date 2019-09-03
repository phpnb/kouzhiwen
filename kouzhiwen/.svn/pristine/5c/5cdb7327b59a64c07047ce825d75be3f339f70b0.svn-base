<?php
/**
 *  [公司资讯和平台文章评论模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-17
 * Time: 下午4:19
 */

namespace app\common\model;
use think\Validate;

class InformationComment extends CommonModel{

    public function addDataOne($one=[]){
        $one['add_time'] = time();
        $id = $this->insert($one);
        if(!$id) return false;
        //增加文章评论量
        $Information = new Information();
        $rs = $Information->where(['id'=>$one['information_id']])->setInc('comment_num');
        return $rs;
    }
    /**
     * @param $information_id 文章id
     * @param $uid 查看文章用户uid
     */
    public function getDataList($information_id,$uid){
        $where = [
            'a.status'=>1,
            'a.information_id'=>$information_id
        ];
        $field = [
            'a.*',
            'u.nickname',
            'u.face',
            "(select if(count(*)>0,1,0) from `tpn_information_comment_like` where `comment_id`=a.id and `uid`='{$uid}') is_like"//是否点赞
        ];
        $model =  $this->alias('a')->field($field)
                    ->join("user u","u.uid=a.uid")
                    ->where($where);
        return $model;
    }
}