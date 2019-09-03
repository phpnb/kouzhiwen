<?php
/**
 * [权限组管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-01 20:47:45
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\model\AccessGroup as model;
use app\admin\root\model\Admin;
use app\common\model\Code;

class AccessGroup extends Common{
    /**
     * [index 列表]
     */
    public function index(){
        //实例化模型
        $model = new model;
        // 当前用户所属模块
        $this_module = $this -> user['module'];
        $where = ['enterprise_id'=>$this->user['enterprise_id'],'is_show'=>1];
        if ($this_module != 'admin/root') {
            $where['module'] = $this_module;
        }

        // 获取数据
        $tmp  = $model -> getAll($where);
        $data = [];
        if (!empty($tmp)) {
            foreach ($tmp AS $v){
                $data[$v['module']][] = $v;
            }
        }
        // 模板
        return view('',[
            'data'     => $data,
        ]);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        if ($this -> isPost) {
            $data = input('post.');
            // 实例化模型
            $model = db('access_group');
            // 重组数据
            $name = $data['name']; $module = $data['module'];
            // 判断名称是否存在
            if ($model -> where(['name'=>$name]) -> find()) {
                return ajax('组名称已存在', 2);
            }
            unset($data['name'], $data['module']);
            $add = [
                'enterprise_id'=> $this->user['enterprise_id'],
                'name'      => $name,
                'access'    => json_encode($data),
                'add_time'  => time(),
                'module'    => $this -> user['module']
            ];

            // 执行添加
            $model -> insert($add);
            $this->AddLog('添加角色'.$name);
            return ajax('添加成功');
        }

        // 当前用户所属模块
        $this_module = $this -> user['module'];
        $where = [];
        // 不是root的只能创建自己的权限
        if ($this_module != 'admin/root') {
            $tmp = db('access_group') -> where(['id'=>['in',$this -> user['group_id']]]) -> select();
            $access = [];
            foreach ($tmp AS $k => $v) {
                $tmp2 = json_decode($v['access'], true);
                $access = array_merge($access, $tmp2);
            }
            // 组合菜单查询条件
            $in_m = ''; $in_c = '';
            foreach ($access AS $k => $v) {
                // 拆分模块和控制器
                $actp = explode('/', $k);
                // 控制器条件
                $in_c .= end($actp) . ',';

                // 模块条件
                array_pop($actp);
                $in_m .= implode('/', $actp) . ',';
            }

            $where = [
                'module'        => ['in', rtrim($in_m, ',')],
                'controller'    => ['in', rtrim($in_c, ',')],
            ];
        }

        if($this->user['enterprise_id']!=0){
            $where['platform']=['in',[1,3]];
        }else{
            $where['platform']=['in',[1,2,3]];
        }
        // 获取菜单列表，用户权限选择
        $tmp = db('menu') -> where($where) -> order('`id` ASC') -> select() -> toArray();
        if (empty($tmp)) {
            echo '还未创建菜单';die;
        }

        // 获取菜单分类
        $mc = db('menu_category') -> where('') -> order('`sort` ASC') -> select();
        $nmc = [];
        foreach ($mc as $v) {
            $nmc[$v['module']][$v['id']]['name'] = $v['name'];
            $nmc[$v['module']][$v['id']]['method_menu'] = [];
            $nmc[$v['module']][$v['id']]['child'] = [];
            foreach ($tmp AS $val) {
                $val['method'] = json_decode($val['method'], true);
                if ($val['mcid'] == $v['id']) {
                    if ($val['address'] == '') {
                        $nmc[$v['module']][$v['id']]['child'][] = $val;
                    } else {
                        $nmc[$v['module']][$v['id']]['method_menu'][] = $val;
                    }
                }
            }
        }

        return view('',[
            'menu'          => $nmc,
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = db('access_group');
        // POST提交处理
        if ($this -> isPost) {
            $data = input('post.');
            // 重组数据
            $name = $data['name'];
            $id   = $data['id'];
            unset($data['name'], $data['id']);
            $add = [
                'id'        => $id,
                'name'      => $name,
                'access'    => json_encode($data),
                'edit_time' => time(),
            ];
            // 执行修改
            $model -> update($add);
            $this->AddLog('修改角色'.$name);
            return ajax('修改成功');
        }
        
        $id = (int)$this -> param['id'];
        // 获取旧数据
        $oldData = $model -> where(['id'=>$id]) -> find();

        // 当前用户所属模块
        $this_module = $this -> user['module'];
        $where = [];
        // 不是root的只能创建自己的权限
        if ($this_module != 'admin/root') {
            $tmp = db('access_group') -> where(['id'=>['in',$this -> user['group_id']]]) -> select();
            $access = [];
            foreach ($tmp AS $k => $v) {
                $tmp2 = json_decode($v['access'], true);
                $access = array_merge($access, $tmp2);
            }
            // 组合菜单查询条件
            $in_m = ''; $in_c = '';
            foreach ($access AS $k => $v) {
                // 拆分模块和控制器
                $actp = explode('/', $k);
                // 控制器条件
                $in_c .= end($actp) . ',';

                // 模块条件
                array_pop($actp);
                $in_m .= implode('/', $actp) . ',';
            }

            $where = [
                'module'        => ['in', rtrim($in_m, ',')],
                'controller'    => ['in', rtrim($in_c, ',')],
            ];
        }
        if($this->user['enterprise_id']!=0){
            $where['platform']=['in',[1,3]];
        }else{
            $where['platform']=['in',[1,2,3]];
        }
        // 获取菜单列表，用户权限选择
        $tmp = db('menu') -> where($where) -> order('`id` ASC') -> select();

        // 获取菜单分类
        $mc = db('menu_category') -> order('`sort` ASC') -> select();
        $nmc = [];
        foreach ($mc as $v) {
            $nmc[$v['module']][$v['id']]['name'] = $v['name'];
            $nmc[$v['module']][$v['id']]['method_menu'] = [];
            $nmc[$v['module']][$v['id']]['child'] = [];
            foreach ($tmp AS $val) {
                $val['method'] = json_decode($val['method'], true);
                if ($val['mcid'] == $v['id']) {
                    if ($val['address'] == '') {
                        $nmc[$v['module']][$v['id']]['child'][] = $val;
                    } else {
                        $nmc[$v['module']][$v['id']]['method_menu'][] = $val;
                    }
                }
            }
        }

        $oldData['access'] = json_decode($oldData['access'], true);

        // 载入模板
        return view('',[
            'oldData'   => $oldData,
            'menu'      => $nmc,
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
        $old = $model -> getOne(['id'=>$id]);
        if ($old['is_sys'] == 1) {
            return ajax('!  非法操作，管理员组不允许删除', 2);
        }
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax('删除失败');
        $this->AddLog('删除角色'.$id);
        return ajax('删除成功');
    }

    /**
     * 角色成员
     */
    public function  user(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $id = $this -> param['id'];
        $model = new Admin();
        $where['group_id'] = $id;

        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }
}