<?php
/**
 * [微信管理基类]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-5-1 17:04:23
 * @Copyright:
 */
namespace app\wechat\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\common\model\User;

class Wechat extends Controller{
    public $param;
    public $isPost;
    public $isAjax;
    public $user;
    // 微信APP_ID
    protected $appid = 'wx75a66eda62423cc5';
    // 微信秘钥
    protected $secret = '90d55c263d55bc93b55a227bb0d9b0ee';
    // 域名
    protected $web   = 'http://heibei.zpftech.com';

    /**
     * 初始化
     */
    public function _initialize(){
        // 初始化请求信息
        $request = Request::instance();
        $this -> param  = $request -> param();
        $this -> isPost = $request -> method() == 'POST' ? true : false;
        $this -> isAjax = $request -> isAjax();

        // 判断是否需要登录
        if (!$this -> _isLogin($request)) {
            // 微信登录回调地址
            $redirect_url = $this -> web . '/wechat/login/login';
            // 微信登录地址
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this -> appid.
                '&redirect_uri='.urlencode($redirect_url).'&response_type=code&scope=snsapi_userinfo&state=state#wechat_redirect';
            // 跳转至微信登录
            header("Location:{$url}");die;
        }

        // 设置微信 JS-SDK 调用权限
        $this -> _setJsSdkAccess();
    }

    /**
     * 判断是否需要登录
     * @param $request
     * @return bool
     */
    private function _isLogin($request){
        // 定义不需要登录就能访问的方法 : 控制器 => [方法1, 方法2];
        $nologin = [
            'Login'     => '*',
        ];

        // 获取当前操作控制和方法
        $controller = underline_to_hump($request -> controller());
        $method = $request -> action();

        // 判断是否需要登录
        if (!array_key_exists($controller, $nologin)) {
            // 检测是否登录
            return $this -> _checkLogin();
        } else {
            if ($nologin[$controller] != '*' && !in_array($method, $nologin[$controller])) {
                // 检测是否登录
                return $this -> _checkLogin();
            }
            return true;
        }
    }

    /**
     * 检测是否登录
     * @return bool
     */
    private function _checkLogin(){
        // 微信登录信息
        $wechatUid = Session::get('wechat_uid');

        if (empty($wechatUid)) return false;
        // where条件
        $where['uid'] = $wechatUid;

        // 用户管理模型
        $userModel = new User;
        // 获取用户信息
        $user = $userModel -> getOne($where);
        if (empty($user)) return false;
        // 保存登录用户信息
        unset($user['password']);
        $this -> user = $user;
        return true;
    }

    /**
     * 获取JS-SDK调用权限
     */
    private function _setJsSdkAccess(){
        // 获取accesstoken
        $accessToken = $this -> _getAccessToken();
        // 获取jsapi_ticket
        $jsapiTicket = $this -> _getJsapiTicket($accessToken);
        // -------- 生成签名 --------
        $wxConf = [
            'jsapi_ticket'  => $jsapiTicket,
            'noncestr'      => md5(time() . '!@#$%^&*()_+'),
            'timestamp'     => time(),
            'url'           => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']
        ];
        $string1 = sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s',$wxConf['jsapi_ticket'],$wxConf['noncestr'],$wxConf['timestamp'],$wxConf['url']);
        // 计算签名
        $wxConf['signature'] = sha1($string1);
        $wxConf['appid'] = $this -> appid;
        $this -> assign('wx_conf', $wxConf);
    }

    /**
     * 获得权限token
     * @return mixed
     */
    private function _getAccessToken(){
        // 获取缓存
        $access = cache('access_token');
        // 缓存不存在-重新创建
        if (empty($access)) {
            // 获取 access token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this -> appid}&secret={$this -> secret}";
            $accessToken = curl($url);
            // 保存至缓存
            $access = $accessToken['access_token'];
            cache('access_token', $access);
        }
        return $access;
    }

    /**
     * 获取JS证明
     * @param $accessToken
     * @return mixed
     */
    private function _getJsapiTicket($accessToken){
        // 获取缓存
        $ticket = cache('jsapi_ticket');
        // 缓存不存在-重新创建
        if (empty($ticket)) {
            // 获取js_ticket
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$accessToken}&type=jsapi";
            $jsTicket = curl($url);
            // 保存至缓存
            $ticket = $jsTicket['ticket'];
            cache('jsapi_ticket', $ticket);
        }
        return $ticket;
    }
}
