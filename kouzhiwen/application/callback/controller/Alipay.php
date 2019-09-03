<?php
/**
 * [支付宝支付回调]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\callback\controller;
use think\Collection;
use think\Config;

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
        $alipaySevice -> writeLog(var_export($arr,true));
        // 验证是否合法
        $result = $alipaySevice -> check($arr);
        // 验证成功
        if ($result) {
            // TODO 自行写支付完成后的处理 - 建议在模型中写公告方法，其他支付方式可直接调用
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
            //如果有做过处理，不执行商户的业务程序
            //注意：
            //付款完成后，支付宝系统发送该交易状态通知

            return "success";
        }
        // 验证失败
        else {

            return "fail";
        }
    }
}