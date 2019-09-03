<?php
/**
 * [模块管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-08-03 13:53:39
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\model\Admin;

class Module extends Common{
    /**
     * [index 默认方法]
     */
    public function index(){

        // 获取权限组
        $tmp = db('access_group') -> field('id,name') -> select() -> toArray();
        $group = [];
        foreach ($tmp AS $v) {
            $group[$v['id']] = $v;
        }

        // 获取模块
        $module = scandir(APP_PATH . 'admin');
        $admin_model = new Admin;
        foreach ($module AS $k => $v) {
            if (strstr($v, '.')) {
                unset($module[$k]);
            } else {
                $module[$k] = [
                    'name'  => $v,
                    'user'  => $admin_model -> where(['module'=>'admin/'.$v]) -> select() -> toArray()
                ];
            }
        }

        return view('', [
            'data'  => $module,
            'group' => $group
        ]);
    }

    /**
     * 初始化模块
     * @return \think\response\View
     */
    public function add(){
        if ($this -> isPost) {
            $name = input('post.name');
            $path = APP_PATH . 'admin/' . $name;
            if (is_dir($path)) return ajax('模块已存在', 2);
            // 创建模块文件夹
            mkdir($path . '/controller', 0777, true);
            mkdir($path . '/model', 0777, true);
            mkdir($path . '/view', 0777, true);
            // 创建初始化文件
            $this -> _createInitFile($name);
            return ajax('初始化完成');
        }

        return view();
    }

    /**
     * 创建初始化文件
     * @param $name
     */
    private function _createInitFile($name){
        // 定义内容
        $content = <<<C
<?php
/**
 * []
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\admin\\{$name}\controller;
use app\admin\\root\controller\Common;

class Index extends Common{
    /**
     * 后台首页
     * @return \\think\\response\View
     */
    public function index(){
        \$index = new \app\admin\\root\controller\Index();
        \$show = \$index -> index();
        return \$show;
    }

    /**
     * welcome
     * @return string
     */
    public function welcome(){
        return 'this is {$name} / welcome';
    }
}
C;
        $fname = APP_PATH . 'admin/' . $name . '/controller/Index.php';
        file_put_contents($fname, $content);
    }
}