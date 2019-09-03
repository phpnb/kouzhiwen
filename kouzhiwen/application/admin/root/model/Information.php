<?php
/**
 * [资讯管理模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-24 17:18:08
 * @Copyright:
 */
namespace app\admin\root\model;  
use think\Validate; 
use app\common\model\CommonModel;

class Information extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
            'classify_id' => 'require',
            'cover_img' => 'require',
            'name' => 'require',
            'author' => 'require',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'id.require' => '请填写ID',
            'enterprise_id.require' => '请填写公司id  0为机构发布',
            'classify_id.require' => '请填写分类',
            'cover_img.require' => '请填写封面图',
            'name.require' => '请填写标题',
            'author.require' => '请填写作者',
            'contents.require' => '请填写内容',
            'add_time.require' => '请填写添加时间',
            'comment_num.require' => '请填写评论总数',
            'pv.require' => '请填写浏览量',
            'status.require' => '请填写状态',
            'is_recommend.require' => '请填写是否推荐 1是 0否',
        ];

        // 创建验证
        if (!empty($rule) && !empty($message)) {
            // 创建验证规则
            $validate = new Validate($rule, $message);
            // 执行验证
            if (!$validate -> check($data)) {
                // 保存错误信息
                $this -> err = $validate -> getError();
                return false;
            }
        }

        // 保存验证过的数据
        $this -> data = $data;
        return true;
    }
}