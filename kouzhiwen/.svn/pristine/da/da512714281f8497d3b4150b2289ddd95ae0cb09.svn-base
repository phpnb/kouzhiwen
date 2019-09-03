<?php
namespace app\index\controller;

use app\common\extend\JGPush;
use app\common\extend\Email;

class Index{
    public function index(){
//        $a = include(APP_PATH . 'config.php');
//        $a['has_child_module'][] = 'cms';
//        $b = file_put_contents(APP_PATH . 'config.php',"<?php\n" . 'return ' . var_export($a, true) . ';');

        $fname = APP_PATH . 'config.php';
        $a = file_get_contents($fname);

        preg_match_all('/\'has_child_module(.*?)],/', $a, $c);
        $b = str_replace('],', '', $c[0][0]) . ',\'cms\'],';

        $d = str_replace($c[0][0], $b, $a);
        file_put_contents($fname, $d);
    }

    /**
     * [doc 文档]
     */
    public function doc(){
        return view();
    }

    public function testOne(){
        return view();
    }
}
