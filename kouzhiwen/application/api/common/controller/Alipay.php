<?php
/**
 * [支付宝支付回调]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\api\common\controller;
use think\Collection;
use think\Config;
use app\common\model\Order;
use app\common\model\ClassUser;
use app\common\model\User;
use app\common\model\UserDetailed;
use app\common\extend\Rongcloudapi;
use app\common\model\Enterprise;
use app\common\model\EnterpriseDetailed;
use app\common\model\UserNotice;
use app\common\model\Teacher;
use app\common\model\TeacherDetailed;


class Alipay extends Collection{
    /**
     * 支付宝支付成功回调
     * @return string
     */
    public function notify(){
        // 载入所需文件
        include_once EXTEND_PATH . 'alipay/pagepay/service/AlipayTradeService.php';
        // 加载配置项
        $conf = Config::get('pay.alipay');

        $alipaySevice = new \AlipayTradeService($conf);
        // 获取回调信息
        $arr = $_REQUEST;
        // 记录日志
        $alipaySevice -> writeLog("所有数据".var_export($arr,true));
        // 验证是否合法
        $result = $alipaySevice -> check($arr);
        // 验证成功

//        if ($result) {
            // TODO 自行写支付完成后的处理 - 建议在模型中写公告方法，其他支付方式可直接调用
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
            //如果有做过处理，不执行商户的业务程序
            //注意：
            //付款完成后，支付宝系统发送该交易状态通知
            $Ordermodel =new Order();
            $order=$Ordermodel->getOne(['order_number'=>$arr['out_trade_no']]);
            if(empty($order)){
                $alipaySevice -> writeLog("返回结果fail--1");
                return "fail";
            }
            if($order['pay_status']==2){
                $alipaySevice -> writeLog("订单已支付");
                return "success";
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
                $Ordermodel->rollBack();
                $alipaySevice -> writeLog("返回结果fail--2");
                return "fail";
            }

            $res=$Ordermodel->editData(['order_number'=>$order['order_number']],['pay_status'=>2,'updated_at'=>$time]);
            if(!$res){
                $Ordermodel->rollBack();
                $alipaySevice -> writeLog("返回结果fail---3");
                return "fail";
            }
            $Ordermodel->commit();
            $alipaySevice -> writeLog("返回结果success");
            return "success";
//        }
//        // 验证失败
//        else {
//            $alipaySevice -> writeLog("验证失败");
//            return "fail";
//        }
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
        $Rongcloud =new Rongcloudapi();
        $Rongcloud->RongCloud->group()->join(["u_".$order['uid']],"c_".$order['type_id'],$order['name']);

        $classusermodel = new ClassUser();
        //班级报名
        $data=array('class_id'=>$order['type_id'],'uid'=>$order['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
        $res=$classusermodel->addData($data);
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