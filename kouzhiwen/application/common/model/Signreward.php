<?php


namespace app\common\model;
use app\common\model\User;
use app\common\model\IntDetailed;

class Signreward extends CommonModel{

    public function checkTime($data) {
        $user = new User();
        $intdetailedmodel = new IntDetailed();
        $newtime = time();

        $p = date('d',$data[0]['sign_time']);
        $ordtime = (int)$p;
        // 判断时间是否大于24小时
        $t = date('d',time());
        $time = (int)$t;

        if ($time - $ordtime != 1 && $time - $ordtime != 0 ) {
            $where = ['uid' => $data[0]['uid']];
            $res = ['fraction'=>1,'sign_time'=>$newtime];
            $this->editData($where,$res);
            $user->where($where)->setInc('integral');
            $intdetailedmodel->addData(['uid'=>$data[0]['uid'],'type'=>1,'title'=>'签到','price'=>'1','created_at'=>$time]);
            $data = ['fraction'=>1];
            return $data;
        }elseif($time - $ordtime == 0 ){
            return 2;
        }else{
            if($data[0]['fraction'] == 7){
                $where = ['uid' => $data[0]['uid']];
                $this->editData($where,['fraction'=>1]);
            }else{
                $where = ['uid' => $data[0]['uid']];
                $this->where($where)->setInc('fraction');
                $this->editData($where,['sign_time'=>$newtime]);
            }
            $fraction = $this->where($where)->field('fraction')->select()->toArray();
//            dump($fraction);
            $user->where($where)->setall('integral',$fraction[0]['fraction']);

            $intdetailedmodel->addData(['uid'=>$data[0]['uid'],'type'=>1,'title'=>'签到','price'=>$fraction[0]['fraction'],'created_at'=>$time]);
            $data = ['fraction'=>$fraction[0]['fraction']];
//            dump($data);
            return $data;
        }

    }

}