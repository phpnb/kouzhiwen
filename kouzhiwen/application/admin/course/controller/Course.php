<?php
/**
 * [视频管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 15:33:43
 * @Copyright:
 */
namespace app\admin\course\controller;  
use app\admin\course\model\Course as model;
use app\admin\root\controller\Common;
use app\admin\course\model\CourseType;
use app\admin\root\model\Classify;
use app\admin\info\model\Teacher;
use app\common\extend\Rongcloudapi;
use app\common\extend\Aliyun;

class Course extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'is_recommendVal'=>['0'=>'否','1'=>'是'],
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
//        $enterprise_id=$this->user['enterprise_id'];
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        // 搜索关键词
        $keywords = input('get.keywords');
        $type=$this->param['type']?$this->param['type']:1;
        //实例化模型
        $model = new model;
        $where =array('c.enterprise_id'=>$this -> checkVal['enterprise_id']);
        switch ($type){
            case 1:$where['c.status']=1;break;
            case 2:$where['c.status']=0;break;
            default:break;
        }
        if (!empty($keywords)) {
            $where['c.title'] = ['like', "%{$keywords}%"];
        }
        $field=array('c.*','t.name');
        $model=$model->alias('c')->join('teacher t','t.id=c.teacher_id','LEFT');
        // 获取数据
        $data  = admin_page($model, $where,'c.weight DESC,c.created_at desc',$field);

        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }else{
            $CourseType=new CourseType();
            $type_id=$CourseType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['type_idVal']=$this->array_convert($type_id,'id','name');
        }
        $this -> checkVal['typeVal']=array('1'=>'专业知识课','2'=>'选修课','3'=>'直播课');
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
     * [add 添加数据]
     */
    public function add(){
        $enterprise_id=$this->user['enterprise_id'];
        $data = input('post.');
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['created_at'] = time();
            $data['enterprise_id'] =$enterprise_id;
            $data['start'] = strtotime($data['start']);
            $data['status'] =1;
            $check=array('id','enterprise_id','reading','look_num','comment_num','created_at','updated_at','status');
            if($enterprise_id==0){
                $check[]='type_id';
                $check[]='power';
            }else{
                $check[]='classify_id';
            }
            if($data['type']==2){
                $data['teacher_id']=0;
                $check[]='teacher_id';
            }
            if($data['type']!=3){
                $check[]='start';
            }else{
                $data['scene'] =1;
                $check[]='url';
                if (!empty($data['url2'])) {
                    $data['url'] = $data['url2'];
                }
                $check[]='power';
            }
            // 验证
            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }
            $id=$model -> addData();
            // 添加数据
            if (!$id) return ajax('添加失败', 2);
            if($data['type']==3){
                $Rongcloud =new Rongcloudapi();
                $Aliyun =new Aliyun();
                $Rongcloud->RongCloud->chatroom()->create(["zb_a_$id"=>$data['title']]);
                $updatadata=array();
                $updatadata['aliyun_push'] =$Aliyun->getPushSteam("zb_a_$id",$data['start']);
                $updatadata['aliyun_pulla'] =$Aliyun->getPullSteam("zb_a_$id",$data['start']);
                $model -> editData(['id'=>$id],$updatadata);
            }
            $this->AddLog('添加视频'.$data['title']);
            return ajax('添加成功');
        }


        $Teacher =new Teacher();
        $keyword = $data['teacher_id'];

        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
            $this -> checkVal['teacher']=$Teacher->getAll(['identity'=>['like','%3%','name'=>['like','%$keyword%']],'status'=>'1']);
        }else{


            $where['enterprise_id'] = ['in',[$enterprise_id,0]];
            $where['status'] = '1';
            $where['identity'] = ['like','%3%','name'=>['like','%$keyword%']];
            $this -> checkVal['teacher']=$Teacher->getAll($where);
//            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id,'identity'=>['like','%3%','name'=>['like','%$keyword%']]]);


        }

        return view('', [
            'checkVal'  => $this -> checkVal,
            'enterprise_id'  => $enterprise_id,
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function edit(){
        $model = new model;
        $enterprise_id=$this->user['enterprise_id'];
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据



            $data = input('post.');

            if (!empty($data['url2'])){
                $data['url'] = $data['url2'];
                unset($data['url2']);
            }else{
                unset($data['url2']);
        }

            $data['updated_at'] = time();
            $data['start'] = strtotime($data['start']);
            $check=array('id','enterprise_id','reading','look_num','comment_num','created_at','updated_at','status');
            if($enterprise_id==0){
                $check[]='type_id';
                $check[]='power';
            }else{
                $check[]='classify_id';
            }
            $id=$data['id'];
            if($data['type']==2){
                $data['teacher_id']=0;
                $check[]='teacher_id';
            }
            if($data['type']!=3){
                $check[]='start';
            }else{
                $check[]='url';
                if (!empty($data['url2'])) {
                    $data['url'] = $data['url2'];
                }
                $check[]='power';
                $Aliyun =new Aliyun();
                $data['aliyun_push'] =$Aliyun->getPushSteam("zb_a_$id",$data['start']);
                $data['aliyun_pulla'] =$Aliyun->getPullSteam("zb_a_$id",$data['start']);
            }
            // 验证
            if (!$model -> checkData($data,$check)) {
                return ajax($model -> err, 2);
            }
            if($data['type']==3){

                $Rongcloud =new Rongcloudapi();
                $rongdata=$Rongcloud->RongCloud->chatroom()->query(["zb_a_$id"]);
            
                $rongdata=json_decode($rongdata);
                if($rongdata->code==200){
                    if(empty($rongdata->chatRooms)){
                        $rongdata=$Rongcloud->RongCloud->chatroom()->create(["zb_a_$id"=>$data['title']]);
                        $rongdata=json_decode($rongdata);
                        if($rongdata->code!=200){
                            return ajax('融云出错', 2);
                        }
                    }
                }else{
                    return ajax('融云出错', 2);
                }
            }
//            // 修改数据
//            if($data['url2']){
//                $model->where('id', $data['id'])
//                    ->update(['url' => $data['url2']]);
//                return ajax('修改成功');
//            }

            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改视频'.$data['title']);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $Teacher =new Teacher();
        $keyword = $data['teacher_id'];

        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
            $this -> checkVal['teacher']=$Teacher->getAll(['identity'=>['like','%3%','name'=>['like','%$keyword%']],'status'=>'1']);
        }else{


            $where['enterprise_id'] = ['in',[$enterprise_id,0]];
            $where['status'] = '1';
            $where['identity'] = ['like','%3%','name'=>['like','%$keyword%']];
            $this -> checkVal['teacher']=$Teacher->getAll($where);
//            $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id,'identity'=>['like','%3%','name'=>['like','%$keyword%']]]);


        }
//        $Teacher =new Teacher();
//        $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id,'identity'=>['like','%1%']]);
        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
        }
        $this -> checkVal['video']='1';
        if(preg_match("/\.(gif|jpg|jpeg|bmp|png)/i",$data['url'])){
            $this -> checkVal['video']='2';
        }

        //dump($this -> checkVal);die;
        return view('',[
            'data'     => $data,
            'id'    => $id,
            'enterprise_id'  => $enterprise_id,
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
        if (empty( $this -> param['type']) || empty( $this -> param['id'])) return ajax('没有必要参数');
        // 定义条件
        $id = $this -> param['id'];
        $type= $this -> param['type'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if($type==1){
            $data=$model->getOne($where);
            if (!$model -> delData($where)) return ajax('删除失败');
            if($data['type']==3){
                $Rongcloud =new Rongcloudapi();
                $Rongcloud->RongCloud->chatroom()->destroy(["zb_a_$id"]);
            }
            $this->AddLog('删除视频'.$id);
            return ajax('删除成功');
        }elseif($type==2){
            if (!$model -> editData($where,['status'=>1,'scene'=>1,'updated_at'=>time()])) return ajax('审核失败');
            $this->AddLog('审核视频'.$id);
            return ajax('审核成功');
        }

    }

    /**
     * 获取分类
     * @return \think\response\Json
     */
    public function typeList(){
        if(empty($this->param['type'])) return ajax('请传type');
        $enterprise_id=$this->user['enterprise_id'];
        $CourseType=new CourseType();
        $type=$CourseType->getAll(['enterprise_id'=>$enterprise_id,'type'=>$this->param['type']]);
        return ajax('获取成功',1,$type);
    }


}