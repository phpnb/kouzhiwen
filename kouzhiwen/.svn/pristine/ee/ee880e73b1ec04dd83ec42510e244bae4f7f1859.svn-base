<?php
/**
 * [扣之问文章]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-25
 * Time: 下午3:08
 */
namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\model\Banner;


class Introduce extends Api{

    /**
     * 扣之问
     */
    public function banner(){
        $BannerModel = new Banner();
        $data = $BannerModel->dataList(['status'=>1,'type'=>3,'enterprise_id'=>0],$this->user['uid']);
        return ajax("获取成功",1,['data'=>$data?$data:[]]);
    }

    /**
     * 发现banner
     * @return \think\response\Json
     */
    public function FindBanner(){
        $BannerModel = new Banner();
        $where=array('status'=>1);
        if(!empty($this->param['type'])){
            $where['type']=$this->param['type'];
        }
        if(!empty($this->param['classify_id'])){
            $where['classify_id']=$this->param['classify_id'];
        }

        $data = $BannerModel->dataList($where,$this->user['uid']);
        return ajax("获取成功",1,['data'=>$data?$data:[]]);
    }

    /**
     * 首页内容
     * @return \think\response\Json
     */
    public function articleList(){
        $model = db('introduce');
        $where = [
            'type'=>6,
            'status'=>1
        ];
        if(!empty($this->param['type'])){
            $where['type'] = $this->param['type'];
        }
        $data  = api_page($model,$where,"id desc");
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 详情
     */
    public function details(){
        if(!$this->param['id']) return ajax("缺少文章id",2);
        $model = db('introduce');
        $data = $model->where(['id'=>$this->param['id']])->find();
        if(!$data) return ajax('无此文章', 2);
        return ajax('获取成功', 1, $data);
    }



}