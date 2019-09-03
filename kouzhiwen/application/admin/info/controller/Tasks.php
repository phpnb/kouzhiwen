<?php


namespace app\admin\info\controller;
use app\admin\root\controller\Common;
use app\admin\info\model\Tasks as model;
use app\admin\root\model\User;
use app\admin\course\model\ClassCourse;
use app\admin\course\model\Study;
class Tasks extends Common{
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');

        $this -> checkVal['enterprise_id']=$this->user['enterprise_id'];
        //实例化模型
        $model = new model;
        $where =['enterprise_id'=>$this -> checkVal['enterprise_id'],'status'=>'1'];
        if (!empty($keywords)) {
            $where['name'] = ['like', "%{$keywords}%"];
        }

            $model=$model->alias('t')->join('user c','t.uid=c.uid');
            $filed=array("c.name","c.phone","c.face","c.uid","c.enterprise_id","t.*");
            $data  = admin_page($model, $where,"t.id desc",$filed);

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

            $enterprise=$this->user['enterprise_id'];
            $study = new Study();
            $classcourse = new ClassCourse();
            $field = array("id","name");
            $res = $study->where(['enterprise_id'=>$enterprise])->field($field)->select()->toArray();
            foreach ($res as $k=>&$v){
                $ags = $classcourse->where(['class_id'=>$v['id']])->field(['title','id as cid'])->select()->toArray();
                $res[$k]['title'] = $ags;

            }
            $user = new User();
            $user = $user->where(['enterprise_id'=>$enterprise,'status'=>'1'])->field(['uid','name as username'])->select()->toArray();
//            dump($res);die;

//            $res=$model -> addData();
            // 添加数据
//            if (!$res) return ajax('添加失败', 2);
//
//            $this->AddLog('添加教师'.$data['username']);
//            return ajax('添加成功');
            // 实例化模型
        if($this->isPost){
            $model = new model;
            // 获取post数据
            $data = input('post.');

//            dump($data);die;
            $data['cid']=implode(",", $data['class_id']);
            foreach ($data['uid'] as $k=>&$v){
                $model -> addData(['uid'=>$v,'cid'=>$data['cid']]);
            }
            return ajax('Success','1');
        }



        return view('', [
            'checkVal'  => $this -> checkVal,
            'user'      =>$user,
            'res'  => $res,
        ]);
    }


    /**
     * [edit 修改数据]
     */
    public function edit(){
        //获取原来的数据
        $model = new model;
        $id = (int)$this -> param['id'];
        $ags = $model -> getOne(['id'=>$id]);
        $cid = explode(",",$ags['cid']);
        $uid = (int)$ags['uid'];
        $user = new User();
        $pp = $user->where(['uid'=>$uid])->select()->toArray();
//        dump($ags['cid']);die;
        $enterprise=$this->user['enterprise_id'];
        $study = new Study();
        $classcourse = new ClassCourse();
        $field = array("id","name");
        $res = $study->where(['enterprise_id'=>$enterprise])->field($field)->select()->toArray();
        foreach ($res as $k=>&$v){
            $ags = $classcourse->where(['class_id'=>$v['id']])->field(['title','id as cid'])->select()->toArray();
            $res[$k]['title'] = $ags;

        }

        if($this->isPost){
            // 获取post数据
            $data = input('post.');
            $data['cid']=implode(",", $data['cid']);
//            dump($data);die;
            $model -> editData(['id'=>$id],$data);
            return ajax('Success','1');


        }



        return view('', [
            'cid'   => $cid,
            'pp'    =>$pp,
            'ags'     => $ags,
            'checkVal'  => $this -> checkVal,
            'user'      =>$user,
            'res'  => $res,
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
        $model -> delData($where);
        return ajax('Success');
    }

    public function look(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $id = (int)$this -> param['id'];
        //实例化模型
        $model = new model;
        $where =['uid'=>$id];
        if (!empty($keywords)) {
            $where['tltle'] = ['like', "%{$keywords}%"];
        }
        $data = $model->where($where)->select()->toArray();
        foreach ($data as $v){
        }
        $res = explode(",",$v['cid']);
        $classcourse = new ClassCourse();
        $ags =  $classcourse->where('id',in,$res)->select()->toArray();
//dump($ags);die;
        // 模板
        return view('',[
            'ags'  => $ags,
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }

}

