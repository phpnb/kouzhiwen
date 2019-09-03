<?php
/**
 * [问卷调查控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-28 16:17:34
 * @Copyright:
 */
namespace app\admin\course\controller;  
use app\admin\course\model\Questionnaire as model;
use app\admin\root\controller\Common;
use app\admin\course\model\Study;

class Questionnaire extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $studymodel=new Study();
        $this -> checkVal = [
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
        $where =array('c.enterprise_id'=>$this->user['enterprise_id']);
        if (!empty($keywords)) {
            $where['q.title'] = ['like', "%{$keywords}%"];
        }
        $field=array('q.*','c.name');
        $model=$model->alias('q')->join('class c','c.id=q.class_id','left');
        // 获取数据
        $data  = admin_page($model, $where,'q.id desc',$field);
        
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
            // 获取post数据
            $data = input('post.');
            $data['updated_at'] = time();
            
            // 验证
            if (!$model -> checkData($data, ['id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加调查问卷'.$data['title']);
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
            
            // 验证
            if (!$model -> checkData($data, ['id','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改调查问卷'.$data['title']);
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
        $this->AddLog('删除调查问卷');
        return ajax('删除成功');
    }

    /**
     * 设置试题
     * @return \think\response\View
     */
    public function problem(){
        $model = new model;
        // 获取旧数据
        $id = (int)$this -> param['id'];
        if(empty($id)){
            return ajax('请上传id',2);
        }
        $type=$this->param['type']?$this->param['type']:1;
        $data = $model -> getOne(['id'=>$id]);
        if(empty($data)){
            return ajax('没有此问卷',2);
        }
        if ($this -> isPost) {
            if ($type==2){
                $excel = request()->file('file')->getInfo();
//                $file=request()->file('file') -> move(ROOT_PATH . 'public' . DS . 'uploads')-> getRealPath();
//                ini_set('max_execution_time', '0');
//                Vendor('PHPExcel.PHPExcel');
//                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
//                $objPHPExcel = $objReader->load($file);
//                vendor("PHPExcel.PHPExcel");

                $objPHPExcel = \PHPExcel_IOFactory::load($excel['tmp_name']);//读取上传的文件
//                $objPHPExcel = $objReader ->load($excel['tmp_name']);
                $arrExcel = $objPHPExcel->getSheet(0)->toArray();//获取其中的数据
                unset($arrExcel[0]);
                $data=array();
                foreach ($arrExcel as $key=>$val){
                    $arr=[];
                    $answer=[];
                    $arr['id']=$key;
                    if($val[0]=='单选框'){
                        $type='adio';
                    }elseif($val[0]=='多选框'){
                        $type='checkbox';
                    }elseif($val[0]=='文本框'){
                        $type='textarea';
                    }else{
                        $type='textarea';
                    }
                    $arr['type']=$type;
                    $arr['title']=$val[1];
                    $arr['score']=0;
                    if($arr['type']=='adio' || $arr['type']=='checkbox'){
                        $answer=array(
                            array("id"=>1,"title"=>$val[2],"status"=>true),
                            array("id"=>2,"title"=>$val[3],"status"=>false,),
                            array("id"=>3,"title"=>$val[4],"status"=>false,),
                            array("id"=>4,"title"=>$val[5],"status"=>false,),
                        );
                    }
                    $arr['answer']=$answer;
                    $data[]=$arr;
                }
                $this->param['data']=json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            if(empty($this->param['data'])){
                return ajax('请填写试题',2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$id],['data'=>$this->param['data'],'updated_at'=>time()])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改调查问卷'.$data['title']);
            return ajax('修改试题');
        }
        if(empty($data['data'])){
            $data['data']="[]";
        }

        return view('',[
            'data'     => $data,
            'id'    => $id,
            'type'    => $type,
            'checkVal' => $this -> checkVal
        ]);
    }


}