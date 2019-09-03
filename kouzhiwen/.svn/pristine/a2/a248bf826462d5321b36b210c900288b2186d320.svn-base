<?php
/**
 * [企业管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-02 20:24:29
 * @Copyright:
 */
namespace app\admin\info\controller;  
use app\admin\info\model\Enterprise as model;
use app\admin\root\controller\Common;
use app\admin\root\model\Admin;

class Enterprise extends Common{
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
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $type=$this->param['type']?$this->param['type']:1;
        $where =array('status'=>$type);
        if($type==3){
            $start=date("Y-m-d");
            $end=date("Y-m-d",strtotime("+1 week"));
            $where =array('status'=>1,'expire'=>['between',[$start,$end]]);
        }elseif ($type==4){
            $start=date("Y-m-d");
            $where =array('status'=>1,'expire'=>['<',$start]);
        }
        if (!empty($keywords)) {
            $where['name'] = ['like', "%{$keywords}%"];
        }
        if($this->user['enterprise_id']!=0){
            $where['id']= $this->user['enterprise_id'];
        }
        // 获取数据
        $data  = admin_page($model, $where);
        
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
        if ($this -> isPost) {
            // 实例化模型
            $model = new model;
            // 获取post数据
            $data = input('post.');
            $data['created_at'] = time();
            if(empty($data['up']))$data['up']=array();
            $data['up'] = json_encode($data['up']);

            // 验证
            if (!$model -> checkData($data, ['id','up','status','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }
            $res=$model->getOne(['name'=>$data['name'],'status'=>1]);
            if ($res) return ajax('企业名称已重复', 2);
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog("添加企业{".$data['name']."}成功");
            return ajax('添加成功');
        }
        $model = new model;
        $this -> checkVal['up']=$model->getAll(['status'=>1]);
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
            if(empty($data['up']))$data['up']=array();
            $data['up'] = json_encode($data['up']);
            // 验证
            if (!$model -> checkData($data, ['id','up','status','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }
            $res=$model->getOne(['name'=>$data['name'],'id'=>['not in',[$data['id']],'status'=>1]]);
            if ($res) return ajax('企业名称已重复', 2);
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog("修改企业{".$data['name']."}成功");
            return ajax('修改成功');
        }

        // 获取旧数据
        $id = (int)$this -> param['id'];
        $data = $model -> getOne(['id'=>$id]);
        $this -> checkVal['up']=$model->getAll(['status'=>1,'id'=>['not in',[$data['id']]]]);

        $data['up']=json_decode($data['up']);

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
         $status=$this->param['status']?$this->param['status']:2;

         $msg="停用";
         if($status==1){
             $msg="恢复正常";
         }
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> editData($where,['status'=>$status,'updated_at'=>time()])) return ajax($msg.'失败');

        $this->AddLog($msg."企业成功[".$id."]");
        return ajax($msg.'成功');
    }

    /**
     * 企业成员
     */
    public function  user(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $id = $this -> param['id'];
        $model = new Admin();
        $where['enterprise_id'] = $id;

        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }

    /**
     * 添加企业成员
     */
    public function  useradd(){
        $id = $this -> param['enterprise_id'];

        // POST提交处理
        if ($this -> isPost) {
            $time=time();
            $data = input('post.');
            // 实例化模型
            $model = db('admin');
            // 判断用户名是否存在
            $oldData = $model -> where(['username'=>$data['username']]) -> find();
            if ($oldData) {
                return ajax('用户名已存在', 2);
            }
            $data['password'] = md5(md5($data['password']));
            $data['group_id'] =23;
            if ($this -> user['module'] == 'admin/root') {
                $data['is_top'] = 1;
            }
            $data['status']=1;
            $data['created_at']=$time;
            $data['updated_at']=$time;
            // 执行添加
            $res = $model -> insert($data);
            if (!$res) {
                return ajax('添加失败', 2);
            }
            $this->AddLog('添加企业成员'.$data['username']);
            return ajax('添加成功');
        }


        // 获取权限组
        $gModel = db('access_group');
        $where = ['enterprise_id'=>$this->user['enterprise_id']];
        $group = $gModel -> where($where) -> field('id,name') -> select() -> toArray();
        if (empty($group)) {
            echo '该模块还未创建权限组';die;
        }
        // 获取模块
        $module = scandir(APP_PATH . 'admin');
        foreach ($module AS $k => $v) {
            if (strstr($v, '.')) unset($module[$k]);
        }

        if (empty($mname)) {
            $tmp = explode('/', $this -> user['module']);
            $mname = $tmp[1];
        }

        // 载入模板
        return view('', [
            'group'     => $group,
            'id'    => $id,
            'module'    => $module,
            'mname'     => $mname
        ]);
    }

    /**
     * [edit 编辑]
     */
    public function templet(){
        $model = new model;
        // POST提交处理
        if ($this -> isPost) {
            // 获取post数据
            $data = input('post.');
            $data['updated_at'] = time();
            if(empty($data['up']))$data['up']=array();
            $data['up'] = json_encode($data['up']);
            // 验证
            if (!$model -> checkData($data, ['id','up','status','created_at','updated_at','student','expire'])) {
                return ajax($model -> err, 2);
            }
            $res=$model->getOne(['name'=>$data['name'],'id'=>['not in',[$data['id']],'status'=>1]]);
            if ($res) return ajax('企业名称已重复', 2);
            // 修改数据
            if (!$model -> editData(['id'=>$this->user['enterprise_id']])) return ajax('没有数据被修改', 2);
            $this->AddLog("修改企业{".$data['name']."}成功");
            return ajax('修改成功');
        }

        // 获取旧数据
        $id =$this->user['enterprise_id'];
        $data = $model -> getOne(['id'=>$id]);
        $this -> checkVal['up']=$model->getAll(['status'=>1,'id'=>['not in',[$data['id']]]]);

        $data['up']=json_decode($data['up']);

        return view('',[
            'data'     => $data,
            'id'    => $id,
            'checkVal' => $this -> checkVal
        ]);
    }


}