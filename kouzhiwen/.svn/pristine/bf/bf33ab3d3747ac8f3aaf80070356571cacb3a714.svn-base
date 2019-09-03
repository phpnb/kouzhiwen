<?php
/**
 * [支付配置项]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Copyright:
 */
return [
    // +----------------------------------------------------------------------
    // | 微信支付参数
    // +----------------------------------------------------------------------
    'wechat'    => [
        // 微信APPID
        'app_id'        => 'wxda77a2764d92388c',
        // 秘钥
        'secret'        => '3e7f0ad20b1d3bce9984068cc34fd191',
        // 微信支付秘钥
        'key'           => 'MfMxoIJYM79fKUl2xQRH1XYQhBi3uLBC',
        // 商户号
        'id'            => '1509132011',
        // 回调地址
        'notify_url'    => 'http://api.kzwchina.com/common/wechat/notify',
        'SSLCERT_PATH'    => '/extra/cert/apiclient_cert.pem',//微信支付设置商户证书路径
        'SSLKEY_PATH'    => '/extra/cert/apiclient_key.pem',//微信支付设置商户证书路径
    ],

    // +----------------------------------------------------------------------
    // | 支付宝支付参数
    // +----------------------------------------------------------------------
    'alipay'    => [
        //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
        'app_id'       => '2018062860465258',

        //商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
        'merchant_private_key'   => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCMLDqGcRIhWC9Ynvsta1QCtbTuS5xfiZfqQK79wNct4qCVSnAZAaKOS9RjpdxP73h+RbtcGZNoxtSpd2b78E9Gr0U7EG8G+ot8dTgwa2PTUyUzjbLg1wYBevtTrLckWc0w9h4tGnDP8r468g52kAfT1pPjDASqiiRCG7NXTZBFcOS06drmE8f6Bo89gDyR+7dsa0hOigo39+EJZl/AeIy72cIpKWqQgXGdHquna/ABbLuuJzK0/5WrqBvJLRwzcML0Fs+sJxe42ti2UCS4/l0CNAb/E65o8Ooa9BxCi+mL/HHygX/Y+Mp6ZXPXgp2IBFZvmZUkw2tIqxc2+bMGsnclAgMBAAECggEALvFw+C1N4RTjZk532BIlpHKuEVAJIoW19qGK+Thn19oZ5WV0fStrATSsAGM/kRWlyMQZpxJ5p5FPDyIJvz4PjqCMEufCBxhJNnkbRDvyxocF4moGCf546G4DVVZ2Txoz+b2zBW/hcALfamY+Kb66oFswU81mkqaI1gro2MgFFPvjXDSoHVKcOSWcqXUTK6ApSSP9LNP5CSnHmn09ZFrX3KjtY/CYGQca7P9eNHpiMwJwz9hAg3IjfMqWp+a2mI37Q+lDLWIowPRElCqTXfRtEwdtBYeBnkUc0l7XfWRfpXLQYN8mwy612P6WObZ5ZgpPnDjYMyco3uuBPVgE4qB0gQKBgQDwZb+xCbKwPXDnmZCz7Bk4SHpQahrN7UclKc2z7q3sc8b2ANH2DP/rF6V7zqJTPllKSrdyETrATgyXFkTaMqJx9o/LqHDnXlq1xgadzgGVPJKhaot4Nq4WPeXEN3jvBwbaP54oKHb9FUvBRoK0gPvz4wVBtaRW7HAOW4YmkEG7yQKBgQCVRToRw27ucvyyPfj/YO900HWVZH25ROs7MZt4zmIFe84wjPRzg9eDNSbxMKIoMyKzkPXKTQ01fStRWTgOgPZlT2btWwkeKwosQ8OhaYUqmF5aF30SKEqhM49HVnitDLLmdRMfTVivxaBDAlF5j5jzqmMZZPU6o++jF1e3QwKWfQKBgQDTgtKcM8oyYny6aVT12R9/c9WadyDKWqCkRBmm3LPOPTerLqGNeXaaJB4HxpDv6QWq5f5tsFce6A0PyhoeWTqwRp3SNIvSJiRtlqQvqBegdMEWoKXByWp2S1OjxqLyvB39XMgM0T2QA3K5xQ4vPuVveikf3W+Qw0r8du6bc4VCcQKBgEHMj0lvRcIUq/GCQfWI7GUo0vw0nPsDN1ITjv4Us77JEV3zdHpLHr/2uSDOmFxyFhTjjIVNq8ntUB/+3Sf/jx2ff7aXT5Cd1lEm2eCYHBxnqAe8nORZIHSovrrqki1uEJpn9zLwLGznB7siFXopY3ndnOt/xl3AEA1rZ74f6s8dAoGBAJKDr7ge3TmDu5EP8ync/WnIPXJ8Bjkjwm/r3VnGpXyF95E7ZZlhr0sq8rrNs/4Ilk7t5cfxT0futedrkOZZJlyfAK0IEVbJKyfYfm994hi/fH/JKExy4mff57MJRYBD4lXn65psf0HpGrZ8swvk0HU1dmzfwLZ2AskqKwWXhKF2',

        //支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm
        'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmRfmCGnRsjV2RpohZ8SKOQMQwUShc8iYKgYoaHR7LHIJ8TMyc3dFHk1BxnMPJzxs5iIYzau3HR61NTc4oWwgtHDIeHZgKo+3UMUU3GGS0noSDPtIDw8TK47jqSEQJwsDkRgvUFTGtjucrCG1Cv3TVWRJV+GWu1B9X5iXCyxVOwYQjWgjaeSxWgFT/6Gp/ctrEiMZyGblECwyO4e7gg4Hmv0nmtwy6mIerlX/CDavnHCoP+u3saYFrjjqe6PCNdU/F6FY11bErUl7PNDuEbW47XoI10Qgt8IUn4TEnXkbKokaIy9xM3Oq5h03MkCXzHdHFVxRF79WzfZaFgzQCr7ZEwIDAQAB',

        // 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        'notify_url'    => 'http://api.kzwchina.com/common/alipay/notify',
        // // 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        'return_url'    => 'http://api.kzwchina.com/common/alipay/notify',

        // 签名方式
        'sign_type'     => 'RSA2',

        // 支付宝网关
        'gatewayUrl'    => 'https://openapi.alipay.com/gateway.do',

        //字符编码格式 目前支持 gbk 或 utf-8
        'charset' => 'UTF-8',

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport'     => 'http',
        // 支付类型 ，无需修改
        'payment_type'  => 1,
        // 产品类型，无需修改
        'service'       => 'create_direct_pay_by_user'
    ]
];
