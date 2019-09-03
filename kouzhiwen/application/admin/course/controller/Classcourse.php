<?php
/**
 * [课程管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-27 15:11:04
 * @Copyright:
 */
namespace app\admin\course\controller;
use app\admin\course\model\ClassCourse as model;
use app\admin\root\controller\Common;
use app\admin\course\model\Study;
use app\admin\info\model\Teacher;
use app\common\extend\Rongcloudapi;
use app\common\extend\Aliyun;

class Classcourse extends Common{
    protected $checkVal = [];
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $teachermodel=new Teacher();
        $studymodel=new Study();
        $this -> checkVal = [
            'statusVal'=>[1=>'预习',2=>'直播',3=>'复习'],
            'typeVal'=>[1=>'直播课',2=>'录播课'],
            'teacher_idVal'=>$this->array_convert($teachermodel->getAll(['identity'=> '1,3']),'id','name'),
            'class_idVal'=>$this->array_convert($studymodel->getAll(['enterprise_id'=>$this->user['enterprise_id']]),'id','name'),
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =array('s.enterprise_id'=>$this->user['enterprise_id']);
        if (!empty($keywords)) {
            $where['c.title'] = ['like', "%{$keywords}%"];
        }
        $model=$model->alias("c")->join('class s','s.id=c.class_id','left');
        $field=array('c.id','c.title','c.type','c.teacher_id','c.photo','c.url','c.reading','c.start','c.status','c.updated_at','s.name');
        // 获取数据
        $data  = admin_page($model, $where,'c.id desc',$field);
        if (!empty($data['data'])) {
            foreach($data['data'] AS $k => $v){

                $data['data'][$k]['url'] =  json_decode($v['url']);
            }
        }
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
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            $Aliyun =new Aliyun();
            // 获取post数据
            $data = input('post.');

            $data['created_at'] = time();
            $data['updated_at'] = time();
            $data['status'] =1;
            $data['url'] = json_encode($data['url']);
            $data['start'] = strtotime($data['start']);
            $check=['id','reading','comment_num',' updated_at','words'];
            if($data['type']==2){
                $check[]='start';
                $data['status'] =3;
            }
            // 验证
            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }
            $corou = new Study();
            $cor = $corou->getOne(['id'=>$data['class_id']]);
            $shuju = ['js_id'=>$cor['js_id'].$data['teacher_id'].','];
            $corou -> editData(['id'=>$data['class_id']],$shuju);
//            dump($cor);die;
            $id=$model -> addData();
            // 添加数据
            if (!$id) return ajax('添加失败', 2);
            if($data['type']==1){
                $Rongcloud =new Rongcloudapi();
                $Rongcloud->RongCloud->chatroom()->create(["zb_b_$id"=>$data['title']]);
                $updatadata=array();
                $updatadata['aliyun_push'] =$Aliyun->getPushSteam("zb_b_$id",$data['start']);
                $updatadata['aliyun_pulla'] =$Aliyun->getPullSteam("zb_b_$id",$data['start']);
                $model -> editData(['id'=>$id],$updatadata);
            }

            $this->AddLog('添加课程管理'.$data['title']);
            return ajax('添加成功');
        }

        $Teacher =new Teacher();
        $enterprise_id = $this->user['enterprise_id'];
        if($enterprise_id==0){
            $this -> checkVal['teacher']=$Teacher->getAll(['identity'=>['like','%3%','name'=>['like','%$keyword%']],'status'=>'1'],'id','name');
        }else{
            $where['enterprise_id'] = ['in',[$enterprise_id,0]];
            $where['status'] = '1';
            $where['identity'] = ['like','%3%','name'=>['like','%$keyword%']];
            $this -> checkVal['teacher']=$Teacher->getAll($where,'id','name');
//            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id,'identity'=>['like','%3%','name'=>['like','%$keyword%']]]);


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

            if (!empty($data['url2'])){
                $data['url'][0] = $data['url2'];
                unset($data['url2']);
            }else{
                unset($data['url2']);
            }


            $Aliyun =new Aliyun();
            $data['updated_at'] = time();
            $data['url'] = json_encode($data['url']);
            $data['start'] = strtotime($data['start']);
            $id=$data['id'];
            $data['aliyun_push'] =$Aliyun->getPushSteam("zb_b_$id",$data['start']);
            $data['aliyun_pulla'] =$Aliyun->getPullSteam("zb_b_$id",$data['start']);
            $check=['id','reading','comment_num','updated_at','words','status'];
            if($data['type']==2){
                $check[]='start';
                $data['status'] =3;
            }
            // 验证
            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }

            if($data['type']==1){
                $Rongcloud =new Rongcloudapi();
                $rongdata=$Rongcloud->RongCloud->chatroom()->query(["zb_b_$id"]);
                $rongdata=json_decode($rongdata);
                if($rongdata->code==200){
                    if(empty($rongdata->chatRooms)){
                        $rongdata=$Rongcloud->RongCloud->chatroom()->create(["zb_b_$id"=>$data['title']]);
                        $rongdata=json_decode($rongdata);
                        if($rongdata->code!=200){
                            return ajax('融云出错', 2);
                        }
                    }
                }else{
                    return ajax('融云出错', 2);
                }
            }

            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改课程管理'.$data['title']);
            return ajax('修改成功');
        }

        $Teacher =new Teacher();
        $enterprise_id = $this->user['enterprise_id'];
        if($enterprise_id==0){
            $this -> checkVal['teacher']=$Teacher->getAll(['identity'=>['like','%3%','name'=>['like','%$keyword%']],'status'=>'1'],'id','name');
        }else{
            $where['enterprise_id'] = ['in',[$enterprise_id,0]];
            $where['status'] = '1';
            $where['identity'] = ['like','%3%','name'=>['like','%$keyword%']];
            $this -> checkVal['teacher']=$Teacher->getAll($where,'id','name');
//            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id,'identity'=>['like','%3%','name'=>['like','%$keyword%']]]);


        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $data['url'] = json_decode($data['url']);

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
        $Rongcloud =new Rongcloudapi();
        $Rongcloud->RongCloud->chatroom()->destroy(["zb_b_$id"]);
        $this->AddLog('删除课程管理'.$id);
        return ajax('删除成功');
    }




}