<?php
/**
 * [教师通知控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 16:38:31
 * @Copyright:
 */
namespace app\teacher\info\controller;  
use app\common\model\TeacherNotice as model;
use app\teacher\root\controller\Common;

class Teachernotice extends Common{
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
        $where =['teacher_id'=>$this->user['id']];
        if (!empty($keywords)) {
            $where['title'] = ['like', "%{$keywords}%"];
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