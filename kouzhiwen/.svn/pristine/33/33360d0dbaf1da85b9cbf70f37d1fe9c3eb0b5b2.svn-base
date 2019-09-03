<?php
/**
 * [协议管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-02 15:30:22
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Protocol as model;


class Protocol extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'typeVal'=>array('register'=>'注册协议','user'=>'关于我们','class'=>'培训班协议'),
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
        $where = ['enterprise_id'=>$this->user['enterprise_id'],'type'=>['not in',['phone','procedures']]];
        if (!empty($keywords)) {
            $where['title|content'] = ['like', "%{$keywords}%"];
        }
        $where=
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
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $data['updated_at'] = time();

            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            $res=$model->getOne(['enterprise_id'=>$this->user['enterprise_id'],'type'=>$data['type']]);
            if($res)return ajax('已有此类型的协议', 2);
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $msg="添加".$this -> checkVal['typeVal'][$data['type']]."协议";
            $this->AddLog($msg);

            return ajax('添加成功');
        }
        if($this->user['enterprise_id']!=0){
            $this -> checkVal['typeVal']=array('class'=>'培训班协议');
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
            $data['updated_at'] = time();
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            $res=$model->getOne(['enterprise_id'=>$this->user['enterprise_id'],'type'=>$data['type'],'id'=>['not in',[$data['id']]]]);
            if($res)return ajax('已有此类型的协议', 2);
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $msg="修改".$this -> checkVal['typeVal'][$data['type']]."协议";
            $this->AddLog($msg);
            return ajax('修改成功');
        }
        if($this->user['enterprise_id']!=0){
            $this -> checkVal['typeVal']=array('class'=>'培训班协议');
        }
        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);

        return view('',[
            'data'     => $data,
            'id'    => $id,
            'checkVal' => $this -> checkVal
        ]);
    }


}