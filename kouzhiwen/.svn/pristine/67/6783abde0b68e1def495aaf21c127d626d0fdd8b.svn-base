<?php
/**
 * [菜单分类管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-04-17 09:38:42
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\model\MenuCategory as model;

class MenuCategory extends Common{
    /**
     * [index 菜单分类列表]
     */
    public function index(){
        // 实例化模型
        $model = new model;
        $tmp = $model -> getAll('', 'id asc');
        $data = [];
        foreach ($tmp AS $v) {
            $data[$v['module']][] = $v;
        }

        return view('',[
            'data'      => $data,
        ]);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            if ($model -> getOne(['name'=>$this -> param['name'],'module'=>$this -> param['module']])) {
                return ajax('分类名称已存在', 2);
            }

            // 验证
            if (!$model -> checkData($this -> param)) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            return ajax('添加成功');
        }

        return view();
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        // POST提交处理
        if ($this -> isPost) {
            $data = input('post.');
            // 验证
            if (!$model -> checkData($data)) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }
        
        // 旧数据
        $id = (int)$this -> param['id'];
        $old = $model -> getOne(['id'=>$id]);
        if ($old['is_sys'] == 1) {
            return view('error/err');
        }
        return view('',[
            'old'   => $old,
            'id'    => $id
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        $id = $this -> param['id'];
        $old = $model -> getOne(['id'=>$id]);
        if ($old['is_sys'] == 1) {
            return ajax('!  非法操作，系统内置方法不允许进行该操作', 2);
        }

        $where['id'] = ['in', $id]; 
        if (!$model -> delData($where)) return ajax('删除失败');
        return ajax('删除成功');
    }
}
