<?php
/**
 * [应用中心控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-08-10 15:17:22
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\model\MenuCategory;

class AppCenter extends Common{
    /**
     * [index 默认方法]
     */
    public function index(){
        $web = $_SERVER['HTTP_HOST'];
        return view('', ['web'=>$web]);
    }

    /**
     * 下载 - 选择菜单模块
     * @return \think\response\View
     */
    public function download(){
        // 获取模块
        $module = scandir(APP_PATH . 'admin');
        foreach ($module AS $k => $v) {
            if (strstr($v, '.')) {
                unset($module[$k]);
            }
        }

        return view('', [
            'module'    => $module,
            'proof'     => $this -> param['proof']
        ]);
    }

    /**
     * 卸载模块
     */
    public function uninstall(){
        if ($this -> isPost) {
            $module = input('post.module');
            // 判断模块是否存在
            if (!is_dir(APP_PATH . $module)) {
                return ajax('模块不存在', 2);
            }
            // 配置文件是否存在
            $menu_file = APP_PATH . $module . '/install.php';
            if (!is_file($menu_file)) {
                return ajax('模块缺少配置文件，不能卸载', 2);
            }

            // 获取菜单
            $menu = include $menu_file;
            // 删除菜单
            if (!empty($menu)) {
                $this -> _deleteMenu($menu, $module);
            }

            // 删除sql
            $this -> _deleteSql($module);

            // 删除目录
            delete_dir(APP_PATH . $module);
            return ajax('卸载完成');
        }
    }

    /**
     * 安装模块
     */
    public function install(){
        // 脚本超时时间
        ini_set("max_execution_time", "1800");
        // 下载文件 - 获取主模块名称
        $name = $this -> _download($this -> param['proof']);
        // 创建菜单分类和菜单
        $top_module = $this -> param['top_module'];
        $this -> _createMenu($top_module, $name);

        // 导入SQL文件
        $this -> _executeSql($name);

        // 写入配置项
        $conffile= APP_PATH . 'config.php';
        $conf = file_get_contents($conffile);
        // 子模块处理
        preg_match_all('/\'has_child_module(.*?)],/', $conf, $new);
        $repl = str_replace('],', '', $new[0][0]) . ',\'cms\'],';
        $newconf = str_replace($new[0][0], $repl, $conf);
        file_put_contents($conffile, $newconf);

        // 进度提示
        echo    "<script>
                    document.getElementById('jyf').innerHTML='应用安装完成，请在后台配置菜单权限!';
                </script>";
        ob_flush();
        flush();
    }

    /**
     * 删除菜单
     * @param $menu
     * @param $module
     */
    private function _deleteMenu($menu, $module){
        $mcmodel = db('menu_category');
        // 删除菜单分类
        $mcmodel -> where(['app'=>$module]) -> delete();

        // 删除菜单
        $mmodel = db('menu');
        foreach ($menu AS $v) {
            $mmodel -> where(['module'=>$v['module']]) -> delete();
        }
    }

    /**
     * 删除SQL
     * @param $module
     */
    private function _deleteSql($module){
        $sql_file = APP_PATH . $module . '/install.sql';
        if (!is_file($sql_file)) return;
        // 获取SQL内容
        $sql = file_get_contents($sql_file);
        // 获取表名称
        preg_match_all('/CREATE.*?TABLE.*?`(.*?)`/is', $sql, $t);
        // 删除表
        $model = db();
        foreach ($t[1] AS $v) {
            $model -> execute("DROP TABLE IF EXISTS `{$v}`;");
        }
    }

    /**
     * 创建菜单
     * @param $top_module
     */
    private function _createMenu($top_module, $name){
        // 进度提示
        echo    "<script>
                    document.getElementById('jyf').innerHTML='正在创建菜单...';
                </script>";
        ob_flush();
        flush();
        sleep(1);

        // 加载模块配置
        $menu = include_once APP_PATH . $name . '/install.php';
        if (empty($menu)) {
            echo '模块配置文件不正确';die;
        }

        // 菜单分类模型
        $mcmodel = new MenuCategory;
        // 菜单模型
        $model = db('menu');

        foreach ($menu AS $v) {
            // 安装模块处理
            $module = $v['module'];
            $v['module'] = $top_module;
            $v['app'] = $name;

            $child = $v['child']; unset($v['child']);
            // 添加菜单分类
            $mcid = $mcmodel -> addData($v);
            // 添加菜单
            foreach ($child AS $val) {
                $val['mcid']   = $mcid;
                $val['module'] = $module;
                $model -> insert($val);
            }
        }
    }

    /**
     * 导入SQL
     * @param $name
     * @return bool
     */
    private function _executeSql($name){
        // 获取SQL文件
        $file = APP_PATH . $name . '/install.sql';
        if (!is_file($file)) return false;

        // 进度提示
        echo    "<script>
                    document.getElementById('jyf').innerHTML='正在导入SQL...';
                </script>";
        ob_flush();
        flush();
        sleep(1);

        $sql = file_get_contents($file);
        $conf = config('database');
        // 连接MYSQL
        $_mysqli = new \mysqli($conf['hostname'], $conf['username'], $conf['password'], $conf['database']);
        if (mysqli_connect_errno()) exit('连接数据库出错');
        // 设置字符集
        $charset = 'SET CHARACTER_SET_CLIENT=BINARY,CHARACTER_SET_CONNECTION=utf8,CHARACTER_SET_RESULTS=utf8';
        $_mysqli -> query($charset);

        // 拆分SQL
        $sql_arr = preg_split('/;(\r|\n)/s', $sql);
        // 执行SQL语句
        foreach ($sql_arr as $_value) {
            $_mysqli -> query($_value.';');
        }
        $_mysqli -> close();
        $_mysqli = null;
    }

    /**
     * 下载文件
     * @param $fname
     */
    private function _download($fname){
        // 进度提示
        $this -> _progress('下载中...');
        // 保存位置
        $save = RUNTIME_PATH . 'module_tmp.zip';
        // 下载文件
        $url = 'http://appcenter.zpftech.com/index/index/download?proof=' . $fname;
        curl_download($url, $save);
        // 下载完毕
        echo    "<script>
                    document.getElementById('xzz').innerHTML='下载完毕!';
                </script>";
        ob_flush();
        flush();
        // 解压
        $name = zip_extract($save, APP_PATH);

        // 是否有static目录
        $path = APP_PATH . $name . '/static/';
        if (is_dir($path)) {
            move_folder($path, ROOT_PATH . 'public/static/');
            delete_dir($path);
        }

        // 删除压缩包
        @unlink($save);
        return $name;
    }

    /**
     * 进度条
     */
    private function _progress($msg){
        echo '<link rel="stylesheet" href="/static/common/bootstrap/css/bootstrap.css">';
        echo '<link rel="stylesheet" href="/static/common/css/base.css">';
        echo '<style>html,body{background:#ECEFF1}</style>';
        echo '<div style="width:50%; margin-top:200px;" id="xzz" class="bc tc f20">'.$msg.'</div>';

        echo    '<div class="progress mt10 bc" style="width:50%;">
	              <div id="jd" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
	              	0%
	              </div>
	            </div>';
        ob_flush();
        flush();
    }
}