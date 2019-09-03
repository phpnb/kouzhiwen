<?php
/**
 * [后台公共管理控制器]
 * @Author: Careless
 * @Date:   2017-04-09 18:08:42
 * @Email:  965994533@qq.com
 * @Copyright:
 */
namespace app\admin\root\controller;
use think\Controller;
use think\Session;
use think\Request;

class Common extends Controller{
    public $user;
    public $param;
    public $isPost;
    public $isAjax;
    public $access;
    public $module;
    
    /**
     * [_initialize 初始化]
     */
    public function _initialize(){
        // 初始化请求数据
        $request = Request::instance();
        $this -> param  = Request::instance() -> param();
        $this -> isPost = Request::instance() -> method() == 'POST' ? true : false;
        $this -> isAjax = Request::instance() -> isAjax();

        // 判断是否登陆
        $user = Session::get('adminUser');
        if (empty($user)){
            // $this -> redirect(url('login/login'));
            $url = url('admin/root/login/login');
            echo "<script>window.parent.location.href='{$url}';</script>";
            die;
        }
        $this -> user = $user;

        // 判断是否有模块的操作权限
        $this -> module = $module = str_replace('\\', '/', $request -> module());

        // 获取当前操作控制和方法
        $controller = underline_to_hump($request -> controller());
        $method     = $request -> action();

        // 获取当前用户权限
        $tmp = db('access_group') -> where(['id'=>['in',$this -> user['group_id']]]) -> select();
        // 保存权限
        $this -> access = $tmp;

        // 获取当前组的权限
        $id = Session::get('gid') ? Session::get('gid') : $tmp[0]['id'];
        foreach ($tmp as $v) {
            if ($v['id'] == $id) {
                $access = json_decode($v['access'], true);
            }
        }

        // 通用权限
        $access['admin/root/Index'] = ['index','welcome'];
        $access['admin/info/User'][] ='export';
        $access['admin/info/User'][] ='signExport';
        $access['admin/root/Notice'][] ='notice';
        $access['admin/finance/Recharge'][] ='recharge';
        $access['admin/course/Paper'][] ='classlist';
        $access['admin/root/Banner'][] ='typelist';
        $access['admin/finance/Recharge'][] ='userlist';
        $access['admin/finance/Recharge'][] ='rechargepay';
        $access['admin/root/Notice'][] ='dataList';
        $access['admin/root/Task']=['index'];
        $access['admin/course/Course'][]='typeList';
        if ($module != 'admin/root') {
            $access[$user['module'] . '/Index'] = ['index','welcome'];
        }
        $access['admin/root/Upload'] = ['upload'];
        // 判断是否有控制器权限
        if (!array_key_exists($module . '/' . $controller, $access)) {
            $this -> _goError();
        }

        // 判断是否有方法权限
        if (!in_array($method, $access[$module . '/' . $controller])){
            $this -> _goError();
        }
    }

    /**
     * 重定向至权限不足
     */
    private function _goError(){
        // 判断是否为异步请求
        if ($this -> isAjax) {
            echo json_encode([
                'status'    => 2,
                'msg'       => '! 您没有权限执行此操作，如需操作，请与管理员联系。'
            ]);die;
        } else {
            // 跳转到权限不足
            $go = url('admin/root/error/access');
            $this -> redirect($go);
        }
    }

    /**
     * 二维数组转一维数组
     * @param $data 数据
     * @param $key 健
     * @param $val 值
     * @return array
     */
    public function array_convert($data,$key,$val){
        $arr=array();
        if(empty($data)){
            return $arr;
        }
        foreach ($data as $k=>$v){
            $arr[$v[$key]]=$v[$val];
        }
        return $arr;
    }

    /**
     * 添加日志
     * @param $content
     * @param $name
     * @param $enterprise_id
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function AddLog($content='',$name='',$enterprise_id=''){
        if(empty($name))$name=$this->user['username'];
        if(empty($enterprise_id))$enterprise_id=$this->user['enterprise_id'];
        $data=array('enterprise_id'=>$enterprise_id,'name'=>$name,'content'=>$content,'updated_at'=>time());

        return db('log')->insert($data);
    }

    /**
     * 导出Excel
     * @param $title 文件名
     * @param $cellName 表头
     * @param $data 数据
     * @param int $topNumber 第几行开始
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function ExcelExport($title,$cellName,$data,$topNumber=1){
        //引入核心文件
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );
        //处理表头
        foreach ($cellName as $k=>$v)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellKey[$k].$topNumber, $v[0]);//设置表头数据
            $objPHPExcel->getActiveSheet()->freezePane($cellKey[$k].($topNumber+1));//冻结窗口
            $objPHPExcel->getActiveSheet()->getStyle($cellKey[$k].$topNumber)->getFont()->setBold(true);//设置是否加粗
            $objPHPExcel->getActiveSheet()->getStyle($cellKey[$k].$topNumber)->getAlignment()->setVertical('center');//垂直居中
            if($v[1] > 0)//大于0表示需要设置宽度
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension($cellKey[$k])->setWidth($v[1]);//设置列宽度
            }
            $objPHPExcel->getActiveSheet()->getDefaultRowDimension($cellKey[$k])->setRowHeight(30);//所有单元格（行）默认高度
        }

        /*--------------开始从数据库提取信息插入Excel表中------------------*/
        //处理数据
        foreach ($data as $k=>$v)
        {
            foreach ($cellName as $k1=>$v1)
            {
                $text=$v[$v1[2]];
                $objPHPExcel->getActiveSheet()->setCellValue($cellKey[$k1].($k+1+$topNumber), $text);
            }
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->setTitle($title);      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $xlsTitle = iconv('utf-8', 'gb2312', $title);//文件名称
        $title=date("Y-m-d").$title.".xls";
        //导出execl
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=".$title);//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $objWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }

    public function Dug($data,$type=1){
        header("Content-type: text/html; charset=utf-8");
        if($type==1){
            echo "<pre />";
            print_r($data);
        }elseif($type==2){
            var_dump($data);
        }
        die;

    }


}

