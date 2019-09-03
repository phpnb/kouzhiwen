<?php
/**
 * [讨论组群员模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class ClassDiscussUser extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';

    /**
     * 获取组成员
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function Userlist($where){
        $where['type']=1;
        $field=array('d.*','u.name','u.face as photo');
        $userdata=$this->field($field)->alias('d')->join('user u','u.uid=d.user_id','left')
            ->where($where)->select()->toArray();
        $where['type']=2;
        $field=array('d.*','t.photo','t.name');
        $teacherdata=$this->field($field)->alias('d')->join('teacher t','t.id=d.user_id','left')
            ->where($where)->select()->toArray();
        return array_merge($teacherdata,$userdata);
    }
}