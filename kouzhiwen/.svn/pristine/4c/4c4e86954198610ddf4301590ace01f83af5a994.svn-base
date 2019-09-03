<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-5-2
 * Time: 下午6:33
 */

namespace app\api\common\controller;

class Uploads extends Api{
    /**
     * 上传图片
     */
    public function uploadImg(){
        //file_put_contents(dirname(__FILE__).'/xml.txt', '  post:'.var_export($_FILES,true), FILE_APPEND);
        $file = $_FILES['file_name'];
        return $this->uploadImgSave($file);
    }

    /**
     * 批量上传
     */
    public function uploadImgList(){
        set_time_limit(0);
        //file_put_contents(dirname(__FILE__).'/imgall.txt', '  post:'.var_export($_FILES,true), FILE_APPEND);
        if(empty($_FILES)){
            return ajax("请选择上传的图片",2);
        }
        $data = array();
        foreach($_FILES as $file){
            $rs = $this->saveImg($file);
            if($rs){
                $data[] = $rs;
            }
        }
        if($data){
            return ajax("上传成功",1,['data'=>$data]);
        }
        return ajax("上传失败",2);
    }

    /**
     * 上传视频
     */
    public function uploadVideo(){
        set_time_limit(0);
        // file_put_contents(dirname(__FILE__).'/video.txt', '  post:'.var_export($_FILES,true), FILE_APPEND);
        $file = $_FILES['file_name'];
        return $this->uploadVideoSave($file);
    }


    /**
     * @param $file
     * @return array
     */
    public function uploadImgSave($file){
        $fileSize = $file['size']/1024;
        $configImgSize = $this->config["upload_img_size"];
        if($fileSize > $configImgSize){
            return ajax("图片大小超过限制,只能上传:{$configImgSize}kb的图片文件!",2);
        }else{
            //检查文件类型是否包含可上传
            $configImgTypeArr = $this->config["upload_img_type"];
            $configImgSuffix = $this->config["upload_img_suffix"];

            /*if(!in_array($file['type'], $configImgTypeArr)){
                $this->returnBack(1,"图片文件类型不被允许,只能上传{$configImgSuffix}的类型图片!");
            }else{*/
                $basePath = $this->config["upload_img_basePath_user"];
                $yNow = date("Y");
                $mNow = date("m");
                $dNow = date("d");

                $imgPath = $basePath. "/" . $yNow . "/" . $mNow . "/" . $dNow . "/";
                $baseImgPath = getcwd()."/".$imgPath;
                $isImgPath = $this->createDir($baseImgPath);
                if($isImgPath){
                    $fileType = strtolower(substr($file['name'],strrpos($file['name'],'.')+1)); //得到文件类型，并且都转化成小写
                    $imgName = time() . md5($file['name']).'.'.$fileType;
                    if(move_uploaded_file($file['tmp_name'], $baseImgPath . $imgName)){
                        return ajax("上传图片成功",1,['img_path'=>$imgPath . $imgName]);
                    }else{
                        return ajax("上传图片失败",2);
                    }
                }else{
                    return ajax("创建文件夹失败",2);
                }
           /* }*/

        }
    }
    /**
     * @param $file
     * @return array
     */
    public function uploadVideoSave($file){
        $backArr = array();
        $fileSize = $file['size']/1024;
        $configImgSize = $this->config["upload_video_size"];
        if($fileSize > $configImgSize){
            return ajax("视频大小超过限制,只能上传:{$configImgSize}kb的视频文件",2);
        }else{
            //检查文件类型是否包含可上传
            $configImgTypeArr = $this->config["upload_video_type"];
            $configImgSuffix  = $this->config["upload_video_suffix"];


           /* if(!in_array($file['type'], $configImgTypeArr)){
                $this->returnBack(1,"视频文件类型不被允许,只能上传{$configImgSuffix}的类型视频");
            }else{*/
                $basePath = $this->config["upload_video_basePath"];
                $yNow = date("Y");
                $mNow = date("m");
                $dNow = date("d");

                $imgPath = $basePath. "/" . $yNow . "/" . $mNow . "/" . $dNow . "/";
                $baseImgPath = getcwd().$imgPath;
                $isImgPath = $this->createDir($baseImgPath);
                if($isImgPath){
                    $fileType = strtolower(substr($file['name'],strrpos($file['name'],'.')+1)); //得到文件类型，并且都转化成小写
                    $imgName =  md5(time().$file['name']);
                    $img_url =  $baseImgPath . $imgName.'.'.$fileType;
                    if(move_uploaded_file($file['tmp_name'], $img_url)){
                        //截取视频第一针
                        //$this->getVideoCover($img_url,1,$baseImgPath .$imgName.'.jpg');
                        return ajax("上传视频成功",1,['img_path'=>$imgPath . $imgName.'.'.$fileType]);

                    }else{
                        return ajax("上传视频失败",2);
                    }
                }else{
                    return ajax("创建文件夹失败",2);
                }
            /*}*/
        }
    }

