<?php
/**
 * [通知管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 19:26:14
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\info\model\User as model;
use app\admin\root\controller\Common;
use app\admin\info\model\Enterprise;
use app\admin\root\model\UserJgpush;
use app\common\extend\JGPush;
use app\common\model\UserNotice;
use app\common\model\Course;
use app\common\model\TeacherArticle;
use app\common\model\Teacher;
use app\common\model\Studys;
use app\common\model\Information;

class Notice extends Common{

    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'typeVal'=>[1=>'班级考试',2=>'专业考试'],
            'paperstatusVal'=>[1=>'及格',2=>'未及格'],
            'sexVal'=>[0=>'未知',1=>'男',2=>'女'],
            'educationVal'=>[1=>'初中',2=>'高中',3=>'大专',4=>'本科',5=>'硕士',6=>'博士'],
            'noticetypeVal'=>[0=>'不关联',1=>'专业知识课',2=>'研究动态',3=>'专家',4=>'学习班',5=>'直播课',6=>'资讯'],
        ];
    }

    /**
     * [index 默认方法]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');

        //实例化模型
        $model = new model;
        $allot=empty($allot)?2:$allot;
        $where =['status'=>1];
        $this -> checkVal['enterprisedata']=array();
        if($this->user['enterprise_id'] !=0){
            $where['enterprise_id'] =$this->user['enterprise_id'];
        }else{
            $Enterprise =new Enterprise();
            $enterprisedata=$Enterprise->getAll();
            $this -> checkVal['enterprisedata']=$this->array_convert($enterprisedata,'id','name');
        }

        if (!empty($keywords)) {
            $where['phone|name|nickname'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'allot'  => $allot,
            'keywords'  => $keywords,
            'enterprise_id'  => $this->user['enterprise_id'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 推送历史记录
     * @return \think\response\View
     */
    public function record(){
        $keywords = input('get.keywords');
        $where =['u.status'=>1];
        if (!empty($keywords)) {
            $where['phone|name|nickname'] = ['like', "%{$keywords}%"];
        }
        if($this->user['enterprise_id'] !=0){
            $where['u.enterprise_id'] =$this->user['enterprise_id'];
        }
        $model=new UserJgpush();
        $model=$model->alias('j')->join('user u','u.uid=j.uid','left');
        $field=array("j.type","j.title","j.describe","j.created_at","u.phone","u.name","u.nickname","u.face");
        // 获取数据
        $data  = admin_page($model, $where,"j.created_at desc",$field);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'enterprise_id'  => $this->user['enterprise_id'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    public function push(){
        // 模板
        return view('',[
            'id'  => $this->param['id'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    public function notice(){
        $uid=$this->param['id'];
        if(empty($uid)){
            return ajax("请选择推送用户", 2);
        }
        if(empty($this->param['title'])){
            return ajax("请输入推送标题", 2);
        }
        if(empty($this->param['describe'])){
            return ajax("请输入推送描述", 2);
        }
        if(!empty($this->param['time']) && $this->param['time']<=date("Y-m-d H:i:s")){
            return ajax("推送时间只能为过期时间", 2);
        }
        $model = new model;
        $UserJgpush = new UserJgpush;
        $UserNotice = new UserNotice;
        $JGPush=new JGPush();

        $UserJgpush->startTrans();
        if($uid=='all'){
            $model = new model;
            $where =['status'=>1];
            if($this->user['enterprise_id'] !=0) {
                $where['enterprise_id'] = $this->user['enterprise_id'];
            }
            $uid=$this->array_convert($model->getAll($where),'uid','uid');
        }
//        $Jgpushwhere['uid'] = ['in', $uid];
//        $Jgpushwhere['type'] =$this->param['type'];
//        $Jgpushwhere['type_id'] =$this->param['type_id'];
//
//
//        $id=$UserJgpush->getAll($Jgpushwhere);
//
//        if(!empty($id)){
//
//            $id=$this->array_convert($id,'uid','uid');
//            if(!is_array($uid)){
//                $uid=explode(",",$uid);
//            }
//            $uid=implode(",",array_diff($id,$uid));
//        }
//        if(empty($uid)){
//            return ajax('此用户以推送', 2);
//        }
//        $where['uid'] = ['in', $uid];
        $data=$model->field(['uid','phone'])->where(['uid'=>['in', $uid]])->select()->toArray();


        $uid=$this->array_convert($data,'uid','phone');
        $data=['type'=>$this->param['type'],'type_id'=>$this->param['type_id']];
//        $res=$this->datashow($this->param['type'],$this->param['type_id']);
//        if(empty($res)){
//            return ajax('没有此推送数据', 2);
//        }
//        $title=$this->checkVal['noticetypeVal'][$this->param['type']];
//        $title=$res['title'];

        $title=$this->param['title'];
        $describe=$this->param['describe'];
        $res=$JGPush->sendUrgentNotify($uid,$title,$describe,'all',$data,$this->param['time']);

//        if($res['code']!==200){
//            return ajax($res['msg'], 2);
//        }
        $data=array();
        $notice=array();
        $time=time();
        $tasktime=empty($this->param['time'])?$time:strtotime($this->param['time']);
        $type=!empty($this->param['type'])?$this->param['type']:0;
        $type_id=!empty($this->param['type_id'])?$this->param['type_id']:0;
        foreach ($uid as $key=>$val){
            $data[$key]['uid']=$key;
            $data[$key]['type']=$this->param['type'];
            $data[$key]['type_id']=$this->param['type_id'];
            $data[$key]['title']=$this->param['title'];
            $data[$key]['describe']=$this->param['describe'];
            $data[$key]['created_at']=$tasktime;
            $notice[]=array('uid'=>$key,'title'=>$this->param['title'],'content'=>$this->param['describe'],'reading'=>0,'type'=>$type,'type_id'=>$type_id,'created_at'=>$time);
        }
        $res=$UserJgpush->insertAll($data);
        if(!$res){
            return ajax('推送失败', 2);
        }
        $res=$UserNotice->insertAll($notice);
        if(!$res){
            return ajax('推送失败', 2);
        }
        $UserJgpush->commit();
        $this->AddLog('推送成功');
        return ajax('推送成功', 1);
    }

    /**
     * 获取关联数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dataList(){
        switch ($this->param['type']){
            case 0:$data=array(['id'=>0,'title'=>'不关联']);break;
            case 1:$data=Course::where(['enterprise_id'=>$this -> user['enterprise_id'],'status'=>1,'type'=>1])->field(['id','title'])->select();break;
            case 2:$data=TeacherArticle::where(['enterprise_id'=>$this -> user['enterprise_id'],'class_id'=>0,'status'=>1])->field(['id','name as title'])->select();break;
            case 3:$data=Teacher::where(['enterprise_id'=>$this -> user['enterprise_id'],'identity'=>['like','%3%']])->field(['id','name as title'])->select();break;
            case 4:$data=Studys::where(['enterprise_id'=>$this -> user['enterprise_id']])->field(['id','name as title'])->select();break;
            case 5:$data=Course::where(['enterprise_id'=>$this -> user['enterprise_id'],'status'=>1,'type'=>3])->field(['id','title'])->select();break;
            case 6:$data=Information::where(['enterprise_id'=>$this -> user['enterprise_id'],'status'=>1])->field(['id','name as title'])->select();break;
            default:$data=[];break;
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 获取推送详情
     * @param $type
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function datashow($type,$id){
        switch ($type){
            case 1:$data=Course::where(['id'=>$id])->field(['id','title'])->find();break;
            case 2:$data=TeacherArticle::where(['id'=>$id])->field(['id','name as title'])->find();break;
            case 3:$data=Teacher::where(['id'=>$id])->field(['id','name as title'])->find();break;
            case 4:$data=Studys::where(['id'=>$id])->field(['id','name as title'])->find();break;
            case 5:$data=Course::where(['id'=>$id])->field(['id','title'])->find();break;
            case 6:$data=Information::where(['id'=>$id])->field(['id','name as title'])->find();break;
            default:$data=[];break;
        }
        return $data;
    }

}