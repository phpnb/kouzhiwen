<?php


namespace app\admin\info\controller;
use app\admin\root\controller\Common;
use app\admin\info\model\Questions as model;
use app\admin\info\model\User;

class Questions extends Common{
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

        $type=$this->param['type']?$this->param['type']:1;
//        $where['classify'] = $type;
//        if($type==1){
//            $where['classify'] = '1';
//        }elseif ($type==2){
//            $where['classify'] = '2';
//        }
        // 搜索关键词
        $keywords = input('get.keywords');
        //获取企业id
        $enterprise_id=$this->user['enterprise_id'];
        //实例化模型
        $model = new model;
        $model = $model->alias('q')->join('user u','q.u_id=u.uid');

        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $field = array('q.*,u.name');
        if($enterprise_id==0){

            $where["classify"] = $type;
            $data  = admin_page($model,$where,'add_time desc',$field);
        }else{
            //条件
            $where['e_id'] =$this->user['enterprise_id'];
            $where["classify"] = $type;
            $data  = admin_page($model, $where,'add_time desc',$field);
        }


        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }


    /**
     * [edit 查看]
     */
    public function edit(){
        $model = new model;
        // POST提交处理
        $model = $model->alias('q')->join('user u','q.u_id=u.uid');

        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $field = array('q.*,u.name');
        $where = ['id' =>(int)$this -> param['id']];
        $data  = admin_page($model, $where,'add_time desc',$field);
        foreach ($data['data'] as $k=>$v){
            $data['data'][0]['url'] = explode(",",$v['url']);
        }


        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        $msg="删除";
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax($msg.'失败');
        return ajax($msg.'成功');
    }



}