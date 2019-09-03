<?php
/**
 * [公共函数]
 * @Author: Careless
 * @Date:   2016-06-28 10:45:16
 * @Email:  965994533@qq.com
 * @Copyright:
 */
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
/**
 * [打印输出数据]
 * @param void $var
 */
function p($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;'>" . print_r($var, true) . "</pre>";
    }
}

/**
 * 创建密码
 * @param $pwd
 * @return string
 */
function create_pwd($pwd)
{
    return md5(md5($pwd) . sha1('my-ioc-!@#$%^&*()'));
}

/**
 * [ajax 返回ajax数据]
 */
function ajax($msg = '', $status = 1, $data = null, $time = 1)
{
    return json([
        'status' => $status,
        'msg' => $msg,
        'data' => $data?$data:[],
        'time' => $time * 1000
    ]);
}

/**
 * [admin_page 后台分页]
 */
function admin_page($model, $where = '', $orderby = '', $field = '', $size = 10)
{
    // 获取数据
    $data = $model->field($field)->where($where)->order($orderby)->paginate($size);
    // 获取分页显示
    $page = $data->render();
    $tmp = $data -> toArray();
    return [
        'data' => $tmp['data'],
        'page' => $page
    ];
}

/**
 * [api_page api分页]
 */
function api_page($model, $where = '', $orderby = '', $field = '',$total="")
{
    $data = input();
    // 分页信息
    $page = !empty($data['page']) ? $data['page'] : 1;
    $pageSize = !empty($data['page_size']) ? $data['page_size'] : 10;
    // 起始数据
    $ofset = ($page - 1) * $pageSize;
    $limit = $ofset . ',' . $pageSize;
    // 获取总数
    if($total===""){
        $total = $model->where($where)->count();
    }
    // 获取数据
    if($field != ''){
        $model = $model->field($field);
    }
    if($where != ''){
        $model = $model->where($where);
    }
    if($orderby != ''){
        $model = $model->order($orderby);
    }
    $data = $model->limit($limit)->select()->toArray();


    // 组合返回数据
    $return = [
        'total' => $total,
        'page' => $page,
        'page_size' => $pageSize,
        'all_page' => ceil($total / $pageSize),
        'data' => $data,
    ];
    return $return;
}

/**
 * [underline_to_hump 将下划线命名转换为驼峰式命名]
 * @param  string $str [要转换的字符串]
 * @param  boolean $ucfirst [首字母是否大写]
 */
function underline_to_hump($str = '', $ucfirst = true)
{
    $str = ucwords(str_replace('_', ' ', $str));
    $str = str_replace(' ', '', lcfirst($str));
    return $ucfirst ? ucfirst($str) : $str;
}

/**
 * [hump_to_underline 将驼峰命名转换为下划线命名]
 * @param  string $str [要转换的字符串]
 */
function hump_to_underline($str = '')
{
    $new = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str));
    return $new;
}

/**
 * [write_file 文件缓存]
 */
function write_file($name, $data = '')
{
    // 检测名称是否存在
    if (empty($name)) return false;
    // 文件路径
    $file = RUNTIME_PATH . 'cache/' . $name . '.php';
    $dir = dirname($file);

    // 设置缓存
    if ($data) {
        // 创建目录
        is_dir($dir) || mkdir($dir, 0777, true);
        file_put_contents($file, json_encode($data));
        return true;
    }

    // 读取缓存
    if ($data === '') {
        if (!is_file($file)) return false;
        $res = json_decode(file_get_contents($file), true);
        return $res;
    }

    // 删除缓存
    if ($data === NULL) {
        @unlink($file);
        return true;
    }
}

/**
 * [get_ip 获取IP地址]
 */
