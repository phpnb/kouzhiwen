<?php
/**
 * 阿里云直播
 * User: lzj
 * Date: 2018-08-27
 * Time: 17:24
 */

namespace app\common\extend;

class Aliyun
{
    private $accessKeyId = "";          //密钥ID
    private $accessKeySecret = "";      //密钥
    public  $version = "2014-11-11";    //API版本号
    public  $format = "JSON";           //返回值类型
    private $domainParameters = "";
    public  $video_host='';                //推流域名
    public  $appName="kzw";            //应用名
    public  $privateKey="";             //鉴权
    public  $pulla_privateKey="";             //播流鉴权
    public  $vhost="";                  //加速域名
    public  $time="";                  //直播时间
    public  $msg;

    public function __construct()
    {
        $config=config('aliyun_oss');
        $aliyun_zb=config('aliyun_zb');
        $this->accessKeyId=$config['accessKeyId'];
        $this->accessKeySecret=$config['accessKeySecret'];
        $this->privateKey=$aliyun_zb['privateKey'];
        $this->pulla_privateKey=$aliyun_zb['pulla_privateKey'];
        $this->version=date("Y-m-d");
        $this->appName=$aliyun_zb['appName'];
        $this->video_host=$aliyun_zb['video_host'];
        $this->vhost=$aliyun_zb['vhost'];
        $this->time=$aliyun_zb['time'];
    }

    /**
     * 访问阿ali接口进行请求并返回ali返回值
     * @param array $apiParams 接口自定义参数
     * @param string $credential 传值方式默认get
     * @param string $domain 请求地址
     */
    public function aliApi($apiParams,$credential="GET", $domain="cdn.aliyuncs.com")
    {
        date_default_timezone_set("GMT");
        $apiParams['Format'] = $this->format;
        $apiParams['SignatureMethod'] = "HMAC-SHA1";//签名算法
        $apiParams['SignatureNonce'] = rand(100000,999999);//随机数
        $apiParams['SignatureVersion'] = '1.0';//签名算法版本
        $apiParams['TimeStamp'] =date('Y-m-d\TH:i:s\Z');//请求时间
        $apiParams['Version'] = $this->version;
        $apiParams["AccessKeyId"]=$this->accessKeyId;
        $accessSecret = $this->accessKeySecret;
        $apiParams["Signature"] = $this->computeSignature($credential,$apiParams,$accessSecret);
        if($credential == "POST") {
            $requestUrl = "https://". $domain . "/";
            foreach ($apiParams as $apiParamKey => $apiParamValue)
            {
                $this->putDomainParameters($apiParamKey,$apiParamValue);
            }
            $url= $requestUrl;
        }
        else {
            $requestUrl = "http://". $domain . "/?";

            foreach ($apiParams as $apiParamKey => $apiParamValue)
            {
                $requestUrl .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
            }
            $url= substr($requestUrl, 0, -1);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); //处理http证书问题
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        if (false === $ret) {
            $ret =  curl_errno($ch);
            $this->message = 'curl方法出错，错误号：'.$ret;
            return false;
        }
        curl_close($ch);
        if( $this->format == "JSON")
            return json_decode($ret,true);
        elseif($this->format =="XML"){
            return $this->xmlToArray($ret);
        }else
            return $ret;
    }

    /**
     * 计算签名
     * @param $credential
     * @param $parameters
     * @param $accessKeySecret
     * @return string
     */
    private function computeSignature($credential,$parameters, $accessKeySecret)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach($parameters as $key => $value)
        {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
        }
        $stringToSign = $credential.'&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
        $signature = $this->signString($stringToSign, $accessKeySecret."&");

        return $signature;
    }

    /**
     * url编码
     * @param $str
     * @return mixed|string
     */
    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    /**
     * get请求时无用没看
     * @param $name
     * @param $value
     */
    public function putDomainParameters($name, $value)
    {
        $this->domainParameters[$name] = $value;
    }

    /**
     * 对待加密字符串加密
     * @param $source
     * @param $accessSecret
     * @return string
     */
    public function signString($source, $accessSecret)
    {
        return	base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
    }

    /**
     * xml转成数组
     * @param $xml
     * @return mixed
     */
    function xmlToArray($xml){

        //禁止引用外部xml实体

        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring),true);

        return $val;

    }

    /**
     * 生成推流地址
     * @param $streamName 用户专有名
     * @param $vhost 加速域名
     * @param $time 有效时间单位秒
     */
    public function getPushSteam($streamName,$time,$vhost='')
    {
        $time = $this->time + $time;
        $videohost = $this->video_host;
        $appName = $this->appName;
        $privateKey = $this->privateKey;
        $vhost=empty($vhost)?$this->vhost:$vhost;
        if ($privateKey) {
            $auth_key = md5('/' . $appName . '/' . $streamName . '-' . $time . '-0-0-' . $privateKey);
            $url = $videohost . '/' . $appName . '/' . $streamName . '?auth_key=' . $time . '-0-0-' . $auth_key;
        } else {
            $url = $videohost . '/' . $appName . '/' . $streamName . '?vhost=' . $vhost;
        }
        return $url;

    }

    /**
     * 生成拉流地址
     * @param $streamName 用户专有名
     * @param $vhost 加速域名
     * @param $type 视频格式 支持rtmp、flv、m3u8三种格式
     */
    public function getPullSteam($streamName,$time,$vhost='',$type='rtmp'){
        $time = $this->time+$time;
        $appName=$this->appName;
        $privateKey=$this->pulla_privateKey;
        $vhost=empty($vhost)?$this->vhost:$vhost;
        $url='';
        switch ($type){
            case 'rtmp':
                $host = 'rtmp://'.$vhost;
                $url = '/'.$appName.'/'.$streamName;
                break;
            case 'flv':
                $host = 'http://'.$vhost;
                $url = '/'.$appName.'/'.$streamName.'.flv';
                break;
            case 'm3u8':
                $host = 'http://'.$vhost;
                $url = '/'.$appName.'/'.$streamName.'.m3u8';
                break;
        }
        if($privateKey){
            $auth_key =md5($url.'-'.$time.'-0-0-'.$privateKey);
            $url = $host.$url.'?auth_key='.$time.'-0-0-'.$auth_key;
        }else{
            $url = $host.$url;
        }
        return $url;
    }

}