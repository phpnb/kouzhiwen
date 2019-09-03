<?php
/**
 * [微信支付回调处理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\model\Order;
use app\common\model\ClassUser;
use app\common\model\User;
use app\common\model\UserDetailed;
use app\common\model\Enterprise;
use app\common\model\EnterpriseDetailed;
use app\common\extend\Rongcloudapi;
use app\common\model\UserNotice;
use app\common\model\Teacher;
use app\common\model\TeacherDetailed;

ini_set('date.timezone','Asia/Shanghai');
// 载入核心文件
require_once EXTEND_PATH . "wechat/lib/WxPay.Api.php";
require_once EXTEND_PATH . 'wechat/lib/WxPay.Notify.php';
require_once EXTEND_PATH . 'wechat/example/log.php';

//初始化日志
$logHandler= new \CLogFileHandler(RUNTIME_PATH . "pay/wx".date('Y-m-d').'.log');
$log = \Log::Init($logHandler, 15);
\Log::DEBUG("begin notify");
//$xml=file_get_contents("php://input");
//\Log::DEBUG("数据".$xml);

class Wechat extends \WxPayNotify{
    /**
     * 微信支付回调方法
     */
    public function notify(){
        $this -> Handle(false);
    }

    /**
     * 查询订单
     * @param $transaction_id
     * @return bool
     */
    public function Queryorder($transaction_id){
        $input = new \WxPayOrderQuery();
        $input -> SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        \Log::DEBUG("query:" . json_encode($result));

        if(
            array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
        ){
            return true;
        }
        return false;
    }

    /**
     * 重写回调函数
     * @param array $data
     * @param string $msg
     * @return bool
     */
    public function NotifyProcess($data, &$msg){
        \Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        // 处理订单
        return $this -> _disposeOrder($data['out_trade_no'], $data['transaction_id']);
    }

    /**
     * 订单处理
     * @param $out_trade_no 商户订单号
     * @param $trade_no     微信支付交易号
     * @return bool
     */
    private function _disposeOrder($out_trade_no, $trade_no){
        //TODO 自行写支付完成后的处理
        //判断该笔订单是否在商户网站中已经做过处理
        //如果没有做过处理，根据订单号（$out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        // return true OR false
        $Ordermodel =new Order();
        $order=$Ordermodel->getOne(['order_number'=>$out_trade_no]);
        if(empty($order)){
            \Log::DEBUG("没有订单");
            return false;
        }
        if($order['pay_status']==2){
            \Log::DEBUG("订单已支付");
            return true;
        }
        $time=time();
        $Ordermodel->startTrans();
        switch ($order['type']){
            case 1:$res=$this->ClassEnroll($order,$time);break;//班级报名
            case 4:$res=$this->UseRecharge($order,$time);break;//用户充值
            case 5:$res=$this->UserGratuity($order,$time);break;//礼物
            case 6:$res=$this->Advertisements_enroll($order,$time);break;//广告报名
            case 7:$res=$this->teacherConsult($order,$time);break;//在线咨询
            case 8:$res=$this->enterpriseRecharge($order,$time);break;//企业充值
            case 9:$order['uid']=$order['type_id'];$res=$this->UseRecharge($order,$time);break;//学员充值
            default:$res=true;break;
        }

        if(!$res){
            \Log::DEBUG("业务失败");
            $Ordermodel->rollBack();
            return false;
        }

        $res=$Ordermodel->editData(['order_number'=>$order['order_number']],['pay_status'=>2,'updated_at'=>$time]);
        if(!$res){
            \Log::DEBUG("更新订单失败");
            $Ordermodel->rollBack();
            return false;
        }
        $Ordermodel->commit();
        \Log::DEBUG("成功");
        return true;
    }

    /**
     * 在线咨询
     * @param $order
     * @param $time
     * @return bool
     */
    private function teacherConsult($order,$time){
        $teachermodel = new Teacher();
        $TeacherDetailedmodel= new TeacherDetailed();

        $user=$teachermodel->getOne(['id'=>$order['type_id']]);
        $balance=$user['money']+$order['price'];
        $res=$teachermodel->editData(['id'=>$order['type_id']],['money'=>$balance,'updated_at'=>$time]);
        if(!$res){
            return false;
        }
        $res=$TeacherDetailedmodel->addData(['teacher_id'=>$order['type_id'],'type'=>2,'title'=>'学员咨询','price'=>$order['price'],'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }
    /**
     * 广告报名
     * @param $order
     * @param $time
     * @return bool
     */
    private function Advertisements_enroll($order,$time){
        $UserNotice=new UserNotice();
        $content="您报名【".$order['name']."】，期待您下次参与";
        $res=$UserNotice->addData(['uid'=>$order['uid'],'title'=>$order['name'].'报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }

    /**
     * 企业充值
     * @param $order
     * @param $time
     * @return bool
     */
    private function enterpriseRecharge($order,$time){
        $enterprisemodel = new Enterprise();
        $enterprisedetailedmodel = new EnterpriseDetailed();
        $enterprose=$enterprisemodel->getOne(['id'=>$order['type_id']]);
        $balance=$enterprose['balance']+$order['price'];
        $res=$enterprisemodel->editData(['id'=>$order['type_id']],['balance'=>$balance,'updated_at'=>$time]);
        if(!$res){
            return false;
        }
        $res=$enterprisedetailedmodel->addData(['enterprise_id'=>$order['type_id'],'type'=>2,'title'=>$order['name'],'price'=>$order['price'],'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }

    /**
     * 礼物
     * @param $order
     * @param $time
     * @return bool
     */
    private function UserGratuity($order,$time){
        $teachermodel = new Teacher();
        $TeacherDetailedmodel= new TeacherDetailed();

        $user=$teachermodel->getOne(['id'=>$order['type_id']]);
        $balance=$user['money']+$order['price'];
        $res=$teachermodel->editData(['id'=>$order['type_id']],['money'=>$balance,'updated_at'=>$time]);
        if(!$res){
            return false;
        }
        $res=$TeacherDetailedmodel->addData(['teacher_id'=>$order['type_id'],'type'=>2,'title'=>$order['name'],'price'=>$order['price'],'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;

    }

    /**
     * 用户充值
     * @param $order
     * @param $time
     * @return bool
     */
    private function UseRecharge($order,$time){
        $usermodel = new User();
        $userdetailedmodel = new UserDetailed();
        $user=$usermodel->getOne(['uid'=>$order['uid']]);
        $balance=$user['balance']+$order['price'];
        $res=$usermodel->editData(['uid'=>$order['uid']],['balance'=>$balance,'updated_at'=>$time]);
        if(!$res){
            return false;
        }
        $res=$userdetailedmodel->addData(['uid'=>$order['uid'],'type'=>2,'title'=>$order['name'],'price'=>$order['price'],'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }
    /**
     * 班级报名
     * @param $order
     * @param $time
     * @return bool
     */
    private function ClassEnroll($order,$time){
        $classusermodel = new ClassUser();
        $Rongcloud =new Rongcloudapi();
        $Rongcloud->RongCloud->group()->join(["u_".$order['uid']],"c_".$order['type_id'],$order['name']);
        //班级报名
        $data=array('class_id'=>$order['type_id'],'uid'=>$order['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
        $res= $classusermodel->addData($data);
        if(!$res){
            return false;
        }
        $UserNotice=new UserNotice();
        $content="您报名【".$order['name']."】学习班，期待您下次参与";
        $res=$UserNotice->addData(['uid'=>$order['uid'],'title'=>'学习班报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }
}