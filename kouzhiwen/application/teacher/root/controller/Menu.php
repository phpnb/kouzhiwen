<?php

namespace app\admin\root\controller;

use app\admin\root\model\MenuCategory;
class Menu extends Common
{
    protected $pre;
    protected $vname = '';
    protected $vcolumn = [];
    /**
     * [_initialize 构造方法]
     */
    public function _initialize()
    {
        parent::_initialize();
        // 数据表下标
        $this->pre = config('database.prefix');

        //@Update by: dufei
    	//@Date: 2018-06-28 19:59:42;
        // 权限验证
        // $check = $this->_checkAccess();

        $check = 'XXXX';	//临时关闭
        if (empty($check)) {
            echo '<b style="color:red; text-align:center">框架功能仅限公司内部使用 (^_^)</b>';
            die;
        }
    }
    /**
     * [index 列表]
     */
    public function index()
    {
        // 获取菜单
        $model = db('menu');
        $tmp = $model->order('`mcid` ASC,`id` ASC')->select()->toArray();
        // 获取菜单分类
        $mc = db('menu_category')->order('`sort` ASC')->select()->toArray();
        $nmc = [];
        foreach ($mc as $v) {
            $nmc[$v['module']][$v['id']]['name'] = $v['name'];
            foreach ($tmp as $val) {
                if ($val['mcid'] == $v['id']) {
                    $val['method'] = json_decode($val['method'], true);
                    $nmc[$v['module']][$v['id']]['child'][] = $val;
                }
            }
        }
        return view('', ['menu' => $nmc]);
    }
    /**
     * 添加方法为菜单
     * @return \think\response\View
     */
    public function addMethod()
    {
        if ($this->isPost) {
            $data = input('post.');
            $model = db('menu');
            // 控制器名称
            $controller = explode('/', $data['address']);
            // 控制器是否存在
            $old = $model->where(['controller' => $controller[0]])->find();
            if (empty($old)) {
                return ajax('控制器不存在', 2);
            }
            if ($old['mcid'] != $data['mcid']) {
                return ajax('控制器与分类不匹配', 2);
            }
            $data['module'] = $old['module'];
            $data['controller'] = $controller[0];
            $data['address'] = $controller[1];
            $model->insert($data);
            return ajax('添加成功');
        }
        // 获取菜单分类
        $catModel = new MenuCategory();
        $tmp = $catModel->getAll();
        $category = [];
        foreach ($tmp as $v) {
            $category[$v['module']][] = $v;
        }
        return view('', ['category' => $category]);
    }
    /**
     * [edit 修改]
     */
    public function edit()
    {
        if ($this->isPost) {
            $data = input('post.');
            // 重组数据
            foreach ($data['mname'] as $k => $v) {
                $add[] = ['name' => $data['mname'][$k], 'method' => $data['method'][$k]];
            }
            $data['method'] = json_encode($add, JSON_UNESCAPED_UNICODE);
            unset($data['mname']);
            // 修改数据库
            db('menu')->where(['id' => $data['id']])->update($data);
            return ajax('操作成功');
        }
        $id = $this->param['id'];
        // 获取旧数据
        $data = db('menu')->where(['id' => $id])->find();
        if ($data['is_sys'] == 1) {
            return view('error/err');
        }
        // 获取菜单分类
        $catModel = new MenuCategory();
        $tmp = $catModel->getAll();
        $category = [];
        foreach ($tmp as $v) {
            $category[$v['module']][] = $v;
        }
        $data['method'] = json_decode($data['method'], true);
        return view('', ['data' => $data, 'category' => $category]);
    }
    /**
     * [del 删除]
     */
    public function del()
    {
        if ($this->isPost) {
            $id = (int) $this->param['id'];
            $old = db('menu')->where(['id' => $id])->find();
            if ($old['is_sys'] == 1) {
                return ajax('!  非法操作，系统内置方法不允许进行该操作', 2);
            }
            db('menu')->where(['id' => $id])->delete();
            return ajax('删除成功');
        }
    }
    /**
     * [add 添加菜单]
     */
    public function add()
    {
        // post处理
        if ($this->isPost) {
            $data = input('post.');
            // 控制器下划线转驼峰
            $data['control'] = underline_to_hump($data['control']);
            // 判断控制器是否被占用
            $where = ['controller' => $data['control'], 'module' => $data['module']];
            $old = db('menu')->where($where)->find();
            if ($old) {
                return ajax('控制器已被占用', 2);
            }
            if (array_key_exists('method', $data)) {
                // 重组方法
                $method = '[';
                $d = '';
                foreach ($data['method'] as $v) {
                    $method .= $d . $v;
                    $d = ',';
                }
                $method .= ']';
                $data['method'] = $method;
            }
            if (array_key_exists('api_method', $data)) {
                // 重组方法
                $method = '[';
                $d = '';
                foreach ($data['api_method'] as $v) {
                    $method .= $d . $v;
                    $d = ',';
                }
                $method .= ']';
                $data['api_method'] = $method;
            }
            // ----------- 创建多表关联视图 -----------
            if (array_key_exists('select_type', $data) && $data['select_type'] == 2) {
                // 是否创建新视图
                if ($data['view_type'] == 2) {
                    // 获取创建好的视图名称
                    $vname = $this->_createViewTable($data);
                    if (!$vname) {
                        return ajax('创建视图出错', 2);
                    }
                    $this->vname = $vname;
                } else {
                    // 使用已有视图
                    $this->vname = $data['vname'];
                    // 获取视图信息
                    if (!$this->_getViewInfo($data['vname'])) {
                        return ajax('指定的视图不存在', 2);
                    }
                }
            }
            if ($data['is_auto'] == 0) {
                // ----------- 创建空控制器 -----------
                $this->_createEmptyControl($data);
                $data['method'] = '[{"name":"列表","method":"index"}]';
            } else {
                if (array_key_exists('method', $data)) {
                    // ----------- 自定义模板配置 -----------
                    if ($data['tpl_type'] == 2) {
                        if (!$this->_createDiyDeploy($data)) {
                            return ajax('创建失败');
                        }
                    }
                    // ----------- 默认模板配置 -----------
                    if ($data['tpl_type'] == 1) {
                        if (!$this->_createDefaultDeploy($data)) {
                            return ajax('创建失败');
                        }
                    }
                }
                // ----------- 是否生成API接口 -----------
                if (array_key_exists('api_method', $data) && !empty($data['api_method'])) {
                    $this->_createApi($data);
                }
            }
            // 保存菜单
            $this->_saveMrnu($data);
            return ajax('添加成功');
        }
        // 获取菜单分类
        $catModel = new MenuCategory();
        $tmp = $catModel->getAll();
        $category = [];
        foreach ($tmp as $v) {
            $category[$v['module']][] = $v;
        }
        return view('', ['category' => $category]);
    }
    // add end
    /**
     * [_createApi 生成API接口]
     * @param type $data
     */
    private function _createApi($data)
    {
        $pre = $this->pre;
        if ($data['tpl_type'] == 1) {
            // 获取表的字段
            $column = db()->query("select \n
            column_key,column_name,column_comment from \n
                INFORMATION_SCHEMA.COLUMNS \n
            where table_name='{$pre}{$data['table']}'");
            foreach ($column as $v) {
                // 获取主键
                if ($v['column_key'] == 'PRI') {
                    $pk['COLUMN_NAME'] = $v['column_name'];
                } else {
                    // 组合字段
                    $data['column']['name'][$v['column_name']] = $v['column_comment'];
                    $data['column']['val'][$v['column_name']] = '';
                    $data['column']['rule'][$v['column_name']] = '*';
                    $data['column']['type'][$v['column_name']] = 'text';
                    $data['column']['add_rule'][$v['column_name']] = '';
                }
            }
        } else {
            // 获取表的主键
            $pk = db()->query("select \n
                            COLUMN_KEY,COLUMN_NAME from \n
                            INFORMATION_SCHEMA.COLUMNS \n
                            where table_name='{$pre}{$data['table']}' AND COLUMN_KEY='PRI'");
            $pk = current($pk);
        }
        // 创建控制器
        $this->_createApiController($data, $pk);
    }
    //_createApi end
    /**
     * 创建API控制器
     * @param type $data
     */
    private function _createApiController($data, $pk)
    {
        $_time = date('Y-m-d H:i:s');
        $pre = $this->pre;
        // 解析方法
        $data['api_method'] = json_decode($data['api_method'], true);
        // 创建方法
        $method = $this->_createApiMethod($data, $pk);
        // 创建模型
        $modelName = $this->_createModel($data, $pk['COLUMN_NAME']);
        if ($data['model_local'] == 1) {
            $usemodel = 'use app\\common\\model\\' . $modelName . ' as model;';
        } else {
            $usemodel = 'use app\\' . str_replace('/', '\\', $data['module']) . '\\model\\' . $modelName . ' as model;';
        }
        $module = str_replace('/', '_', $data['module']);
        // 保存文件
        if ($data['api_local'] == 1) {
            $fname = APP_PATH . 'api/' . $module . '/controller/' . $data['control'] . '.php';
            $namespa = 'namespace app\\api\\' . $module . '\\controller; @eval("//Encode by  phpjiami.com,Free user."); ';
        } else {
            $tmp = explode('/', $data['module']);
            $fname = APP_PATH . $tmp[0] . '/api/controller/' . $data['control'] . '.php';
            $namespa = 'namespace app\\' . $tmp[0] . '\\api\\controller; @eval("//Encode by  phpjiami.com,Free user."); ';
        }
        // 生成控制器
        $controller = <<<C
<?php
/**
 * [{$data['name']}接口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   {$_time}
 * @Copyright:
 */
{$namespa}
use app\\api\\common\\controller\\Api;
{$usemodel}

class {$data['control']} extends Api{
    {$method}
}
C;
        if (!is_dir(dirname($fname))) {
            mkdir(dirname($fname), 0777, true);
        }
        $controller = str_replace('@eval("//Encode by  phpjiami.com,Free user.");', '', $controller);
        file_put_contents($fname, $controller);
    }
    // _createApiController end
    /**
     * 创建API控制器
     * @param type $data
     * @param type $pk
     */
    private function _createApiMethod($data, $pk)
    {
        // 创建方法
        $method = '';
        foreach ($data['api_method'] as $v) {
            // 创建列表方法
            if ($v['method'] == 'index') {
                $method .= $this->_createApiMethodIndex($data);
            }
            // 创建添加方法
            if ($v['method'] == 'add') {
                $method .= $this->_createApiMethodAdd($data);
            }
            // 创建修改方法
            if ($v['method'] == 'edit') {
                $method .= $this->_createApiMethodEdit($data, $pk['COLUMN_NAME']);
            }
            // 创建删除方法
            if ($v['method'] == 'del') {
                $method .= $this->_createApiMethodDel($data, $pk['COLUMN_NAME']);
            }
        }
        return $method;
    }
    /**
     * API删除
     * @param type $data
     * @param type $pk
     */
    private function _createApiMethodDel($data, $pk)
    {
        $method = <<<M
    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        \$model = new model;
        if (!\$this -> isPost) return ajax('非法请求');
        // 定义条件
        \${$pk} = \$this -> param['id'];
        if (empty(\${$pk})) return ajax('请选择要操作的数据');
        \$where['{$pk}'] = \${$pk};
        if (!\$model -> delData(\$where)) return ajax('删除失败');
        return ajax('删除成功');
    }


M;
        return $method;
    }
    // _createApiMethodDel del
    /**
     * API修改方法
     * @param type $data
     * @param type $pk
     */
    private function _createApiMethodEdit($data, $pk)
    {
        // 是否有更新不需要验证的字段
        if (array_key_exists('no_up_rule', $data['column']) && !empty($data['column']['no_up_rule'])) {
            $noRule = '[';
            $d = '';
            foreach ($data['column']['no_up_rule'] as $v) {
                $noRule .= $d . "'" . $v . "'";
                $d = ',';
            }
            $noRule .= ']';
        } else {
            $noRule = '[]';
        }
        $method = <<<M
    /**
     * [edit 编辑]
     */
    public function edit(){
        if (!\$this -> isPost) return ajax('非法请求', 2);
        \$model = new model;
        // 获取post数据
        \$data = input('post.');
        if (empty(\$data['{$pk}'])) return ajax('请选择要操作的数据');
        // 验证
        if (!\$model -> checkData(\$data, {$noRule})) {
            return ajax(\$model -> err, 2);
        }
        // 修改数据
        if (!\$model -> editData(['{$pk}'=>\$data['{$pk}']])) return ajax('没有数据被修改', 2);
        return ajax('修改成功');
    }


M;
        return $method;
    }
    // _createApiMethodEdit end
    /**
     * API添加方法
     * @param type $data
     */
    private function _createApiMethodAdd($data)
    {
        // 是否有更新不需要验证的字段
        if (array_key_exists('no_up_rule', $data['column']) && !empty($data['column']['no_up_rule'])) {
            $noRule = '[';
            $d = '';
            foreach ($data['column']['no_up_rule'] as $v) {
                $noRule .= $d . "'" . $v . "'";
                $d = ',';
            }
            $noRule .= ']';
        } else {
            $noRule = '[]';
        }
        $method = <<<M
    /**
     * [add 添加数据]
     */
    public function add(){
        if (!\$this -> isPost) return ajax('非法请求', 2);
        // 实例化模型
        \$model = new model;
        // 获取post数据
        \$data = input('post.');
        // 验证
        if (!\$model -> checkData(\$data, {$noRule})) {
            return ajax(\$model -> err, 2);
        }
        // 添加数据
        if (!\$model -> addData()) return ajax('添加失败', 2);
        return ajax('添加成功');
    }


M;
        return $method;
    }
    // _createApiMethodAdd end
    /**
     * api列表方法
     * @param type $data
     */
    private function _createApiMethodIndex($data)
    {
        // 是否多表关联查询
        if (!empty($this->vname)) {
            // 是否分页
            if ($data['is_page'] == 0) {
                // 不分页处理
                $cdata = "
                // 获取视图数据\n
                \$data = db('{$this->vname}') -> select();\n
                if (empty(\$data)) return ajax('暂无数据', 2);";
            } else {
                // 分页处理
                $cdata = "
                // 获取视图数据\n
                \$data = api_page(db('{$this->vname}'));\n
                if (empty(\$data['data'])) return ajax('暂无数据', 2);";
            }
        } else {
            // 是否分页
            if ($data['is_page'] == 0) {
                $cdata = "
                //实例化模型\n
                \$model = new model;\n
                // 获取数据\n
                \$data  = \$model -> getAll();\n
                if (empty(\$data)) return ajax('暂无数据', 2);";
            } else {
                $cdata = "
                //实例化模型\n
                \$model = new model;\n
                // 获取数据\n
                \$data  = api_page(\$model);\n
                if (empty(\$data['data'])) return ajax('暂无数据', 2);";
            }
        }
        $method = <<<M
/**
     * [index 列表]
     */
    public function index(){
        {$cdata}
        return ajax('获取成功', 1, \$data);
    }


M;
        return $method;
    }
    // _createApiMethodIndex end
    /**
     * [getTable 获取表]
     */
    public function getTable()
    {
        $tname = $this->param['tname'];
        // 表前缀
        $pre = $this->pre;
        $db = config('database.database');
        // 判断表是否存在
        $sql = "select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$pre}{$tname}'";
        $model = db();
        $hasTable = $model->query($sql);
        if (empty($hasTable)) {
            return ajax('数据表不存在', 2);
        }
        // 获取数据库字段和备注
        $sql = "SELECT column_name,column_comment,CASE WHEN extra = 'auto_increment' THEN 1 ELSE 0 END AS `is_pk` \n
                FROM Information_schema.columns \n
                WHERE TABLE_SCHEMA='{$db}' AND table_Name='{$pre}{$tname}'";
        $field = $model->query($sql);
        return ajax('获取成功', 1, $field);
    }
    // getTable end
    /**
     * [_saveMrnu 保存菜单]
     */
    private function _saveMrnu($data)
    {
        // 保存菜单
        $save = ['name' => $data['name'], 'controller' => $data['control'], 'method' => array_key_exists('method', $data) ? $data['method'] : '', 'mcid' => $data['mcid'], 'is_show' => $data['is_show'], 'module' => $data['module']];
        return db('menu')->insert($save);
    }
    // _saveMrnu end
    /**
     * [_getViewInfo 获取视图信息]
     */
    private function _getViewInfo($vname)
    {
        $pre = $this->pre;
        $db = config('database.database');
        // 判断数据表是否存在
        $has_table = db()->query("select * from information_schema.tables where table_name = '{$pre}{$vname}'");
        if (!$has_table) {
            return false;
        }
        // 获取视图栏位与备注
        $sql = "SELECT column_name, column_comment, CASE WHEN extra = 'auto_increment' THEN 1 ELSE 0 END AS `is_pk` \n
                FROM Information_schema.columns \n
                WHERE TABLE_SCHEMA='{$db}' AND table_name='{$pre}{$vname}'";
        $tmp = db()->query($sql);
        // 重组
        $field = [];
        foreach ($tmp as $v) {
            $field[$v['column_name']] = $v['column_comment'];
        }
        $this->vcolumn = $field;
        return true;
    }
    // _getViewInfo end
    /**
     * [_createViewTable 创建多表关联视图]
     */
    private function _createViewTable($data)
    {
        // 表前缀
        $pre = $this->pre;
        $db = config('database.database');
        // --------- 查询字段处理 ---------
        $fields = $this->_viewFields($data, $pre);
        // --------- JOIN 处理 ---------
        $join = $this->_viewJoin($data, $pre);
        // 删除原视图
        db()->execute("DROP VIEW IF EXISTS `{$fields['vname']}`");
        // 创建新视图
        $sql = "CREATE VIEW `{$fields['vname']}` AS SELECT \n
        		{$fields['fields']} \n
        		FROM `{$pre}{$data['main_table']}` AS `{$data['main_table']}`{$join}";
        if (db()->execute($sql) !== 0) {
            return false;
        }
        // 获取视图栏位与备注
        $sql = "SELECT column_name, column_comment, CASE WHEN extra = 'auto_increment' THEN 1 ELSE 0 END AS `is_pk` \n
        		FROM Information_schema.columns \n
        		WHERE TABLE_SCHEMA='{$db}' AND table_Name='{$fields['vname']}'";
        $tmp = db()->query($sql);
        // 重组
        $field = [];
        foreach ($tmp as $v) {
            $field[$v['column_name']] = $v['column_comment'];
        }
        $this->vcolumn = $field;
        $fields['vname'] = str_replace($pre, '', $fields['vname']);
        return $fields['vname'];
    }
    // _createViewTable end
    /**
     * [_viewFields 创建查询字段]
     * @param  [type] $data [数据结构]
     * @param  [type] $pre  [表前缀]
     */
    private function _viewFields($data, $pre)
    {
        $fields = '';
        // 主表字段
        foreach ($data[$data['main_table'] . '_field'] as $key => $val) {
            if (empty($data[$data['main_table'] . '_alias'][$val])) {
                // 无别名
                $fields .= $data['main_table'] . '.' . $val . ',';
            } else {
                // 别名处理
                $fields .= $data['main_table'] . '.' . $val . ' AS ' . $data[$data['main_table'] . '_alias'][$val] . ',';
            }
        }
        // 视图名称
        $vname = $pre . 'v_' . $data['main_table'];
        // 附加表字段
        foreach ($data['tables'] as $k => $v) {
            $vname .= '_' . $v;
            foreach ($data[$v . '_field'] as $key => $val) {
                if (empty($data[$v . '_alias'][$val])) {
                    $fields .= $v . '.' . $val . ',';
                } else {
                    $fields .= $v . '.' . $val . ' AS ' . $data[$v . '_alias'][$val] . ',';
                }
            }
        }
        return ['fields' => rtrim($fields, ','), 'vname' => $vname];
    }
    // _viewFields end
    /**
     * [_viewJoin JOIN处理]
     */
    private function _viewJoin($data, $pre)
    {
        $join = '';
        foreach ($data['tables'] as $k => $v) {
            $join .= ' ' . $data['join'][$k] . ' `' . $pre . $v . '` AS `' . $v . '` ON ' . $data['on']['l'][$k] . '=' . $data['on']['r'][$k];
        }
        return $join;
    }
    // _viewJoin end
    /**
     * [_createEmptyControl 创建空控制器]
     */
    private function _createEmptyControl($data)
    {
        $_time = date('Y-m-d H:i:s');
        $use = '';
        if ($data['module'] != 'admin/root') {
            $use = 'use app\\admin\\root\\controller\\Common;';
        }
        $module = str_replace('/', '\\', $data['module']);
        // ------------------------ begin ----------------------------
        $controller = <<<C
<?php
/**
 * [{$data['name']}控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   {$_time}
 * @Copyright:
 */
namespace app\\{$module}\\controller; @eval("//Encode by  phpjiami.com,Free user.");
{$use}

class {$data['control']} extends Common{
    /**
     * [index 默认方法]
     */
    public function index(){
        return 'this is {$data['control']}/index';
    }
}
C;
        // ------------------------- end ---------------------------
        $fname = APP_PATH . $data['module'] . '/controller/' . $data['control'] . '.php';
        if (!is_dir(dirname($fname))) {
            mkdir(dirname($fname), 0777, true);
        }
        $controller = str_replace('@eval("//Encode by  phpjiami.com,Free user.");', '', $controller);
        file_put_contents($fname, $controller);
    }
    // _createEmptyControl end
    /**
     * [_createDiy 创建自定义配置]
     */
    private function _createDiyDeploy($data)
    {
        $pre = $this->pre;
        $db = config('database.database');
        // 判断数据表是否存在
        $has_table = db()->query("select * from information_schema.tables where table_name = '{$pre}{$data['table']}' AND TABLE_SCHEMA='{$db}'");
        if (!$has_table) {
            return false;
        }
        // 获取表的主键
        $pk = db()->query("select COLUMN_KEY,COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS \n
        					where table_name='{$pre}{$data['table']}' AND COLUMN_KEY='PRI' AND TABLE_SCHEMA='{$db}'");
        $pk = current($pk);
        // 生成自定义配置控制器控制器
        $controllerName = $this->_createDirController($data, $pk);
        // 生成自定义配置视图模板
        $this->_createDirViewTpl($data, $pk);
        return true;
    }
    // _createDiyDeploy end
    /**
     * [_createDefaultDeploy 创建默认配置]
     */
    private function _createDefaultDeploy($data)
    {
        $pre = $this->pre;
        $db = config('database.database');
        // 判断数据表是否存在
        $has_table = db()->query("select * from information_schema.tables where table_name = '{$pre}{$data['table']}' AND TABLE_SCHEMA='{$db}'");
        if (!$has_table) {
            return false;
        }
        // 获取表的字段
        $column = db()->query("select column_key,column_name,column_comment from INFORMATION_SCHEMA.COLUMNS \n                   where TABLE_SCHEMA='{$db}' AND  table_name='{$pre}{$data['table']}'");
        foreach ($column as $v) {
            // 获取主键
            if ($v['column_key'] == 'PRI') {
                $pk['COLUMN_NAME'] = $v['column_name'];
            } else {
                // 组合字段
                $data['column']['name'][$v['column_name']] = $v['column_comment'];
                $data['column']['val'][$v['column_name']] = '';
                $data['column']['rule'][$v['column_name']] = '*';
                $data['column']['type'][$v['column_name']] = 'text';
                $data['column']['add_rule'][$v['column_name']] = '';
            }
        }
        // 创建控制器
        $controllerName = $this->_createDirController($data, $pk);
        // 创建模版
        $this->_createDirViewTpl($data, $pk);
        return true;
    }
    // _createDefaultDeploy end
    /**
     * [_createDirController 生成自定义配置控制器控制器]
     */
    private function _createDirController($data, $pk)
    {
        $_time = date('Y-m-d H:i:s');
        $pre = $this->pre;
        // 解析方法
        $data['method'] = json_decode($data['method'], true);
        // 创建模型
        $modelName = $this->_createModel($data, $pk['COLUMN_NAME']);
        // 创建方法
        $method = $this->_createAllMethod($data, $pk);
        // 创建自定义选择数据
        $checkVal = "[\n";
        $kg = '            ';
        foreach ($data['column']['val'] as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $checkVal .= "{$kg}'{$k}Val' => [\n";
            // 拆分数据
            $tmp = explode(',', $v);
            foreach ($tmp as $val) {
                $val = explode('-', $val);
                $checkVal .= "{$kg}    '{$val[1]}' => '{$val[0]}',\n";
            }
            $checkVal .= "            ],\n";
        }
        $checkVal .= "        ];";
        // 命名空间处理
        $namespace = 'namespace app\\' . str_replace('/', '\\', $data['module']) . '\\controller; @eval("//Encode by  phpjiami.com,Free user."); ';
        $use = '';
        if ($data['module'] != 'admin/root') {
            $use = 'use app\\admin\\root\\controller\\Common;';
        }
        if ($data['model_local'] == 1) {
            $usemodel = 'use app\\common\\model\\' . $modelName . ' as model;';
        } else {
            $usemodel = 'use app\\' . str_replace('/', '\\', $data['module']) . '\\model\\' . $modelName . ' as model;';
        }
        // 生成控制器
        $controller = <<<C
<?php
/**
 * [{$data['name']}控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   {$_time}
 * @Copyright:
 */
{$namespace}
{$usemodel}
{$use}

class {$data['control']} extends Common{
    protected \$checkVal = []; @eval("//Encode by  phpjiami.com,Free user.");
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        \$this -> checkVal = {$checkVal}
    }
    {$method}
}
C;
        // 保存文件
        $fname = APP_PATH . $data['module'] . '/controller/' . $data['control'] . '.php';
        if (!is_dir(dirname($fname))) {
            mkdir(dirname($fname), 0777, true);
        }
        $controller = str_replace('@eval("//Encode by  phpjiami.com,Free user.");', '', $controller);
        file_put_contents($fname, $controller);
    }
    // _createDirController end
    /**
     * [_createDirViewTpl 创建自定义视图模板]
     */
    private function _createDirViewTpl($data, $pk)
    {
        // 驼峰命名转下滑线
        $controller = hump_to_underline($data['control']);
        // 创建目录
        $dir = APP_PATH . $data['module'] . '/view/' . $controller;
        is_dir($dir) || mkdir($dir, 0777, true);
        // 解析方法
        $data['method'] = json_decode($data['method'], true);
        $addTpl = $this->_createAddTpl($data, $pk);
        foreach ($data['method'] as $v) {
            // 创建列表模板
            if ($v['method'] == 'index') {
                $indexTpl = $this->_createIndexTpl($data, $pk);
                file_put_contents($dir . '/index.html', $indexTpl);
            }
            // 创建添加模板
            if ($v['method'] == 'add') {
                file_put_contents($dir . '/add.html', $addTpl['add_table']);
            }
            if ($v['method'] == 'edit') {
                file_put_contents($dir . '/edit.html', $addTpl['edit_table']);
            }
        }
    }
    // _createDirViewTpl end
    /**
     * [_createAddTpl 创建添加模板]
     */
    private function _createAddTpl($data, $pk)
    {
        $addTable = '';
        $editTable = '';
        $kg = '';
        $include = '';
        $script = '';
        // ------------- 自定义 -------------
        foreach ($data['column']['name'] as $k => $v) {
            // 去掉不需要添加的字段
            if (array_key_exists('no_add', $data['column']) && in_array($k, $data['column']['no_add'])) {
                continue;
            }
            // 验证规则处理
            if ($data['column']['rule'][$k] == 'norule') {
                $rule = '/^.*?$/';
            } elseif ($data['column']['rule'][$k] == 'money') {
                $rule = '/^(\\d{1,8}|\\d{1,8}\\.\\d{1,2})$/';
            } elseif ($data['column']['rule'][$k] == 'cn') {
                $rule = '/^[\\u2E80-\\u9FFF]+?$/';
            } elseif ($data['column']['rule'][$k] == 'm') {
                $rule = '/^1\\d{10}$/';
            } else {
                $rule = $data['column']['rule'][$k];
            }
            // 附加规则
            $addRule = $data['column']['add_rule'][$k];
            if (!empty($addRule)) {
                // 正则
                if ($rule == 'preg') {
                    $rule = $addRule;
                }
                // 长度
                if ($rule == 'n' || $rule == 's') {
                    $rule .= str_replace(',', '-', $addRule);
                }
                // 金额支持的小数位数
                if ($data['column']['rule'][$k] == 'money') {
                    $rule = '/^(\\d{1,8}|\\d{1,8}\\.\\d{1,' . $addRule . '})$/';
                }
                // 中文长度
                if ($data['column']['rule'][$k] == 'cn') {
                    $rule = '/^[\\u2E80-\\u9FFF]{' . str_replace('-', ',', $addRule) . '}$/';
                }
            }
            // 输入类型
            if ($data['column']['type'][$k] == 'text') {
                $addTable .= "{$kg}<tr>\n                <th width=\"150\" class=\"msg\">{$v}</th>\n                <td><input name=\"{$k}\" type=\"text\" class=\"form-control w400\" datatype=\"{$rule}\"></td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th width=\"150\" class=\"msg\">{$v}</th>\n                <td><input name=\"{$k}\" value=\"{\$data.{$k}}\" type=\"text\" class=\"form-control w400\" datatype=\"{$rule}\"></td>\n            </tr>\n";
                //                    continue;
            }
            // textarea文本框
            if ($data['column']['type'][$k] == 'textarea') {
                $addTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td><textarea name=\"{$k}\" datatype=\"{$rule}\"></textarea></td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td><textarea name=\"{$k}\" datatype=\"{$rule}\">{\$data.{$k}}</textarea></td>\n            </tr>\n";
                //                    continue;
            }
            // 密码框
            if ($data['column']['type'][$k] == 'password') {
                $addTable .= "{$kg}<tr>\n                <th width=\"150\" class=\"msg\">{$v}</th>\n                <td><input name=\"{$k}\" type=\"password\" class=\"form-control w400\" datatype=\"{$rule}\"></td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th width=\"150\" class=\"msg\">{$v}</th>\n                <td><input name=\"{$k}\" value=\"{\$data.{$k}}\" type=\"password\" class=\"form-control w400\" datatype=\"{$rule}\"></td>\n            </tr>\n";
                //                    continue;
            }
            // 多选
            if ($data['column']['type'][$k] == 'checkbox') {
                // 拆分重组数据
                $option = '';
                $option2 = '';
                $tval = $data['column']['val'][$k];
                $kg2 = '                        ';
                if (!empty($tval)) {
                    $option .= "<?php \$cnum = 0;?>\n";
                    $option2 .= "<?php \$cnum = 0;?>\n";
                    $option .= "                    {foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option2 .= "                    {foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option .= "                    {if (\$cnum == 0)}\n";
                    $option2 .= "                    {if (\$cnum == 0)}\n";
                    $option .= "{$kg2}<label class=\"checkbox-inline\">\n                            <input name=\"{$k}[]\" type=\"checkbox\" datatype=\"{$rule}\" value=\"{\$n}\"> {\$m}\n                            <u class=\"Validform_checktip\"></u>\n                        </label>\n";
                    $option2 .= "{$kg2}<label class=\"checkbox-inline\">\n                            <input type=\"checkbox\" name=\"{$k}[]\" value=\"{\$n}\" datatype=\"{$rule}\" " . "{if (in_array(\$n, \$data['{$k}']))} checked=\"checked\"{/if}> {\$m}\n                            <u class=\"Validform_checktip\"></u>\n                        </label>\n";
                    $option .= "                   {else/}\n";
                    $option2 .= "                   {else/}\n";
                    $option .= "{$kg2}<label class=\"checkbox-inline\">\n                            <input type=\"checkbox\" name=\"{$k}[]\" value=\"{\$n}\"> {\$m}\n                        </label>\n";
                    $option2 .= "{$kg2}<label class=\"checkbox-inline\">\n                            <input type=\"checkbox\" name=\"{$k}[]\" value=\"{\$n}\" {if (in_array(\$n, \$data['{$k}']))} checked=\"checked\"{/if}> {\$m}\n                        </label>\n";
                    $option .= "                    {/if}\n";
                    $option2 .= "                    {/if}\n";
                }
                $option .= "                    <?php \$cnum = 1;?>\n";
                $option2 .= "                    <?php \$cnum = 1;?>\n";
                $option .= "                    {/foreach}";
                $option2 .= "                    {/foreach}";
                $addTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    {$option}\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    {$option2}\n                </td>\n            </tr>\n";
                //                    continue;
            }
            // 单选
            if ($data['column']['type'][$k] == 'radio') {
                // 拆分重组数据
                $option = '';
                $option2 = '';
                $kg2 = '                        ';
                $tval = $data['column']['val'][$k];
                if (!empty($tval)) {
                    $option .= "<?php \$cnum = 0;?>\n";
                    $option2 .= "<?php \$cnum = 0;?>\n";
                    $option .= "                    {foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option2 .= "                    {foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option .= "                    {if (\$cnum == 0)}\n";
                    $option2 .= "                    {if (\$cnum == 0)}\n";
                    $option .= "{$kg2}<label class=\"radio-inline\">\n                            <input type=\"radio\" name=\"{$k}\" value=\"{\$n}\" datatype=\"{$rule}\"> {\$m}\n                            <u class=\"Validform_checktip\"></u>\n                        </label>\n";
                    $option2 .= "{$kg2}<label class=\"radio-inline\">\n                            <input type=\"radio\" name=\"{$k}\" value=\"{\$n}\" datatype=\"{$rule}\" " . "{if (\$data['{$k}'] == \$n)} checked=\"checked\"{/if}> {\$m}\n                            <u class=\"Validform_checktip\"></u>\n                        </label>\n";
                    $option .= "                   {else/}\n";
                    $option2 .= "                   {else/}\n";
                    $option .= "{$kg2}<label class=\"radio-inline\">\n                            <input type=\"radio\" name=\"{$k}\" value=\"{\$n}\"> {\$m}\n                        </label>\n";
                    $option2 .= "{$kg2}<label class=\"radio-inline\">\n                            <input type=\"radio\" name=\"{$k}\" value=\"{\$n}\" {if (\$data['{$k}'] == \$n)} checked=\"checked\"{/if}> {\$m}\n                        </label>\n";
                    $option .= "                    {/if}\n";
                    $option2 .= "                    {/if}\n";
                    $option .= "                    <?php \$cnum = 1;?>\n";
                    $option2 .= "                    <?php \$cnum = 1;?>\n";
                    $option .= "                    {/foreach}";
                    $option2 .= "                    {/foreach}";
                }
                $addTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    {$option}\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    {$option2}\n                </td>\n            </tr>\n";
                //                    continue;
            }
            // select下拉选择
            if ($data['column']['type'][$k] == 'select') {
                // 拆分重组数据
                $option = '';
                $option2 = '';
                $kg2 = '                            ';
                $tval = $data['column']['val'][$k];
                if (!empty($tval)) {
                    $option .= "{foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option2 .= "{foreach \$checkVal['{$k}Val'] AS \$n => \$m}\n";
                    $option .= "{$kg2}<option value=\"{\$n}\">{\$m}</option>\n";
                    $option2 .= "{$kg2}<option value=\"{\$n}\" " . "{if \$data['{$k}'] == \$n} selected=\"selected\"{/if}>{\$m}</option>\n";
                    $option .= "                        {/foreach}";
                    $option2 .= "                        {/foreach}";
                }
                $addTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    <select name=\"{$k}\" class=\"form-control w426\" datatype=\"{$rule}\">\n                        {$option}\n                    </select>\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class=\"msg\">{$v}</th>\n                <td>\n                    <select name=\"{$k}\" class=\"form-control w426\" datatype=\"{$rule}\">\n                        {$option2}\n                    </select>\n                </td>\n            </tr>\n";
                //                    continue;
            }
            //  时间选择器
            if ($data['column']['type'][$k] == 'time') {
                $addTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <input type=\"text\" id=\"time-{$k}\" name=\"{$k}\" class=\"date-plugin form-control w200\" value=\"\" placeholder=\"选择日期\" datatype=\"{$rule}\">\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <input type=\"text\" id=\"time-{$k}\" name=\"{$k}\" class=\"date-plugin form-control w200\" value=\"{\$data.{$k}}\" placeholder=\"选择日期\" datatype=\"{$rule}\">\n                </td>\n            </tr>\n";
                $includeTime = 1;
                $script .= "\$('#time-{$k}').datetimepicker({\n    format: 'yyyy-mm-dd',\n    language:'zh-CN',\n    minView:2,\n    autoclose:true\n});\n\n";
            }
            // 单图上传
            if ($data['column']['type'][$k] == 'img') {
                $addTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <div id=\"{$k}-picker\">上传图片</div>\n                    <div id=\"{$k}-list\" class=\"uploader-list\">\n                        <div class=\"upload-ts\">\n                            <input type=\"hidden\" name=\"{$k}\" value=\"\" datatype=\"{$rule}\" nullmsg=\"请上传图片\">\n                            <span class=\"Validform_checktip\"></span>\n                        </div>\n                    </div>\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <div id=\"{$k}-picker\">上传图片</div>\n                    <div id=\"{$k}-list\" class=\"uploader-list\">\n                        <div class=\"upimg-box upload-ts\">\n                            <span class=\"glyphicon glyphicon-remove-sign remove-img\"></span>\n                            <input type=\"hidden\" name=\"{$k}\" value=\"{\$data.{$k}}\" datatype=\"{$rule}\" nullmsg=\"请上传图片\">\n                            <img src=\"{\$data.{$k}}\" style=\"max-width:200px;\">\n                            <span class=\"Validform_checktip\"></span>\n                        </div>\n                    </div>\n                </td>\n            </tr>\n";
                $includeImg = 1;
                $script .= "file_upload({\n    pick        : '#{$k}-picker',\n    container   : '#{$k}-list',\n    server      : '{:url(\"admin/root/upload/upload\")}',\n    mulit       : false,\n    inputname   : '{$k}'\n});\n\n";
            }
            // 多图上传
            if ($data['column']['type'][$k] == 'img_more') {
                $addTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <div id=\"{$k}-picker\">上传图片</div>\n                    <div id=\"{$k}-list\" class=\"uploader-list\">\n                        <div class=\"upload-ts\">\n                            <input type=\"hidden\" name=\"{$k}[]\" value=\"\" datatype=\"{$rule}\" nullmsg=\"请上传图片\">\n                            <span class=\"Validform_checktip\"></span>\n                        </div>\n                    </div>\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <div id=\"{$k}-picker\">上传图片</div>\n                    <div id=\"{$k}-list\" class=\"uploader-list\">\n                    \n                    {if (!empty(\$data['{$k}']))}\n                    {foreach \$data['{$k}'] AS \$k => \$v}\n                        {if \$k == 0}\n                            <div class=\"upimg-box upload-ts no-remove\">\n                                <span class=\"glyphicon glyphicon-remove-sign remove-img\"></span>\n                                <input type=\"hidden\" name=\"{$k}[]\" value=\"{\$v}\" datatype=\"*\" nullmsg=\"请上传图片\">\n                                <img src=\"{\$v}\" style=\"max-width:200px;\">\n                                <span class=\"Validform_checktip\"></span>\n                            </div>\n                        {else}\n                            <div class=\"upimg-box\">\n                                <span class=\"glyphicon glyphicon-remove-sign remove-img\"></span>\n                                <input type=\"hidden\" name=\"{$k}[]\" value=\"{\$v}\">\n                                <img src=\"{\$v}\" style=\"max-width:200px;\">\n                            </div>\n                        {/if}\n                    {/foreach}\n                    {else/}\n                        <div class=\"upload-ts\">\n                            <input type=\"hidden\" name=\"{$k}[]\" value=\"\" datatype=\"{$rule}\" nullmsg=\"请上传图片\">\n                            <span class=\"Validform_checktip\"></span>\n                        </div>\n                    {/if}\n                    </div>\n                </td>\n            </tr>\n";
                $includeImg = 1;
                $script .= "file_upload({\n    pick        : '#{$k}-picker',\n    container   : '#{$k}-list',\n    server      : '{:url(\"admin/root/upload/upload\")}',\n    mulit       : true,\n    inputname   : '{$k}[]'\n});\n\n";
            }
            // 编辑器
            if ($data['column']['type'][$k] == 'editor') {
                $addTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <textarea name=\"{$k}\" style=\"width:800px;height:400px;\" datatype=\"{$rule}\" id=\"{$k}Editor\"></textarea>\n                </td>\n            </tr>\n";
                $editTable .= "{$kg}<tr>\n                <th class='msg'>{$v}</th>\n                <td>\n                    <textarea name=\"{$k}\" style=\"width:600px;height:300px;\" datatype=\"{$rule}\" id=\"{$k}Editor\">{\$data.{$k}}</textarea>\n                </td>\n            </tr>\n";
                $includeEditor = 1;
                $script .= "setTimeout(function(){\n        UE.getEditor('{$k}Editor', {\n            autoHeight: false,\n        });\n    },500);\n\n";
            }
            $kg = '            ';
        }
        //  是否载入上传图片
        if (!empty($includeImg)) {
            $include .= "{include file=\"admin/root/common/webuploader\"}\n";
        }
        // 是否载入编辑器
        if (!empty($includeEditor)) {
            $include .= "{include file=\"admin/root/common/ueditor\"}\n";
        }
        // 是否载入时间选择器
        if (!empty($includeTime)) {
            $include .= "{include file=\"admin/root/common/dateplugin\"}\n";
        }
        $add_table = <<<T
{include file="admin/root/common/header"}
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            {$addTable}
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">Save Change</button></td>
            </tr>
        </table>
    </form>
</div>
{$include}
<script>
\$(function(){
    {$script}
})
</script>
{include file="admin/root/common/footer"}
T;
        $edit_table = <<<T
{include file="admin/root/common/header"}
<div id="right_content">
    <form action="" class="verify-form rform">
        <table class="table">
            <tr>
                <td width="150"></td>
                <td></td>
            </tr>
            {$editTable}
            <tr>
                <td>
                    <input name="{$pk['COLUMN_NAME']}" type="hidden" value="{\$data.{$pk['COLUMN_NAME']}}">
                </td>
                <td><button type="submit" class="btn btn-success">Save Change</button></td>
            </tr>
        </table>
    </form>
</div>
{$include}
<script>
{$script}
</script>
{include file="admin/root/common/footer"}
T;
        return ['add_table' => $add_table, 'edit_table' => $edit_table];
    }
    // _createAddTpl end
    /**
     * [_createIndexTpl 创建列表模板]
     */
    private function _createIndexTpl($data, $pk)
    {
        $menu = '';
        $operation = '';
        foreach ($data['method'] as $v) {
            if ($v['method'] == 'index') {
                // 头部菜单-列表
                $menu .= '<li><a href="#" class="this">数据列表</a></li>' . "\n";
            }
            if ($v['method'] == 'add') {
                // 头部菜单-添加
                $menu .= '        <li>
            <a
                href="{:url(\'add\')}" target="frame_dispose"
                onclick="open_frame(\'添加\', 100, 100, true);">
                添加数据
            </a>
        </li>' . "\n";
            }
            if ($v['method'] == 'edit') {
                $operation .= '<a href="{:url(\'edit\',[\'' . $pk['COLUMN_NAME'] . '\'=>$v[\'' . $pk['COLUMN_NAME'] . '\']])}" target="frame_dispose"
                        onclick="open_frame(\'修改数据\', 100, 100, true)"
                        class="glyphicon glyphicon-edit" title="编辑"></a>' . "\n";
            }
            if ($v['method'] == 'del') {
                $operation .= '<a class="glyphicon glyphicon-trash"
                        onclick="ajax_post(\'{:url(\'del\')}\',{\'id\':{$v[\'' . $pk['COLUMN_NAME'] . '\']}});" title="删除"></a>' . "\n";
            }
        }
        // 是否分页
        $page = $data['is_page'] == 1 ? '{$page}' : '';
        if (!empty($this->vcolumn)) {
            $data['column']['name'] = $this->vcolumn;
        }
        // 是否是多表关联查询
        // $data['column']['name'] = array_merge($this -> vcolumn, $data['column']['name']);
        // 组合表格
        $kg1 = '';
        $kg2 = '';
        $th = '';
        $td = '';
        foreach ($data['column']['name'] as $k => $v) {
            // 去掉不需要显示的
            if (!empty($data['column']['no_show']) && in_array($k, $data['column']['no_show'])) {
                continue;
            }
            // 表格头部
            $th .= "{$kg1}<th>{$v}</th>\n";
            if (array_key_exists($k, $data['column']['type'])) {
                if ($data['column']['type'][$k] == 'img') {
                    // 单图处理
                    $td .= "{$kg2}<td><img src='{\$v.{$k}}' style='max-width:100px;'></td>\n";
                } else {
                    if ($data['column']['type'][$k] == 'img_more') {
                        // 多图处理
                        $td .= "{$kg2}<td>\n                        {foreach \$v['{$k}'] AS \$val}\n                            <img src='{\$val}' style='max-width:100px;'>\n                        {/foreach}\n                        </td>\n";
                    } else {
                        if (in_array($data['column']['type'][$k], ['select', 'radio'])) {
                            // 下拉框,单选处理
                            $td .= "{$kg2}<td>\n                        {if (!empty(\$checkVal['{$k}Val'][\$v['{$k}']]))}\n                            {\$checkVal['{$k}Val'][\$v['{$k}']]}\n                        {/if}\n                    </td>\n";
                        } else {
                            if ($data['column']['type'][$k] == 'checkbox') {
                                // 多选处理
                                $td .= "{$kg2}<td>\n                        {foreach \$v['{$k}'] AS \$val}\n                            {if (!empty(\$checkVal['{$k}Val'][\$val]))}\n                            {\$checkVal['{$k}Val'][\$val]},\n                            {/if}\n                        {/foreach}\n                        </td>\n";
                            } else {
                                // 其他处理
                                if ($k == $data['column']['settime']['add'] || $k == $data['column']['settime']['update']) {
                                    $td .= "{$kg2}<td>{\$v.{$k} ? date('Y-m-d H:i:s', \$v.{$k}) : '----'}</td>\n";
                                } else {
                                    $td .= "{$kg2}<td>{\$v.{$k}}</td>\n";
                                }
                            }
                        }
                    }
                }
            } else {
                $td .= "{$kg2}<td>{\$v.{$k}}</td>\n";
            }
            $kg1 = '                ';
            $kg2 = '                    ';
        }
        // 搜索提示
        $placeholder = '关键词';
        if (!empty($data['column']['search'])) {
            $placeholder = '';
            $dh = '';
            foreach ($data['column']['search'] as $v) {
                $placeholder .= $dh . $data['column']['name'][$v];
                $dh = '/';
            }
        }
        // 创建模板
        $tpl = <<<T
{include file="admin/root/common/header"}
<div id="right_content">
    <div class="top-info">
        <i class="glyphicon glyphicon-home"></i>
        {$data['name']}
    </div>

    <!-- 菜单 -->
    <ul class="clearfix menu">
        {$menu}
    </ul>

    <div class="table-box">
        <div class="table-header clearfix">
            <div class="all-operation fl clearfix">
                <button type="button" class="btn btn-danger btn-sm"
                onclick="all_operation('{:url('del')}','{$pk['COLUMN_NAME']}[]');">
                    删除<i class="glyphicon glyphicon-trash ml5"></i>
                </button>
            </div>
            <form action="" method="get" class="clearfix fr">
                <input type="text" value="{\$keywords}" name="keywords" class="form-control search-in" placeholder="{$placeholder}">
                <button onclick="loding();" type="submit" class="btn btn-info btn-sm fl">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>

        <table class="table">
            <tr>
                <th width="20">
                    <input onclick="check_all('{$pk['COLUMN_NAME']}[]');" name="check_all" type="checkbox" value="">
                </th>
                {$th}
                <th width="100">操作</th>
            </tr>
            {if (!empty(\$data))}
            {foreach \$data AS \$v}
                <tr>
                    <td>
                        <input name="{$pk['COLUMN_NAME']}[]" type="checkbox" value="{\$v.{$pk['COLUMN_NAME']}}">
                    </td>
                    {$td}
                    <td class="operation">
                        {$operation}
                    </td>
                </tr>
            {/foreach}
            {/if}
        </table>
        <div>{$page}</div>
    </div>
</div>

<script type="text/javascript">

</script>
{include file="admin/root/common/footer"}
T;
        return $tpl;
    }
    // _createIndexTpl end
    /**
     * [_createAllMethod 创建所有方法]
     */
    private function _createAllMethod($data, $pk)
    {
        // 创建方法
        $method = '';
        foreach ($data['method'] as $v) {
            // 创建列表方法
            if ($v['method'] == 'index') {
                $method .= $this->_createMethodIndex($data);
            }
            // 创建添加方法
            if ($v['method'] == 'add') {
                $method .= $this->_createMethodAdd($data);
            }
            // 创建修改方法
            if ($v['method'] == 'edit') {
                $method .= $this->_createMethodEdit($data, $pk['COLUMN_NAME']);
            }
            // 创建删除方法
            if ($v['method'] == 'del') {
                $method .= $this->_createMethodDel($data, $pk['COLUMN_NAME']);
            }
        }
        return $method;
    }
    /**
     * [_createModel 创建模型]
     */
    private function _createModel($data, $pk)
    {
        $_time = date('Y-m-d H:i:s');
        // 模型首字母大写
        $mname = underline_to_hump($data['table']);
        // 自定义规则时 -> 创建验证规则
        if ($data['tpl_type'] == 2) {
            $verifyRule = $this->_createVerifyRule($data['column']);
        } else {
            $verifyRule = ['rule' => '[]', 'message' => '[]'];
        }
        // 命名空间处理
        if ($data['model_local'] == 1) {
            $namespace = 'app\\common\\model; @eval("//Encode by  phpjiami.com,Free user."); ';
            $use = '';
            $mp = 'common/model/';
        } else {
            $namespace = 'app\\' . str_replace('/', '\\', $data['module']) . '\\model; @eval("//Encode by  phpjiami.com,Free user."); ';
            $use = 'use app\\common\\model\\CommonModel;';
            $mp = $data['module'] . '/model/';
        }
        $model = <<<M
<?php
/**
 * [{$data['name']}模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   {$_time}
 * @Copyright:
 */
namespace {$namespace}
use think\\Validate; @eval("//Encode by  phpjiami.com,Free user.");
{$use}

class {$mname} extends CommonModel{
    public \$err;
    public \$data;
    public \$pk = '{$pk}';

    /**
     * [checkData 验证数据]
     */
    public function checkData(\$data, \$noverify = []){
        // 验证规则
        \$rule = {$verifyRule['rule']};

        // 去除不需要验证的字段
        if (!empty(\$noverify)) {
            foreach (\$noverify as \$v) {
                unset(\$rule[\$v]);
            }
        }

        // 错误提示
        \$message = {$verifyRule['message']};

        // 创建验证
        if (!empty(\$rule) && !empty(\$message)) {
            // 创建验证规则
            \$validate = new Validate(\$rule, \$message);
            // 执行验证
            if (!\$validate -> check(\$data)) {
                // 保存错误信息
                \$this -> err = \$validate -> getError();
                return false;
            }
        }

        // 保存验证过的数据
        \$this -> data = \$data;
        return true;
    }
}
M;
        $fname = APP_PATH . $mp . $mname . '.php';
        if (!is_dir(dirname($fname))) {
            mkdir(dirname($fname), 0777, true);
        }
        // 保存模型
        if (!is_file($fname)) {
            $model = str_replace('@eval("//Encode by  phpjiami.com,Free user.");', '', $model);
            file_put_contents($fname, $model);
        }
        return $mname;
    }
    // _createModel end
    /**
     * [_createVerifyRule 创建模型验证规则]
     */
    private function _createVerifyRule($data)
    {
        $rule = [];
        $message = [];
        foreach ($data['name'] as $k => $v) {
            // 必须验证
            if ($data['rule'][$k] == '*') {
                $rule[$k] = 'require';
            }
            // 验证数字
            if ($data['rule'][$k] == 'n') {
                $valid = 'require|number';
                // 是否有附加规则
                if (!empty($data['add_rule'][$k])) {
                    $adr = str_replace('-', ',', $data['add_rule'][$k]);
                    $valid .= "|length:{$adr}";
                    $message[$k . '.length'] = '请填写正确长度的' . $v;
                }
                $rule[$k] = $valid;
                $message[$k . '.number'] = '请填写正确的' . $v;
            }
            // 验证正则
            if ($data['rule'][$k] == 'preg') {
                $rule[$k] = "['require', 'regex' => '{$data['add_rule'][$k]}']";
                $message[$k . '.regex'] = '请填写正确的' . $v;
            }
            // 验证字符串
            if ($data['rule'][$k] == 's') {
                // 是否有附加规则
                if (!empty($data['add_rule'][$k])) {
                    $adr = str_replace('-', ',', $data['add_rule'][$k]);
                    $valid = "require|length:{$adr}";
                    $message[$k . '.length'] = '请填写正确长度的' . $v;
                } else {
                    $valid = 'require';
                }
                $rule[$k] = $valid;
            }
            // 验证邮编
            if ($data['rule'][$k] == 'p') {
                $rule[$k] = 'require|number|length:6';
                $message[$k . '.number'] = '请填写正确的' . $v;
                $message[$k . '.length'] = '请填写正确长度的' . $v;
            }
            // 验证手机号
            if ($data['rule'][$k] == 'm') {
                $rule[$k] = "['require', 'regex' => '/^1[0-9]{10}\$/']";
                $message[$k . '.regex'] = '请填写正确的' . $v;
            }
            // 验证邮箱
            if ($data['rule'][$k] == 'e') {
                $rule[$k] = 'require|email';
                $message[$k . '.email'] = '请填写正确的' . $v;
            }
            // 验证网址
            if ($data['rule'][$k] == 'url') {
                $rule[$k] = 'require|url';
                $message[$k . '.url'] = '请填写正确的' . $v;
            }
            // 验证金额
            if ($data['rule'][$k] == 'money') {
                $rule[$k] = "['require', 'regex' => '/^(\\d{1,8}|\\d{1,8}\\.\\d{1,2})\$/']";
                // 金额支持的小数位数
                if (!empty($data['add_rule'][$k])) {
                    $rule[$k] = "['require', 'regex' => '/^(\\d{1,8}|\\d{1,8}\\.\\d{1," . $data['add_rule'][$k] . "})\$/']";
                }
                $message[$k . '.regex'] = '请填写正确的' . $v;
            }
            // 验证正文
            if ($data['rule'][$k] == 'cn') {
                $rule[$k] = "['require', 'regex' => '/^[\\u2E80-\\u9FFF]+?\$/']";
                $message[$k . '.regex'] = '请填写正确的' . $v;
                // 中文长度
                if (!empty($data['add_rule'][$k])) {
                    $rule[$k] = "['require', 'regex' => '/^[\\u2E80-\\u9FFF]{" . str_replace(',', '-', $data['add_rule'][$k]) . "}\$/']";
                    $message[$k . '.regex'] = '请填写正确长度的' . $v;
                }
            }
            // 错误提示
            $message[$k . '.require'] = '请填写' . $v;
        }
        // 规则组合为可写字符串
        $rulestr = "[\n";
        foreach ($rule as $k => $v) {
            if ($v[0] == '[' && $v[strlen($v) - 1] == ']') {
                $rulestr .= "            '{$k}' => {$v},\n";
            } else {
                $rulestr .= "            '{$k}' => '{$v}',\n";
            }
        }
        $rulestr .= "       ]";
        // 提示信息组合为可写字符串
        $messagestr = "[\n";
        foreach ($message as $k => $v) {
            $messagestr .= "            '{$k}' => '{$v}',\n";
        }
        $messagestr .= "        ]";
        return ['rule' => $rulestr, 'message' => $messagestr];
    }
    // _createVerifyRule end
    /**
     * [_createMethodIndex 创建方法-列表]
     */
    private function _createMethodIndex($data)
    {
        $cfimg = '';
        if ($data['tpl_type'] == 2) {
            // 是否需要拆分图片
            if ($data['is_page'] == 1) {
                $cfimg = "if (!empty(\$data['data'])) {\n            foreach(\$data['data'] AS \$k => \$v){\n";
            } else {
                $cfimg = "if (!empty(\$data)) {\n            foreach(\$data AS \$k => \$v){\n";
            }
            $iscf = 0;
            foreach ($data['column']['type'] as $k => $v) {
                if ($v != 'img_more' && $v != 'checkbox') {
                    continue;
                }
                if ($data['is_page'] == 1) {
                    $cfimg .= "                \$data['data'][\$k]['{$k}'] = explode(',', \$v['{$k}']);\n";
                } else {
                    $cfimg .= "                \$data[\$k]['{$k}'] = explode(',', \$v['{$k}']);\n";
                }
                $iscf = 1;
            }
            $cfimg .= "            }\n        }";
            if ($iscf == 0) {
                $cfimg = '';
            }
        }
        // 搜索配置
        $swhere = '';
        if (!empty($data['column']['search'])) {
            $swhere = "\$where['";
            $sh = '';
            foreach ($data['column']['search'] as $v) {
                $swhere .= $sh . $v;
                $sh = '|';
            }
            $swhere .= "'] = ['like', \"%{\$keywords}%\"]";
        }
        // 是否多表关联查询
        if (!empty($this->vname)) {
            // 是否分页
            if ($data['is_page'] == 0) {
                // 不分页处理
                $cdata = "    // 获取视图数据\n        \$where = '';\n        if (!empty(\$keywords)) {\n            {$swhere};\n        }\n        \$data = db('{$this->vname}') -> where(\$where) -> select();";
            } else {
                // 分页处理
                $cdata = "    // 获取视图数据\n        \$where = '';\n        if (!empty(\$keywords)) {\n            {$swhere};\n        }\n        \$data = admin_page(db('{$this->vname}'), \$where);";
            }
        } else {
            // 是否分页
            if ($data['is_page'] == 0) {
                $cdata = "    //实例化模型\n        \$model = new model;\n        \$where = '';\n        if (!empty(\$keywords)) {\n            {$swhere};\n        }\n        // 获取数据\n        \$data  = \$model -> getAll(\$where);";
            } else {
                $cdata = "    //实例化模型\n        \$model = new model;\n        \$where = '';\n        if (!empty(\$keywords)) {\n            {$swhere};\n        }\n        // 获取数据\n        \$data  = admin_page(\$model, \$where);";
            }
        }
        // 组合返回数据
        if ($data['is_page'] == 0) {
            $return = "return view('',[\n            'data'      => \$data,\n            'keywords'  => \$keywords,\n            'checkVal'  => \$this -> checkVal\n        ]);";
        } else {
            $return = "return view('',[\n            'data'      => \$data['data'],\n            'page'      => \$data['page'],\n            'keywords'  => \$keywords,\n            'checkVal'  => \$this -> checkVal\n        ]);";
        }
        $method = <<<M
/**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        \$keywords = input('get.keywords');
    {$cdata}
        {$cfimg}
        // 模板
        {$return}
    }


M;
        return $method;
    }
    // _createMethodIndex end
    /**
     * [_createMethodAdd 创建添加方法]
     */
    private function _createMethodAdd($data)
    {
        // 是否需要组合数据
        $zhimg = '';
        $kg = '';
        foreach ($data['column']['type'] as $k => $v) {
            if ($v != 'img_more' && $v != 'checkbox') {
                continue;
            }
            $zhimg .= "{$kg}\$data['{$k}'] = implode(',', \$data['{$k}']);\n";
            $kg = '            ';
        }
        // 是否有更新不需要添加的字段
        if (!empty($data['column']['no_add'])) {
            $noRule = '[';
            $d = '';
            foreach ($data['column']['no_add'] as $v) {
                $noRule .= $d . "'" . $v . "'";
                $d = ',';
            }
            $noRule .= ']';
        } else {
            $noRule = '[]';
        }
        // 是否需要自动写入时间戳
        $set_addtime = '';
        if (!empty($data['column']['settime']['add'])) {
            $set_addtime = "\$data['{$data['column']['settime']['add']}'] = time();";
        }
        $method = <<<M
    /**
     * [add 添加数据]
     */
    public function add(){
        if (\$this -> isPost) {
            // 实例化模型
            \$model = new model;
            // 获取post数据
            \$data = input('post.');
            {$set_addtime}
            {$zhimg}
            // 验证
            if (!\$model -> checkData(\$data, {$noRule})) {
                return ajax(\$model -> err, 2);
            }
            // 添加数据
            if (!\$model -> addData()) return ajax('添加失败', 2);
            return ajax('添加成功');
        }

        return view('', [
            'checkVal'  => \$this -> checkVal
        ]);
    }


M;
        return $method;
    }
    // _createMethodAdd end
    /**
     * [_createMethodEdit 创建修改方法]
     */
    private function _createMethodEdit($data, $pk)
    {
        // 是否有更新不需要验证的字段
        if (!empty($data['column']['no_up_rule'])) {
            $noRule = '[';
            $d = '';
            foreach ($data['column']['no_up_rule'] as $v) {
                $noRule .= $d . "'" . $v . "'";
                $d = ',';
            }
            $noRule .= ']';
        } else {
            $noRule = '[]';
        }
        // 是否需要拆分图片
        $cfimg = "";
        $zhimg = '';
        $kg = '';
        foreach ($data['column']['type'] as $k => $v) {
            if ($v != 'img_more' && $v != 'checkbox') {
                continue;
            }
            $cfimg .= "{$kg}\$data['{$k}'] = explode(',', \$data['{$k}']);\n";
            $zhimg .= "{$kg}\$data['{$k}'] = implode(',', \$data['{$k}']);\n";
            $kg = '                ';
        }
        // 是否需要自动写入时间戳
        $set_updatetime = '';
        if (!empty($data['column']['settime']['update'])) {
            $set_updatetime = "\$data['{$data['column']['settime']['update']}'] = time();";
        }
        $method = <<<M
    /**
     * [edit 编辑]
     */
    public function edit(){
        \$model = new model;
        // POST提交处理
        if (\$this -> isPost) {
            // 获取post数据
            \$data = input('post.');
            {$set_updatetime}
            {$zhimg}
            // 验证
            if (!\$model -> checkData(\$data, {$noRule})) {
                return ajax(\$model -> err, 2);
            }
            // 修改数据
            if (!\$model -> editData(['{$pk}'=>\$data['{$pk}']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }

        // 获取旧数据
        \${$pk} = (int)\$this -> param['{$pk}'];
        \$data = \$model -> getOne(['{$pk}'=>\${$pk}]);
        {$cfimg}
        return view('',[
            'data'     => \$data,
            '{$pk}'    => \${$pk},
            'checkVal' => \$this -> checkVal
        ]);
    }


M;
        return $method;
    }
    // _createMethodEdit end
    /**
     * [_createMethodDel 创建删除方法]
     */
    private function _createMethodDel($data, $pk)
    {
        $method = <<<M
    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        \$model = new model;
        if (!\$this -> isPost) return ajax('非法请求');
        // 定义条件
        \${$pk} = \$this -> param['id'];
        // 可批量删除
        \$where['{$pk}'] = ['in', \${$pk}];
        if (!\$model -> delData(\$where)) return ajax('删除失败');
        return ajax('删除成功');
    }


M;
        return $method;
    }

    // _createMethodDel end
    //@Update by: dufei
    //@Date:   2018-06-28 19:59:42;
    //使用授权控制函数
    private function _checkAccess()
    {
        $a = file_get_contents('http://zpfbasic.zpftech.com/access.php');
        $a = json_decode($a, true);
        if (empty($a)) {
            return false;
        }
        return $a['status'];
    }
}
