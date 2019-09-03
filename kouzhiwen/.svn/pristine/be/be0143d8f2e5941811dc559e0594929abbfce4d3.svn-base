<?php
/**
 * [文件上传]
 * @Author: Careless
 * @Date:   2017-04-09 21:38:30
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\teacher\root\controller;
use think\Image;
use OSS\OssClient;
use OSS\core\OssUtil;

class Upload{
    /**
     * 上传图片
     * @return \think\response\Json
     */
    public function upload(){
        $file = request() -> file('file');
        // 判断图片大小是否超限
        $info = $file -> getInfo();

        // 图片大小限制 3145728
        if ($info['type'] == 'video/mp4')
        {
            if ($info['size'] > 2147483648) {
                return ajax('上传的视频不能超过2048M!', 2);
            }
        }else{
            if ($info['size'] > 11457280) {
                return ajax('上传的图片过大', 2);
            }
        }

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file -> move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path = $info -> getRealPath();
            $fname = strstr($path, 'uploads');
            $fname = '/' . str_replace('\\', '/', $fname);

            // 是否需要裁剪图片
            $cj = input('post.cj');
            if (!empty($cj)) {
                // 执行裁剪
                $this -> _tailorImg($path, $cj);
            }
            return ajax('上传成功', 1, ['path'=>$fname]);
        }else{
            // 上传失败获取错误信息
            return ajax($file->getError(), 2);
        }
        
    }

    /**
     * 保存阿里云oss上
     * @return \think\response\Json
     * @throws \OSS\Core\OssException
     */
    public function AliyunOss(){
        $config=config('aliyun_oss');
        $bucket =$config['Bucket'];
        $file = request() -> file('file');
        // 判断图片大小是否超限
        $info = $file -> getInfo();
        //保存路径
        $object='video/'.date("Ymd").'/'.create_order_num().'.'.substr($info['name'],strrpos($info['name'],'.')+1);
        $path=$config['url'].$object;
        /**
         *  step 1. 初始化一个分块上传事件, 也就是初始化上传Multipart, 获取upload id
         */
        try{
            $ossClient = new OssClient($config['accessKeyId'], $config['accessKeySecret'], $config['Endpoint']);
            $uploadId = $ossClient->initiateMultipartUpload($bucket, $object);
        } catch(OssException $e) {
            return ajax($e->getMessage(), 2);
        }
        /*
         * step 2. 上传分片
         */
        $partSize = 10 * 1024 * 1024;
        $uploadFile = $info['tmp_name'];
        $uploadFileSize = filesize($uploadFile);

        $pieces = $ossClient->generateMultiuploadParts($uploadFileSize, $partSize);
        $responseUploadPart = array();
        $uploadPosition = 0;
        $isCheckMd5 = true;
        foreach ($pieces as $i => $piece) {
            $fromPos = $uploadPosition + (integer)$piece[$ossClient::OSS_SEEK_TO];
            $toPos = (integer)$piece[$ossClient::OSS_LENGTH] + $fromPos - 1;
            $upOptions = array(
                $ossClient::OSS_FILE_UPLOAD => $uploadFile,
                $ossClient::OSS_PART_NUM => ($i + 1),
                $ossClient::OSS_SEEK_TO => $fromPos,
                $ossClient::OSS_LENGTH => $toPos - $fromPos + 1,
                $ossClient::OSS_CHECK_MD5 => $isCheckMd5,
            );
            if ($isCheckMd5) {
                $contentMd5 = OssUtil::getMd5SumForFile($uploadFile, $fromPos, $toPos);
                $upOptions[$ossClient::OSS_CONTENT_MD5] = $contentMd5;
            }
            //2. 将每一分片上传到OSS
            try {
                $responseUploadPart[] = $ossClient->uploadPart($bucket, $object, $uploadId, $upOptions);
            } catch(OssException $e) {
                return ajax($e->getMessage(), 2);
            }
        }
        $uploadParts = array();
        foreach ($responseUploadPart as $i => $eTag) {
            $uploadParts[] = array(
                'PartNumber' => ($i + 1),
                'ETag' => $eTag,
            );
        }
        /**
         * step 3. 完成上传
         */
        try {
            $ossClient->completeMultipartUpload($bucket, $object, $uploadId, $uploadParts);
        }  catch(OssException $e) {
            return ajax($e->getMessage(), 2);
        }
        return ajax('上传成功', 1, ['path'=>$path,'name'=>$info['name']]);
    }
    /**
     * 裁剪图片
     * @param $fname
     * @param $cj
     */
    private function _tailorImg($fname, $cj){
        // 打开图片
        $image = Image::open($fname);
        // 获取原图宽高
        $width  = $image -> width();
        $height = $image -> height();

        // 裁剪
        foreach (explode(',', $cj) as $v) {
            // 计算比例
            $ratio = $v / $width;
            // 计算高度
            $h = round($height * $ratio);
            // 生成缩略 
            $image -> thumb($v, $h, 2) -> save($fname . '_' . $v . '.jpg');
        }
    }
}











