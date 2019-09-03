<?php
namespace app\teacher\root\controller;
use app\teacher\root\model\Teacher;
use app\admin\info\model\Teacher as model;
use app\common\extend\Rongcloudapi;
use think\Session;
use think\Controller;
use think\Db;
use app\common\model\Enterprise;

class Login extends Controller{

    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();

        $this -> checkVal = [
            'sexVal'=>['1'=>'男','2'=>'女'],
            'identityVal'=>['1'=>'教师','2'=>'班主任','3'=>'专家'],
            'is_recommendVal'=>['0'=>'否','1'=>'是'],

        ];
    }

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
            $model = new Teacher();
            // 登陆验证
            $admin = $model -> login($param);
            if (!$admin) return ajax($model -> errMsg,2);
            if($admin['enterprise_id']){
                $enterprisemodel = new Enterprise();
                $enterprise=$enterprisemodel->getOne(['id'=>$admin['enterprise_id']]);
                if($enterprise['status']==2){
                    return ajax('尊敬的老师你好；你所属的企业已停用。', 2);
                }
            }
            if(strpos($admin['identity']."aa",'1') !== false){
                $admin['jiaoshi'] = 1;
            }

            if(strpos($admin['identity']."aa",'2') !== false){
                $admin['zhuren'] = 1;
            }

            Session::set('teacherUser', $admin);
            $url = url("teacher/root/index/index");
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
        $user = Session::get('teacherUser');
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
            db('teacher') -> where(['id'=>$user['id']]) -> update([
                'password' => md5(md5($param['new_pwd']))
            ]);
            return ajax('修改成功');
        }
        return view();
    }

    /**
    *修改资料
    **/
    public function updetail(){
        $user = Session::get('teacherUser');
        if (empty($user)) {
            $url = url('teacher/root/login/login');
            echo "<script>window.parent.location.href='{$url}'</script>";
            die;
        }
        // 判断是否为POST提交
        $data = input('post.');

        if (!empty($data)) {
            $model = new model;
            if(!empty($data['password'])){
                $data['password'] = md5(md5($data['password']));
            }else{
                unset($data['password']);
            }
            $teacher= db('teacher') -> where(['id'=>$user['id']]) ->find();
            if($teacher['status'==0]){
                return ajax('没有此老师', 2);
            }
            if($teacher['identity']!=2){
                $data['status']=2;
            }

            $data['updated_at']=time();

            $oldData = $model -> where(['username'=>$data['username'],'id'=>['not in',$user['id']]]) -> find();
            if ($oldData) {
                return ajax('用户名已存在', 2);
            }
            $check=['id','enterprise_id','classify_id','teacher_type','is_xszd','identity','password','group_id','logintime','loginip','consult_num'
                ,'status','created_at','updated_at','module'];
            // 验证
            if($teacher['identity']==2){
                $check[]='title';
                $check[]='phone';
                $check[]='brief';
            }
            $photo=empty($data['photo'])?"/uploads/default.png":$data['photo'];
            $name=empty($data['name'])?$data['username']:$data['name'];
            if(empty($teacher['rongcloud'])){
                $Rongcloud =new Rongcloudapi();
                $uid="t_".$user['id'];
                $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$photo;
                $rongdata=$Rongcloud->RongCloud->user()->getToken($uid, $name, $face);
                $rongdata=json_decode($rongdata);
                if($rongdata->code==200){
                    $data['rongcloud']=$rongdata->token;
                }
            }else{
                $Rongcloud =new Rongcloudapi();
                $uid="t_".$user['id'];
                $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$photo;
                $rongdata=$Rongcloud->RongCloud->user()->refresh($uid, $name, $face);
                $rongdata=json_decode($rongdata);
                if($rongdata->code!=200){
                    return ajax('更新数据失败', 2);
                }
            }

            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }


            // 请求参数
            if (!$model -> editData(['id'=>$user['id']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功',1);
        }
        $data = db('teacher') -> where(['id'=>$user['id']]) ->find();
        $data['identity'] = explode(',', $data['identity']);
        return view('',['data'=>$data,'checkVal'=>$this -> checkVal]);
    }
    /**
     * [loginOut 退出登录]
     */
    public function loginOut(){
        Session::set('teacherUser', null);
        $this -> redirect(url('teacher/root/login/login'));
    }
}
