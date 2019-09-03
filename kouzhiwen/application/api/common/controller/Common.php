<?php
/**
 * [公共接口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\model\Regions;
use app\common\model\Protocol;

class Common extends Api{

    /**
     * 获取城市列表
     * @return \think\response\Json
     */
    public function regions(){
        $model = new Regions;
        $province=$model->getAll(['level'=>0]);
        $city=$model->getAll(['level'=>1]);
        $county=$model->getAll(['level'=>2]);

        $data=array();
        $citydata=array();
        foreach ($city as $key=>$val){
            $citydata[$key]=$val;
            $citydata[$key]['name']=$val['title'];
            $countydata=array();
            foreach ($county as $ck=>$v){
                if($val['id']==$v['pid']){
                    $v['name']=$v['title'];
                    $countydata[]=$v;
                }
            }
            $citydata[$key]['child']=$countydata;
        }

        foreach ($province as $y=>$p){
            $data[$y]=$p;
            $data[$y]['name']=$p['title'];
            $citylist=array();
            foreach ($citydata as $c){
                if($p['id']==$c['pid']){
                    $citylist[]=$c;
                }
            }
            $data[$y]['child']=$citylist;
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 查询协议
     * @return \think\response\Json
     */
    public function protocol(){
        $type = input('type');
        $enterprise_id = input('enterprise_id');
        if(empty($type) || !isset($enterprise_id)){
            return ajax('没有必要参数', 2);
        }
        $where=array('type'=>$type,'enterprise_id'=>$enterprise_id);
        $model = new Protocol;
        $data=$model->getOne($where);
        if($type=='phone'){
            $da=json_decode($data['content'],true);
            $data=array_merge($data,$da);
        }
        return ajax('查询成功', 1,$data);
    }
}