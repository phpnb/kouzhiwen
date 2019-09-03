<?php
/**
 * [ddddd控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-16 14:31:08
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\User as model;


class Tests extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where = '';
        if (!empty($keywords)) {
            $where['phone|nickname'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where);
        
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            
            
            // 验证
            if (!$model -> checkData($data, ['logintoken','wechat_openid','login_qq','login_wechat','login_sina','status'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            return ajax('添加成功');
        }

        return view('', [
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据
            $data = input('post.');
            
            
            // 验证
            if (!$model -> checkData($data, ['logintoken','wechat_openid','login_qq','login_wechat','login_sina','status'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['uid'=>$data['uid']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }

        // 获取旧数据
        $uid = (int)$this -> param['uid'];
        $data = $model -> getOne(['uid'=>$uid]);
        
        return view('',[
            'data'     => $data,
            'uid'    => $uid,
            'checkVal' => $this -> checkVal
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        // 定义条件
        $uid = $this -> param['id'];
        // 可批量删除
        $where['uid'] = ['in', $uid];
        if (!$model -> delData($where)) return ajax('删除失败');
        return ajax('删除成功');
    }


}