<?php
/**
 * [极光推送]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\common\extend;
use think\Config;
require EXTEND_PATH . 'jpush/autoload.php';

class JGPush{
    // 加载配置项
    public $app_key = '';
    public $master_secret ='';

    public function __construct(){
        $conf = Config::get('jpush');
        $this->app_key=$conf['app_key'];
        $this->master_secret=$conf['master_secret'];
    }


    /**
     * 创建推送
     */
    public function smJumpOne($uid,$msg = null,$is="all",$typemsg = '系统消息'){
        // 初始化
        $client = new \JPush\Client($this->app_key,$this->master_secret);
        $push_payload = $client->push()
            ->options(['apns_production'=>true])
            ->setPlatform('all')
            ->addRegistrationId($uid)
            ->setNotificationAlert($msg)
            ->message($msg, array(
                'title' =>$typemsg,
            ));
        try {
            $push_payload->send();
            $data=[
                'msg'=>"推送成功",
                'code'=>200
            ];
            return $data;
        }catch (\JPush\Exceptions\APIConnectionException $e) {
            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>1002
            ];
            return $data;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>1001
            ];
            return $data;
        }
    }

    /**
     * 创建推送
     * @param array $tag 群组
     * @param string $title 消息标题
     * @param array $data 数据
     */
    public function smJumpall($msg = null,$is="all",$typemsg = '系统消息',$nid){
        // 初始化
        $client = new \JPush\Client($this->app_key,$this->master_secret);
        $push_payload = $client->push()
            ->options(['apns_production'=>true])
            ->addAllAudience('all')
            ->setPlatform($is)
            ->setNotificationAlert($msg)
            ->message($msg, array(
                'title' =>$typemsg,
            ));
        try {
            $push_payload->send();
            $data=[
                'msg'=>"推送成功",
                'code'=>200
            ];
            return $data;
        }catch (\JPush\Exceptions\APIConnectionException $e) {
            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>201
            ];
            return $data;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>201
            ];
            return $data;
        }
    }

    /**
     * 向指定设备推送自定义消息(自定义通知)
     * @param string $targets 收消息用户 all表示所有
     * @param string $title 发送消息标题
     * @param string $message 发送消息内容
     * @param array $regid 特定设备的id
     * @param string $platform 推送平台 android ios all
     * @param string $data 推送平台 自定义数据
     */
    public function sendUrgentNotify($targets,$title, $message, $platform = 'all',$data=[],$time=''){
        $clientobj = new \JPush\Client($this->app_key,$this->master_secret);
        //$push_payload = "";
        if(!is_array($targets)){
            $targets = "".$targets;
        }
        $client= $clientobj->push()
            ->setPlatform($platform);
        if($targets=="all"){
            $client = $client->addAllAudience('all');
        }else{
            $client = $client->addAlias($targets);
        }
        $client=  $client->options(['apns_production'=>false])// IOS推送环境
            ->androidNotification($message, ['title'=>$title,'builder_id' => 1, 'extras' => $data])
            ->iosNotification($message, ['sound' => 'sound.caf', 'badge' => '+1', 'content-available' => true, 'extras' => $data]);
        $push_payload = $client;

        try {
            if(empty($time)){
                $push_payload->send();
            }else{

                $payload=$push_payload->build();
                $clientobj->schedule()->createSingleSchedule($title, $payload, array("time"=>$time));
            }

            $data=[
                'msg'=>"推送成功",
                'code'=>200
            ];
            return $data;
        }catch (\JPush\Exceptions\APIConnectionException $e) {

            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>201
            ];
            return $data;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $msg_ms = $this->getmsgsss( $e->getCode());
            $data=[
                'msg'=>$msg_ms,
                'code'=>201
            ];
            return $data;
        }
    }


    public function getmsgsss($code){
        switch(intval($code))
        {
            case 0:
                $message['msg'] = '消息推送成功';
                break;
            case 10:
                $message['msg'] = '系统内部错误';
                break;
            case 1001:
                $message['msg'] = '只支持 HTTP Post 方法，不支持 Get 方法';
                break;
            case 1002:
                $message['msg'] = '缺少了必须的参数';
                break;
            case 1003:
                $message['msg'] = '参数值不合法';
                break;
            case 1004:
                $message['msg'] = '验证失败';
                break;
            case 1005:
                $message['msg'] = '消息体太大';
                break;
            case 1007:
                $message['msg'] = 'receiver_value 参数 非法';
                break;
            case 1008:
                $message['msg'] = 'appkey参数非法';
                break;
            case 1010:
                $message['msg'] = 'msg_content 不合法';
                break;
            case 1011:
                $message['msg'] = '没有满足条件的推送目标';
                break;
            case 1012:
                $message['msg'] = 'iOS 不支持推送自定义消息。只有 Android 支持推送自定义消息';
                break;
            case 8100:
                $message['msg'] = '定时任务推送失败';
                break;
            default:
                $message['msg'] = '极光推送失败';
                break;
        }

        return $message['msg'];

    }
}