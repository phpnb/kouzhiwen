<?php
/**
 * [im控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-03 18:00:03
 * @Copyright:
 */
namespace app\teacher\info\controller;
use app\teacher\root\controller\Common;
use app\admin\info\model\Teacher;

class Im extends Common{
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
    public function im(){
        if(!$this->param['id']){
            return ajax('请传教师id', 2);
        }
        $this->user=Teacher::find(['id'=>$this->param['id']]);

        $this->user['photo']=empty($this->user)?'/uploads/default.png':$this->user['photo'];

        return ajax('获取成功',1,['token'=>$this->user['rongcloud'],'appkey'=>config('rongcloud_key'),'user'=>$this->user]);
    }

}