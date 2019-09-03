<?php
/**
 * [轮播图模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class Banner extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
           'type' => 'require',
           'img_url' => 'require',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'type' => '请选择banner位置',
            'img_url' => '请请上传图片',
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

    public function dataList($where,$uid){
        $data=array();
        $where['status']=1;
        $banner=$this->where($where)
                    ->field(['pid','mold','type','img_url'])
                    ->order("add_time desc")
                    ->limit('0,4')
                    ->select();
        if(!empty($banner)){
            foreach ($banner as $key=>$val){
                $data[$key]=$val;
                $data[$key]['banner_type']=0;
                $item=$val->bannertable;

                if($val->mold==1){
                    $data[$key]['banner_type']=$item['type'];
                }elseif ($val->mold==2){
                    $user=ClassUser::where(['uid'=>$uid,'class_id'=>$item['id']])->find();
                    $data[$key]['banner_type']=empty($user)?2:1;
                }
                unset($data[$key]['bannertable']);
            }
        }

        return $data;
    }

    public function bannertable(){
        return $this->morphTo(['mold','pid'],[
            1=>'app\common\model\Course',
            2=>'app\common\model\Studys',
            3=>'app\common\model\Information',
        ]);
    }

}