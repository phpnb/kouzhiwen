<?php
/**
 * [学习班管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:32:03
 * @Copyright:
 */
namespace app\admin\course\controller;  
use app\admin\course\model\Study as model;
use app\admin\root\controller\Common;
use app\admin\course\model\ClassType;
use app\admin\root\model\Classify;
use app\admin\info\model\Teacher;
use app\admin\course\model\ClassUser;
use app\admin\course\model\ClassNotice;
use app\common\model\TeacherArticle;
use app\common\extend\Rongcloudapi;
use app\common\model\TeacherCont;
use app\admin\info\model\Enterprise;
use app\admin\info\model\User;

class Study extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'typeVal'=>['1'=>'线上','2'=>'线下']
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
        $where =['c.enterprise_id'=>$this->user['enterprise_id']];
        if (!empty($keywords)) {
            $where['c.name'] = ['like', "%{$keywords}%"];
        }

        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }else{
            $ClassType=new ClassType();
            $type=$ClassType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['class_type_idVal']=$this->array_convert($type,'id','name');
        }
        $model=$model->alias('c')->join('teacher t','t.id=c.teacher_id','left');
        // 获取数据
        $filed=array("c.*","t.name as teachername");
        $data  = admin_page($model, $where,"c.created_at desc",$filed);

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
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['created_at'] = time();
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $check=['id','enterprise_id','created_at','updated_at'];
            if($this->user['enterprise_id']==0){
                $check[]='class_type_id';
                $check[]='power';
            }else{
                $check[]='classify_id';
            }
            // 验证
            if (!$model -> checkData($data,$check)) {
                return ajax($model -> err, 2);
            }
            $id=$model -> addData();
            // 添加数据
            if (!$id) return ajax('添加失败', 2);
            $Rongcloud =new Rongcloudapi();
            $Rongcloud->RongCloud->group()->create(["t_".$data['teacher_id']],"c_$id",$data['name']);
            $fileName=$id.".png";
            qrcode($id,$fileName,5,'',3);
            $qrcode = '/uploads/qrcode/' . date('Ymd') . '/'.$fileName;
            $model -> editData(['id'=>$id],['img_url'=>$qrcode]);
            $this->AddLog('添加班级'.$data['name']);
            return ajax('添加成功');
        }


        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$classify;
        }else{
            $ClassType=new ClassType();
            $type=$ClassType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['class_type_idVal']=$type;
        }
        $Teacher =new Teacher();

        if($this -> checkVal['enterprise_id']==0){
            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id'],'identity'=>['like','%2%']]);
        }else{
            $enterprise_id = $this -> checkVal['enterprise_id'];
            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>['in',[$enterprise_id,0]],'identity'=>['like','%2%']]);
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
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $check=['id','enterprise_id','created_at','updated_at'];
            if($this->user['enterprise_id']==0){
                $check[]='class_type_id';
                $check[]='power';
            }else{
                $check[]='classify_id';
            }
            $id=$data['id'];
            $fileName=$id.".png";
            qrcode($id,$fileName,5,'',3);
            $qrcode = '/uploads/qrcode/' . date('Ymd') . '/'.$fileName;
            $data['img_url'] = $qrcode;
            // 验证
            if (!$model -> checkData($data,$check)) {
                return ajax($model -> err, 2);
            }

            $study=$model->getOne(['id'=>$id]);
            $Rongcloud =new Rongcloudapi();

            $Rongcloud->RongCloud->group()->quit("t_".$study['teacher_id'],"c_$id");
            $Rongcloud->RongCloud->group()->refresh("c_$id",$data['name']);
            $Rongcloud->RongCloud->group()->join(["t_".$data['teacher_id']],"c_$id",$data['name']);

            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改班级'.$data['name']);
            return ajax('修改成功');
        }
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$classify;
        }else{
            $ClassType=new ClassType();
            $type=$ClassType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['class_type_idVal']=$type;
        }
        $Teacher =new Teacher();
        if($this -> checkVal['enterprise_id']==0){
            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id'],'identity'=>['like','%2%']]);
        }else{
            $enterprise_id = $this -> checkVal['enterprise_id'];
            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>['in',[$enterprise_id,0]],'identity'=>['like','%2%']]);
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
        $this->AddLog('删除班级');
        return ajax('删除成功');
    }

    /**
     *班级成员
     * @return \think\response\View
     */
    public function user(){
        $keywords = input('get.keywords');
        $ClassUser =new ClassUser();
        $where =array("c.class_id"=>$this->param['id']);
        if (!empty($keywords)) {
            $where['u.nickname|u.name'] = ['like', "%{$keywords}%"];
        }

        $model=$ClassUser->alias('c')->join('user u','u.uid=c.uid','left');
        // 获取数据
        $filed=array("c.created_at as ccreated_at","u.*");
        $data  = admin_page($model, $where,"c.created_at desc",$filed);
        $res['count'] = count($data['data']);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'res'      => $res,
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 班级通知
     * @return \think\response\View
     */
    public function notice(){
        $keywords = input('get.keywords');
        $model =new ClassNotice();
        $where =array("n.class_id"=>$this->param['id']);
        if (!empty($keywords)) {
            $where['n.title'] = ['like', "%{$keywords}%"];
        }

        $model=$model->alias('n')->join('teacher t','t.id=n.teacher_id','left');
        // 获取数据
        $filed=array("t.name as teachername","n.id","n.title","n.photo","n.describe","n.price","n.created_at");
        $data  = admin_page($model, $where,"n.created_at desc",$filed);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 班级热点
     * @return \think\response\View
     */
    public function hotspot(){
        $keywords = input('get.keywords');
        $model =new TeacherArticle();
        $where =array("a.class_id"=>$this->param['id']);
        if (!empty($keywords)) {
            $where['a.title'] = ['like', "%{$keywords}%"];
        }

        $model=$model->alias('a')->join('teacher t','t.id=a.teacher_id','left');
        // 获取数据
        $filed=array("t.name as teachername","a.id","a.name","a.cover_img","a.comment_num","a.pv","a.add_time");
        $data  = admin_page($model, $where,"a.add_time desc",$filed);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }
    /**
     * 选择用户
     * @return \think\response\View
     */
    public function adduser(){
        // 搜索关键词
        $keywords = input('get.keywords');

        //实例化模型
        $user = new User();
        $model = new model;
        $id = $this -> param['id'];
        $allot = input('get.allot');
        $allot=empty($allot)?2:$allot;
        $where =['allot'=>$allot,'status'=>1];
        if($this->user['enterprise_id'] !=0){
            $where['enterprise_id'] = $this->user['enterprise_id'];
        }else{
            $Enterprise =new Enterprise();
            $enterprisedata=$Enterprise->getAll();
            $this -> checkVal['enterprisedata']=$this->array_convert($enterprisedata,'id','name');
        }

        if (!empty($keywords)) {
            $where['phone|name|nickname'] = ['like', "%{$keywords}%"];
        }
        $orderby = 'uid desc';
        // 获取数据
        $anyu = $model->where(['id'=>$id])->field('any_u')->select()->toArray();
        $data['any_u'] = explode(",",$anyu['0']['any_u']);
        $data['data'] = $user->where($where)->order($orderby)->select()->toArray();

//        dump($data);die;
        if ($this -> isPost) {
        $post = input('post.');
        if($post){
            $data = implode(",", $post['uid']);
        }

            $id = $this -> param['id'];
            // 修改数据
            $res = $model ->editData(['id'=>$id],['any_u' => $data]);
            if($res){
                return ajax('添加成功');
            }

        }
        // 模板
        return view('',[
            'data'      => $data['data'],
            'anyu'      => $data['any_u'],
            'page'      => $data['page'],
            'allot'  => $allot,
            'keywords'  => $keywords,
            'enterprise_id'  => $this->user['enterprise_id'],
            'checkVal'  => $this -> checkVal
        ]);
    }
}