<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-25
 * Time: 下午5:00
 */
namespace app\common\model;
use think\Validate;

class LookRecord extends CommonModel{

    /**
     * 查看记录
     * @param $uid
     * @param array $teacher_id
     */
    public function saveData($uid,$teacher_id=[]){
        $one = $this->where(['uid'=>$uid])->find();
        if(!$one){
            //添加
            $data = [
                'uid' => $uid,
                'teacher_id'=>implode(",",$teacher_id)
            ];
            return $this->insert($data);
        }else{
            $teacher=$one['teacher_id'];
            if(!empty($teacher_id)){
                $teacher=$teacher.",".implode(",",$teacher_id);
            }

            //修改
            return $this->where(['uid'=>$uid])->update(['teacher_id'=>$teacher]);
        }
    }
}