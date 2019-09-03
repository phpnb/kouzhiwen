<?php
/**
 * [班级学员模型]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */
namespace app\common\model;
use think\Validate;

class ClassUser extends CommonModel{
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
     * 获取用户所在的班级列表
     * @param $uid
     */
    public function getDataList($uid){
        $where = [
            'a.delete' => 1,
            'a.uid'    => $uid
        ];
        $field = [
            'a.*',
            "b.name",
            "b.photo",
            "b.start",
            "b.end",
            "b.price",
            "t.name as teacher_name",//教师名称
            "(select count(*) from tpn_class_user where `class_id`=a.class_id and `status`=1) apply_num",//已报名人数
        ];
        $model = $this->alias('a')->field($field)
            ->join("class b","a.class_id=b.id")
            ->join("teacher t","t.id=b.teacher_id")
            ->where($where)->order("a.id desc");
        return $model;
    }

    /**
     * 获取班级群成员
     * @param $where
     * @param $teacherid
     * @param $tid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function UserList($where,$teacherid,$tid){
        $field=array('c.uid as user_id','u.name','u.face as photo','1 as type','c.call');
        $data=$this->alias('c')->field($field)->join('user u','u.uid=c.uid','left')
            ->where($where)->select()->toArray();
        $field=array("id as user_id",'name',"photo","2 as type","if(id=$tid,'班主任','讲师') as 'call'");
        $teacher=Teacher::field($field)->where(['id'=>['in',$teacherid]])->select()->toArray();
        return array_merge($teacher,$data);;
    }

    /**
     * 获取排行榜
     * @param $where
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function rankingList($where){
        $y=date("Y");
        $field=array(
            "u.uid","u.face",
            "(select SUM(blue+purple+green+orange+red) from `tpn_user_ranking` `r` where `date`='$y' and `r`.`uid`=`c`.`uid`) ranking_num",
        );
        $data=$this->alias('c')
            ->join('user u','u.uid=c.uid','left')
            ->field($field)
            ->where($where)
            ->order('ranking_num desc')
            ->limit(0,10)
            ->select();
        if(empty($data)){
            return array();
        }
        foreach ($data as $key=>$val){
            $val->ranking;
            unset($data[$key]['ranking_num']);
        }
        return $data;
    }
    /**
     * 关联排行榜
     * @return \think\model\relation\HasMany
     */
    public function ranking(){
        return $this->hasMany('UserRanking','uid','uid')->field(['blue','purple','green','orange','red'])->order('date desc');
    }

}