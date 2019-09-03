<?php
/**
 * [资讯管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-24 17:18:08
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Information as model;
use app\admin\root\model\Classify;


class Information extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'is_recommend' => [
                '1'=>'是',
                '0'=>'否',
            ]
        ];
        $this->Classify();
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =['enterprise_id'=>$this->user['enterprise_id']];
        if (!empty($keywords)) {
            $where['name|author'] = ['like', "%{$keywords}%"];
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
            $data['add_time'] = time();
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $check=['id','enterprise_id','add_time','comment_num','pv','status'];
            if($this->user['enterprise_id']==0){
                $check[]='power';
            }
            // 验证
            if (!$model -> checkData($data,$check )) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加资讯'.$data['name']);
            return ajax('添加成功');
        }

        return view('', [
            'checkVal'  => $this -> checkVal,
            'enterprise_id'  => $this->user['enterprise_id'],
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
            $data['add_time'] = time();
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $check=['id','enterprise_id','add_time','comment_num','pv','status'];
            if($this->user['enterprise_id']==0){
                $check[]='power';
            }
            // 验证
            if (!$model -> checkData($data,$check)) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('添加资讯'.$data['name']);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        
        return view('',[
            'data'     => $data,
            'id'    => $id,
            'enterprise_id'  => $this->user['enterprise_id'],
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
        $this->AddLog('删除资讯'.$id);
        return ajax('删除成功');
    }

    /**
     * 获取分类id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function Classify(){
        $Classify =new Classify();
        $data=$Classify->where(['enterprise_id'=>$this->user['enterprise_id']])->field(['id','name'])->select()->toArray();
        $this->checkVal['classify_idVal']=$this->array_convert($data,'id','name');
    }



}