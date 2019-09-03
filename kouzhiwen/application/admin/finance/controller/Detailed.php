<?php
/**
 * [消费明细控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-29 16:14:56
 * @Copyright:
 */
namespace app\admin\finance\controller;  
use app\admin\finance\model\EnterpriseDetailed as model;
use app\admin\root\controller\Common;
use app\admin\finance\model\UserDetailed;
use app\common\model\User;

class Detailed extends Common{
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
//    public function index(){
//        // 搜索关键词
//        $keywords = input('get.keywords');
//        $type = $this->param['type'];
//        $type=$type?$type:2;
//        //实例化模型
//        $model = new model;
//        $where =['enterprise_id'=>$this->user['enterprise_id'],'type'=>$type];
//        if (!empty($keywords)) {
//            $where['title'] = ['like', "%{$keywords}%"];
//        }
//        // 获取数据
//        $data  = admin_page($model, $where,'created_at desc');
//
//        // 模板
//        return view('',[
//            'data'      => $data['data'],
//            'page'      => $data['page'],
//            'type'      => $type,
//            'keywords'  => $keywords,
//            'checkVal'  => $this -> checkVal
//        ]);
//    }

    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $type = $this->param['type'];
        $type=$type?$type:2;
        //实例化模型
        $model = new UserDetailed();
        $model=$model->alias('d')
            ->join('user u','u.uid=d.uid','left')
            ->join('enterprise e','u.enterprise_id=e.id');
        $where = ['d.type'=>$type];
//        if($this->user['enterprise_id']!=0){
//            $where = ['u.enterprise_id'=>$this->user['enterprise_id']];
//        }

//        $where = ['u.enterprise_id'=>$this->user['enterprise_id']];
        if (!empty($keywords)) {
            $where['d.title'] = ['like', "%{$keywords}%"];
        }
        $field=array('d.*','u.name','e.name as qname');
        // 获取数据
        $data  = admin_page($model, $where,'d.created_at desc',$field);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'type'      => $type,
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
            if (!$model -> checkData($data, ['id','enterprise_id','type','title','price','created_at'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
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
            $data['created_at'] = time();
            
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','type','title','price','created_at'])) {
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