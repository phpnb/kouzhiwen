<?php
/**
 * 融云
 * User: lzj
 * Date: 2018-08-08
 * Time: 16:27
 */

namespace app\common\extend;
use think\Config;

class  Rongcloudapi{

    public $RongCloud="";

    public function __construct(){
        include_once EXTEND_PATH .'rongcloud/rongcloud.php';

        // 加载配置项
        $conf = Config::get('note.rongcloud');
        $appKey =$conf['app_key'];
        $appSecret = $conf['app_secret'];
        $this->RongCloud = new \RongCloud($appKey,$appSecret);
    }
}