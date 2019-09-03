<?php
/**
 * [专家]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午4:31
 */

namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\model\LookRecord;
use app\common\model\Teacher as model;
use app\common\model\TeacherCont;
use app\common\model\TeacherType;
use app\common\model\UserQuiz;
use app\common\model\TeacherArticle;

class Teacher extends Api{

    /**
     * 专家委员会
     */
    public function pecialist(){
        if(!$this->param['classify_id']) return ajax("缺少平台分类id",2);
        $this->param['enterprise_id'] = 0;//平台教师
        $this->param['identity'] = 3;//专家
        $this->param['is_xszd'] =0;//专家
        $TeacherModel = new model();
        $model = $TeacherModel->getDataList($this->param);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $TeacherModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        $data['data'] = $TeacherModel->recombineData($data['data'],3);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 扣之问学会成员未查看新人数
     */
    public function isRed(){
        $LookRecordModel = new LookRecord();
        $teacher_id      = $LookRecordModel->where(['uid'=>$this->user['uid']])->value('teacher_id');
        $Teacher = new model();
        $one_num         = $Teacher->where(['enterprise_id'=>0,'is_xszd'=>1,'status'=>1,'id'=>['not in',$teacher_id]])->count();
//        $teacher_type = db('teacher_type')->where(['enterprise_id'=>0])->column("id");
//        $two_num         = $Teacher->where(['enterprise_id'=>0,'status'=>1,'teacher_type'=>['in',$teacher_type],'id'=>['not in',$teacher_id]])->count();

        return ajax("成功",1,['num'=>$one_num]);
    }
    /**
     * 扣之问学会
     */
    public function learnData(){
        $data = [];
        //叩之问学会学术指导委员会成员
        $Teacher = new model();
        $field = [
            "id","name","title","phone","photo"
        ];
        $where=['enterprise_id'=>0,'is_xszd'=>1,'is_zdwy'=>1,'status'=>1];
        $data['xszd']= $Teacher->field($field)->where($where)->order("id desc")->limit(0,6)->select();
        $teacher_id_one= $Teacher->where($where)->column('id');
//        $id=$this->array_convert($data['xszd'],'id','id');
        //叩之问学会成员
//        $teacher_type = db('teacher_type')->where(['enterprise_id'=>0])->column("id");
        $where['is_zdwy']=0;
        $data['xhcy'] = $Teacher->field($field)->where($where)->order("id desc")->limit(0,6)->select()->toArray();
        $teacher_id_two  = $Teacher->where($where)->column('id');
//        $LookRecordModel = new LookRecord();
        $teacher_id = array_merge($teacher_id_one,$teacher_id_two);
        $LookRecordModel = new LookRecord();
        $LookRecordModel->saveData($this->user['uid'],$teacher_id);
        return ajax("获取成功",1,$data);
    }

    /**
     * 扣之问学术指导委员会列表
     */
    public function xszdList(){
        //叩之问学会学术指导委员会成员
        $Teacher = new model();
        $field = [
            "id","name","title","phone","photo"
        ];
        $where=['enterprise_id'=>0,'is_xszd'=>1,'is_zdwy'=>1,'status'=>1];
        $data  = api_page($Teacher,$where,"id desc", $field);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 学术成员分类
     */
    public function xhcyType(){
        $teacher_type = db('teacher_type')->field("id,name")->where(['enterprise_id'=>0])->select()->toArray();
        return ajax('获取成功', 1, ['data'=>$teacher_type]);
    }
    /**
     * 学术成员列表
     */
    public function xhcyList(){
        if(empty($this->param['teacher_type'])) return ajax("请上传分类",2);
        $teacher_type = $this->param['teacher_type'];
        $Teacher      = new model();
        $field = [
            "id","name","title","phone","photo"
        ];
        $where=['enterprise_id'=>0,'is_xszd'=>1,'is_zdwy'=>0,'status'=>1,'teacher_type'=>$teacher_type];
        $data  = api_page($Teacher,$where,"id desc", $field);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 获取老师类型
     * @return \think\response\Json
     */
    public function TeacherType(){
        if(empty($this->param['enterprise_id'])) return ajax("请传企业id",2);
         $TeacherType =new TeacherType();
         $data=$TeacherType->getAll(['enterprise_id'=>$this->param['enterprise_id']]);
         return ajax('获取成功', 1, $data);
    }

    /**
     * 专家委员会列表
     * @return \think\response\Json
     */
    public function TeacherList(){
        if(empty($this->param['enterprise_id'])) return ajax("请传企业id",2);
        $TeacherModel = new model();
        $where=array('enterprise_id'=>['=',$this->param['enterprise_id']],'status'=>1,'is_xszd'=>0,'identity'=>['like',"%3%"]);
        if(!empty($this->param['teacher_type']))$where['teacher_type']=['=',$this->param['teacher_type']];
        $field=array('id','name','nickname','photo','consult_num','brief','level','phone');
        $data  = api_page($TeacherModel,$where,'created_at desc', $field);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 专家详情
     * @return \think\response\Json
     */
    public function TeacherDetails(){
        if(empty($this->param['id'])) return ajax("请传专家id",2);
        $TeacherModel = new model();
        $UserQuiz=new UserQuiz();
        $data=$TeacherModel->getOne(['id'=>$this->param['id']]);
        unset($data['password']);
        $data['evaluate_all']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>['neq',0]])->count();
        $data['evaluate_one']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>1])->count();
        $data['evaluate_two']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>2])->count();
        $data['evaluate_three']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>3])->count();
        $data['evaluate_four']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>4])->count();
        $data['evaluate_five']=$UserQuiz->where(['teacher_id'=>$this->param['id'],'answer'=>['neq',''],'evaluate'=>5])->count();
        return ajax('获取成功', 1, $data);
    }

    /**
     * 内训咨询列表
     * @return \think\response\Json
     */
    public function TeacherQuiz(){
        if(empty($this->param['id'])) return ajax("请传专家id",2);
        $UserQuiz=new UserQuiz();
        $where=array('teacher_id'=>$this->param['id']);
        $field=array('u.nickname','u.face','a.quiz','a.answer','a.created_at');
        $model=$UserQuiz->QuizList($field,$where,'a.created_at desc');
        $total = $model->count();
        $model=$UserQuiz->QuizList($field,$where,'a.created_at desc');
        $data=api_page($model,'','','',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 专家提问
     * @return \think\response\Json
     */
    public function UserQuiz(){
        if($this->user['allot']!=2){
            $msg=$this->user['allot']==1?"因你还未通过后台的审核；所以不能向专家提问":"因你没有通过后台的审核；所以不能向专家提问";
            return ajax($msg, 2);
        }
        if(empty($this->param['teacher_id'])) return ajax("请传专家id",2);
        if(empty($this->param['text'])) return ajax("请填写问题",2);
        $this->param['text']=$this->keywordReplace($this->param['text']);
        $UserQuiz=new UserQuiz();
        $time=time();
        $res=$UserQuiz->addData(['uid'=>$this->user['uid'],'teacher_id'=>$this->param['teacher_id'],'quiz'=>$this->param['text'],'created_at'=>$time,'updated_at'=>$time]);
        if(!$res) return ajax("提问失败",2);
        return ajax("提问成功",1);
    }

    /**
     * 研究动态
     * @return \think\response\Json
     */
    public function TeacherArticle(){
        if(empty($this->param['teacher_id'])) return ajax("请传专家id",2);
        $TeacherArticle=new TeacherArticle();
        $field=array('id','name');
        $data=api_page($TeacherArticle,['teacher_id'=>$this->param['teacher_id'],'class_id'=>0,'status'=>1],'add_time desc',$field);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 主讲课程
     * @return \think\response\Json
     */
    public function TeacherCont(){
        if(empty($this->param['teacher_id'])) return ajax("请传专家id",2);
        $TeacherArticle=new TeacherCont();
        $field=array('id','name');
        $data=api_page($TeacherArticle,['teacher_id'=>$this->param['teacher_id'],'status'=>1],'add_time desc',$field);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }


    /**
     * 评价列表
     * @return \think\response\Json
     */
    public function EvaluateList(){
        if(empty($this->param['id'])) return ajax("请传专家id",2);
        $UserQuiz=new UserQuiz();
        $where=array('teacher_id'=>$this->param['id'],'answer'=>['neq','']);
        if(empty($this->param['evaluate'])){
            $where['evaluate']=['neq',0];
        }else{
            $where['evaluate']=['=',$this->param['evaluate']];
        }
        $field=array('u.nickname','u.face','a.evaluate');
        $model=$UserQuiz->QuizList($field,$where,'a.created_at desc');
        $total = $model->count();
        $model=$UserQuiz->QuizList($field,$where,'a.created_at desc');
        $data=api_page($model,'','','',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 用户评价
     * @return \think\response\Json
     */
    public function Evaluate(){
        if(empty($this->param['id'])) return ajax("请传专家id",2);
        if(empty($this->param['evaluate'])) return ajax("请传评价",2);
        $UserQuiz=new UserQuiz();
        $quiz=$UserQuiz->getOne(['teacher_id'=>$this->param['id'],'evaluate'=>0,'answer'=>['neq',''],'uid'=>$this->user['uid']]);
        if(empty($quiz)) return ajax("没有符合条件评价",2);
        $res=$UserQuiz->editData(['id'=>$quiz['id']],['evaluate'=>$this->param['evaluate'],'updated_at'=>time()]);
        if(!$res) return ajax("评价失败",2);
        return ajax("评价成功",1);
    }

    /**
     * 统计老师质询数量
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function consult(){
        if (!$this->param['id']) return ajax('请上传教师id', 2);
        $model = new model();
        $model->where(['id'=>$this->param['id']])->setInc('consult_num');
        return ajax('统计成功', 1);
    }
}