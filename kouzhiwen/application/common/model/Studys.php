<?php
/**
 * [学习班]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午5:20
 */
namespace app\common\model;
use think\Validate;

class Studys extends CommonModel{
    protected $name = 'class';//学习表


    /**
     * 获取学习班列表
     * @param array $param=[ 查询条件
     * 'classify_id'=>"1",  平台分类id
     * 'enterprise_id'   => "0" 企业id
     * 'time'         => 485152121当前时间撮
     * 'uid'         => 用户uid
     * ]
     */
    public function getDataList($param=[]){
        $param['uid'] = $param['uid']?$param['uid']:0;
        $where = [
            'a.enterprise_id'=>$param['enterprise_id'],
        ];
        if($param['classify_id']){
            //所属平台的分类
            $where['a.classify_id'] = $param['classify_id'];
        }
        if($param['class_type_id']){
            //所属平台的分类
            $where['a.class_type_id'] = $param['class_type_id'];
        }
        if($param['time']>0){
            //结束时间大于当前时间
            $where['a.end'] = ['>',$param['time']];
        }
        if($param['power']){
            $where['a.power'] =0;
        }

        $class=$this->alias('a')
            ->field("a.id,count(`u`.`uid`) as count")
            ->join('class_user u','a.id=u.class_id','left')
            ->group('u.class_id')
            ->where($where)
            ->order('count desc')
            ->find();
        $id=0;
        if(!empty($class)){
            $id=$class['id'];
        }
        $field = [
            "a.id",
            "a.enterprise_id",
            "a.name",
            "a.photo",
            "a.start",
            "a.end",
            "a.price",
            "a.created_at",
            "(select count(*) from tpn_class_user where `class_id`=a.id) apply_num",//已报名人数
            "(select if(count(*)>0,1,0) from tpn_class_user where `class_id`=a.id and `uid`=".$param['uid'].") is_apply",//是否已报名 1是 0否
        ];
        $model = $this->alias('a')->field($field)->where($where)->order("id<>".$id.",a.start desc");
        return $model;
    }


}