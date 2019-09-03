<?php
/**
 * [评论模型表]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-20
 * Time: 上午10:15
 */

namespace app\common\model;
use think\Validate;

class Comment extends CommonModel{

    /**
     * 获取直接评论
     * @param array $param=[
     * 'type_id'=>0,//关联id
     * 'type'   =>1,评论类型 1专业知识 2班级课
     * ]
     * @param $uid 用户uid
     */
    public function getDataList($param=[],$uid){
        $where = [
            'a.pid' =>    0,
            'a.status' =>    1,
            'a.type'   =>    $param['type'],
            'a.type_id'=>    $param['type_id']
        ];
        $field = [
            'a.id',
            'a.type',
            'a.type_id',
            'a.contents',
            'a.add_time',
            'a.like_num',
            'a.comment_num',
            'a.is_accept',
            'u.nickname',
            'u.face',
            'u.uid',
            'u.company_name',
            'u.unit_title',
            'u.name',
            "(select if(count(*)>0,1,0) from `tpn_comment_like` where `comment_id`=a.id and `uid`='{$uid}') is_like"//是否点赞

        ];
        $model = $this->alias('a')->field($field)
                    ->join("user u","u.uid=a.uid")->where($where)->order("is_accept desc");
        return $model;
    }

    /**
     * 添加一条主评论
     * @param array $one
     * @return int
     */
    public function addDataOne($one=[]){
        $one['add_time'] = time();
        $id = $this->insertGetId($one);
        if(!$id) return false;
        //增加评论数量
        if($one['type']==1){
            //1专业知识
            $model = new Course();
            $rs    = $model->where(['id'=>$one['type_id']])->setInc('comment_num');
        }elseif($one['type']==2){
            //2班级课
            $model = new ClassCourse();
            $rs    = $model->where(['id'=>$one['type_id']])->setInc('comment_num');
        }
        return $id;
    }

    /**
     * @param $id
     * @param $uid
     */
    public function getDetails($id,$uid){
        $where = [
            'a.id'=>$id
        ];
        $field = [
            'a.id',
            'a.contents',
            'a.add_time',
            'a.like_num',
            'a.comment_num',
            'u.nickname',
            'u.face',
            "(select if(count(*)>0,1,0) from `tpn_comment_like` where `comment_id`=a.id and `uid`='{$uid}') is_like"//是否点赞
        ];
        $data = $this->alias('a')->field($field)->join("user u","u.uid=a.uid")
                     ->where($where)->order("id desc")->find()->toArray();
                $data['contents'] = base64_decode($data['contents']);
        if(!$data) return $data;

        //获取评论下的子评论
        $data['cmment'] = $this->getPidData($id);
        return $data;
    }

    /**
     * @param $pid 上级评论id
     */
    public function getPidData($pid){
        $where = [
            'a.pid'=>$pid
        ];
        $field = [
            'a.id',
            'a.is_reply',
            'a.contents',
            'a.add_time',
            'u.nickname as uid_name',
            'IFNULL(uu.nickname,"")'  => "be_uid_name"
        ];
        $data = $this->alias('a')->field($field)
                ->join("user u","u.uid=a.uid")
                ->join("user uu","uu.uid=a.be_uid","left")
                ->where($where)->select()->toArray();
                foreach ($data as $k=>$v){
                    $data[$k]['contents'] = base64_decode($v['contents']);
                }
        return $data;
    }

}