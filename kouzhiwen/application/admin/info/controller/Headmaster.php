<?php
/**
 * [班主任管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 16:38:31
 * @Copyright:
 */
namespace app\admin\info\controller;
use app\admin\info\model\Teacher as model;
use app\admin\root\controller\Common;
use app\admin\info\model\TeacherType;
use app\admin\root\model\Classify;
use app\admin\root\model\AccessGroup;
use app\common\extend\Rongcloudapi;
use app\common\model\UserQuiz;
use app\common\model\TeacherArticle;
use app\common\model\TeacherNotice;

class Headmaster extends Common{
    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();

        $this -> checkVal = [
            'sexVal'=>['1'=>'男','2'=>'女'],
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        //实例化模型
        $model = new model;
        $where =['enterprise_id'=>$this->user['enterprise_id'],'status'=>'1','identity'=>'2'];
        if (!empty($keywords)) {
            $where['name|phone'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where,'created_at desc');
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }else{
            $TeacherType=new TeacherType();
            $typedata=$TeacherType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);

            $this -> checkVal['teacher_typeVal']=$this->array_convert($typedata,'id','name');
        }

//        $AccessGroup=new AccessGroup();
//        $group=$AccessGroup->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
//        $this -> checkVal['group_idVal']=$this->array_convert($group,'id','name');

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
            $oldData = $model -> where(['username'=>$data['username'],'status'=>['>',0]]) -> find();
            if ($oldData) {
                return ajax('用户名已存在', 2);
            }

            $data['password'] = md5(md5($data['password']));
            $data['created_at'] = time();
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $data['identity'] = '2';



//            $wehre=['id',];

            // 验证

//            if (!$model -> checkData($data)) {
//                return ajax($model -> err, 2);
//            }
            $res=$model -> addData($data);
            // 添加数据
            if (!$res) return ajax('添加失败', 2);
            $Rongcloud =new Rongcloudapi();
            $id="t_".$res;
            $photo=empty($data['photo'])?"/uploads/default.png":$data['photo'];
            $name=empty($data['name'])?$data['username']:$data['name'];
            $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$photo;
            $rongdata=$Rongcloud->RongCloud->user()->getToken($id, $name, $face);
            $rongdata=json_decode($rongdata);
            if($rongdata->code==200){
                $model -> editData(['id'=>$res],['rongcloud'=>$rongdata->token,'updated_at'=>time()]);
            }

            $this->AddLog('添加教师'.$data['username']);
            return ajax('添加成功');
        }
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $this -> checkVal['classify_idVal']=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
        }
        $TeacherType=new TeacherType();
        $this -> checkVal['teacher_typeVal']=$TeacherType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);

        $AccessGroup=new AccessGroup();
        $this -> checkVal['group_idVal']=$AccessGroup->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
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
            if(!empty($data['password'])){
                $data['password'] = md5(md5($data['password']));
            }else{
                unset($data['password']);
            }

            $oldData = $model -> where(['username'=>$data['username'],'id'=>['not in',$data['id']],'status'=>['>',0]]) -> find();
            if ($oldData) {
                return ajax('用户名已存在', 2);
            }

            $wehre=['id','name','title','enterprise_id','photo','phone','brief','password','group_id','logintime','loginip','consult_num','status','created_at','updated_at','module'];
            if($this->user['enterprise_id']!=0){
                $wehre[]='classify_id';
                $wehre[]='is_xszd';
                $wehre[]='is_xszd';
                $wehre[]='is_zdwy';
            }

            if($data['is_xszd']==1){
                $data['identity'] ='3';
                $wehre[]='identity';
            }
//            else{
//                if(empty($data['identity'])){
//                    return ajax('请选择身份', 2);
//                }
//                $data['identity'] = implode(',', $data['identity']);
//            }
            // 验证
//            if (!$model -> checkData($data, $wehre)) {
//                return ajax($model -> err, 2);
//            }
            $teacher = $model -> getOne(['id'=>$data['id']]);
            $photo=empty($data['photo'])?"/uploads/default.png":$data['photo'];
            $name=empty($data['name'])?$data['username']:$data['name'];
            if(empty($teacher['rongcloud'])){
                $Rongcloud =new Rongcloudapi();
                $uid="t_".$data['id'];
                $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$photo;
                $rongdata=$Rongcloud->RongCloud->user()->getToken($uid, $name, $face);
                $rongdata=json_decode($rongdata);
                if($rongdata->code==200){
                    $data['rongcloud']=$rongdata->token;
                }
            }else{
                $Rongcloud =new Rongcloudapi();
                $uid="t_".$data['id'];
                $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$photo;
                $rongdata=$Rongcloud->RongCloud->user()->refresh($uid, $name, $face);
                $rongdata=json_decode($rongdata);
                if($rongdata->code!=200){
                    return ajax('更新数据失败', 2);
                }
            }
            // 修改数据
            $model -> editData(['id'=>$data['id']],$data);
            $this->AddLog('修改教师'.$data['username']);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $data['identity'] = explode(',', $data['identity']);

        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $this -> checkVal['classify_idVal']=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
        }

        $TeacherType=new TeacherType();
        $this -> checkVal['teacher_typeVal']=$TeacherType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
        $AccessGroup=new AccessGroup();
        $this -> checkVal['group_idVal']=$AccessGroup->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
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
        $status = $this->param['status']?$this->param['status']:0;
        $msg="删除";
        if($status==1){
            $msg="审核通过";
            $content="尊敬的老师你好：你所提交的个人信息以通过后台审核。";
        }elseif ($status==3){
            $msg="审核不通过";
            $content="尊敬的老师你好：你所提交的个人信息没有通过后台审核；请重新修改信息修改。";

        }        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax($msg.'失败');
        $this->AddLog($msg.'教师['.$id."]");
        if(in_array($status,[1,3])){
            $TeacherNotice =new TeacherNotice();
            $data=array();
            $idarr=explode(",",$id);
            $time=time();
            foreach ($idarr as $v){
                $data[]=array('teacher_id'=>$v,'title'=>$msg,'content'=>$content,'reading'=>0,'created_at'=>$time);
            }
            $TeacherNotice->insertAll($data);
        }
        return ajax($msg.'成功');
    }
}