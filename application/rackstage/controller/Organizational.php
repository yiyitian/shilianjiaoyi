<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Organizational extends Common
{
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    /*
     * 分类列表
     * */
   public function index()
    {
         if (Request::instance()->isAjax())
        {
            $list =Db::name('framework')->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['open'] = true;
            }
            return json(["code"=>"0","msg"=>"ok","data"=>$list]);
        }
        return $this->fetch();
    }
     public function editProject()
    {
        if (Request::instance()->isPost())
        {
            if(db::name('framework')->update(input('')))
            {
                return json(['code'=>1,'msg'=>'修改成功']);
            }else{
                return json(['code'=>2,'msg'=>'修改失败']);
            }
        }
        $data = db::name('framework')->where('id',input('id'))->find();
        return $this->fetch('add',['list'=>$data,'pid'=>$data['cid']]);
    }
    /*
     * 删除方法
     * */
    public function Del()
    {
        if(count(Db::name('framework')->where('pid='.input('id'))->select())>0)
        {
            return json(['code'=>'2','msg'=>'请先删除该分类下子分类']);
        }

        if(Db::name('framework')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 增加分类
     * */
    public function add()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $pid = db::name('framework')->where('id',$info['pid'])->value('pid');
            $upPid = db::name('framework')->where('id',$pid)->value('pid');
            if(empty($upPid))
            {
                $info['cid'] = $info['pid'];
                unset($info['pid']);
            }else{
                $info['cid'] = $info['pid'];
                $info['pid'] = $pid;
            }

            if(Db::name('framework')->insert($info))
            {
                $info = array('code'=>1,'msg'=>'新增分类成功');
            }else{
                $info = array('code'=>2,'msg'=>'新增分类失败');
            }
            return json($info);
        }
        return $this->fetch('add',['pid'=>input('pid')]);
    }
    /*
     * 修改分类名称
     * */
    public function edit()
    {
        $info = input('post.');
        if(Db::name('framework')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }
    /*
     * 修改状态(组织架构)
     * */
    public function checkStatus()
    {
        $info = input('post.');
        if(Db::name('framework')->where('id',$info['id'])->update(['status'=>-$info['status']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }






    /*
     * 岗位列表
     * */
    public function posts()
    {
        

         if (Request::instance()->isAjax())
        {
            $list =Db::name('posts')->order('id asc')->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['open'] = true;
            }
            return json(["code"=>"0","msg"=>"ok","data"=>$list]);
        }
        return $this->fetch();
    }
    /*
    * 修改状态(岗位)
    * */
    public function checkStatusPosts()
    {
        $info = input('post.');
        if(Db::name('posts')->where('id',$info['id'])->update(['status'=>-$info['status']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }
    /*
     * 增加岗位
     * */
    public function postsAdd()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('posts')->insert(input('post.')))
            {
                $info = array('code'=>1,'msg'=>'新增岗位成功');
            }else{
                $info = array('code'=>2,'msg'=>'新增岗位失败');
            }
            return json($info);
        }
		$this->assign('pid',$_REQUEST['pid']);
		$this->assign('list',Db::name('posts')->where('pid','0')->select());
        return $this->fetch('posts_add');
    }
    /*
     * 获取分类下分类
     * */
    public function getCate()
    {
        return json(Db::name('framework')->where('pid',input('cateId'))->select());
    }
    /*
     *
     * */
    /*
   * 删除方法
   * */
    public function postsDel()
    {
        if(Db::name('posts')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 岗位编辑
     * */
    public function postsEdit()
    {
        if (Request::instance()->isPost()){
            if(Db::name('posts')->where('id',$_POST['id'])->update($_POST))
            {
                return json(array('code'=>1,'msg'=>'修改成功'));
            }else{
                return json(array('code'=>2,'msg'=>'修改失败，请重试！！！'));
            }
        }else{
			$info=Db::name('posts')->where('id',$this->request->param('id'))->find();
			$this->assign('info',$info);
			$this->assign('pid',$info['pid']);
            return $this->fetch('posts_add',['list'=>Db::name('posts')->where('pid','0')->select()
            ]);
        }
    }
    /*
     * 修改指定字段名称
     * */
    public function postsfieldedit()
    {
        $info = input('post.');
        if(Db::name('posts')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }


    /*
    * 修改状态(项目)
    * */
    public function checkStatusProject()
    {

        if(Db::name('project')->where('id',$_POST['id'])->update(['status'=>-$_POST['status']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }
    /*
     * 项目列表
     * */
    public function project()
    {
        if(isset($_GET['id']))
        {
            if(!isset($_POST['search_field'])){
                $_POST['search_field']='';
            }
            if(isset($_POST['manager'])){
                $manager = db::name('project')->field('manager')->group('manager')->select();
                foreach($manager as $k=>$v)
                {
                    $data[] = $v['manager'];
                }
                $ids = db::name('user')->where('user_name','like','%'.$_POST['manager'].'%')->where('id','in',$data)->select();
                foreach($ids as $k=>$v)
                {
                    $dates1[] = $v['id'];
                }
                $where['manager'] = array('in',$dates1);
            }

            if($_SESSION['think']['role_title']=='项目负责人'){
                $where['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $this->assign('block',1);
                $where['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
                //如果是地区业管，且department不为空
                $where['framework_id']=array('in',$_SESSION['think']['department']);
            }

            if(isset($_POST['del'])){
                $where['del']=$_POST['del'];
            }else{
                $where['del']='-1';
            }
            $count=Db::name('project')
                ->where('name','like','%'.$_POST['search_field'].'%')
                ->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('project')
                ->where('name','like','%'.$_POST['search_field'].'%')
                ->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
				$region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
                if($v['user_id']<2)
                {
                    $list[$k]['user_name']='--';

                }else{
                    $list[$k]['user_name']=Db::name('user')->where('id',$v['user_id'])->value('user_name');
                }
                $list[$k]['manager']=Db::name('user')->where('id',$v['manager'])->value('user_name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        if($_SESSION['think']['role_title']=='项目负责人'){
        }elseif($_SESSION['think']['role_title']=='项目经理'){
            $this->assign('block',1);
        }
        $uid = array(1,2,4,276);
        if(in_array(session('user_id'),$uid))
        {
            $this->assign('uid',$uid);
        }
        
        return $this->fetch();
    }
    public function project_add()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('project')->insert($_POST))
            {
                AddLog(Db::Name('project')->getLastSql());
                $info = array('code'=>1,'msg'=>'添加成功');
            }else{
                $info = array('code'=>2,'msg'=>'添加失败');
            }
            return json($info);
        }
        $this->assign('fatherlist',Db::name('framework')->where('pid','-1')->select());
        $this->assign('sonlist',Db::name('framework')->where('pid','>','-1')->where('status','1')->order('id asc')->select());
        $user_list=Db::name('user')->where('role_title','项目负责人')->where('status','1')->select();
        $this->assign('user_list',$user_list);
        $manager_list=Db::name('user')->where('role_title','项目经理')->where('status','1')->select();
        $this->assign('manager_list',$manager_list);
        return $this->fetch();
    }
    public function checkUsers()
    {
        $project = db::name('project')->field('id,framework_id')->select();
        foreach($project as $K=>$v)
        {
            db::name('users')->where('projectname',$v['id'])->update(['department'=>$v['framework_id']]);
        }
    }
    public function project_edit()
    {
        if (Request::instance()->isPost())
        {
            $Framework = getFramework();
            $framework_id = db::Name('project')->where('id',$_POST['id'])->find();
            if($framework_id['framework_id'] !== $_POST['framework_id'])
            {
                db::startTrans();
                try{
                    $update = Db::name('project')->update($_POST);
                    if($update)
                    {
                        /*更新项目人员部门*/
                        $projectNumber = db::name('users')->where('projectname',$_POST['id'])->count();
                        $updateNumber = db::name('users')->where('projectname',$_POST['id'])->update(['department'=>$_POST['framework_id']]);
                        if($updateNumber<$projectNumber)
                        {
                            throw new \Exception("同步项目人员数据失败");
                        }
                        /*更新已培训人员部门数据*/
                        $trainNumber = db::name('train')->where('project_id',$_POST['id'])->count();
                        if(!empty($trainNumber))
                        {
                            $trainNumbers = db::name('train')->where('project_id',$_POST['id'])->update(['department'=>$_POST['framework_id'],'department_title'=>$Framework[$_POST['framework_id']]]);
                            if($trainNumbers<$trainNumber)
                            {
                                throw new \Exception("同步培训人员数据失败");
                            }
                        }
                        /*更新询盘成绩数据*/
                        $enquiryNumber = db::name('enquiry')->where('project_id',$_POST['id'])->count();
                        if(!empty($enquiryNumber)) {
                            $enquiryNumbers = db::name('enquiry')->where('project_id', $_POST['id'])->update(['department' => $_POST['framework_id']]);
                            if ($enquiryNumbers < $enquiryNumber) {
                                throw new \Exception("同步询盘数据失败");
                            }
                        }
                        /*更新电话接听数据*/
                        $answerNumber = db::name('answercall')->where('project_id',$_POST['id'])->count();
                        if(!empty($answerNumber)) {
                            $answerNumbers = db::name('answercall')->where('project_id', $_POST['id'])->update(['department' => $_POST['framework_id']]);
                            if ($answerNumbers < $answerNumber) {
                                throw new \Exception("同步电话接听数据失败");
                            }
                        }

                        /*更新客户回访数据*/
                        $reviewNumber = db::name('review')->where('project_id',$_POST['id'])->count();
                        if(!empty($trainNumber)) {
                            $reviewNumbers = db::name('review')->where('project_id', $_POST['id'])->update(['department' => $_POST['framework_id']]);
                            if ($reviewNumbers < $reviewNumber) {
                                throw new \Exception("同步客户回访数据失败");
                            }
                        }
                    }else{
                        throw new \Exception("项目更新失败");
                    }
                    Db::commit();
                }catch(\Exception $e){
                    Db::rollback();
                    return json(['code'=>2,'msg'=>$e->getMessage()]);
                }
                return json(['code'=>1,'msg'=>'更新成功']);
            }else{
                $update = Db::name('project')->update($_POST);
                if($update)
                {
                    return json(['code'=>1,'msg'=>'更新成功']);
                }else{
                    return json(['code'=>1,'msg'=>'没有任何更新']);
                }
            }
        }
        $list=Db::name('project')->where('id',$_REQUEST['id'])->find();
        $list['framework_name']=Db::name('framework')->where('id',$list['framework_id'])->value('name');
        $pid=Db::name('framework')->where('id',$list['framework_id'])->value('pid');
        $list['framework_name_f']=Db::name('framework')->where('id',$pid)->value('name');
        $this->assign('list',$list);

        $this->assign('fatherlist',Db::name('framework')->where('pid','-1')->select());
        $this->assign('sonlist',Db::name('framework')->where('pid','>','-1')->order('pid asc')->select());
        $user_list=Db::name('user')->where('role_title','项目负责人')->where('status','1')->select();

        $this->assign('user_list',$user_list);
        $manager_list=Db::name('user')->where('role_title','项目经理')->where('status','1')->select();
        $this->assign('manager_list',$manager_list);
        return $this->fetch();
    }
    /*
    * 删除方法
    * */
    public function project_del()
    {
        if(Db::name('project')->where('id='.input('id'))->update(['del'=>1]))
        {
            AddLog(Db::Name('project')->getLastSql());
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    public function getProject()
    {
        $data=Db::name('project')->where('framework_id',input('pid'))->select();
        return json($data);
    }

    public function projectPeople()
    {

        if (Request::instance()->isAjax())
        {
            $info = db::name('project')->where('id',input('id'))->value('is_insert');
            if($info<0)
            {
                $where['projectname'] = ['eq',input('id')];
                $where['is_quit'] = ['eq','-1'];
                $where['del'] = ['eq','-1'];
                $list =Db::name('users')->field('id as uid,work_id,username,phone,station,projectname as project')->where($where)->order('id desc')->select();
                foreach($list as $k=>$v)
                {
                    $list[$k]['station_name'] = getName('2',$v['station']);
                    $list[$k]['project_name'] = getName('3',$v['project']);
                    $list[$k]['pid'] = input('id');
                    $list[$k]['addtime'] = '2020-05-01 00:00:00';
                }
                db::name('maintain')->insertAll($list);
                db::name('project')->where('id',input('id'))->update(['is_insert'=>1]);
            
            }
                $wheres['pid'] = input('id');
                $count=Db::name('maintain')->where($wheres)->count();
                $page = $this->request->param('page');
                $limit = $this->request->param('limit');
                $tol=($page-1)*$limit;
                $list =Db::name('maintain')->where($wheres)->order('id desc')->limit($tol,$limit)->select();
                return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
            
        }
        $is_assessment = db::name('project')->where('id',input('id'))->value('is_assessment');
        return $this->fetch('',['id'=>input('id'),'is_assessment'=>$is_assessment]);
    }

    public function projectPeopleAdd()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $userInfo = db::name('maintain')->where(['uid'=>$info['uid'],'pid'=>$info['pid']])->find();
            
            if(!empty($userInfo))
            {
                return json(['code'=>2,'msg'=>'此人已经在项目中']);
            }
            $list =Db::name('users')->field('id as uid,work_id,username,phone,station')->where('id',$info['uid'])->order('id desc')->find();
            $list['station_name'] = getName('2',$list['station']);
            $list['project_name'] = getName('3',$info['pid']);
            $list['addtime'] = $info['addtime'];
            $list['status'] = $info['status'];
            $list['project'] = $info['pid'];
            $list['pid']  = $info['pid'];
            $list['stoptime']  = $info['stoptime'];
            $list['isHave'] = $info['isHave'];
            
            if(db::name('maintain')->insert($list))
            {
                $department = db::name('project')->where('id',$info['pid'])->value('framework_id');
                if($info['isHave'] !== '不在')
                {
                    db::name('users')->where('id',$list['uid'])->update(['projectname'=>$info['pid'],'department'=>$department]);
                }
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
//             if($_SESSION['think']['role_title']=='项目经理')
//             {
//                $where['projectname'] = ['eq',input('id')];
//             }
             $uid = db::name('project')->where('id',input('id'))->value('manager');
             $userInfo = db::name('users')->where('user_id',$uid)->find();

             $where['del'] = ['eq','-1'];
             $list = db::name('users')->where($where)->select();
            $list[] = $userInfo;
            return  $this->fetch('',['types'=>'edit','id'=>input('id'),'list'=>$list,'userInfos'=>$userInfo]);
        }
        
    }

    public function editMaintain()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $userInfo = db::name('maintain')->where(['uid'=>$info['uid'],'pid'=>$info['pid']])->find();
            if(!empty($userInfo))
            {
                if((int)$userInfo['id'] !== (int)$info['id'])
                {
                    return json(['code'=>2,'msg'=>'此人已经在项目中']);
                }
            }
            $list =Db::name('users')->field('id as uid,work_id,username,phone,station,projectname as project,department')->where('id',$info['uid'])->order('id desc')->find();
            $list['station_name'] = getName('2',$list['station']);
            $list['project_name'] = getName('3',$list['project']);
            $list['pid'] = input('id');
            $list['addtime'] = $info['addtime'];
            $list['status'] = $info['status'];
            $list['pid']  = $info['pid'];
            $list['id'] = $info['id'];
            $list['stoptime']  = $info['stoptime'];
            $li = db::name('users')->where('id',$list['uid'])->find();
            if($list['status']=='离职')
            {
                if($li['is_quit']<0)
                {

                    if($li['region'] == 15)
                    {
                        $info1 = 326;
                    }else{
                        $info1 =   db::name('project')->where('mark',$li['department'])->value('id');
                    }
                    db::name('users')->where('id',$list['uid'])->update(['is_quit'=>1,'projectname'=>$info1]);
                }
            }else{
                if($li['is_quit']>0)
                {
                    db::name('users')->where('id',$list['uid'])->update(['is_quit'=>-1]);
                }
            }
            unset($list['department']);
            if(db::name('maintain')->update($list))
            {
                $data['code'] = 1;
                $data['msg'] = '更改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '更改失败';
            }
            return json($data);
        }else{
             $userInfo = db::name('maintain')->where('id',input('id'))->find();
             $where['del'] = ['eq','-1'];
             $list = db::name('users')->where($where)->select();
            return  $this->fetch('project_people_add',['id'=>$userInfo['pid'],'list'=>$list,'userInfo'=>$userInfo]);
        }
    }

    public function delMaintain()
    {
         if(Db::name('maintain')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }


   public function checkStatusProjects()
   {
        $info = input('');
        if($info['status']>1)
        {
            db::name('project')->where('id',$info['id'])->update(['is_edit'=>'-1']);
        }else{
            $where['manager']=$_SESSION['think']['user_id'];
            db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'del'=>'-1'])->update(['is_edit'=>'-1']);
            db::name('project')->where('id',$info['id'])->update(['is_edit'=>'1']);
        }

        return json(array('code'=>1,'msg'=>'状态修改成功'));
   }

    public function getProjects()
    {
        $info = db::name('maintain')->column('uid');
        foreach(db::name('users')->field('id,start_time')->where('id','in',$info)->select() as $k=>$v)
        {
            db::name('maintain')->where('uid',$v['id'])->update(['addtime'=>$v['start_time']]);
        }
    }

    public function subsidyEdit()
    {
        if(db::name('maintain')->where('id',input('id'))->update([input('field')=>input('value')])) {
            return json(["code" => "1", "msg" => "修改成功"]);
        }

    }
    public function isTrue()
    {
        $count = db::name('maintain')->where('pid',input('id'))->where('subsidy','<','2')->count();
        if($count>0)
        {
            return json(['code'=>2,'msg'=>'还有未填写补助的人员，请补足']);
        }
        db::Name('project')->where('id',input('id'))->update(['is_true'=>1]);
        return json(['code'=>1,'msg'=>'人员确认完成']);
    }

    public function tests()
    {
        $project = db::name('review')->field('project_id')->where('department','not in','19,20,21,25,26,38')->select();
        foreach($project as $k=>$v)
        {
            $data[] = $v['project_id'];
        }
        $projects = db::name('project')->where('id','in',$data)->select();
        foreach($projects as $k=>$v)
        {
            db::name('review')->where('project_id',$v['id'])->update(['department'=>$v['framework_id']]);
        }
    }
}
