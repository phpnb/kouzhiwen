<?php
/**
 * [版本管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-09-03 18:33:37
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Version as model;


class Version extends Common{
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
        $where = '';
        if (!empty($keywords)) {
            ;
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
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据
            $data = input('post.');
            
            
            // 验证
            if (!$model -> checkData($data, ['id'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改版本'.$data['v']);
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


}