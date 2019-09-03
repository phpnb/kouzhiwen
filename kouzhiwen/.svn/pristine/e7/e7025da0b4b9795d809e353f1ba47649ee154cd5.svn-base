<?php
/**
 * [学习班分类控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 17:19:21
 * @Copyright:
 */
namespace app\admin\course\controller;  
use app\admin\course\model\ClassType as model;
use app\admin\root\controller\Common;

class Classtype extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'upVal'=>[],
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
        $where =array('enterprise_id'=>$this->user['enterprise_id']);
        if (!empty($keywords)) {
            $where['name'] = ['like', "%{$keywords}%"];
        }

        $type=$model->getAll(['enterprise_id'=>$this->user['enterprise_id'],'up'=>0]);
        if(!empty($type)){
            $this->checkVal['upVal']=$this->array_convert($type,'id','name');
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
        $model = new model;
        if ($this -> isPost) {
            // 实例化模型

            // 获取post数据
            $data = input('post.');
            $data['updated_at'] = time();
            $data['enterprise_id'] =$this->user['enterprise_id'];

            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            return ajax('添加成功');
        }

        $type=$model->getAll(['enterprise_id'=>$this->user['enterprise_id'],'up'=>0]);
        $this->checkVal['upVal']=$type;
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
            $data['updated_at'] = time();
            
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $type=$model->getAll(['enterprise_id'=>$this->user['enterprise_id'],'up'=>0]);
        $this->checkVal['upVal']=$type;
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
        return ajax('删除成功');
    }


}