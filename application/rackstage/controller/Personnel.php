<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Personnel extends Common
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
       if(isset($_GET['id']))
        {
            if($_SESSION['think']['role_title']=='项目负责人'){
                //项目负责人只能维护本项目员工
                $id_list=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])
                    ->field('id')
                    ->select();
                if(empty($id_list)){
                    return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
                }
                foreach($id_list as $key => $val){
                    $id_arr[]=$val['id'];
                }
                $id_str=implode(',',$id_arr);
                $where['projectname']=array('in',$id_str);
            }
            if($_SESSION['think']['role_title']=='项目经理'){
                //项目经理只能维护本项目员工
                $where['projectname']=Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id');
            }
            if($_SESSION['think']['role_title']=='地区业管'){
                //项目经理只能维护本项目员工
                $where['department']=array('in',$_SESSION['think']['department']);

            }
            if($_SESSION['think']['role_title']=='部门总监')
            {
                //查看本部门的所有人员
                $where['department']=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
            }
            if($_SESSION['think']['role_title']=='事业部秘书')
            {
                //查看本部门的所有人员
                $where['department']=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
            }
            $where['del']='-1';
            $count=Db::name('users')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('users')->where($where)->order('is_quit asc')->limit($tol,$limit)->select();
            foreach($list as $key => $val){
                $list[$key]['sex']=$val['sex']==1 ? '男':'女' ;
                $list[$key]['marriage']=$val['marriage']==1 ? '已婚':'未婚' ;
                $list[$key]['is_teacher']=$val['is_teacher']==1 ? '是':'不是' ;
                $list[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        //进入页面
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->select());
        $this->assign('users',Db::name('users')->where('del','neq','1')->field('id,work_id,username')->select());
        $department=Db::name('project')->where('del','neq','1')->where('status',1)->field('framework_id')->select();
        foreach ($department as $key => $val){
            $department_arr[]=$val['framework_id'];
        }
        $department_arr=array_unique($department_arr);
        $project_pid=Db::name('framework')->where('id','in',$department_arr)->select();
        foreach ($project_pid as $key => $val){
            $project_pid[$key]['father']=Db::name('framework')->where('id',$val['pid'])->value('name');
        }
        $this->assign('project_pid',$project_pid);
        $this->assign('department',$department);
        $this->assign('project',Db::name('project')->where('del','neq','1')->where('status',1)->select());
        if($_SESSION['think']['role_title']=='总管理员')
        {
            $this->assign('admins',1);
        }else{
            $this->assign('admins',2);
        }

        if($_SESSION['think']['role_title']=='王丹')
        {
            $this->assign('admins',1);
        }

        $Info = Db::name('framework')->field('id as value,name,cid')->where('pid','-1')->order('id asc')->select();
        foreach($Info as $k=>$v)
        {
            $values = Db::name('framework')->field('id as value,name')->where('cid',$v['value'])->order('id asc')->select();
            foreach($values as $key =>$val)
            {
                $sco = Db::name('framework')->field('id as value,name')->where('cid',$val['value'])->order('id asc')->select();

                foreach($sco as $ks => $vs)
                {
                    $sco[$ks]['children'] = Db::name('framework')->field('id as value,name')->where('cid',$vs['value'])->order('id asc')->select();
                }

                $values[$key]['children'] = $sco;
            }
            $Info[$k]['children'] = $values;

        }
        $this->assign('lists1',json_encode($Info)) ;
        $posts = db::name('posts')->field('id as value,posts as name')->where('pid',0)->select();
        foreach($posts as $k=>$v)
        {
            $posts[$k]['children'] = db::name('posts')->field('id as value,posts as name')->where('pid',$v['value'])->select();
            unset($posts[$k]['value']);
        }
        $this->assign('posts',json_encode($posts));
        return $this->fetch();
    }
    public function getProjects()
    {
        $where = input('');
        $Info = Db::name('project')->field('id as value,name')->where('framework_id','in',$where['pid'])->where('del','-1')->order('id asc')->select();
//        foreach($Info as $k=>$v)
//        {
//            $children = Db::name('project')->field('id as value,name')->where('framework_id',$v['value'])->order('id asc')->select();
//            if(!empty($children))
//            {
//                $Info[$k]['children'] = $children;
//            }else{
//                unset($Info[$k]);
//            }
//        }

        return ["code"=>"0","msg"=>"success","data"=>$Info];
    }
    public function search()
    {

        if($_SESSION['think']['role_title']=='项目负责人'){
            //项目负责人只能维护本项目员工
            $id_list=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])
                ->field('id')
                ->select();
            if(empty($id_list)){
                return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
            }
            foreach($id_list as $key => $val){
                $id_arr[]=$val['id'];
            }
            $id_arr=array_intersect(implode(',',$_POST['projectname']),$id_arr);
            $id_str=implode(',',$id_arr);
            $where['projectname']=array('in',$id_str);
        }else{
            if(!empty($_POST['project'])){
                $where['projectname']=array('in',$_POST['project']);
            }
        }
        if($_SESSION['think']['role_title']=='项目经理'){
            //项目经理只能维护本项目员工
            $where['projectname']=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('projectname');
        }else{
            if(!empty($_POST['project'])){
                $where['projectname']=array('in',$_POST['project']);
            }
        }
        if($_SESSION['think']['role_title']=='部门总监')
        {
            //查看本部门的所有人员
            $where['department']=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
        }
        if($_SESSION['think']['role_title']=='地区业管'){
            //项目经理只能维护本项目员工
            $where['department']=array('in',$_SESSION['think']['department']);
        }
        if($_SESSION['think']['role_title']=='事业部秘书')
        {
            //查看本部门的所有人员
            $where['department']=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
        }
        if(empty($where['department'])&&!empty($_POST['department']))
        {
            $where['department']=array('in',$_POST['department']);
        }

        if(!empty($_POST['station'])){
            $where['station']=array('in',$_POST['station']);
        }
        if(!empty($_POST['ids']))
        {
            $where['id']=array('in',$_POST['ids']);
        }
                $where['is_quit'] = array('eq',$_POST['isQuit']);

        $where['del']='-1';
        $keyword = $_POST['search_field'];

        $counts = db::name('users')->where(function ($query) use ($keyword) {
            if ($keyword !== '') {
                $query->where("concat(username,work_id,phone) LIKE '%$keyword%' ");
            }
        })->where($where)->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $lists =db::name('users')->where(function ($query) use ($keyword) {
            if ($keyword !== '') {
                $query->where("concat(username,work_id,phone) LIKE '%$keyword%' ");
            }
        })->where($where)->order('id desc')->limit($tol,$limit)->select();
        foreach($lists as $key => $val){
            $lists[$key]['sex']=$val['sex']==1 ? '男':'女' ;
            $lists[$key]['marriage']=$val['marriage']==1 ? '已婚':'未婚' ;
            $lists[$key]['is_teacher']=$val['is_teacher']==1 ? '是':'不是' ;
            $lists[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
            $lists[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
            $lists[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
            $lists[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
        }
        return ["code"=>"0","msg"=>"","count"=>$counts,"data"=>$lists];

    }
    /*
     * 后台增加员工
     * */
    public function users_add()
    {
        if (Request::instance()->isPost())
        {
            //var_dump($_POST);exit;
            $province	=Db::name('area')->where('codes',$_POST['users']['province'])->value('name_se');
            $city		=Db::name('area')->where('codes',$_POST['users']['city'])->value('name_se');

            $_POST['users']['domicile']=$province.$city;
            unset($_POST['users']['province']);
            unset($_POST['users']['city']);
            $_POST['users']['classid']=0;
            $_POST['users']['outline_id']=0;
            if(empty($_POST['work_id']))
            {
                $_POST['users']['work_id'] = "SD888888";
            }
            $info = Db::name('users')->insertGetId($_POST['users']);
            if($info)
            {
                $info = array('code'=>1,'msg'=>'新增员工成功');
            }else{
                $info = array('code'=>2,'msg'=>'新增员工失败');
            }
            return json($info);
        }
        $this->assign('province',Db::name('area')->where('pid','0')->select());
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());

        $list =Db::name('project')->order('id desc')->select();
        foreach($list as $k=>$v)
        {
            $department=Db::name('framework')->where('id',$v['framework_id'])->find();
            $region=Db::name('framework')->where('id',$department['pid'])->value('name');
            $list[$k]['department'] = $region.'--'.$department['name'];
        }
        $this->assign('project',$list);
        return $this->fetch();
    }
    /*
     * 后台修改员工
     */
    public function users_edit(){
        if (Request::instance()->isPost())
        {
            $_POST['users']['updatetime']=time();
            $where['id'] = ['neq',$_POST['users']['id']];
            if(0!=(Db::name('users')->update($_POST['users'])))
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }
        $list=Db::name('users')->where('id',$_REQUEST['id'])->find();
        $list['department_name']=Db::name('framework')->where('id',$list['department'])->value('name');
        $list['station_name']=Db::name('posts')->where('id',$list['station'])->value('posts');
        $list['project_name']=Db::name('project')->where('id',$list['projectname'])->value('name');
        $this->assign('stations',Db::name('posts')->where('pid',Db::name('framework')->where('id',$list['region'])->value('type'))->select());
        $this->assign('projects',Db::name('project')->where('framework_id',$list['department'])->where('status',1)->where('del',-1)->select());
        $this->assign('list',$list);
        $post1 = db::name('framework')->where('id',$list['region'])->value('type');
        $station = db::name('posts')->where('pid',$post1)->select();
        $projects = db::name('project')->where('framework_id',$list['department'])->where(['del'=>'-1','status'=>1])->select();
        $this->assign('project',$projects);
        $this->assign('station',$station);
        $depart = db::name('framework')->where('pid',$list['region'])->select();
        $this->assign('depart',$depart);
        $this->assign('province',Db::name('area')->where('pid','0')->select());
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            $this->assign('department',Db::name('framework')->where('pid','14')->order('id asc')->select());
        $list =Db::name('project')->order('id desc')->select();
        foreach($list as $k=>$v)
        {
            $department=Db::name('framework')->where('id',$v['framework_id'])->find();
            $region=Db::name('framework')->where('id',$department['pid'])->value('name');
            $list[$k]['department'] = $region.'--'.$department['name'];
        }
        $this->assign('project',$list);
        return $this->fetch('users_add');
    }
    /*
     * 删除方法
     * */
    public function users_del()
    {
        if(Db::name('users')->where('id='.input('id'))->update(['del'=>1]))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    function class_lists(){
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
        $list =Db::name('classinfo')->where('levels','1')->order('id asc')->select();

        return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
    }
    /*
     * 员工课程信息
     * */
    public function users_class()
    {
        if($this->request->isPost()){
            $classId = db::name('users')->where('id',input('id'))->value('classid');
//            if($_POST['classes']=='all'){
//                if(!empty($_POST['classtype'])){
//                    $where['pid']=$_POST['classtype'];
//                    unset($_POST['classtype']);
//                }
//                if(!isset($where))
//                    $where['levels']='1';
//                $id_list=Db::name('classinfo')->where($where)->select();
//                foreach ($id_list as $key =>$val){
//                    $arr[]=$val['id'];
//                }
//                $_POST['classes']=implode(",", $arr);
//            }else if(empty($_POST['classes'])){
//                $info=Db::name('users')->where('id',$_POST['id'])->update(['classid'=>""]);
//                return json(['msg'=>'课程修改成功！','code'=>1]);
//            }
            if(empty($classId))
            {
                $classIds = [];
            }else{
                $classIds = explode(',',$classId);
            }

            $date = explode(',',$_POST['classes']);
            $this->addTrain($_POST['id'],$date);
            $class_id = array_merge($date,$classIds );
            $data['classid']= implode(',',$class_id);
            $data['id'] = $_POST['id'];
            $info=Db::name('users')->update($data);
            if($info){
                return json(['msg'=>'课程修改成功！','code'=>1]);
            }else{
                return json(['msg'=>'课程修改失败！','code'=>0]);
            }
        }
        $id=input('id');
        $classid=Db::name('users')->where('id',$id)->value('classid');
        //已经上过的课程
        if(isset($_REQUEST['classinfo'])){
            $data=Db::name('classinfo')->where('id','in',$classid)->select();
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        //已通知，还未上的课程
        if(isset($_REQUEST['notice'])) {
            $data = Db::name('notice')
                ->where('classify','notin',$classid)
                ->where("find_in_set(" . $id . ",usersid)")
                ->select();
            if(!empty($data)){
                foreach ($data as $key => $val){
                    $data[$key]['title']=Db::name('classinfo')->where('id',$val['classify'])->value('title');
                }
            }
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        $this->assign('id',$id);
        //所有课程
        $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('classArr',$classArr);
        $this->assign('classArrs',Db::name('classinfo')->where('pid','in','1,2,3')->order('orderby desc,id asc')->select());
        return $this->fetch();
    }
  /*
   * 获取地区部门
   * */
   public function getDepartment(){
	   $data=Db::name('framework')->where('pid',input('id'))->select();
	   return json($data);
   }
    /*
     * 改变教师状态
     * */
    public function checkQuitStatus()
    {
        $is_quit = -input('is_quit');
        $data['is_quit']=$is_quit;
        if ($is_quit==1){
            $data['quit_time']=date('Y-m-d H:i:s');
        }else{
            $data['quit_time']='0000-00-00 00:00:00';
        }
        if(Db::name('users')->where('id',input('id'))->update(['is_quit'=>$is_quit]))
        {
            $info = ['code'=>1,'msg'=>"修改成功"];
        }else
        {
            $info = ['code'=>2,'msg'=>"修改失败"];
        }
        return json($info);
    }
    /*
    * 改变员工离职状态
    * */
    public function checkUserQuit()
    {
        $is_quit = -input('is_quit');
        if(Db::name('users')->where('id',input('id'))->update(['is_quit'=>$is_quit]))
        {
            $info = ['code'=>1,'msg'=>"修改成功"];
        }else
        {
            $info = ['code'=>2,'msg'=>"修改失败"];
        }
        return json($info);
    }
    /*
     * 获取省市县
     * */
    public function get_city_area(){
        $data=Db::name('area')->where('pid',input('pid'))->select();
        //var_dump($data);
        return json($data);
    }
  /*
   * 获取分类下分类
   * */
    public function getCate()
    {
		$data['framework']=Db::name('framework')->where('pid',input('pid'))->select();
		$post_pid=Db::name('framework')->where('id',input('pid'))->value('type');
		if(input('pid') == '70')
        {
            $post_pid = '51';
        }
		$data['post']=Db::name('posts')->where('pid',$post_pid)->select();
        return json($data);
    }
    /*
     * 获取岗位
     * */
    public function getPosts()
    {
        return json(Db::name('posts')->where('department',input('cateId'))->select());
    }
    /*
     * 获取项目
     * */
    public function getProject()
    {
        $data=Db::name('project')->where('framework_id',input('pid'))->where('status',1)->where('del',-1)->select();
        return json($data);
    }
    /*
     * 修改分类名称-
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
     * 修改状态
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
     * 重置前台员工密码
     * */
    public function resetpassword()
    {
        //var_dump($_POST);exit;
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $string  = '';
		$pass='';
        for($i = 0; $i < 6; $i ++) {
            $string .= $pattern {mt_rand ( 0, 61 )}; //生成php随机数
            $pass .= $num {mt_rand ( 0, 9 )}; //生成php随机数
        }
        $_POST['random']=$string;
        //$_POST['pass']  = md5($string.$pass);
        $_POST['pass']  = md5($string.'123456');
        Db::name('users')->update($_POST);
        return json(['msg'=>'123456']);
    }
    public function DelUserClassId()
    {
        $classId = db::name('users')->where('id',input('userId'))->value('classid');
        $list    = explode(',',$classId);
        foreach($list as $k=>$v)
        {
            if($v !== input('id'))
            {
                $lists[] = $v;
            }
        }
        if(isset($lists))
        {
            $listArr = implode(',',$lists);
        }else{
            $listArr = '';
        }
        db::name('users')->where('id',input('userId'))->update(['classid'=>$listArr]);
        db::name('train')->where(['uid'=>input('userId'),'classify_id'=>input('id')])->delete();
        return json(['code'=>1,'msg'=>'删除成功']);
    }


    /*
     * 增加培训课程
     * \*/
    public function addTrain()
    {
        $info = input('');
        $userInfo = db::name('users')->where('id',$info['uid'])->field('classid,work_id,username,phone,region,department,station,projectname as project_id')->find();
        $userInfo['region_title'] = getName(1,$userInfo['region']);
        $userInfo['department_title'] = getName(1,$userInfo['department']);
        $userInfo['station_title'] = getName(2,$userInfo['station']);
        $userInfo['project_title'] = getName(3,$userInfo['project_id']);
        $info =array_merge($info,$userInfo);
        $classInfo = db::name('outline')->where('id',$info['class_time'])->field('times as class_time,username as headmaster,startdate,enddate,price')->find();
        $info =array_merge($info,$classInfo);
        $info['classify_title'] = db::name('classinfo')->where('id',$info['classify_id'])->value('title');
        $class = $info['classid'];unset($info['classid']);
        if(db::name('train')->insert($info))
        {
            /*给用户增加一条培训记录*/
            $classId = array_filter(explode(',',$class));
            $classId[] = $info['classify_id'];
            Db::name('users')->where('id',$info['uid'])->update(['classid'=>implode(',',array_unique($classId))]);
            /*把此用户放到通知人员里面去*/
            $usersId = db::name('notice')->where('times',$info['class_time'])->value('usersid');
            $userArr = explode(',',$usersId);
            if(!in_array($info['uid'],$userArr))
            {
                $userArr[] = $info['uid'];
                db::name('notice')->where('times',$info['class_time'])->update(['usersid'=>implode(',',$userArr)]);
            }
            return json(['code'=>1,'msg'=>'增加成功']);
        }
    }

    public function getOutline()
    {
        $list = db::name('outline')->where('classify',input('pid'))->where('status',1)->order('times desc')->select();
        return json($list);
    }
    
}
