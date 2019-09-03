<?php
/**
 * [学习班管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 16:32:03
 * @Copyright:
 */
namespace app\teacher\course\controller;  
use app\api\common\controller\Order;
use app\teacher\course\model\Study as model;
use app\teacher\root\controller\Common;
use app\teacher\course\model\ClassType;
use app\teacher\course\model\ClassNotice;
use app\teacher\course\model\TeacherArticle;
use app\common\model\QuestionnaireUser;
use app\common\model\ClassCourse;
use app\common\model\Course;
use app\teacher\course\model\Paper;
use app\teacher\course\model\ClassDiscuss;
use app\teacher\course\model\ClassDiscussUser;
use app\teacher\course\model\PaperUser;
use app\teacher\course\model\UserQuiz;
use app\teacher\root\model\Classify;
use app\teacher\info\model\Teacher;
use app\teacher\course\model\TeacherPay;
use app\teacher\course\model\ClassUser;
use app\common\extend\JGPush;
use app\common\extend\Rongcloudapi;
use app\common\model\UserRanking;
use think\Db;
use think\Request;
use app\common\model\TeacherDetailed;
use app\common\model\TeacherCont;


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
        public $msg="";
        /*
        *[活动列表]
        ***/
        public function classNotice(){
            $where = ['n.teacher_id'=>$this->user['id']];
            // 搜索关键词
            $keywords = input('get.keywords');
            if (!empty($keywords)) {
                $where['n.title'] = ['like', "%{$keywords}%"];
            }
            $model = new ClassNotice();
            $model=$model->alias('n')->join('class c','c.id=n.class_id','left');
            // var_dump($model);die;
//             $data = $model->getAll();
            $data  = admin_page($model, $where,'n.created_at desc',['n.*','c.name as class_name']);
            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);

        }
        /**
         * [index 列表]
         */
        public function index(){
            // 搜索关键词
            $keywords = input('get.keywords');
            //实例化模型
            $model = new model;
            $where = [];
            if (!empty($keywords)) {
                $where['c.name'] = ['like', "%{$keywords}%"];
            }

            $where['teacher_id'] = $this->user['id'];


            if($this -> checkVal['enterprise_id']==0){
                $Classify=new Classify();
                $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
                $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
            }else{
                $ClassType=new ClassType();
                $type=$ClassType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
                $this -> checkVal['class_type_idVal']=$this->array_convert($type,'id','name');
            }

//            $model=$coures->alias('c')->join('class_course s','s.class_id=c.id','left')
//                ->join('teacher t','t.id=s.teacher_id as t_iud');
            $model=$model->alias('c')->join('teacher t','t.id=c.teacher_id','left');
            // 获取数据
            $filed=array("c.*","t.name as teachername","t.id as teacherid");
            $data  = admin_page($model, $where,"c.created_at desc",$filed);

            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }


        public function kecheng(){
            // 搜索关键词
            $keywords = input('get.keywords');
            $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
            //实例化模型
            $model = new ClassCourse;
            $where = [];
            if (!empty($keywords)) {
                $where['c.name'] = ['like', "%{$keywords}%"];
            }
            $where['teacher_id'] = $this->user['id'];
//            $where['js_id'] = ['in',$this->user['id']];

            if($this -> checkVal['enterprise_id']==0){
                $Classify=new Classify();
                $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
                $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
            }else{
                $ClassType=new ClassType();
                $type=$ClassType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
                $this -> checkVal['class_type_idVal']=$this->array_convert($type,'id','name');
            }

            $model=$model->alias('c')->join('teacher t','c.teacher_id=t.id','left');
            // 获取数据
            $filed=array("c.*","t.name as teachername");
            $data  = admin_page($model, $where,"c.created_at desc",$filed);
//
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
                // file_put_contents('txt.txt', json_encode($data));
                $data['created_at'] = time();
                $data['enterprise_id'] =$this->user['enterprise_id'];
                $data['start'] = strtotime($data['start']);
                $data['end'] = strtotime($data['end']);
                //验证
                if (!$model -> checkData($data, ['id','enterprise_id','created_at','updated_at'])) {
                    return ajax($model -> err, 2);
                }
                //生成二维码
                $url = 'http://'.$_SERVER['HTTP_HOST'];
                $fileName = 'yw_'.$aid.'.png';
                qrcode($url,$fileName,5,'',3);
                $qrcode = '/uploads/qrcode/' . date('Ymd') . '/'.$fileName;
                $data['img_url'] = $qrcode;
                // 添加数据
                if (!$model -> addData($data)) return ajax('添加失败', 2);


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

            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            if(!$this -> checkVal['teacher']){
               $this -> checkVal['teacher'] = array();
            }


            return view('', [
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*****
        *添加活动
        *****/
        public function addn(){
            if ($this -> isPost) {
                $model = new ClassNotice();
                // 获取post数据
                $data = input('post.');
                $data['created_at'] = time();
                $data['teacher_id'] =$this->user['id'];
                if (!$model -> checkData($data, ['id'])) {
                    return ajax($model -> err, 2);
                }

                if (!$model->addData($data)) return ajax('添加失败', 2);
                $banji = db('class_user')->where(array('class_id'=>$data['class_id']))->select();

                $arr = array();
                foreach ($banji as $key => $value) {
                    # code...
                    $arr[] = $value['uid']."";
                }

                $JGPush=new JGPush();
                $res=$JGPush->smJumpOne($arr,'发布新活动'.$data['title']);
                //            file_put_contents('txt.txt', json_encode($res));

                return ajax('添加成功');
            }

            $this -> checkVal = db('class')->where(['teacher_id'=>$this->user['id']])->select();
            return view('', [
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*****
        *添加班级讨论组
        *****/
        public function addQun(){
            if(empty($this->param['id'])){
                return ajax('请传班级id',2);
            }
            if ($this -> isPost) {
                $model = new ClassDiscuss();
                // 获取post数据
                $data = input('post.');
                $data['created_at'] = time();
                if(empty($data['uid'])){
                    return ajax('请选择组长',2);
                }
                $uid=$data['uid'];
                unset($data['uid']);
                if(empty($data['name'])){
                    return ajax('请输入讨论组名称',2);
                }
                if (!$id = $model->addData($data)) return ajax('添加失败', 2);
                $Rongcloud = new Rongcloudapi();
                $res = $Rongcloud->RongCloud->group()->create(["u_".$uid],"d_$id",$data['name']);
                $code = json_decode($res,true);
                if($code['code'] !== 200) return ajax('添加失败',2);
                $user = new ClassDiscussUser();
                $add = array(
                        'discuss_id'=>$id,
                        'call'=>'组长',
                        'discuss_user_id'=>"u_".$uid,
                        'user_id'=>$uid,
                        'type'=>1
                );
                $user->addData($add);
                return ajax('添加成功');
            }
            $ClassUser =new ClassUser();
            $where =array("c.class_id"=>$this->param['id']);

            $model=$ClassUser->alias('c')->join('user u','u.uid=c.uid','left');
            $this -> checkVal['user_Val']=$model->field(['u.uid','u.name'])->where($where)->select()->toArray();
            return view('', [
                'checkVal'  => $this -> checkVal,
                'id'  => $this -> param['id']
            ]);
        }

        /*****
        *加入班级讨论组
        *****/
        public function addUserQun(){
            if(empty($this->param['id'])){
                return ajax('请传讨论组id',2);
            }
            if ($this -> isPost) {
                // 获取post数据
                $data = input('post.');
                if(empty($data['user_id'])){
                    return ajax('请选择用户',2);
                }
                if(empty($data['call'])){
                    return ajax('请输入身份',2);
                }
                if(db('class_discuss_user')->where(array('discuss_id'=>$data['discuss_id'],'user_id'=>$data['user_id']))->find()) return ajax('此学员已经加入此群',2);//判断用户是否已经加入
                $Rongcloud = new Rongcloudapi();
                $qun = db('class_discuss')->where(array('id'=>$data['discuss_id']))->find();
                $res = $Rongcloud->RongCloud->group()->join(["u_".$data['user_id']],"d_".$data['discuss_id'],$qun['name']);
                $code = json_decode($res,true);
                if($code['code'] !== 200) return ajax('添加失败',2);
                $user = new ClassDiscussUser();
                $add = array(
                        'discuss_id'=>$data['discuss_id'],
                        'call'=>$data['call'],
                        'discuss_user_id'=>"d_".$data['user_id'],
                        'user_id'=>$data['user_id'],
                        'type'=>1
                );
                $user->addData($add);
                return ajax('添加成功');
            }
            $Discuss = new ClassDiscuss();
            $Discussdata=$Discuss->find(['id'=>$this->param['id']]);
            $ClassUser =new ClassUser();
            $where =array("c.class_id"=>$Discussdata['class_id']);

            $model=$ClassUser->alias('c')->join('user u','u.uid=c.uid','left');
            $this -> checkVal['user_Val']=$model->field(['u.uid','u.name'])->where($where)->select()->toArray();
            return view('', [
                'checkVal'  => $this -> checkVal,
                'id'      => $this -> param['id']
            ]);
        }

        /**
         * [edit 编辑]
         */
        public function editn(){
            $model = new ClassNotice;
            // POST提交处理
            if ($this -> isPost) {
                // 获取post数据
                $data = input('post.');
                $data['created_at'] = time();
                if (!$model -> checkData($data, ['id','teacher_id'])) {
                    return ajax($model -> err, 2);
                }
                // 修改数据
                if (!db('class_notice')->where(array('id'=>$data['id']))->update($data)) return ajax('没有数据被修改', 2);
                return ajax('修改成功');
            }

            // 获取旧数据
            $id = (int)$this -> param['id'];
            $data = $model -> getOne(['id'=>$id]);
//            if($data['class_id'] == 0){
//                $data['class'] = '研究动态';
//            }else{
//                $data['class'] = db('class')->where(array('id'=>$data['class_id']))->find()['name'];
//            }

            $this -> checkVal = db('class')->where(['teacher_id'=>$this->user['id']])->select();
            return view('',[
                'data'     => $data,
                'id'    => $id,
                'checkVal' => $this -> checkVal
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
                if (!$model -> checkData($data, ['id','enterprise_id','created_at','updated_at'])) {
                    return ajax($model -> err, 2);
                }
                // 修改数据
                if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
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
            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
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
            return ajax('删除成功');
        }

        /**
         * [del 删除]
         */
        public function deln(){
            // 实例化模型
            $model = new ClassNotice;
            if (!$this -> isPost) return ajax('非法请求');
            // 定义条件
            $id = $this -> param['id'];
            // 可批量删除
            $where['id'] = ['in', $id];
            if (!$model -> delData($where)) return ajax('删除失败');
            return ajax('删除成功');
        }

        /**
         * [stop 禁言]
         */
        public function stop(){
            $id = $this -> param['id'];
            if (!$id) return ajax('非法请求',2);
            $ClassUser =new ClassUser();
            $data=$ClassUser->find(['id'=>$id]);

            if(empty($data)){
                return ajax('没有此用户',2);
            }
            if($data['status']==1){
                $res=$ClassUser->editData(['id'=>$id],['status'=>2,'updated_at'=>time()]);
                if(!$res){
                    return ajax('禁言失败',2);
                }
                $Rongcloud = new Rongcloudapi();
                $res = $Rongcloud->RongCloud->group()->addGagUser(["u_".$data['uid']],"c_".$data['class_id'],'43200');
                $code = json_decode($res,true);
                if($code['code'] !== 200) return ajax('禁言失败',2);
                return ajax('禁言成功');
            }else{
                $res=$ClassUser->editData(['id'=>$id],['status'=>1,'updated_at'=>time()]);
                if(!$res){
                    return ajax('解除禁言失败',2);
                }
                $Rongcloud = new Rongcloudapi();
                $res = $Rongcloud->RongCloud->group()->rollBackGagUser(["u_".$data['uid']],"c_".$data['class_id']);
                $code = json_decode($res,true);
                if($code['code'] !== 200) return ajax('解除禁言失败',2);
                return ajax('解除禁言成功');
            }

        }

        /**
         * [stop 解除禁言]
         */
    //    public function getstop(){
    //        $id = $this -> param['uid'];
    //        $qun_id = $this -> param['qun_id'];
    //        include_once EXTEND_PATH . 'server-sdk-php-master/API/rongcloud.php';
    //        $modela = new \RongCloud('4z3hlwrv4oqnt','sIjIsqm7nR');
    //        $model = $modela->Group();
    //        $a = $model->rollBackGagUser($id,$qun_id);
    //        $code = json_decode($a,true);
    //        if($code['code'] == 200){
    //            return ajax('解除禁言成功');
    //        }
    //            // return ajax($a);
    //            return ajax('解除禁言失败');
    //
    //    }

        /**
         * [del_gou 踢出群组]
         */
        public function delgou(){
            $id = $this -> param['uid'];
            $qun_id = $this -> param['qun_id'];


            include_once EXTEND_PATH . 'server-sdk-php-master/API/rongcloud.php';
            $modela = new \RongCloud('pwe86ga5pv616','rKYmVuM3766');
            $model = $modela->Group();
            $a = $model->quit($id,$qun_id);
            $code = json_decode($a,true);
            if($code['code'] == 200){
                return ajax('踢出成功');
            }
                return ajax('踢出失败');

        }

        //班级人员
        public function user(){
            $keywords = input('get.keywords');
            $ClassUser =new ClassUser();
            $where =array("c.class_id"=>$this->param['id']);
            if (!empty($keywords)) {
                $where['u.nickname|u.name'] = ['like', "%{$keywords}%"];
            }

            $model=$ClassUser->alias('c')->join('user u','u.uid=c.uid','left');
            // 获取数据
            $filed=array("c.*","u.name","u.nickname","u.face","u.phone");
            $data  = admin_page($model, $where,"c.created_at desc",$filed);

            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /***
        *班级签到记录
        ***/
        public function sign(){
            // echo input('exl');die;
            $keywords = input('get.keywords');
            $id = input('id');
            $start = input('start');
            $end = input('end');
            $where['a.class_id'] = $id;
            if (!empty($keywords)) {
                $where['c.nickname'] = ['like', "%{$keywords}%"];
            }
            if(!empty($start) && !empty($end)){
                $where['a.created_at'] = ['between', [strtotime($start), strtotime($end." 23:59:59")]];
            }else if(!empty($start)){
                $where['a.created_at'] = ['>',strtotime($start)];
            }else if(!empty($end)){
                $where['a.created_at'] = ['<',strtotime($end." 23:59:59")];
            }

            $field =['a.*','b.name as course_title','c.name','c.unit_title'];
            $data = Db::name('sign')->alias('a')
            ->join('class b','a.class_id = b.id','LEFT')
            ->join('user c','a.uid = c.uid','LEFT')
            ->where($where)
            ->field($field)
            ->distinct(true)
            ->select();


            //dump($data);die;


            if(!empty(input('exl'))){
                $cellName=array(
                ['课程名称',15,'course_title'],['昵称',10,'nickname'],['签到时间',20,'created_at']
            );



            //处理数据
            foreach ($data as $k=>$v)
            {
                foreach ($cellName as $k1=>$v1)
                {
                    $text=$v[$v1[2]];
                    if($k1==20){
                        $text= $this -> checkVal['sexVal'][$text];
                    }
                    if($k1==10){
                        $text= $this -> checkVal['educationVal'][$text];
                    }
                    $data[$k][$v1[2]]=$text;
                }
            }

            $this->ExcelExport('签到表',$cellName,$data);
            }
            // 模板


            return view('',[
                'data'      => $data,
                'keywords'  => $keywords,
                'start'     => $start,
                'id'     => $id,
                'end'     => $end
            ]);
        }

        /***
        *teacherArticle  班级热点列表
        ****/
        public function teacherArticle(){
            $where = [];
            $where['a.teacher_id'] = $this->user['id'];
            $type=$this->param['type'];
            $type=$type?$type:1;
            // 搜索关键词
            $keywords = input('get.keywords');
            if (!empty($keywords)) {
                $where['a.name'] = ['like', "%{$keywords}%"];
            }
            $model = new TeacherArticle();
            if($type==1){
                $model->alias("a");
                $where["a.class_id"]=0;
            }else{
                $model->alias("a")->join("class c","a.class_id=c.id","left");
            }
            // $data = $model->getAll();
            $data  = admin_page($model, $where,'add_time desc');
            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'type'      => $type,
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*****
        *添加热点
        *****/
        public function addt(){
            if ($this -> isPost) {

                $model = new TeacherArticle();
                // 获取post数据
                $data = input('post.');
                $data['add_time'] = time();
                $data['teacher_id'] =$this->user['id'];
                $data['enterprise_id'] =$this->user['enterprise_id'];
                // return ajax('添加成功');

                if (!$model->addData($data)) return ajax('添加失败', 2);

                return ajax('添加成功');
            }

            $this -> checkVal = db('class')->select();
            return view('', [
                'checkVal'  => $this -> checkVal
            ]);
        }

        /**
         * [del 删除]
         */
        public function delt(){
            // 实例化模型
            $model = new TeacherArticle;
            if (!$this -> isPost) return ajax('非法请求');
            // 定义条件
            $id = $this -> param['id'];
            // 可批量删除
            $where['id'] = ['in', $id];
            if (!$model -> delData($where)) return ajax('删除失败');
            return ajax('删除成功');
        }

        /**
         * [edit 编辑]
         */
        public function editt(){
            $model = new TeacherArticle;
            // POST提交处理
            if ($this -> isPost) {
                // 获取post数据
                $data = input('post.');
                // 修改数据
                if (!db('teacher_article')->where(array('id'=>$data['id']))->update($data)) return ajax('没有数据被修改', 2);
                return ajax('修改成功');
            }

            // 获取旧数据
            $id = (int)$this -> param['id'];
            $data = $model -> getOne(['id'=>$id]);
            $data['class'] = db('class')->where(array('id'=>$data['class_id']))->find()['name'];
            $this -> checkVal = db('class')->select();
            return view('',[
                'data'     => $data,
                'id'    => $id,
                'checkVal' => $this -> checkVal
            ]);
        }

        /*
        *问卷列表
        ****/
        public function questionnaireUser(){
            $where =array("c.teacher_id"=>$this->user['id']);
            // 搜索关键词
            $keywords = input('get.keywords');
            if (!empty($keywords)) {
                $where['q.name'] = ['like', "%{$keywords}%"];
            }
            $model = new QuestionnaireUser();
//            $data=$model::find(11);
            $model=$model->alias("u")
                         ->join("questionnaire q",'q.id=u.questionnaire_id')
                         ->join('class c',"c.id=q.class_id");
            $field=["c.name as classname","q.title","q.describe","u.uid","u.data","u.answer"];
            $data  = $model->field($field)->where($where)->order("u.id desc")->paginate(10);
//            $data  = admin_page($model, $where,"u.id desc",$field);
//            $arr = [];
//            foreach ($data['data'] as $key => $value) {
//                # code...
//                $value['nickname'] = db('user')->where(array('uid'=>$value['uid']))->find()['nickname'];
//                $qu = db('questionnaire')->where(array('id'=>$value['questionnaire_id']))->field('title,describe,updated_at')->find();
//                $value['title'] = $qu['title'];
//                $value['describe'] = $qu['describe'];
//                $value['updated_at'] = $qu['updated_at'];
//                $arr[] = $value;
//            }


                if(!empty($this->param['exl'])){
                    $cellName=array(
                        ['用户昵称',10,'nickname'],['班级',20,'classname'],['标题',20,'title'],['描述',50,'describe'],
                        ['问答',50,'data'],['答案',50,'answer']
                );

                //处理数据
                foreach ($data as $k=>$v)
                {
                    $v['nickname']=$v->user['nickname'];
                    foreach ($cellName as $k1=>$v1)
                    {
                        $text=$v[$v1[2]];
                        if($k1==20){
                            $text= $this -> checkVal['sexVal'][$text];
                        }
                        if($k1==10){
                            $text= $this -> checkVal['educationVal'][$text];
                        }
                        $dataa[$k][$v1[2]]=$text;
                    }
                }
               $this->ExcelExport('问卷',$cellName,$data);
            }

            // 模板
            return view('',[
                'data'      => $data,
                'page'      => $data->render(),
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*
        *热题
        ****/
        public function paper(){
            $type=$this->param['type']?$this->param['type']:1;
            $where = ['p.type'=>$type];
            // $where['teacher_id'] = $this->user['id'];
            // 搜索关键词
            $keywords = input('get.keywords');
            if (!empty($keywords)) {
                $where['p.title'] = ['like', "%{$keywords}%"];
            }
            $model = new Paper();
            $model=$model->alias("p");

            if($type==2){
                 $Course =new Course();
                $classid=$this->array_convert($Course->getAll(['teacher_id'=>$this->user['id']]),'id','id');
            }else{
                $Studymodel= new model();
                $ClassCoursemodel= new ClassCourse();
                $studydata=$this->array_convert($Studymodel->getAll(['teacher_id'=>$this->user['id']]),'id','id');
                $couerdata=$this->array_convert($ClassCoursemodel->getAll(['teacher_id'=>$this->user['id']]),'class_id','class_id');
                $classid=array_unique(array_merge($studydata,$couerdata));
            }
            $where['class_id']=['in',$classid];
            $data  = admin_page($model, $where,'p.start_time desc',"p.*");

            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'type'  => $type,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /**
        *获取考生试卷
        */
        public function paperUser(){
            $id = (int)$this -> param['id'];
            $where['paper_id'] = $id;
            $model = new PaperUser();
            // var_dump($model);die;
            // $data = $model->getAll();
            $data  = admin_page($model, $where);
            $arr = [];
            foreach ($data['data'] as $key => $value) {
                # code...
                $value['nickname'] = db('user')->where(array('uid'=>$value['uid']))->find()['nickname'];
                $arr[] = $value;
            }
            // 模板
            return view('',[
                'data'      => $arr,
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*
        *阅卷
        */
        public function upPuser(){
            $id = (int)$this -> param['id'];
            $model = new PaperUser();
            $data = $model -> getOne(['id'=>$id]);
            $data['data'] = json_decode($data['data'],true) ? json_decode($data['data'],true) : [];
            $data['result'] = json_decode($data['result'],true) ? json_decode($data['result'],true) : [];
            if ($this -> isPost){
                $papermodel = new Paper();
                $paperdata=$papermodel-> getOne(['id'=>$data['paper_id']]);
                if($data['status']!=3){
                    return ajax('此试卷以审阅',2);
                }
                $score=0;
                foreach ($data['data'] as $v){
                    if($v['type']=='adio'){
                        $a="";
                        foreach ($v['answer'] as $d){
                            if($d['status']){
                                $a=$d['id'];
                            }
                        }
                        if($data['result'][$v['id']]==$a){
                            $score+=(int)$v['score'];
                        }
                    }elseif ($v['type']=='checkbox'){
                        $a=[];
                        foreach ($v['answer'] as $d){
                            if($d['status']){
                                $a[]=$d['id'];
                            }
                        }
                        if($data['result'][$v['id']]==$a){
                            $score+=(int)$v['score'];
                        }
                    }
                }
                if(!empty($this->param['score'])){
                    foreach ($this->param['score'] as $v){
                        $score+=(int)$v;
                    }
                }
                if($paperdata['full']<$score){
                    return ajax('得分结果大于试卷总分',2);
                }
                $status=1;
                if($score<$paperdata['pass']){
                    $status=2;
                }

                db('paper_user')->where(array('id'=>$id))->update(array('status'=>$status,'score'=>$score));
                $UserRanking = new UserRanking();
                if($score){
                    (new UserRanking)->updateRanking($data['uid'],'orange');
                    $UserRanking->editData(['uid'=>$data['uid']],['orange'=>$score]);
                }
                return ajax('修改成功');
            }
            // 模板
            return view('',[
                'data'      => $data,
                'checkVal'  => $this -> checkVal
            ]);
        }


        /*
        *留言列表
        ****/
        public function userQuiz(){
            // 搜索关键词
            $keywords = input('get.keywords');
            //实例化模型
            $where['a.teacher_id'] = $this->user['id'];

            $model = new TeacherCont();
            if (!empty($keywords)) {
                $where['a.name'] = ['like', "%{$keywords}%"];
            }

                $model->alias("a");
                $field=["a.*"];


            // 获取数据
            $data  = admin_page($model, $where,"a.add_time desc",$field);
            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);





//            $where = [];
//             $where['teacher_id'] = $this->user['id'];
//            // 搜索关键词
//            $keywords = input('get.keywords');
//            if (!empty($keywords)) {
//                $where['name'] = ['like', "%{$keywords}%"];
//            }
//            $model = new UserQuiz();
//            // var_dump($model);die;
//            // $data = $model->getAll();
//            $data  = admin_page($model, $where,'id desc');
//
//            // 模板
//            return view('',[
//                'data'      => $data['data'],
//                'page'      => $data['page'],
//                'keywords'  => $keywords,
//                'checkVal'  => $this -> checkVal
//            ]);
        }


        /*****
        *添加留言列表
        *****/
        public function addUserQuiz(){
            $model = new TeacherCont();
            if ($this -> isPost) {
                // 实例化模型

                // 获取post数据
                $data = input('post.');
                $data['add_time'] = time();
                $data['enterprise_id'] =$this->user['enterprise_id'];
                $data['teacher_id'] =$this->user['id'];

                // 验证
                if (!$model -> checkData($data, ['id','enterprise_id','teacher_id','add_time'])) {
                    return ajax($model -> err, 2);
                }
                // 添加数据
                if (!$model -> addData()) return ajax('添加失败', 2);

                return ajax('添加成功');
            }

            return view('', [
                'checkVal'  => $this -> checkVal,
            ]);





//            if ($this -> isPost) {
//
//                $model = new UserQuiz();
//                // 获取post数据
//                $data = input('post.');
//                $data['created_at'] = time();
//                $data['teacher_id'] =$this->user['id'];
//                $data['uid'] = intval($data['uid']);
//                if($data['uid'] == 0){
//                    return ajax('UID必须为数字', 2);
//                }
//                if(!db('user')->where(array('uid'=>$data['uid']))->find()){
//                    return ajax('此用户不存在', 2);
//                }
//                if (!$model->addData($data)) return ajax('添加失败', 2);
//
//                return ajax('添加成功');
//            }
//
//            return view('', [
//                'checkVal'  => $this -> checkVal
//            ]);
        }

        /**
         * [edit 编辑]
         */
        public function editUserQuiz(){

            $model = new TeacherCont();
            // POST提交处理
            if ($this -> isPost) {
                // 获取post数据
                $data = input('post.');
                $article=$model->getOne(['id'=>$data['id']]);
                // 验证
                if (!$model -> checkData($data, ['id','enterprise_id','teacher_id','add_time'])) {
                    return ajax($model -> err, 2);
                }

                // 修改数据
                if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);

                return ajax('修改成功');
            }

            // 获取旧数据
            $id = (int)$this -> param['id'];
            $data = $model -> getOne(['id'=>$id]);

            return view('',[
                'data'     => $data,
                'id'    => $id,
                'checkVal' => $this -> checkVal
            ]);



//            $model = new UserQuiz;
//            // POST提交处理
//            if ($this -> isPost) {
//                // 获取post数据
//                $data = input('post.');
//                $data['updated_at'] = time();
//                // 修改数据
//                if (!db('user_quiz')->where(array('id'=>$data['id']))->update($data)) return ajax('没有数据被修改', 2);
//                return ajax('修改成功');
//            }
//
//            // 获取旧数据
//            $id = (int)$this -> param['id'];
//            $data = $model -> getOne(['id'=>$id]);
//            return view('',[
//                'data'     => $data,
//                'id'    => $id,
//                'checkVal' => $this -> checkVal
//            ]);
        }

        /**
         * [del 删除]
         */
        public function delUserQuiz(){

            // 实例化模型
            $model = new TeacherCont();
            if (!$this -> isPost) return ajax('非法请求');
            // 定义条件
            $id = $this -> param['id'];
            // 可批量删除
            $where['id'] = ['in', $id];
            if (!$model -> delData($where)) return ajax('删除失败');
            return ajax('删除成功');


//            // 实例化模型
//            $model = new UserQuiz;
//            if (!$this -> isPost) return ajax('非法请求');
//            // 定义条件
//            $id = $this -> param['id'];
//            // 可批量删除
//            $where['id'] = ['in', $id];
//            if (!$model -> delData($where)) return ajax('删除失败');
//            return ajax('删除成功');
        }


        /*
        *提现列表
        ****/
        public function teacherPay(){
            $where = ['teacher_id'=>$this->user['id']];
            // $where['teacher_id'] = $this->user['id'];
            // 搜索关键词
            $keywords = input('get.keywords');
            if (!empty($keywords)) {
                $where['name'] = ['like', "%{$keywords}%"];
            }
            $model = new TeacherPay();
            // var_dump($model);die;
            // $data = $model->getAll();
            $data  = admin_page($model, $where,'id desc');
            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }
        /*
      *钱包
      ****/
        public function qianbao(){
            $where = ['id'=>$this->user['id']];
            // 搜索关键词
            $model = new Teacher();
            $TeacherDetailed = new TeacherDetailed();
            $mingxi = $TeacherDetailed -> getAll(['teacher_id'=>$this->user['id'],'type' => 2]);


            $data = $model -> getOne(['id'=>$this->user['id']]);
            // 模板
            return view('',[
                'data'      => $data,
                'page'      => $data['page'],
                'mingxi'    => $mingxi,
                'checkVal'  => $this -> checkVal
            ]);
        }
        /*****
        *申请提现
        *****/
        public function addTeacherPay(){
                $protocol = db('protocol')->where(array('type'=>'procedures','enterprise_id'=>0))->find();
            $user = db('teacher')->where(array('id'=>$this->user['id']))->find();
            if ($this -> isPost) {

                $data = input('post.');


                $qian = $data['account'] + $data['account'] * $protocol['content'] / 100;
                if($user['money'] < $qian) return ajax('余额不足 金额'.$qian,2);
                $money = $user['money'] - $qian;
                if(!db('teacher')->where(array('id'=>$this->user['id']))->update(array('money'=>$money))) return ajax('扣款失败',2);
                $model = new TeacherPay();
                // 获取post数据
                $data['created_at'] = time();
                $data['teacher_id'] =$this->user['id'];
                $data['brokerage'] =$data['account'] * $protocol['content'] / 100;
                if (!$model->addData($data)) return ajax('申请失败', 2);

                return ajax('申请成功');
            }
            $money=$user['money']- $user['money'] * $protocol['content'] / 100;
            return view('', [
                'checkVal'  => $this -> checkVal,
                'data'      => $protocol,
                'user'      => $user,
                'money'      => $money,

            ]);
        }

        /**
         * 获取班级讨论组
         * @return \think\response\Json|\think\response\View
         */
        public function discuss(){
            if(empty($this->param['id'])){
                return ajax('请传班级id',2);
            }
            // 搜索关键词
            $keywords = input('get.keywords');
            $ClassDiscussmodel =new ClassDiscuss();
            $where =['class_id'=>$this->param['id']];
            if (!empty($keywords)) {
                $where['name'] = ['like', "%{$keywords}%"];
            }
            $data  = admin_page($ClassDiscussmodel, $where,'created_at desc');
            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'id'      => $this->param['id'],
                'keywords'  => $keywords,
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*****
         *编辑班级讨论组
         *****/
        public function discussedit(){
            if(empty($this->param['id'])){
                return ajax('请传讨论组id',2);
            }
            $model = new ClassDiscuss();
            if ($this -> isPost) {

                // 获取post数据
                $data = input('post.');
                $data['created_at'] = time();
                if(empty($data['name'])){
                    return ajax('请输入讨论组名称',2);
                }
                if (!$id = $model->editData(['id'=>$data['id']],$data)) return ajax('编辑失败', 2);
                $Rongcloud = new Rongcloudapi();
                $res = $Rongcloud->RongCloud->group()->refresh("d_".$data['id'],$data['name']);
                $code = json_decode($res,true);
                if($code['code'] !== 200) return ajax('编辑失败',2);
                return ajax('编辑成功');
            }
            $data=$model->find(['id'=>$this->param['id']])->toArray();
            return view('', [
                'checkVal'  => $this -> checkVal,
                'data'  => $data
            ]);
        }

        /**
         * [del 班级讨论组删除]
         */
        public function discussdel(){
            // 实例化模型
            $model = new ClassDiscuss();
            $usermodel = new ClassDiscussUser();

            if (!$this -> isPost) return ajax('非法请求');
            // 定义条件
            $id = $this -> param['id'];
            if (!$id) return ajax('讨论组id不能为空');
            // 可批量删除
            $where =array('id'=>['in', $id]);
            $model->startTrans();
            if (!$model -> delData($where)){
                $model->rollBack();
                return ajax('删除失败');
            }
            $where =array('discuss_id'=>['in', $id]);
            if (!$usermodel -> delData($where)){
                $model->rollBack();
                return ajax('删除失败');
            }
            $id=explode(',',$id);
            $Rongcloud = new Rongcloudapi();
            foreach ($id as $v){
                $res = $Rongcloud->RongCloud->group()->dismiss('t_'.$this->user['id'],"d_".$v);
            }
            $model->commit();
            return ajax('删除成功');
        }

        //讨论组人员
        public function discussuser(){
            if(empty($this->param['id'])){
                return ajax('请传讨论组id',2);
            }
            $keywords = input('get.keywords');

            $Usermodel =new ClassDiscussUser();
            $where =array("d.discuss_id"=>$this->param['id'],'d.type'=>1);
            if (!empty($keywords)) {
                $where['u.nickname|u.name'] = ['like', "%{$keywords}%"];
            }

            $model=$Usermodel->alias('d')->join('user u','u.uid=d.user_id','left');
            // 获取数据
            $filed=array("d.*","u.name","u.nickname","u.face","u.phone");
            $data  = admin_page($model, $where,"",$filed);

            // 模板
            return view('',[
                'data'      => $data['data'],
                'page'      => $data['page'],
                'keywords'  => $keywords,
                'id'  => $this->param['id'],
                'checkVal'  => $this -> checkVal
            ]);
        }

        /*****
         *编辑班级讨论组成员
         *****/
        public function discussuseredit(){
            if(empty($this->param['id'])){
                return ajax('请传id',2);
            }
            $model = new ClassDiscussUser();
            if ($this -> isPost) {

                // 获取post数据
                $data = input('post.');
                if(empty($data['call'])){
                    return ajax('请输入身份',2);
                }
                if (!$model->editData(['id'=>$data['id']],$data)) return ajax('编辑失败', 2);
                return ajax('编辑成功');
            }
            $data=$model->find(['id'=>$this->param['id']])->toArray();
            return view('', [
                'checkVal'  => $this -> checkVal,
                'data'  => $data
            ]);
        }

        /**
         * [del 班级讨论组删除]
         */
        public function discussuserdel(){
            // 实例化模型
            $usermodel = new ClassDiscussUser();

            if (!$this -> isPost) return ajax('非法请求');
            // 定义条件
            $id = $this -> param['id'];
            if (!$id) return ajax('用户id不能为空');
            // 可批量删除
            $where =array('id'=>['in', $id]);
            $discuss=$usermodel->find($where)->toArray();
            if (!$usermodel -> delData($where)){
                return ajax('删除失败');
            }

            $id=explode(',',$id);
            $Rongcloud = new Rongcloudapi();
            foreach ($id as $v){
                $Rongcloud->RongCloud->group()->quit('t_'.$v,"d_".$discuss['discuss_id']);
            }
            return ajax('删除成功');
        }

        /**
         * 班级群身份编辑
         * @return \think\response\Json|\think\response\View
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         */
        public function useredit(){
            if(empty($this->param['id'])){
                return ajax('请传id',2);
            }
            $model = new ClassUser();
            if ($this -> isPost) {

                // 获取post数据
                $data = input('post.');
                if(empty($data['call'])){
                    return ajax('请输入身份',2);
                }
                if (!$model->editData(['id'=>$data['id']],$data)) return ajax('编辑失败', 2);
                return ajax('编辑成功');
            }
            $data=$model->find(['id'=>$this->param['id']])->toArray();
            return view('', [
                'checkVal'  => $this -> checkVal,
                'data'  => $data
            ]);
        }



    }