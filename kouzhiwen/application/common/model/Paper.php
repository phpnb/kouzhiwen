<?php
/**
 * [考试模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class Paper extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

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
     * 查询考试列表
     * @param $uid
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exam($uid,$where){
        $field=array(
            'p.id',
            'p.title',
            'p.photo',
            '(SELECT COUNT(*) FROM `tpn_paper_user` WHERE paper_id=p.id AND `uid`='.$uid.') num',
            '(SELECT IF(COUNT(*)>0,1,0) FROM `tpn_paper_user` WHERE paper_id=p.id AND `uid`='.$uid.' AND `status`=1) is_paper',
        );
        $data=$this->alias('p')
            ->field($field)
            ->where($where)
            ->select()
            ->toArray();
        return $data;
    }

    

}