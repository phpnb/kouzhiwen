<?php
/**
 * [公司资讯和平台文章]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-17
 * Time: 下午3:54
 */

namespace app\common\model;
use think\Validate;

class Information extends CommonModel{

    /**
     * @param array $param=[
     *  'classify_id'=>'feng类id',
     *  'keywords'=>'搜索',
     *  'enterprise_id'=>"对应公司id",默认平台0
     * ]
     */
    public function getDataList($param=[]){
        $where = [
            'status'=>1,
            'enterprise_id'=>$param['enterprise_id'],
        ];
        if(!empty($param['classify_id'])){
            //分类
            $where['classify_id'] = $param['classify_id'];
        }
        if(!empty($param['keywords'])){
            //搜索
            $where['keywords'] = ['like',"%".$param['keywords']."%"];
        }
        if($param['power']){
            $where['power'] =0;
        }
        $field = [
            'id','name','cover_img','author','add_time','comment_num','pv','is_recommend'
        ];
        $model = $this->field($field)->where($where)->order("comment_num desc,is_recommend desc,id desc");
        return $model;
    }

    /**
     * @param $id 文章id
     * @param $uid 查看文章的用户uid
     */
    public function getDetails($id,$uid){
        $where = [
            'id'=>$id,
            'status'=>1,
        ];
        $data =  $this->where($where)->find();
        if(!$data) return false;
//        var_dump($data->userCollec()->where(['type'=>3,'uid'=>$uid])->find());die;
        //查询文章下的评论
      //  $InformationComment = new InformationComment();
       // $model = $InformationComment->getDataList($id,$uid);
//        $data['comment']    =  $model->limit(0,3)->select()->toArray();
        $data['collec']    = $data->userCollec()->where(['type'=>3,'uid'=>$uid,'type_id'=>$data['id']])->find()?true:false;
        return $data;
    }

    public function userCollec(){
        return  $this->hasOne('UserCollect','type_id');
    }
}