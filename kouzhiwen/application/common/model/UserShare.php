<?php
/**
 * [用户分享记录模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-24
 * Time: 下午3:50
 */


namespace app\common\model;
use think\Validate;

class UserShare extends CommonModel{

    /**
     * 用户分享记录
     * @param array $param
     * @param $uid
     * @return mixed
     */
    public function getDataList($param=[],$uid){
        $where = [
            'uid'=>$uid,
            'type'=>['in',[1,2,3,4]]
        ];
        if($param['year']){
            $year = $param['year']."-01-01";
            $start_time = strtotime($year);
            $end_time   = strtotime("+1 year",$start_time);
            $where['created_at'] = [['>',$start_time],['<',$end_time],'and'];
        }
        $model = $this->where($where)->order("id desc");

        return $model;
    }

    /**
     * 重组
     * @param $data
     */
    public function regroupData($data){
        foreach($data as &$item){
            if($item['type']==1){
                $one = db('class_notice')->where(['id'=>$item['type_id']])->find();
                $item['photo']       = $one['photo'];
                $item['title']       = $one['title'];
                $item['add_time']    = $one['created_at'];//发布时间
                $item['comment_num'] = 0;
            }elseif($item['type']==2){
                $one = db('teacher_article')->where(['id'=>$item['type_id']])->find();
                $item['photo']       = $one['cover_img'];
                $item['title']       = $one['name'];
                $item['add_time']    = $one['add_time'];//发布时间
                $item['comment_num'] = $one['comment_num'];
            }elseif($item['type']==3){
                $one = db('teacher_article')->where(['id'=>$item['type_id']])->find();
                $item['photo']       = $one['cover_img'];
                $item['title']       = $one['name'];
                $item['add_time']    = $one['add_time'];//发布时间
                $item['comment_num'] = $one['comment_num'];
            }elseif($item['type']==4){
                $one = db('information')->where(['id'=>$item['type_id']])->find();
                $item['photo']       = $one['cover_img'];
                $item['title']       = $one['name'];
                $item['add_time']    = $one['add_time'];//发布时间
                $item['comment_num'] = $one['comment_num'];
            }
        }
        return $data;
    }
}