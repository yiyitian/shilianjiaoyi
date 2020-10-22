<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;

class Common extends Controller
{
    public function __construct(){
        {
            parent::__construct();
        }
        if(request()->controller()!=="Login")self::check_login();
    }
   
    /*
     * 检查登录
     * */
    private function check_login()
    {
        $user = Session::get('username');
       
        if(""==$user)
        {
            Session::set('REQUEST_URI',$_SERVER['REQUEST_URI']);
            $this->redirect('/index/Login/login');
        }
    }
    /*
     * 操作日志
     * */
    public function get_user_operation($id="")
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
        $datArr = explode(',',Db::name('role')->where('id',$r_id)->value('role_cate'));
        $cateArr = Db::name('cate')->field('id,pid,title,cont,act')->where('pid','0')->order('id asc')->select();
        $arr = []; $Arr=[];
        foreach($cateArr as $key=>$val)
        {
            if(in_array($val['id'],$datArr))
            {
                $Arr[] = $val;
            }
        }
        foreach($Arr as $key=>$val)
        {
            $sonArr = Db::name('cate')->field('id,pid,title,cont,act')->where('pid',$val['id'])->order('id asc')->select();
            if(!empty($sonArr))
            {
                foreach($sonArr as $k=>$v)
                {
                    if(in_array($v['id'],$datArr))
                    {
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
        $cateArr=Db::name('cate')->where('pid','0')->order('orderby desc,id asc')->select();

        foreach($cateArr as $key=>$val)
        {
            $sonArr = Db::name('cate')->field('id,pid,title,cont,act')->where('pid',$val['id'])->order('orderby desc,id asc')->select();
            if(!empty($sonArr))
            {

                $cateArr[$key]['son'] = $sonArr;

            }
        }
        //var_dump($cateArr);
        $this->assign('list',$cateArr);
        return $this->fetch();
    }

    public function edit_cate()
    {
        $where['id']=$_REQUEST['id'];
        if(empty($_REQUEST['add'])){
            $cate=Db::name('cate')->where($where)->order('orderby desc,id asc')->find();
            $this->assign('cate',$cate);
            //var_dump($cate);
            return $this->fetch();
        }else{
            unset($_POST['add']);
            if(empty($_POST['id'])){
                unset($_POST['id']);
                Db::name('cate')->insert($_POST);
                //Db::name('cate')->getLastsql();

            }else{
                $info=Db::name('cate')->update($_POST);
                var_dump($info);
            }
            $this->redirect('/rackstage/common/cates');

        }




    }

    public function checklist()
    {
        $list=Db::name('sales__department')->select();
        foreach($list as $key => $val){
            $where['contract_num']=$val['contract_num'];
            $task_this=Db::name('task_list')->where($where)->find();
            if(!empty($task_this)){
                if($task_this['is_mould']!=$val['is_mould']){
                    $data['is_mould']=$task_this['is_mould'];

                    $info=Db::name('sales__department')->where('id', $val['id'])->update($data);
                    if($info)
                        var_dump('修改成功');//exit;
                }
                //exit;
            }
            //var_dump();
            var_dump('匹配成功');

        }
    }
}