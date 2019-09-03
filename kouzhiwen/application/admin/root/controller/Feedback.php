<?php
/**
 * [意见反馈控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-09-03 18:42:59
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\UserFeedback as model;


class Feedback extends Common{
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
            $where['f.contents'] = ['like', "%{$keywords}%"];
        }
        $model=$model->alias("f")->join("user u","u.uid=f.uid","left")->join("enterprise e","u.enterprise_id=e.id","left");
        // 获取数据
        $field=array("f.*","u.name","e.name as ename");
        $data  = admin_page($model, $where,"f.created_at desc",$field);
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
        $this->AddLog('删除意见反馈'.$id);
        return ajax('删除成功');
    }


}