<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-20
 * Time: 上午10:04
 */


namespace app\api\discover\controller;
use app\api\common\controller\Api;
use app\common\model\Comment as model;
use app\common\model\Information;
use app\common\model\TeacherArticle;
use app\common\model\UserRanking;
use app\common\model\Questions;

class Comment extends Api{

    /**
     * 获取评论列表
     */
    public function datalist(){
        if(!$this->param['type']) return ajax("缺少评论类型",2);
        if(!$this->param['type_id']) return ajax("缺少关联id",2);

        $CommentModle = new model();
        $model = $CommentModle->getDataList($this->param,$this->user['uid']);
        $total = $model->count();
        //tp5.0会清空上一次的查询条件
        $model =  $CommentModle->getDataList($this->param,$this->user['uid']);
        $data  = api_page($model,'','', '',$total);

        foreach ($data['data'] as $k=>$v){
            $data['data'][$k]['contents'] = base64_decode($v['contents']);
        }

        if($this->param['type'] == '5'){
            $questions = new Questions();
            $comment_num = $questions->where(['id'=>$this->param['type_id']])->field('comment_num')->select()->toArray();
            $data['comment_num'] = $comment_num[0]['comment_num'];
        }
        if(!$data['data']) return ajax('已是全部数据', 1, $data);
        return ajax('获取成功', 1, $data);
    }

    /**
     * 添加评论
     */
    public function add(){
        if($this->user['allot']!=2){
            $msg=$this->user['allot']==1?"因你还未通过后台的审核；所以不能发表评论":"因你没有通过后台的审核；所以不能发表评论";
            return ajax($msg, 2);
        }
        if(!$this->param['type']) return ajax("缺少评论类型",2);
        if(!$this->param['type_id']) return ajax("缺少关联id",2);
        if(!$this->param['contents']) return ajax("请输入评论内容",2);
        if(empty($this->param['enterprise_id']))$this->param['enterprise_id']=$this->user['enterprise_id'];

        $CommentModel = new model();
        $this->param['contents']=$this->keywordReplace($this->param['contents']);
        $data = [
            'enterprise_id'      => $this->param['enterprise_id'],
            'type'      => (int)$this->param['type'],
            'type_id'   => $this->param['type_id'],
            'uid'       => $this->user['uid'],
            'contents'  => base64_encode($this->param['contents'])
        ];

        $id = $CommentModel->addDataOne($data);
        if(!$id) return ajax('评论失败', 2);
        if($this->param['type']==3){
            $TeacherArticleModel  = new TeacherArticle();
            $TeacherArticleModel->where(['id'=>$this->param['type_id']])->setInc('comment_num');
        }else if($this->param['type']==4){
            $InformationModel  = new Information();
            $InformationModel->where(['id'=>$this->param['type_id']])->setInc('comment_num');
        }else if($this->param['type']==5){
            $Questions  = new Questions();
            $Questions->where(['id'=>$this->param['type_id']])->setInc('comment_num');
        }
        $data=$CommentModel->getDataList($this->param,$this->user['uid'])->find()->toArray();
        return ajax('评论成功', 1,$data);
    }

    /**
     * 添加对评论的评论
     */
    public function addComment(){
        if($this->user['allot']!=2){
            $msg=$this->user['allot']==1?"因你还未通过后台的审核；所以不能发表评论":"因你没有通过后台的审核；所以不能发表评论";
            return ajax($msg, 2);
        }
        if(!$this->param['comment_id'])return ajax("请上传评论id",2);
        if(!$this->param['contents']) return ajax("请输入评论内容",2);

        $this->param['contents']=$this->keywordReplace($this->param['contents']);

        $CommentModel = new model();
        $one  = $CommentModel->where(['id'=>$this->param['comment_id']])->find();
        if(!$one) return ajax("评论不存在",2);
        $data = [
            'enterprise_id'      => $one['enterprise_id'],
            'type'      => $one['type'],
            'type_id'   => $one['type_id'],
            'is_reply'  => 0,
            'uid'       => $this->user['uid'],
            'pid'       => $one['id'],
            'be_uid'    => $one['uid'],
            'contents'  => base64_encode($this->param['contents']),
            'add_time'  => time()
        ];
        $id = $CommentModel->insertGetId($data);
        if(!$id) return ajax("评论失败",2);
        //增加当前评论的评论数量
        $rs = $CommentModel->where(['id'=>$this->param['comment_id']])->setInc('comment_num');
        return ajax("评论成功",1);
    }

    /**
     * 回复评论
     */
    public function replyComment(){
        if($this->user['allot']!=2){
            $msg=$this->user['allot']==1?"因你还未通过后台的审核；所以不能发表评论":"因你没有通过后台的审核；所以不能发表评论";
            return ajax($msg, 2);
        }
        if(!$this->param['comment_id'])return ajax("请上传评论id",2);
        if(!$this->param['contents']) return ajax("请输入评论内容",2);
        $this->param['contents']=$this->keywordReplace($this->param['contents']);
        $CommentModel = new model();
        $one  = $CommentModel->where(['id'=>$this->param['comment_id']])->find();
        if(!$one) return ajax("评论不存在",2);
        $data = [
            'enterprise_id'      => $one['enterprise_id'],
            'type'      => $one['type'],
            'type_id'   => $one['type_id'],
            'is_reply'  => 1,
            'uid'       => $this->user['uid'],
            'pid'       => $one['pid'],//主评论的id
            'be_uid'    => $one['uid'],
            'contents'  => base64_encode($this->param['contents']),
            'add_time'  => time()
        ];
        $id = $CommentModel->insertGetId($data);
        if(!$id) return ajax("评论失败",2);
        return ajax("评论成功",1);
    }

    /**
     * 添加和取消评论点赞
     */
    public function setLike(){
        if(!$this->param['comment_id'])return ajax("请上传评论id",2);
        $comment_id = $this->param['comment_id'];
        $CommentModel = new model();
        $one = $CommentModel->where(['id'=>$comment_id])->find();

        if(!$one)return ajax("评论不存在",2);
        $db       = db('comment_like');
        $where    = ['comment_id'=>$comment_id,'uid'=>$this->user['uid']];
        $likeData = $db->where($where)->find();

        if($likeData){
            //点赞过 取消点赞
            $rs = $db->where($where)->delete();
            $CommentModel->where(['id'=>$comment_id])->setDec('like_num');
        }else{

            //未点赞过 添加点赞
            $data = [
                'uid'            => $this->user['uid'],
//                'information_id' => $one['information_id'],
                'comment_id'     => $comment_id,
                'add_time'       => time()
            ];
            $rs = $db->insertGetId($data);
//            if($one['like_num']==9){
//                (new UserRanking)->updateRanking($one['uid'],'green');
//            }

            $CommentModel->where(['id'=>$comment_id])->setInc('like_num');
        }
        if(!$rs) return ajax('操作失败', 2);
        return ajax('操作成功', 1);
    }

    /**
     * 评论详情
     */
    public function details(){
        if(!$this->param['comment_id'])return ajax("请上传评论id",2);
        $CommentModel = new model();
        $data = $CommentModel->getDetails($this->param['comment_id'],$this->user['uid']);
        if(!$data) return ajax('无数据', 2);
        return ajax('获取成功', 1 ,$data);
    }

}