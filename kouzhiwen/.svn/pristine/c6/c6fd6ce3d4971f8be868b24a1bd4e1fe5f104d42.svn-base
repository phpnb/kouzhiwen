<?php
/**
 * [user控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-03 18:00:03
 * @Copyright:
 */
namespace app\teacher\info\controller;  
use app\teacher\info\model\User as model;
use app\teacher\root\controller\Common;
use app\teacher\info\model\Enterprise;
use app\common\model\PaperUser;
use app\common\model\UserRecord;
use app\common\model\Sign;
use app\common\model\UserDetailed;
use app\common\model\UserShare;
use app\common\model\TeacherArticle;
use app\common\model\Introduce;

class User extends Common{
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
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $id = input('id');
        //实例化模型
        $model = new model;
        $allot = input('get.allot');
        $allot=empty($allot)?2:$allot;
        $where =['allot'=>$allot,'status'=>1];
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
        $data  = admin_page($model, $where,'','','',5,$id);
        
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
     * [add 添加数据]
     */
    public function add(){
        if ($this -> isPost) {
            $time=time();
            // 实例化模型
            $Enterprisemodel =new Enterprise();
            $model = new model;
            $count=$model->where(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1])->count();
            $Enterprise=$Enterprisemodel->getOne(['id'=>$this->user['enterprise_id']]);
            if($Enterprise['student']<=$count && $this->user['enterprise_id']>0){
                return ajax('学员人数以满', 2);
            }
            // 获取post数据
            $data = input('post.');
            $data['enterprise_id'] =$this->user['enterprise_id'];
            $data['password'] =create_pwd($data['password']);
            $data['status'] =1;
            $data['allot'] =2;
            $data['created_at'] =$time;
            $data['updated_at'] =$time;
            $data['birth']=empty($data['birth'])?date("Y-m-d"):$data['birth'];
            $user=$model->getOne(['phone'=>$data['phone'],'status'=>1]);


            // 验证
            if (!$model -> checkData($data, ['uid','enterprise_id','name_hide','balance','logintoken','allot','status','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }

            if(!empty($user)){
                if($user['allot']==1){
                    // 修改数据
                    if (!$model -> editData(['uid'=>$user['uid']],['enterprise_id'=>$this->user['enterprise_id'],'allot'=>2,'updated_at'=>$time])) return ajax('添加失败', 2);
                    $this->AddLog("添加用户{".$user['phone']."}成功");
                    return ajax('添加成功');
                }
                return ajax('已有此账号', 2);
            }

            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog("添加用户{".$data['phone']."}成功");
            return ajax('添加成功');
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
            $user=$model->getOne(['phone'=>$data['phone'],'uid'=>['not in',$data['uid']],'status'=>1]);
            if(!empty($user)){
                return ajax('已有此账号', 2);
            }
            if(!empty($data['password'])){
                $data['password'] =create_pwd($data['password']);
            }

            // 验证
            if (!$model -> checkData($data, ['uid','password','enterprise_id','name_hide','balance','logintoken','allot','status','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['uid'=>$data['uid']])) return ajax('没有数据被修改', 2);
            $this->AddLog("修改用户{".$data['phone']."}成功");
            return ajax('修改成功');
        }

        // 获取旧数据
        $uid = (int)$this -> param['uid'];
        $data = $model -> getOne(['uid'=>$uid]);
        
        return view('',[
            'data'     => $data,
            'uid'    => $uid,
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
        $uid = $this -> param['id'];
        // 可批量删除
        $where['uid'] = ['in', $uid];

        if (!$model -> editData($where,['status'=>2,'updated_at'=>time()])) return ajax('删除失败');
        $this->AddLog("删除用户成功");
        return ajax('删除成功');
    }

    /**
     * [stop 禁言]
     */
    public function stop(){
        if (!$this -> isPost) return ajax('非法请求');
        // 定义条件
        $uid = $this -> param['id'];
        $qid = $this -> param['id'];

        $this->AddLog("删除用户成功");
        return ajax('删除成功');
    }




    /**
     * 审核用户
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function auditing(){
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        // 定义条件
        $uid = $this -> param['id'];
        // 可批量删除
        $where['uid'] = ['in', $uid];

        if (!$model -> editData($where,['enterprise_id'=>$this->user['enterprise_id'],'allot'=>2,'updated_at'=>time()])) return ajax('审核失败', 2);
        $this->AddLog("审核用户成功");
        return ajax('审核成功');
    }

    /**
     * 用户考试记录
     * @return \think\response\View
     */
    public function achievement(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $PaperUsermodel =new PaperUser();
        $model=$PaperUsermodel->PaperList();
        $where=array('a.uid'=>$this -> param['uid']);
        if (!empty($keywords)) {
            $where['b.title'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $this->param['type'],
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 班级考试平均分
     * @return \think\response\View
     */
    public function avgscore(){
        $keywords = input('get.keywords');
        $PaperUsermodel =new PaperUser();

        $model=$PaperUsermodel->classAvgScore($this -> param['uid']);
        $where=array();
        if (!empty($keywords)) {
            $where['c.name'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $this->param['type'],
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 分享记录
     * @return \think\response\View
     */
    public function share(){
        $keywords = input('get.keywords');
        $UserShare     = new UserShare();

        $where=array('uid'=>$this->param['uid']);

        // 获取数据
        $data  = admin_page($UserShare, $where);
        $data['data'] = $UserShare->regroupData($data['data']);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $this->param['type'],
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 发表班级热点文章记录
     * @return \think\response\View
     */
    public function Article(){
        $keywords = input('get.keywords');
        $model = new model;
        $TeacherArticle    = new TeacherArticle();
        $user=$model->getOne(['uid'=>$this->param['uid']]);
        $where=array('phone'=>$user['phone']);
        if (!empty($keywords)) {
            $where['name'] = ['like', "%{$keywords}%"];
        }
        $data  = admin_page($TeacherArticle,$where,'add_time desc');
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $this->param['type'],
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 用户签到记录
     * @return \think\response\View
     */
    public function sign(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $Signmodel =new Sign();
        $model=$Signmodel->userGign();
        $where=array('s.uid'=>$this -> param['uid']);
        if (!empty($keywords)) {
            $where['c.name'] = ['like', "%{$keywords}%"];
        }
        $field=array('s.id','c.name','c.photo','s.date');
        // 获取数据
        $data  = admin_page($model, $where,'s.date desc',$field);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }


    /**
     * 学习记录
     */
    public function studyrecord(){

        // 搜索关键词
        $keywords = input('get.keywords');
        $Introduce    = new Introduce();
        $model = new model;
        $user=$model->getOne(['uid'=>$this->param['uid']]);
        $where=array('phone'=>$user['phone']);
//        $UserRecord    = new UserRecord();
//        $model = $UserRecord->getDataList(['type'=>4],$this->user['uid']);
        if (!empty($keywords)) {
            $where['name'] = ['like', "%{$keywords}%"];
        }

        // 获取数据
        $data  = admin_page($Introduce,$where,'add_time desc');

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'type'  => $this->param['type'],
            'uid'  => $this -> param['uid'],
            'checkVal'  => $this -> checkVal
        ]);
    }


    /**
     * 学习进度
     */
    public function progress(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $where=array('uid'=>$this -> param['uid'],'type'=>['in',[3,6]]);
        $UserRecordmodel=new UserRecord();
        $field=array(
            'r.type',
            'r.created_at',
            '(SELECT `title` FROM `tpn_course` WHERE `id`=`r`.`type_id` ) AS ctitle',
            '(SELECT `photo` FROM `tpn_course` WHERE `id`=`r`.`type_id` ) AS cphoto',
            '(SELECT `photo` FROM `tpn_class_course` WHERE `id`=`r`.`type_id` ) AS bphoto',
            '(SELECT `title` FROM `tpn_class_course` WHERE `id`=`r`.`type_id` ) AS btitle',
        );

        // 获取数据
        $data  = admin_page($UserRecordmodel->alias('r'), $where,'r.created_at desc',$field);

        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }
    /**
     * 用户消费记录
     * @return \think\response\View
     */
    public function consume(){
        $keywords = input('get.keywords');
        $where=array('uid'=>$this -> param['uid']);
        if (!empty($keywords)) {
            $where['title'] = ['like', "%{$keywords}%"];
        }
        $UserDetailedmodel=new UserDetailed();
        // 获取数据
        $data  = admin_page($UserDetailedmodel, $where,'created_at desc');
        $this -> checkVal['typeVal']=array('1'=>'消费','2'=>'充值');
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

    /**
     * 用户导入
     * @return \think\response\Json
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import(){
        if(request()->isPost()){
            $time=time();
            $excel = request()->file('file')->getInfo();
            $objPHPExcel = \PHPExcel_IOFactory::load($excel['tmp_name']);//读取上传的文件
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();//获取其中的数据
            unset($arrExcel[0]);
            if(count($arrExcel)>1000){
                return ajax('最大限制单次导入1000条',2);
            }
            $data=array();
            $update=array();
            $model = new model;
            foreach ($arrExcel as $key=>$val){
                if(empty($val[0])){
                    continue;
                }
                $user=$model->getOne(['phone'=>$val[0],'status'=>1]);
                if(!empty($user)){
                    if($user['allot']==1){
                        $update[]=$user['uid'];
                    }
                    continue;
                }
                $data[$key]['enterprise_id']=$this->user['enterprise_id'];
                $data[$key]['phone']=$val[0];
                $data[$key]['password']=create_pwd(123456);
                $data[$key]['name']=$val[1];
                $data[$key]['nickname']=$val[2];
                $data[$key]['face']='/uploads/default.png';
                $data[$key]['identity']=$val[3];
                $sex=array_keys($this -> checkVal['sexVal'],$val[4]);
                $data[$key]['sex']=empty($sex)?1:$sex[0];
                $data[$key]['birth']=$val[5];
                $data[$key]['oph']=$val[6];
                $data[$key]['tel']=$val[7];
                $data[$key]['email']=$val[8];
                $data[$key]['school']=$val[9];
                $education=array_keys($this -> checkVal['educationVal'],$val[10]);
                $data[$key]['education']=empty($education)?4:$education[0];
                $data[$key]['unit_title']=$val[11];
                $data[$key]['company_name']=$val[12];
                $data[$key]['allot']=2;
                $data[$key]['status']=1;
                $data[$key]['created_at']=$time;
                $data[$key]['updated_at']=$time;
            }
            $res=true;
            if(!empty($update)){
                $where['uid'] = ['in', $update];
                $res=$model->editData($where,['enterprise_id'=>$this->user['enterprise_id'],'updated_at'=>$time]);
                if(!$res)return ajax('导入失败', 2);
            }

            if(!empty($data)){
                $res=$model->saveAll($data);
            }
            if(!$res)return ajax('导入失败', 2);
            if(empty($update) && empty($data))return ajax('没有数据', 2);
            return ajax('导入成功',1);
        }
        // 模板
        return view('',[
            'checkVal'  => $this -> checkVal
        ]);
    }
    /**
     * 用户导出
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function export(){

        $Enterprise =new Enterprise();
        $model = new model;
        // 定义条件
        $uid = $this -> param['id'];
        $where=array('allot'=>2,'status'=>1);
        if(!empty($uid)){
            $where['uid'] = ['in', $uid];
        }
        if($this->user['enterprise_id']>0){
            $where['enterprise_id'] = $this->user['enterprise_id'];
        }
        $title="平台学员";
        if($this->user['enterprise_id']>0){
            $enterpriserdata=$Enterprise->getOne(['id'=>$this->user['enterprise_id']]);
            $title=$enterpriserdata['name'];
        }
        $data=$model->getAll($where);



        $cellName=array(
            ['账号',15,'phone'],['姓名',10,'name'],['昵称',10,'nickname'],['身份证',20,'identity'],
            ['性别',5,'sex'],['出生年月',10,'birth'],['办公电话',15,'oph'],['电话',15,'tel'],['邮箱',15,'email'],
            ['学校',15,'school'],['学历',10,'education'],['单位职称',10,'unit_title'],
            ['公司名称',20,'company_name'],['公司地址',30,'company_adddetailed'],['家庭地址',30,'address_detailed'],['用户余额',10,'balance'],
        );

        //处理数据
        foreach ($data as $k=>$v)
        {
            foreach ($cellName as $k1=>$v1)
            {
                $text=$v[$v1[2]];
                if($k1==4){
                    $text= $this -> checkVal['sexVal'][$text];
                }
                if($k1==10){
                    $text= $this -> checkVal['educationVal'][$text];
                }

                $data[$k][$v1[2]]=$text;
            }
        }

        $this->ExcelExport($title,$cellName,$data);
    }



    /**
     * 用户签到导出
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function signExport(){
        $Signmodel =new Sign();
        $model=$Signmodel->userGign();
        // 定义条件
        $id = $this -> param['id'];
        $uid= $this -> param['uid'];
        $where=array('uid'=>$uid);
        if(!empty($id)){
            $where['id'] = ['in', $id];
        }
        $title="用户签到";
        $field=array('s.id','c.name','c.photo','s.date');
        // 获取数据
        $data  =$model->field($field)->where($where)->order('s.date desc')->select()->toArray();

        $cellName=array(['班级',20,'name'],['签到时间',20,'date']);

        //处理数据
        foreach ($data as $k=>$v)
        {
            foreach ($cellName as $k1=>$v1)
            {
                $text=$v[$v1[2]];
//                if($k1==1){
//                    $text= date("Y-m-d H:i:s",$text);
//                }

                $data[$k][$v1[2]]=$text;
            }
        }
        $this->ExcelExport($title,$cellName,$data);
    }

}