<?php
/**
 * [接口列表控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-23 13:48:56
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\model\Port as model;

class Port extends Common{
    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'cat'   => [
                '1'     => '用户类',
                '2'     => '其他类'
            ]
        ];
    }

    /**
     * [index 列表]
     */
    public function index(){
        //实例化模型
        $model = new model;
        // 获取数据
        $temp = $model -> getAll();
        $data = [];
        if ($temp) {
            foreach ($temp as $k => $v) {
                $v['param'] = json_decode($v['param'], true);
                $v['url']   = 'http://bd.zpfshop.com/' . $v['url'];
                $data[$v['cid']][] = $v;
            }
            ksort($data);
        }
        
        // 模板
        return view('',[
            'data'     => $data,
            'checkVal' => $this -> checkVal
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
            $data['param'] = $model -> createparam($data['param']);
            // 添加数据
            if (!$model -> addData($data)) return ajax('添加失败', 2);
            return ajax('添加成功');
        }

        return view('', [
            'checkVal' => $this -> checkVal
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
            $data['param'] = $model -> createparam($data['param']);
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']], $data)) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }
        
        // 获取旧数据
        $id = (int)$this -> param['id'];
        $old = $model -> getOne(['id'=>$id]);
        $old['param'] = json_decode($old['param'], true);
        return view('',[
            'old' => $old,
            'id' => $id,
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