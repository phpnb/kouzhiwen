<?php
/**
 * Created by PhpStorm.
 * User: kzw
 * Date: 2019/3/6
 * Time: 16:34
 */

namespace app\common\model;


class CourseTime extends CommonModel
{
    
    public function saveCode($data){
        $sql = sql_keyupdate_one($data, 'tpn_course_time');
        return $this -> execute($sql);
    }
}