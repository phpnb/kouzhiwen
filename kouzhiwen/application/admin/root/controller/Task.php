<?php
/**
 * [任务控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 19:26:14
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\common\extend\Note;
use app\admin\info\model\Enterprise;
use app\admin\info\model\User;
use app\admin\root\model\UserJgpush;
use app\common\model\UserNotice;
use app\common\extend\JGPush;
use app\common\model\Course;
use app\common\model\ClassCourse;
use app\common\model\Protocol;


class Task extends Common{

    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [];
    }

    /**
     * [index 默认方法]
     */
    public function index(){

        if($this->param['type']==2){//上午推送
            $this->enterpriseTime(); //企业到期时间短信通知
            $this->classnotice();//班级课程课程推送
        }else{//下午推送
            $this->notice();//课程推送
        }
        return ajax('推送成功', 1);
    }

    /**
     * 班级课程课程推送
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function classnotice(){
        $coursedata=$this->classcourseTask();
        if(empty($coursedata)){
            return true;
        }

        $Usermodel = new User;
        $JGPush=new JGPush();
        $UserJgpush = new UserJgpush;
        $UserNotice = new UserNotice;
        $where =['status'=>1];
        $userdata=$Usermodel->field(['uid','phone'])->where($where)->select()->toArray();
        $uid=$this->array_convert($userdata,'uid','phone');
        $title=$coursedata['title'];
        $describe='';
        $data=['type'=>1,'type_id'=>$coursedata['id']];
        $res=$JGPush->sendUrgentNotify($uid,$title,$describe,'all',$data,'');
//        if($res['code']!==200){
//            return false;
//        }
        $time=time();
        $notice=array();
        foreach ($uid as $key=>$val){
            $notice[]=array('uid'=>$key,'title'=>$title,'content'=>$describe,'reading'=>0,'type'=>7,'type_id'=>$coursedata['id'],'created_at'=>$time);
        }
        $UserNotice->insertAll($notice);
        $data=array();
        $data[]=array('uid'=>0,'type'=>7,'type_id'=>$coursedata['id'],'title'=>$title,'describe'=>$describe,'created_at'=>time());
        $UserJgpush->insertAll($data);
        return true;
    }

    /**
     * 课程推送
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function notice(){
        $coursedata=$this->courseTask();
        if(empty($coursedata)){
            return true;
        }

        $Usermodel = new User;
        $JGPush=new JGPush();
        $UserJgpush = new UserJgpush;
        $UserNotice = new UserNotice;
        $where =['status'=>1];
        $userdata=$Usermodel->field(['uid','phone'])->where($where)->select()->toArray();
        $uid=$this->array_convert($userdata,'uid','phone');
        $title=$coursedata['title'];
        $describe=substr($coursedata['describe'],0,100);
        $data=['type'=>1,'type_id'=>$coursedata['id']];
        $res=$JGPush->sendUrgentNotify($uid,$title,$describe,'all',$data,'');
//        if($res['code']!==200){
//            return false;
//        }
        $time=time();
        $notice=array();
        foreach ($uid as $key=>$val){
            $notice[]=array('uid'=>$key,'title'=>$title,'content'=>$describe,'reading'=>0,'type'=>1,'type_id'=>$coursedata['id'],'created_at'=>$time);
        }
        $UserNotice->insertAll($notice);
        $data=array();
        $data[]=array('uid'=>0,'type'=>1,'type_id'=>$coursedata['id'],'title'=>$title,'describe'=>$describe,'created_at'=>$time);
        $UserJgpush->insertAll($data);
        return true;
    }
    /**
     * 企业到期时间短信通知
     * @return bool
     */
    private function enterpriseTime(){
        $Enterprisemodel =new Enterprise();
        $Protocolmodel =new Protocol();
        $start=date("Y-m-d",strtotime("+1 week"));
        $where =array('status'=>1,'expire'=>$start);
        $data=$Enterprisemodel->getAll($where);
        if(empty($data)){
            return false;
        }
        $Protocoldata=$Protocolmodel->getOne(['enterprise_id'=>0,'type'=>'phone']);
        $Protocoldata=json_decode($Protocoldata['content'],true);
        $obj = new Note;
        $sms_code="SMS_149391072";
        $server=$Protocoldata['phone'];
        foreach ($data as $val){
            if(!empty($val['admin_phone'])){
                $code=array('account'=>$val['name'],'time'=>$val['expire'],'server'=>$server);
                $obj -> sendSms($val['admin_phone'], $code,$sms_code);
            }
        }
        return true;
    }

    /**
     * 检查满足条件的课程
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function courseTask(){
        //新课程（前一天发布的最后1个课程）
        $start=strtotime(date("Y-m-d",strtotime("-1 day")));
        $end=strtotime(date("Y-m-d"));
        $where =array('enterprise_id'=>0,'type'=>1,'status'=>1,'created_at'=>['between',[$start,$end]]);
        $data=Course::where($where)->field(['id','title','describe'])->order("created_at desc")->find();
        if(!empty($data)){
            $res=UserJgpush::where(['uid'=>0,'type'=>1,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        //热门课程（浏览数够200且最新发布1个）
        $where =array('enterprise_id'=>0,'type'=>1,'status'=>1,'reading'=>['>=',200]);
        $data=Course::where($where)->field(['id','title','describe'])->order("created_at desc")->find();
        if(!empty($data)){
            $res=UserJgpush::where(['uid'=>0,'type'=>1,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        //学习数课程（100人且最新发布的1个）
        $where =array('enterprise_id'=>0,'type'=>1,'status'=>1,'look_num'=>['>=',100]);
        $data=Course::where($where)->field(['id','title','describe'])->order("created_at desc")->find();
        if(!empty($data)){
            $res=UserJgpush::where(['uid'=>0,'type'=>1,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        return [];
    }

    /**
     * 检查满足条件的课程
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function classcourseTask(){
        $model=new ClassCourse();
        $model=$model->alias('s')->join('class c','c.id=s.class_id','left');
        $field=['s.title','s.id'];
        //新课程（前一天发布的最后1个课程）
        $start=strtotime(date("Y-m-d",strtotime("-1 day")));
        $end=strtotime(date("Y-m-d"));
        $where =array('c.enterprise_id'=>0,'s.created_at'=>['between',[$start,$end]]);
        $data=$model->where($where)->field($field)->order("s.created_at desc")->find();
        if(!empty($data)){
            $res=UserJgpush::where(['uid'=>0,'type'=>7,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        //热门课程（浏览数够200且最新发布1个）
        $where =array('c.enterprise_id'=>0,'s.reading'=>['>=',200]);
        $model=$model->alias('s')->join('class c','c.id=s.class_id','left');
        $data=$model->where($where)->field($field)->order("s.created_at desc")->find();
        if(!empty($data)){
            $res=UserJgpush::where(['uid'=>0,'type'=>7,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        //学习数课程（100人且最新发布的1个）
        $where =array('c.enterprise_id'=>0);
        $field[]="(select count(*) from tpn_class_user where `class_id`=c.id) as look_num";
        $model=$model->alias('s')->join('class c','c.id=s.class_id','left');
        $data=$model->where($where)->field($field)->order("s.created_at desc,look_num desc")->find();
        if(!empty($data) && $data['look_num']>=100){
            $res=UserJgpush::where(['uid'=>0,'type'=>7,'type_id'=>$data['id']])->find();
            if(empty($res)){
                return $data;
            }
        }
        return [];
    }

}