<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/4/8
 * Time: 11:06
 */
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Login extends Controller
{
    public function registers()
    {
        if (Request::instance()->isPost())
        {
            $info = input();
            $info["region"] = "14";
            $info["department"] = "19";
            $info["station"] ="13";
            $info["projectname"] ="11";
            $info['createtime'] = time();
            $info['random'] = self::getRandom();
            $info['pass']  = md5($info['random'].$info['pass']);
            $username = Db::name('users')
                ->where('phone',$info['phone'])
                ->find();
            if(null!==$username)return json(['code'=>2,'msg'=>'用户已存在']);
            if(empty($info['work_id']))
            {
                $info['work_id'] = "SD888888";
            }
            if($id = Db::name('users')->insertGetId($info))
            {
                Session::set('username',$info['username']);
                Session::set('userId',$id);
                if(!empty($id)){
                    Session::set('project',Db::name('user')->where('id',$id)->value('role_title'));
                }else{
                    Session::set('project','');
                }
                $return = ['code'=>1,'msg'=>'注册成功'];
            }else{
                $return = ['code'=>2,'msg'=>'注册失败，请联系管理员'];
            }
            return json($return);
        }
        if(!isset($_GET['random'])){
            $this->redirect('/index/Login/login');exit;
        }
        if($_GET['random']!='253562'){
            $this->redirect('/index/Login/login');exit;
        }
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $list =Db::name('project')->order('id desc')->select();
        foreach($list as $k=>$v)
        {
            $department=Db::name('framework')->where('id',$v['framework_id'])->find();
            $region=Db::name('framework')->where('id',$department['pid'])->value('name');
            $list[$k]['department'] = $region.'--'.$department['name'];
        }
        $this->assign('project',$list);
        $classname=Db::name('classinfo')->where('levels','>','1')->select();
        $this->assign('classname',$classname);
        $where['is_teacher']=array('neq','1');
        $where['del']=array('neq','1');
        $this->assign('users',Db::name('users')->where($where)->select());
        return $this->fetch();
    }
    public function register()
    {
		//$this->redirect('/index/Login/login');exit;
        if (Request::instance()->isPost())
        {
            $info = input();
            $info['createtime'] = time();
            $info['random'] = self::getRandom();
            $info['pass']  = md5($info['random'].$info['pass']);
            $username = Db::name('users')
                ->where('username',$info['username'])
                ->whereOr('phone',$info['phone'])
                ->find();
            if(null!==$username)return json(['code'=>2,'msg'=>'用户已存在']);
            //var_dump($_REQUEST);exit;
            if(empty($info['classid']))
            $info['classid']=0;
            $info['outline_id']=0;
            if(empty($info['work_id']))
            {
                $info['work_id'] = "SD888888";
            }
            if($id = Db::name('users')->insertGetId($info))
            {
                Session::set('username',$info['username']);
                Session::set('userId',$id);
                if(!empty($id)){
                    Session::set('project',Db::name('user')->where('id',$id)->value('role_title'));
                }else{
                    Session::set('project','');
                }
                $return = ['code'=>1,'msg'=>'注册成功'];
            }else{
                $return = ['code'=>2,'msg'=>'注册失败，请联系管理员'];
            }
            return json($return);
        }
		if(!isset($_GET['random'])){
			$this->redirect('/index/Login/login');exit;
		}
		if($_GET['random']!='253562'){
			$this->redirect('/index/Login/login');exit;
		}
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $list =Db::name('project')->order('id desc')->select();
        foreach($list as $k=>$v)
        {
            $department=Db::name('framework')->where('id',$v['framework_id'])->find();
            $region=Db::name('framework')->where('id',$department['pid'])->value('name');
            $list[$k]['department'] = $region.'--'.$department['name'];
        }
        $this->assign('project',$list);
        $classname=Db::name('classinfo')->where('levels','>','1')->select();
        //var_dump($classname);
        $this->assign('classname',$classname);
        $where['is_teacher']=array('neq','1');
        $where['del']=array('neq','1');
        $this->assign('users',Db::name('users')->where($where)->select());
        return $this->fetch();
    }
    /*
     * 添加线下课程
     * */
    public function class_add()
    {
        if($this->request->isPost()){
            //var_dump($_POST);exit;
            if($_POST['classes']=='all'){
                if(!empty($_POST['classtype'])){
                    $where['pid']=$_POST['classtype'];
                    unset($_POST['classtype']);
                }

                if(!isset($where))
                    $where['levels']='1';
                $id_list=Db::name('classinfo')->where($where)->select();
                foreach ($id_list as $key =>$val){
                    $arr[]=$val['id'];
                }
                $_POST['classes']=implode(",", $arr);
            }else if(empty($_POST['classes'])){
                $data['code'] = 0;
                $data['msg']= '所选课程为空';
                return json($data);
            }
            $data['code'] = 1;
            $data['msg']= $_POST['classes'];
            return json($data);
        }
      
        
        $classArr=Db::name('classinfo')->where('id','in','1,2,3,125')->order('orderby desc,id asc')->select();
        $this->assign('classArr',$classArr);

        return $this->fetch();
    }
    public function class_lists(){
        if(!empty($_GET['id']))
        {
            $classid=Db::name('users')->where('id',Session::get('userId'))->value('classid');
            $list=Db::name('classinfo')
                ->where('id','in',$classid)
                ->order('orderby desc,id asc')->select();
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
        }
        if(isset($_GET['list'])){
            //var_dump($_REQUEST);exit;
            $list=Db::name('classinfo')->where('pid',$_GET['classtype'])->select();


            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
        }
$ddd = array();
         $id = db::name('classinfo')->field('id')->where('pid','125')->where('is',1)->select();
        foreach($id as $k)
        {
            $ddd[] = $k['id'];
        }
        $ddd[] = 1;$ddd[] = 2;$ddd[] = 3;
        
        $list =Db::name('classinfo')->where('pid','in',$ddd)->where('is',1)->order('id asc')->select();

        return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
    }

    static private function getRandom($length=6)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $string  = '';
        for($i = 0; $i < $length; $i ++) {
            $string .= $pattern {mt_rand ( 0, 61 )}; //生成php随机数
        }
        return $string;
    }

    public function login()
    {
        if (Request::instance()->isPost())
        {
            $info = Db::name('users')->where('username',input('username'))->find();
            if(null==$info)return json(['code'=>2,'msg'=>'用户名不存在']);
            if(md5($info['random'].input('pass'))!==$info['pass'])return json(['code'=>2,'msg'=>'密码不正确']);
            Session::set('username',$info['username']);
            Session::set('userId',$info['id']);
            if(!empty($info['user_id'])){
                Session::set('project',Db::name('user')->where('id',$info['user_id'])->value('role_title'));
            }else{
                Session::set('project','');
            }
			
			if(isset($_SESSION['think']['REQUEST_URI'])){
                $data['url']=Session::get('REQUEST_URI');
                Session::delete('REQUEST_URI');
            }
			$data['code']=1;
			$data['msg']='登录成功';
			
            return json($data);
        }
        return $this->fetch();
    }

    public function tests()
    {
        $files = fopen("new_file.txt", "w") or die("Unable to open file!");
        $txt = "Bill Gates\n";
        fwrite($files, $txt);
        $txt = "Steve Jobs\n";
        fwrite($files, $txt);
        fclose($files);
    }
    /*
     * 获取分类下分类
     * */
    public function getCate()
    {
        $data['framework']=Db::name('framework')->where('pid',input('pid'))->select();
        $post_pid=Db::name('framework')->where('id',input('pid'))->value('type');

        $data['post']=Db::name('posts')->where('pid',$post_pid)->select();
        return json($data);
    }
    /*
     * 获取项目
     * */
    public function getProject()
    {
        return json(Db::name('project')->where('framework_id',input('pid'))->select());
    }
    /*
 * 登出
 * */
    public function login_out()
    {
        session::set('username',null);
        $this->redirect('/index/Login/login');
    }

    public function update()
    {
        if (Request::instance()->isPost())
        {
            $info = Db::name('users')->where('id',session('userId'))->update(['classid'=>input('classid')]);
            $userInfo = db::name('users')->field('id as uid,username,region,department,station,projectname,classid')->where('id',session('userId'))->find();
            foreach(explode(',', $userInfo['classid']) as $key => $val) {
                $times = db::name('notice')->where('classify', $val)->where("find_in_set(" . $userInfo['uid'] . ",usersid)")->order('inputtime desc')->value('times');
                if ($times !== null) {
                    $info = db::name('outline')->field('username as headmaster,startdate,enddate,times,classify as classtype')->where(['times' => $times, 'del' => -1])->find();
                    if ($info !== null) {
                        unset($userInfo['classid']);
                        $v['branch'] = '100';
                        $data[] = $v + $info;
                    }
                }
            }
            db::Name('question_an')->insertAll($data);
            $data['code']=1;
            $data['msg']='修改成功';
            return json($data);
        }
        return $this->fetch();
    }

    public function getList()
    {
        return json(Db::name('classinfo')->where('pid',input('id'))->where('is',1)->select());
    }

    public function tests111()
    {
        return $this->fetch('tests');
    }
}

