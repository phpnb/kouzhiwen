<?php
/**
 * [发现 文章]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-17
 * Time: 下午2:52
 */
namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\model\Information;
use app\common\model\Banner;
use app\common\model\InformationComment;
use app\common\model\InformationClassify;
use app\common\model\Classify;
use app\common\model\ClassifyUser;
use app\common\model\Advertisements;
use app\common\model\Order;

class Article extends Api{

    public function InformationClassify(){
        if(empty($this->param['enterprise_id'])) return ajax("请传企业id",2);
        $Classifymodel=new Classify();
        $type=$Classifymodel->getAll(['enterprise_id'=>$this->param['enterprise_id']]);
        $type=empty($type)?[]:$type;
        $BannerModel = new Banner();
        $banner= $BannerModel->getAll(['status'=>1,'type'=>2,'enterprise_id'=>$this->param['enterprise_id']]);

        return ajax("获取成功",1,['type'=>$type,'banner'=>$banner]);
    }

    /**
     * 获取广告图
     * @return \think\response\Json
     */
    public function advertisements(){
        $Advertisements=new Advertisements();
        $data=$Advertisements->getAll();
        return ajax("获取成功",1,$data);
    }

    /**
     * 广告详情
     * @return \think\response\Json
     */
    public function AdvertisementsDetails(){
        if (!$this->param['id']) return ajax('非法请求', 2);
        $Advertisements=new Advertisements();
        $Order=new Order();
        $data=$Advertisements->getOne(['id'=>$this->param['id']]);
        $res=$Order->getOne(['type'=>6,'type_id'=>$this->param['id'],'uid'=>$this->user['uid'],'pay_status'=>2]);
        $data['enroll']=false;
        if(!empty($res))$data['enroll']=true;
        return ajax("获取成功",1,$data);
    }

    /**
     * 平台分类
     * @return \think\response\Json
     */
    public function UserClassify(){
        $Classifyusermode=new ClassifyUser();
        $data=$Classifyusermode->UserType(['c.id','c.name'],['u.uid'=>$this->user['uid']],'u.weight ASC');
        //没有就就显示全部
//        if(empty($data)){
//            $Classifymode=new Classify();
//            $data=$Classifymode->getAll(['enterprise_id'=>0]);
//        }
        return ajax("获取成功",1,$data);
    }

    /**
     * 平台分类
     */
    public function classify(){
        $Classifymode=new Classify();
        $Classifyusermode=new ClassifyUser();
        $usertype=$Classifyusermode->UserType(['c.id','c.name'],['u.uid'=>$this->user['uid']],'u.weight ASC');
        $id=array();
        if(!empty($usertype)){
            foreach ($usertype as $v){
                $id[]=$v['id'];
            }
        }
        $data=$Classifymode->getAll(['enterprise_id'=>0,'id'=>['not in',$id]]);
        if(empty($data))$data=array();
        if(empty($usertype))$usertype=array();
        return ajax("获取成功",1,['data'=>$data,'user'=>$usertype]);
    }

    /***
     * 保持用户分类
     * @return \think\response\Json
     */
    public function ClassifySave(){
        $Classifyusermode=new ClassifyUser();
        $data=array();
        if(!empty($this->param['data'])){
            $arr=explode(",",$this->param['data']);
            foreach ($arr as $key=>$val){
                $data[]=array('uid'=>$this->user['uid'],'classify_id'=>trim($val),'weight'=>$key);
            }
        }
        $Classifyusermode->where(['uid'=>$this->user['uid']])->delete();
        $res=$Classifyusermode->insertAll($data);

        if(!$res && !empty($this->param['data'])) return ajax('保存失败', 2);
        return ajax('保存成功', 1);
    }


    /**
     * C7热点
     */
    public function datalist(){
        if(empty($this->param['enterprise_id'])){
            $this->param['enterprise_id']=0;
        }
        if($this->user['enterprise_id'] !=$this->param['enterprise_id']){
            $this->param['power']=1;
        }
        $InformationModel  = new Information();
        $model = $InformationModel->getDataList($this->param);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $InformationModel->getDataList($this->param);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     *
     * 文章和资讯详情
     */
    public function details(){
        $id = $this->param['id'];
        if(!$id) return ajax("请上传文章id",2);
        $InformationModel  = new Information();
        $this->user['uid'] = $this->user['uid']?$this->user['uid']:0;
        $data = $InformationModel->getDetails($id,$this->user['uid']);
        if(!$data) return ajax('无数据', 2);
        //增加文章浏览量
        $InformationModel->where(['id'=>$id])->setInc('pv');
        return ajax('获取成功', 1, $data);
    }

    /**
     * 加载评论列表
     */
    public function commentList(){
        $id = $this->param['id'];
        if(!$id) return ajax("请上传文章id",2);
        $InformationComment = new InformationComment();
        $model = $InformationComment->getDataList($id,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $InformationComment->getDataList($id,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 评论文章和资讯
     */
    public function comment(){
        $id = $this->param['id'];
        $contents = $this->param['contents'];
        if(!$id) return ajax("请上传文章id",2);
        if(!$contents) return ajax("请上传评论内容",2);
        $data = [
            'uid' => $this->user['uid'],
            'information_id'=>$id,
            'contents'=>$contents
        ];
        $InforationCommentModel = new InformationComment();
        $id = $InforationCommentModel->addDataOne($data);
        if(!$id) return ajax('评论失败', 2);
        return ajax('评论成功', 1);
    }



    /**
     * 添加和取消评论点赞
     */
    public function setLike(){
        if(!$this->param['comment_id'])return ajax("请上传评论id",2);
        $comment_id = $this->param['comment_id'];
        $InforationCommentModel = new InformationComment();
        $one = $InforationCommentModel->where(['id'=>$comment_id])->find();
        if(!$one)return ajax("评论不存在",2);
        $db       = db('information_comment_like');
        $where    = ['comment_id'=>$comment_id,'uid'=>$this->user['uid']];
        $likeData = $db->where($where)->find();
        if($likeData){
            //点赞过 取消点赞
            $rs = $db->where($where)->delete();
            $InforationCommentModel->where(['id'=>$comment_id])->setDec('like_num');
        }else{
            //未点赞过 添加点赞
            $data = [
                'uid'            => $this->user['uid'],
                'information_id' => $one['information_id'],
                'comment_id'     => $comment_id,
                'add_time'       => time()
            ];
            $rs = $db->insertGetId($data);
            $InforationCommentModel->where(['id'=>$comment_id])->setInc('like_num');
        }
        if(!$rs) return ajax('操作失败', 2);
        return ajax('操作成功', 1);
    }
}