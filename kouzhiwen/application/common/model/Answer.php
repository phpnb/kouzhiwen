<?php
/**
 * [����ģ��]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2017-06-20 09:37:12
 * @Copyright:
 */

namespace app\common\model;

use think\Validate;

class Answer extends CommonModel
{
    public function addDataOne($one=[]){
        $id = $this->insert($one);
        if(!$id) return false;
        //增加文章评论量
        $questions = new Questions();
        $rs = $questions->where(['id'=>$one['qid']])->setInc('comment_num');
        return $rs;
    }

}