function get_ip()
{
    static $realip;
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

/**
 * [create_order_num 创建唯一订单号]
 * @return [string]
 */
function create_order_num()
{
    // 截取当前微秒数的后6位
    $num = substr(uniqid(), 7, 13);
    // 将截取的微秒数分割为数组
    $numArr = str_split($num);
    // 用ord获取ASCII码，避免字母的出现
    $numArr = array_map('ord', $numArr);
    // 组合为字符串 规范长度
    $str = substr(implode('', $numArr), 0, 8);
    // 生成随机数
    $rand = '';
    for ($i = 0; $i < 5; $i++) {
        $rand .= mt_rand(0, 9);
    }
    // 组合订单号
    return date('Y') . $str . $rand;
}

/**
 * 获取一段时间内的周
 * @param $s 开始时间
 * @param $e 结束时间
 * @param $m_or_w 类型 week 周 | month 月
 * @return array
 */
function get_week_arr($s, $e, $m_or_w = 'week')
{
    $arr = array();
//    $start=strtotime($s." 00:00:00");
//    $end=strtotime($e." 23:59:59");
    $start = $s;
    $end = $e;
    if ($m_or_w == 'week') {
        $s_w = date('w', $start);
        $f_w = 8 - $s_w;
    } else {
        $allday = date('t', $start);
        $today = date('d', $start);
        $f_w = $allday - $today + 1;
    }
    if ($f_w) {
        $f_end = $start + 86400 * $f_w - 1;
    } else {
        $f_end = $start + 86400 - 1;
    }
    $new_end = $f_end;
    if ($end < $new_end) {
        $arr[] = array($start, $end);
        return $arr;
    }
    while ($end > $new_end) {
        $arr[] = array($start, $new_end);
        $start = $new_end + 1;
        if ($m_or_w == 'week') {
            $day = 7;
        } else {
            $day = date('t', $new_end + 10);
        }
        $new_end = $new_end + $day * 86400;
    }
    if ($m_or_w == 'week') {
        $fullday = 7;
    } else {
        $fullday = date('t', $new_end);
    }
    $arr[] = array($new_end - $fullday * 86400 + 1, $end);
    return $arr;
}

/**
 * [sql_keyupdate_one 有则修改，无则添加 sql 语句（一条）]
 */
function sql_keyupdate_one($data, $table)
{
    // 组合sql语句
    $sql = 'INSERT INTO `' . $table . '` (';
    $b = '';
    $insert = '';
    $values = '';
    $update = '';
    foreach ($data as $k => $v) {
        $insert .= $b . '`' . $k . '` ';
        $values .= $b . '"' . $v . '"';
        $update .= $b . '`' . $k . '`="' . $v . '"';
        $b = ',';
    }
    $sql .= $insert . ') VALUES (' . $values . ') ON DUPLICATE KEY UPDATE ' . $update;
    return $sql;
}

/**
 * 格式化日期
 * @param $time
 * @return string
 */
function format_date($time)
{
    $t = time() - $time;
    $f = array(
        '31536000' => '年',
        '2592000' => '个月',
        '604800' => '星期',
        '86400' => '天',
        '3600' => '小时',
        '60' => '分钟',
        '1' => '秒'
    );
    foreach ($f as $k => $v) {
        if (0 != $c = floor($t / (int)$k)) {
            return $c . $v . '前';
        }
    }
}

/**
 * [qrcode 生成二维码]
 * @param    string  $value                   [二维码内容]
 * @param    string  $name                    [保存名称]
 * @param    integer $size                    [大小]
 * @param    string  $errorCorrectionLevel    [容错级别 [L M Q H][]]
 * @param    string  $margin                  [边距]
 */
function qrcode($value = '', $name = '', $size = 10, $errorCorrectionLevel = 'L', $margin= '1') {
    // 载入核心文件
    require_once EXTEND_PATH . 'qrcode/phpqrcode.php';
    // 名称为空时 直接输出二维码
    if (empty($name)) {
        //生成二维码图片
        QRcode::png($value);
//        \QRcode::png($value, false, $errorCorrectionLevel, $size, $margin);
    }
    // 保存二维码为图片
    else {
        $path = ROOT_PATH . 'public' . DS . 'uploads/qrcode/' . date('Ymd') . '/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        \QRcode::png($value, $path . $name, $errorCorrectionLevel, $size, $margin);
        return $path . $name;
    }
}

/**
 * curl 请求
 */
function curl($url, $data = [], $metnod = 'get', $headers = []){
    // 初始化curl
    $ch = curl_init();
    // 设置请求地址
    curl_setopt($ch, CURLOPT_URL, $url);
    // 返回的数据自动显示
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($metnod == 'post') {
        // 请求方式为POST
        curl_setopt($ch, CURLOPT_POST, 1);
        // POST数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }

    if (!empty($headers)) {
        // header头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    // 抓取跳转后的页面
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    // 执行请求
    $return = curl_exec($ch);
    // 关闭curl资源
    curl_close($ch);
    // 返回数据
    return json_decode($return, true);
}

/**
 * 创建时间区间数组
 * @param string $hisStart
 * @param string $hisEnd
 * @param int $range
 * @return array
 */
function create_his_range($hisStart = '00:00:00', $hisEnd = '23:59:59', $range = 3600){
    return array_map(function ($time) {
        return date('H:00:00', $time);
    }, range(strtotime($hisStart), strtotime($hisEnd), $range));
}

/**
 * 创建日期区间数组
 * @param $ymdStart
 * @param bool $ymdEnd
 * @param int $range
 * @return array
 */
function create_ymd_range($ymdStart, $ymdEnd = true, $range = 86400){
    if ($ymdEnd === true) $ymdEnd = date('Y-m-d');

    return array_map(function ($time) {
        return date('m-d', $time);
    }, range(strtotime($ymdStart), strtotime($ymdEnd), $range));
}

/**
 * 写入日志
 * @param string $word
 * @param string $name
 */
function write_log($word = '', $name = 'log.txt') {
    $fname = RUNTIME_PATH . $name;
    if (!is_dir(dirname($fname))) mkdir(dirname($fname), 0777, true);
    $fp = fopen($fname, 'a');
    flock($fp, LOCK_EX);
    fwrite($fp,'[' . date('Y-m-d H:i:s') . '] ' . $word . "\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * 删除指定目录下的所有文件及文件夹
 * @param $dir
 * @return bool
 */
function delete_dir($dir) {
    // 规范路径
    $dir = dir_path($dir);
    if (!is_dir($dir)) {
        return false;
    }
    $list = glob($dir . '*');
    foreach ($list as $v) {
        @unlink($v . '/.DS_Store');
        if (is_dir($v)) {
            delete_dir($v);
        } else {
            @unlink($v);
        }
        @rmdir($v);
    }
    @rmdir($dir);
}

/**
 * 标准化路径
 * @param $path
 * @return mixed|string
 */
function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/')
        $path = $path . '/';
    return $path;
}

/**
 * [runtime 获得脚本时间]
 * @param  integer $switch [description]
 */
function runtime($switch = 0){
    static $start;
    if($switch == 1){
        //开始，保存第一次时间
        $start = microtime(true);
    }else{
        //所算的的时间差
        return (microtime(true) - $start) . 's';
    }
}

/**
 * [curl_download curl 下载]
 */
function curl_download($url, $fname){
    // 初始化curl
    $ch = curl_init();
    // 设置请求地址
    curl_setopt($ch, CURLOPT_URL, $url);
    // header头设为空
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // 返回的数据自动显示
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $fp = fopen($fname,'w');
    curl_setopt($ch, CURLOPT_NOPROGRESS, 0);
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'progress');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 64000);

    // 超时时间
    curl_setopt($ch, CURLOPT_TIMEOUT,1800);
    // 判断是否为https
    $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
    if ($ssl) {
        $opt[CURLOPT_SSL_VERIFYHOST] = 1;
        $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }
    // 执行请求
    $return = curl_exec($ch);
    // 关闭curl资源
    curl_close($ch);
    // 关闭文件
    fclose($fp);
    // 返回数据
    return $return;
}

/**
 * [progress 下载进度]
 * @param  [void] $buffer  [缓冲]
 * @param  [type] $dltotal [下载总大小]
 * @param  [type] $dlnow   [当前下载大小]
 * @param  [type] $ultotal [上传总大小]
 * @param  [type] $ulnow   [当前上传大小]
 */
function progress($buffer, $dltotal, $dlnow, $ultotal, $ulnow){
    ini_set("max_execution_time", "1800");
    usleep(30000);
    $now = date('Y-m-d H:i:s');//当前时间
    //刚开始下载或上传时，$dltotal和$ultotal为0，此处避免除0错误
    if(empty($dltotal)){
        $when = "0";
    }else{
        $when = round($dlnow / $dltotal, 2) * 100;
    }

    // 计算kb
    $allKb = round($dltotal / 1024);
    $newKb = round($dlnow / 1024);
    // 更新页面进度
    echo    "<script>
                document.getElementById('jd').style.width='{$when}%';
                document.getElementById('jd').innerHTML='{$when}%';
                document.getElementById('xzz').innerHTML='正在下载...({$newKb} / {$allKb})kb';
            </script>";
    ob_flush();
    flush();
}

/**
 * [zip_extract 解压zip文件]
 */
function zip_extract($filename, $path) {
    ini_set("max_execution_time", "1800");
    if(0 !== strrpos($path,'/')){
        $path.='/';
    }
    //先判断待解压的文件是否存在
    if (!file_exists($filename)) {
        die("文件 $filename 不存在！");
    }
    $starttime = explode(' ', microtime()); //解压开始的时间

    //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
    $filename = iconv("utf-8", "gb2312", $filename);
    $path = iconv("utf-8", "gb2312", $path);
    //打开压缩包
    $resource = zip_open($filename);

    // 进度提示
    echo '<div style="width:50%;" id="jy" class="bc tc f14">正在解压...</div>';
    echo '<div style="width:50%;" id="jyf" class="bc tc f14"></div>';
    $one = 1;
    //遍历读取压缩包里面的一个个文件
    while ($dir_resource = zip_read($resource)) {
        if ($one == 1) {
            $mainName = zip_entry_name($dir_resource);
            $one = 2;
        }
        //如果能打开则继续
        if (zip_entry_open($resource, $dir_resource)) {
            //获取当前项目的名称,即压缩包里面当前对应的文件名
            $file_name = $path.zip_entry_name($dir_resource);
            //以最后一个“/”分割,再用字符串截取出路径部分
            $file_path = substr($file_name, 0, strrpos($file_name, "/"));
            //如果路径不存在，则创建一个目录，true表示可以创建多级目录
            if (!is_dir($file_path)) {
                mkdir($file_path, 0777, true);
            }
            //如果不是目录，则写入文件
            if (!is_dir($file_name)) {
                //读取这个文件
                $file_size = zip_entry_filesize($dir_resource);
                //最大读取10M，如果文件过大，跳过解压，继续下一个
                // $file_size = 1024 * 1024 * 10;
                $file_content = zip_entry_read($dir_resource, $file_size);
                file_put_contents($file_name, $file_content);

                // 进度提示
                $f = basename($file_name);
                echo    "<script>
                            document.getElementById('jyf').innerHTML='正在解压:({$f})';
                        </script>";
            }
            //关闭当前
            zip_entry_close($dir_resource);
            ob_flush();
            flush();
            usleep(30000);
        }
    }
    //关闭压缩包
    zip_close($resource);

    // $endtime = explode(' ', microtime()); //解压结束的时间
    // $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
    // $thistime = round($thistime, 3); //保留3为小数
    echo    "<script>
                document.getElementById('jy').innerHTML='解压完成';
                document.getElementById('jyf').innerHTML='正在安装...';
            </script>";
    return rtrim($mainName, '/');
}

/**
 * 状态值转文字
 * @param $data
 * @param array $map
 * @return array
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}


function moveFolder($source, $target){

    if(!file_exists($source))return false; //如果源目录/文件不存在返回false

    //如果要移动文件
    if(filetype($source) == 'file'){
        $basedir = dirname($target);
        if(!is_dir($basedir))mkdir($basedir); //目标目录不存在时给它创建目录
        copy($source, $target);
//        unlink($source);

    }else{ //如果要移动目录

        if(!file_exists($target))mkdir($target); //目标目录不存在时就创建

        $files = array(); //存放文件
        $dirs = array(); //存放目录
        $fh = opendir($source);

        if($fh != false){
            while($row = readdir($fh)){
                $src_file = $source . '/' . $row; //每个源文件
                if($row != '.' && $row != '..'){
                    if(!is_dir($src_file)){
                        $files[] = $row;
                    }else{
                        $dirs[] = $row;
                    }
                }
            }
            closedir($fh);
        }

        foreach($files as $v){
            copy($source . '/' . $v, $target . '/' . $v);
//            unlink($source . '/' . $v);
        }

        if(count($dirs)){
            foreach($dirs as $v){
                moveFolder($source . '/' . $v, $target . '/' . $v);
            }
        }
    }
    return true;
}
// select concat('truncate table ' ,table_name,';') from information_schema.tables;

function getRandomString($len, $chars=null)
{
    if (is_null($chars)) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
        $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}