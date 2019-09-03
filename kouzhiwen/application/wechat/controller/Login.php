<?php
/**
 * [登录管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\wechat\controller;
use app\common\model\User;
use think\Session;

class Login extends Wechat{
    /**
     * 微信登录回调
     * @return \think\response\View
     */
    public function login(){
        // 微信返回码
        $code = $this -> param['code'];
        // 获取权限信息
        $access = $this -> _getUserAccessToken($code);
        $accessToekn = $access['access_token'];
        $openid = $access['openid'];
        // 获取微信用户信息
        $wechatUser = $this -> _getUserInfo($accessToekn, $openid);

        // 判断该账户是否已写入
        $model = new User;
        $user  = $model -> getOne(['wechat_openid' => md5($openid)]);

        // 未写入过 则注册为新用户
        if (empty($user)) {
            // 微信用户信息保存到SESSION中 方便注册
            Session::set('wechat_user', $wechatUser);
            // return view('', [

            // ]);
            $this -> redirect(url('register'));
        }
        // 写入过 跳转至首页
        else {
            // 记录登录信息
            Session::set('wechat_uid', $user['uid']);
            // 跳转至首页
            $this -> redirect(url('index/index'));
        }
    }

    /**
     * 微信注册
     * @return \think\response\Json
     */
    public function register(){
        // if (!$this -> isPost) return ajax('非法请求', 2);
        // 获取微信用户信息
        $wechatUser = Session::get('wechat_user');
        if (empty($wechatUser)) return ajax('非法操作', 2);
        // 组合注册信息
        $reg = [
            'nickname'          => $wechatUser['nickname'],
            'face'              => $wechatUser['headimgurl'],
            'add_time'          => time(),
            'wechat_openid'     => md5($wechatUser['openid'])
        ];
        $model = new User;
        if (!$model -> addData($reg)) return ajax('注册失败-系统错误', 2);
        return ajax('注册成功');
    }

    /**
     * 获取权限信息
     * @param $code
     * @return mixed
     */
    private function _getUserAccessToken($code){
        // 请求信息地址
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this -> appid.
            '&secret='.$this -> secret.'&code='.$code.'&grant_type=authorization_code';
        $res = curl($url);
        return $res;
    }

    /**
     * 获取微信用户信息
     * @param $accessToekn
     * @param $openid
     * @return mixed
     */
    private function _getUserInfo($accessToekn, $openid){
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$accessToekn.'&openid='.$openid.'&lang=zh_CN';
        $res = curl($url);
        return $res;
    }
}