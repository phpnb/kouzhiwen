<?php
/**
 * [手续费设置控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-30 15:32:49
 * @Copyright:
 */
namespace app\admin\finance\controller; 
use app\admin\root\controller\Common;
use app\common\model\Protocol;

class Procedures extends Common{
    /**
     * [index 默认方法]
     */
    public function index(){
        $Protocol =new Protocol();
        $data=$Protocol->getOne(['enterprise_id'=>$this->user['enterprise_id'],'type'=>'procedures']);
        if($this->isPost){
            $procedures=$this->param['procedures'];
            if($procedures>100 || $procedures<0){
                return ajax("设置失败 手续费不能大于100或小于0",2);
            }
            if(empty($data)){
                $data=['enterprise_id'=>$this->user['enterprise_id'],'type'=>'procedures','title'=>'手续费','content'=>$procedures,'updated_at'=>time()];
                $res=$Protocol->addData($data);
            }else{
                $update=['content'=>$procedures,'updated_at'=>time()];
                $res=$Protocol->editData(['id'=>$data['id']],$update);
            }

            if(!$res)return ajax("设置失败",2);
            $this->AddLog('设置手续费为'.$procedures.'%');
            return ajax("设置成功",1);
        }

        return view('',$data);
    }
}