<?php
/**
 * [用户考试结果模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class PaperUser extends CommonModel{
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
     * 查询已答完的题
     * @param $field
     * @param $where
     * @param $group
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function examid($field,$where,$group,$order){
        $data=$this->field($field)
            ->where($where)
            ->group($group)
            ->order($order)
            ->select()
            ->toArray();
        return $data;
    }

    /**
     * 获取用户考试记录
     * @param $uid  用户uid
     * @param $type 考试状态（1、通过 2、未通过
     */
    public function getUserDataList($uid,$type){
        $where = [
            'a.uid'=>$uid,
            'a.status'=>['neq',3],
        ];
        $field = [
            'a.id',
            'a.paper_id',
            'a.uid',
            'a.score',
            'a.created_at',
            'b.type',
            'b.title',
            'b.photo',
            "(select count(*) from `tpn_paper_user` where `paper_id`=a.paper_id and `uid`={$uid}) exam_num",//考试总数
            "(select count(*) from `tpn_paper_user` where `paper_id`=a.paper_id and `uid`={$uid} and `status`=3) exa",//考试总数
            "(select if(count(*)>0,1,2) from `tpn_paper_user` where `paper_id`=a.paper_id and `status`=1 and `uid`={$uid}) is_pass",//是否及格 1及格 2未及格
        ];
        $having = "";
        if($type == 1){
            $having = "is_pass=1";
        }elseif($type == 2){
            $having = "is_pass=2 and exa=0";
        }
        $model = $this->alias('a')->field($field)->join("paper b","a.paper_id=b.id")
                 ->where($where)->order("a.id desc")->group("a.paper_id")->having($having);
        return $model;
    }

    /**
     * 用户考试记录
     * @param $uid
     * @param $param=[
     * 'year'=>'2018',选择年份
     * ]
     */
    public function getDataList($uid,$param=[]){
        $where = [
            'a.uid'=>$uid
        ];
        if($param['year']>0){
            $year = $param['year']."-01-01";
            $start_time = strtotime($year);
            $end_time   = strtotime("+1 year",$start_time);
            $where['a.created_at'] = [['>',$start_time],['<',$end_time],'and'];
        }
        $field = [
            'a.id',
            'a.paper_id',
            'a.uid',
            'a.score',
            'a.status',
            'a.created_at',
            'b.type',
            'b.title',
            'b.photo',
        ];
        $model = $this->alias('a')->field($field)->join("paper b","a.paper_id=b.id")
                    ->where($where)->order("a.id desc");
        return $model;
    }

    /**
     * 获取班级用户平均值
     * @param $uid
     * @param $param=[
     * 'year'=>'2018',选择年份
     * ]
     */
    public function classAvgScore($uid,$param=[]){
        $year = $param['year']."-01-01";
        $start_time = strtotime($year);
        $end_time   = strtotime("+1 year",$start_time);
        $where = [
            'a.uid'=>$uid
        ];
        if($param['year']>0){
            $where['a.created_at'] = [['>',$start_time],['<',$end_time],'and'];
        }
        $field = [
            'a.id',
            'b.class_id',//班级id
            'c.name',//班级名称
            "FORMAT(avg(`score`),2)"=>"avg_score",//平均分
        ];
        $model = $this->alias('a')->field($field)
                    ->join("paper b","a.paper_id=b.id")
                    ->join("class c","b.class_id=c.id")
                    ->where($where)->group("b.class_id");
        return $model;
    }

    /**
     * 获取用户考试记录
     * @return $this
     */
    public function PaperList(){
        $field = [
            'a.score',
            'a.status',
            'a.created_at',
            'b.type',
            'b.title',
            'b.photo',
        ];
        $model = $this->alias('a')->field($field)->join("paper b","a.paper_id=b.id",'left')->order("a.created_at desc");
        return $model;
    }
}