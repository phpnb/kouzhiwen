<?php
/**
 * 【用户收藏模型】
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-23
 * Time: 下午3:35
 */
namespace app\common\model;
use think\Validate;

class UserCollect extends CommonModel{

    /**
     * @param $uid
     * @param $type 类型（1、专业课2、选修课 3、文章 4、消息 5、提问
     */
    public function getUserData($uid,$type){
        $where = [
            'a.uid'=>$uid,
            'a.type'=>$type
        ];
        $model = $this;
        if($type==1){
            $where['b.type'] = 1;
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.title',
                'b.photo',
                'b.url',
                'b.price',
                'b.look_num',
                'b.reading'
            ];
            $model = $this->alias('a')->field($field)->join("course b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==2){
            $where['b.type'] = 2;
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.title',
                'b.photo',
                'b.url',
                'b.price',
                'b.look_num',
                'b.reading'
            ];
            $model = $this->alias('a')->field($field)->join("course b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==3){
            $where['b.status'] = 1;
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.name',
                'b.cover_img',
                'b.author',
                'b.pv',
            ];
            $model = $this->alias('a')->field($field)->join("information b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==4){
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.title',
                'b.content',
                'b.created_at as notice_time',//通知时间
            ];
            $model = $this->alias('a')->field($field)->join("user_notice b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==5){
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.url',
                'b.type',
                'b.money',
                'b.contents',
                'b.add_time as notice_time',//通知时间
            ];
            $model = $this->alias('a')->field($field)->join("questions b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==6){
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.name',
                'b.photo',
                'b.start',
                'b.end',
                "(select count(*) from tpn_class_user where `class_id`=b.id) apply_num",//已报名人数
                "(select if(count(*)>0,1,0) from tpn_class_user where `class_id`=b.id and `uid`=".$uid.") is_apply",//是否已报名 1是 0否
            ];
            $model = $this->alias('a')->field($field)->join("class b","b.id=a.type_id")->where($where)->order("a.id desc");
        }elseif($type==7){
            $field = [
                'a.id',
                'a.type_id',
                'a.created_at',
                'b.title',
                'b.photo',
                'b.reading',
            ];
            $model = $this->alias('a')->field($field)->join("class_course b","b.id=a.type_id")->where($where)->order("a.id desc");
        }


        return $model;
    }
}
