<?php
/**
 * [用户指标模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class UserNorm extends CommonModel{

    private $fiddata=['a','b','c','d','e'];
    private $rule=[
        'money'=>[2=>50,3=>100,4=>200,5=>500,],
    ];

    /**
     * 添加指标
     * @param $user
     * @param $fid
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function normUp($user,$fid){
        if(!in_array($fid,$this->fiddata)){
            return false;
        }
        $time=time();
        $data=$this->where(['uid'=>$user['uid']])->find();
        if(empty($data)){
            //没有指标则创建指标并加一
            return $this->addData(['uid'=>$user['uid'],$fid=>1]);
        }
        $this->startTrans();//开始事务
        //指标加一
        $res=$this->where(['uid'=>$user['uid']])->setInc($fid);
        if(!$res){
            $this->rollback();
            return false;
        }
        $data=$this->find($user['uid']);
        $level=$this->userLevel($data,$user['level']);
        if($level){
            $balance=$user['balance']+$this->rule['money'][$level];
            $this->Userup($user['uid'],$level,$balance,$time);
            if(!$res){
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }

    /**
     * 会员等级提升
     * @param $uid
     * @param $level
     * @param $balance
     * @param $time
     * @return bool
     */
    private function Userup($uid,$level,$balance,$time){
        $res=User::update(['level'=>$level,'balance'=>$balance,'updated_at'=>$time],['uid'=>$uid]);
        if(!$res){
            return false;
        }
        $res=UserDetailed::create(['uid'=>$uid,'type'=>2,'title'=>'等级提升','price'=>$this->rule['money'][$level],'created_at'=>$time]);
        if(!$res){
            return false;
        }
        $res=UserNotice::create(['uid'=>$uid,'title'=>'等级提升','content'=>"等级提升 奖励".$this->rule['money'][$level]."元",'reading'=>0,'created_at'=>$time]);
        if(!$res){
            return false;
        }
        return true;
    }

    /**
     * 判断会员等级
     * @param $data
     * @param $level
     * @return int
     */
    private function userLevel($data,$level){
        // 注册用户
        if($level==0 && $data['a']==0 && $data['b']==0 && $data['c']==0 && $data['d']==0 && $data['e']==0){
            return 1;
        }

        // 铜牌会员
        if($level==1 && $data['a']>=3 && $data['b']>=1 && $data['c']>=3 && $data['d']>=10 && $data['e']>=1){
            return 2;
        }

        // 银牌会员
        if($level==2 && $data['a']>=5 && $data['b']>=2 && $data['c']>=5 && $data['d']>=20 && $data['e']>=2){
            return 3;
        }

        // 金牌会员
        if($level==3 && $data['a']>=10 && $data['b']>=4 && $data['c']>=8 && $data['d']>=50 && $data['e']>=4){
            return 4;
        }

        // 钻石会员
        if($level==4 && $data['a']>=15 && $data['b']>=5 && $data['c']>=10 && $data['d']>=100 && $data['e']>=5){
            return 5;
        }
        return 0;
    }



}