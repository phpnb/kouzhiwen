<?php
/**
 * [班级接口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\extend\Alipay;
use app\common\extend\Wechat;
use app\common\model\Studys;
use app\common\model\ClassType;
use app\common\model\ClassUser;
use app\common\model\Teacher;
use app\common\model\TeacherDetailed;
use app\common\model\Questionnaire;
use app\common\model\QuestionnaireUser;
use app\common\model\Order;
use app\common\model\User;
use app\common\model\UserCollect;
use app\common\model\UserDetailed;
use app\common\model\ClassCourse;
use app\common\model\TeacherArticle;
use app\common\model\Paper;
use app\common\model\PaperUser;
use app\common\model\ClassNotice;
use app\common\model\Sign;
use app\common\model\Advertisements;
use app\common\model\ClassDiscuss;
use app\common\model\ClassDiscussUser;
use app\common\model\UserRanking;
use app\common\model\TeacherCont;
use app\common\model\Ctype;
use app\admin\info\model\Tasks;
use think\Db;
use app\common\model\Zan;

class Study extends Api{

    public $msg="";
    public $data="";



    /**
     * 返回用户学习班结束时间
     * @return \think\response\Json
     */
    public function getclasstime()
    {
        $id = input('id');
        $model = new Studys();
        $data = $model->where('id',$id)->find();
        if(!$data){
            return ajax('获取失败', 1, $data);
        }

        return ajax('获取成功', 1, $data);

    }
    /**
     * 判断学习班用户
     * @return \think\response\Json
     */
    public function anyuid(){
        $cid=input('class_id');
        $model = new Studys();
        $data = $model->where(['id'=>$cid])->field('any_u')->select()->toArray();
        if(!$data['0']['any_u']){
            return ajax('成功', 1);
        }
        $anyu = explode(",",$data['0']['any_u']);
        $uid = $this->user['uid'];
        if(in_array($uid,$anyu)){
            return ajax('成功', 1);
        }else{
            return ajax('暂无权限，请联系后台管理员', 2);
        }
    }

    /**
     * 班级列表
     * @return \think\response\Json
     */
    public function datalist(){
        $usercollect = new UserCollect();
        $class_type_id=input('class_type_id');
        $enterprise_id=input('enterprise_id');
        if($class_type_id){
            $this->param['class_type_id'] = $class_type_id; //班级分类
        }

        $this->param['enterprise_id'] = $this -> user['enterprise_id']; //平台
        if($enterprise_id){
            $this->param['enterprise_id'] =$enterprise_id;
        }

        if($this -> user['enterprise_id'] != $this->param['enterprise_id']){
            $this->param['power']=1;
        }
        $this->param['uid'] = $this->user['uid'];//当前用户
        $this->param['time'] = time();

        $StudysModel = new Studys();
        $model = $StudysModel->getDataList($this->param);
        $total = $model->count();


        //tp5.0会清空上一次的查询条件
        $model =  $StudysModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        foreach ($data['data'] as  $k=>$v){
            $data['data'][$k]['collec']    = $usercollect->where(['type'=>6,'uid'=>$this->param['uid'],'type_id'=>$v['id']])->find()?true:false;
        }
//        $data['collec']    = $data->userCollec()->where(['type'=>6,'uid'=>$this->param['uid'],'type_id'=>$data['id']])->find()?true:false;

        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 获取班级分类
     * @return \think\response\Json
     */
    public function typelist(){
        $classtypemodel=new ClassType();
        $up=$classtypemodel->getAll(['enterprise_id'=>$this ->param['enterprise_id'],'up'=>0]);
        $type=$classtypemodel->getAll(['enterprise_id'=>['=',$this -> param['enterprise_id']],'up'=>['>',0]]);
        $data=array();
        if(!empty($up)){
            foreach ($up as $key=>$val){
                $data[$key]=$val;
                $data[$key]['sub']=array();
                if(!empty($type)){
                    foreach ($type as $v){
                        if($val['id']==$v['up']){
                            $data[$key]['sub'][]=$v;
                        }
                    }
                }

            }
        }

        return ajax('获取成功', 1,$data);
    }


    /**
     * 班级详情
     * @return \think\response\Json
     */
    public function StudyDetails(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $StudysModel = new Studys();
        $classusermodel = new ClassUser();
        $teachermodel = new Teacher();
        //取得班级得数据
        $data=$StudysModel->getOne(['id'=>$id]);
        //查询班级群得所有字段
        $data['count']=$classusermodel->where(['class_id'=>$id])->count();
        //查询满足条件得数据
        $is_apply=$classusermodel->where(['class_id'=>$id,'uid'=>$this->user['uid']])->find();
        $data['is_apply']=empty($is_apply)?0:1;
        $teacher=$teachermodel->getOne(['id'=>$data['teacher_id']]);
        $data['teacher']=$teacher['phone'];
        return ajax('获取成功', 1, $data);
    }

    /**
     * 问卷列表
     * @return \think\response\Json
     */
    public function QuestionnaireList(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $questionnairemodel =new Questionnaire();
        $questionnaireusermodel =new QuestionnaireUser();
        $data=api_page($questionnairemodel,['class_id'=>$id],'','id,title,photo');
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        foreach ($data['data'] as $key=>$val){
            $data['data'][$key]['status']=0;
            if($questionnaireusermodel->getOne(['questionnaire_id'=>$val['id'],'uid'=>$this -> user['uid']])){
                $data['data'][$key]['status']=1;
            }
        }
        return ajax('获取成功', 1, $data);
    }

    /**
     * 问卷详情
     * @return \think\response\Json
     */
    public function QuestionnaireDetails(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $questionnairemodel =new Questionnaire();
        $questionnaireusermodel =new QuestionnaireUser();
        if($questionnaireusermodel->getOne(['questionnaire_id'=>$id,'uid'=>$this -> user['uid']])){
            return ajax('此问卷以答过', 2);
        }
        $data=$questionnairemodel->getOne(['id'=>$id]);
        $data['data']=json_decode($data['data']);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 提交问卷
     * @return \think\response\Json
     */
    public function QuestionnaireAnswer(){
        $id=input('id');
        $data=input('data');
        if (!$id || !$data) return ajax('非法请求', 2);
        $questionnaireusermodel =new QuestionnaireUser();
        $questionnairemodel =new Questionnaire();

        if($questionnaireusermodel->getOne(['questionnaire_id'=>$id,'uid'=>$this -> user['uid']])){
            return ajax('此问卷以答过', 2);
        }
        $questionnaire=$questionnairemodel->getOne(['id'=>$id]);
        $param=array('questionnaire_id'=>$id,'uid'=>$this -> user['uid'],'answer'=>$data,'data'=>$questionnaire['data']);

        $res=$questionnaireusermodel->addData($param);
        if(!$res){
            return ajax('提交问卷失败', 2);
        }
//        (new UserRanking)->updateRanking($this->user['uid'],'blue');
        return ajax('提交问卷成功', 1);
    }

    /**
     * 班级报名
     * @return \think\response\Json
     */
    public function enroll(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $StudysModel = new Studys();
        $classusermodel = new ClassUser();
        $studys=$StudysModel->getOne(['id'=>$id]);
        $user=$classusermodel->getOne(['class_id'=>$id,'uid'=>$this -> user['uid']]);
        if($user){
            return ajax('此班级你以报名', 2);
        }
        $count=$classusermodel->where(['class_id'=>$id])->count();
        if($studys['number']<=$count){
            return ajax('班级报名人数以满', 2);
        }
        if($studys['price']>0){
            $res=$this->AddOrder($studys,1);
            if(!$res){
                return ajax($this->msg, 2);
            }
            return ajax($this->msg, 1,$this->data);
        }
        $time=time();
        $data=array('class_id'=>$id,'uid'=>$this -> user['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
        $res=$classusermodel->addData($data);
        if(!$res){
            return ajax('报名失败', 2);
        }
        return ajax('报名成功', 1);
    }

    /**
     * 课程列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ClassCourseList(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        //课程
        $classcoursemode=new ClassCourse();
        $classusermodel = new ClassUser();
        $usercollect = new UserCollect();
        $teacherarticlemodel = new TeacherArticle();
        //学习班
        $StudysModel = new Studys();
        $signmode=new Sign();
        $ctype = new Ctype();

        $user=$classusermodel->getOne(['class_id'=>$id,'uid'=>$this -> user['uid']]);


        if(!$user){
            return ajax('此班级你未报名', 2);
        }
        $data=array();
        $studys=$StudysModel->getOne(['id'=>$id]);


        //检测是否签到
        $data['sign']=1;
//        $course=$classcoursemode->getOne(['class_id'=>['=',$id],'status'=>['=',2],'start'=>['<=',time()]]);
//        if(empty($course)) {
//            $data['sign']=2;
//        }
//        $course_id=$course['id'];
        $res=$signmode->getOne(['class_id'=>$id,'uid'=>$this -> user['uid'],'date'=>date("Y-m-d")]);
        if(!empty($res)){
            $data['sign']=3;
        }
        $data['sign_count']=$signmode->where(['class_id'=>$id,'date'=>date("Y-m-d")])->count();
        $data['name']=$studys['name'];
        $data['number']=$studys['number'];
        $data['type']=$studys['type'];

        $data['cours']=$classcoursemode->courselist('c.id,c.title,c.photo,c.reading,c.status',['c.class_id'=>$id],'c.sort');
        foreach ($data['cours'] as  $k=>$v){
            $data['cours'][$k]['collec']    = $usercollect->where(['type'=>7,'uid'=>$this -> user['uid'],'type_id'=>$v['id']])->find()?true:false;
        }



        foreach ($data['cours']  as $key =>  $value){

            $where1 = [
                'cid' => $value['id'],
                'uid' => $this -> user['uid'],
            ];

           $infos =  $ctype -> where($where1)->find();


//            $value['ctype'] = $infos['ctype']== null ? 1 :$infos['ctype']  ;

            $data['cours'][$key]['ctype'] = $infos['ctype'] == null ? 1 :$infos['ctype']  ;

        }


        ///dump($data['cours']);die;
        $data['ranking']=$classusermodel->rankingList(['c.class_id'=>$id]);
        $data['article']=$teacherarticlemodel->field('id,name,contents,phone,add_time,comment_num,pv,lookeva')->where(['class_id'=>$id,'status'=>1])->limit("0,1")->order('add_time desc')->select()->toArray();

        return ajax('获取成功', 1,$data);
    }


    /**
     * 学习任务
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ClassCourseTasks(){
        $model = new Tasks();
        $id = $this->user['uid'];
        $where =['uid'=>$id];
        $data = $model->where($where)->select()->toArray();
        if(!$data){
            return ajax('暂无任务', 2);
        }
        foreach ($data as $v){
        }
        $res = explode(",",$v['cid']);
        $classcourse = new ClassCourse();
        $ags =  $classcourse->where('id',in,$res)->select()->toArray();

        return ajax('获取成功', 1,$ags);
    }


    /**
     * 论文评级
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function thesisrating(){
        $id=input('id');
        $lookeva = input('lookeva');
        $uid = input('user_id');
        if (!$id) return ajax('请上传id', 2);
        $teacherarticlemodel = new TeacherArticle();
        $where =['id'=>$id];
        $data = $teacherarticlemodel->editData($where,['lookeva'=>$lookeva]);
        $UserRanking = new UserRanking();
        (new UserRanking)->updateRanking($uid,'red');
        $UserRanking->editData(['uid'=>$data['uid']],['red'=>$lookeva]);

        if(!$data){
            return ajax('评论失败', 2);
        }
        return ajax('评论成功', 1);
    }


    /**
     * 获取考试列表
     * @return \think\response\Json
     */
    public function PaperList(){
        $id=input('id');
        $type=input('type');
        if (!$id || !$type) return ajax('非法请求', 2);
        $papermodel=new Paper();
        $where=['p.type'=>$type,'p.class_id'=>$id];
        $where['p.start_time']=['<=',date("Y-m-d H:i")];
        $where['p.end_time']=['>=',date("Y-m-d H:i")];
        $data=$papermodel->exam($this -> user['uid'],$where);
        $arr=array();
        foreach ($data as $key=>$val){
            if(!empty($this->param['exam'])){
                if($this->param['exam']==1 && $val['num']>0){//未考试
//                    unset($data[$key]);
                    continue;
                }else if($this->param['exam']==2 && $val['num']==0){//已考试
//                    unset($data[$key]);
                    continue;
                }
            }
            $arr[]=$data[$key];

        }
        return ajax('获取成功', 1,$arr);
    }

    /**
     * 考试详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function PaperDetails(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $papermodel=new Paper();
        $paperusermodel=new PaperUser();
        $paper=$papermodel->getOne(['id'=>$id]);
        if(empty($paper))return ajax('没有此考试', 2);
        $paper['data']=json_decode($paper['data']);
        $paperusercount=$paperusermodel->where(['paper_id'=>$id,'uid'=>$this -> user['uid']])->count();
        $paperuser=array();
        $mun=3;
        if($paperusercount>0){
            $paperuser=$paperusermodel->getOne(['paper_id'=>$id,'uid'=>$this -> user['uid'],'status'=>1]);

            if(empty($paperuser)){
                if($paperusercount>=3){
                    $mun=0;
                    $paperuser=$paperusermodel->where(['paper_id'=>$id,'uid'=>$this -> user['uid']])->order('created_at desc')->find();
                }else{
                    $paperuser=$paperusermodel->where(['paper_id'=>$id,'uid'=>$this -> user['uid']])->order('created_at desc')->find();
                    $mun=$mun-$paperusercount;
                }
            }
        }
        if(empty($paperuser))$paperuser=(object)[];

        return ajax('获取成功', 1,['user'=>$this -> user['face'],'paper'=>$paper,'paperuser'=>$paperuser,'num'=>$mun]);
    }

    /**
     * 考试内容
     * @return \think\response\Json
     */
    public function PaperContent(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $papermodel=new Paper();
        $paper=$papermodel->getOne(['id'=>$id]);
        return ajax('获取成功', 1,$paper);
    }

    /**
     * 考试结果
     * @return \think\response\Json
     */
    public function PaperResult(){
        $id=input('id');
        $result=input('result');
        if (!$id || !$result) return ajax('非法请求', 2);
        $papermodel=new Paper();
        $paperusermodel=new PaperUser();
        $paper=$papermodel->getOne(['id'=>$id]);
        $status=3;
        $paperusercount=$paperusermodel->where(['paper_id'=>$id,'uid'=>$this -> user['uid']])->count();
        if($paperusercount>=3){
            return ajax('您的三次考试机会以用完', 2);
        }
        $mun=2-$paperusercount;
        $time=time();
        $paperuser=['paper_id'=>$id,'uid'=>$this -> user['uid'],'data'=>$paper['data'],'result'=>$result,'status'=>$status,'created_at'=>$time,'updated_at'=>$time];
        $res=$paperusermodel->addData($paperuser);
        if(!$res){
            return ajax('提交失败', 2);
        }
        return ajax('提交成功', 1,['paper'=>$paper,'paperuser'=>$paperuser,'num'=>$mun]);
    }

    /**
     * 班级通知
     * @return \think\response\Json
     */
    public function NoticeList(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $classnoticemodel=new ClassNotice();
        $data=$classnoticemodel->getAll(['class_id'=>$id],'created_at desc');
        return ajax('提交成功', 1,$data);
    }

    /**
     * 通知详情
     * @return \think\response\Json
     */
    public function NoticeDetails(){
        $id=input('id');
        $OS = input('OS');
        $version = input('version');
        if (!$id) return ajax('非法请求', 2);
        $classnoticemodel=new ClassNotice();
        $teachermodel=new Teacher();

        $data=$classnoticemodel->getOne(['id'=>$id]);
        $teacher=$teachermodel->getOne(['id'=>$data['teacher_id']]);
        $data['teacher_name']=$teacher['name'];
        $pay=true;
        $user=[];
        if($OS == 'iOS' || $version == '1.0'){
            $pay=false;
            return ajax('提交成功', 1,['notice'=>$data,'user'=>$user,'id_pay'=>$pay]);
        }
        if($data['price']>0){
            $ordermodel=new Order();
            $field=array('u.nickname','u.face');
            $user=$ordermodel->EnrollUser($field,['o.type_id'=>$id,'o.type'=>3,'o.pay_status'=>2],'o.created_at desc');
            $pay=$ordermodel->getOne(['type'=>3,'type_id'=>$id,'uid'=>$this -> user['uid'],'pay_status'=>2])?false:true;
        }
        return ajax('提交成功', 1,['notice'=>$data,'user'=>$user,'id_pay'=>$pay]);
    }

    /**
     * 班级通知报名
     * @return \think\response\Json
     * @throws \think\exception\PDOException
     */
//    public function NoticeEnroll(){
//        if (!$this -> isPost) return ajax('非法请求', 2);
//        $id=input('id');
//        if (!$id) return ajax('非法请求', 2);
//        $ordermodel=new Order();
//        $classnoticemodel=new ClassNotice();
//        $res=$ordermodel->getOne(['type'=>3,'type_id'=>$id,'uid'=>$this -> user['uid'],'pay_status'=>2]);
//        if($res){
//            return ajax('以报名', 1);
//        }
//        $notice=$classnoticemodel->getOne(['id'=>$id]);
//        if($notice['price']<=0){
//            return ajax('非法请求', 2);
//        }
//        $res=$this->AddOrder(['id'=>$notice['id'],'price'=>$notice['price'],'name'=>$notice['title']],3);
//        if(!$res){
//            return ajax($this->msg, 2);
//        }
//        return ajax($this->msg, 1,$this->data);
//
//    }

    /**
     * 班级热点
     * @return \think\response\Json
     */
    public function ClassHot(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);

        $teacherarticlemodel = new TeacherArticle();
        $data=api_page($teacherarticlemodel,['class_id'=>$id],'add_time desc',['id','contents','name','phone','add_time','comment_num','pv','lookeva']);
        return ajax('获取成功', 1,$data);
    }

    /**
 * 热点详情
 * @return \think\response\Json
 * @throws \think\Exception
 */
    public function HotDetails(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
        $uid =  $this->user['uid'];
        $teacherarticlemodel = new TeacherArticle();
        $teacherarticlemodel->where(['id'=>$id])->setInc('pv');
        $data=$teacherarticlemodel->getOne(['id'=>$id]);
        $Usermodel=new User();
        $user=$Usermodel->getOne(['phone'=>$data['tel']]);
        $data['uid'] = $user['uid'];
        $zan = new Zan();
        $zanmodel = $zan->where(['uid'=>$uid,'cid'=>$this->param['id'],'type'=>2])->field('z_type')->select()->toArray();
        if($zanmodel[0]['z_type'] ==1){
            $data['z_type'] = 1;
        }else{
            $data['z_type'] = 0;
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 主讲详情
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function NoDetails(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);

        $teacherarticlemodel = new TeacherCont();
        $Teacheremodel = new Teacher();
        $teacherarticlemodel->where(['id'=>$id])->setInc('pv');
        $data=$teacherarticlemodel->getOne(['id'=>$id]);
        $data['teacher']=$Teacheremodel->getOne(['id'=>$data['teacher_id']]);
        return ajax('获取成功', 1,$data);
    }

    /**
     * 用户签到
     * @return \think\response\Json
     */
    public function sign(){
        $id=input('id');
        if (!$id) return ajax('非法请求', 2);
//        $classcoursemode=new ClassCourse();
        $signmode=new Sign();
//        $course=$classcoursemode->getOne(['class_id'=>['=',$id],'status'=>['=',2],'start'=>['<=',time()]]);
//        if(empty($course)) return ajax('当前没有直播课不能签到', 2);
//        $course_id=$course['id'];
        $date=date("Y-m-d");
        $res=$signmode->getOne(['class_id'=>$id,'uid'=>$this -> user['uid'],'date'=>$date]);
        if($res)return ajax('已签到过', 1);
        $res=$signmode->addData(['class_id'=>$id,'uid'=>$this -> user['uid'],'date'=>$date,'created_at'=>time()]);
        if(!$res){
            return ajax('签到失败', 2);
        }
        return ajax('签到成功', 1);
    }

    /**
     * 送礼物
     * @return \think\response\Json
     * @throws \think\exception\PDOException
     */
    public function gratuity(){
        $id=input('id');
        $price=input('price');
        if (!$id | !$price) return ajax('非法请求', 2);
        $res=$this->AddOrder(['id'=>$id,'price'=>$price,'name'=>'礼物'],5);
        if(!$res){
            return ajax($this->msg, 2);
        }
        return ajax($this->msg, 1,$this->data);
    }

    /**
     * 广告报名
     * @return \think\response\Json
     * @throws \think\exception\PDOException
     */
//    public function AdvertisementsEnroll(){
//        if (!$this->param['id']) return ajax('非法请求', 2);
//        $Advertisements=new Advertisements();
//        $Order=new Order();
//        $res=$Order->getOne(['type'=>6,'type_id'=>$this->param['id'],'uid'=>$this->user['uid'],'pay_status'=>2]);
//        if (!empty($res)) return ajax('已报名，不能在报名', 2);
//        $data=$Advertisements->getOne(['id'=>$this->param['id']]);
//        if ($data['price']<=0) return ajax('报名金额不能小于等于零', 2);
//        $res=$this->AddOrder(['id'=>$this->param['id'],'price'=>$data['price'],'name'=>'报名'],6,0);
//        if(!$res){
//            return ajax($this->msg, 2);
//        }
//        return ajax($this->msg, 1,$this->data);
//    }

    /**
     * 获取当前班级讨论组
     * @return \think\response\Json
     */
    public function ClassDiscuss(){
        if (!$this->param['id']) return ajax('非法请求', 2);
        $ClassDiscuss =new ClassDiscuss();
        $where=array('d.class_id'=>$this->param['id'],'u.user_id'=>$this->user['uid'],'u.type'=>1);
        $data=$ClassDiscuss->alias("d")->field("d.*")->join("class_discuss_user u","d.id=u.discuss_id","left")
            ->where($where)->order("d.created_at asc")->select();
//        $data=$ClassDiscuss->getAll(['class_id'=>$this->param['id']]);
        $data=empty($data)?[]:$data;
        return ajax($this->msg, 1,$data);
    }

    /**
     * 获取所有班级讨论组
     * @return \think\response\Json
     */
    public function AllClassDiscuss(){
        $ClassDiscuss =new ClassDiscuss();
        $where=array('u.user_id'=>$this->user['uid'],'u.type'=>1);
        $data=$ClassDiscuss->alias("d")->field("d.*")->join("class_discuss_user u","d.id=u.discuss_id","left")
            ->where($where)->order("d.created_at asc")->select();
        foreach ($data as $k=>$v){
            $classdiscussuser = new ClassDiscussUser();
            $user_id = $classdiscussuser->alias('u')->join('user y','u.user_id=y.uid')->where(['discuss_id'=>$v['id']])->field('face')->limit(4)->select()->toArray();
            $data[$k]['face'] = $user_id;

        }
        $data=empty($data)?[]:$data;
        return ajax($this->msg, 1,$data);

    }

    /**
     * 讨论组或班级成员
     * @return \think\response\Json
     */
    public function DiscussUser(){
        if (!$this->param['id'] || !$this->param['type']) return ajax('非法请求', 2);
        if($this->param['type']==1){
            $Studys= new Studys();
            $ClassUser= new ClassUser();
            $ClassCourse= new ClassCourse();
            $teacherid=$ClassCourse->getAll(['class_id'=>$this->param['id']]);
            $datastudys=$Studys->getOne(['id'=>$this->param['id']]);
            $teacherid=$this->array_convert($teacherid,'teacher_id','teacher_id');
            $teacherid[]=$datastudys['teacher_id'];
            $data=$ClassUser->UserList(['c.class_id'=>$this->param['id']],$teacherid,$datastudys['teacher_id']);
        }else{
            $ClassDiscussUser=new ClassDiscussUser();
            $data=$ClassDiscussUser->Userlist(['discuss_id'=>$this->param['id']]);
        }

        return ajax($this->msg, 1,$data);
    }

    /**
     * 获取当前群员信息
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function DiscussDetails(){
        if (!$this->param['id'] || !$this->param['type']) return ajax('非法请求', 2);
        if($this->param['type']==1){
            $User =new User();
            $data=$User->field(['uid as id','face as photo','name','name_hide','nickname','sex','company_name','unit_title','email'])->where(['uid'=>$this->param['id']])->find();
            $data->ranking;
        }else{
            $Teacher =new Teacher();
            $data=$Teacher->field(['id','photo','name','nickname','sex','company_name','unit_title','email'])->where(['id'=>$this->param['id']])->find();
        }
        return ajax($this->msg, 1,$data);
    }


    /**
     * 添加订单
     * @param $studys
     * @return bool
     * @throws \think\exception\PDOException
     */
    private function AddOrder($studys,$type,$enterprise_id=''){
        $param = input('post.');
        $msg=array(
            1=>['r'=>'报名失败','e'=>'报名成功'],
            3=>['r'=>'报名失败','e'=>'报名成功'],
            5=>['r'=>'送礼物失败','e'=>'送礼物成功'],
            6=>['r'=>'报名失败','e'=>'报名成功'],
        );
        $pay_type=array(1,2,3);

        if(empty($param['type']) || !in_array($param['type'],$pay_type)){
            $this->msg="非法请求";
            return false;
        }
        $ordermodel=new Order();
        $usermodel = new User();
        if($param['type']==3 && $studys['price']>$this -> user['balance']){
            $this->msg="余额不足！";
            return false;
        }
        $time=time();
        $order_number=create_order_num();
        $pay_status=1;
        $ordermodel->startTrans();
        if($param['type']==3){

            $userdetailedmodel = new UserDetailed();
            $classusermodel = new ClassUser();
            $balance=$this -> user['balance']-$studys['price'];
            $res=$usermodel->editData(['uid'=>$this -> user['uid']],['balance'=>$balance,'updated_at'=>$time]);
            if(!$res){
                $this->msg=$msg[$type]['r'];
                $ordermodel->rollBack();
                return false;
            }

            $res=$userdetailedmodel->addData(['uid'=>$this -> user['uid'],'type'=>1,'title'=>$studys['name'],'price'=>$studys['price'],'created_at'=>$time]);

            if(!$res){
                $this->msg=$msg[$type]['r'];
                $ordermodel->rollBack();
                return false;
            }

            if($type==1){
                //班级报名
                $data=array('class_id'=>$studys['id'],'uid'=>$this -> user['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
                $res=$classusermodel->addData($data);
                if(!$res){
                    $this->msg=$msg[$type]['r'];
                    $ordermodel->rollBack();
                    return false;
                }
            }elseif ($type==5){
                $Teachermodel= new Teacher();
                $TeacherDetailedmodel= new TeacherDetailed();
                $teacher=$Teachermodel->getOne(['id'=>$studys['id']]);
                $balance=$teacher['money']+$studys['price'];
                $res=$Teachermodel->editData(['id'=>$studys['id']],['money'=>$balance,'updated_at'=>$time]);
                if(!$res){
                    $this->msg=$msg[$type]['r'];
                    $ordermodel->rollBack();
                    return false;
                }
                $res=$TeacherDetailedmodel->addData(['teacher_id'=>$studys['id'],'type'=>2,'title'=>$studys['name'],'price'=>$studys['price'],'created_at'=>$time]);

                if(!$res){
                    $this->msg=$msg[$type]['r'];
                    $ordermodel->rollBack();
                    return false;
                }
            }

            $pay_status=2;
        }else if($param['type']==1){
            $obj = new Alipay;
            $this->data=$obj->createAppPay(['subject'=>$studys['name'],'out_trade_no'=>$order_number,'total_amount'=>$studys['price']]);
        }else if($param['type']==2){
            $obj = new Wechat;
            $this->data=$obj->createAppPay(['subject'=>$studys['name'],'body'=>$studys['name'],'out_trade_no'=>$order_number,'total_amount'=>$studys['price']]);
        }
        if(!isset($enterprise_id)){
            $enterprise_id=$this -> user['enterprise_id'];
        }

        $res=$ordermodel->addData(['order_number'=>$order_number,
            'enterprise_id'=>$enterprise_id,
            'type'=>$type,
            'type_id'=>$studys['id'],
            'name'=>$studys['name'],
            'uid'=>$this -> user['uid'],
            'price'=>$studys['price'],
            'pay_type'=>$param['type'],
            'pay_status'=>$pay_status,
            'created_at'=>$time,
            'updated_at'=>$time]);
        if(!$res){
            $this->msg=$msg[$type]['r'];
            $ordermodel->rollBack();
            return false;
        }

        $ordermodel->commit();
        $this->msg=$msg[$type]['e'];
        return true;
    }



}