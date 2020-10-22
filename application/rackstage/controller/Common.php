<?php

namespace app\rackstage\controller;

use think\Controller;
use think\Db;
use think\Session;

class Common extends Controller
{
    public $role;
    public $role_title;
    public $user_id;
    public $department;
    public $user_name;
    public $jurisdiction; //权限
    public $in_time;
    public $project_title;

    public function __construct()
    {
        {
            parent::__construct();
        }
        if (request()->controller() !== "Login") self::check_login();
        $session = session('');
        $this->in_time = in_time();
        if (!empty($session['user_id'])) {
            $this->user_id = $session['user_id'];
            $this->role_title = $session['role_title'];
            $this->role = $session['role'];
            $this->department = $session['department'];
            $this->user_name = $session['user_name'];

            switch ($this->role_title) {
                case '总管理员':
                case '数据收集（胡月）':
                    $this->jurisdiction = 1;
                    break;
                case '项目经理':
                    $this->jurisdiction = 2;
                    break;
                case '项目策划':
                    $this->jurisdiction = 3;
                    break;
                case '置业顾问':
                    $this->jurisdiction = 4;
                    break;
                case '项目文员':
                    $this->jurisdiction = 5;
                    break;
                case '部门总监':
                    $this->jurisdiction = 6;
                    break;
                case '部门秘书':
                    $this->jurisdiction = 7;
                    break;
                case '事业部秘书':
                    $this->jurisdiction = 8;
                    break;
            }
        }
        $head_img = Db::name('user')->where('id', session::get('user_id'))->value('head_img');
        $this->assign('head_img', $head_img == null ? 'http://t.cn/RCzsdCq' : $head_img);
        $this->assign('user_name', session::get('user_name'));
        $this->assign('lists', self::role());
    }

    /*
     * 检查登录
     * */
    private function check_login()
    {
        $user = Session::get('user_name');
        if ("" == $user) {
            $this->redirect('/rackstage/Login/login');
        }
    }

    /*
     * 操作日志
     * */
    public function get_user_operation($id = "")
    {
        /* $dateArr = array();
        $dateArr['user_id'] = session::get('user_id');
        $dateArr['user_name'] = session::get('user_name');
        $dateArr['create_time'] = date('Y-m-d H:i:s',time());
        $dateArr['controllers'] = request()->controller()."/".request()->action();
        $dateArr['edit_id'] = request()->controller()."/".request()->action();
        Db::name('logs')->insert($dateArr);*/
    }

    public function role()
    {
        $r_id = session::get('role');
        $datArr = explode(',', Db::name('role')->where('id', $r_id)->value('role_cate'));
        $cateArr = Db::name('cate')->field('id,pid,title,cont,act,icon,orderby')->where(['pid'=>0,'status'=>1])->order('orderby desc,id asc')->select();
        $arr = [];
        $Arr = [];
        foreach ($cateArr as $key => $val) {
            if (in_array($val['id'], $datArr)) {
                $Arr[] = $val;
            }
        }
        foreach ($Arr as $key => $val) {
            $sonArr = Db::name('cate')->field('id,pid,title,cont,act,icon,orderby')->where(['pid'=>$val['id'],'status'=>1] )->order('orderby desc,id asc')->select();
            if (!empty($sonArr)) {
                foreach ($sonArr as $k => $v) {
                    if (in_array($v['id'], $datArr)) {
                        $arr[] = $v;
                    }
                }
                $Arr[$key]['son'] = $arr;
                $arr = [];
            }
        }

        return $Arr;
    }

    public function cates()
    {
        $cateArr = Db::name('cate')->where('pid', '0')->order('orderby desc,id asc')->select();

        foreach ($cateArr as $key => $val) {
            $sonArr = Db::name('cate')->field('id,pid,title,cont,act,icon')->where(['pid'=>$val['id'],'status'=>1])->order('orderby desc,id asc')->select();
            if (!empty($sonArr)) {

                $cateArr[$key]['son'] = $sonArr;
            }
        }
        //var_dump($cateArr);
        $this->assign('list', $cateArr);
        return $this->fetch();
    }

    public function edit_cate()
    {
        $where['id'] = $_REQUEST['id'];
        if (empty($_REQUEST['add'])) {
            $cate = Db::name('cate')->where($where)->order('orderby desc,id asc')->find();
            $this->assign('cate', $cate);
            //var_dump($cate);
            return $this->fetch();
        } else {
            unset($_POST['add']);
            if (empty($_POST['id'])) {
                unset($_POST['id']);
                Db::name('cate')->insert($_POST);
                //Db::name('cate')->getLastsql();

            } else {
                $info = Db::name('cate')->update($_POST);
                var_dump($info);
            }
            $this->redirect('/rackstage/common/cates');
        }
    }

    public function checklist()
    {
        $list = Db::name('sales__department')->select();
        foreach ($list as $key => $val) {
            $where['contract_num'] = $val['contract_num'];
            $task_this = Db::name('task_list')->where($where)->find();
            if (!empty($task_this)) {
                if ($task_this['is_mould'] != $val['is_mould']) {
                    $data['is_mould'] = $task_this['is_mould'];

                    $info = Db::name('sales__department')->where('id', $val['id'])->update($data);
                    if ($info)
                        var_dump('修改成功'); //exit;
                }
                //exit;
            }
            //var_dump();
            var_dump('匹配成功');
        }
    }

    function qrcode($url = "", $filename = '', $level = 3, $size = 4)
    {
        Vendor('phpqrcode.phpqrcode');
        //容错级别  
        $errorCorrectionLevel = intval($level);
        //生成图片大小  
        $matrixPointSize = intval($size);
        //生成二维码图片  
        $object = new \QRcode();

        //第二个参数false的意思是不生成图片文件，如果你写上‘picture.png’则会在根目录下生成一个png格式的图片文件  
        $object::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2, '/');
        //var_dump($info);//exit;
        //return $object->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}

