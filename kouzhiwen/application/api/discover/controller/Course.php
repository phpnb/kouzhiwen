<?php
/**
 * [专业知识课]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午3:43
 */


namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\extend\Alipay;
use app\common\extend\Wechat;
use app\common\model\ClassCourse;
use app\common\model\ClassUser;
use app\common\model\Course as model;
use app\common\model\Order;
use app\common\model\User;
use app\common\model\UserDetailed;
use app\common\model\UserRecord;
use app\common\model\Seec;
use app\common\model\CourseType;
use app\common\model\UserCollect;
use app\common\model\Studys;


class Course extends Api{



    /**
     * 直播课列表
     */
    public function zbdatalist(){
//        if(!$this->param['type']) return ajax("缺少课程类型",2);
        $this->param['type'] = 3;
        $CourseModel = new model();
        if($this -> user['enterprise_id'] != $this->param['enterprise_id']){
            $this->param['power']=1;
        }
        $model = $CourseModel->getDataList($this->param);
        $total = $model->count();

        //tp5.0会清空上一次的查询条件
        $model =  $CourseModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 选修课程列表
     */
    public function xxdatalist(){
//        if(!$this->param['type']) return ajax("缺少课程类型",2);
        $this->param['type'] = 2;
        $CourseModel = new model();
        if($this -> user['enterprise_id'] != $this->param['enterprise_id']){
            $this->param['power']=1;
        }
        $model = $CourseModel->getDataList($this->param);
        $total = $model->count();

        //tp5.0会清空上一次的查询条件
        $model =  $CourseModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        foreach ($data['data'] as $k=>$v){
            $collect = $CourseModel->collection(5,$v['id'],$this->user['uid']);
            $data['data'][$k]['collect'] = $collect['collec'];
        }
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 专业课列表
     */
    public function datalist(){
        if(!$this->param['type']) return ajax("缺少课程类型",2);
        $CourseModel = new model();
        if($this -> user['enterprise_id'] != $this->param['enterprise_id']){
            $this->param['power']=1;
        }
        $model = $CourseModel->getDataList($this->param);
        $total = $model->count();

        //tp5.0会清空上一次的查询条件
        $model =  $CourseModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        if($this->param['type'] == 1){
            foreach ($data['data'] as $k=>$v){
                $collect = $CourseModel->collection(5,$v['id'],$this->user['uid']);
                $data['data'][$k]['collect'] = $collect['collec'];
            }
        }

        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 获取所有分类
     * @return \think\response\Json
     */
    public function CourseType(){
        if(!$this->param['enterprise_id']) return ajax("缺少企业参数",2);
        if(!$this->param['type']) return ajax("缺少type",2);
        $CourseModel = new CourseType();
        $data=$CourseModel->getAll(['enterprise_id'=>$this->param['enterprise_id'],'type'=>$this->param['type']]);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 课程详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function CourseDetails(){
        if(!$this->param['id']) return ajax("缺少必要参数",2);
        $CourseModel = new model();
        $ordermodel= new Order();
        $usercollectmodel=new UserCollect();
        $data=$CourseModel->getOne(['id'=>$this->param['id']]);
        $buyOrder = $ordermodel->where(['type'=>2,'uid'=>$this->user['uid'],'type_id'=>$this->param['id'],'pay_status'=>2])->find();
        $where=array('uid'=>$this->user['uid'],'type'=>$data['type'],'type_id'=>$this->param['id']);
        $collect=$usercollectmodel->getOne($where);
        $data['buy']=$buyOrder?true:false;
        $data['collect']=$collect?true:false;
        $data['look_add']=false;
        if($data['price']<=0 || $data['buy']){

            $UserRecordModel  = new UserRecord();
            if(!$UserRecordModel->getOne(['uid'=>$this->user['uid'],'type'=>6,'type_id'=>$this->param['id']])){
                $CourseModel->where(['id'=>$this->param['id']])->setInc('look_num');
                $UserRecordModel->addData(['uid'=>$this->user['uid'],'type'=>6,'type_id'=>$this->param['id'],'created_at'=>time()]);
                $data['look_add']=true;
            }

            $CourseModel->where(['id'=>$this->param['id']])->setInc('reading');
        }elseif($data['price']<=0){

            $UserRecordModel  = new UserRecord();
            if(!$UserRecordModel->getOne(['uid'=>$this->user['uid'],'type'=>7,'type_id'=>$this->param['id']])){
                $CourseModel->where(['id'=>$this->param['id']])->setInc('look_num');
                $UserRecordModel->addData(['uid'=>$this->user['uid'],'type'=>7,'type_id'=>$this->param['id'],'created_at'=>time()]);
                $data['look_add']=true;
            }
        }
        return ajax('获取成功', 1, $data);
    }

    /**
     * 进行中的直播课
     */
//    public function directSeeding(){
//        if(!$this->param['classify_id']) return ajax("缺少平台分类id",2);
//        $this->param['enterprise_id'] = 0;
//        $this->param['type'] = 1;
//
//        $ClassCourseModel = new ClassCourse();
//        $model = $ClassCourseModel->getDataList($this->param);
//        $total = $model->count();
//        //tp5.0会清空上一次的查询条件
//        $model =  $ClassCourseModel->getDataList($this->param);
//        $data  = api_page($model,'','', '',$total);
//        if(!$data['data']) return ajax('已是全部数据', 1, $data);
//        return ajax('获取成功', 1, $data);
//    }

    /**
     * 看过的课程
     */
    public function lookClassCourse(){
//        if(!$this->param['classify_id']) return ajax("缺少平台分类id",2);
//        $this->param['enterprise_id'] = 0;
        $this->param['type'] = 6;
        $this->param['course'] = 2;
        $UserRecordModel  = new UserRecord();
        $model = $UserRecordModel->getDataList($this->param,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $UserRecordModel->getDataList($this->param,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 删除直播可记录
     */
    public function delClassRecord(){
        if(!$this->param['id']) return ajax("缺少记录id",2);
        $UserRecordModel  = new UserRecord();
        $rs = $UserRecordModel->where(['type'=>3,'id'=>$this->param['id'],'uid'=>$this->user['uid']])->delete();
        if(!$rs)return ajax('删除失败', 2);
        return ajax('删除成功', 1);
    }

    /**
     * 直播课详情
     */
    public function classCourseInfo(){
        if(!$this->param['course_id']) return ajax("缺少直播颗id",2);
        $ClassCourseModle = new ClassCourse();
        $studysModel = new Studys();
        $ClassCourseModle->where(['id'=>$this->param['course_id']])->setInc('reading');
        $data = $ClassCourseModle->getDetails($this->param['course_id'],$this->user['uid']);

        $UserRecordModel  = new UserRecord();
        if(!$UserRecordModel->getOne(['uid'=>$this->user['uid'],'type'=>3,'type_id'=>$this->param['course_id']])){
            $UserRecordModel->addData(['uid'=>$this->user['uid'],'type'=>3,'type_id'=>$this->param['course_id'],'created_at'=>time()]);
        }
        $class=$studysModel->getOne(['id'=>$data['class_id']]);
        $data['enterprise_id']=$class['enterprise_id'];
        if(!$data)return  ajax("没有数据",2);
        return  ajax("获取成功",1,$data);
    }

    /**
     * 购买专业课程
     */
//    public function buyCourse(){
//        //create_order_num
//        $param = input('post.');
//        $type=array(1,2,3);
//        if(empty($param['type']) || !in_array($param['type'],$type)) return ajax("支付参数非法",2);
//        if(!$param['course_id']) return ajax("缺少课程id",2);
//        $CourseModel = new model();
//        $one         = $CourseModel->where(['id'=>$param['course_id']])->find();
//        if(!$one) return ajax("课程不存在",2);
//
//        $ordermodel= new Order();
//        //验证用户是否购买过
//        $buyOrder = $ordermodel->where(['type'=>2,'uid'=>$this->user['uid'],'type_id'=>$param['course_id'],'pay_status'=>2])->find();
//        if($buyOrder) return ajax("你已经购买过此课程",2);
//        $usermodel = new User();
//        if($param['type']==3 && $one['price']>$this -> user['balance']) return ajax("余额不足",2);
//        $time=time();
//        $order_number=create_order_num();
//        $pay_status=1; //支付状态 1-未支付 2-已支付
//        $ordermodel->startTrans();
//        $sign = "";//支付返回
//        if($param['type']==3){
//            $userdetailedmodel = new UserDetailed();
//            $balance=$this -> user['balance']-$one['price'];
//            //减去用户余额
//            $res=$usermodel->editData(['uid'=>$this -> user['uid']],['balance'=>$balance,'updated_at'=>$time]);
//            if(!$res){
//                $ordermodel->rollBack();
//                return  ajax("购买失败",2);
//            }
//            //增加余额记录
//            $res=$userdetailedmodel->addData(['uid'=>$this -> user['uid'],'type'=>1,'title'=>$one['title'],'price'=>$one['price'],'created_at'=>$time]);
//            if(!$res){
//                $ordermodel->rollBack();
//                return  ajax("购买失败",2);
//            }
//            $pay_status=2;
//        }else if($param['type']==1){
//            $obj  = new Alipay();
//            $sign = $obj->createAppPay(['subject'=>$one['title'],'out_trade_no'=>$order_number,'total_amount'=>$one['price']]);
//        }else if($param['type']==2){
//            $obj  = new Wechat();
//            $sign = $obj->createAppPay(['subject'=>$one['title'],'body'=>"",'out_trade_no'=>$order_number,'total_amount'=>$one['price']]);
//        }
//
//        $order = ['order_number'=>$order_number,
//            'enterprise_id'     =>$this -> user['enterprise_id'],
//            'type'              =>2,
//            'type_id'           =>$one['id'],
//            'uid'               =>$this -> user['uid'],
//            'price'             =>$one['price'],
//            'pay_type'          =>$param['type'],
//            'pay_status'        =>$pay_status,
//            'created_at'        =>$time,
//            'updated_at'        =>$time
//        ];
//        $res = $ordermodel->addData($order);
//        if(!$res){
//            $ordermodel->rollBack();
//            return  ajax("下单失败",2);
//        }
//        $ordermodel->commit();
//        //数据返回
//        if($param['type']==1){
//            return ajax("下单成功",1,['sign'=>$sign]);
//        }elseif($param['type']==2){
//            return ajax("下单成功",1,$sign);
//        }
//        return  ajax("购买成功",1);
//    }

}