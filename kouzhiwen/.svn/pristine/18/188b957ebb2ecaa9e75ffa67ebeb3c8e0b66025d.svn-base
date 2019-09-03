<?php
/**
 * [操作日志控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-29 20:12:05
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Log as model;


class Log extends Common{
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
        $where = ['enterprise_id'=>$this->user['enterprise_id']];
        if (!empty($keywords)) {
            $where['name|content'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where,'updated_at desc');
        
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }


}