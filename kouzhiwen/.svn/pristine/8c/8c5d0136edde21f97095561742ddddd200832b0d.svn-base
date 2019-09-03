<?php


namespace app\common\model;


class Charts extends CommonModel{

    /**
     * 添加排行榜
     * @param $uid
     * @param $fied
     * @return bool|int|true
     * @throws \think\Exception
     */
    public  function updateRanking($uid,$fied)
    {
        $where=array('uid'=>$uid);
        $data=$this->getOne($where);
        if($data){
            $res=$this->where($where)->setInc($fied);
        }else{
            $data=array('uid'=>$uid,$fied=>1);
            $res=$this->addData($data);
        }
        return $res;
    }

    public  function newRanking($uid,$fied,$num)
    {
        $where=array('uid'=>$uid);
        $data=$this->getOne($where);
        if($data){
            $res=$this->where($where)->setall($fied,$num);
        }else{
            $data=array('uid'=>$uid,$fied=>$num);
            $res=$this->addData($data);
        }
        return $res;
    }
}