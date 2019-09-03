<?php
/**
 * [充值控制器]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-29 16:42:13
 * @Copyright:
 */
namespace app\admin\finance\controller; 
use app\admin\root\controller\Common;
use app\common\model\Order;
use app\common\extend\Alipay;
use app\common\extend\Wechat;
use app\admin\info\model\User;
use app\common\model\Enterprise;
use app\common\model\UserDetailed;
use app\common\model\EnterpriseDetailed;

class Recharge extends Common{

    public $sign="";
    /**
     * [index 默认方法]
     */
    public function user(){

//        if ($this->param['type']) {
//            $price=$this->param['price'];
//            $pay_type=$this->param['type'];
//            if(empty($price))return ajax('请输入充值金额', 2);
//            if(empty($pay_type))return ajax('请选择充值方式', 2);
//            $data=['pay_type'=>$pay_type,'type'=>8,'type_id'=>$this->user['enterprise_id'],'name'=>'企业充值','price'=>$price];
//            $res=$this->AddOrder($data);
//            if(!$res)return ajax("充值失败",2);
//            if($pay_type==2){
//                return ajax("充值成功",1,$this->sign);
//            }
//
//        }
        if($this->isPost){
//            if(empty($this->param['price'])) return ajax("请输入充值金额",2);
            if(empty($this->param['enterprise'])) return ajax("请选择企业",2);
            if(empty($this->param['student'])) return ajax("请输入学员上限",2);
            if(empty($this->param['expire'])) return ajax("请选择到期时间",2);
            $time=time();
            $enterprisemodel = new Enterprise();
            $res=$enterprisemodel->editData(['id'=>$this->param['enterprise']],['student'=>$this->param['student'],'expire'=>$this->param['expire'],'updated_at'=>$time]);
            if(!$res){
                return ajax("充值失败",2);
            }
            $this->AddLog('平台企业充值 企业【'.$this->param['enterprise']."】 学员上限：".$this->param['student']." 到期时间:".$this->param['expire']);
            return ajax("充值成功",1);
//            $enterprisedetailedmodel = new EnterpriseDetailed();
//            $enterprisedetailedmodel->startTrans();
//            $enterprose=$enterprisemodel->getOne(['id'=>$this->param['enterprise']]);
//            $balance=$enterprose['balance']+$this->param['price'];
//            $time=time();
//            $res=$enterprisemodel->editData(['id'=>$this->param['enterprise']],['balance'=>$balance,'updated_at'=>$time]);
//            if(!$res){
//                $enterprisedetailedmodel->rollBack();
//                return ajax("充值失败",2);
//            }
//            $res=$enterprisedetailedmodel->addData(['enterprise_id'=>$this->param['enterprise'],'type'=>2,'title'=>'平台充值','price'=>$this->param['price'],'created_at'=>$time]);
//            if(!$res){
//                $enterprisedetailedmodel->rollBack();
//                return ajax("充值失败",2);
//            }
//            $enterprisedetailedmodel->commit();
//            $this->AddLog('平台学员充值 学员【'.$this->param['enterprise']."】 金额：".$this->param['price']);
//            return ajax("充值成功",1);
        }
        $Enterprisemodel= new Enterprise();
        if($this->param['type']==1){
            $data=$Enterprisemodel->getOne(['id'=>$this->param['id']]);
            return ajax("获取成功",1,$data);
        }
        $enterprise=$Enterprisemodel->getAll(['status'=>1]);
//        // 模板
        return view('',['enterprise_id'=>$this->user['enterprise_id'],'enterprise'=>$enterprise]);
    }

    /**
     * [index 默认方法]
     */
    public function index(){
        if ($this->param['type']) {
            $price=$this->param['price'];
            $pay_type=$this->param['type'];
            $uid=$this->param['uid'];
            if(empty($price))return ajax('请输入充值金额', 2);
            if(empty($uid))return ajax('请选择学员', 2);
            if(empty($pay_type))return ajax('请选择充值方式', 2);
            $data=['pay_type'=>$pay_type,'type'=>9,'type_id'=>$uid,'name'=>'学员充值','price'=>$price];
            $res=$this->AddOrder($data);
            if(!$res)return ajax("充值失败",2);
            if($pay_type==2){
                $this->AddLog('企业学员充值 学员【'.$this->param['uid']."】 金额：".$this->param['price']);
                return ajax("充值成功",1,$this->sign);
            }
        }
        $User= new User();
        $Enterprisemodel= new Enterprise();
        $user=$User->getAll(['enterprise_id'=>$this->user['enterprise_id'],'status'=>1]);
        $enterprise=$Enterprisemodel->getAll(['status'=>1]);
        // 模板
        return view('',['user'=>$user,'enterprise'=>$enterprise,'enterprise_id'=>$this->user['enterprise_id']]);
    }

    /**
     * 用户列表
     * @return \think\response\Json
     */
    public function userlist(){
        if(empty($this->param['id'])) return ajax("没有id",2);
        $User= new User();
        $user=$User->getAll(['enterprise_id'=>$this->param['id'],'status'=>1]);
        return ajax("获取成功",1,$user);
    }
    /**
     * 返回二维码
     * @return string
     */
    public function Recharge(){
        $img=$this->param['img'];
        return qrcode($img);
    }

    /**
     * 添加订单
     * @param $price
     * @param $pay_type
     * @return bool
     */
    public function AddOrder($data){
        $ordermodel= new Order();
        $time=time();
        $order_number=create_order_num();
        $pay_type=$data['pay_type'];
        if( $pay_type==1){
            $obj  = new Alipay();
            $this->sign =$obj->createPcPay(['subject'=>$data['name'],'out_trade_no'=>$order_number,'total_amount'=>$data['price']]);
        }else if($pay_type==2){
            $obj  = new Wechat();
            $this->sign =$obj->createScanQrcodePay(['subject'=>$data['name'],'body'=>$data['name'],'out_trade_no'=>$order_number,'total_amount'=>$data['price']]);
        }
        $order = ['order_number'=>$order_number,
            'enterprise_id'     =>$this -> user['enterprise_id'],
            'type'              =>$data['type'],
            'type_id'           =>$data['type_id'],
            'name'              =>$data['name'],
            'uid'               =>$this -> user['aid'],
            'price'             =>$data['price'],
            'pay_type'          =>$pay_type,
            'pay_status'        =>1,
            'created_at'        =>$time,
            'updated_at'        =>$time
        ];
        $res = $ordermodel->addData($order);

        return $res;
    }

    public function rechargepay(){
        if(empty($this->param['price'])) return ajax("请输入充值金额",2);
        if(empty($this->param['uid'])) return ajax("没有uid",2);
        $usermodel = new User();
        $userdetailedmodel = new UserDetailed();
        $usermodel->startTrans();
        $time=time();
        $user=$usermodel->getOne(['uid'=>$this->param['uid']]);
        $balance=$user['balance']+$this->param['price'];
        $res=$usermodel->editData(['uid'=>$this->param['uid']],['balance'=>$balance,'updated_at'=>$time]);
        if(!$res){
            $usermodel->rollBack();
            return ajax("充值失败",2);
        }
        $res=$userdetailedmodel->addData(['uid'=>$this->param['uid'],'type'=>2,'title'=>'平台充值','price'=>$this->param['price'],'created_at'=>$time]);
        if(!$res){
            $usermodel->rollBack();
            return ajax("充值失败",2);
        }
        $usermodel->commit();
        $this->AddLog('平台学员充值 学员【'.$this->param['uid']."】 金额：".$this->param['price']);
        return ajax("充值成功",1);
    }
}