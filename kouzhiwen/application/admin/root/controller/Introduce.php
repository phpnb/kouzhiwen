<?php
/**
 * [平台资讯控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-27 17:57:06
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Introduce as model;
use app\common\model\User;
use app\common\model\UserNorm;

class Introduce extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'type' => [
                '1'=>'公开课',
                '2'=>'定制培训',
                '3'=>'标杆学习',
                '4'=>'国际项目',
                '5' => '关于叩之问',
                '6' => '平台资讯'
            ],
            'is_recommend' => [
                '1'=>'是',
                '0'=>'否',
            ],
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
            $where['name'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where,'add_time desc');
        
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
            $data['add_time'] = time();
            // 验证
            if (!$model -> checkData($data, ['id','comment_num','pv','status','add_time'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加平台资讯'.$data['name']);
            if(!empty($data['phone'])){
                $UserNorm =new UserNorm();
                $Usermodel=new User();
                $user=$Usermodel->getOne(['phone'=>$data['phone']]);
                if(!empty($user)){
                    $UserNorm->normUp($user,'b');
                }

            }
            return ajax('添加成功');
        }
//        $Usermodel=new User();
//        $this -> checkVal['uid']=$Usermodel->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
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
            if (!$model -> checkData($data, ['id','comment_num','pv','status'])) {
                return ajax($model -> err, 2);
            }
            $introduce=$model->getOne(['id'=>$data['id']]);
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改平台资讯'.$data['name']);
            if(!empty($data['phone']) && $introduce['phone']!=$data['phone']){
                $UserNorm =new UserNorm();
                $Usermodel=new User();
                $user=$Usermodel->getOne(['phone'=>$data['phone']]);
                if(!empty($user)){
                    $UserNorm->normUp($user,'b');
                }

            }
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
//        $Usermodel=new User();
//        $this -> checkVal['uid']=$Usermodel->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
        return view('',[
            'data'     => $data,
            'id'    => $id,
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
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax('删除失败');
        $this->AddLog('删除平台资讯'.$id);
        return ajax('删除成功');
    }


}