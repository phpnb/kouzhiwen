<?php
/**
 * [获奖记录控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-09-20 15:25:40
 * @Copyright:
 */
namespace app\admin\finance\controller;  
use app\admin\finance\model\UserGift as model;
use app\admin\root\controller\Common;
use app\admin\info\model\User;

class Gift extends Common{
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
        $where = array('u.enterprise_id'=>$this->user['enterprise_id'],'u.status'=>1);
        if (!empty($keywords)) {
            $where['g.contents|u.name|u.phone|u.nickname'] = ['like', "%{$keywords}%"];
        }
        $model=$model->alias('g')->join('user u','u.uid=g.uid');
        // 获取数据
        $data  = admin_page($model, $where,'g.created_at desc',['g.id','g.contents','g.created_at','u.phone','u.face','u.nickname','u.name']);
        
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
            
            // 验证
            if (!$model -> checkData($data, ['id','gift_id'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加获奖记录');
            return ajax('添加成功');
        }
        $this -> checkVal['uid_Val']=(new User)->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
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
            $data['created_at'] = time();
            
            // 验证
            if (!$model -> checkData($data, ['id','gift_id'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改获奖记录');
            return ajax('修改成功');
        }
        $this -> checkVal['uid_Val']=(new User)->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
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
        $this->AddLog('删除获奖记录'.$id);
        return ajax('删除成功');
    }


}