<?php


namespace app\admin\root\controller;
use app\common\model\Report as model;
use app\common\model\User;
use app\common\model\Questions;

class Report extends Common{

    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =['r.enterprise_id'=>$this->user['enterprise_id'],'r.status'=>1];
        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $model = $model->alias('r')->join('user u','r.uid=u.uid','left')
        ->join('questions q','q.id = r.qid');
        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }
    /**
     * 查看
     */
    public function add(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $id = $this -> param['id'];
        //实例化模型
        $model = new model;
        $where =['r.enterprise_id'=>$this->user['enterprise_id'],'r.status'=>1,'id'=>$id];
        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $model = $model->alias('r')->join('user u','r.uid=u.uid','left')
            ->join('questions q','q.id = r.qid');
        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }


    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        $status = $this->param['status'];
        if($status==2){
            $id = $this -> param['id'];
            $where['rid'] =  $id;
            $data=['status'=>$status];
            $model -> editData($where,$data);
        }else{
            $id = $this -> param['id'];
            $where['rid'] =  $id;
            $model -> delData($where);
        }

        return ajax('成功');
    }


}