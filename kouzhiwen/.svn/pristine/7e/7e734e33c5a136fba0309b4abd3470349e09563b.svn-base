<?php
/**
 * [用户列表模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\common\model;
use app\common\extend\Rongcloudapi;
use think\Validate;

class User extends CommonModel{
    public $err;
    public $data;
    public $pk = 'uid';

    /**
     * 用户注册
     * @param $param
     * @return bool|mixed
     */
    public function reg($param){
        // 判断用户是否注册过
        if ($this -> getOne(['phone'=>$param['phone'],'status'=>1])) {
            $this -> err = '手机号已被占用'; return false;
        }
        if ($this -> getOne(['username'=>$param['username'],'status'=>1])) {
            $this -> err = '用户名已被占用'; return false;
        }
        // 组合注册信息
        $reg = [
            'name'         => $param['name'],
            'nickname'         => getRandomString(6),
            'phone'         => $param['phone'],
            'username'    => $param['username'],
            'password'      => create_pwd($param['password']),
            'logintoken'    => md5($param['phone'] . time()),
            'deviceToken'    => $param['deviceToken'],
            'face'          => '/uploads/default.png',
            'name_hide'          =>1,
            'allot'          =>2,
            'created_at'          =>time(),
            'updated_at'          =>time(),
        ];

        $id=$this -> addData($reg);
        // 注册
        if (!$id) {
            $this -> err = '系统出错'; return false;
        }
        $Rongcloud =new Rongcloudapi();
        $uid="u_".$id;
        $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$reg['face'];
        $rongdata=$Rongcloud->RongCloud->user()->getToken($uid, '用户', $face);
        $rongdata=json_decode($rongdata);
        if($rongdata->code==200){
            $this -> editData(['uid'=>$id], ['rongcloud'=>$rongdata->token]);

        }
        return  ['logintoken'=>$reg['logintoken'],'rongcloud'=>$rongdata->token];
    }

    /**
     * 用户重置密码
     * @param $param
     * @return bool|mixed
     */
    public function reset($param){

        // 判断用户是否存在
        $user = $this -> getOne(['phone'=>$param['phone']]);
        if (!$user) {
            $this -> err = '用户不存在'; return false;
        }
        // 更新token
        $token = md5($user['phone'] . time());
        if (!$this -> editData(['uid'=>$user['uid']], ['logintoken'=>$token,'password'=>create_pwd($param['password']),'updated_at'=>time()])) {
            $this -> err = '系统出错'; return false;
        }
        $user['logintoken'] = $token;

        return $user;
    }
    /**
     * 登录
     * @param $param
     * @return array | bool
     */
    public function login($param){
        // 判断是否是第三方登录
//        if (!empty($param['login_type']) && $param['login_type'] != 'phone') {
//            return $this -> _otherLogin($param);
//        }


        // 判断用户是否存在
//        $user = $this -> getOne(['phone'=>$param['phone'],'status'=>1]);

        $user=$this->where("username='{$param['phone']}' OR phone='{$param['phone']}'")->find();


        if (!$user) {
            $this -> err = '用户不存在'; return false;
        }

        if($param['login_type'] == 'phone'){
            // 判断密码是否正确
            if ($user['password'] != create_pwd($param['password'])) {
                $this -> err = '密码不正确'; return false;
            }
        }

        // 更新token
        $token = md5($user['phone'] . time());
        $updatedata=array('logintoken'=>$token,'deviceToken'=>$param['deviceToken']);

        if(empty($user['rongcloud'])){
            $Rongcloud =new Rongcloudapi();
            $uid="u_".$user['uid'];
            $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$user['face'];
            $rongdata=$Rongcloud->RongCloud->user()->getToken($uid, $user['nickname'], $face);
            $rongdata=json_decode($rongdata);
            if($rongdata->code==200){
                $updatedata['rongcloud']=$rongdata->token;
                $user['rongcloud'] =$rongdata->token;
            }
        }

        if (!$this -> editData(['uid'=>$user['uid']], $updatedata)) {
            $this -> err = '系统出错'; return false;
        }
        $user['logintoken'] = $token;
//        var_dump($user);die;
        return $user;
    }

    /**
     * 第三方登录
     * @param $param
     * @return array|bool|object
     */
    private function _otherLogin($param){
        // 第三方 openid 是否存在
        if (empty($param['openid'])) {
            $this -> err = '请提交第三方账号 openid'; return false;
        }
        // 判断类型是否正确
        if (!in_array($param['login_type'], ['qq', 'wechat', 'sine'])) {
            $this -> err = '未授权的登录类型'; return false;
        }

        // 判断是否注册过:注册过 直接返回用户信息
        $user = $this -> getOne(['login_' . $param['login_type']=>md5($param['openid'])]);

        if ($user) {
            // 更新token
            $user['logintoken'] = md5(time() . $user['uid']);
            $this -> editData(['uid'=>$user['uid']], ['logintoken'=>$user['logintoken']]);
            return $user;
        }

        // 注册新账户
        $reg = [
            'login_' . $param['login_type'] => md5($param['openid']),
            'nickname'    => empty($param['nickname']) ? '' : $param['nickname'],
            'face'      => empty($param['face'])   ? '' : $param['face'],
            'add_time'  => time(),
            'logintoken' => md5(time() . round(1000, 9999))
        ];
        $uid = $this -> addData($reg);
        // 返回用户信息
        return $this -> getOne(['uid'=>$uid]);
    }

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'phone' => 'require|/^1[0-9]{10}$/',
            'password' => 'require|length:6,16',
            'name' => 'require',
//            'username'=>'require',
//            'nickname' => 'require',
//            'face' => 'require',
//            'identity' => 'require',
//            'sex' => 'require',
//            'tel' => 'require|/^1[0-9]{10}$/',
//            'email' => 'email',
//            'id_photo_pos' => 'require',
//            'id_photo_neg' => 'require',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'phone' => '请填写正确的手机',
            'password' => '请填写正确的密码',
            'name' => '请填写姓名',
//            'username'=>'请填写用户名',
//            'nickname' => '请填写昵称',
////            'face' => '请上传正确的头像',
//            'identity' => '请填写正确的身份证号',
//            'sex' => '请选择正确的性别',
//            'birth' => '请选择正确的出生年月',
//            'tel' => '请填写正确的手机',
//            'email' => '请填写正确的邮箱',
//            'id_photo_pos' => '请上传正确的证件照',
//            'id_photo_neg' => '请上传正确的证件照',
        ];

        // 创建验证
        if (!empty($rule) && !empty($message)) {
            // 创建验证规则
            $validate = new Validate($rule, $message);
            // 执行验证
            if (!$validate -> check($data)) {
                // 保存错误信息
                $this -> err = $validate -> getError();
                return false;
            }
        }
        unset($data['code']);
        // 保存验证过的数据
        $this -> data = $data;
        return true;
    }

    /**
     * 关联排行榜
     * @return \think\model\relation\HasMany
     */
    public function ranking(){
        return $this->hasMany('UserRanking','uid','uid')->field(['blue','purple','green','orange','red'])->order('date desc');
    }
}