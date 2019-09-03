<?php
/**
 * [API接口管理基类]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-5-1 17:04:23
 * @Copyright:
 */
namespace app\api\common\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\common\model\User;

class Api extends Controller{
    public $param;
    public $isPost;
    public $isAjax;
    public $user;
    public $config;
    /**
     * 初始化
     */
    public function _initialize(){
        // 初始化请求信息
        $request = Request::instance();
        $this -> param  = $request -> param();
        $this -> isPost = $request -> method() == 'POST' ? true : false;
        $this -> isAjax = $request -> isAjax();
        $this -> config = $this->img_video_config();

        // 判断是否需要登录
        if (!$this -> _isLogin($request)) {
            echo json_encode(['status'=>0,'msg'=>'请先登录'], JSON_UNESCAPED_UNICODE);die;
        }
    }

    /**
     * 图片配置
     * @return array
     */
    public function img_video_config(){
        return array(
            "upload_img_basePath_user"=>"/uploads/user/images",//图片 上传的根目录
            'upload_img_type'=>array(//上传文件的mime类型
                "image/gif",
                "image/pjpeg",
                "image/jpeg",
                "image/jpg",
                "image/png",
                "image/x-png",
                "application/octet-stream"
            ),
            "upload_img_suffix"=>"gif,jpeg,jpg,png",
            "upload_img_size"=>10240,//上传图片文件限制大小10M

            "upload_video_basePath"=>"/uploads/user/video",//视频
            "upload_video_type"=>array(//上传视频的mime类型
                "video/mp4",
                "video/mov"
            ),
            "upload_video_suffix"=>"mp4",
            "upload_video_size"  =>204800,//上传视频文件限制大小20M
        );
    }
    /**
     * 判断是否需要登录
     * @return bool
     */
    private function _isLogin($request){
        // 定义不需要登录就能访问的方法 : 控制器 => [方法1, 方法2];
        $nologin = [
            'api\common\Login'     => '*',
            'api\common\Common'    => '*',
            'api\common\Uploads'    => '*',
            'api\common\Pushnotice'    => '*',
            'api\common\Study'    =>['studyDetails','hotDetails','noticeDetails'],
            'api\discover\Comment'    =>['datalist'],
            'api\discover\Article'    =>['details'],
            'api\discover\Course'    =>['courseDetails'],
            'api\discover\Introduce'    =>['details'],
        ];

        // 获取当前操作控制和方法
        $controller = $request -> module() . '\\' . underline_to_hump($request -> controller());
        $method = $request -> action();
        // 判断是否需要登录
        if (!array_key_exists($controller, $nologin)) {

            // 检测是否登录
            return $this -> _checkLogin($request);
        } else {
            $logintoken = $request -> header('logintoken');
            if ($nologin[$controller] != '*' && (!in_array($method, $nologin[$controller]) || !empty($logintoken))) {

                // 检测是否登录
                return $this -> _checkLogin($request);
            }
            return true;
        }
    }

    /**
     * 检测是否登录 API & Wechat 公用
     * @return bool
     */
    private function _checkLogin($request){
        // APP登录token
        $logintoken = $request -> header('logintoken');
        // 微信登录信息
        $wechatUid = Session::get('wechat_uid');
        if (empty($logintoken) && empty($wechatUid)) return false;
        // where条件
        if (empty($logintoken)) {
            $where['uid'] = $wechatUid;
        } else {
            $where['logintoken'] = $logintoken;
        }

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
     * 二维数组转一维数组
     * @param $data 数据
     * @param $key 健
     * @param $val 值
     * @return array
     */
    public function array_convert($data,$key,$val){
        $arr=array();
        foreach ($data as $k=>$v){
            $arr[$v[$key]]=$v[$val];
        }
        return $arr;
    }

    /**
     * 关键字替换
     * @param $text
     * @return mixed
     */
    public function keywordReplace($text){
        $data=db('keyword') -> field(['title','id','replace']) -> select()->toArray();
        if(empty($data)){
            return $text;
        }
        $keyword=$this->array_convert($data,'id','title');
        $Replace=$this->array_convert($data,'id','replace');
        return str_replace($keyword,$Replace,$text);
    }
}
