<?php
/**
 * [微信支付回调处理]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\callback\controller;
ini_set('date.timezone','Asia/Shanghai');
// 载入核心文件
require_once EXTEND_PATH . "wechat/lib/WxPay.Api.php";
require_once EXTEND_PATH . 'wechat/lib/WxPay.Notify.php';
require_once EXTEND_PATH . 'wechat/example/log.php';

//初始化日志
$logHandler= new \CLogFileHandler(RUNTIME_PATH . "wechat/logs/".date('Y-m-d').'.log');
$log = \Log::Init($logHandler, 15);
\Log::DEBUG("begin notify");

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
        file_put_contents(ROOT . '/runtime/callback.php', json_encode($data));
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

        return true;
    }
}