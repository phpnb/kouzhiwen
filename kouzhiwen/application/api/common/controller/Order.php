<?php
/**
 * [订单口管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\model\Order as model;
use app\common\model\Studys;
use app\common\model\ClassUser;
use app\common\model\Course;
use app\common\model\ClassNotice;
use app\common\model\Advertisements;
use app\common\model\User;
use app\common\model\UserDetailed;
use app\common\model\Teacher;
use app\common\model\TeacherDetailed;
use app\common\extend\Alipay;
use app\common\extend\Wechat;
use app\common\extend\Rongcloudapi;
use app\common\model\UserNotice;
use app\admin\root\model\Aduser;

class Order extends Api{

    public $msg="";
    public $data="";
    public $res=true;

    /**
     * 创建订单
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function Order(){
        if (!$this -> isPost) return ajax('非法请求', 2);
        $id=input('id');
        $OS = $_SERVER['HTTP_OS'];
        $version= $_SERVER['HTTP_VERSION'];
        $type=input('type');

        if (!$id  || !$type) return ajax('请传id与type', 2);
        switch ($type){
            case 1:$this->Class_enroll($id,1,$OS,$version);break;//班级报名
            case 2:$this->Course_enroll($id,2,$OS,$version);break;//专业课
            case 3:$this->Notice_enroll($id,3,$OS,$version);break;//班级通知
            case 6:$this->Advertisements_enroll($id,6,$OS,$version);break;//广告报名
            case 7:$this->TeacherConsult($id,7,$OS,$version);break;//老师咨询
        }

        if(!$this->res){
            return ajax($this->msg, 2);
        }

        return ajax($this->msg, 1,$this->data);
    }

    /**
     * 订单支付
     * @return \think\response\Json
     * @throws \think\exception\PDOException
     */
    public function OrderPay(){
        //如果不是post非法请求
        if (!$this -> isPost) return ajax('非法请求', 2);
        //如果没有传订单号和类型请求失败
        if (!$this->param['order_number']  || !$this->param['type']) return ajax('请传order_number与type', 2);
        //order实例化
        $Ordermodel=new model();
//        通过订单号查一条数据
        $order=$Ordermodel->getOne(['order_number'=>$this->param['order_number']]);
        //如果订单号空，没有次订单号
        if(empty($order)){
            return ajax('没有此订单', 2);
        }
        //如果pay_status=2,已经支付
        if($order['pay_status']==2){
            return ajax('此订单已支付', 2);
        }
//        创建数组$pay_type
        $pay_type=array(1,2,3);
        //如果参数type是空或者数组里没有这个参数值,非法请求
        if(empty($this->param['type']) || !in_array($this->param['type'],$pay_type)){
            return ajax('非法请求', 2);
        }
        //时间
        $time=time();
        //启动事务
        $Ordermodel->startTrans();
        //支付方式等于传递得参数
        $update=['pay_type'=>$this->param['type'],'updated_at'=>$time];
        //创建$data数组
        $data=array();
        //余额支付
        if($this->param['type']==3){
            //user实例化
            $usermodel = new User();
            //用户消费明细实例化
            $userdetailedmodel = new UserDetailed();
            //班级群实例化
            $classusermodel = new ClassUser();
            //如果订单号得金额大于余额,余额不足
            if($order['price']>$this -> user['balance']){
                return ajax('余额不足', 3);
            }
            //用户余额减去订单金额
            $balance=$this -> user['balance']-$order['price'];
            //返回给用户金额
            $data['balance']=$balance;
            //并写进数据库
            $res=$usermodel->editData(['uid'=>$this -> user['uid']],['balance'=>$balance,'updated_at'=>$time]);
            //如果失败,支付失败
            if(!$res){
                $Ordermodel->rollBack();
                return ajax('支付失败', 2);
            }
            //写进用户明细表
            $res=$userdetailedmodel->addData(['uid'=>$this -> user['uid'],'type'=>1,'title'=>$order['name'],'price'=>$order['price'],'created_at'=>$time]);
            //如果失败,支付失败
            if(!$res){
                $Ordermodel->rollBack();
                return ajax('支付失败', 2);
            }


            //type=1,班级报名
            if($order['type']==1){
                //取得数据
                $data=array('class_id'=>$order['type_id'],'uid'=>$this -> user['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
                //写进群组表
                $res=$classusermodel->addData($data);
                //如果失败,支付失败
                if(!$res){
                    $Ordermodel->rollBack();
                    return ajax('支付失败', 2);
                }
                //通知表实例化
                $UserNotice=new UserNotice();
                //组合数据
                $content="您报名【".$order['name']."】学习班，期待您下次参与";
                //写进通知表
                $res=$UserNotice->addData(['uid'=>$this -> user['uid'],'title'=>'学习班报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);
                //如果失败,支付失败
                if(!$res){
                    $Ordermodel->rollBack();
                    return ajax('支付失败', 2);
                }

            }


            //广告报名
            elseif($order['type']==6){
                //通知表实例化
                $UserNotice=new UserNotice();
                //组合信息
                $content="您报名【".$order['name']."】，期待您下次参与";
                //写进数据表
                $res=$UserNotice->addData(['uid'=>$this -> user['uid'],'title'=>$order['name'].'报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);
                //如果失败,支付失败
                if(!$res){
                    $Ordermodel->rollBack();
                    return ajax('支付失败', 2);
                }
            }


            //在线咨询
            elseif ($order['type']==7){
                //讲师表实例化
                $Teacher=new Teacher();
                //讲师明细实例化
                $TeacherDetailed=new TeacherDetailed();
                //找到当前讲师得金额更新成订单金额
                $res=$Teacher->where(['id'=>$order['type_id']])->setInc('money',$order['price']);
                //失败
                if(!$res){
                    $Ordermodel->rollBack();
                    return ajax('支付失败', 2);
                }
//                写进讲师明细表
                $res=$TeacherDetailed->addData(['teacher_id'=>$order['type_id'],'type'=>2,'title'=>'学员咨询','price'=>$data['price'],'created_at'=>time()]);
                //失败
                if(!$res){
                    $Ordermodel->rollBack();
                    return ajax('支付失败', 2);
                }
            }

            //$update的支付状态是已支付
            $update['pay_status']=2;
        }
        //微信支付
        else if ($this->param['type']==2){
            $obj = new Wechat;
            $data=$obj->createAppPay(['subject'=>$order['name'],'body'=>$order['name'],'out_trade_no'=>$order['order_number'],'total_amount'=>$order['price']]);
        }
        //支付宝支付
        else if($this->param['type']==1){
            $obj = new Alipay;
            $data=$obj->createAppPay(['subject'=>$order['name'],'out_trade_no'=>$order['order_number'],'total_amount'=>$order['price']]);
        }
        //根据订单号修改支付状态
        $res=$Ordermodel->editData(['order_number'=>$order['order_number']],$update);
        //失败
        if(!$res){
            $Ordermodel->rollBack();
            return ajax('支付失败', 2);
        }
        //如果是余额支付并且是学习班
        if($this->param['type']==3 && $order['type']==1){
//            实例化融云
            $Rongcloud =new Rongcloudapi();
            //加入群组
            $Rongcloud->RongCloud->group()->join(["u_".$order['uid']],"c_".$order['type_id'],$order['name']);
        }
        //事务提交
        $Ordermodel->commit();
        return ajax('支付成功', 1,$data);
    }

    /**
     * 老师咨询
     * @param $id
     * @param $type
     * @return string
     */
    private function TeacherConsult($id,$type,$OS,$version){
        $Teacher=new Teacher();
        $data=$Teacher->getOne(['id'=>$id]);

        if($OS == 'iOS' || $version == '1.0'){
            return $this->msg="创建订单失败";
        }

        if($data['price']<=0){
            $this->res=false;
            return $this->msg="金额必须大于零";
        }
        $data['name']=$data['nickname'];
        $res=$this->AddOrder($data,$type,$this->param['enterprise_id']);
        if(!$res){
            $this->res=false;
            return $this->msg="创建订单失败";
        }
        return $this->msg="创建订单成功";
    }

    /**
     * 广告报名
     * @param $id
     * @param $type
     * @return string
     */
    private function Advertisements_enroll($id,$type,$OS,$version){
        $Advertisements=new Advertisements();
        $Order=new model();
        $cy = new Aduser();
        $res=$Order->getOne(['type'=>$type,'type_id'=>$id,'uid'=>$this->user['uid'],'pay_status'=>2]);
        if($res){
            $this->res=false;
            return $this->msg="已报名，不能在报名'";
        }
        $data=$Advertisements->getOne(['id'=>$this->param['id']]);
        $data['name']=$data['title'];


        if($OS == 'iOS' || $version == '1.0' || $data['price']>0){
            $res=$this->AddOrder($data,6,$this->param['enterprise_id'],4);

            $this->msg="报名成功";
            $time=time();
            $UserNotice=new UserNotice();
            $aduser = new Aduser();
            $uid = $this->user['uid'];
            $aduser->addData(['userid'=> $uid , 'adid'=> $id]);
            $content="您报名【".$this->data['order']['name']."】，期待您下次参与";
            $UserNotice->addData(['uid'=>$this -> user['uid'],'title'=>$this->data['order']['name'].'报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);

        }


        if($data['price']<=0){

            $res=$this->AddOrder($data,6,$this->param['enterprise_id'],4);

            $this->msg="报名成功";
            $time=time();
            $UserNotice=new UserNotice();
            $aduser = new Aduser();
            $uid = $this->user['uid'];
            $aduser->addData(['userid'=> $uid , 'adid'=> $id]);
            $content="您报名【".$this->data['order']['name']."】，期待您下次参与";
            $UserNotice->addData(['uid'=>$this -> user['uid'],'title'=>$this->data['order']['name'].'报名通知','content'=>$content,'reading'=>0,'created_at'=>$time]);




        }else{
            $res=$this->AddOrder($data,6,$this->param['enterprise_id']);
            $this->msg="创建订单成功";
        }

        if(!$res){
            $this->res=false;
            return $this->msg="创建订单失败";
        }
        return $this->msg;
    }

    /**
     * 班级通知报名
     * @return \think\response\Json
     * @throws \think\exception\PDOException
     */
    private function Notice_enroll($id,$type,$OS,$version){
        $ordermodel=new model();
        $classnoticemodel=new ClassNotice();
        $res=$ordermodel->getOne(['type'=>$type,'type_id'=>$id,'uid'=>$this -> user['uid'],'pay_status'=>2]);
        if($res){
            $this->res=false;
            return $this->msg="以报名";
        }
        $notice=$classnoticemodel->getOne(['id'=>$id]);


        if($notice['price']<=0){
            $this->res=false;
            return $this->msg="金额必须大于零";
        }
        if($OS == 'iOS' || $version == '1.0'){
            $pay=false;
            return $this->msg="创建订单失败";
        }

        $res=$this->AddOrder(['id'=>$notice['id'],'price'=>$notice['price'],'name'=>$notice['title']],3,$this->param['enterprise_id']);
        if(!$res){
            $this->res=false;
            return $this->msg="创建订单失败";
        }
        return $this->msg="创建订单成功";

    }

    /**
     * 购买专业课程
     * @param $id
     * @param $type
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function Course_enroll($id,$type,$OS,$version){
        $CourseModel = new Course();
        $ordermodel= new model();
        $one = $CourseModel->where(['id'=>$id])->find();
        if(!$one){
            $this->res=false;
            return $this->msg="课程不存在";
        }
        if(!isset($this->param['enterprise_id'])){
            $this->res=false;
            return $this->msg="请上传企业id";
        }
        if($one['price']<=0){
            $this->res=false;
            return $this->msg="金额必须大于零";
        }
        if($OS == 'iOS' || $version == '1.0'){
            return $this->msg="创建订单失败";
        }
        //验证用户是否购买过
        $buyOrder = $ordermodel->where(['type'=>2,'uid'=>$this->user['uid'],'type_id'=>$id,'pay_status'=>2])->find();
        if($buyOrder){
            $this->res=false;
            return $this->msg="你已经购买过此课程";
        }
        $one['name']=$one['title'];
        $res=$this->AddOrder($one,$type,$this->param['enterprise_id']);
        if(!$res){
            $this->res=false;
            return $this->msg="创建订单失败";
        }
        return $this->msg="创建订单成功";
    }

    /**
     * 班级报名
     * @param $id
     * @param $type
     * @return string
     */
    private function Class_enroll($id,$type,$OS,$version){
        if($this->user['allot']!=2){
            $msg=$this->user['allot']==1?"因你还未通过后台的审核；所以不能向报名":"因你没有通过后台的审核；所以不能报名";
            return ajax($msg, 2);
        }
        $StudysModel = new Studys();
        $classusermodel = new ClassUser();
        $studys=$StudysModel->getOne(['id'=>$id]);
        $user=$classusermodel->getOne(['class_id'=>$id,'uid'=>$this -> user['uid']]);

        if($user){
            $this->res=false;
            return $this->msg="此班级你已报名";
        }

        $count=$classusermodel->where(['class_id'=>$id])->count();
        if($studys['number']<=$count){
            $this->res=false;
            return $this->msg="班级报名人数以满";
        }

        if(!isset($this->param['enterprise_id'])){
            $this->res=false;
            return $this->msg="请上传企业id";
        }
        if($OS == 'iOS' || $version == '1.0'){
            $time=time();
            $data=array('class_id'=>$id,'uid'=>$this -> user['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
            $res=$classusermodel->addData($data);
            $Rongcloud =new Rongcloudapi();
            $Rongcloud->RongCloud->group()->join(["u_".$data['uid']],"c_".$data['class_id'],$data['class_id']);
            if(!$res){
                $this->res=false;
                return $this->msg="报名失败";
            }
            return $this->msg="报名成功";
        }
        if($studys['price']>0){
            $res=$this->AddOrder($studys,$type,$this->param['enterprise_id']);
            if(!$res){
                $this->res=false;
                return $this->msg="创建订单失败";
            }
            return $this->msg="创建订单成功";
        }

        $time=time();
        $data=array('class_id'=>$id,'uid'=>$this -> user['uid'],'status'=>1,'created_at'=>$time,'updated_at'=>$time);
        $res=$classusermodel->addData($data);
        $Rongcloud =new Rongcloudapi();
        $Rongcloud->RongCloud->group()->join(["u_".$data['uid']],"c_".$data['class_id'],$data['class_id']);
        if(!$res){
            $this->res=false;
            return $this->msg="报名失败";
        }
        return $this->msg="报名成功";
    }

    /**
     * 添加订单
     * @param $data 订单数据
     * @param $type //订单类型
     * @param $enterprise_id //企业id
     * @return bool
     */
    private function AddOrder($data,$type,$enterprise_id,$pay_type=1){

        $model=new model();
        $time=time();
        $order_number=create_order_num();
        if(!isset($enterprise_id)){
            $enterprise_id=$this -> user['enterprise_id'];
        }
        $pay_status=1;
        if($pay_type==4)$pay_status=2;

        $this->data['order']=[
            'order_number'=>$order_number,
            'enterprise_id'=>$enterprise_id,
            'type'=>$type,
            'type_id'=>$data['id'],
            'uid'=>$this -> user['uid'],
            'price'=>$data['price'],
            'name'=>$data['name'],
            'pay_type'=>$pay_type,
            'pay_status'=>$pay_status,
            'created_at'=>$time,
            'updated_at'=>$time];
        $res=$model->addData($this->data['order']);
        if(!$res){
            return false;
        }
        return true;
    }

}