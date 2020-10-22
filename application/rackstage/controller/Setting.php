<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Setting extends Common
{
    public function xieyi()
    {
        if (Request::instance()->isPost())
        {
            $data = json_decode(input('data'),true);
            db::name('xieyi')->where('id',1)->update($data);
            return json(['code'=>1,'msg'=>'修改成功']);
        }

        return $this->fetch('xieyi',['list'=>db::name('xieyi')->where('id',1)->find()]);
    }
    public function panAdd()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $titleArr = db::name('framework')->where('id','in',$info['role'])->field('name')->select();
            foreach($titleArr as $k=>$v)
            {
                $data[] = $v['name'];
            }
            $info['department'] = implode(',',$data);
            $info['uid'] = session('user_id');
            $info['uname'] = session('user_name');
            $info['times'] = date('Y-m-d H:i:s',time());
            if(db::name('files')->insert($info))
            {
                $date = ['code'=>1,'msg'=>'创建文件夹成功'];
            }else{
                $date = ['code'=>2,'msg'=>'创建文件夹失败'];
            }
            return json($date);
        }
        return $this->fetch('',['id'=>'-1']);
        
    }
     public function panEdits()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $titleArr = db::name('framework')->where('id','in',$info['role'])->field('name')->select();
            foreach($titleArr as $k=>$v)
            {
                $data[] = $v['name'];
            }
            $info['department'] = implode(',',$data);
            if(db::name('files')->update($info))
            {
                $date = ['code'=>1,'msg'=>'编辑文件夹成功'];
            }else{
                $date = ['code'=>2,'msg'=>'编辑文件夹失败'];
            }
            return json($date);
        }else{
           
            $list = db::Name('files')->where('id',input('id'))->find();
            return $this->fetch('pan_add',['list'=>$list,'id'=>$list['id']]);
        }
        
    }
    public function getDepartments()
    {
        $id = Request::instance()->param('id');
        if($id>0)
        {
            $dateArr = explode(",",Db::name('files')->where('id',$id)->value('role'));
        }else{
            $dateArr = [];
        }
        //$date = Db::query("select id as value,title as title from shilian_cate where pid='0' ");
        $date = Db::name("framework")->where('status','1')->where('cid','in','-1')->where('cid','neq','')->field('id as value,name as title')->order('id asc')->select();
        foreach($date as $key=>$val)
        {
            if(in_array($val['value'],$dateArr))
            {
                $date[$key]['checked'] = true;
            }
            $data =  Db::name("framework")->where('status','1')->where('cid',$val['value'])->where('cid','neq','')->field('id as value,name as title')->order('id desc')->select();
            if(empty($data))
            {
                $date[$key]['data'] = [];
            }else{
                foreach($data as $k=>$v)
                {
                    if(in_array($v['value'],$dateArr))
                    {
                        $data[$k]['checked'] = true;
                    }
                    $data[$k]['data'] = [];
                }
                $date[$key]['data'] = $data;
            }
        }
        return  json_encode($date);
    }
    public function is_status1()
    {
        $_POST['status1'] = -$_POST['status1'];
        Db::startTrans();
        try{
            Db::name('project_article')->where('id',$_POST['id'])->update(['status1'=>$_POST['status1']]);
            Db::commit();
            $info = array('msg'=>1,'info'=>'操作成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'启用失败，请联系技术人员支持');
        }
        return json($info);
    }
    public function project_del()
    {
        if(Db::name('project_article')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    public function log()
    {
        return $this->fetch();
    }
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    /*
     * 首页
     * */
    public function index()
    {
        return $this->fetch();
    }
    /*
     * 角色列表
     * */
    public function lists()
    {
        $count=Db::name('role')->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::name('role')->order('id desc')->limit($tol,$limit)->select();
        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
    }
    /*
     * 角色删除
     * */
    public function del()
    {
        if(Db::name('role')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    /*
     * 启用
     * */
    public function edit_status()
    {
        $_POST['status'] = -$_POST['status'];
        Db::startTrans();
        try{
            Db::name('role')->where('id',$_POST['id'])->update(['status'=>$_POST['status']]);
            Db::commit();
            $info = array('msg'=>1,'info'=>'启用成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'启用失败，请联系技术人员支持');
        }
        return json($info);
    }
    /*
     * 角色添加
     * */
    public function add()
    {
        if (Request::instance()->isPost())
        {
            $data  = explode(",",$_POST['role_cate']);
            $date = Db::name('cate')->where('id','in',$data)->select();
            foreach($date as $key=>$val)
            {
                $arr[] = $val['title'];
            }
            $_POST['role_cate_title'] = implode(",", $arr);
            $info = Db::name('role')->insert($_POST);
            if($info!=0)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else {
            $this->assign('id','-1');
            return $this->fetch();
        }
    }
    public function get_cate()
    {
        $id = Request::instance()->param('id');
        if($id>0)
        {
            $dateArr = explode(",",Db::name('role')->where('id',$id)->value('role_cate'));
        }else{
            $dateArr = [];
        }
        //$date = Db::query("select id as value,title as title from shilian_cate where pid='0' ");
        $date = Db::name("cate")->where('status','1')->where('pid','0')->field('id as value,title as title')->order('id asc,orderby desc')->select();
        foreach($date as $key=>$val)
        {
            if(in_array($val['value'],$dateArr))
            {
                $date[$key]['checked'] = true;
            }
            //$data =  Db::query("select id as value,title as title from shilian_cate where pid='".$val['id']."'");
            $data =  Db::name("cate")->where('status','1')->where('pid',$val['value'])->field('id as value,title as title')->order('orderby desc')->select();
            if(empty($data))
            {
                $date[$key]['data'] = [];
            }else{
                foreach($data as $k=>$v)
                {
                    if(in_array($v['value'],$dateArr))
                    {
                        $data[$k]['checked'] = true;
                    }
                    $data[$k]['data'] = [];
                }
                $date[$key]['data'] = $data;
            }
        }
        return  json_encode($date);
    }

    public function getDepartment()
    {
        $id = Request::instance()->param('id');
        if($id>0)
        {
            $dateArr = explode(",",Db::name('user')->where('id',$id)->value('department'));
        }else{
            $dateArr = [];
        }
        //$date = Db::query("select id as value,title as title from shilian_cate where pid='0' ");
        $date = Db::name("framework")->where('status','1')->where('pid','14')->where('pid','neq','')->field('id as value,name as title')->order('id asc')->select();
        foreach($date as $key=>$val)
        {
            if(in_array($val['value'],$dateArr))
            {
                $date[$key]['checked'] = true;
            }
            $data =  Db::name("framework")->where('status','1')->where('pid',$val['value'])->where('pid','neq','')->field('id as value,name as title')->order('id desc')->select();
            if(empty($data))
            {
                $date[$key]['data'] = [];
            }else{
                foreach($data as $k=>$v)
                {
                    if(in_array($v['value'],$dateArr))
                    {
                        $data[$k]['checked'] = true;
                    }
                    $data[$k]['data'] = [];
                }
                $date[$key]['data'] = $data;
            }
        }
        return  json_encode($date);
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
           $_POST['user']['department'] = $_POST['department'];unset($_POST['department']);
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
            $this->assign('id','-1');

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
            $_POST['user']['department'] = $_POST['department'];unset($_POST['department']);

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
            //if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'){
                $department=Db::name('framework')
                    ->where('pid',Db::name('users')->where('user_id',$list['id'])->value('region'))
                    ->select();
                $this->assign('department',$department);
           // }

            $list['username']=Db::name('users')->where('user_id',$list['id'])->value('username');
            $list['work_id']=Db::name('users')->where('user_id',$list['id'])->value('work_id');
            $this->assign('list',$list);
            $this->assign('id',$list['id']);
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
             if($_SESSION['think']['role_title']=='事业部秘书')
            {
                 $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
                 $where['pid'] = ['eq',$depart];
            }else{
                $where  = '1=1';
            }
            $count=Db::name('article')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('article')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['pname'] = db::name('article_cate')->where('id',$v['pid'])->value('posts');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch('',['type'=>db::name('article_cate')->where('pid',2)->select()]);
        }
    }
    /*
     * 推荐到首页
     * */
    public function is_status()
    {
        $_POST['status1'] = -$_POST['status1'];
        Db::startTrans();
        try{
            Db::name('article')->where('id',$_POST['id'])->update(['status1'=>$_POST['status1']]);
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
        $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');

        if (Request::instance()->isPost())
        {
            if(empty($_POST['department']))
            {
                $department=Db::name('framework')->where('pid','neq','-1')->select();
                foreach ($department as $key=>$val){
                    $department_arr[]=$val['id'];
                }
                $_POST['department']=implode(',',$department_arr);
            }
            if(empty($_POST['station']))
            {
                $station=Db::name('posts')->where('pid','neq','0')->select();
                foreach ($station as $key=>$val){
                    $station_arr[]=$val['id'];
                }
                $_POST['station']=implode(',',$station_arr);
            }
            $_POST['createtime']=date('Y-m-d',time());
            $_POST['content']=str_replace("&nbsp;","&amp;nbsp;",$_POST['content']);
            $_POST['stations'] = $_POST['station'];
            $_POST['username'] = session('user_name');
            $_POST['departments'] =  Db::name('framework')->where('id',$depart)->value('name');
            $_POST['pid'] = $depart;
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
             if($_SESSION['think']['role_title']=='事业部秘书')
             {
                $where['id'] = ['eq',$depart];
             }else{
                $where['pid'] = ['neq','-1'];
             }
            $this->assign('role',Db::name('role')->field('id,role_name')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where($where)->select());
            $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->where('status',1)->order('id asc')->select());
            $this->assign('gangwei',Db::name('posts')->where('pid','eq','0')->where('status',1)->order('id asc')->select());
            $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
            $this->assign('lists',Db::name('article_cate')->where('pid','2')->select());
            return  $this->fetch('',['times'=>date('Y-m-d',time())]);
        }
    }
    /*
    * 修改用户
    * */
    public function article_edit()
    {
        if (Request::instance()->isPost())
        {

            if(empty($_POST['department']))
            {
                $department=Db::name('framework')->where('pid','neq','-1')->select();
                foreach ($department as $key=>$val){
                    $department_arr[]=$val['id'];
                }
                $_POST['department']=implode(',',$department_arr);
            }
            if(empty($_POST['station']))
            {
                $station=Db::name('posts')->where('pid','neq','0')->select();
                foreach ($station as $key=>$val){
                    $station_arr[]=$val['id'];
                }
                $_POST['station']=implode(',',$station_arr);
            }
             if(empty($_POST['stations']))
            {
                $station=Db::name('posts')->where('pid','neq','0')->select();
                foreach ($station as $key=>$val){
                    $station_arr[]=$val['id'];
                }
                $_POST['stations']=implode(',',$station_arr);
            }
            $_POST['content']=str_replace("&nbsp;","&amp;nbsp;",$_POST['content']);
                        $_POST['stations'] = $_POST['station'];

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
            $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
             if($_SESSION['think']['role_title']=='事业部秘书')
             {
                $where['id'] = ['eq',$depart];
             }else{
                $where['pid'] = ['neq','-1'];
             }
            $this->assign('role',Db::name('role')->field('id,role_name')->select());
            $list = Db::name('article')->where('id',Request::instance()->param('id'))->find();
            //$list['role_cate'] = explode(",",$list['role_cate']);
            $this->assign('list',$list);
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where($where)->select());
            $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
            $this->assign('posts',Db::name('posts')->where('pid','neq','0')->select());
            $this->assign('gangwei',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
            $this->assign('lists',Db::name('article_cate')->where('pid','2')->select());
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
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
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

    public function articleDetail()
    {
         $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
             

        if(isset($_GET['cid']))
        {
            if($_SESSION['think']['role_title']=='事业部秘书')
             {
                $where['department'] = ['eq',$depart];
             }else{
                $where= '1=1';
             }
            $info = Db::name('article')->where('id',input('cid'))->value('stations');
            $station = explode(',', $info);
            $lists = Db::name('users')->field('id,username,region,department,station,projectname')->where('del','-1')->where('is_quit','-1')->where('station','in',$station)->where($where)->where('is_quit','-1')->select();
            $posts = $this->getPosts();$framework = $this->getFramework();$project = $this->getProject();$ready = $this->getReady(input('cid'));

            foreach($lists as $k=>$v)
            {
                $lists[$k]['region'] = $framework[$v['region']]['name'];
                $lists[$k]['department'] = $framework[$v['department']]['name'];
                $lists[$k]['station'] = $posts[$v['station']]['posts'];

                if($v['projectname'] !== "0")
                {
                                    $lists[$k]['projectname'] = Db::name('project')->where('id',$v['projectname'])->value('name');
                }else{
                    $lists[$k]['projectname'] = '无';
                }
                if(isset($ready[$v['id']]))
                {
                    $lists[$k]['isReady'] = $ready[$v['id']]['ready'] == 1?'已阅读':'未阅读';
                    $lists[$k]['isdu'] = $ready[$v['id']]['do'] == 1?'已完成':'未完成';
                }else{
                    $lists[$k]['isReady'] = '未阅读';
                    $lists[$k]['isdu'] = '未完成';
                }

            }

            $count = count($lists);
            
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$lists];
            
        }
        return $this->fetch('article_detail',['id'=>input('id')]);
    }

    public function getPosts()
    {
        $info = Db::name('posts')->field('id,posts')->select();
        $newArray1 = array_column($info,NULL,'id');
        return $newArray1;
    }
    public function getFramework()
    {
        $info = Db::name('framework')->field('id,name')->select();
        $newArray1 = array_column($info,NULL,'id');
        return $newArray1;
    }
    public function getProject()
    {
        $info = Db::name('project')->field('id,name')->select();
        $newArray1 = array_column($info,NULL,'id');
        return $newArray1;
    }
    public function getReady($gid = 5)
    {
        $info = Db::name('ready')->field('uid,ready,do')->where('gid',$gid)->select();
        $newArray1 = array_column($info,NULL,'uid');
        return $newArray1;
    }

    public function getList()
    {
         $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
             

        if($_SESSION['think']['role_title']=='事业部秘书')
             {
                $where['department'] = ['eq',$depart];
             }else{
                $where= '1=1';
             }
            
        $info = Db::name('article')->where('id',input('cid'))->value('stations');
            $station = explode(',', $info);

            $lists = Db::name('users')->field('id,username,region,department,station,projectname')->where('station','in',$station)->where($where)->where('is_quit','-1')->where('del','-1')->select();

            $posts = $this->getPosts();$framework = $this->getFramework();$project = $this->getProject();$ready = $this->getReady(input('cid'));

            foreach($lists as $k=>$v)
            {
                $lists[$k]['region'] = $framework[$v['region']]['name'];
                $lists[$k]['department'] = $framework[$v['department']]['name'];
                $lists[$k]['station'] = $posts[$v['station']]['posts'];
                if($v['projectname'] !== '0')
                {
                    $lists[$k]['projectname'] = Db::name('project')->where('id',$v['projectname'])->value('name');
                }else{
                    $lists[$k]['projectname'] = '无';
                }
                if(isset($ready[$v['id']]))
                {
                    $lists[$k]['isReady'] = $ready[$v['id']]['ready'] == 1?'已阅读':'未阅读';
                    $lists[$k]['isdu'] = $ready[$v['id']]['do'] == 1?'已完成':'未完成';
                    $lists[$k]['ready'] = $ready[$v['id']]['ready'];
                    $lists[$k]['du'] = $ready[$v['id']]['do'];
                }else{
                    $lists[$k]['isReady'] = '未阅读';
                    $lists[$k]['isdu'] = '未完成';
                    $lists[$k]['ready'] = '-1';
                    $lists[$k]['du'] = '-1';
                }

                if(($lists[$k]['du'] == input('du'))&&($lists[$k]['ready'] == input('ready')))
                {
                    $list[] = $lists[$k];
                }
                 if(('10' == input('du'))&&('10' == input('ready')))
                {
                    $list[] = $lists[$k];
                }

            }
            
            
            if(!isset($list))
            {
                $count = '';
                $list = '';
            }else{
                $count = count($list);
            }
           
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        
    }
    public function config()
    {
        if (\request()->isPost()) {
            $post = input('param.');
            foreach (\request()->post() as $key => $value) {

                sysconf($key, $value);
            }

            return json(['code' => 1, 'msg' => '系统参数配置成功！']);
        }
        return $this->fetch();
    }
    public function project()
    {
        if(isset($_GET['id']))
        {
            if($_SESSION['think']['role_title']=='事业部秘书')
            {
                $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
                $where['pid'] = ['eq',$depart];
            }else{
                $where  = '1=1';
            }
            $count=Db::name('project_article')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('project_article')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['pname'] = db::name('article_cate')->where('id',$v['pid'])->value('posts');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch('',['type'=>db::name('article_cate')->where('pid',1)->select()]);
        }
    }

    /*
    * 添加公告
    * */
    public function project_add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['pname'] = db::name('article_cate')->where('id',$_POST['pid'])->value('posts');
            if(empty($_POST['createtime']))
            {
                $_POST['createtime'] = date('Y-m-d H:i:s',time());
            }
            $info = Db::name('project_article')->insert($_POST);

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
            $this->assign('lists',Db::name('article_cate')->where('pid','1')->select());
                        return  $this->fetch('',['times'=>date('Y-m-d',time())]);

        }
    }

    public function project_edit()
    {
        if (Request::instance()->isPost())
        {

            $info = Db::name('project_article')->update($_POST);
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

            $list = Db::name('project_article')->where('id',Request::instance()->param('id'))->find();

            $this->assign('list',$list);
            $this->assign('lists',Db::name('article_cate')->where('pid','1')->select());
            return $this->fetch('project_add');
        }
    }

    public function pan()
    {
        if (Request::instance()->isAjax())
        {

            $count=db::name('files')->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =db::name('files')->order('id desc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch();
    }

    public function filesList()
    {
        if (Request::instance()->isAjax())
        {
            $count=db::name('upload')->where('cid',input('id'))->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =db::name('upload')->where('cid',input('id'))->order('id desc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
         }
        return $this->fetch('',['pro_id'=>input('pro_id')]);
    }

    public function filesDel()
    {
        if(db::name('upload')->where('id',input('id'))->delete())
        {
            return json(['code'=>1,'msg'=>'删除成功']);
        }
    }
    public function uploadDel()
    {
        if(db::name('files')->where('id',input('id'))->delete())
        {
            return json(['code'=>1,'msg'=>'删除成功']);
        }
    }

        public function uploads()
    {
        $ret = array();
        if ($_FILES["file"]["error"] > 0)
        {
            $ret["message"] =  $_FILES["file"]["error"] ;
            $ret["status"] = 0;
            $ret["src"] = "";
            return json($ret);
        }else{
            $pic =  $this->upload();
            if($pic['info']== 1){
                $url = '/public/uploads/'.str_replace("\\","/",$pic['savename']);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            $ret["msg"]= "上传成功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            if($this->request->param('id'))
            {
                $reserve = isset($_GET['reserve'])?$_GET['reserve']:1;
                Db::name('img')->insert(array('url'=>$url,'tid'=>$this->request->param('id'),'mark'=>$this->request->param('mark'),'reserve' =>$reserve));

            }
            if($this->request->param('cid'))
            {

                Db::name('users')->where('id',$this->request->param('cid'))->update(['avatar'=>$url]);

            }
            return json($ret);
        }
    }
    /*
     * 文件上传实际操作
     * */
    private  function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录?
        $info = $file->move(ROOT_PATH . 'public/uploads');
        $reubfo = array();
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();
        }
        return $reubfo;
    }

    public function article_cate()
    {
        if(isset($_GET['id']))
        {
            $count=Db::name('article_cate')->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('article_cate')->order('id asc')->limit($tol,$limit)->select();

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch();
    }


    public function postsAdd()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('article_cate')->insert(input('post.')))
            {
                $info = array('code'=>1,'msg'=>'新增分类成功');
            }else{
                $info = array('code'=>2,'msg'=>'新增分类失败');
            }
            return json($info);
        }
        $this->assign('pid',$_REQUEST['pid']);
        $this->assign('list',Db::name('article_cate')->where('pid','0')->select());
        return $this->fetch('posts_add');
    }

    public function postsDel()
    {
        if(Db::name('article_cate')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }

    public function checkStatusPosts()
    {
        $info = input('post.');
        if(Db::name('article_cate')->where('id',$info['id'])->update(['status'=>-$info['status']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }

    public function Search()
    {
        if(!empty($_POST['title'])){
            $where['title']= ['like', "%".$_POST['title']."%"];
        }
        if(!empty($_POST['types'])){
            $where['pid']=$_POST['types'];
        }
        if(empty($where))
        {
            $where = '1=1';
        }
        $count=Db::name('article')->where($where)->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::name('article')->where($where)->order('id desc')->limit($tol,$limit)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['pname'] = db::name('article_cate')->where('id',$v['pid'])->value('posts');
        }
        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
    }
    public function Searchs()
    {
        if(!empty($_POST['title'])){
            $where['title']= ['like', "%".$_POST['title']."%"];
        }
        if(!empty($_POST['types'])){
            $where['pid']=$_POST['types'];
        }
         if(empty($where))
        {
            $where = '1=1';
        }
        $count=Db::name('project_article')->where($where)->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::name('project_article')->where($where)->order('id desc')->limit($tol,$limit)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['pname'] = db::name('article_cate')->where('id',$v['pid'])->value('posts');
        }
        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
    }
    public function Search1()
    {
        if(!empty($_POST['title'])){
            $where['name']= ['like', "%".$_POST['title']."%"];
        }
        if(!empty($_POST['uname'])){
            $where['uname']= ['like', "%".$_POST['uname']."%"];
        }
        $where['cid'] = input('pro_id');


        $count=Db::name('upload')->where($where)->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::name('upload')->where($where)->order('id desc')->limit($tol,$limit)->select();

        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
    }

    public function banner()
    {
        if(isset($_GET['id']))
        {

            $count=Db::name('banner')->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('banner')->order('sort desc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    public function bannerEdit()
    {
         if (Request::instance()->isPost())
         {
            if(db::name('banner')->update(input('')))
            {
                return json(['code'=>1,'msg'=>'更新成功']);
            }else{
                return json(['code'=>2,'msg'=>'更新失败']);
            }
         }
        return $this->fetch('banner_add',['info'=>db::name('banner')->where('id',input('id'))->find()]);
    }
    public function bannerDel()
    {
        if(Db::name('banner')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    public function bannerAdd()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('banner')->insert(input('post.')))
            {
                $info = array('code'=>1,'msg'=>'添加成功');
            }else{
                $info = array('code'=>2,'msg'=>'添加失败');
            }
            return json($info);
        }
        return $this->fetch();
    }
}
