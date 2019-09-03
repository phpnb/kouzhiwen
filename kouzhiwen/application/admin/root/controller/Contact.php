<?php
/**
 * [联系我们控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-09-18 11:04:04
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\admin\root\controller\Common;
use app\admin\root\model\Protocol as model;


class Contact extends Common{

    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        // 获取数据
        $data  = $model -> getOne(['type'=>'phone']);
        if($this->isPost){
            if(empty($this->param['phone']) || empty($this->param['qq']) || empty($this->param['email'])){
                return ajax("手机号或QQ、邮箱为必填",2);
            }
            $upda=json_encode(['phone'=>$this->param['phone'],'qq'=>$this->param['qq'],'email'=>$this->param['email']]);
            if(empty($data)){
                $data=['enterprise_id'=>$this->user['enterprise_id'],'type'=>'phone','title'=>'联系扣之问','content'=>$upda,'updated_at'=>time()];
                $res=$model->addData($data);
            }else{
                $update=['content'=>$upda,'updated_at'=>time()];
                $res=$model->editData(['id'=>$data['id']],$update);
            }

            if(!$res)return ajax("保存失败",2);
            $this->AddLog('修改联系我们');
            return ajax("保存成功",1);
        }

        if(!empty($data)){
            $data=json_decode($data['content'],true);
        }

        // 模板
        return view('',[
            'data'      => $data,
            'keywords'  => $keywords,
            'checkVal'  => $this -> checkVal
        ]);
    }


}