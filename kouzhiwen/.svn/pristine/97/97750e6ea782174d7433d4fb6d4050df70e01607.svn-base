<?php
/**
 * 【学习记录模型】
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-19
 * Time: 上午10:10
 */
namespace app\common\model;
use think\Validate;

class UserRecord extends CommonModel{

    /**
     * 用户学习记录
     * @param array $param=[
     * 'classify_id'      => 平台分类id,
     * 'enterprise_id'   => "0" 企业id
     * 'type'           => 类型(1、专业考试记录 2、班级考试 3、班级课,
     * ]
     * @param $uid 用户uid
     * @return UserRecord
     */
    // 6 3
    public function getDataList($param=[],$uid){
        $where = [
            'a.uid'          =>$uid,
        ];
        if($param['type']){
            //学习类型
            $where['a.type'] = $param['type'];
        }
        $field = [];
        $model = $this;
        if($param['type'] == 1){

        }elseif($param['type'] == 2){
        }
        elseif($param['type'] == 3)
        {
            //班级课
            $field = [
               'a.id',
               'a.type',
               'a.type_id',
               'b.teacher_id',
               'b.id as course_id',//课程id
               'b.class_id',
               'b.title',
               'b.photo',
               'b.reading',
               'b.words',
               'b.start',
               'b.status',
               't.name as teacher_name'//老师名字
           ];
            if($param['classify_id']){
                //平台分类id
                $where['c.classify_id'] = $param['classify_id'];
            }
            $where['c.enterprise_id']=$param['enterprise_id'];
            $model = $model->alias('a')->field($field)
                ->join("class_course b","a.type_id=b.id")
                ->join("class c","c.id=b.class_id")
                ->join("teacher t","b.teacher_id=t.id")
                ->where($where)->order("a.id desc");
        }
        elseif($param['type']==4)
       {
            if($param['year']){
                $year = $param['year']."-01-01";
                $start_time = strtotime($year);
                $end_time   = strtotime("+1 year",$start_time);
                $where['a.created_at'] = [['>',$start_time],['<',$end_time],'and'];
            }
            //发现公开课
            $field = [
                'a.id',
                'a.type',
                'a.type_id',
                'a.created_at',
                'b.cover_img',
                'b.name',
                'b.add_time'
            ];
            $model = $this->alias('a')->field($field)->join("introduce b","a.type_id=b.id")->where($where)->order("a.id desc");
        }
        elseif($param['type']==5){
            //班级热点 教师文章
            if($param['year']){
                $year = $param['year']."-01-01";
                $start_time = strtotime($year);
                $end_time   = strtotime("+1 year",$start_time);
                $where['a.created_at'] = [['>',$start_time],['<',$end_time],'and'];
            }
            //发现公开课
            $field = [
                'a.id',
                'a.type',
                'a.type_id',
                'a.created_at',
                'b.cover_img',
                'b.name',
                'b.add_time',
                'b.comment_num'
            ];
            $model = $this->alias('a')->field($field)->join("teacher_article b","a.type_id=b.id")->where($where)->order("a.id desc");

        }elseif($param['type']==6){
            //直播记录
            if($param['classify_id']){
                //平台分类id
                $where['c.classify_id'] = $param['classify_id'];
            }
            if($param['course']){
                //平台分类id
                $where['c.type'] = $param['course'];

            }
            if($param['course_type']){
                //平台分类id
                $where['c.type_id'] = $param['course_type'];

            }

            $where['c.enterprise_id']=$param['enterprise_id'];
            $field=array('c.id','c.title','c.photo','c.look_num','c.reading','t.name');
            $model = $model->alias('a')->field($field)
                ->join("course c","c.id=a.type_id",'left')
                ->join("teacher t","c.teacher_id=t.id",'left')
                ->where($where)->order("a.created_at desc");
        }

        return $model;
    }


}