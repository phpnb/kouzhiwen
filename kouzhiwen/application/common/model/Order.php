<?php
/**
 * [订单模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class Order extends CommonModel{
    public $err;
    public $data;
    public $pk = 'order_number';

    /**
     * [checkData 验证数据]
     */
    public function checkData($data, $noverify = []){
        // 验证规则
        $rule = [
           'title' => 'require',
           'content' => 'require',
       ];

        // 去除不需要验证的字段
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // 错误提示
        $message = [
            'title' => '请填写标题',
            'content' => '请填写协议内容',
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

    /**
     * 查询用户班级活动报名
     * @param $field
     * @param $where
     * @param $order
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function EnrollUser($field,$where,$order){
        $data= $this->alias('o')
            ->field($field)
            ->join('user u','u.uid=o.uid','left')
            ->where($where)
            ->order($order)
            ->select()
            ->toArray();
        return $data;
    }

    /**
     * 查询购买记录
     * @param $type 类型（1、学习班 2专业课 3、班级通知
     * @param $param 自定条件
     * @param $uid
     */
    public function getDataList($type,$param=[],$uid=0){
        $where = [
            'a.type'=>$type,
        ];
        if($uid>0){
            $where["a.uid"] = $uid;
        }
        $model  = $this;
        if($type==2){
            $where['a.pay_status'] = 2;
            $where['b.type'] = $param['course_type'];//课程类型 1、专业知识课 2、选修课'
            $field = [
                'a.*',
                'b.title',
                'b.photo',
                'b.created_at as add_time',//课程添加时间
            ];
            $model = $this->alias('a')->field($field)->join("course b","b.id=a.type_id")->where($where)->order("id desc");
        }elseif($type==1){

        }elseif($type==3){

        }
        return $model;
    }
}