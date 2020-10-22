<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Management extends Common
{
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    /*
     * 首页
     * */
    public function work()
    {
        if(!empty($_GET['id']))
        {
            if(!empty($_POST['search_field'])){
                $where['username']=array('like','%'.$_POST["search_field"].'%');
            }
            if (!isset($where)){
                $where='1=1';
            }
            $count=Db::name('work')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('work')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach ($list as $key => $val){
                $list[$key]['createtime']=date('Y-m-d',$val['createtime']);
				$list[$key]['lastweek'] =  preg_replace("/\s+/", " ", $val['lastweek']);
				$list[$key]['thisweek'] =  preg_replace("/\s+/", " ", $val['thisweek']);
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch();
    }
   public function workmine()
    {
        if(!empty($_GET['id']))
        {
            if(!empty($_POST['search_field'])){
                $where['username']=array('like','%'.$_POST["search_field"].'%');
            }
            $where['user_id']=$_SESSION['think']['user_id'];
            $count=Db::name('work')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('work')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach ($list as $key => $val){
                $list[$key]['createtime']=date('Y-m-d',$val['createtime']);
				$list[$key]['lastweek'] =  preg_replace("/\s+/", " ", $val['lastweek']);
				$list[$key]['thisweek'] =  preg_replace("/\s+/", " ", $val['thisweek']);
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch();
    }

    /*
     * 角色删除
     * */
    public function work_del()
    {
        if(Db::name('work')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>0,'msg'=>'删除失败');
        }
        return json($info);
    }

    /*
     * 工作提报添加
     * */
    public function work_add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['createtime']=time();

            if(!empty($_POST['id'])){
                if(Db::name('work')->update($_POST))
                {
                    $data['code'] = 1;
                    $data['msg'] = '修改成功';
                }else{
                    $data['code'] = 0;
                    $data['msg']= '修改失败';
                }
            }else{
                $_POST['user_id']=$_SESSION['think']['user_id'];
                $users=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->find();
                if(!empty($users)){
                    $_POST['username']=$users['username'];
                }else{
                    $_POST['username']=Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('user_name');
                }

                if(Db::name('work')->insert($_POST))
                {
                    $data['code'] = 1;
                    $data['msg'] = '添加成功';
                }else{
                    $data['code'] = 0;
                    $data['msg']= '添加失败';
                }
            }
            return json($data);
        }
        if(!empty($_GET['id'])){
            $this->assign('list',Db::name('work')->where('id',$_GET['id'])->find());
        }
        return $this->fetch();
    }
    public function work_see()
    {
        $this->assign('list',Db::name('work')->where('id',$_GET['id'])->find());
        return $this->fetch();
    }
    /*
     * 角色编辑
     * */
    public function edit()
    {
        if (Request::instance()->isPost())
        {
            $data  = explode(",",$_POST['role_cate']);
            $date = Db::name('cate')->where('id','in',$data)
                ->where('status','1')->select();
            foreach($date as $key=>$val)
            {
                $arr[] = $val['title'];
            }
            $_POST['role_cate_title'] = implode(",", $arr);
            //var_dump($_POST);exit;
            $info = Db::name('role')->update($_POST);
            if($info!==false)
            {
                //修改user表中role_title
                Db::name('user')->where('role',$_POST['id'])->update(['role_title'=>$_POST['role_name']]);
                $data['code'] = 1;
                $data['msg'] = '更新成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '更新失败';
            }
            return json($data);
        }else{
            $list = Db::name('role')->where('id',Request::instance()->param('id'))->find();
           $this->assign('id',$list['id']);
            $this->assign('list',$list);
            return $this->fetch('add');
        }
    }
    /*
     * 用户列表
     * */
    public function user()
    {
        if(isset($_GET['id'])){
            if(!isset($_POST['search_field'])){
                $_POST['search_field']='';
            }
            $count=Db::name('user')
                ->where('user_name','like','%'.$_POST['search_field'].'%')
                ->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('user')
                ->where('user_name','like','%'.$_POST['search_field'].'%')
                ->limit($tol,$limit)->order('id desc')->select();
            foreach($list as $key => $val){
                $users=Db::name('users')->where('user_id',$val['id'])->find();
                $list[$key]['username']=$users['username'];
                $list[$key]['work_id']=$users['work_id'];
                $list[$key]['station']=Db::name('posts')->where('id',$users['station'])->value('posts');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    /*
     * 添加用户
     * */
    public function add_user()
    {
        if (Request::instance()->isPost())
        {
            $count=Db::name('user')->where('user_name',$_POST['user']['user_name'])->count();
            if($count>0){
                $data['code'] = 0;
                $data['msg']= '该用户名已被使用，请勿重复添加';
                return json($data);
            }
           $_POST['user']['role_title'] = Db::name('role')->where('id',$_POST['user']['role'])->value('role_name');
           $_POST['user']['pwd'] = md5("pwd_shilian".$_POST['user']['pwd']);
           $insert_id = Db::name('user')->insertGetId($_POST['user']);
            if($insert_id!=0)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
                if(!empty($_POST['users_id'])) {
                    //用户添加成功，开始关联users表
                    $arr = explode('--', $_POST['users_id']);
                    $where['username'] = $arr[0];
                    $where['work_id'] = $arr[1];
                    $info = Db::name('users')->where($where)->update(['user_id' => $insert_id]);
                    if ($info) {
                        $data['code'] = 1;
                        $data['msg'] = '添加成功，并成功关联员工数据';
                    } else {
                        $data['code'] = 0;
                        $data['msg'] = '添加用户成功，但关联员工失败';
                    }
                }
			}else{
                $data['code'] = 0;
                $data['msg']= '添加用户失败';
            }
            return json($data);
        }else {
            $date = Db::name('role')->where('status', 1)->select();
            $this->assign('role', $date);

            $this->assign('users',Db::name('users')->where('del','-1')->where('user_id','')->select());
            return $this->fetch();
        }
    }
    /*
     * 修改用户
     * */
    public function edit_user()
    {
        if (Request::instance()->isPost())
        {
            $_POST['user']['role_title']= Db::name('role')->where('id',$_POST['user']['role'])->value('role_name');
            $infouser = Db::name('user')->update($_POST['user']);
            if($infouser!==false)
            {
                $data['code'] = 1;
                $data['msg'] = '更新成功';
                if(!empty($_POST['users_id'])){
                    //用户添加成功，开始关联users表
                    $arr=explode('--',$_POST['users_id']);
                    $where['username']=$arr[0];
                    $where['work_id']=$arr[1];
                    $info=Db::name('users')->where($where)->update(['user_id'=>$_POST['user']['id']]);
                    if($info!==false){
                        $data['code'] = 1;
                        $data['msg'] = '修改成功，并成功关联员工数据';
                    }else{
                        $data['code'] = 0;
                        $data['msg']= '修改用户成功，但关联员工失败';
                    }
                }
            }else{
                $data['code'] = 0;
                $data['msg']= '更新用户失败';
            }
            return json($data);
        }else{
            $date = Db::name('role')->where('status', 1)->select();
            $this->assign('role', $date);
            $list = Db::name('user')->where('id',$_REQUEST['id'])->find();
            $station=Db::name('users')->where('user_id',$list['id'])->value('station');
            //var_dump(Db::name('posts')->where('id',$station)->value('posts'));
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'){
                $department=Db::name('framework')
                    ->where('pid',Db::name('users')->where('user_id',$list['id'])->value('region'))
                    ->select();
                $this->assign('department',$department);
            }

            $list['username']=Db::name('users')->where('user_id',$list['id'])->value('username');
            $list['work_id']=Db::name('users')->where('user_id',$list['id'])->value('work_id');
            $this->assign('list',$list);
            $this->assign('users',Db::name('users')->where('del','-1')->where('user_id','')->select());
            return $this->fetch('add_user');
        }


    }
    /*
     * 修改用户状态
     * */
    public function edit_user_status()
    {
        $_POST['status'] = -$_POST['status'];
        Db::startTrans();
        try{
            Db::name('user')->where('id',$_POST['id'])->update(['status'=>$_POST['status']]);
            Db::commit();
            $info = array('msg'=>1,'info'=>'状态修改成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'状态修改失败，请联系技术人员支持');
        }
        return json($info);
    }
    /*
    * 用户删除
    * */
    public function del_user()
    {
        if(Db::name('user')->where('id='.input('id'))->delete()&&Db::name('users')->where('user_id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }

    /*
     * 登录日志
     * */
    public function logs()
    {
        if(isset($_GET['id']))
        {
            $count=Db::name('log')->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('log')->order('id desc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    /*
    * 角色删除
    * */
    public function del_log()
    {
        if(Db::name('log')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    /*
     * 公告列表
     * */
    public function article()
    {
        if(isset($_GET['id']))
        {
            $count=Db::name('article')->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('article')->order('id desc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    /*
     * 推荐到首页
     * */
    public function is_status()
    {
        $_POST['status'] = -$_POST['status'];
        Db::startTrans();
        try{
            Db::name('article')->where('id',$_POST['id'])->update(['status'=>$_POST['status']]);
            Db::commit();
            $info = array('msg'=>1,'info'=>'操作成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'启用失败，请联系技术人员支持');
        }
        return json($info);
    }
    /*
     * 添加公告
     * */
    public function article_add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['createtime']=date('Y-m-d',time());
            $_POST['content']=str_replace("&nbsp;","&amp;nbsp;",$_POST['content']);
            $info = Db::name('article')->insert($_POST);
            if($info!=0)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $this->assign('role',Db::name('role')->field('id,role_name')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());

            return  $this->fetch();
        }
    }
    /*
    * 修改用户
    * */
    public function article_edit()
    {
        if (Request::instance()->isPost())
        {
            $_POST['content']=str_replace("&nbsp;","&amp;nbsp;",$_POST['content']);
            $info = Db::name('article')->update($_POST);
            if($info!==false)
            {
                $data['code'] = 1;
                $data['msg'] = '更新成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '更新失败';
            }
            return json($data);
        }else{
            $this->assign('role',Db::name('role')->field('id,role_name')->select());
            $list = Db::name('article')->where('id',Request::instance()->param('id'))->find();
            //$list['role_cate'] = explode(",",$list['role_cate']);
            $this->assign('list',$list);
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
            return $this->fetch('article_add');
        }
    }
    /*
     * 删除公告
     * */
    public function article_del()
    {
        if(Db::name('article')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'info'=>'删除成功');
        }else{
            $info = array('code'=>2,'info'=>'删除失败');
        }
        return json($info);
    }

    /*
  * 采购列表
  * */
    public function show_article()
    {
        if(isset($_GET['id']))
        {if(Request::instance()->isAjax())
        {
            $val = '%'.input('title').'%';
            $where['title'] = array('like',$val);
            $where['role_cate'] = array('like','%'.session::get('role').'%');

        }else{
            $where['role_cate'] = array('like',session::get('role'));
        }
            $count=Db::name('article')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('article')->where($where)->order('id desc')->limit($tol,$limit)->select();

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    /*
     * 查看
    * */
    public function detail()
    {

            $this->assign('list',Db::name('article')->where('id',Request::instance()->param('id'))->find());
            return $this->fetch();

    }
}
