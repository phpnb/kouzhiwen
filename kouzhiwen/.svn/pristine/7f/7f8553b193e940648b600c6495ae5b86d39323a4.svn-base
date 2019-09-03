<?php
/**
 * [可程表模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午3:46
 */

namespace app\common\model;
use think\Validate;

class Course extends CommonModel{

    /**
     * @param array $param=[
     * type=>类型（1、专业知识课 2、选修课
     * classify_id=>平台分类id
     * 'enterprise_id'   => "0" 企业id
     * ]
     */
    public function getDataList($param=[]){
        $where = [
            'a.status'=>1,
            'a.enterprise_id'=>$param['enterprise_id']
        ];
        if($param['type']){
            //类型（1、专业知识课 2、选修课 3、直播课
            $where['a.type'] = $param['type'];
        }
        if($where['a.type']!=3 && $param['power']){
            $where['a.power'] =0;
        }
        if($param['classify_id']){
            //所属平台分类
            $where['a.classify_id'] = $param['classify_id'];
        }
        if(!empty($param['type_id'])){
            //所属分类id
            $where['a.type_id'] = $param['type_id'];
        }
        $where['a.enterprise_id']=0;
        if($param['enterprise_id']){
            //所属企业id
            $where['a.enterprise_id'] = $param['enterprise_id'];
        }
        $field = [
            "a.id","a.photo","a.title","a.price","a.look_num","a.reading","a.scene","a.start",
            "(select if(count(*)>0,1,0) from `tpn_order` where `type`=2 and `type_id`=a.id and `pay_status`=2) is_buy",//是否购买 1是 0否
        ];
        $order = "weight desc,a.id desc";
        if($where['a.type']==3){
            $field[]='t.name';
//            $where['a.scene']=1;
            $model = $this->alias("a")->join('teacher t','t.id=a.teacher_id','left')->field($field)->where($where)->order($order);
        }else{
            $model = $this->alias("a")->field($field)->where($where)->order($order);
        }
        return $model;
    }


    //获取收藏状态
    public function collection($type,$id,$uid){
        $where = [
            'id'=>$id,
        ];
        $data =  $this->where($where)->find();
        if(!$data) return false;
        $data['collec']    = $data->userCollec()->where(['type'=>$type,'uid'=>$uid,'type_id'=>$data['id']])->find()?true:false;
        return $data;
    }

    public function userCollec(){
        return  $this->hasOne('UserCollect','type_id');
    }

    /**
     * 获取正在直播课程
     * @param $where
     * @param $orderby
     * @param $field
     * @param $total
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function scene($where,$orderby,$field,$total){
        $data=$this->alias('c')
            ->field($field)
            ->join('teacher t','c.teacher_id=t.id','left')
            ->where($where)
            ->order($orderby)
            ->limit("0,$total")
            ->select()
            ->toArray();

        return $data;
    }

}