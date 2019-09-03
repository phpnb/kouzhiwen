<?php
/**
 * [知识库]
 * @Author: Careless
 * @Email:  965994533@qq.com
 * @Date:   2018-08-24 17:18:08
 * @Copyright:
 */
namespace app\admin\root\controller;
use app\common\model\Questions as model;
use app\admin\root\model\UserJgpush;
use app\common\model\UserNotice;
use app\common\extend\JGPush;
use app\admin\info\model\User;
use app\admin\root\controller\Notice;
use app\common\model\Charts;

class Science extends Common{


    /**
     * [index 列表]
     */
    public function index(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =['e_id'=>$this->user['enterprise_id'],'science'=>2];
        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $model = $model->alias('r')->join('user u','r.u_id=u.uid','left');
        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }

    /**
     * [add 添加数据]
     */
    public function add(){
        // 搜索关键词
        $keywords = input('get.keywords');
        //实例化模型
        $model = new model;
        $where =['e_id'=>$this->user['enterprise_id'],'science'=>1];
        if (!empty($keywords)) {
            $where['contents'] = ['like', "%{$keywords}%"];
        }
        // 获取数据
        $model = $model->alias('r')->join('user u','r.u_id=u.uid','left');
        $data  = admin_page($model, $where);
        return view('', [
            'enterprise_id'  => $this->user['enterprise_id'],
            'data'      => $data['data'],
            'page'      => $data['page'],
        ]);
    }

    /**
     * 查看
     */
    public function edit(){
        // 搜索关键词
        $keywords = input('get.keywords');
        $id = $this -> param['id'];
        //实例化模型
        $model = new model;
        $where =['e_id'=>$this->user['enterprise_id'],'id'=>$id];
        // 获取数据
        $model = $model->alias('r')->join('user u','r.u_id=u.uid','left');
        $data  = admin_page($model, $where);
        // 模板
        return view('',[
            'data'      => $data['data'],
            'page'      => $data['page'],
            'keywords'  => $keywords,
        ]);
    }

    /**
     * [del 删除]
     */
    public function del(){
        // 实例化模型
        $model = new model;
        if (!$this -> isPost) return ajax('非法请求');
        // 定义条件
        $id = $this -> param['id'];
        // 可批量删除
        $where['id'] = ['in', $id];
        if (!$model -> editData($where,['science' => 1])) return ajax('删除失败');
        $this->AddLog('删除资讯'.$id);
        return ajax('删除成功');
    }

    /**
     * [del 添加知识库]
     */
    public function sauta()
    {
        //问题库实例化
        $model = new model;
        $Charts = new Charts;
        $id = $this->param['id'];
        $uid = $this->param['uid'];
        $where = ['id' => $id];
        $user = new User();
        $data=$user->field(['uid','phone'])->where(['uid'=>['in', $uid]])->select()->toArray();
        $uid=$this->array_convert($data,'uid','phone');
        // 修改数据
        if (!$model->editData($where, ['science' => 2])) return ajax('没有数据被修改', 2);
        $JGPush = new JGPush();
        $mag = '问题被列入知识库';
        $res = $JGPush->sendUrgentNotify($uid,$mag,$mag,'all',$id);
        if($res['code']!==200){
            return ajax($res['msg'], 2);
        }
        $Charts->updateRanking($this->param['uid'],'answer_num');
        return ajax('保存成功');
    }








}