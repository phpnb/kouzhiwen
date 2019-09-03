<?php
/**
 * [用户提问专家模型]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-20
 * Time: 下午6:27
 */

namespace app\common\model;
use think\Validate;

class UserQuiz extends CommonModel{

    /**
     * @param $uid
     * @return mixed
     */
    public function getDataList($uid){
        $where = [
            'a.uid'=>$uid
        ];
        $field = [
            "a.*",
            "u.nickname",
            "u.face"
        ];

        $model = $this->alias('a')->field($field)->join("user u","a.uid=u.uid")->where($where)->order("a.id desc");
        return $model;
    }

    public function QuizList($field,$where,$orderby){
        $model=$this->alias('a')
            ->field($field)
            ->join('user u','a.uid=u.uid','left')
            ->where($where)
            ->order($orderby);
        return $model;
    }

}