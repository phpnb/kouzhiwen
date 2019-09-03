<?php
/**
 * [班级课程表]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午5:54
 */
namespace app\common\model;
use think\Validate;

class ClassCourse extends CommonModel{
    public $err;
    public $data;
    public $pk = 'id';


    public function profile()
    {
        return $this->hasOne('note')->field('title');
    }
	/**
     * 获取学习班列表
     * @param array $param=[ 查询条件
     * 'classify_id'=>"1",  平台分类id
     * 'enterprise_id'   => "0" 企业id
     * 'type'         => 1  类型  1直播课 2已直播 3视频课
     * ]
     */
    public function getDataList($param=[]){
        $param['uid'] = $param['uid']?$param['uid']:0;
        $where = [
            'b.enterprise_id'=>$param['enterprise_id']
        ];
        if($param['type']==1){
            //正在直播的课程
            $where['a.status'] = 2;
            $where['a.start']  = ["<>",0];
            $where['a.start']  = ['<',time()];
        }elseif($param['type']==2){
            //已结束的直播课
            $where['a.status'] = 3;
            $where['a.start']  = ["<>",0];
        }elseif($param['type']==3){
            //视频课
            $where['a.start'] = 0;
        }
        if($param['classify_id']){
            //所属平台的分类
            $where['b.classify_id'] = $param['classify_id'];
        }
        $field = [
            'a.id as course_id',
            'a.teacher_id',
            'a.title',
            'a.photo',
            'a.url',
            'a.reading',
            'b.price',//班级收费
            't.name as teacher_name'//老是名字
        ];

        $model = $this->alias('a')->field($field)
                    ->join("class b","b.id=a.class_id")
                    ->join("teacher t","a.teacher_id=t.id")
                    ->where($where)->order("a.id desc");
        return $model;
    }
	
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
     * 获取正在直播课程
     * @param $where
     * @param $orderby
     * @param $field
     * @param $total
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function scene($where,$orderby,$field,$total){
        $data=$this->alias('s')
            ->field($field)
            ->join('class c','s.class_id=c.id','left')
            ->join('teacher t','s.teacher_id=t.id','left')
            ->where($where)
            ->order($orderby)
            ->limit("0,$total")
            ->select()
            ->toArray();

        return $data;
    }

    /**
     * 直播课详情
     * @param $id  直播颗id
     * @param $uid 当前用户id
     */
    public function getDetails($id,$uid){
        $where = [
            'id'=>$id
        ];
        $data = $this->where($where)->find();

        return $data;
    }


    /**
     * 课程列表
     * @param $field
     * @param $orderby
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function courselist($field,$where,$orderby){
        $data=$this->alias('c')
            ->field($field)
            ->order($orderby,'desc')
            ->where($where)
            ->select()
            ->toArray();
        return $data;
    }

}