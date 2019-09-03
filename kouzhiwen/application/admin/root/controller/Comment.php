<?php
/**
 * [评论管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:08:34
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Comment as model;


class Comment extends Common{
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
        $where =array('c.enterprise_id'=>$this->user['enterprise_id']);
        if (!empty($keywords)) {
            $where['c.contents'] = ['like', "%{$keywords}%"];
        }
        $model=$model->alias('c')->join('user u','u.uid=c.uid','left');
        $fiele=array('c.*','u.nickname');
        // 获取数据
        $data  = admin_page($model, $where,'c.add_time desc',$fiele);
        
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
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax('删除失败');
        $this->AddLog('删除评论'.$id);
        return ajax('删除成功');
    }


}