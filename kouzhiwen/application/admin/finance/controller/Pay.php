<?php
/**
 * [提现管理控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-30 16:36:53
 * @Copyright:
 */
namespace app\admin\finance\controller;  
use app\admin\finance\model\TeacherPay as model;
use app\admin\root\controller\Common;
use app\common\extend\Alipay;
use app\common\extend\Wechat;

class Pay extends Common{
    protected $checkVal = []; 
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        parent::_initialize();
        $this -> checkVal = [
            'pay_typeVal'=>[1=>'微信',2=>'支付宝']
        ];
    }
    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $status = $this->param['status'];
        $status=$status?$status:1;
        //实例化模型
        $model = new model;
        $where =['p.status'=>$status];
        if (!empty($keywords)) {
            $where['p.account_num|t.name'] = ['like', "%{$keywords}%"];
        }
        $model=$model->alias('p')
            ->join('teacher t','t.id=p.teacher_id','left')
            ->join('enterprise e','e.id=t.enterprise_id','left');
        // 获取数据
        $field=array('p.id','p.pay_type','p.account','p.brokerage','p.created_at','p.account_num','t.name','e.name as enterprisename');
        $data  = admin_page($model, $where,'p.created_at desc',$field);
        
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
            'status'  => $status,
            'checkVal'  => $this -> checkVal
        ]);
    }

    public function pay(){
        $id=$this->param['id'];
//        if (!$this -> isPost || !$id) return ajax('非法请求',2);
        $model = new model;
        $data=$model->getOne(['id'=>$id]);

        if($data['pay_type']==1){
            $Wechat=new Wechat();
            $res=$Wechat->pay($data);
        }elseif ($data['pay_type']==2){
            $Alipay=new Alipay();
            $res=$Alipay->pay($data);
        }else{
            return ajax('数据错误',2);
        }

        if(!$res){
            return ajax('打款失败',2);
        }
        $res=$model->editData(['id'=>$data['id']],['updated_at'=>time(),'status'=>2]);
        if(!$res){
            return ajax('打款失败',2);
        }
        $this->AddLog('打款成功');
        return ajax('打款成功',1);
    }


}