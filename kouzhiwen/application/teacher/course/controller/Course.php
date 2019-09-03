<?php
/**
 * [视频管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-07-31 15:33:43
 * @Copyright:
 */
namespace app\teacher\course\controller;  
use app\teacher\course\model\Course as model;
use app\teacher\root\controller\Common;
use app\teacher\course\model\CourseType;
use app\teacher\root\model\Classify;
use app\teacher\info\model\Teacher;

class Course extends Common{
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
        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =array('c.enterprise_id'=>$this -> checkVal['enterprise_id']);
        if (!empty($keywords)) {
            $where['c.title'] = ['like', "%{$keywords}%"];
        }
        $field=array('c.*','t.name');
        $model=$model->alias('c')->join('teacher t','t.id=c.teacher_id','LEFT');
        // 获取数据
        $data  = admin_page($model, $where,'c.weight DESC',$field);

        if($this -> checkVal['enterprise_id']==0){
            $Classify=new Classify();
            $classify=$Classify->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['classify_idVal']=$this->array_convert($classify,'id','name');
        }else{
            $CourseType=new CourseType();
            $type=$CourseType->getAll(['enterprise_id'=>$this -> checkVal['enterprise_id']]);
            $this -> checkVal['type_idVal']=$this->array_convert($type,'id','name');
        }
        $this -> checkVal['typeVal']=array('1'=>'专业知识课','2'=>'选修课','3'=>'直播课');
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
        $enterprise_id=$this->user['enterprise_id'];
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['created_at'] = time();
            $data['enterprise_id'] =$enterprise_id;
            $data['status'] =1;
            $check=array('id','enterprise_id','reading','look_num','comment_num','created_at','updated_at','status');
            if($enterprise_id==0){
                $check[]='type_id';
            }else{
                $check[]='classify_id';
            }
            // 验证
            if (!$model -> checkData($data, $check)) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            return ajax('添加成功');
        }
        $Teacher =new Teacher();
        $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id]);
        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
        }else{
            $CourseType=new CourseType();
            $type=$CourseType->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['type']=$type;
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
            $data['updated_at'] = time();
            $check=array('id','enterprise_id','reading','look_num','comment_num','created_at','updated_at','status');
            if($enterprise_id==0){
                $check[]='type_id';
            }else{
                $check[]='classify_id';
            }
            // 验证
            if (!$model -> checkData($data,$check)) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $Teacher =new Teacher();
        $this -> checkVal['teacher']=$Teacher->getAll(['enterprise_id'=>$enterprise_id]);
        if($enterprise_id==0){
            $Classify=new Classify();
            $classify_id=$Classify->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['classify']=$classify_id;
        }else{
            $CourseType=new CourseType();
            $type=$CourseType->getAll(['enterprise_id'=>$enterprise_id]);
            $this -> checkVal['type']=$type;
        }
        $this -> checkVal['video']='1';
        if(preg_match("/\.(gif|jpg|jpeg|bmp|png)/i",$data['url'])){
            $this -> checkVal['video']='2';
        }

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
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> delData($where)) return ajax('删除失败');
        return ajax('删除成功');
    }


}