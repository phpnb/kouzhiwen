<?php
/**
 * [教师模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午4:32
 */
namespace app\common\model;
use think\Validate;

class Teacher extends CommonModel{

    /**
     * 获取教师列表
     * @param array $param=[ 查询条件
     * 'classify_id'=>"1",  平台分类id
     * 'identity'   => "1" 身份（1、教师 2、班主任 3、专家
     * 'enterprise_id'   => "0" 企业id
     * 'is_xszd'   => "1" 是否是学术指导成员 1是 0否
     * ]
     */
    public function getDataList($param=[]){
        $where = [
            'status' => 1,
            'enterprise_id'=>$param['enterprise_id']
        ];
//        if($param['classify_id']){
//            //所属平台的分类
////            $where['classify_id'] = ['like',"%{$param['classify_id']}%"];
//        }
        if($param['identity']){
            //教师身份
            $where['identity']    = ['like',"%{$param['identity']}%"];
        }
        if(!empty($param['is_xszd'])){
            //学术指导成员
            $where['is_xszd']    = $param['is_xszd'];
        }


        $field = [
            "id","name","title","phone","photo","consult_num"
        ];
        $model = $this->field($field)->where($where)->where('find_in_set(:a,classify_id)',['a'=>$param['classify_id']]);
        return $model;
    }

    /**
     * 重组教师数据
     * @param $data
     */
    public function recombineData($data,$num){
        foreach($data as &$item){
            $item['article'] = db('teacher_article')->field("id,name")->where(['teacher_id'=>$item['id'],'status'=>1])->limit(0,$num)->select()->toArray();
            $item['article'] =  $item['article']? $item['article']:[];
        }
        return $data;
    }


}