    /**
     * @param $file video路径
     * @param $time 第几帧
     * @param $name 图片名称
     * @param int $w 图片宽度
     * @param int $h 图片高度
     * @return int
     */
    public  function getVideoCover($file,$time,$name,$w=300,$h=300) {
        if(empty($time))$time = '1';//默认截取第一秒第一帧
        $strlen = strlen($file);
        //$str = "ffmpeg -i ".$file." -y -f mjpeg -ss 3 -t ".$time." -s {$w}x{$h} ".$name;
        $str = "ffmpeg -i ".$file." -y -f  image2  -ss 00:00:01 -vframes 1 ".$name;

        exec($str);
        //$result = system($str);
        return 1;
    }

    public function saveImg($file){
        $fileSize = $file['size']/1024;
        $configImgSize = $this->config["upload_img_size"];
        if($fileSize > $configImgSize){
            return false;
        }else{
            //检查文件类型是否包含可上传
            $configImgTypeArr = $this->config["upload_img_type"];
            $configImgSuffix = $this->config["upload_img_suffix"];

            /*if(!in_array($file['type'], $configImgTypeArr)){
                //$this->returnBack(1,"图片文件类型不被允许,只能上传{$configImgSuffix}的类型图片!");
                return false;
            }else{*/
                $basePath = $this->config["upload_img_basePath_user"];
                $yNow = date("Y");
                $mNow = date("m");
                $dNow = date("d");

                $imgPath = $basePath. "/" . $yNow . "/" . $mNow . "/" . $dNow . "/";
                $baseImgPath = getcwd()."/".$imgPath;
                $isImgPath = $this->createDir($baseImgPath);
                if($isImgPath){
                    $fileType = strtolower(substr($file['name'],strrpos($file['name'],'.')+1)); //得到文件类型，并且都转化成小写
                    $imgName = time() . md5($file['name']).'.'.$fileType;
                    if(move_uploaded_file($file['tmp_name'], $baseImgPath . $imgName)){
                        return $imgPath . $imgName;
                    }else{
                        return false;
                    }
                }else{
                    //$this->returnBack(1,"创建文件夹失败");
                    return false;
                }
            /*}*/

        }
    }

    /**
     * 在服务端创建文件夹
     * @param $path
     * @return bool
     */
    protected function createDir($path){
        $path = str_replace("./", "/", $path);
        if(is_dir($path) || @mkdir($path, 0777)){
            chmod($path,0777);
            return true;
        }
        if(!$this->createDir(dirname($path))){
            return false;
        }
        if(@mkdir($path, 0777)){
            chmod($path,0777);
            return true;
        }
        return false;
    }

    /**
     * 音频文件上传 'mp3'
     */
    public function saveUploadAudio() {
        $back = $this->uploadSave(4*1000*1000,array('mp3'), './public/upload/music/');
        if ($back['code']===0)
            echo $back['path'];
        else
            echo $back['state'];
    }
    /**
     * @param $fileSize 文件大小
     * @param $fileExt  数组，支持的文件扩展名
     * @param $savePath 保存路径
     * @return mixed    返回路径或错误代码
     */
    private  function uploadSave($fileSize, $fileExt, $savePath) {
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];

            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $targetFile = rtrim($savePath,'/') . '/' . date("YmdHis").md5($fileParts['filename']).'.'.$fileParts['extension'];

            if (in_array($fileParts['extension'],$fileExt)) {
                if ($_FILES['Filedata']['size'] > $fileSize)
                    return array('state'=>1);    // 文件大于指定的大小

                @copy($tempFile,$targetFile);
                return array('state'=>0, 'domain'=>$this->config['site_url'], 'path'=>str_replace('./', '/', $targetFile));
            } else {
                return array('state'=>2);    // 文件格式不对
            }
        }
    }
}