<?php
/**
 * [首页接口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\model\Enterprise;
use app\common\model\Banner;
use app\common\model\ClassCourse;
use app\common\model\Teacher;
use app\common\model\Information;
use app\common\model\Studys;
use app\common\model\Course;
use app\common\model\TeacherArticle;
use app\common\model\User;
use app\common\model\Questions;
use app\common\model\Hotkeyword;
use app\common\model\Storage;
use app\common\model\ClassUser;


class Home extends Api{
    /**
     * 获取首页
     */
    public function index(){
        if ($this -> user['allot']==1 || $this -> user['enterprise_id']==0) return ajax('您没有权限查看', 2);

        $enterprisemodel=new Enterprise();
        $bannermodel=new Banner();
//        $classcoursemodel=new ClassCourse();
        $coursemodel=new Course();
        $teachermodel=new Teacher();
        $informationmodel=new Information();
        $data=array();
        //企业
        $enterprise=$enterprisemodel->getOne(['id'=>$this -> user['enterprise_id']]);
        $up=json_decode($enterprise['up']);
        $data['enterprise'][]=$enterprise;
        if(!empty($up)){

            foreach ($up as $key=>$val){
                $enterpriseup=$enterprisemodel->getOne(['id'=>$val,'status'=>1]);
                $keyval=$key+1;
                $data['enterprise'][$keyval]['id']=$enterpriseup['id'];
                $data['enterprise'][$keyval]['name']=$enterpriseup['name'];
                $data['enterprise'][$keyval]['logo']=$enterpriseup['logo'];
            }
        }

        $enterprise_id =input('enterprise_id');
        $enterprise_id = isset($enterprise_id)?$enterprise_id:$this -> user['enterprise_id'];
        //轮播图
        $banner=$bannermodel->dataList(['enterprise_id'=>$enterprise_id,'type'=>1],$this->user['uid']);
        $data['banner']=$banner?$banner:[];
        //直播课
        $field="c.id,c.title,c.photo,c.reading,c.look_num,t.name,c.price";
        $where=array(
            'c.enterprise_id'=>array('=',$enterprise_id),
            'c.type'=>3,
            'c.scene'=>1,
        );
        $orderby="c.is_recommend desc,c.created_at desc";
//        $data['course']=$classcoursemodel->scene($where,$orderby,$field,4);
        $data['course']=$coursemodel->scene($where,$orderby,$field,4);
        //专家模型
        $data['teacher']=$teachermodel->field("id,name,title,photo")->where(['enterprise_id'=>['=',$enterprise_id],'status'=>1,'is_xszd'=>0,'identity'=>['like',"%3%"]])->order("is_recommend desc,updated_at desc")->limit("0,4")->select()->toArray();
        $where=['enterprise_id'=>$enterprise_id];
        if($enterprise_id !=$this -> user['enterprise_id']){
            $where['power']=0;
        }
        //资讯
        $data['information']=$informationmodel->field("id,cover_img,name,add_time,comment_num,pv")->where($where)->order(['is_recommend'=>'desc','add_time'=>'desc'])->limit("0,2")->select()->toArray();
        return ajax('获取成功', 1,$data);
    }

    /**
     * 添加资料库
     */
    public function addstorage()
    {
        // 实例化模型
        $model = new Storage();
        $uid = $this->user['uid'];
        if(empty($uid)) return ajax('您没有传必要参数', 2);
        $data['enterprise_id'] = input('enterprise_id');
        $data['add_time'] = time();
        $data['uid'] = $uid;
        $data['is_upload'] = 'true';
        $data['url'] = input('url');
        $data['name'] = input('name');
        $data['size'] = input('size');
        $data['username'] = $this->user['name'];
        $qid = $model->addData($data);
        if (!$qid) return ajax('添加失败', 2);
        return ajax('添加成功',1,$data);


    }

    /**
     * 个人资料
     */
    public function showstorage()
    {
        // 实例化模型
        $uid = $this->user['uid'];
        $enterprise_id = input('enterprise_id');
        $page = input('page');
        $model = new Storage();
        $where = ['uid'=>$uid,'enterprise_id'=>$enterprise_id];
        $data  = api_page($model, $where,'id desc');
        if (!$data) return ajax('暂无数据', 1);
        return ajax('获取成功',1,$data);

    }
    /**
     * 资料库
     */
    public function anystorage()
    {
        // 实例化模型
        $enterprise_id = input('enterprise_id');
        $page = input('page');
        $model = new Storage();

        $where = ['enterprise_id'=>$enterprise_id];
        $data  = api_page($model, $where,'id desc');
        if (!$data) return ajax('暂无数据', 1);
        return ajax('获取成功',1,$data);

    }



    /**
     * 查询关键字
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function keyword(){
        $type=input('type');
        $keyword=input('keyword');
        $enterprise_id=input('enterprise_id');
        if(empty($type) || empty($keyword)) return ajax('您没有传必要参数', 2);
        if (($this -> user['allot']==1 || $this -> user['enterprise_id']==0) && $type=='home') return ajax('您没有权限搜索', 2);
        $enterprise_id=isset($enterprise_id)?$enterprise_id:$this -> user['enterprise_id'];
        if($type=='find'){
            $enterprise_id=0;
        }
        $data=array();

        $pageSize=10;
        $page=isset($page)?$page:1;
        $ofset = ($page - 1) * $pageSize;
        $limit = $ofset . ',' . $pageSize;

        $studysmodel=new Studys();
        $classcoursesmodel=new ClassCourse();
        $coursemodel=new Course();
        $teachermodel=new Teacher();
        $informationmodel=new Information();
        $teacherarticlemodel=new TeacherArticle();
        $usermodel=new User();
        $questionsmodel=new Questions();
        //用户
        $user = $usermodel->field('name')->where(['name' => ['like', "%$keyword%"], 'enterprise_id' => ['=', $enterprise_id]])->limit($limit)->select()->toArray();
        if (!empty($user)) {
            foreach ($user as $val) {
                $data[] = $val['name'];
            }
        }
        //提问
        $questions = $questionsmodel->field('contents')->where(['contents' => ['like', "%$keyword%"], 'e_id' => ['=', $enterprise_id]])->limit($limit)->select()->toArray();
        if (!empty($questions)) {
            foreach ($questions as $val) {
                $data[] = $val['contents'];
            }
        }

        //班级
        $studys=$studysmodel->field('name')->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($studys)){
            foreach ($studys as $val){
                $data[]=$val['name'];
            }
        }
        //班级课程
        $classcourses=$classcoursesmodel->alias('c')->field('c.title')->join('class s','c.class_id=s.id','LEFT')->where(['c.title'=>['like',"%$keyword%"],'s.enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($classcourses)){
            foreach ($classcourses as $val){
                $data[]=$val['title'];
            }
        }
        //专业课
        $course=$coursemodel->field('title')->where(['title'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($course)){
            foreach ($course as $val){
                $data[]=$val['title'];
            }
        }
        //老师
        $teacher=$teachermodel->field('name')->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id],'status'=>1])->limit($limit)->select()->toArray();
        if(!empty($teacher)){
            foreach ($teacher as $val){
                $data[]=$val['name'];
            }
        }
        //资讯
        $information=$informationmodel->field('name')->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($information)){
            foreach ($information as $val){
                $data[]=$val['name'];
            }
        }
        //文章
        $teacherarticle=$teacherarticlemodel->alias('a')->field('a.name')->join('teacher t','a.teacher_id=t.id','LEFT')->where(['a.class_id'=>0,'a.name'=>['like',"%$keyword%"],'t.enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($teacherarticle)){
            foreach ($teacherarticle as $val){
                $data[]=$val['name'];
            }
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 搜索列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function search(){
        $type=input('type');
        $keyword=input('keyword');
        $page=input('page');
        $enterprise_id=input('enterprise_id');
        $uid = $this->user['uid'];
        $hotkeyword = new Hotkeyword();
        $num = $hotkeyword->where(['keyword'=>['like',"%$keyword%"]])->select()->toArray();
        if(!$num){
            $hotkeyword->addData(['keyword'=>$keyword,'enterprise_id'=>$enterprise_id]);
        }else{
            $hotkeyword->where(['keyword'=>['like',"%$keyword%"]])->setInc('pv');
        }
        if(empty($type) || empty($keyword)) return ajax('您没有传必要参数', 2);
        if (($this -> user['allot']==1 || $this -> user['enterprise_id']==0) && $type=='home') return ajax('您没有权限搜索', 2);
        $enterprise_id=isset($enterprise_id)?$enterprise_id:$this -> user['enterprise_id'];
        if($type=='find'){
            $enterprise_id=0;
        }
        $pageSize=10;
        $page=isset($page)?$page:1;
        $ofset = ($page - 1) * $pageSize;
        $limit = $ofset . ',' . $pageSize;
        $data=array('course'=>array(),'teacher'=>array(),'information'=>array(),'article'=>array(),'class'=>array(),'classcourse'=>array());
        $studysmodel=new Studys();
        $classcoursesmodel=new ClassCourse();
        $coursemodel=new Course();
        $teachermodel=new Teacher();
        $informationmodel=new Information();
        $teacherarticlemodel=new TeacherArticle();
        $usermodel=new User();
        $questionsmodel=new Questions();

        //班级
        $field =  [
            'a.id',
            'a.name',
            'a.start',
            'a.photo',
            'a.price',
            "(select count(*) from tpn_class_user where `class_id`=a.id) apply_num",//已报名人数
            "(select if(count(*)>0,1,0) from tpn_class_user where `class_id`=a.id and `uid`=".$uid.") is_apply",//是否已报名 1是 0否
        ];
        $studys=$studysmodel->alias('a')->field($field)->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($studys)){
            foreach ($studys as $val){
                $data['study'][]=$val;
            }
        }
//        班级课程
        $classcourses=$classcoursesmodel->alias('c')->field('c.title')->join('class s','c.class_id=s.id','LEFT')->where(['c.title'=>['like',"%$keyword%"],'s.enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($classcourses)){
            foreach ($classcourses as $val){
                $data['classcourse'][]=$val;
            }
        }
        //用户
        $user = $usermodel->field('name,uid,face')->where(['name' => ['like', "%$keyword%"], 'enterprise_id' => ['=', $enterprise_id]])->limit($limit)->select()->toArray();
//            dump($questions);
        if (!empty($user)) {
            foreach ($user as $val) {
                $data['name'][] = $val;
            }
        }
        //提问
        $questions = $questionsmodel->field('contents,url,id,type')->where(['contents' => ['like', "%$keyword%"], 'e_id' => ['=', $enterprise_id]])->limit($limit)->select()->toArray();
//            dump($questions);
        if (!empty($questions)) {
            foreach ($questions as $val) {
                $data['contents'][] = $val;
            }
        }

        //专业课
        $course=$coursemodel->field('id,title,photo,look_num,price,type')->where(['title'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($course)){
            foreach ($course as $val){
                $data['course'][]=$val;
            }
        }
        //老师
        $teacher=$teachermodel->field('id,name,brief,photo,consult_num')->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id],'status'=>1])->limit($limit)->select()->toArray();
        if(!empty($teacher)){
            foreach ($teacher as $val){
                $data['teacher'][]=$val;
            }
        }
        //资讯
        $information=$informationmodel->field('id,cover_img,name,add_time,comment_num,pv')->where(['name'=>['like',"%$keyword%"],'enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($information)){
            foreach ($information as $val){
                $data['information'][]=$val;
            }
        }
        //文章
        $teacherarticle=$teacherarticlemodel->alias('a')->field('a.id,a.cover_img,a.name,a.add_time,a.comment_num')->join('teacher t','a.teacher_id=t.id','LEFT')->where(['a.name'=>['like',"%$keyword%"],'t.enterprise_id'=>['=',$enterprise_id]])->limit($limit)->select()->toArray();
        if(!empty($teacherarticle)){
            foreach ($teacherarticle as $val){
                $data['article'][]=$val;
            }
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 最热搜索
     */
    public function hotkeyword(){
        $hotkeyword = new Hotkeyword();
        $enterprise_id = input('enterprise_id');
        $data = $hotkeyword->where(['enterprise_id'=>$enterprise_id])->field('keyword')->order('pv','desc')->limit(0,10)->select()->toArray();
        if(!$data){
            return ajax('已是全部数据', 2);
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 通讯录搜索
     */
    public function searchuser(){
        $user = new user();
        $name = input('name');

        $enterprise_id = input('enterprise_id');
        $data = $user->where(['name'=>['like',"%$name%"],'enterprise_id'=>$enterprise_id])->field('name,face,uid')->select()->toArray();
        if(!$data){
            return ajax('已是全部数据', 2);
        }
        return ajax('获取成功', 1,$data);
    }

    /**
     * 首页排行榜
     */
    public function homeranking(){
        $enterprise_id = input('enterprise_id');
        $user = new user();
        $field=array(
            "c.uid","c.face","c.unit_title","c.company_name","c.name",
            "(select SUM(questions_num+look_num+fans_num+zan_num+answer_num) from `tpn_charts` `r` where `r`.`uid`=`c`.`uid`) ranking_num",
        );
        $data = $user->alias('c')
            ->where(['enterprise_id'=>$enterprise_id])
            ->field($field)
            ->limit(0,10)
            ->order('ranking_num desc')
            ->select()
            ->toArray();
        if(!$data){
            return ajax('已是全部数据', 2);
        }
        return ajax('获取成功', 1,$data);
    }



}