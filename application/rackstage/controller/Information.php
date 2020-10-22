<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Information extends Common
{
    /*
     * 列表
     * */
    public function pro_list()
    {
        if(isset($_GET['id']))
        {
            if(isset($_POST['search_field'])){
                $where['name']=array('like','%'.$_POST['search_field'].'%');
            }

            if($_SESSION['think']['role_title']=='项目负责人'){
                $where['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
				$where['manager']=$_SESSION['think']['user_id'];
			}elseif($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
                //如果是地区业管，且department不为空
                $where['framework_id']=array('in',$_SESSION['think']['department']);
            }
            $where['status']=1;
            $count=Db::name('project')->where($where)->count();

            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('project')->where($where)->order('id asc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
                $region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch();
    }
    public function project_postsinfo(){
        $list =Db::name('users')->where('projectname',$_REQUEST['pro_id'])->where('is_quit','-1')->field('station,username')->select();
        $data=array();
        foreach ($list as $key => $val){
            $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
            $data[]=$list[$key]['station'];
        }
        $data=array_unique($data);

        foreach($data as $k => $v){
            foreach ($list as $key => $val){
                if($val['station']==$v){
                    if(!isset($data[$k]['num'])){
                        $i=1;
                    }
                    $data[$k]=array(
                        'station'=>$v,
                        'num'=>$i++,
                    );
                }
            }
        }
        $data=array_values($data);
        return ["code"=>"0","msg"=>"","data"=>$data];
    }
     public function weekinfo(){
        if(isset($_GET['id']))
        {
            $pro_id=$_GET['id'];
            $count=Db::name('weekinfo')->where('pro_id',$pro_id)->count()/7;
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit*7;
            $list =Db::name('weekinfo')->where('pro_id',$pro_id)->order('id desc')->field('times')->limit($tol,$limit*7)->select();
            if(empty($list)){
                return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
            }

            foreach($list as $key=>$val)
            {
                $list_new[]=$val['times'];
            }
            arsort($list_new);
            $list_new=array_values(array_unique($list_new));

            foreach($list_new as $key => $val){
                $data[$key]['title']=date('Y-m-d',$val-6*24*3600).'~'.date('Y-m-d',$val);
                $data[$key]['times']=$val;

//                var_dump(date('Y-m-d',$val));
//                var_dump(date('Y-m-d',$val-6*24*3600));  exit;
            }
//            exit;
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$data];
        }

        $list=Db::name('settime')->where('id',1)->find();

        if(time()<$list['starttime'] || time()>$list['endtime']){
            $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
        }
        $this->assign('name',Db::name('project')->where('id',$_REQUEST['pro_id'])->value('name'));
        $this->assign('pro_id',$_REQUEST['pro_id']);
        return $this->fetch();
    }
    /*
     * 获取当前周时间，添加当前周的报表
     */
    public function creatweekinfo(){
        if($_REQUEST['time_code']=='this_week'){
            $times=strtotime(date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600)));
        }else if($_REQUEST['time_code']=='last_week'){
            $times=strtotime(date('Y-m-d 23:59:59', strtotime('-1 sunday', time())));
        }
        $where['pro_id']=$pro_id=$_REQUEST['pro_id'];
        $where['times']=$times;
        $where['comecall'] = ['neq','项目经理'];
        if(!empty($_REQUEST['check'])){
            $count=Db::name('weekinfo')->where($where)->count();
            if($count>0){
                return json(["code"=>"0","msg"=>"数据已存在，数据初始化中"]);
            }else{
                $createtime=time();
                $data=array(
                    ['company' => '周目标',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '6',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'aim'],
                    ['company' => '世联',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '5',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'shilian'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '4',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '3',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '2',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '1',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai']
                );
                $info=Db::name('weekinfo')->insertAll($data);
                if($info){
                    return json(["code"=>"1","msg"=>"表格初始化中"]);
                }else{
                    return json(["code"=>"0","msg"=>"周报插入数据表失败，请重试"]);
                }

            }
        }
        $data=Db::name('weekinfo')->where($where)->order('orderby desc')->select();
        return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];

    }
    public function weekinfo_field_edit(){
        $info = input('post.');
        if(Db::name('weekinfo')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }
    /*
     *添加
     * */
    public function weekinfo_add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['user_id'] = session::get('user_id');
            if(0!=(Db::name('logs')->insert($_POST)))
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $this->assign('pro_id',$_REQUEST['pro_id']);
            return $this->fetch();
        }
    }

    /*
   * 编辑
   * */
    public function weekinfo_see()
    {
        $this->assign('pro_id',$_REQUEST['pro_id']);
        $this->assign('times',$_REQUEST['times']);
        return $this->fetch();
    }
    /*
     * 编辑
     * */
    public function weekinfo_edit()
    {
        if (isset($_GET['id']))
        {
            $where['pro_id']=$_REQUEST['pro_id'];
            $where['times']=$_REQUEST['times'];
            $where['comecall']= ['neq','项目经理'];
            $data=Db::name('weekinfo')->where($where)->order('orderby desc')->select();
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }else{
            $this->assign('pro_id',$_REQUEST['pro_id']);
            $this->assign('times',$_REQUEST['times']);
            return $this->fetch();
        }
    }

    /*
    * 删除
    * */
    public function weekinfo_del()
    {
        $where['times']=$_REQUEST['times'];
        $where['pro_id']=$_REQUEST['pro_id'];
        if(Db::name('weekinfo')->where($where)->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 周报搜索
     */
    public function weeksearch(){
         if(isset($_GET['search'])){
            $time_code=$_POST['time_code'];
            $type=$_POST['type'];
            $array=explode(' - ', $time_code);
            $array[0]=strtotime($array[0].' 0:0:0');
            $array[1]=strtotime($array[1].' 23:59:59')+1;
            $where['times']=array('between',$array);
            if($type!='all'){
                $where['shilian_weekinfo.type']=$type;
            }
            $where['company']=array('neq','');
            //根据角色筛选对应项目start
            if($_SESSION['think']['role_title']=='项目负责人'){
                $where_pro['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $where_pro['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
                //如果是地区业管，且department不为空
                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
            }
            $where_pro['status']=1;
            $where_pro['is_agent']=input('is_agent');
            $pro_id_arr=Db::name('project')->where($where_pro)->field('id')->select();
            foreach ($pro_id_arr as $item) {
                $pro_id[]=$item['id'];
            }
            $where['pro_id']=array('in',$pro_id);
            //根据角色筛选对应项目end
            if($_POST['is_member']==-1)
            {
                $where['company']=array('notlike','%人数%');
            }
            $count=Db::name('weekinfo')
                ->alias('weekinfo')
                ->join('shilian_project project','weekinfo.pro_id = project.id')
                ->join('shilian_framework framework','project.framework_id = framework.id')
                ->field('framework.name as framework,project.name,weekinfo.*')
                ->where($where)
                ->where('company','neq','')
                ->order('weekinfo.createtime desc,weekinfo.orderby desc')->count();

            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $data=Db::name('weekinfo')
                ->alias('weekinfo')
                ->join('shilian_project project','weekinfo.pro_id = project.id')
                ->join('shilian_framework framework','project.framework_id = framework.id')
                ->field('framework.name as framework,project.name,weekinfo.*')
                ->where($where)
                ->where('company','neq','')
                ->order('weekinfo.createtime desc,weekinfo.orderby desc')
                ->limit($tol,$limit)
                ->select();
            foreach($data as $k=>$v)
            {
                if(($v['comecall']>0)||($v['comevisit']>0))
                {

                }else{
                    unset($data[$k]);
                }
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$data];

        }
        return $this->fetch();
    }
    /*
     * 月报搜索
     */
    public function monthsearch(){
        if(isset($_GET['search'])){
            $array=explode(' - ', $_POST['time_code']);
            $array[0]=strtotime($array[0].' 0:0:0')-1;
            $array[1]=strtotime($array[1].' 23:59:59');
            $where['times']=array('between',$array);
            $where['company']=array('neq','');
            //根据角色筛选对应项目start
            if($_SESSION['think']['role_title']=='项目负责人'){
                $where_pro['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $where_pro['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
                //如果是地区业管，且department不为空
                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
            }
            $where_pro['status']=1;
            $pro_id_arr=Db::name('project')->where($where_pro)->field('id')->select();
            foreach ($pro_id_arr as $item) {
                $pro_id[]=$item['id'];
            }
            $where['pro_id']=array('in',$pro_id);
            //根据角色筛选对应项目end
            $count=Db::name('monthinfo')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $data=Db::name('monthinfo')
                ->alias('weekinfo')
                ->join('shilian_project project','weekinfo.pro_id = project.id')
                ->join('shilian_framework framework','project.framework_id = framework.id')
                ->field('framework.name as framework,project.name,weekinfo.*')
                ->where($where)
                ->order('times desc')
                ->limit($tol,$limit)
                ->select();

            return ["code"=>"0","msg"=>"","count"=>$count-1,"data"=>$data];

        }
        return $this->fetch();
    }
    public function monthinfo(){
        if(isset($_GET['id']))
        {
            $pro_id=$_GET['id'];
            $count=Db::name('monthinfo')->where('pro_id',$pro_id)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $data =Db::name('monthinfo')->where('pro_id',$pro_id)->order('title desc')->limit($tol,$limit)->select();

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$data];
        }
        $list=Db::name('settime')->where('id',1)->find();
        if(time()<$list['starttime'] || time()>$list['endtime']){
            $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
        }
        $this->assign('pro_id',$_REQUEST['pro_id']);
        return $this->fetch();
    }
    /*
     *添加
     * */
    public function monthinfo_add()
    {
        $this->assign('pro_id',$_REQUEST['pro_id']);
        return $this->fetch();
    }
    /*
     *查看
     * */
    public function monthinfo_see()
    {
        $this->assign('id',$_REQUEST['id']);
        return $this->fetch();
    }
    /*
    * 编辑
    * */
    public function monthinfo_edit()
    {
        if (isset($_GET['list']))
        {
            $where['id']=$_REQUEST['list'];
            $data=Db::name('monthinfo')->where($where)->order('orderby desc')->select();
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }else{
            $this->assign('id',$_REQUEST['id']);
            return $this->fetch();
        }
    }
    /*
     * 删除
     */
    public function monthinfo_del()
    {
        if(Db::name('monthinfo')->delete($_REQUEST['id']))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 获取当前周时间，添加当前周的报表
     */
    public function creatmonthinfo(){
        if (isset($_GET['list']))
        {
            $where['times']=$_REQUEST['list'];
            $where['pro_id']=$_REQUEST['pro_id'];
            $data=Db::name('monthinfo')->where($where)->order('orderby desc')->select();
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        if($_REQUEST['time_code']=='this_week'){
            $times=strtotime(date('Y-m-d 23:59:59', strtotime('last day next week')));
        }else if($_REQUEST['time_code']=='last_week'){
            $times=strtotime(date('Y-m-d 23:59:59', strtotime('last day this week')));
        }
        $where['title']=$time_code=$_REQUEST['time_code'];
        $times=strtotime($time_code.'-1 0:0:0');
        $where['pro_id']=$pro_id=$_REQUEST['pro_id'];
        $where['times']=$times;
        if(!empty($_REQUEST['check'])){
            $count=Db::name('monthinfo')->where($where)->count();
            if($count>0){
                return json(["code"=>"0","msg"=>"数据已存在，数据初始化中","times"=>Db::name('monthinfo')->where($where)->value('times')]);
            }else{
                $createtime=time();
                $data=array(
                    'title' => $time_code,
                    'pro_id' => $pro_id,
                    'company' => '世联',
                    'lastmonthcall' => '',
                    'lastmonthcome' => '',
                    'lastmonthmainhouse' => '',
                    'lastmonthparking' => '',
                    'lastmonthbasement' => '',
                    'lastmonthsale' => '',
                    'thismonthsale' => '',
                    'is_add' => '',
                    'addnum' => '',
                    'addaim' => '',
                    'obj_type' => '',
                    'bestaim' => '',
                    'times' => $times,
                    'createtime' => $createtime
                );
                $info=Db::name('monthinfo')->insert($data);
                if($info){
                    return json(["code"=>"1","msg"=>"表格初始化中","times"=>$times]);
                }else{
                    return json(["code"=>"0","msg"=>"月报插入数据表失败，请重试"]);
                }

            }
        }
        $data=Db::name('monthinfo')->where($where)->order('orderby desc')->select();
        return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];

    }
    /*
     * 月报设置项目类型
     */
    public function set_obj_type()
    {
        if (Request::instance()->isPost()) {
            $info=Db::name('monthinfo')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }else
        {
            $this->assign('id', $_GET['id']);
            $this->assign('obj_type', $_GET['obj_type']);
            return $this->fetch();
        }
    }
    public function monthinfo_field_edit(){
        $info = $_POST;
        if(Db::name('monthinfo')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }
    /*
     * 设置周报提交时间范围
     */
    public function settime(){
        if (Request::instance()->isPost()) {
            $_POST['starttime']=strtotime($_POST['starttime']);
            $_POST['endtime']=strtotime($_POST['endtime']);

            $info=Db::name('settime')->update($_POST);
            if($info){
                $info = array('code'=>1,'msg'=>'设置成功');
            }else{
                $info = array('code'=>2,'msg'=>'设置失败');
            }
            return json($info);
        }
        $list=Db::name('settime')->where('id',1)->find();
        $list['starttime']=date('Y-m-d H:i:s',$list['starttime']);
        $list['endtime']=date('Y-m-d H:i:s',$list['endtime']);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function work_books()
    {
        if (!empty($_GET['id'])) {
            if (!empty($_POST['search_field'])) {
                $where['uname'] = array('like', '%' . $_POST["search_field"] . '%');
            }
            if (!empty($_POST['title'])) {
                $where['title'] = array('in', $_POST["title"]);
            }
            if (!empty($_POST['department'])) {
                $where['department'] = array('in', $_POST["department"]);
            }
            if (!empty($_POST['projects'])) {
                $where['project'] = array('in', $_POST["projects"]);
            }
            if (!isset($where)) {
                $where = '1=1';
            }
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol = ($page - 1) * $limit;
            $count = Db::name('work_books')->where($where)->count();
            $list = Db::name('work_books')->where($where)->order('id desc')->limit($tol, $limit)->select();
            return ["code" => "0", "msg" => "", "count" => $count, "data" => $list];
        }
        $timeType = db::name('work_books')->field('id,title')->group('title')->select();
        $department = db::name('framework')->field('id,name')->where('pid',14)->select();
        return $this->fetch('',['timeType'=>$timeType,'department'=>$department]);
    }

    public function WorkBookDel()
    {
        if(Db::name('work_books')->where('id',input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }




}
