<?php
/**
 * [直播推流回调管理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-05-10 14:43:52
 * @Copyright:
 */
namespace app\api\common\controller;
use app\common\model\Course;
use app\common\model\ClassCourse;
use app\common\extend\Aliyun;

class Pushnotice extends Api{

    /**
     * 直播推流回调
     * @return \think\response\Json
     */
    public function index(){

          $id=explode("_",$this->param['id']);
          $type=$id[1];
          $id=$id[2];
          $Aliyun =new Aliyun();
          $time=time();
          if($type=='a'){
              $scene=$this->param['action']=='publish'?1:2;
              $Course =new Course();
              $aliyun_pulla=$Aliyun->getPullSteam("zb_a_$id",$time);
              $Course->editData(['id'=>$id],['scene'=>$scene,'aliyun_pulla'=>$aliyun_pulla,'updated_at'=>$time]);
          }else if($type=='b'){
              $scene=$this->param['action']=='publish'?2:3;
              $ClassCourse =new ClassCourse();
              $aliyun_pulla=$Aliyun->getPullSteam("zb_b_$id",$time);
              $ClassCourse->editData(['id'=>$id],['status'=>$scene,'aliyun_pulla'=>$aliyun_pulla,'updated_at'=>$time]);
          }

        return ajax('返回成功');
    }

    public function oss(){
        $id=explode("_",$this->param['stream']);
        $type=$id[1];
        $id=$id[2];
        $uri="https://zhibokzw.oss-cn-beijing.aliyuncs.com/".$this->param['uri'];
        $time=time();
        if($type=='a'){
            $url=$uri;
            $Course =new Course();
            $Course->editData(['id'=>$id],['url'=>$url,'scene'=>2,'updated_at'=>$time]);
        }else if($type=='b'){
            $url=json_encode([$uri]);
            $ClassCourse =new ClassCourse();
            $ClassCourse->editData(['id'=>$id],['url'=>$url,'status'=>3,'updated_at'=>$time]);
        }
        return ajax('返回成功');
    }

    private function log($data){
        file_put_contents ( RUNTIME_PATH . "pay/push".date('Y-m-d').'.log', date ( "Y-m-d H:i:s" ) . "  " . $data . "\r\n", FILE_APPEND );
    }


}