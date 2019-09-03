<?php
/**
 * [广告位管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-09 15:27:15
 * @Copyright:
 */
namespace app\admin\root\controller;  
use app\admin\root\model\Advertisements as model;
use app\admin\root\model\Aduser;
use app\admin\root\model\User;

class Advertisements extends Common{
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
        $where = '';
        if (!empty($keywords)) {
            $where['title'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $data  = admin_page($model, $where);
        
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
            $data['created_at'] = time();
            
            // 验证
            if (!$model -> checkData($data, ['id','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 添加数据
            if (!$model -> addData()) return ajax('添加失败', 2);
            $this->AddLog('添加广告'.$data['title']);
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
            if (!$model -> checkData($data, ['id','created_at','updated_at'])) {
                return ajax($model -> err, 2);
            }
            // 修改数据
            if (!$model -> editData(['id'=>$data['id']])) return ajax('没有数据被修改', 2);
            $this->AddLog('修改广告'.$data['title']);
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
        $this->AddLog('删除广告'.$id);
        return ajax('删除成功');
    }

    /**
     * [aduser 报名成员]
     */
    public function aduser(){
        // 实例化模型
        $model = new Aduser();


        $keywords = input('get.keywords');
        if (!empty($keywords)) {
            $where['name|tel'] = ['like', "%{$keywords}%"];
        }

        $id = $this -> param['id'];

        $where['adid'] =  $id;

        $model = $model->alias('a')->join('user u','a.userid=u.uid ');
        $filed=array("u.*");
        $data  = admin_page($model, $where,"u.created_at desc",$filed);

        if(!empty($this->param['exl'])) {
            $cellName = array(
                ['姓名', 10, 'name'], ['电话', 20, 'oph'], ['公司名称', 20, 'company_name'], ['单位职称', 50, 'unit_title']
            );

            $this->ExcelExport('报名学员', $cellName, $data);
        }

        return view('',[
            'data'      => $data['data'],
            'keywords'  => $keywords,
        ]);
    }


}