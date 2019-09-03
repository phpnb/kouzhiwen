<?php
/**
 * [用户排行榜模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class UserRanking extends CommonModel{
    public $pk = 'id';

    /**
     * 添加排行榜
     * @param $uid
     * @param $fied
     * @return bool|int|true
     * @throws \think\Exception
     */
    public  function updateRanking($uid,$fied)
    {
        $where=array('uid'=>$uid,'date'=>date("Y"));
        $data=$this->getOne($where);
        if($data){
            $res=$this->where($where)->setInc($fied);
        }else{
            $data=array('uid'=>$uid,'date'=>date("Y"),$fied=>1);
            $res=$this->addData($data);
        }
        return $res;
    }

    public  function newRanking($uid,$fied,$num)
    {
        $where=array('uid'=>$uid,'date'=>date("Y"));
        $data=$this->getOne($where);
        if($data){
            $res=$this->where($where)->setall($fied,$num);
        }else{
            $data=array('uid'=>$uid,'date'=>date("Y"),$fied=>$num);
            $res=$this->addData($data);
        }
        return $res;
    }

}