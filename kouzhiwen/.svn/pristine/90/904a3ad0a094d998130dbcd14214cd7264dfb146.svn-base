<?php
/**
 * [直播控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 15:54:30
 * @Copyright:
 */
namespace app\teacher\course\controller;
use app\teacher\root\controller\Common;
use app\admin\course\model\Course as model;
use app\common\model\ClassCourse;
use app\common\model\Course;
use app\common\extend\Aliyun;
use app\admin\course\model\CourseType;
use app\admin\root\model\Classify;
use app\common\extend\Rongcloudapi;

class Broadcast extends Common{
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
        $type=$this->param['type'];
        $type=$type?$type:1;

        if (!empty($keywords)) {
            $where['title'] = ['like', "%{$keywords}%"];
        }
        if($type==1){
            $streamName='zb_b_';
            $where['s.teacher_id'] = $this->user['id'];
            $where['s.status'] =['in',[1,2]];
            $ClassCourse =new ClassCourse();
            $model=$ClassCourse->alias('s')->join("class c","s.class_id=c.id");
            $field=array("s.id","s.title","s.photo","s.start","s.status","c.name","c.price","s.aliyun_push");
            $data=admin_page($model,$where,"start desc",$field);
        }else{
            $streamName='zb_a_';
            $where['teacher_id'] = $this->user['id'];
            $where['scene'] =['in',[0,1]];
            $where['type'] = 3;
//            $where['start'] = ['<=',time()];
            $field="*";
            $Course=new Course();
            $data=admin_page($Course,$where,"start desc",$field);
        }
        $Aliyun =new Aliyun();
        $time=time();
        if(!empty($data['data'])){
            foreach ($data['data'] as $key=>$val){
                $data['data'][$key]['aliyun_push']=$Aliyun->getPushSteam($streamName.$val['id'],$time);
            }
        }
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $type,
            'time'  => time(),
            'checkVal'  => $this -> checkVal
        ]);
    }


    /**
     * 直播
     * @return \think\response\Json|\think\response\View
     */
    public function web(){
        if(!$this->param['id']){
            return ajax('请传直播id', 2);
        }
        $type=$this->param['type'];
        $type=$type?$type:1;
        $start=time();
        $id=$this->param['id'];
        if($type==1){
            $ClassCourse =new ClassCourse();
            $data=$ClassCourse->getOne(['id'=>$this->param['id']]);
            if(empty($data)){
                return ajax('没有此直播课', 2);
            }
            if($data['start']>time()){
                return ajax('直播课没有到直播时间，请耐心等待', 2);
            }

            $Aliyun =new Aliyun();
            $arr=array('updated_at'=>$start);
            $arr['aliyun_push'] =$Aliyun->getPushSteam("zb_b_$id",$start);
            $arr['aliyun_pulla'] =$Aliyun->getPullSteam("zb_b_$id",$start);
            $ClassCourse -> editData(['id'=>$id],$arr);
        }else{
            $coursemodel= new Course();
            $data=$coursemodel->getOne(['id'=>$this->param['id']]);
            if(empty($data) || $data['type']!=3){
                return ajax('没有此直播课', 2);
            }
            if($data['start']>time()){
                return ajax('直播课没有到直播时间，请耐心等待', 2);
            }
            $Aliyun =new Aliyun();
            $arr=array('updated_at'=>$start);
            $arr['aliyun_push'] =$Aliyun->getPushSteam("zb_a_$id",$start);
            $arr['aliyun_pulla'] =$Aliyun->getPullSteam("zb_a_$id",$start);
            $coursemodel -> editData(['id'=>$id],$arr);
        }

        return ajax('获取成功',1,$data['aliyun_push']);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        $enterprise_id=$this->user['enterprise_id'];
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['created_at'] = time();
            $data['enterprise_id'] =$enterprise_id;
            $data['start'] = strtotime($data['start']);
            $data['teacher_id'] =$this->user['id'];
            $data['type'] =3;
            $data['is_recommend'] =0;
            $data['status'] =0;
            $data['weight'] =0;
            $data['power'] =1;
            $check=array('id','enterprise_id','teacher_id','type','reading','look_num','comment_num','weight','is_recommend','created_at','updated_at','status');
            if($enterprise_id==0){
                $check[]='type_id';
            }else{
                $check[]='classify_id';
            }
            if($data['type']!=3){
                $check[]='start';
            }else{
                $check[]='url';
            }
            // 验证
            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }
            $id=$model -> addData();
            // 添加数据
            if (!$id) return ajax('创建失败', 2);
            if($data['type']==3){
                $Rongcloud =new Rongcloudapi();
                $Aliyun =new Aliyun();
                $Rongcloud->RongCloud->chatroom()->create(["zb_a_$id"=>$data['title']]);
                $updatadata=array();
                $updatadata['aliyun_push'] =$Aliyun->getPushSteam("zb_a_$id",$data['start']);
                $updatadata['aliyun_pulla'] =$Aliyun->getPullSteam("zb_a_$id",$data['start']);
                $model -> editData(['id'=>$id],$updatadata);
            }
            return ajax('创建成功');
        }
        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
        }else{
            $CourseType=new CourseType();
            $type=$CourseType->getAll(['enterprise_id'=>$enterprise_id,'type'=>3]);
            $this -> checkVal['type']=$type;
        }

        return view('', [
            'checkVal'  => $this -> checkVal,
            'enterprise_id'  => $enterprise_id,
        ]);
    }

}