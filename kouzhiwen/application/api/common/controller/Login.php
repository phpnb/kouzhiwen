<?php
/**
 * [登录注册管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date: 2017/5/11
 * @Time: 上午11:09
 */
namespace app\api\common\controller;
use app\common\model\Code;
use app\common\model\User;
use app\common\model\Enterprise;
use app\common\extend\Note;



class Login extends Api{
    /**
     * 注册
     * @return \think\response\Json
     */
    public function register(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求数据
        $param = input('post.');
        // 用户管理模型
        $model = new User;
        // 数据验证
        if (!$model -> checkData($param)) {
            return ajax($model -> err, 2);
        }

        // 注册后返回用户登录凭证
        $token = $model -> reg($param);
        if (!$token) return ajax($model -> err, 2);
        return ajax('注册成功', 1,$token);
    }

    /**
     * 登录
     * @return \think\response\Json
     */
    public function login(){

        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求信息
        $param = input('post.');
        // 模型
        $model = new User;

        if(!empty($param['login_type']) && $param['login_type'] == 'sms'){
            // 判断短信验证码是否正确
            $codeModel = new Code;
            if (!$codeModel -> checkCode($param)) {
                return ajax($codeModel -> err, 2);
            }
        }

        // 登录 - 返回用户信息
        $user = $model -> login($param);
        if (!$user) return ajax($model -> err, 2);
        if($user['enterprise_id']){
            $enterprisemodel = new Enterprise();
            $enterprise=$enterprisemodel->getOne(['id'=>$user['enterprise_id']]);
            if($enterprise['status']==2){
                return ajax('尊敬的用户你好；你所属的企业已停用。', 2);
            }
        }
        unset($user['password']);
        $user['info']=true;
        if(empty($user['name']) || empty($user['phone'])){
            $user['info']=false;
        }
        return ajax('登录成功', 1, $user);
    }

    /**
     * 发送短信验证码
     * @return \think\response\Json
     */
    public function sendCode(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求数据
        $data = input('post.');
        // 判断手机号
        if (!preg_match('/^1\d{10}$/',$data['phone'])) {
            return ajax('请填写正确的手机号', 2);
        }
        $sms_code="SMS_139855104";
        if(!empty($data['type']) && $data['type']=='user'){
            $userModel = new User;
            $user=$userModel-> getOne(['phone'=>$data['phone'],'status'=>1]);
            if (!$user) return ajax('用户不存在', 2);
            $sms_code="SMS_139855104";
        }

        if(!empty($data['type']) && $data['type']=='exist'){
            $userModel = new User;
            $user=$userModel-> getOne(['phone'=>$data['phone'],'status'=>1]);
            if ($user) return ajax('用户已存在', 2);
            $sms_code="SMS_139855101";
        }

        // 验证码模型
        $model = new Code;
        // 1分钟之内是否获取过短信了
        $old = $model -> getOne(['phone'=>$data['phone']]);
        if ($old && ($old['time'] + 60 > time())) {
            return ajax('你已经获取过短信验证码了', 2);
        }

        // 验证码
        $code = $data['code'] = rand(1000, 9999);

        // TODO 自行选择发送的短信服务商来发短信
        $obj = new Note;
        $content="您的验证码是$code,在3分钟内有效。如非本人操作请忽略本短信。";
        // 短信宝
//        $res=$obj -> smsbao($data['phone'], $content);
        $res=$obj -> sendSms($data['phone'], $code,$sms_code);
        // TODO 自行修改为判断短信是否发送成功
        if ($res) {
            unset($data['type']);
            // 保存短信
            $model -> saveCode($data);
            return ajax('短信发送成功');
        } else {
            return ajax('短信运营商出错', 2);
        }

    }

    /**
     * 重置密码
     * @return \think\response\Json
     */
    public function resetPassword(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求数据
        $param = input('post.');
        // 用户管理模型
        $model = new User;
        // 数据验证
        if (!$model -> checkData($param,['name','nickname','email'])) {
            return ajax($model -> err, 2);
        }



        // 注册后返回用户登录凭证
        $user = $model -> reset($param);
        if (!$user) return ajax($model -> err, 2);
        unset($user['password']);
        $user['info']=true;
        if(empty($user['name']) || empty($user['nickname'])){
            $user['info']=false;
        }

        return ajax('重置成功', 1, $user);
    }

    /**
     * 校验验证码
     * @return \think\response\Json
     */
    public function code(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求数据
        $param = input('post.');
        // 判断短信验证码是否正确
        $codeModel = new Code;
        if (!$codeModel -> checkCode($param)) {
            return ajax($codeModel -> err, 2);
        }
        return ajax('验证成功', 1);
    }
}
