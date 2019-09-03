<?php
/**
 * [关键字管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-10-15 15:12:46
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Keyword as model;


class Keyword extends Common{
    protected $checkVal = [];
    protected $replace="*";
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
        $where = '';
        if (!empty($keywords)) {
            $where['title|replace'] = ['like', "%{$keywords}%"];
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
            $data['created_at'] = time();
            if(empty($data['replace']) && !empty($data['title'])){
                $strlen=mb_strlen($data['title'],"utf-8");
                $replace="";
                if($strlen){
                    for ($i=0;$i<$strlen;$i++){
                        $replace.=$this->replace;
                    }
                }
                $data['replace']=$replace?$replace:$this->replace;
            }
            // 验证
            if (!$model -> checkData($data, ['id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            $res=$model -> addData();
            // 添加数据
            if (!$res) return ajax('添加失败', 2);
            return ajax('添加成功');
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
            $data['updated_at'] = time();
            if(empty($data['replace']) && !empty($data['title'])){
                $strlen=mb_strlen($data['title'],"utf-8");
                $replace="";
                if($strlen){
                    for ($i=0;$i<$strlen;$i++){
                        $replace.=$this->replace;
                    }
                }
                $data['replace']=$replace?$replace:$this->replace;
            }
            // 验证
            if (!$model -> checkData($data, ['id','created_at'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        
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