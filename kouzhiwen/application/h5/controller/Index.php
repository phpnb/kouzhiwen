<?php

namespace app\h5\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{

    public function teacherCont()
    {

        $id = input('param.id');

        $infos = Db::name('teacher_cont')->where('id',$id)->find();

        $this->assign('info',$infos);

        return $this->fetch();
    }




}