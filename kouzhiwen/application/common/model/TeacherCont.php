<?php
/**
 * [��ʦ����ģ��]
 * Created by PhpStorm.
 * User: admin
 * Date: 18-7-18
 * Time: ����4:32
 */
namespace app\common\model;
use think\Validate;

class TeacherCont extends CommonModel{

    public $err;
    public $data;
    public $pk = 'id';

    /**
     * [checkData ��֤����]
     */
    public function checkData($data, $noverify = []){
        // ��֤����
        $rule = [
            'enterprise_id' => 'require|number',
            'teacher_id' => 'require|number',
//            'cover_img' => 'require',
            'name' => 'require',
            'contents' => 'require',
            'add_time' => 'require',
        ];

        // ȥ������Ҫ��֤���ֶ�
        if (!empty($noverify)) {
            foreach ($noverify as $v) {
                unset($rule[$v]);
            }
        }

        // ������ʾ
        $message = [
            'enterprise_id.require' => '����д��ҵ����',
            'enterprise_id.number' => '����д��ҵ����',
            'teacher_id.require' => '����д��ʦ',
            'teacher_id.number' => '����д��ȷ�Ľ�ʦ',
//            'cover_img.require' => '���ϴ�ͼƬ',
            'name.require' => '����д����',
            'contents.require' => '����д����',
            'add_time.require' => '����д���ʱ��',
        ];

        // ������֤
        if (!empty($rule) && !empty($message)) {
            // ������֤����
            $validate = new Validate($rule, $message);
            // ִ����֤
            if (!$validate -> check($data)) {
                // ���������Ϣ
                $this -> err = $validate -> getError();
                return false;
            }
        }

        // ������֤��������
        $this -> data = $data;
        return true;
    }


}