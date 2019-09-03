<?php
/**
 * [Banner管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-27 16:46:42
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\common\model\Banner as model;
use app\admin\root\model\Classify;
use app\admin\course\model\Study;
use app\admin\course\model\Course;
use app\admin\root\model\Information;

class Banner extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'mold'=>[
                '1'=>"课程",
                '2'=>'班级',
                '3'=>'资讯',
            ],
            'enterprise_id'=>$this->user['enterprise_id'],
        ];
        if($this -> checkVal['enterprise_id']==0){
            $this -> checkVal['type']=array('3'=>'叩之问','4'=>'发现');
        }else{
            $this -> checkVal['type']=array('1'=>'首页','2'=>'资讯');
        }
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =['enterprise_id'=>$this->user['enterprise_id']];
//        if (!empty($keywords)) {
//            ;
//        }

        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }

        // 获取数据
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
     * [add 添加数据]
     */
    public function add(){
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['add_time'] = time();
            $data['status'] =1;
            $data['enterprise_id'] =$this->user['enterprise_id'];

            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','status','add_time'])) {
                return ajax($model -> err, 2);
            }
            if($data['type']==4 && empty($data['classify_id'])){
                return ajax('请选择分类', 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加Banner');
            return ajax('添加成功');
        }
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }

        return view('', [
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据
            $data = input('post.');
            
            
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','status','add_time'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改Banner');
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }
        return view('',[
            'data'     => $data,
            'id'    => $id,
            'checkVal' => $this -> checkVal
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax('删除失败');
        $this->AddLog('删除Banner'.$id);
        return ajax('删除成功');
    }

    public function typelist(){
        if($this->param['type']==1){
            $Course=new Course();
            $data=$Course->getAll(['enterprise_id'=>$this->user['enterprise_id']],'created_at desc');
        }elseif ($this->param['type']==2){
            $Study=new Study();
            $data=$Study->field(['id','name as title'])->where(['enterprise_id'=>$this->user['enterprise_id']])->select();
        }elseif ($this->param['type']==3){
            $Information =new Information();
            $data=$Information->field(['id','name as title'])->where(['enterprise_id'=>$this->user['enterprise_id']])->select();
        }
        return ajax('获取成功',1,$data);
    }


}