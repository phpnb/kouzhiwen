<?php
/**
 * [研究动态与班级热点控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 17:19:21
 * @Copyright:
 */
namespace app\teacher\info\controller;
use app\teacher\root\controller\Common;
use app\common\model\TeacherArticle as model;
use app\common\model\Studys;
use app\common\model\User;
use app\common\model\UserRanking;

class Teacherarticle extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            "type"=>array(1=>'研究动态',2=>'班级热点'),
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $where['a.teacher_id'] = $this->user['id'];
        $type=$this->param['type'];
        $type=$type?$type:1;

        $model = new model;
        if (!empty($keywords)) {
            $where['a.name'] = ['like', "%{$keywords}%"];
        }

        if($type==1){
            $model->alias("a");
            $where["a.class_id"]=0;
            $field=["a.*"];
        }else{
            $model->alias("a")->join("class c","a.class_id=c.id");
            $field=["a.*","c.name as classname"];
        }

        // 获取数据
        $data  = admin_page($model, $where,"a.add_time desc",$field);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'type'      => $type,
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        $model = new model;
        $type=$this->param['type'];
        $type=$type?$type:1;
        if ($this -> isPost) {
            // 实例化模型

            // 获取post数据
            $data = input('post.');

            $data['status'] =0;
            $data['add_time'] = time();
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $data['teacher_id'] =$this->user['id'];
            if($data['type']==1){
                $data['class_id']=0;
            }else{
                $data['status'] =1;
            }
            unset($data['type']);
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','teacher_id','add_time','tel'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            if(!empty($data['tel'])){
                $Usermodel=new User();
                $user=$Usermodel->getOne(['phone'=>$data['tel']]);
                if(!empty($user)){
                    (new UserRanking)->updateRanking($user['uid'],'purple');
                }

            }
            return ajax('添加成功');
        }
        if($type==2){
            $Studys =new Studys();

            $this -> checkVal["class_idVal"]=$Studys->getAll(['teacher_id'=>$this->user['id']]);
//            $this -> checkVal['uid']=$Usermodel->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
        }
        return view('', [
            'checkVal'  => $this -> checkVal,
            'type'  => $type,
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        $type=$this->param['type'];
        $type=$type?$type:1;
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据
            $data = input('post.');
            if($data['type']==1){
                $data['class_id']=0;
            }
            unset($data['type']);
            $article=$model->getOne(['id'=>$data['id']]);
            if($article['status']==2){
                $data['status']=0;
            }
            // 验证
            if (!$model -> checkData($data, ['id','enterprise_id','teacher_id','add_time'])) {
                return ajax($model -> err, 2);
            }

            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            if(!empty($data['tel']) && $article['tel']!=$data['tel']){
                $Usermodel=new User();
                $user=$Usermodel->getOne(['tel'=>$data['tel']]);
                if(!empty($user)){
                    (new UserRanking)->updateRanking($user['uid'],'purple');
                }
            }
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        if($type==2){
            $Studys =new Studys();

            $this -> checkVal["class_idVal"]=$Studys->getAll(['teacher_id'=>$this->user['id']]);
//            $this -> checkVal['uid']=$Usermodel->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
        }
        return view('',[
            'data'     => $data,
            'id'    => $id,
            'type'  => $type,
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
        return ajax('删除成功');
    }


    /**
     * [evaluate 查看]
     */
    public function evaluate(){
        $model = new model;
        $id = (int)$this -> param['id'];

        if ($this -> isPost) {
            $data = input('post.');
            if (!$model->editData(['id'=> $id],['lookeva'=>$data['lookeva'],'alook'=>$data['alook'],'comment'=>$data['comment']])) {
                return ajax('保存失败',2);
            }
            return ajax('保存成功');
        }


        $where = ['id' => $id];

       $data = $model->where($where)->select()->toArray();

        // 模板
        return view('',[
            'data'      => $data,
            'checkVal'  => $this -> checkVal
        ]);
    }


}