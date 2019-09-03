<?php
/**
 * [用户列表接口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\extend\Alipay;
use app\common\extend\Wechat;
use app\common\model\Charts;
use app\common\model\ClassCourse;
use app\common\model\ClassUser;
use app\common\model\Note;
use app\common\model\Order;
use app\common\model\PaperUser;
use app\common\model\User as model;
use app\common\model\UserQuiz;
use app\common\model\UserCollect;
use app\common\model\UserRanking;
use app\common\model\UserRecord;
use app\common\model\UserShare;
use app\common\model\UserNotice;
use app\common\model\Regions;
use app\common\extend\Rongcloudapi;
use app\common\model\ClassifyUser;
use app\common\model\UserNorm;
use app\common\model\Introduce;
use app\common\model\TeacherArticle;
use app\common\model\CourseTime;
use app\common\model\Ctype;
use think\Db;
use app\common\model\Department;

class User extends Api{


    /**
     * 获取当前用户已付费的课程
     */
    public function mybuy(){
        if(!$this->param['course_type'])return ajax("缺少课程类型",2); //1、专业知识课 2、选修课'

        $OrderModel = new Order();
        $model = $OrderModel->getDataList(2,$this->param,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $OrderModel->getDataList(2,$this->param,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 获取当前用户资料
     */
    public function myInfo(){
        $Regionsmodel =new Regions();
        $add=$Regionsmodel->getAll();
        $add=$this->array_convert($add,'id','title');
        $this->user['company_add_text']='';
        $this->user['address_text']='';
        if(!empty($this->user['company_add'])){
            $addarray=explode(',',$this->user['company_add']);
            $this->user['company_add_text']=$add[$addarray[0]].$add[$addarray[1]].$add[$addarray[2]];
        }
        if(!empty($this->user['address'])){
            $addarray=explode(',',$this->user['address']);
            $this->user['address_text']=$add[$addarray[0]].$add[$addarray[1]].$add[$addarray[2]];
        }
        $this -> user['info']=true;
        if(empty($this -> user['name']) || empty($this -> user['phone'])){
            $this -> user['info']=false;
        }

        return ajax('获取成功', 1, $this -> user);
    }
    /**
     * 地区部门
     */
    public function region(){
        $Regionsmodel =new Regions();
        $add=$Regionsmodel->where(['pid'=>0])->select()->toArray();
        $department = new Department();
        if(!$this->param['enterprise_id']){
            $res = $department->where(['enterprise_id'=>'0'])->select()->toArray();
        }else{
            $res = $department->where(['enterprise_id'=>$this->param['enterprise_id']])->select()->toArray();
        }
        $data['department_id'] = $res;
        $data['regions_id'] = $add;

        return ajax('获取成功', 1, $data);
    }
    /**
     *  完善信息
     * @return \think\response\Json
     */
    public function perfectInfo(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        // 请求数据
        $param = input('post.');

        // 用户管理模型
        $model = new model;
        $where=['phone','password','face'];
        if(isset($param['name_hide'])){
            $param=array(
                'name' => $param['name'],
                'email' => $param['email'],
                'name_hide'=>$param['name_hide'],
                'nickname'=>$param['nickname'],
                'school'=>$param['school'],
                'oph'=>$param['oph'],
                'education'=>$param['education'],
                'unit_title'=>$param['unit_title'],
                'company_name'=>$param['company_name'],
                'company_introduce'=>$param['company_introduce'],
                'company_add'=>$param['company_add'],
                'company_adddetailed'=>$param['company_adddetailed'],
                'address'=>$param['address'],
                'address_detailed'=>$param['address_detailed'],
                'department_id'=>$param['department_id'],
                'Regions_id'=>$param['Regions_id'],
            );
            $where=['phone','password','name','face','identity','sex','birth','tel','id_photo_pos','id_photo_neg'];
        }
        if(empty($this->user['name'])){
            $param['name']=$param['name'];
            unset($where['name']);
        }
//        if(empty($this->user['identity'])){
//            $param['identity']=$param['identity'];
//            unset($where['identity']);
//        }
        //用户未分配企业时可以任意修改个人信息
        if($this->user['allot'] !=2){
            $param = input('post.');
            $param['allot']=1;
            $where=['phone','password','face'];
        }
        // 数据验证
        if (!$model -> checkData($param,$where)) {
            return ajax($model -> err, 2);
        }
        $param['updated_at']=time();
        $res=$model->editData(['uid'=> $this ->user['uid']],$param);
        if(!$res){
            return ajax('完善信息失败', 2);
        }
        //更新个人信息
        $Rongcloud =new Rongcloudapi();
        $uid="u_".$this ->user['uid'];
        $face=input('server.REQUEST_SCHEME') . '://' .input('server.SERVER_NAME').$param['face'];
        $Rongcloud->RongCloud->user()->refresh($uid, $param['nickname'], $face);

        $user=$model->getOne(['uid'=> $this ->user['uid']]);
        unset($user['password']);
        $user['info']=true;
        if(empty($user['name']) || empty($user['phone'])){
            $user['info']=false;
        }
        return ajax('修改成功', 1,$user);
    }

    /**
     * 修改用户头像
     */
    public function updFace(){
        if(!$this->param['face'])return ajax("上传用户头像",2);
        $face = $this->param['face'];
        $model= new model;
        $rs   = $model->where(['uid'=>$this->user['uid']])->update(['face'=>$face]);
        if($rs===false) return ajax("头像保存失败",2);
        return ajax("头像保存成功",1);
    }

    /**
     * 修改用户头像
     */
    public function updbackground(){
        if(!$this->param['background'])return ajax("上传用户背景图片",2);
        $face = $this->param['background'];
        $model= new model;
        $rs   = $model->where(['uid'=>$this->user['uid']])->update(['background'=>$face]);
        if($rs===false) return ajax("背景保存失败",2);
        return ajax("背景保存成功",1);
    }

    /**
     * 我的互动 我的问答
     */
    public function quizData(){
        $UserQuizModel = new UserQuiz();
        $model = $UserQuizModel->getDataList($this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $UserQuizModel->getDataList($this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 我的课程
     */
    public function courseData(){
        if(!$this->param['course_type'])return ajax("缺少课程类型",2); //1、专业知识课 2、选修课'

        $OrderModel = new Order();
        $model = $OrderModel->getDataList(2,$this->param,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $OrderModel->getDataList(2,$this->param,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }


    /**
     * 我的班级
     */
    public function classData(){
        $ClassUserModel = new ClassUser();
        $model = $ClassUserModel->getDataList($this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $ClassUserModel->getDataList($this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 删除学习班记录
     * @return \think\response\Json
     */
    public function deleteClass(){
        if (!$this -> isPost) return ajax('非法请求');
        if (empty($this -> param['id'])) return ajax('请传id',2);
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        $data=array('delete'=>2,'updated_at'=>time());
        $ClassUserModel = new ClassUser();
        if (!$ClassUserModel -> editData($where,$data)) return ajax('删除失败');
        return ajax('删除成功');
    }

    /**
     * 我的考试
     */
    public function paperData(){
        $PaperUserModle = new PaperUser();
        $model = $PaperUserModle->getUserDataList($this->user['uid'],$this->param['type']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $PaperUserModle->getUserDataList($this->user['uid'],$this->param['type']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 添加收藏
     * @return \think\response\Json
     */
    public function addCollect(){
        if(!$this->param['id'] || !$this->param['type']) return ajax("缺少必要参数",2);
        $usercollectmodel=new UserCollect();
        $where=array('uid'=>$this->user['uid'],'type'=>$this->param['type'],'type_id'=>$this->param['id']);
        $collect=$usercollectmodel->getOne($where);
        if(empty($collect)){
            $res=$usercollectmodel->addData(['uid'=>$this->user['uid'],'type'=>$this->param['type'],'type_id'=>$this->param['id'],'created_at'=>time()]);
            if(!$res) return ajax('收藏失败', 2);
            return ajax('收藏成功', 1);
        }else{
            $res=$usercollectmodel->delData($where);
            if(!$res) return ajax('取消收藏失败', 2);
            return ajax('取消收藏成功', 1);
        }

    }

    /**
     * 用户收藏
     */
    public function oneuserCollect(){
        $UserColectModle = new UserCollect();
        $model = $UserColectModle->getUserData($this->user['uid'],$this->param['type']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $UserColectModle->getUserData($this->user['uid'],$this->param['type']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 用户收藏
     */
    public function userCollect(){
        if(!$this->param['type'])return ajax("缺少收藏类型",2);
        $UserColectModle = new UserCollect();
        $model = $UserColectModle->getUserData($this->user['uid'],$this->param['type']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $UserColectModle->getUserData($this->user['uid'],$this->param['type']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 取消收藏
     */
    public function  cancelCollect(){
        if(empty($this->param['id'])) return ajax("请选择收藏内容",2);
        $id = explode(',',$this->param['id']);
        $UserColectModle = new UserCollect();
        $where = [
            'id'=>['in',$id],
            'uid'=>$this->user['uid']
        ];
        $rs = $UserColectModle->where($where)->delete();
        return ajax("删除收藏成功",1);
    }

    /**
     * 消费明细 & 充值明细
     */
    public function userDetailed(){
        if(empty($this->param['type'])) return ajax("请选择类型",2);
        $model = db('user_detailed');
        $where = ['type'=>$this->param['type'],'uid'=>$this->user['uid']];
        $data  = api_page($model,$where,"id desc");
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 消费明细 & 充值明细
     */
    public function intDetailed(){
        $model = db('int_detailed');
        $where = ['uid'=>$this->user['uid']];
        $data  = api_page($model,$where,"id desc");
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 用户充值
     */
    public function recharge(){
        if(empty($this->param['pay_type'])) return ajax("请选择支付方式",2);
        if(empty($this->param['money'])) return ajax("请选择充值金额",2);
        $pay_type = $this->param['pay_type'];
        $price    =$this->param['money'];
        $ordermodel= new Order();
        $time=time();
        $order_number=create_order_num();
        $pay_status=1; //支付状态 1-未支付 2-已支付

        $sign = "";
        if( $pay_type==1){
            $obj  = new Alipay();
            $sign =$obj->createAppPay(['subject'=>"充值",'out_trade_no'=>$order_number,'total_amount'=>$price]);
        }else if($pay_type==2){
            $obj  = new Wechat();
            $sign =$obj->createAppPay(['subject'=>"充值",'body'=>"",'out_trade_no'=>$order_number,'total_amount'=>$price]);
        }
        $order = ['order_number'=>$order_number,
            'enterprise_id'     =>$this -> user['enterprise_id'],
            'type'              =>4,
            'type_id'           =>$this -> user['uid'],
            'name'              =>'充值',
            'uid'               =>$this -> user['uid'],
            'price'             =>$price,
            'pay_type'          =>$pay_type,
            'pay_status'        =>$pay_status,
            'created_at'        =>$time,
            'updated_at'        =>$time
        ];
        $res = $ordermodel->addData($order);
        if(!$res)return ajax("充值失败",2);
        return ajax("下单成功",1,$sign);
    }

    /**
     * 意见反馈
     */
    public function feedback(){
        if(empty($this->param['contents'])) return ajax("请输入反馈内容",2);
        $db   = db('user_feedback');
        $data = [
            'uid'           => $this->user['uid'],
            'enterprise_id' => 0,
            'contents'      => $this->param['contents'],
            'created_at'    => time(),
        ];
        $id = $db->insertGetId($data);
        if(!$id){
            return ajax("提交失败",2);
        }
        return  ajax("提交成功",1);
    }

    /**
     * 用户获奖记录
     */
    public function userGift(){
        $model = db('user_gift');
        $data  = api_page($model,['uid'=>$this->user['uid']],"id desc");
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 学习记录
     */
    public function userRecord(){
        if(empty($this->param['year'])) return ajax("请选择年份",2);
        $data = [];
        //1、考试记录
        $PaperUser     = new PaperUser();
        $data['paper'] =  $PaperUser->getDataList($this->user['uid'],$this->param)->limit(0,3)->select()->toArray();
//        //2、发现公开课
//        $Introduce    = new Introduce();
//        $TeacherArticle    = new TeacherArticle();
//        $data['introduce'] = $Introduce->user_Introduce(['phone'=>$this->user['phone']]);
        //2、学习班
        $Introduce    = new Introduce();
        $TeacherArticle    = new TeacherArticle();
        $data['introduce'] = $Introduce->user_Introduce(['phone'=>$this->user['phone']]);
        //3、班级热点
        $data['teacher_article'] = $TeacherArticle->where(['class_id'=>['>',0],'phone'=>$this->user['phone']])->field("*")->limit(0,3)->select()->toArray();
        //4、分享记录
        $UserShare     = new UserShare();
        $data['share'] = $UserShare->getDataList($this->param,$this->user['uid'])->limit(0,3)->select()->toArray();
        $data['share'] = $UserShare->regroupData($data['share']);
        //5、班级考试平均分记录
        $data['avgScore'] = $PaperUser->classAvgScore($this->user['uid'],$this->param)->limit(0,3)->select()->toArray();
        return ajax("成功",1,$data);
    }

    /**
     * 考试记录
     */
    public function paperRecord(){
        $PaperUser     = new PaperUser();
        $model = $PaperUser->getDataList($this->user['uid'],$this->param);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $PaperUser->getDataList($this->user['uid'],$this->param);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 发现公开课
     */
    public function introduceRecord(){
//        $UserRecord    = new UserRecord();
        $Introduce    = new Introduce();
//        $model = $UserRecord->getDataList(['type'=>4,'year'=>$this->param['year']],$this->user['uid']);
//        $total = $model->count();
        //tp5.0会清空上一次的查询条件
//        $model =  $UserRecord->getDataList(['type'=>4,'year'=>$this->param['year']],$this->user['uid']);
        $data  = api_page($Introduce,['phone'=>$this->user['phone']],'add_time desc', '*');
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 班级热点
     */
    public function teacherArticle(){
//        $UserRecord    = new UserRecord();
//        $model = $UserRecord->getDataList(['type'=>5,'year'=>$this->param['year']],$this->user['uid']);
//        $total = $model->count();
//        //tp5.0会清空上一次的查询条件
//        $model =  $UserRecord->getDataList(['type'=>5,'year'=>$this->param['year']],$this->user['uid']);
        $TeacherArticle    = new TeacherArticle();
        $data  = api_page($TeacherArticle,['class_id'=>['>',0],'phone'=>$this->user['phone']],'add_time desc', '*');
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 分享记录
     */
    public function shareRecord(){
        $UserShare     = new UserShare();
        $model = $UserShare->getDataList($this->param,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $UserShare->getDataList($this->param,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        $data['data'] = $UserShare->regroupData($data['data']);
        return ajax('获取成功', 1, $data);
    }
    /**
     * 班级考试平均分记录
     */
    public function avgScore(){
        $PaperUser     = new PaperUser();
        $model = $PaperUser->classAvgScore($this->user['uid'],$this->param);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $PaperUser->classAvgScore($this->user['uid'],$this->param);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 获取未读数量
     * @return \think\response\Json
     */
    public function NoticeCount(){
        $UserNotice=new UserNotice();
        $data=$UserNotice->where(['uid'=>$this->user['uid'],'reading'=>0])->count();
        return ajax('获取成功', 1, ['count'=>$data]);
    }

    /**
     * 消息列表
     * @return \think\response\Json
     */
    public function NoticeList(){
        $UserNotice=new UserNotice();
        $model=$UserNotice->NoticeCollect(['n.uid'=>$this->user['uid']]);
        $total = $model->count();
        $model=$UserNotice->NoticeCollect(['n.uid'=>$this->user['uid']]);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 消息详情
     * @return \think\response\Json
     */
    public function NoticeDetails(){
        if(empty($this->param['id'])) return ajax("传必要参数",2);
        $UserNotice=new UserNotice();
        $data=$UserNotice->getOne(['id'=>$this->param['id']]);
        if($data['reading']==0){
            $UserNotice->editData(['id'=>$this->param['id']],['reading'=>1]);
        }
        return ajax('获取成功', 1, $data);
    }

    /**
     * 删除消息
     * @return \think\response\Json
     */
    public function NoticeDelete(){
        if(empty($this->param['id'])) return ajax("传必要参数",2);
        $UserNotice=new UserNotice();
        $res=$UserNotice->delData(['id'=>['in',$this->param['id']]]);
        if(!$res) return ajax('删除失败', 2);
        return ajax('删除成功', 1);
    }

    /**
     * 添加分享记录
     * @return \think\response\Json
     */
    public function ShareAdd(){
        if(empty($this->param['type']) || empty($this->param['type_id'])) return ajax("传类型或类型id",2);
        $UserShare     = new UserShare();
        $data=array('uid'=>$this->user['uid'],'type'=>$this->param['type'],'type_id'=>$this->param['type_id'],'created_at'=>time());
        $res=$UserShare->addData($data);
        $count=$UserShare->where(['created_at'=>['>',strtotime(date("Y-m-1"))]])->count();
        if($count>10){
            (new UserNorm)->normUp($this->user,'d');
        }

        if(!$res) return ajax('分享失败', 2);
        return ajax('分享成功', 1);
    }

    /**
     * 企业通讯录
     * @return \think\response\Json
     */
    public function Communication(){
        if(empty($this->param['enterprise_id']) || empty($this->param['enterprise_id'])) return ajax("传企业id",2);
        $data  = api_page(new model(),['enterprise_id'=>$this->param['enterprise_id'],'uid'=>['neq',$this->user['uid']]],'level desc', ['uid','name','name_hide','nickname','face','phone','level']);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 平台通讯录
     * @return \think\response\Json
     */
    public function communicationHome(){
        if(empty($this->param['classify_id']) || empty($this->param['classify_id'])) return ajax("传分类id",2);
        $ClassifyUser =new ClassifyUser();
        $model=$ClassifyUser->alias("c")->join("user u","u.uid=c.uid","left")->where(['classify_id'=>$this->param['classify_id'],'c.uid'=>['neq',$this->user['uid']]]);
        $total=$model->count();
        $model=$ClassifyUser->alias("c")->join("user u","u.uid=c.uid","left")->where(['classify_id'=>$this->param['classify_id'],'c.uid'=>['neq',$this->user['uid']]]);
        $data  = api_page($model,'','u.created_at desc', ['u.uid','u.name','u.name_hide','u.nickname','u.face','u.phone','u.level'],$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }



    //获取用户的观看时间
    public function againtime(){
        $userranking = new UserRanking();
        $charts = new Charts();
        $data = [
            'user_id'           => $this -> user['uid'],
            'classcourse_id'    => $this->param['cid'],
            'time'              => $this->param['time'],
            'type'              => $this->param['type'],
            'course_time'              => $this->param['course_time'],
        ];
        $CourseTimemodel = new CourseTime();
        $where['user_id'] =  $data['user_id'];
        $where['classcourse_id'] =  $data['classcourse_id'];
        //视频时间差
        $usertime = $data['course_time'] - $data['time'];
        $charts->newRanking($this -> user['uid'],'answer_num',$usertime);
        $userranking->newRanking($this -> user['uid'],'green',$usertime);
        $where['type'] = $data['type'];
        $CourseTimemodel -> delData($where);
        $res=$CourseTimemodel -> addData($data);
        return ajax('保存成功', 1, $res);


    }

    //发送用户观看时间
    public function aftertime(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'user_id'           => $this -> user['uid'],
            'classcourse_id'    => $this->param['cid'],
            'type'              => $this->param['type'],

        ];
        $model = new CourseTime();
        $res=$model->where($data)->find();
        if(!$res){

            return ajax('没有数据', 2);
        }
        return ajax('获取成功', 1, $res);

    }

    /**
     * 上传用户笔记
     * @return \think\response\Json
     */
    public function addnote(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'uid'           => $this -> user['uid'],
            'cid'    => $this->param['cid'],
            'content'              => $this->param['content'],
        ];
        $model = new Note();
        $where['uid'] =  $data['uid'];
        $where['cid'] =  $data['cid'];
        $res=$model->where($where)->find();
        if(!$res){
            $model -> save($data);
        }
        if ($res['content'] != $data['content']){
            $w  = [
                'uid' => $data['uid'],
                'cid' => $data['cid'],
            ];


            $model ->where($w)
                ->update(['content' => $data['content']]);
        }


        return ajax('上传成功', 1, $res);
    }

   //保存用户得视频状态
    public function addstues(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'uid'           => $this -> user['uid'],
            'cid'    => $this->param['cid'],
            'ctype'              => $this->param['ctype'],
        ];
        $where['uid'] =  $data['uid'];
        $where['cid'] =  $data['cid'];

        $model = new Ctype();
        $res=$model->where($where)->find();


        if(!$res){
            $model -> save($data);
        }

        if ($data['ctype'] == 2 && $res['ctype'] != 3){
            $w  = [
                'uid' => $data['uid'],
                'cid' => $data['cid'],
            ];


            $model ->where($w)
                ->update(['ctype' => $data['ctype']]);
        }

        if ($data['ctype'] == 3){
                        $w  = [
                       'uid' => $data['uid'],
                       'cid' => $data['cid'],
                   ];


                        $model ->where($w)
                            ->update(['ctype' => $data['ctype']]);

        }


        return ajax('获取成功', 1, $res);
    }

    public function getstues(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'uid'           => $this -> user['uid'],
            'cid'    => $this->param['cid'],
        ];
        $model = new Ctype();
        $res=$model->where($data)->find();
        return ajax('获取成功', 1, $res);

    }
    /**
     * 获取用户单条笔记
     * @return \think\response\Json
     */
    public function getnote(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'uid'           => $this -> user['uid'],
            'cid'    => $this->param['cid'],
        ];
        $model = new Note();
        $res=$model->where($data)->find();
        if(!$res){
            return ajax('获取失败', 2, $res);
        }
        return ajax('获取成功', 1, $res);

    }

    /**
     * 获取用户所有笔记
     * @return \think\response\Json
     */
    public function anynote(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        $data = [
            'uid'           => $this -> user[ 'uid'],
        ];
        $res = Db::table('tpn_note')
            ->alias('n')
            ->join('class_course c','n.cid = c.id')
            ->where($data)
            ->select();
//        $model = new Note();
//        $course = new ClassCourse();
//        $res=$model->where($data)->select();
        if(!$res){
            return ajax('获取失败', 2, $res);
        }
        return ajax('获取成功', 1, $res);

    }








    /**
     * 最近联系人
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function historyUser(){
        if(!$this->param['uid']) return ajax("缺少用户id",2);
        // 定义条件
        $id = $this -> param['uid'];
        // 可批量删除
        $where['uid'] = ['in', $id];
        $model=new model();
        $data=$model->field(['uid','name','name_hide','nickname','face','phone','level'])->where($where)->select()->toArray();
        if(!empty($data) && !empty($id)){
            $idarr=explode(",",$id);
            $arr=[];
            foreach ($idarr as $v){
                foreach ($data as $val){
                    if($v==$val['uid']){
                        $arr[]=$val;
                    }
                }
            }
            $data=$arr;

        }
        return ajax('获取成功', 1, $data);
    }
}