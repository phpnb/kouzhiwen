<?php
/**
 * [学员消费记录控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-29 16:26:26
 * @Copyright:
 */
namespace app\admin\finance\controller;
use app\admin\finance\model\UserDetailed as model;
use app\admin\root\controller\Common;

class Userdetailed extends Common{
    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
//    public function _initialize(){
//        parent::_initialize();
//        $this -> checkVal = [
//        ];
//    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $type = $this->param['type'];
        $type=$type?$type:2;
        //实例化模型
        $model = new model;
        $model=$model->name('user_detailed d')->join('user u','u.uid=d.uid','left');
        if($type == 1){
            $where = '';
            if($this->user['enterprise_id']!=0){
                $where = ['u.enterprise_id'=>$this->user['enterprise_id'],'type' => 1];
            }
            if($this->user['enterprise_id'] ==0){
                $where = ['u.enterprise_id'=>$this->user['enterprise_id'],'type' => 1];
            }
            if (!empty($keywords)) {
                $where['d.title'] = ['like', "%{$keywords}%"];
            }
            $field=array('d.*','u.name');
            // 获取数据
            $data  = admin_page($model, ['type'=> 1],'d.created_at desc',$field);

        }else{
//            $where = ['d.type'=>2];
            if($this->user['enterprise_id']!=0){
                $where = ['u.enterprise_id'=>$this->user['enterprise_id'],'type' => 2];
            }
            if($this->user['enterprise_id'] ==0){
                $where = ['u.enterprise_id'=>$this->user['enterprise_id'],'type' => 2];
            }
            if (!empty($keywords)) {
                $where['d.title'] = ['like', "%{$keywords}%"];
            }
            $field=array('d.*','u.name');
            // 获取数据
            $data  = admin_page($model, $where,'d.created_at desc',$field);
        }


        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'type'      => $type,
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }


}