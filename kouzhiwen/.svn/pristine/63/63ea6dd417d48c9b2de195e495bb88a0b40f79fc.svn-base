<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: 下午3:17
 */

namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\model\ClassUser;
use app\common\model\Studys;
use app\common\model\ClassCourse;

class Group extends Api{
    /**
     * 通讯录分组
     */
    public function datalist(){
        $db   = db('teacher_group');
        $data = $db->where(['status'=>1])->select()->toArray();
        return ajax("获取成功",1,['data'=>$data]);
    }

    /**
     * 获取最近联系人
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function historyTeacher(){
        if(!$this->param['classify_id']) return ajax("缺少平台分类id",2);
        if(!$this->param['t_id']) return ajax("缺少教师id",2);
        $db   = db('teacher_group_record');

        $where= [
            'g.classify_id'    =>$this->param['classify_id'],
            'a.teacher_id'    =>['in',$this->param['t_id']],
        ];
        $field = [
            "a.teacher_id",//教师id
            "t.nickname",//教师姓名
            "t.name",//教师姓名
            't.photo',
            't.phone',
            't.level',
        ];
        $total = $db->alias('a')->join("teacher_group g","g.id=a.group_id")->join("teacher t","t.id=a.teacher_id")->where($where)->count();
        $model = $db->alias('a')->field($field)->join("teacher_group g","g.id=a.group_id")->join("teacher t","t.id=a.teacher_id");

        $data  = api_page($model,$where,"", "",$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);

    }

    /**
     * 通讯录教师
     */
    public function teacherData(){
        if(!$this->param['group_id']) return ajax("缺少分组id",2);
        $group_id = $this->param['group_id'];
        $db   = db('teacher_group_record');
        $where= [
            'a.group_id'    =>$group_id,
        ];
        $field = [
            "a.teacher_id",//教师id
            "t.name",//教师姓名
            't.photo',
            't.phone'
        ];
        $total = $db->alias('a')->join("teacher t","t.id=a.teacher_id")->where($where)->count();
        $model = $db->alias('a')->field($field)->join("teacher t","t.id=a.teacher_id");

        $data  = api_page($model,$where,"", "",$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 我的群组
     * @return \think\response\Json
     */
    public function MyGroup(){
        if(!$this->param['type']) return ajax("缺少分类id",2);
        $ClassUser=new ClassUser();
        $field=array("c.id","c.name");
        $where=['u.uid'=>$this->user['uid'],'c.enterprise_id'=>0,'c.classify_id'=>$this->param['type']];
        $model=$ClassUser->alias('u')->field($field)->join('class c','c.id=u.class_id','left')->where($where);
        $total=$model->count();
        $model=$ClassUser->alias('u')->field($field)->join('class c','c.id=u.class_id','left')->where($where);
        $data  = api_page($model,"","u.created_at desc", "",$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 群组详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function GroupDetails(){
        if(!$this->param['id']) return ajax("缺少id",2);
        $Studys= new Studys();
        $ClassUser= new ClassUser();
        $ClassCourse= new ClassCourse();
        $teacherid=$ClassCourse->getAll(['class_id'=>$this->param['id']]);
        $datastudys=$Studys->getOne(['id'=>$this->param['id']]);
        $teacherid=$this->array_convert($teacherid,'teacher_id','teacher_id');
        $teacherid[]=$datastudys['teacher_id'];
        $data=$ClassUser->UserList(['c.class_id'=>$this->param['id']],$teacherid,$datastudys['teacher_id']);
        return ajax('获取成功', 1,['data'=>$data,'count'=>count($data),'name'=>$datastudys['name'],'capacity'=>$datastudys['number']]);
    }

}