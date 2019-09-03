<?php
/**
 * [权限组管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-01 20:47:45
 * @Copyright:
 */
namespace app\admin\root\controller;

class Admin extends Common{
    /**
     * [index 管理员列表]
     * @return [type] [description]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $this_module = $this -> user['module'];
        $where = ['enterprise_id'=>$this->user['enterprise_id']];
        if (!empty($keywords)) {
            $where['username'] = ['like', "%{$keywords}%"];
        }
        if ($this_module != 'admin/root') {
            $where['module'] = $this_module;
            $where['is_top'] = 0;
        }
        $tmp = db('admin') -> where($where) -> select() -> toArray();
        $data = [];
        if (!empty($tmp)) {
            $groupModel = db('access_group');
            foreach ($tmp AS $k => $v) {
                $v['name'] = $groupModel -> where(['id'=>['in', $v['group_id']]]) -> field('name') -> select() -> toArray();
                $data[$v['module']][] = $v;
            }
        }

        return view('', [
            'data'  => $data,
            'keywords'  => $keywords,
        ]);
    }

    /**
     * [add 添加]
     */
    public function add(){
        // POST提交处理
        if ($this -> isPost) {
            $data = input('post.');
            // 实例化模型
            $model = db('admin');
            // 判断用户名是否存在
            $oldData = $model -> where(['username'=>$data['username']]) -> find();
            if ($oldData) {
                return ajax('用户名已存在', 2);
            }
            $data['password'] = md5(md5($data['password']));
            $data['group_id'] = implode(',', $data['group_id']);
            $data['enterprise_id']=$this->user['enterprise_id'];
            if ($this -> user['module'] == 'admin/root') {
                $data['is_top'] = 1;
            }
            // 执行添加
            $res = $model -> insert($data);
            if (!$res) {
                return ajax('添加失败', 2);
            }
            $this->AddLog('添加管理员'.$data['username']);
            return ajax('添加成功');
        }

        $mname = $this -> param['module'];

        // 获取权限组
        $gModel = db('access_group');
        // 当前用户所属模块
        $this_module = $this -> user['module'];
        $where = ['enterprise_id'=>$this->user['enterprise_id']];
        if ($this_module != 'admin/root') {
            $where['module'] = $this -> user['module'];
        }

        $group = $gModel -> where($where) -> field('id,name') -> select() -> toArray();
        if (empty($group)) {
            echo '该模块还未创建权限组';die;
        }

        // 获取模块
        $module = scandir(APP_PATH . 'admin');
        foreach ($module AS $k => $v) {
            if (strstr($v, '.')) unset($module[$k]);
        }

        if (empty($mname)) {
            $tmp = explode('/', $this -> user['module']);
            $mname = $tmp[1];
        }

        // 载入模板
        return view('', [
            'group'     => $group,
            'module'    => $module,
            'mname'     => $mname
        ]);
    }

    /**
     * [edit 修改]
     */
    public function edit(){
        // 实例化模型
        $model = db('admin');
        // POST提交处理
        if ($this -> isPost) {
            $data = input('post.');
            if (empty($data['group_id'])) {
                return ajax('请选择所属组', 2);
            }
            // 密码加密
            if (!empty($data['password'])) {
                $data['password'] = md5(md5($data['password']));
            } else {
                unset($data['password']);
            }
            $data['group_id'] = implode(',', $data['group_id']);
            // 执行修改
            $model -> update($data);
            $this->AddLog('修改管理员'.$data['username']);
            return ajax('修改成功');
        }

        $aid = (int)$this -> param['aid'];
        // 获取旧数据
        $oldData = $model -> where(['aid'=>$aid]) -> find();
        $oldData['group_id'] = explode(',', $oldData['group_id']);
        // 获取权限组
        $gModel = db('access_group');
        // 当前用户所属模块
        $this_module = $this -> user['module'];
        $where = [];
        if ($this_module != 'admin/root') {
            $where['module'] = $this -> user['module'];
        }
        $group = $gModel -> where($where) -> field('id,name') -> select() -> toArray();

        if (empty($group)) {
            echo '还未设置权限组';die;
        }

        // 载入模板
        return view('',[
            'oldData'   => $oldData,
            'group'     => $group,
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        if ($this -> isPost) {
            // 实例化模型
            $model = db('admin');
            $data = input('post.');
            // 执行删除
            if($data['aid']==1)return ajax('超级管理员不可删除',2);
            $model -> where(['aid'=>$data['aid']]) -> delete();
            $this->AddLog('删除管理员'.$data['aid']);
            return ajax('删除成功');
        }
        
    }
}
