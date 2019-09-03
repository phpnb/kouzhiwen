<?php
namespace app\admin\root\controller;
use app\admin\root\model\Admin;
use think\Session;
use think\Controller;
use app\admin\info\model\Enterprise;

class Login extends Controller{
    /**
     * [login 登陆]
     */
    public function login(){
        // 请求数据
        $request = request(); 
        // 判断是否为POST提交
        if ($request -> method() == 'POST') {
            // 请求参数
            $param = $request -> post();
            // 判断是否为空
            if (empty($param['username']) || empty($param['password'])) {
                return ajax('请输入用户名和密码', 2);
            }
            // 实例化模型
            $model = new Admin();

            // 登陆验证
            $admin = $model -> login($param);
            if (!$admin) return ajax($model -> errMsg,2);

            if($admin['enterprise_id']){
                $enterprisemodel = new Enterprise();
                $enterprise=$enterprisemodel->getOne(['id'=>$admin['enterprise_id']]);
                if($enterprise['status']==2){
                    return ajax('尊敬的管理员你好；你所属的企业已停用。', 2);
                }
            }
            Session::set('adminUser', $admin);
            $url = url("{$admin['module']}/index/index");

            return ajax('登录成功', 1, ['url'=>$url]);
        }
        return view();
    }

    /**
     * 修改密码
     * @return \think\response\View
     */
    public function editPwd(){
        // 用户信息
        $user = Session::get('adminUser');
        if (empty($user)) {
            $url = url('admin/root/login/login');
            echo "<script>window.parent.location.href='{$url}'</script>";
            die;
        }

        // 请求数据
        $request = request();
        // 判断是否为POST提交
        if ($request -> method() == 'POST') {
            // 请求参数
            $param = $request -> post();
            // 判断旧密码是否正确
            if (md5(md5($param['old_pwd'])) != $user['password']) {
                return ajax('旧密码不正确', 2);
            }
            db('admin') -> where(['aid'=>$user['aid']]) -> update([
                'password' => md5(md5($param['new_pwd']))
            ]);
            return ajax('修改成功');
        }
        return view();
    }

    /**
     * [loginOut 退出登录]
     */
    public function loginOut(){
        Session::set('adminUser', null);
        $this -> redirect(url('admin/root/login/login'));
    }
}
