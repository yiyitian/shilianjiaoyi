<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Cookie;

class Lecturer extends Common
{
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    public function adduserClass(){
        $class_id=$_REQUEST['id'];//获取课程id

    }

    public function ceshis()
    {
      echo 123;
    }

     public function addClass()
    {
      return $this->fetch('addAll',['pid'=>input('pid'),'levels'=>1]);
    }
    public function editClass()
    {
      if (Request::instance()->isPost())
        {
            if(db::name('classinfo')->update(input('')))
            {
              return json(['code'=>1,'msg'=>'修改成功']);
            }else{
              return json(['code'=>2,'msg'=>'修改失败']);
            }
        }
      $info = db::name('classinfo')->where('id',input('id'))->find();
      return $this->fetch('addAll',['pid'=>$info['pid'],'levels'=>$info['levels'],'list'=>$info]);
    }


    public function getTrainUsers()
    {
        if($_SESSION['think']['role_title']=='地区业管'){
            $where['headmaster'] = $_SESSION['think']['user_name'];
        }
        $info = input('');
                $wheres['work_id'] = strtoupper($info['work_id']);

        if($info['is_train'] != 1)//未培训
        {
            if(!empty($info['username'])){
                $where['id']=array('in',$info['username']);
            }
            if(!empty($info['project'])){
                $where['projectname']=array('in',$info['project']);
            }
            $classify = getClassInfo();
            $project = getProjectTitle();
            $department = getFramework();
            $station = getStations();
            if(!empty($info['classify'])){
                $date = $info['classify'];
                if(strstr($date, ','))
                {
                    return ["code"=>"0","msg"=>"","count"=>0,"data"=>0];
                }
                $where['is_quit']='-1';
                $where['del']='-1';
                //判断筛选人员是否为空
                $id_list=Db::name('users')->where($where)
                    ->where("!find_in_set(".$date.",classid)")
                    ->field('id,work_id,username,region,department,station,projectname,phone')->select();
                if(empty($id_list)){
                    $data['code'] = 0;
                    $data['msg'] = '筛选范围内，没有任何员工';
                    return json($data);
                }
                foreach($id_list as $k=>$val)
                {
                    $id_list[$k]['region'] = $department[$val['region']];
                    $id_list[$k]['department'] = $department[$val['department']];
                    $id_list[$k]['project'] = $project[$val['projectname']];
                    $id_list[$k]['station'] = $station[$val['station']];
                }

                return ["code"=>"0","msg"=>"","count"=>count($id_list),"data"=>$id_list];
            }
        }else{//已培训
            if(!empty($info['classify'])){
                $wheres['classify_id']=array('in',$info['classify']);
            }
            if((int)$info['is_qualified'] !==3)
            {
                $wheres['branch'] = $info['is_qualified'] > 0 ? ['EGT',90] : ['LT',90];
            }
            if(!empty($info['username']))
            {
                $wheres['uid']=array('in',$info['username']);
            }
            $list = db::name('train')->where($wheres)->select();
            return ["code"=>"0","msg"=>"","count"=>count($list),"data"=>$list];
        }
    }

    
    public function editTi()
    {
if (Request::instance()->isPost())
        {

       unset($_POST['add']);
            unset($_POST['act']);
            unset($_POST['quiz1']);
            unset($_POST['quiz2']);
            $find = array("‘","’","“","”");
            $info = db::name('class_info')->where('id',$_POST['quiz3'])->find();
            unset($_POST['quiz3']);

            $_POST['title'] = $info['title'];
            $_POST['cid']  = $info['id'];
            $infos =  Db::name('classinfo')->update($_POST);
            if($infos)
            {
                $infoq = array('code'=>1,'msg'=>'修改成功');
            }else{
                $infoq = array('code'=>2,'msg'=>'修改失败');
            }
            return json($infoq);
}

      $list = db::name('classinfo')->where('id',input('id'))->find();
      $infos = db::name('class_info')->where('id',$list['cid'])->find();
      $infoList = db::name('class_info')->where('pid',$infos['pid'])->select();
      $pInfo = db::name('class_info')->where('id',$infos['pid'])->find();
      $pInfoList = db::name('class_info')->where('pid',$pInfo['pid'])->select();
      $fInfo = db::name('class_info')->where('id',$pInfo['pid'])->find();

      $this->assign('cate',db::name('class_info')->where('pid',0)->select());
            $this->assign('pid',$list['pid']);
            $this->assign('levels',2);
                        $this->assign('list',$list);

      return $this->fetch('classinfo_add',['infoList'=>$infoList,'pInfoList'=>$pInfoList,'fInfo'=>$fInfo,'pInfo'=>$pInfo,'infos'=>$infos]);
    }

    public function addAll()
    {
      if (Request::instance()->isPost())
        {
            if(db::name('classinfo')->insert(input('')))
            {
              return json(['code'=>1,'msg'=>'新增成功']);
            }else{
              return json(['code'=>2,'msg'=>'新增失败']);
            }
        }
      return $this->fetch('addAll',['pid'=>input('pid'),'levels'=>input('levels')]);
    }

    /*
     * 保留方法
     * */
    public function index()
    {
        if(isset($_GET['id']))
        {
            if(!empty($_POST['username'])){
                $where['username']= $_POST['username'];
            }
            if(!empty($_POST['types'])){
                $where['types']=$_POST['types'];
            }
            $where['levels'] = '普通';
            $count=Db::name('lecturer')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('lecturer')->where($where)->order('id asc')->limit($tol,$limit)->select();
            foreach($list as $key => $val){
                $list[$key]['username']=Db::name('users')->where(['id'=>$val['users_id']])->value('username');
                if(!empty($val['classid'])){
                    $list[$key]['menshu']=substr_count($val['classid'],',')+1;//授课门数
                }else{
                    $list[$key]['menshu']=0;//授课门数
                }
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }


        return $this->fetch('',['list'=>db::name('framework')->where('pid','in','14,15')->select()]);
    }

    public function add()
    {
        if (Request::instance()->isPost())
        {
            $arr=explode('--',$_POST['users_id']);
            $where['username']=$arr[0];
            $where['work_id']=$arr[1];
            $_POST['users_id']=Db::name('users')->where($where)->value('id');
            $info =Db::name('users')->where($where)->update(['is_teacher'=>1]);
            if($info)
            {
                $info =  Db::name('lecturer')->insert($_POST);
                //Db::name('classinfo')->getLastsql();
                if($info)
                {
                    $info = array('code'=>1,'msg'=>'添加成功');
                }else{
                    $info = array('code'=>2,'msg'=>'添加讲师失败');
                }
            }else{
                $info = array('code'=>2,'msg'=>'修改员工讲师状态失败');
            }

            return json($info);
        }

        $where['is_teacher']=array('neq','1');
        $where['del']=array('neq','1');
    $this->assign('users',Db::name('users')->where($where)->select());
        $classname=Db::name('classinfo')->where('levels','2')->select();
        //var_dump($classname);
        $this->assign('classname_pid',Db::name('classinfo')->where('levels','1')->select());
        $this->assign('classname',$classname);
        return $this->fetch();
    }

    /*
     * 编辑zl
     * */
    public function edit()
    {
        if (Request::instance()->isPost())
        {
      //var_dump($_REQUEST);exit;
      $count_check=Db::name('lecturer')->where('id',$_REQUEST['id'])->count();
      if($count_check=='0'){
        $info=Db::name('lecturer')->insert($_REQUEST);
        if($info!==false)
        {
          $data['code'] = 1;
          $data['msg'] = '新增成功';
        }else{
          $data['code'] = 0;
          $data['msg']= '新增失败';
        }
      }else{
        $info = Db::name('lecturer')->update($_POST);
        if($info!==false)
        {
          $data['code'] = 1;
          $data['msg'] = '更新成功';
        }else{
          $data['code'] = 0;
          $data['msg']= '更新失败';
        }
      }
      
            
            return json($data);
        }else{
      $id=$_REQUEST['id'];
      
            $date = Db::name('lecturer')->where('users_id',$id)->find();
            $date['users_name']= Db::name('users')->where('id',$date['users_id'])->value('username');
      //var_dump($date);exit;
      if(!empty($date['classname'])){
        //$date['classname']=explode(",", $date['classname']);
      }
      $date['usersname']=Db::name('users')->where('id',$id)->field('username')->find();
      //var_dump($date['classname']);exit;
            $this->assign('id',$id);
      $classname=Db::name('classinfo')->where('levels','>','0')->select();
      //var_dump($classname);
            $this->assign('classname',$classname);
            $this->assign('classname_pid',Db::name('classinfo')->where('levels','1')->select());
            $this->assign('list',$date);
            $this->assign('users',Db::name('users')->where('is_teacher','neq','1')->select());
            return $this->fetch('add');
        }


    }
    /*
     * 删除
     * */
    public function del()
    {
        $id=$_REQUEST['id'];

        $data = Db::name('lecturer')->where('id',$id)->find();

        $info =Db::name('users')->where(['id'=>$data['users_id']])->update(['is_teacher'=>'-1']);

        if($info)
        {
            $info =  Db::name('lecturer')->delete($id);
            //Db::name('classinfo')->getLastsql();
            if($info)
            {
                $info = array('code'=>1,'msg'=>'删除讲师信息成功');
            }else{
                $info = array('code'=>2,'msg'=>'删除讲师信息失败');
            }
        }else{
            $info = array('code'=>2,'msg'=>'修改员工讲师状态失败');
        }

        return json($info);
    }

    /*
     * 讲师记录
     */
    public function lecturer_search(){
        if(Request::instance()->isPost()){
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
            $array[0]=$array[0].' 0:0:0';
            $array[1]=$array[1].' 23:59:59';
            $where['del']=-1;
            $where['startdate']=array('between',$array);
            $outline=Db::name('outline')->where($where)->select();
            $times_arr=Db::name('outline_lecturer')->where('lecturer','neq','')->distinct(true)->column('times');
            if(empty($times_arr)){
                return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
            }
            foreach ($times_arr as $key => $val){
                $classify_arr[]=Db::name('outline')->where('times',$val)->value('classify');
            }
            $classify_arr=array_unique($classify_arr);
            $area=Db::name('outline')->where('times','in',implode(',',$times_arr))->field('area')->select();
            foreach ($area as $key => $val){
                $area_arr[]=$val['area'];
            }
            $area_arr=array_unique($area_arr);
            if($_POST['area']==1){
               foreach ($area_arr as $key_area => $val_area){
                   foreach ($outline as $k => $v) {
                       if($v['area']==$val_area) {
                           foreach ($classify_arr as $key_classify => $val_classify) {
                               if ($v['classify'] == $val_classify) {
                                   $outline_lecturer = Db::name('outline_lecturer')
                                       ->where(['times' => $v['times']])
                                       ->where('lecturer', 'neq', '')
                                       ->select();
                                   if (!empty($outline_lecturer)) {
                                       foreach ($outline_lecturer as $key => $val) {
                                           if (!isset($data[$val_classify][$val['lecturer']]['classnum'])) {
                                               $data[$val_classify][$val['lecturer']]['classnum'] = 0;
                                           }
                                           if (!isset($data[$val_classify][$val['lecturer']]['classtime'])) {
                                               $data[$val_classify][$val['lecturer']]['classtime'] = 0;
                                           }
                                           $data[$val_classify][$val['lecturer']]['users_id'] = $val['lecturer'];
                                           $data[$val_classify][$val['lecturer']]['classnum']++;                          //上课次数classnum
                                           $data[$val_classify][$val['lecturer']]['classtime'] += $val['classtime'];          //上课时长classtime
                                           $data[$val_classify][$val['lecturer']]['work_id'] = Db::name('users')->where('id', $val['lecturer'])->value('work_id');
                                           $data[$val_classify][$val['lecturer']]['username'] = Db::name('users')->where('id', $val['lecturer'])->value('username');
                                           $data[$val_classify][$val['lecturer']]['station'] = Db::name('posts')->where('id', Db::name('users')->where('id', $val['lecturer'])->value('station'))->value('posts');
                                           $data[$val_classify][$val['lecturer']]['classify'] = Db::name('classinfo')->where('id', Db::name('outline')->where('times', $val['times'])->value('classify'))->value('title');
                                           $data[$val_classify][$val['lecturer']]['area'] = $val_area;
                       if(!empty($_POST['lecturer'])){
                         if($val['lecturer']!=$_POST['lecturer']){
                           unset($data[$val_classify][$val['lecturer']]);
                         }
                       }
                                       }
                                   }


                               }
                 if(isset($data[$val_classify])&&empty($data[$val_classify])){
                   unset($data[$val_classify]);
                 }
                           }
                       }
                   }
               }
      if(!empty($data)){
        foreach ($data as $key => $val){
          foreach ($val as $k => $v){
            $new_arr[]=$v;
          }
        }
      }else{
          $new_arr=[];
        }
      }else if($_POST['area'] == 3)
      {

         foreach ($area_arr as $key_area => $val_area){
                   foreach ($outline as $k => $v) {
                       if($v['area']==$val_area) {
                           foreach ($classify_arr as $key_classify => $val_classify) {
                               if ($v['classify'] == $val_classify) {
                                   $outline_lecturer = Db::name('outline_lecturer')
                                       ->where(['times' => $v['times']])
                                       ->where('lecturer', 'neq', '')
                                       ->select();
                                   if (!empty($outline_lecturer)) {
                                       foreach ($outline_lecturer as $key => $val) {
                                           if (!isset($data[$val_classify][$val['lecturer']]['classnum'])) {
                                               $data[$val_classify][$val['lecturer']]['classnum'] = 0;
                                           }
                                           if (!isset($data[$val_classify][$val['lecturer']]['classtime'])) {
                                               $data[$val_classify][$val['lecturer']]['classtime'] = 0;
                                           }
                                           $data[$val_classify][$val['lecturer']]['users_id'] = $val['lecturer'];
                                           $data[$val_classify][$val['lecturer']]['classnum']++;                          //上课次数classnum
                                           $data[$val_classify][$val['lecturer']]['classtime'] += $val['classtime'];          //上课时长classtime
                                           $data[$val_classify][$val['lecturer']]['work_id'] = Db::name('users')->where('id', $val['lecturer'])->value('work_id');
                                           $data[$val_classify][$val['lecturer']]['username'] = Db::name('users')->where('id', $val['lecturer'])->value('username');
                                           $data[$val_classify][$val['lecturer']]['station'] = Db::name('posts')->where('id', Db::name('users')->where('id', $val['lecturer'])->value('station'))->value('posts');
                                           $data[$val_classify][$val['lecturer']]['classify'] = Db::name('classinfo')->where('id', Db::name('outline')->where('times', $val['times'])->value('classify'))->value('title');
                                           $data[$val_classify][$val['lecturer']]['area'] = $val_area;
                       if(!empty($_POST['lecturer'])){
                         if($val['lecturer']!=$_POST['lecturer']){
                           unset($data[$val_classify][$val['lecturer']]);
                         }
                       }
                                       }
                                   }


                               }
                 if(isset($data[$val_classify])&&empty($data[$val_classify])){
                   unset($data[$val_classify]);
                 }
                           }
                       }
                   }
               }
            //$data计算出了每个讲师的，上课时长classtime,上课次数classnum
      if(!empty($data)){
        foreach ($data as $key => $val){
          foreach ($val as $k => $v){
            $new_arr[]=$v;
          }
        }
      }else{
          $new_arr=[];
        }
           }else if($_POST['area'] == 2)
           {
                foreach ($area_arr as $key_area => $val_area){
                   foreach ($outline as $k => $v) {
                       if($v['area']==$val_area) {
                           foreach ($classify_arr as $key_classify => $val_classify) {
                               if ($v['classify'] == $val_classify) {
                                   $outline_lecturer = Db::name('outline_lecturer')
                                       ->where(['times' => $v['times']])
                                       ->where('lecturer', 'neq', '')
                                       ->select();
                                   if (!empty($outline_lecturer)) {
                                       foreach ($outline_lecturer as $key => $val) {
                                           if (!isset($data[$val_classify][$val['lecturer']]['classnum'])) {
                                               $data[$val_classify][$val['lecturer']]['classnum'] = 0;
                                           }
                                           if (!isset($data[$val_classify][$val['lecturer']]['classtime'])) {
                                               $data[$val_classify][$val['lecturer']]['classtime'] = 0;
                                           }
                                           $data[$val_classify][$val['lecturer']]['users_id'] = $val['lecturer'];
                                           $data[$val_classify][$val['lecturer']]['classnum']++;                          //上课次数classnum
                                           $data[$val_classify][$val['lecturer']]['classtime'] += $val['classtime'];          //上课时长classtime
                                           $data[$val_classify][$val['lecturer']]['work_id'] = Db::name('users')->where('id', $val['lecturer'])->value('work_id');
                                           $data[$val_classify][$val['lecturer']]['username'] = Db::name('users')->where('id', $val['lecturer'])->value('username');
                                           $data[$val_classify][$val['lecturer']]['station'] = Db::name('posts')->where('id', Db::name('users')->where('id', $val['lecturer'])->value('station'))->value('posts');
                                           $data[$val_classify][$val['lecturer']]['classify'] = Db::name('classinfo')->where('id', Db::name('outline')->where('times', $val['times'])->value('classify'))->value('title');
                                           $data[$val_classify][$val['lecturer']]['area'] = $val_area;
                                          
                                           if(!empty($_POST['posts'])){
                                               if( $data[$val_classify][$val['lecturer']]['station'] !==$_POST['posts']){
                                                   unset($data[$val_classify][$val['lecturer']]);
                                               }
                                           }
                                       }
                                   }


                               }
                               if(isset($data[$val_classify])&&empty($data[$val_classify])){
                                   unset($data[$val_classify]);
                               }
                           }
                       }
                   }
                }
if(!empty($data)){
                    foreach ($data as $key => $val){
                       foreach ($val as $k => $v){
                           $new_arr[]=$v;
                       }
                    }
                }else{
                    $new_arr=[];
                }
           
           }else{
               //计算每个讲师的课时，上课次数classtime时长，classnum上课次数

               foreach ($classify_arr as $key_classify => $val_classify) {
                   foreach ($outline as $k => $v) {

                       if($v['classify']==$val_classify){
                           $outline_lecturer=Db::name('outline_lecturer')
                               ->where(['times'=>$v['times']])
                               ->where('lecturer','neq','')
                               ->select();
                           if(!empty($outline_lecturer)){
                               foreach ($outline_lecturer as $key=> $val) {
                   
                  if(!isset($data[$val_classify][$val['lecturer']]['classnum'])){$data[$val_classify][$val['lecturer']]['classnum']=0;}
                  if(!isset($data[$val_classify][$val['lecturer']]['classtime'])){$data[$val_classify][$val['lecturer']]['classtime']=0;}
                  $data[$val_classify][$val['lecturer']]['users_id'] = $val['lecturer'];
                  $data[$val_classify][$val['lecturer']]['classnum']++;                          //上课次数classnum
                  $data[$val_classify][$val['lecturer']]['classtime'] += $val['classtime'];          //上课时长classtime
                  $data[$val_classify][$val['lecturer']]['work_id'] = Db::name('users')->where('id', $val['lecturer'])->value('work_id');
                  $data[$val_classify][$val['lecturer']]['username'] = Db::name('users')->where('id', $val['lecturer'])->value('username');
                  $data[$val_classify][$val['lecturer']]['station'] = Db::name('posts')->where('id', Db::name('users')->where('id', $val['lecturer'])->value('station'))->value('posts');
                  $data[$val_classify][$val['lecturer']]['classify'] = Db::name('classinfo')->where('id', Db::name('outline')->where('times', $val['times'])->value('classify'))->value('title');
                  if(!empty($_POST['lecturer'])){
                     if($val['lecturer']!=(int)$_POST['lecturer']){
                       unset($data[$val_classify][$val['lecturer']]);
                     }
                   }
                               }
                           }


                       }
             if(isset($data[$val_classify])&&empty($data[$val_classify])){
               unset($data[$val_classify]);
             }
                   }
               }

        if(!empty($data)){
          foreach ($data as $key => $val){
             foreach ($val as $k => $v){
               $new_arr[]=$v;
             }
          }
        }else{
          $new_arr=[];
        }
           }
            $data=array_values($new_arr);

            if($_POST['area'] == 3)
            {

              $u = array();
        foreach ($data as $k => $v){
            if (!in_array($v['work_id'],$u)){
                $u[] = $v['work_id'];
            }
        }
        $datas = array();
        foreach ($u as $uk => $uv)
        {
            foreach ($data as $pk => $pv)
            {

                if ($pv['work_id'] == $uv)
                {
                    $datas[$uv]['station'] = $pv['station'];
                    $datas[$uv]['work_id'] = $pv['work_id'];
                                        $datas[$uv]['area'] = $pv['area'];

                    $datas[$uv]['users_id'] = $pv['users_id'];
                    $datas[$uv]['station'] = $pv['station'];
                     $datas[$uv]['username'] = $pv['username'];
                      if(!isset($datas[$uv]['classtime']))
                      {
$datas[$uv]['classtime'] = 0;
                      }
                       if(!isset($datas[$uv]['classnum']))
                      {
$datas[$uv]['classnum'] = 0;
                      }
                    $datas[$uv]['classtime'] += $pv['classtime'];
                    $datas[$uv]['classnum'] += $pv['classnum'];
         
                }
                
            }
        }

        $data = array_values($datas);
            }
          
        
       
           //var_dump($data);exit;
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        $date = Db::name('users')->field('station')->where('is_teacher',1)->where('is_quit',-1)->select();

        foreach($date as $k)
        {
            $ddd[] = $k['station'];
        }
        $ddd = array_unique($ddd);
        $dd = Db::name('posts')->where('id','in',$ddd)->select();
        $this->assign('posts',$dd);
    $this->assign('lecturer',Db::name('users')->where('is_teacher',1)->where('is_quit',-1)->select());
        return $this->fetch();
    }
    public function getceshi()
    {
      $info = db::name('lecturer')->select();
      foreach($info as $K=>$v)
      {
            $v['username'] = db::name('users')->where('id',$v['users_id'])->value('username');
            db::name('lecturer')->update($v);
      }
     
    }
    public function teacherLog()
    {
        if (Request::instance()->isPost())
        {
            if($_SESSION['think']['role_title']=='地区业管'){
                $where['userid']=$_SESSION['think']['user_id'];
            }
            $user = db::name('lecturer')->select();
            foreach($user as $k=>$v)
            {
              $userInfo[$v['users_id']][] = $v['username'];
              $userInfo[$v['users_id']][] = $v['types'];
            }
            $getClassInfo = getClassInfo();//获取课程名称
            $getFramework = getFramework();
            $array=explode(' - ', input('time_code'));
            $array[0] = $array[0].'-01';
            $array[1] = $array[1].'-30';
            $where['startdate']=array('between',$array);///员工入职时间
            $where['del']=array('neq','1');
            $where['status'] = 1;
            $where['is_outline'] = array('eq','线下课程');

            $list =Db::name('outline')->field('area,times,address,classify,username,startdate,address,enddate,real_number')->where($where)->order('startdate desc')->select();
            foreach($list as $k=>$v)
            {
                $class = db::name('outline_lecturer')->where('lecturer','neq','')->where('times',$v['times'])->select();
                foreach($class as $key=>$val)
                {
                  $sql = "select avg(a) as a,avg(b) as b,avg(c) as c,avg(d) as d,avg(e) as e,avg(f) as f,avg(g) as g from shilian_scoring where uid = ".$val['lecturer']." and time = ".$val['times'];
                    $info = db::query($sql);
                    $dateArr[] = $val+$info[0];
                }
            }
            if(empty($dateArr))
            {
                return ["code"=>"0","msg"=>"","count"=>'0',"data"=>0];
            }
            db::name('linshi')->where('id','neq', 0)->delete();
            db::name('linshi')->insertAll($dateArr);
            $sqls = "select avg(a) as a,avg(b) as b,avg(c) as c,avg(d) as d,avg(e) as e,avg(f) as f,avg(g) as g ,lecturer ,count(lecturer) as num, sum(classtime) as chang  from shilian_linshi group by lecturer";
            $array = db::query($sqls);
            foreach($array as $k=>$v)
            {
                if(!empty($v['a']))
                {
                    $v['a'] = round($v['a'], 2);
                    $v['b'] = round($v['a'], 2);
                    $v['c'] = round($v['a'], 2);
                    $v['d'] = round($v['a'], 2);
                    $v['e'] = round($v['a'], 2);
                    $v['f'] = round($v['a'], 2);
                    $v['g'] = round($v['a'], 2);
                    $v['count'] = round(((float)$v['a']+(float)$v['b']+(float)$v['c']+(float)$v['d']+(float)$v['e']+(float)$v['f']+(float)$v['g']),2);
                }
              $types = isset($userInfo[$v['lecturer']])?$userInfo[$v['lecturer']]:[];
               $s= db::name('users')->where('id',$v['lecturer'])->find();
              $v['department']   = db::name('framework')->where('id',$s['department'])->value('name');
                $v['work_id'] = $s['work_id'];
                $v[0] = $s['username'];

              $infoArrs[] = $v+$types;

            }


            return ["code"=>"0","msg"=>"","count"=>count($infoArrs),"data"=>$infoArrs];
        }
        return $this->fetch();
    }


    public function teacherDetails()
    {
        if (Request::instance()->isAjax())
        {
            $getClassInfo = getClassInfo();//获取课程名称
            $array=explode(' - ', input('code'));
            $where['startdate']=array('between',$array);///员工入职时间
            $where['del']=array('neq','1');
            $where['status'] = 1;
            $where['is_outline'] = array('eq','线下课程');
            $count=Db::name('outline')->field('times')->where($where)->select();
            foreach($count as $k=>$v){
                $date[] = $v['times'];
            }
            $list = db::name('outline_lecturer')->where('lecturer',input('uid'))->where('times','in',$date)->select();
            foreach($list as $k=>$v)
            {
                $sql = "select avg(a) as a,avg(b) as b,avg(c) as c,avg(d) as d,avg(e) as e,avg(f) as f,avg(g) as g from shilian_scoring where tid = ".$v['lecturer']." and time = ".$v['times'];
                $info = db::query($sql);
                $outline = db::name('outline')->field('username as master,startdate,classify')->where('times',$v['times'])->find();
                $outline['classify'] = $getClassInfo[$outline['classify']];
                $data[] = $v+$info[0]+$outline;
            }
            return ["code"=>"0","msg"=>"","count"=>'0',"data"=>$data];
        }
        return $this->fetch('',['code'=>input('time_code'),'uid'=>input('id')]);
    }
    /*
     * 上传方法
     * */
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
            return json($ret);
        }
    }
    /*
     * 文件上传实际操作
     * */
    private  function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录�?
        $info = $file->move(ROOT_PATH . 'public/uploads');
        $reubfo = array();  
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();;
        }
        return $reubfo;
    }
    public function addonemore(){
        if (Request::instance()->isPost()) {
            $usersid=Db::name('notice')->where('id',$_POST['id'])->value('usersid');
            if(!empty($usersid)){
                $_POST['usersid']=$usersid.','.$_POST['usersid'];
            }
            $info=Db::name('notice')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else
        {
            //列出“未上过此课程分类”的员工
            $this->assign('id', Db::name('notice')->where('times',$_GET['times'])->value('id'));
            $this->assign('classify', $_GET['classify']);
             $users1=Db::name('users')
                ->where("classid",null)
                ->order('id asc')->select();
            $users=Db::name('users')
                ->where("!find_in_set(".$_GET['classify'].",classid)")
                ->order('id asc')->select();
            $users = array_merge($users1,$users);
            $this->assign('users',$users);
            return $this->fetch();
        }
    }
    /*
     * 筛选通知人员
     */
    public function noticeusers(){
        $Info = input('');
        if(isset($Info['get_list'])){
            $this_date=Db::name('notice')->where('times',$Info['get_list'])->find();
            if(!empty($this_date['usersid'])){
                $list=Db::name('users')->where('id','in',$this_date['usersid'])->where('id','not in','1,3')->select();
            }
            if(!empty($list)){
                foreach ($list as $key => $val){
                    $list[$key]['region_name']=Db::name('framework')->where('id',$val['region'])->value('name');
                    $list[$key]['department_name']=Db::name('framework')->where('id',$val['department'])->value('name');
                    $list[$key]['station_name']=Db::name('posts')->where('id',$val['station'])->value('posts');
                    $list[$key]['project_name'] = Db::name('project')->where('id',$val['projectname'])->value('name');
                    $list[$key]['num'] = Db::name('notice')->where("find_in_set(".$val['id'].",usersid)")->where('classify',$this_date['classify'])->count();

                    if(Db::name('users')->where('id',$val['id'])->where("find_in_set(".$this_date['classify'].",classid)")->count()>0){
                        $list[$key]['is_done'] ='已上课';

                        $dd[] = $val['id'];
                    }else{
                        $list[$key]['is_done'] ='未上课';
                    }
                }
            }else
            {
                $list='';
            }
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
        }

        if(isset($Info['reset'])){
            Db::name('notice')->where('times',$Info['times'])->update(['usersid'=>'']);
            return ['code'=>1,'msg'=>'筛选人员已清空'];
        }
        switch ($Info['classify']) {
            case 11:
                $find_in_set = 'find_in_set("8",classid) and find_in_set("9",classid)';
                $classId['classify_id'] = array('in','8,9');
                break;
            case 10:
                $find_in_set = 'find_in_set("9",classid) and find_in_set("8",classid) and find_in_set("11",classid)';
                $classId['classify_id'] = array('in','8,9,11');
                break;
            case 15:
                $find_in_set = 'find_in_set("13",classid) and find_in_set("14",classid)';
                $classId['classify_id'] = array('in','13,14');
                break;
            case 16:
                $find_in_set = 'find_in_set("13",classid) and find_in_set("14",classid) and find_in_set("15",classid)';
                $classId['classify_id'] = array('in','13,14,15');
                break;
            default:
                $find_in_set = '1=1';
                $classId = '1=1';
        }
        //重置筛选人员


       if(!empty($Info['department']))
        {
            $where['department']=array('in',$Info['department']);
            $wheres['department']=array('in',$Info['department']);
        }
        if(!empty($Info['station']))
        {
            $where['station']=array('in',$Info['station']);
            $wheres['station']=array('in',$Info['station']);
        }
        if(!empty($Info['project']))
        {
            $where['projectname']=array('in',$Info['project']);
            $wheres['project_id']=array('in',$Info['project']);
        }

        if(!empty($Info['start_time'])){
            $array_time[0]=date('Y-m-d H:i:s',strtotime($Info['start_time'])-1);
            $array_time[1]=$Info['end_time'];
            $where['start_time']=array('between',$array_time);
            $wheres['startdate']=array('between',$array_time);
        }
        if(empty($where)){
            $data['code'] = 0;
            $data['msg'] = '请添加筛选通知培训人员条件';
            return json($data);
        }
        $data['where']=$where;
        $where['is_quit']='-1';
        $where['del'] = -1;
        $id_lists=Db::name('users')->where($where)->where('classid',null)->where($find_in_set)->field('id')->select();
        $id_list=Db::name('users')->where($where)
            ->where("!find_in_set(".$Info['classify'].",classid)")
            ->where($find_in_set)
            ->field('id')->select();
        $id_list = array_merge($id_list,$id_lists);
        $wheres['classify_id'] = $Info['classify'];
        $wheres['branch'] = ['LT',90];
        $dd = db::name('train')->field('uid')->where($wheres)->select();
        if(!empty($dd))
        {
            foreach($dd as $val)
            {
                $ddInfo = db::name('users')->where('id',$val['uid'])->value('is_quit');
                if($ddInfo<1)
                {
                    $noClassify[] = $val['uid'];
                }
            }
        }
        foreach($id_list as $key => $val){
            $ids[]=$val['id'];
        }
        $noBranch = db::name('train')->field('uid')->where('branch','LT',90)->where($classId)->where('uid','in',$ids)->select();
        if(!empty($noBranch))
        {
            foreach($noBranch as $key => $val)
            {
                if(in_array($val['uid'],$ids))
                {
                    $ids  = array_merge(array_diff($ids,array($val['uid'])));
                }
            }
        }
        if(!empty($noClassify))
        {
            $array['usersid']=implode(',',$ids).',1,3,'.implode(',',$noClassify);
        }else{
            $array['usersid']=implode(',',$ids).',1,3';
        }
        if(empty($array)){
            $data['code'] = 0;
            $data['msg'] = '筛选范围内，没有任何员工';
            $usersid=Db::name('notice')->where('times',$Info['times'])->value('usersid');
            $list=Db::name('users')->where('id','in',$usersid)->select();
            foreach ($list as $key => $val){
                $list[$key]['region_name']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department_name']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station_name']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['project_name'] = Db::name('project')->where('id',$val['projectname'])->value('name');
                $list[$key]['num'] = Db::name('notice')->where("find_in_set(".$val['id'].",usersid)")->where('classify',$Info['classify'])->count();
            }
            $data['data'] =$list;
            return json($data);
        }
        session('idss',$dd);
        $array['inputtime']=time();
        $array['classify']=$Info['classify'];
        $array['times']=$Info['times'];
        //若已存在此课程的通知，仅更新
        if(Db::name('notice')->where('times',$Info['times'])->count()>0)
        {
            $usersid=Db::name('notice')->where('times',$Info['times'])->value('usersid');
            if(!empty($usersid)){
                $array['usersid']=$array['usersid'];
            }
            if(Db::name('notice')->where('times',$Info['times'])->update($array)){
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else {
                $data['code'] = 0;
                $data['msg'] = '修改通知信息失败';
            }
        }else{
            if(Db::name('notice')->insert($array)){
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else {
                $data['code'] = 0;
                $data['msg'] = '添加通知信息失败';
            }
        }
        if($data['code']==1){
            $list=Db::name('users')->where('id','in',$array['usersid'])->where('id','not in','1,3')->select();
            foreach ($list as $key => $val){
                $list[$key]['region_name']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department_name']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station_name']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['project_name'] = Db::name('project')->where('id',$val['projectname'])->value('name');
                $list[$key]['num'] = Db::name('notice')->where("find_in_set(".$val['id'].",usersid)")->where('classify',$Info['classify'])->count();
            }
            return ["code"=>"0","msg"=>"筛选成功","count"=>'',"data"=>$list];
        }else{
            return json($data);
        }

    }

      /*
     * 筛选通知人员
     */
    public function getdiaocha(){
        if(isset($_GET['get_list'])){
            $answers=Db::name('notice')->where('times',$_GET['get_list'])->value('usersid');
            $answer = db::name('train')->where('uid','in',$answers)->where('class_time',$_GET['get_list'])->where('uid','not in','1,3')->select();
            return ["code"=>"0","msg"=>"筛选成功","count"=>'',"data"=>$answer];
        }
    }
    /*
     * 筛选通知人员
     */
    public function noticeusers_timely(){

        //获取已添加的需要通知的人员信息start
        if(isset($_GET['get_list'])){

$where['department'] = ['in',$_GET['get_lists']];
            $where['station'] = ['in',$_GET['get_list']];
            $where['is_quit'] = ['eq','-1'];
            $where['del']   =   ['eq','-1'];

            $list=Db::name('users')->where($where)->order('department')->select();


            if(!empty($list)){
                foreach ($list as $key => $val){
                    $list[$key]['region_name']=Db::name('framework')->where('id',$val['region'])->value('name');
                    $list[$key]['department_name']=Db::name('framework')->where('id',$val['department'])->value('name');
                    $list[$key]['station_name']=Db::name('posts')->where('id',$val['station'])->value('posts');
                    $list[$key]['project_name'] = Db::name('project')->where('id',$val['projectname'])->value('name');
                    $list[$key]['xinde'] = Db::name('tips')->where(['uid'=>$val['id'],'classname'=>$_GET['classname']])->value('remark');
                                                            
                    if(Db::name('users')->where('id',$val['id'])->where("find_in_set(".$_GET['classname'].",classname)")->count()>0){
                        $list[$key]['is_done'] ='已上课';
                    }else{
                        $list[$key]['is_done'] ='未上课';
                    }

                }
            }else
            {
                $list='';
            }

            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];

        }
//获取已添加的需要通知的人员信息end
        //$_POST['department'];//部门
        //$_POST['station'];//岗位
        //$_POST['start_time'];//入职时间范围
        if(!empty($_POST['department']))
            $where['department']=$_POST['department'];
        if(!empty($_POST['station']))
            $where['station']=$_POST['station'];
        if(!empty($_POST['project']))
            $where['projectname']=$_POST['project'];

        if(!empty($_POST['start_time'])){
            $array_time=explode(' - ', $_POST['start_time']);

            $array_time[0]=date('Y-m-d H:i:s',strtotime($array_time[0])-1);
            //$array[1]=date('Y-m-d H:i:s',strtotime($array[1]));
            $where['start_time']=array('between',$array_time);
        }
        if(empty($where)){
            $data['code'] = 0;
            $data['msg'] = '请添加筛选通知培训人员条件';
            return json($data);
        }

        //$where['is_teacher']='-1';
        $where['is_quit']='-1';
        //判断筛选人员是否为空
        $id_list=Db::name('users')->where($where)
            ->where("!find_in_set(".$_POST['classify'].",classid)")
            ->field('id')->select();
        if(empty($id_list)){
            $data['code'] = 0;
            $data['msg'] = '筛选范围内，没有任何员工';
            return json($data);
        }
        //添加或修改完成，开始创建通知信息

        //课程添加/修改成功之后，创建/修改一条“通知”，并记录所有该通知人员的ID

        //准备插入notice
        $ids=array();
        foreach($id_list as $key => $val){
            $ids[]=$val['id'];
        }
        $array['usersid']=implode(',',$ids);
        $array['inputtime']=time();
        $array['classify']=$_POST['classify'];
        $array['times']=$_POST['times'];

        //若已存在此课程的通知，仅更新
        if(Db::name('notice')->where('times',$_POST['times'])->count()>0)
        {
            //更新
            $usersid=Db::name('notice')->where('times',$_POST['times'])->value('usersid');
            if(!empty($usersid)){
                $array['usersid']=$usersid.','.$array['usersid'];
                $array['usersid']=implode(',',array_unique(explode(',',$array['usersid'])));
            }
            if(Db::name('notice')->where('times',$_POST['times'])->update($array)){
                $data['code'] = 1;
                $data['msg'] = '修改成功';

            }else {
                $data['code'] = 0;
                $data['msg'] = '修改通知信息失败';
            }

        }else{
            //添加
            if(Db::name('notice')->insert($array)){
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else {

                $data['code'] = 0;
                $data['msg'] = '添加通知信息失败';
            }

        }
        if($data['code']==1){
            $list=Db::name('users')->where('id','in',$array['usersid'])->select();
            foreach ($list as $key => $val){
                $list[$key]['region_name']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department_name']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station_name']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['project_name'] = Db::name('project')->where('id',$val['projectname'])->value('name');
                $list[$key]['num'] = Db::name('notice')->where("find_in_set(".$val['id'].",usersid)")->where('classify',$_POST['classify'])->count();
            }
            return ["code"=>"0","msg"=>"筛选成功","count"=>'',"data"=>$list];
        }else{
            return json($data);
        }

    }
    public function getqrcode(){
        $time=time();
        //$_POST['question'];
        //var_dump($_POST);exit;
        $this->qrcode('http://'.$_POST['host'].'/api/course/feedback?times='.$_POST['times'].'&question='.$_POST['question'],$time.'.png');

        $_POST['qrcode']='/public/'.$time.'.png';
        if(Db::name('outline')->where('times',$_POST['times'])->count()>0){
            Db::name('outline')->where('times',$_POST['times'])->update(['qrcode'=>$_POST['qrcode']]);
        }

        return json($_POST);
    }
    public function getqrcodes($time){
       
        $this->qrcode('http://app.sz-senox.com/api/course/details?times='.$time,$time.'.png');
        return '/public/'.$time.'.png';
    }
    public function ceshi()
    {
      dd($this->getqrcodes('1586501566'));
    }


     public function getOline($id){
        $time=time();
        //$_POST['question'];
        //var_dump($_POST);exit;
        $this->qrcode('http://47.104.191.142/index/Online/Detail?timely=1&id=59',$time.'.png');
        $code = '/public/'.$time.'.png';
                    Db::name('outline')->where('id',$id)->update(['qrcode'=>$code]);


       

    }



public function tongji()
{
  $this->assign('lists',Db::name('outline')->where('id',input('id'))->find());
  return $this->fetch();
}
  public function aaa(){
    $str="倪飞,王陈萍,田迎港,郑世明,刘蒙,王家梁,刘可心,周长美,邱东青,张自鹏,刘金凤,张毅,刘家美,王珂,杨治斌,李伯皓,刘旭瑞,庞文瑞,王伟伟,彭代保,王迪,王晓华,王允坤,李克,高菊,于新,耿杰,张慧敏,王豪,张雪雪,马婷婷,徐冬,于振,黄亚楠";
        $arr=explode(',',$str);
        //var_dump(array_unique($arr));die;
        foreach ($arr as $key => $val){
            $user=Db::name('users')->where('username',$val)
                //->where('outline_id',0)
                ->field('id,outline_id,classid')->select();
            if(count($user)>1){
                $user_se[]=$val;
            }else{
                if(!empty($user)){
                    $users[]=$user;

                    if(count($user)==1){
                        $user=$user[0];
                    }else{
                        var_dump('重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复重复');die;
                    }
                    var_dump($user);
                    echo'<br>';
                    if(empty($user['outline_id'])){
                        $user['outline_id']=15;
                    }else{
                        $user['outline_id']=$user['outline_id'].',15';
                    }
                    if(empty($user['classid'])){
                        $user['classid']=14;
                    }else{
                        $user['classid']=$user['classid'].',14';
                    }
                    //Db::name('users')->update($user);
                }else{
                    $user_no[]=$val;
                }
            }
        }
        if(isset($user_se)) {
            echo'未找到';
            var_dump($user_se);
            echo '<br>';
        }
        if(isset($user_no)){
            echo'未找到';
            var_dump($user_no);
            echo '<br>';
        }
        //var_dump($users);
        die;
  }
    /*
     * 线下课程
     * */
    public function outline()
    {
    
        if(isset($_GET['id']))
        {
            if($_SESSION['think']['role_title']=='地区业管'){
                //地区业管只能看自己创建的课程
                $where['userid']=$_SESSION['think']['user_id'];
            }
            $where['del']=array('neq','1');
             $where['is_outline'] = array('eq','线下课程');
      $count=Db::name('outline')->where($where)->count();

      $page = $this->request->param('page');
      $limit = $this->request->param('limit');
      $tol=($page-1)*$limit;
      $list =Db::name('outline')->where($where)->order('startdate desc')->limit($tol,$limit)->select();

      foreach($list as $key => $val){
        $list[$key]['classtype']=Db::name('classinfo')->where('id',$list[$key]['classtype'])->value('title');
        $list[$key]['classify']=Db::name('classinfo')->where('id',$list[$key]['classify'])->value('title');
        $list[$key]['classname']=Db::name('classinfo')->where('id',$list[$key]['classname'])->value('title');
        if($val['is_outline'] !== '线下课程')
        {
         
           $wheres['department'] = ['in',$val['department']];
            $wheres['station'] = ['in',$val['station']];
            $wheres['is_quit'] = ['eq','-1'];
            $wheres['del']  = ['eq','-1'];
           $list[$key]['num_hasdone'] = Db::name('users')->where($wheres)->where("find_in_set(".$val['classname'].",classname)")->count();

        }else{

          $list[$key]['num_hasdone'] = Db::name('question_an')->where('times',$val['times'])->count();
        }

       
        $list[$key]['startdate']=date('Y-m-d',strtotime($val['startdate']));
        $list[$key]['enddate']=date('Y-m-d',strtotime($val['enddate']));
        
        
      }

    
            //return json(["code"=>"0","msg"=>"ok","data"=>$list]);
      return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }

        if($_SESSION['think']['role_title']=='总管理员'){
           $show = 1;
        }else{
            $show = 2;
        }
        $this->assign('show',$show);
    $this->assign('nowtime',date('Y-m-d H:i:s',time()));
        $wheres['is_outline'] = array('eq','线下课程');
        $user = db::name('outline')->where($wheres)->group('username')->select();
        $area = db::name('outline')->where($wheres)->group('area')->select();
        $classify  = db::name('outline')->where($wheres)->group('classify')->select();
        foreach($classify as $K)
        {
            $wheress[] = $K['classify'];
        }

        $this->assign('classify',db::name('classinfo')->field('id,title')->where('id','in',$wheress)->select());
        $this->assign('users',$user);
        $this->assign('area',$area);
        return $this->fetch();
    }


     /*
     * 线下课程
     * */
    public function line()
    {
    
        if(isset($_GET['id']))
        {
            if($_SESSION['think']['role_title']=='地区业管'){
                //地区业管只能看自己创建的课程
                $where['userid']=$_SESSION['think']['user_id'];
            }
            $where['del']=array('neq','1');
            $where['is_outline'] = array('neq','线下课程');
      $count=Db::name('outline')->where($where)->count();


      $page = $this->request->param('page');
      $limit = $this->request->param('limit');
      $tol=($page-1)*$limit;
      $list =Db::name('outline')->where($where)->order('id desc')->limit($tol,$limit)->select();
      foreach($list as $key => $val){
        $list[$key]['classtype']=Db::name('classinfo')->where('id',$list[$key]['classtype'])->value('title');
        $list[$key]['classify']=Db::name('classinfo')->where('id',$list[$key]['classify'])->value('title');
        $list[$key]['classname']=Db::name('classinfo')->where('id',$list[$key]['classname'])->value('title');
        if($val['is_outline'] !== '线下课程')
        {
         
           $wheres['department'] = ['in',$val['department']];
            $wheres['station'] = ['in',$val['station']];
            $wheres['is_quit'] = ['eq','-1'];
            $wheres['del']  = ['eq','-1'];
           $list[$key]['num_hasdone'] = Db::name('users')->where($wheres)->where("find_in_set(".$val['classname'].",classname)")->count();

        }else{

          $list[$key]['num_hasdone'] = Db::name('question_an')->where('times',$val['times'])->count();
        }

        $list[$key]['startdate']=date('Y-m-d',strtotime($val['startdate']));
        $list[$key]['enddate']=date('Y-m-d',strtotime($val['enddate']));
        
        
      }
    
            //return json(["code"=>"0","msg"=>"ok","data"=>$list]);
      return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
    
  
    $this->assign('nowtime',date('Y-m-d H:i:s',time()));
        return $this->fetch();
    }
    /*
     * 添加线下课程
     * */
    public function outline_add()
    {
        if(isset($_REQUEST['get_list'])){
            //获取已添加的课程及对应的讲师、课程时长
            $list=Db::name('outline_lecturer')->where('times',$_REQUEST['get_list'])->order('id asc')->select();
            if(!empty($list)){
                foreach($list as $key=>$val){
                    $list[$key]['username']=Db::name('users')->where('id',$val['lecturer'])->value('username');
                }
            }
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
        }
        if (Request::instance()->isPost())
        {
      if(!empty($_POST['usersid'])){
          $arr=explode(',',$_POST['usersid']);
                $_POST['usersid']=$arr[0];
                $_POST['usersname']=$arr[1];
      }
      //筛选通知培训人员为空的话，不进行任何操作
if(isset($_POST['undefined'])){
    unset($_POST['undefined']);
}
      //课程操作，id不为空，修改课程
      if(!empty($_POST['id'])){
          $_POST['updatetime']=time();
          if(isset($_POST['project']))
                {
                    unset($_POST['project']);

                }
        if(0!=(Db::name('outline')->update($_POST)))
        {
          $data['code'] = 1;
          $data['msg'] = '修改成功';
        }else{
          $data['code'] = 0;
          $data['msg']= '修改失败';
        }
      }else{
          //添加课程
                $_POST['userid']=$_SESSION['think']['user_id'];
                $_POST['username']=$_SESSION['think']['user_name'];

                //$desc = db::name('outline')->order('id desc')->find();
//                if(($desc['username'] == $_POST['username'])&&($desc['classtype'] == $_POST['classtype'])&&($desc['classify'] == $_POST['classify'])&&($desc['userid'] == $_POST['userid']))
//                {
//                  $info = 1;
//                }else{
//                if(isset($_POST['project']))
                {
                    unset($_POST['project']);

                }
                  $info=Db::name('outline')->insertGetId($_POST);
//                }

                
        if(0!=$info)
        {
          if($_POST['classtype'] !== '7')
          {
             $returnCode =  $this->getQuestion($info,$_POST['classify']);
              if($returnCode !== 1)
              {
                  db::name('outline')->where('id',$info)->delete();
                  return json(['code'=>2,'msg'=>'课程没有添加试题']);
              }
          }
         
                    $_POST['id']=$info;
                    $data['code'] = 1;
                    $data['msg']= '添加课程成功';
        }else{
          $data['code'] = 0;
          $data['msg']= '课程已经添加完成，不要重复添加';
        }
      }

            return json($data);
        }
        if(!empty($_REQUEST['id'])){

            $id=$_REQUEST['id'];
            $date = Db::name('outline')->where('id',$id)->find();
             $count = db::name('train')->where('class_time',$date['times'])->count();
            if($count>1)
            {
                $this->assign('count',$count);
            }
            $date['classtype_name']=Db::name('classinfo')->where('id',$date['classtype'])->value('title');
            $date['classify_name']=Db::name('classinfo')->where('id',$date['classify'])->value('title');
            $date['classname_name']=Db::name('classinfo')->where('id',$date['classname'])->value('title');
            $date['department_name']=Db::name('framework')->where('id',$date['department'])->value('name');
            $date['station_name']=Db::name('posts')->where('id',$date['station'])->value('posts');
            //var_dump($date['classname']);
            if(!empty($date['times'])){
                $this->assign('times',$date['times']);
                 $answers=Db::name('notice')->where('times',$date['times'])->value('usersid');
            $answer = db::name('question_an')->where('uid','in',$answers)->where('times',$date['times'])->select();

                $feedbackList = explode(',',$date['feedbacks']);
                if($feedbackList[0] !== '0')
                {
                    foreach($feedbackList as $k => $v)
                    {
                        $ddd[$k]['url'] = $v;
                        $v =  preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $v, $cn_name);
                        $ddd[$k]['name'] = implode('', $cn_name[0] );
                    }

                }else{
                    $ddd="";
                }
                $this->assign('nameList',$ddd);
            if(!empty($answer)){
               foreach($answer as $k=>$v)
               {
                  $answer[$k]['region'] = $this->getDepartment($v['region']);
                  $answer[$k]['department'] = $this->getDepartment($v['department']);
                  $answer[$k]['station'] = $this->getStation($v['station']);
                                    $answer[$k]['projectname'] = Db::name('project')->where('id',$v['projectname'])->value('name');

               }
            }else{
                $answer='';
            }

           $this->assign('answer_user',$answer);
            }else{
                $this->assign('times',time());
            }

        }else{
            $id='0';
            $date='';
            $times = time();
            $this->assign('times',$times);
            $this->assign(['img'=>$this->getqrcodes($times)]);
        }
        $classArr=Db::name('classinfo')->where('pid','0')->where('del',0)->order('orderby desc,id asc')->select();
        $lecturer=Db::name('users')->where('is_teacher','1')->order('id asc')->select();

        $this->assign('classArr',$classArr);
        $this->assign('id',$id);

        $this->assign('list',$date);
        $this->assign('lecturer',$lecturer);
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $this->assign('question',Db::name('testlist')->where('types','-1')->select());
        if(!empty($_GET['browse'])) {
            $this->assign('browse', $_GET['browse']);
            //课程times
            $answers=Db::name('notice')->where('times',$date['times'])->value('usersid');
            $answer = db::name('question_an')->where('uid','in',$answers)->where('times',$date['times'])->select();
          

            if(!empty($answer)){
               foreach($answer as $k=>$v)
               {
                  $answer[$k]['region'] = $this->getTitle($v['region']);
                  $answer[$k]['department'] = $this->getTitle($v['department']);
                  $answer[$k]['station'] = $this->getTitle($v['station']);
                  $answer[$k]['projectname'] = Db::name('project')->where('id',$v['projectname'])->value('name');
               }
            }else{
                $answer='';
            }

        
           $this->assign('answer_user',$answer);

        }
        //进入页面
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
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
        $this->assign('project',Db::name('project')->where('del','neq','1')->where('status',1)->select());
        $time = time();
        
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
    /*
     * 添加岗位必修课
     * */
    public function outline_addtimely()
    {
        if(isset($_REQUEST['get_list'])){
            //获取已添加的课程及对应的讲师、课程时长
            $list=Db::name('outline_lecturer')->where('times',$_REQUEST['get_list'])->order('id asc')->select();
            if(!empty($list)){
                foreach($list as $key=>$val){
                    $list[$key]['username']=Db::name('users')->where('id',$val['lecturer'])->value('username');
                }
            }
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$list];
        }
        if (Request::instance()->isPost())
        {
            //不选部门，默认为所有部门
            if(empty($_POST['department']))
            {
                $department=Db::name('framework')->where('pid','neq','-1')->select();
                foreach ($department as $key=>$val){
                    $department_arr[]=$val['id'];
                }
                $_POST['department']=implode(',',$department_arr);
            }
            //不选岗位，默认为所有岗位
            if(empty($_POST['station']))
            {
                $station=Db::name('posts')->where('pid','neq','0')->select();
                foreach ($station as $key=>$val){
                    $station_arr[]=$val['id'];
                }
                $_POST['station']=implode(',',$station_arr);
            }
            if(!empty($_POST['usersid'])){
                $arr=explode(',',$_POST['usersid']);
                $_POST['usersid']=$arr[0];
                $_POST['usersname']=$arr[1];
            }
            //筛选通知培训人员为空的话，不进行任何操作
            if(isset($_POST['undefined'])){
                unset($_POST['undefined']);
            }
            //课程操作，id不为空，修改课程
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                if(0!=(Db::name('outline')->update($_POST)))
                {
                    $data['code'] = 1;
                    $data['msg'] = '修改成功';
                }else{
                    $data['code'] = 0;
                    $data['msg']= '修改失败';
                }
            }else{
                //添加课程
                $_POST['userid']=$_SESSION['think']['user_id'];
                $_POST['username']=$_SESSION['think']['user_name'];
                $info=Db::name('outline')->insertGetId($_POST);
                if(0!=$info)
                {
                    $_POST['id']=$info;
                    $data['code'] = 1;
                    $data['msg']= '添加课程成功';
                }else{
                    $data['code'] = 0;
                    $data['msg']= '添加课程失败';
                }
            }

            return json($data);
        }
        if(!empty($_REQUEST['id'])){
            $id=$_REQUEST['id'];
            $date = Db::name('outline')->where('id',$id)->find();
            $date['classtype_name']=Db::name('classinfo')->where('id',$date['classtype'])->value('title');
            $date['classify_name']=Db::name('classinfo')->where('id',$date['classify'])->value('title');
            $date['classname_name']=Db::name('classinfo')->where('id',$date['classname'])->value('title');
            $date['department_name']=Db::name('framework')->where('id',$date['department'])->value('name');
            if(!empty($date['station'])){
                $stationlist=Db::name('posts')->where('id','in',$date['station'])->select();
                foreach ($stationlist as $key => $val)
                {
                    $stationlist[$key]['pid']=Db::name('posts')->where('id',$val['pid'])->value('posts');
                }
                $this->assign('stationlist',$stationlist);
            }
            if(!empty($date['times'])){
                $this->assign('times',$date['times']);
            }else{
                $this->assign('times',time());
            }

        }else{
            $id='0';
            $date='';
            $this->assign('times',time());
        }
        $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
        $lecturer=Db::name('users')->where('is_teacher','1')->order('id asc')->select();
        $this->assign('classArr',$classArr);
        $this->assign('id',$id);
        $this->assign('list',$date);
        $this->assign('lecturer',$lecturer);
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $this->assign('question',Db::name('testlist')->where('types','-1')->select());
        if(!empty($_GET['browse'])) {
            $this->assign('browse', $_GET['browse']);
            //课程times
            $answer=Db::name('answer')->where('times',$date['times'])->select();
            if(!empty($answer)){
                foreach ($answer as $key => $val){
                    $question_id[]=$val['testquestion'];//每个问题的id
                    $users_id[]=$val['users_id'];//每个员工的id
                }
                $question_id=array_unique($question_id);
                $question_s=Db::name('testquestion')->where('id','in',$question_id)->order('id asc')->select();
                foreach ($question_s as $key=> $val){
                    $question_title[$key]['title']=$val['question'];
                    $question_title[$key]['id']=$val['id'];
                }
                $this->assign('question_title',$question_title);

                $users_id=array_unique($users_id);
                foreach ($users_id as $key => $val){
                    $answer_user=Db::name('answer')->where('times',$date['times'])
                        ->where('users_id',$val)
                        ->order('testquestion asc')
                        ->select();
                    $data_u_answer[$val]['username']=Db::name('users')->where('id',$val)->value('username');
                    foreach ($answer_user as $k => $v){
                        $data_u_answer[$val][$v['testquestion']]=$v['answer'];
                    }

                }
            }else{
                $data_u_answer='';
            }
            $this->assign('answer_user',$data_u_answer);

        }
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());

        return $this->fetch();

    }
    /*
     * 删除
     * */
    public function outline_del()
    {
        $times = db::name('outline')->where('id',input('id'))->value('times');
        db::name('notice')->where('times',$times)->delete();
        if(Db::name('outline')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 添加课程中对应的课程名称以及对应的讲师、对应的上课时长
     */
    public function outline_lecturer_add(){
        $check_count =Db::name('outline_lecturer')->field('id')->where(['times'=>$_REQUEST['times']])->count();
        if($check_count>0){
            Db::name('outline_lecturer')->where(['times'=>$_REQUEST['times']])->delete();
        }
        $class_arr =Db::name('classinfo')->field('cid as id,title')->where(['pid'=>$_REQUEST['pid'],'levels'=>$_REQUEST['levels']])->select();
        if(empty($class_arr)){
            $info['code']=0;
            $info['msg']='分类下无课程，请先添加课程';
            return json($info);
        }
        foreach ($class_arr as $key => $val){
            $data[$key]['classid']=$val['id'];
            $data[$key]['classname']=$val['title'];
            $data[$key]['times']=$_REQUEST['times'];
        }
        $info=Db::name('outline_lecturer')->insertAll($data);
        if(!$info){
            $info['code']=0;
            $info['msg']='课程、讲师、时长信息创建失败，请确认';
            return json($info);
        }
        $data=Db::name('outline_lecturer')->where('times',$_REQUEST['times'])->select();
        return json(["code"=>"0","msg"=>"课程信息已更新！","data"=>$data]);
    }
    public function outline_lecturer_field_edit(){
        $info = $_POST;
        if(Db::name('outline_lecturer')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }

    /*
     * 设置每节课的讲师
     */
    public function set_lecturer()
    {
        if (Request::instance()->isPost()) {
            $info=Db::name('outline_lecturer')->update($_POST);
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
            $this->assign('lecturer', $_GET['lecturer']);
            $lecturer=Db::name('users')->where('is_teacher','1')->order('id asc')->select();
            $this->assign('lecturer_list',$lecturer);
            return $this->fetch();
        }
    }
    /*
   * 课程相关信息
   **/
  public function classinfo(){
     if (Request::instance()->isAjax())
        {
            $list =Db::name('classinfo')->where('del','0')->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['open'] = true;
            }
            return json(["code"=>"0","msg"=>"ok","data"=>$list]);
        }
    return $this->fetch();
  }

  public function getClassInfo()
  {
      $info = Db::name('classinfo')->where('pid',input('pid'))->select();
      return json(["code"=>"0","msg"=>"ok","data"=>$info]);
  }
    /*
     * 添加课程相关信息
     * */
    public function classinfo_add()
    {
        if(!empty($_REQUEST['add'])){
            unset($_POST['add']);
            unset($_POST['act']);
            unset($_POST['quiz1']);
            unset($_POST['quiz2']);
            $find = array("‘","’","“","”");
            $info = db::name('class_info')->where('id',$_POST['quiz3'])->find();
            unset($_POST['quiz3']);

            $_POST['title'] = $info['title'];
            $_POST['cid']  = $info['id'];
            $infos =  Db::name('classinfo')->insert($_POST);
            if($infos)
            {
                $infoq = array('code'=>1,'msg'=>'添加成功');
            }else{
                $infoq = array('code'=>2,'msg'=>'添加失败');
            }
            return json($infoq);
        }else{
            $this->assign('cate',db::name('class_info')->where('pid',0)->select());
            $this->assign('pid',$_REQUEST['pid']);
            $this->assign('levels',$_REQUEST['levels']);
            return $this->fetch();
        }

    }

    public function class_info_add()
    {
        if (Request::instance()->isPost()) {
            unset($_POST['add']);
            $info =  Db::name('class_info')->insert($_POST);
            if($info)
            {
                $info = array('code'=>1,'msg'=>'添加成功');
            }else{
                $info = array('code'=>2,'msg'=>'添加失败');
            }
            return json($info);
        }else{
            $this->assign('cate',db::name('class_info')->where('pid',0)->select());
            $this->assign('pid',$_REQUEST['pid']);
            $this->assign('levels',$_REQUEST['levels']);
            return $this->fetch();
        }

    }


    public function getCate()
    {
        $info = db::name('class_info')->where('pid',input('pid'))->select();
        return json($info);
    }
    /*
     * 修改课程相关信息
     * */
    public function classinfo_edit()
    {
        if(!empty($_REQUEST['edit'])){

            unset($_POST['edit']);
            $find = array("‘","’","“","”");
            $_POST['title']=str_replace($find,"",$_POST['title']);

            $info = Db::name('classinfo')->update($_POST);
            //Db::name('classinfo')->getLastsql();
            if($info)
            {
                $info = array('code'=>1,'msg'=>'更新成功');
            }else{
                $info = array('code'=>2,'msg'=>'更新失败');
            }
            return json($info);
        }else{
            $this->assign('id',$_REQUEST['id']);
            $this_info=Db::name('classinfo')->where('id',$_REQUEST['id'])->find();
            $this->assign('list',$this_info);
            return $this->fetch();
        }

    }
    /*
    * 删除课程相关信息
    * */
    public function classinfo_del()
    {
       $infos = db::Name('classinfo')->where('cid',input('id'))->find();
        if($infos)
        {
          return json(array('code'=>2,'msg'=>'请先删除分类下课程'));
        }
        if(Db::name('classinfo')->where('id',$_REQUEST['id'])->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);

    }
    public function class_info_del()
    {
        $infos = db::Name('class_info')->where('pid',input('id'))->find();
        if($infos)
        {
          return json(array('code'=>2,'msg'=>'请先删除分类下课程'));
        }
        if(Db::name('class_info')->where('id',$_REQUEST['id'])->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);

    }
     public function delApply()
    {
      
        if(Db::name('apply')->where('id',input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);

    }
    /*
     * 修改状态(课程信息)
     * */
    public function checkStatus()
    {
        $info = input('post.');
        if(Db::name('classinfo')->where('id',$info['id'])->update(['status'=>-$info['status']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }
     /*
     * 修改状态(课程信息)
     * */
    public function checkStatus1()
    {
        $info = input('post.');
        if(Db::name('classinfo')->where('id',$info['id'])->update(['status1'=>-$info['status1']]))
        {
            $info = array('code'=>1,'msg'=>'状态更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'状态更新失败');
        }
        return json($info);
    }
  public function classinfo_field_edit(){
        $info = input('post.');
        if(Db::name('classinfo')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
  }

    public function classinfo_field_edits(){
        $info = input('post.');
        if(Db::name('class_info')->where('id',$info['id'])->update([$info['field']=>$info['value']]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }
  /*
   * 获取posts岗位信息
   */
  public function getPosts(){
        if(isset($_REQUEST['pid']))
        {
            $list =Db::name('posts')->where(['pid'=>$_REQUEST['pid']])->select();
            return json(["code"=>"0","msg"=>"ok","data"=>$list]);
        }
    }

    public function getPost()
    {
        $info = input('');
        $where['department'] = array('in',$info['posts']);
        $where['station'] = array('in',$info['station']);
        $where['is_quit'] = array('eq','-1');
        $where['del']     = array('eq','-1');
        $userInfo = db::name('users')->where($where)->select();
        foreach($userInfo as $k=>$v)
        {
            $userInfo[$k]['department'] =$this->getDepartment($v['department']);
            $userInfo[$k]['station'] =$this->getStation($v['station']);
            $userInfo[$k]['region']=Db::name('framework')->where('id',$v['region'])->value('name');
            $userInfo[$k]['project']=Db::name('project')->where('id',$v['projectname'])->value('name');
        }
        return json(["code"=>"0","msg"=>"筛选成功","count"=>count($userInfo),"data"=>$userInfo]);
    }
    /*
     * 日志列表
     * */
    public function condition()
    {
        if(isset($_GET['pid']))
        {
            $count=Db::name('words_log')->where('pid',$_GET['pid'])->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('words_logs')->where('contract_num',$_GET['id'])->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    public function statusedit(){
        $time=time();
        $_POST['status_time']=$time;
        //如果是线上课程，只修改outline的status
        if($_POST['is_outline']=='线上课程'){
            //更新outline status为1
            $info = Db::name('outline')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }
       //先修改times对应outline_lecturer数据，然后计算对应讲师的课时、门数，最后修改课程outline状态

        $info=Db::name('outline_lecturer')->where('times',$_POST['times'])->update(['status'=>'1','updatetime'=>$time]);
        if($info){
            $list=Db::name('outline_lecturer')
                ->where('times',$_POST['times'])
                ->where('lecturer','neq','')
                ->select();
            $lecturers=Db::name('outline_lecturer')
                ->where('times',$_POST['times'])
                ->where('lecturer','neq','')
                ->field('lecturer')
                ->select();
            foreach ($lecturers as $key => $val){
                $lecturer_arr[]=$val['lecturer'];
            }
            if(empty($lecturer_arr)){
                $data['code'] = 0;
                $data['msg']= '至少要有1个讲师';
                return json($data);
            }
            $lecturer_arr=array_unique($lecturer_arr);//去重后的lecturer数组
            //计算每个讲师的课时，上课次数classtime时长，classnum上课次数
            foreach ($lecturer_arr as $key=> $val){
                $data[$key]['classnum']=0;
                $data[$key]['classtime']=0;
                foreach($list as $k => $v){
                    if($val==$v['lecturer']){
                        if(isset($data[$key]['classid'])){
                            $data[$key]['classid']=$data[$key]['classid'].','.$v['classid'];
                        }else{
                            $data[$key]['classid']=$v['classid'];
                        }

                        $data[$key]['users_id']=$val;
                        $data[$key]['classnum']++;
                        $data[$key]['classtime']+=$v['classtime'];
                    }
                }

            }
            //开始更新lecturer表中数据
            foreach ($data as $key => $val){
                $this_info=Db::name('lecturer')->where('users_id',$val['users_id'])->find();
                $val['classnum']+=$this_info['classnum'];
                $val['classtime']+=$this_info['classtime'];
                if(!empty($this_info['classid'])){
                    $val['classid']=$this_info['classid'].','.$val['classid'];
                    $val['classid']=implode(',',array_unique(explode(',',$val['classid'])));

                }

                Db::name('lecturer')->where('users_id',$val['users_id'])->update($val);
            }
            //更新outline status为1
            $info = Db::name('outline')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '讲师信息更新成功,修改课程状态失败';
            }

        }else{
            $data['code'] = 0;
            $data['msg']= '更新outline_lecturer信息失败';
        }
        return json($data);
    }
    /*
     * 问卷调查列表
     */
    public function feedback()
    {
        if (!empty($_REQUEST['list']))
        {
            $where['del'] ='-1';
            $where['types'] ='-1';
            $count=Db::name('testlist')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('testlist')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $key=>$val)
            {
                $list[$key]['datetime'] = date('Y-m-d H:i:s',$val['times']);
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $this->assign('act','feedback');
            return $this->fetch('tests');
        }
    }
    /*
     * 考试问卷列表
     */
    public function tests()
    {
        if (!empty($_REQUEST['list']))
        {
            $where['del'] ='-1';
            $where['types'] ='1';
            $count=Db::name('testlist')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('testlist')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $key=>$val)
            {
                $list[$key]['datetime'] = date('Y-m-d H:i:s',$val['times']);
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $this->assign('act','tests');
            return $this->fetch();
        }
    }
    public function tests_add()
    {
        if ($this->request->isPost())
        {
            if($_POST['act']=='tests'){
                $_POST['types']='1';
            }else{
                $_POST['types']='-1';
            }
            unset($_POST['act']);
            $info = Db::name('testlist')->insert($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $this->assign('times',time());
            $this->assign('act',$_REQUEST['act']);
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            return $this->fetch();
        }
    }
    public function tests_edit()
    {
        if ($this->request->isPost())
        {
            $info = Db::name('testlist')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }else{
            $this->assign('id',$_REQUEST['id']);
            $list=Db::name('testlist')->where('id',$_REQUEST['id'])->find();
            $list['classtype_name']=Db::name('classinfo')->where('id',$list['classtype'])->value('title');
            $list['classify_name']=Db::name('classinfo')->where('id',$list['classify'])->value('title');
            $this->assign('list',$list);
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            return $this->fetch('tests_add');
        }
    }
    public function tests_del()
    {
        if ($info = Db::name('testlist')->where('id',$_REQUEST['id'])->update(['del'=>'1']))
        {
            $data['code'] = 1;
            $data['msg'] = '操作成功';
        }else{
            $data['code'] = 0;
            $data['msg']= '操作失败';
        }
        return json($data);
    }
    public function tests_q_del()
    {
        $id=$_REQUEST['id'];
        $questions=$_REQUEST['questions'];
        $result=Db::name('testlist')->where('id',$id)->value('questions');
        $result= explode(",", $result);
        foreach($result as $key=>$val){
            if($val == $questions){
                unset($result[$key]);
            }
        }
        $result= implode(",", $result);
        if ($info = Db::name('testlist')->where('id',$id)->update(['questions'=>$result]))
        {
            $data['code'] = 1;
            $data['msg'] = '操作成功';
        }else{
            $data['code'] = 0;
            $data['msg']= '操作失败';
        }
        return json($data);
    }
    /*
     * 问题列表--添加试卷后的选择列表
     */
    public function question_lists()
    {
        if(isset($_GET['list'])){
            //var_dump($_REQUEST);exit;
            $questions=Db::name('testlist')->where('id',$_GET['list'])->value('questions');
            if(!empty($_GET['classify']))
                $where['classify']=$_GET['classify'];
            if(!empty($_GET['classname']))
                $where['classname']=$_GET['classname'];
            if(!empty($questions))
                $where['id']=array('notin',$questions);
            if(!isset($where))
                $where='1=1';
            $count=Db::name('testquestion')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('testquestion')->where($where)->order('id desc')->limit($tol,$limit)->select();

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        //$this->assign('id',$_REQUEST['id']);
        return $this->fetch();
    }
    public function question_lists_choose()
    {
        if($this->request->isPost()){

            if($_POST['questions']=='all'){
                if(!empty($_POST['classtype'])){
                    $where['classtype']=$_POST['classtype'];
                }
                if(!empty($_POST['classify'])){
                    $where['classify']=$_POST['classify'];
                }
                if(!empty($_POST['classname'])){
                    $where['classname']=$_POST['classname'];
                }
                if(!isset($where))$where='1=1';
                $id_list=Db::name('testquestion')->where($where)->select();
                foreach ($id_list as $key =>$val){
                    $arr[]=$val['id'];
                }
                $_POST['questions']=implode(",", $arr);
            }else if($_POST['questions']!=''){
                $questions=Db::name('testlist')->where('id',$_POST['id'])->value('questions');
                if(!empty($questions)){
                    $_POST['questions']=$questions.','.$_POST['questions'];
                }
            }else if(empty($_POST['questions'])){
                $data['code'] = 0;
                $data['msg']= '选题为空';
                return json($data);
            }
            unset($_POST['classtype']);
            unset($_POST['classify']);
            unset($_POST['classname']);

            $info=Db::name('testlist')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }
        $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('classArr',$classArr);
        $this->assign('id',$_REQUEST['id']);
        return $this->fetch();
    }
        /*
         * 问题列表--试卷中已添加问题列表
         */
    public function questions()
    {
        if (!empty($_REQUEST['list']))
        {
            $questions=Db::name('testlist')->where('id',$_REQUEST['list'])->value('questions');
            $count=Db::name('testquestion')->where('id','in',$questions)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('testquestion')->where('id','in',$questions)->order('orderby desc,id desc')->limit($tol,$limit)->select();

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $this->assign('id',$_REQUEST['id']);
            return $this->fetch();
        }
    }
    public function question_add()
    {
        if ($this->request->isPost())
        {
            if(empty($_POST['option_a'])){
                $_POST['is_choose']='-1';
            }
            $info = Db::name('testquestion')->insert($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            return $this->fetch();
        }
    }
    public function question_edit()
    {
        if ($this->request->isPost())
        {
            $info = Db::name('testquestion')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }else{
            $this->assign('id',$_REQUEST['id']);
            $list=Db::name('testquestion')->where('id',$_REQUEST['id'])->find();
            $list['classtype_name']=Db::name('classinfo')->where('id',$list['classtype'])->value('title');
            $list['classify_name']=Db::name('classinfo')->where('id',$list['classify'])->value('title');
            $list['classname_name']=Db::name('classinfo')->where('id',$list['classname'])->value('title');
            $this->assign('list',$list);
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            return $this->fetch('question_add');
        }
    }
    public function question_del()
    {
        if (Db::name('testquestion')->delete($_REQUEST['id']))
        {
            $data['code'] = 1;
            $data['msg'] = '删除成功';
        }else{
            $data['code'] = 0;
            $data['msg']= '删除失败';
        }
        return json($data);

    }
    /*
     * 员工/管理员/项目负责人培训总结
     */
    public function summed(){
        if(isset($_GET['id']))
        {

            $where['status']='1';
            $where['del']='-1';

            //$count=Db::query("SELECT  COUNT(*) AS tp_count FROM `shilian_outline` WHERE  `status` = '1' OR `station` <> '' AND `del` = -1  ");
            //$count=$count[0]['tp_count'];
            $count=Db::name('outline')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('outline')->where($where)->order('status_time desc')->limit($tol,$limit)->select();
            //$list =Db::query("SELECT * FROM `shilian_outline` WHERE  `status` = '1' OR `station` <> '' AND `del` = -1  ORDER BY `status_time` DESC LIMIT ".$tol.",".$limit);

            foreach($list as $key => $val){
                $list[$key]['classtype']=Db::name('classinfo')->where('id',$list[$key]['classtype'])->value('title');
                $list[$key]['classify']=Db::name('classinfo')->where('id',$list[$key]['classify'])->value('title');
                $list[$key]['classname']=Db::name('classinfo')->where('id',$list[$key]['classname'])->value('title');

            }
            //return json(["code"=>"0","msg"=>"ok","data"=>$list]);
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }


        return $this->fetch();
    }
    public function summed_list(){
        if(isset($_GET['users']))
        {
            $where['class_id']=$_GET['id'];
            $count=Db::name('tips')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('tips')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $key => $val){
                $list[$key]['datetime']=date('Y-m-d H:i:s',$val['startdate']);
            }

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        if(isset($_GET['id']))
        {
            $where['outline_id']=$_GET['id'];
            $count=Db::name('summed')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('summed')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $key => $val){
                $list[$key]['datetime']=date('Y-m-d H:i:s',$val['times']);
            }

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        //var_dump($_SESSION['think']['user_name']);exit;
        $this->assign('outline_id',$_REQUEST['outline_id']);
        return $this->fetch();
    }
    public function summed_add()
    {
        if ($this->request->isPost())
        {
            $_POST['user_id']=$_SESSION['think']['user_id'];
            $_POST['user_name']=$_SESSION['think']['user_name'];

            $info = Db::name('summed')->insert($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $this->assign('outline_id',$_REQUEST['outline_id']);
            $this->assign('times',time());
            $this->assign('nowtime',time());
            return $this->fetch();
        }
    }
    public function summed_edit()
    {
        if ($this->request->isPost())
        {
            $_POST['times']=time();
            $info = Db::name('summed')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }else{
            $this->assign('id',$_REQUEST['id']);
            $list=Db::name('summed')->where('id',$_REQUEST['id'])->find();
            $this->assign('list',$list);
            $this->assign('times',$list['times']);
            $this->assign('nowtime',time());
            $imglist=Db::name('uploads')->where('times',$list['times'])->where('del','-1')->select();
            $this->assign('imglist',$imglist);
            return $this->fetch('summed_add');
        }
    }
    public function summed_del()
    {
        $times=Db::name('summed')->where('id',$_REQUEST['id'])->value('times');


        if(Db::name('uploads')->where('times',$times)->delete()){
            if (Db::name('summed')->delete($_REQUEST['id']))
            {
                $data['code'] = 1;
                $data['msg'] = '删除成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '删除失败';
            }
        }else{
            $data['code'] = 0;
            $data['msg']= '请先删除附件';
        }
        return json($data);

    }
    public function summed_tips_browse()
    {

        $this->assign('id',$_REQUEST['id']);
        $list=Db::name('tips')->where('id',$_REQUEST['id'])->find();
        $this->assign('list',$list);

        $this->assign('nowtime',time());

        return $this->fetch();

    }
    public function summed_tips_del()
    {
        if (Db::name('tips')->delete($_REQUEST['id']))
        {
            $data['code'] = 1;
            $data['msg'] = '删除成功';
        }else{
            $data['code'] = 0;
            $data['msg']= '删除失败';
        }
        return json($data);

    }
    /*
 * 上传方法
 * */
    public function uploads_bak()
    {
        $ret = array();
        if ($_FILES["file"]["error"] > 0)
        {
            $ret["message"] =  $_FILES["file"]["error"] ;
            $ret["status"] = 0;
            $ret["src"] = "";
            return json($ret);
        }else{
            $pic =  $this->upload_bak();
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
            return json($ret);
        }
    }
    /*
     * 文件上传实际操作
     * */
    private  function upload_bak(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录�?
        $info = $file->move(ROOT_PATH . 'public/uploads');
        $reubfo = array();
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();;
        }
        return $reubfo;
    }
    /*
     * 统计查询
     */
    public function statistics(){
        if ($this->request->isPost())
        {
            //var_dump($_POST);exit;
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
//            $array[0]=strtotime($array[0]);
//            $array[1]=strtotime($array[1]);
            $where['start_time']=array('between',$array);///员工入职时间
            $where['is_quit'] = array('eq',-1);
            $where['del'] = ['eq','-1'] ;
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);//员工部门
            }
            if(!empty($_POST['station'])){
                $where['station']=array('in',$_POST['station']);//员工岗位
            }
            //如果是项目经理或项目负责人，只查询自己项目中的所有人
            if($_SESSION['think']['role_title']=='部门总监'){
                $where_pro['framework_id']=Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department');
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $where_pro['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $where_pro['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'){
                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
            }
//            if($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
//                //如果是地区业管，且department不为空
//                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
//            }
            if(isset($where_pro)){
                $where_pro['status']=1;
                $pro_id_arr=Db::name('project')->where($where_pro)->field('id')->select();
                foreach ($pro_id_arr as $item) {
                    $pro_id[]=$item['id'];
                }
                $where['projectname']=array('in',$pro_id);
            }

            //根据条件查询（已上过）该课程的员工
            //var_dump($where);die;
            $count=Db::name('users')->where($where)
                ->where("find_in_set(".$_POST['classify'].",classid)")
                ->count();
            //var_dump(Db::name('users')->getLastSql());exit;
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('users')->where($where)
                ->where("find_in_set(".$_POST['classify'].",classid)")
                ->order('id desc')->limit($tol,$limit)->select();
            //Db::name('users')->getLastSql();
            //若查询未培训人员，在对应岗位中去除已培训人员id即可
            if($_POST['is_train']=='-1'){
                if(!empty($list)){
                    $count=Db::name('users')->where($where)
                        ->where("!find_in_set(".$_POST['classify'].",classid)")
                        ->count();

                    $page = $this->request->param('page');
                    $limit = $this->request->param('limit');
                    $tol=($page-1)*$limit;
                    $list =Db::name('users')->where($where)
                        ->where("!find_in_set(".$_POST['classify'].",classid)")
                        ->order('id desc')->limit($tol,$limit)->select();
                }else{
                    $count=Db::name('users')->where($where)
                        ->count();

                    $page = $this->request->param('page');
                    $limit = $this->request->param('limit');
                    $tol=($page-1)*$limit;
                    $list =Db::name('users')->where($where)
                        ->order('id desc')->limit($tol,$limit)->select();
                }
            }


            foreach($list as $key => $val){
                $list[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('classArr',$classArr);
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());

        return $this->fetch();

    }


     /*
     * 统计查询
     */
    public function chaxuns(){
        if ($this->request->isPost())
        {
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
            $where['start_time']=array('between',$array);///员工入职时间
            $where['is_quit'] = array('eq',-1);
            $where['del'] = ['eq','-1'] ;
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);//员工部门
            }
            if(!empty($_POST['station'])){
                $where['station']=array('in',$_POST['station']);//员工岗位
            }
            //如果是项目经理或项目负责人，只查询自己项目中的所有人
            if($_SESSION['think']['role_title']=='部门总监'){
                $where_pro['framework_id']=Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department');
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $where_pro['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $where_pro['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'){
                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
            }
            if(isset($where_pro)){
                $where_pro['status']=1;
                $pro_id_arr=Db::name('project')->where($where_pro)->field('id')->select();
                foreach ($pro_id_arr as $item) {
                    $pro_id[]=$item['id'];
                }
                $where['projectname']=array('in',$pro_id);
            }
            $count=Db::name('users')->where($where)
                ->where("find_in_set(".$_POST['classify'].",classid)")
                ->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('users')->where($where)
                ->where("find_in_set(".$_POST['classify'].",classid)")
                ->order('id desc')->limit($tol,$limit)->select();
            if($_POST['is_train']=='-1'){
                if(!empty($list)){
                    $count=Db::name('users')->where($where)
                        ->where("!find_in_set(".$_POST['classify'].",classid)")
                        ->count();
                    $page = $this->request->param('page');
                    $limit = $this->request->param('limit');
                    $tol=($page-1)*$limit;
                    $list =Db::name('users')->where($where)
                        ->where("!find_in_set(".$_POST['classify'].",classid)")
                        ->order('id desc')->limit($tol,$limit)->select();
                }else{
                    $count=Db::name('users')->where($where)
                        ->count();
                    $page = $this->request->param('page');
                    $limit = $this->request->param('limit');
                    $tol=($page-1)*$limit;
                    $list =Db::name('users')->where($where)
                        ->order('id desc')->limit($tol,$limit)->select();
                }
            }
            foreach($list as $key => $val){
                $list[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
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
        $this->assign('posts1',json_encode($posts));


        $this->assign('classArr',Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select());
        $classifyNew = db::name('classinfo')->where('pid',0)->field('id as value,title as name')->select();
        foreach($classifyNew as $k=>$v)
        {
            $classifyNew[$k]['children'] = db::name('classinfo')->where('pid',$v['value'])->field('id as value,title as name')->select();
        }
        $this->assign('classifyNew',json_encode($classifyNew));

        $this->assign('classify',Db::name('classinfo')->where('pid','neq','0')->order('orderby desc,id asc')->select());
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
        $this->assign('project',Db::name('project')->field('id,name')->where(['status'=>1,'del'=>-1])->select());
        $userArr = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->field('id as value,username as name')->select();
        $this->assign('userArr',json_encode($userArr));
        return $this->fetch('',['teacher'=>db::name('outline')->field('userid,username')->group('userid')->select()]);
    }


    public function chaxun(){
        if ($this->request->isPost())
        {
            $info = input('');
            if(!empty($info['department'])) {$wheres['department'] = ['in',$info['department']];}
            if(!empty($info['project'])) {$wheres['projectname'] = ['in',$info['project']];}
            if(empty($wheres))
            {
                $wheres = "1=1";
            }
            $data = db::name('users')->where($wheres)->where("find_in_set(" . $info['className'] . ",outlines)")->select();
            foreach($data as $k=>$v)
            {
                $data[$k]['department'] =$this->getDepartment($v['department']);
                $data[$k]['station'] =$this->getStation($v['station']);
                $data[$k]['region']=Db::name('framework')->where('id',$v['region'])->value('name');
                $data[$k]['projectname']=Db::name('project')->where('id',$v['projectname'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>count($data),"data"=>$data];
        }
        if($_SESSION['think']['role_title']=='事业部秘书')
        {
            $depart=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('department');
            $frame = Db::name('framework')->where('id',$depart)->where('status','1')->order('id asc')->select();
        }else{
            $frame = Db::name('framework')->where('pid','neq','-1')->select();
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
        return $this->fetch('',['framework'=>$frame,'classInfo'=>db::name('class_info')->where('pid',0)->select(),'lists1'=>json_encode($Info)]);
    }



    
    public function getDepartment($v)
    {
      return db::name('framework')->where('id',$v)->value('name');
    }
     public function getStation($v)
    {
      return db::name('posts')->where('id',$v)->value('posts');
    }

    public function getProjectInfo()
    {
      $info = Db::name('project')->where('framework_id',input('pid'))->select();
      return json(["code"=>"0","msg"=>"ok","data"=>$info]);
    }

    public function getUid($pid)
    {
            $list = Db::name('users')->field('id')->where('department',$pid)->select();
            if($list)
            {
                foreach($list as $val)
                {
                    $lists[] = $val['id'];
                }

            }else{
              $lists =   '';
            }
           
            return $lists;
    }
    public function getPid($pid)
    {
            $list = Db::name('users')->field('id')->where('projectname',$pid)->select();
            if($list)
            {
                foreach($list as $val)
                {
                    $lists[] = $val['id'];
                }

            }else{
              $lists =   '';
            }
           
            return $lists;
    }




    /*此方法以废弃*/
    public function datascreen()
    {

        if(Request::instance()->isPost()){
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
//            $array[0]=strtotime($array[0].' 0:0:0');
//            $array[1]=strtotime($array[1].' 23:59:59');
            $where['startdate']=array('between',$array);//更新状态的时间
            $where['status']='1';//已授课
            $where['del']=array('neq','1');//未删除
            if($_POST['group']=='3'){
                $outline=Db::name('outline')->where($where)->select();
                foreach ($outline as $key => $val){

                    if(!isset($data[$val['classify']]['num'])){$data[$val['classify']]['num']=0;}

                    //$data[$val['classify']]['area']=$val['area'];
                    $data[$val['classify']]['classtype']=$val['classtype'];
                    $data[$val['classify']]['classtype_name']=Db::name('classinfo')->where('id',$val['classtype'])->value('title');
                    $data[$val['classify']]['classify']=$val['classify'];
                    $data[$val['classify']]['classify_name']=$data[$val['classify']]['classtype_name'].'--'.Db::name('classinfo')->where('id',$val['classify'])->value('title');
                    $data[$val['classify']]['num']++;//本分类培训次数
                    //已创建课程通知的情况下，才能继续运行
                    $usersid=Db::name('notice')->where('times',$val['times'])->value('usersid');
                    $users_arr=explode(',',$usersid);


                    if(!isset($data[$val['classify']]['usersnum'])){
                        $data[$val['classify']]['usersnum']=$usersid;//本课程中通知的人员id列表，统计通知人数，非人次
                    }else{
                        $data[$val['classify']]['usersnum']=$data[$val['classify']]['usersnum'].','.$usersid;//本课程中通知的人员id列表
                    }

                }
                if(empty($data)){
                    return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
                }
                $new_arr=$data;
            }elseif($_POST['group']=='1') {
                $area = Db::name('outline')->where($where)->field('area')->select();
                foreach ($area as $key => $val) {
                    foreach ($val as $k => $v) {
                        $area_arr[] = $v;
                    }
                }
                if(empty($area_arr)){
                    return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
                }
                $area_arr=array_unique($area_arr);
                foreach ($area_arr as $k_area => $v_area) {
                    $where['area'] = $v_area;
                    $outline = Db::name('outline')->where($where)->select();
                    //var_dump($outline);
                    foreach ($outline as $key => $val) {

                        if (!isset($data[$v_area][$val['classify']]['num'])) {
                            $data[$v_area][$val['classify']]['num'] = 0;
                        }

                        $data[$v_area][$val['classify']]['area'] = $val['area'];
                        $data[$v_area][$val['classify']]['classtype'] = $val['classtype'];
                        $data[$v_area][$val['classify']]['classtype_name'] = Db::name('classinfo')->where('id',$val['classtype'])->value('title');
                        $data[$v_area][$val['classify']]['classify'] = $val['classify'];
                        $data[$v_area][$val['classify']]['classify_name'] = $data[$v_area][$val['classify']]['classtype_name'].'--'.Db::name('classinfo')->where('id',$val['classify'])->value('title');
                        $data[$v_area][$val['classify']]['num']++;//本分类培训次数

                        //已创建课程通知的情况下，才能继续运行
                        $usersid = Db::name('notice')->where('times', $val['times'])->value('usersid');
                        $users_arr = explode(',', $usersid);


                        if (!isset($data[$v_area][$val['classify']]['usersnum'])) {
                            $data[$v_area][$val['classify']]['usersnum'] = $usersid;//本课程中通知的人员id列表，统计通知人数，非人次
                        } else {
                            $data[$v_area][$val['classify']]['usersnum'] = $data[$v_area][$val['classify']]['usersnum'] . ',' . $usersid;//本课程中通知的人员id列表
                        }

                    }
                    //var_dump($data);
                }
                foreach ($data as $key => $val) {
                    foreach ($val as $k => $v) {
                        $new_arr[] = $v;
                    }
                }

            }elseif($_POST['group']=='2') {
                //按培训类型分组
                $classtype = Db::name('outline')->where($where)->field('classtype')->select();
                foreach ($classtype as $key => $val) {
                    foreach ($val as $k => $v) {
                        $classtype_arr[] = $v;
                    }
                }

                if(empty($classtype_arr)){
                    return ["code"=>"0","msg"=>"","count"=>'',"data"=>''];
                }
                $classtype_arr=array_unique($classtype_arr);

                foreach ($classtype_arr as $k_classtype => $v_classtype) {
                    $where['classtype'] = $v_classtype;
                    $area = Db::name('outline')->where($where)->field('area')->select();
                    foreach ($area as $key => $val) {
                        foreach ($val as $k => $v) {
                            $area_arr[] = $v;
                        }
                    }
                    $area_arr=array_unique($area_arr);
                    foreach ($area_arr as $k_area => $v_area) {
                        $where['area'] = $v_area;
                        $outline = Db::name('outline')->where($where)->select();
                        foreach ($outline as $key => $val) {
///////////////////////////////

                            if (!isset($data[$v_classtype][$v_area]['num'])) {
                                $data[$v_classtype][$v_area]['num'] = 0;
                            }

                            $data[$v_classtype][$v_area]['area'] = $val['area'];
                            $data[$v_classtype][$v_area]['classtype'] = $val['classtype'];
                            $data[$v_classtype][$v_area]['classtype_name'] = Db::name('classinfo')->where('id',$val['classtype'])->value('title');
                            $data[$v_classtype][$v_area]['classify'] = $val['classify'];
                            $data[$v_classtype][$v_area]['classify_name'] = $data[$v_classtype][$v_area]['classtype_name'].'--'.Db::name('classinfo')->where('id',$val['classify'])->value('title');
                            $data[$v_classtype][$v_area]['num']++;//本分类培训次数

                            //已创建课程通知的情况下，才能继续运行
                            $usersid = Db::name('notice')->where('times', $val['times'])->value('usersid');
                            $users_arr = explode(',', $usersid);


                            if (!isset($data[$v_classtype][$v_area]['usersnum'])) {
                                $data[$v_classtype][$v_area]['usersnum'] = $usersid;//本课程中通知的人员id列表，统计通知人数，非人次
                            } else {
                                $data[$v_classtype][$v_area]['usersnum'] = $data[$v_classtype][$v_area]['usersnum'] . ',' . $usersid;//本课程中通知的人员id列表
                            }

/////////////////////////////////////
                        }
                    }
                }

                foreach ($data as $key => $val) {
                    foreach ($val as $k => $v) {
                        $new_arr[] = $v;
                    }
                }

            }
            //$count_values=array_count_values($classify_arr);
            //var_dump($new_arr);exit;


            $data=array_values($new_arr);
            foreach ($data as $key => $val){
                dd($val);
                $notice=array_unique(explode(',',$val['usersnum']));//通知人数去重
                $data[$key]['notice'] =count($notice);
                $num = 0;//培训人数

                foreach ($notice as $k_users => $v_users) {
                    $users_count = Db::name('users')
                        ->where('id', $v_users)
                        ->where("find_in_set(" . $val['classify'] . ",classid)")
                        ->count();
                    if ($users_count > 0) {
                        $num++;
                    }
                }

                if (!isset($data[$key]['ying'])) {
                    $data[$key]['ying'] = $num;//此分类已培训人数
                }else {
                    $data[$key]['ying'] += $num;//此分类已培训人数
                }

                $weinum=0;//未培训人数
                foreach ($notice as $k_users => $v_users){
                    $users_count=Db::name('users')
                        ->where('id',$v_users)
                        ->where("!find_in_set(".$val['classify'].",classid)")
                        ->count();
                    if ($users_count>0){
                        $weinum++;
                    }
                }
                if(!isset($data[$key]['wei'])){
                    $data[$key]['wei']=$weinum;//此分类已培训人数
                }else{
                    $data[$key]['wei']+=$weinum;//此分类已培训人数
                }

            
            }
            die;
            //var_dump($data);exit;
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        return $this->fetch();
    }


    public function chart()
    {
        if (Request::instance()->isPost())
        {
            $datas = $_POST['createTime'].",".$_POST['endTime'];
            $where['startdate']=array('between',$datas);//更新状态的时间
            $where['status']='1';//已授课
            $where['del']=array('neq','1');//未删除
            $classtype = Db::name('outline')->where($where)->field('area')->group('area')->select();
            foreach($classtype as $v)
            {
                $where['area'] = array('eq',$v['area']);
                $infos = Db::name('outline')->where($where)->field('real_number,area')->select();
                $data['area'][]  = ['name'=> $v['area'],'value'=>count($infos)];
                $data['num'][] = ['name'=> $v['area'],'value'=>array_sum(array_column($infos, 'real_number'))];
            }

            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        return $this->fetch();
    }

     public function tests1()
    {
            $code = "2019-07-01 - 2019-10-23";
            $array=explode(' - ', $code);
            $where['startdate']=array('between',$array);//更新状态的时间
            $where['status']='1';//已授课
            $where['del']=array('neq','1');//未删除
            $classtype = Db::name('outline')->where($where)->field('area')->group('area')->select();
            foreach($classtype as $v)
            {
                $where['area'] = array('eq',$v['area']);
                $infos = Db::name('outline')->where($where)->field('real_number,area')->select();
                $data['area'][]  = ['name'=> $v['area'],'value'=>count($infos)];
                $data['area'][] = ['name'=> $v['area'],'value'=>array_sum(array_column($infos, 'real_number'))];
            }

            dd($data);


    }


    public function getTitle($id)
    {
        if(session('?info'))
        {
            $info = json_decode(session('info'),true);
        }else{
            $info = Db::name('classinfo')->field('id,pid,title')->select();
            session('info',json_encode($info));
        }
        
        foreach($info as $k=>$v)
        {
            if($v['id'] == $id)
            {
                return   $v['title']; break;
            }
        }
    }


     public function datascreens()
    {

        if(Request::instance()->isPost()){
            
            
            $datas = $_POST['createTime'].",".$_POST['endTime'];
            $where['startdate']=array('between',$datas);//更新状态的时间
            $where['status']='1';//已授课
            $where['del']=array('neq','1');//未删除
            if($_POST['group']=='2')
            {
                $classtype = Db::name('outline')->where($where)->field('classify')->group('classify')->select();
                foreach($classtype as $v)
                {
                    $where['classify'] = array('eq',$v['classify']);
                    $infos = Db::name('outline')->where($where)->field('real_number,times,classtype,classify')->select();
                    foreach($infos as $key => $val)
                    {

                        $dd = explode(',',Db::name('notice')->where('times', $val['times'])->value('usersid'));
                    
                         $infos[$key]['renumber'] = $this->getQuestionNaire($val);
                         $infos[$key]['count'] = count($dd);
                    }
                    $infoarr = $infos[0];
                    $infoarr['renumber']    = array_sum(array_column($infos, 'renumber'));
                    $infoarr['real_number'] = array_sum(array_column($infos, 'real_number'));
                    $infoarr['count']       = array_sum(array_column($infos, 'count'));
                    $infoarr['number']      = count($infos);
                    $infoarr['classtype']   = $this->getTitle($infoarr['classtype']);
                    $infoarr['classify']    = $this->getTitle($infoarr['classify']);

                    $data[] = $infoarr;
                    $last_names = array_column($data,'classtype');
                    array_multisort($last_names,SORT_DESC,$data);
                    
                }
            }else{
                $classtype = Db::name('outline')->where($where)->field('classify,area')->group('classify,area')->select();

             
                foreach($classtype as $v)
                {
                    $where['classify'] = array('eq',$v['classify']);
                    $where['area'] = array('eq',$v['area']);
                    $infos = Db::name('outline')->where($where)->field('real_number,times,classtype,classify,area')->select();
                    foreach($infos as $key => $val)
                    {

                        $dd = explode(',',Db::name('notice')->where('times', $val['times'])->value('usersid'));
                    
                         $infos[$key]['renumber'] = $this->getQuestionNaire($val);
                         $infos[$key]['count'] = count($dd);
                         

                    }
                    $infoarr = $infos[0];
                    $infoarr['renumber']    = array_sum(array_column($infos, 'renumber'));
                    $infoarr['real_number'] = array_sum(array_column($infos, 'real_number'));
                    $infoarr['count']       = array_sum(array_column($infos, 'count'));
                    $infoarr['number']      = count($infos);

                    $infoarr['classtype']   = $this->getTitle($infoarr['classtype']);
                    $infoarr['classify']    = $this->getTitle($infoarr['classify']);

                    $data[] = $infoarr;

                   $last_names = array_column($data,'area');
                    array_multisort($last_names,SORT_DESC,$data);

                    
                }
            }
            if(empty($data))
            {
              $data = '';
            }
           
            return ["code"=>"0","msg"=>"","count"=>'',"data"=>$data];
        }
        return $this->fetch();
    }


    public function getQuestionNaire($info)
    {

        $questions = Db::name('answer')->where('times',$info['times'])->select();
        if(!empty($questions))
        {

         foreach ($questions as $key => $val){
                    $question_id[]=$val['testquestion'];//每个问题的id
                    $users_id[]=$val['users_id'];//每个员工的id
                }
                $question_id=array_unique($question_id);
                $question_s=Db::name('testquestion')->where('id','in',$question_id)->order('id asc')->select();
                foreach ($question_s as $key=> $val){
                    $question_title[$key]['title']=$val['question'];
                    $question_title[$key]['id']=$val['id'];
                }
               
                $users_id=array_unique($users_id);
                foreach ($users_id as $key => $val){
                    $answer_user=Db::name('answer')->where('times',$info['times'])
                        ->where('users_id',$val)
                        ->order('testquestion asc')
                        ->select();
                    $data_u_answer[$val]['username']=Db::name('users')->where('id',$val)->value('username');
                    foreach ($answer_user as $k => $v){
                        $data_u_answer[$val][$v['testquestion']]=$v['answer'];
                    }

                }}else{
        return 0;
    }
               return count($data_u_answer);
        }



    public function questionList()
    {
      if (Request::instance()->isAjax())
      {
          if($_SESSION['think']['role_title']=='教师管理'){
                  
              $where['add_user_id'] = $_SESSION['think']['user_id'];
          }
          $where['cid'] = input('id');
          $count = Db::name('question')->where($where)->count();
          $lists = Db::name('question')->where($where)->select();
          foreach($lists as $k=>$v)
          {
            $lists[$k]['cid'] = db::name('class_info')->where('id',$v['cid'])->value('title');
           
          }

          return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$lists];

      }
      return $this->fetch('questionList',['id'=>input('id')]);
    }

    public function questionAdd()
    {
      


        if ($this->request->isAjax())
        {
             $info = input('');
             $info['add_user_id'] = $_SESSION['think']['user_id'];
             unset($info['is_choose']);
             if(db::name('question')->insert($info))
             {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
             }else{
                $data['code'] = -1;
                $data['msg'] = '添加失败';
             }
             return json($data);
        }else{
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            $this->assign('cid',input('id'));
            return $this->fetch('questionAdd');
        }
    }

     public function questionEdit()
    {
        if ($this->request->isPost())
        {
            unset($_POST['is_choose']);
            $info = Db::name('question')->update($_POST);
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '修改失败';
            }
            return json($data);
        }else{
            $this->assign('id',$_REQUEST['id']);
            $list=Db::name('question')->where('id',$_REQUEST['id'])->find();
          
            $this->assign('list',$list);
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
            $this->assign('classArr',$classArr);
            return $this->fetch('question_add');
        }
    }

     public function questionDel()
    {
        if (Db::name('question')->delete($_REQUEST['id']))
        {
            $data['code'] = 1;
            $data['msg'] = '删除成功';
        }else{
            $data['code'] = 0;
            $data['msg']= '删除失败';
        }
        return json($data);

    }
    public function getQuestion($cid,$id)
    {
        $info['title'] = Db::name('classinfo')->where(['id'=>$id,'status'=>'1','status'=>'1'])->value('title');
        $date = db::Name('classinfo')->field('id,cid')->where(['pid'=>$id,'status1'=>'1'])->select();
        $num = floor(20/count($date));
        foreach($date as $k=>$v)
        {
          $arr = db('question')->field('id')->where('cid',$v['cid'])->orderRaw('rand()')->limit($num)->select();
          if(!$arr)
          {
            continue;
          }
          foreach($arr as $K=>$V)
          {
            $data[] = $V['id'];
          }
          $dates[] = $v['cid'];
        }
        if(!isset($dates))
        {
            return 2;
        }
        if((20%count($date)) !== 0)
        {
            $arrs = db::name('question')->field('id')->where('cid','in',$dates)->where('id','not in',$data)->limit(20%count($date))->select();
            if(!empty($arrs))
            {
                foreach($arrs as $k=>$v)
                {
                    $data[] = $v['id'];
                }
            }else{
                $data[] = '';
            }
        }

        if(count($data)<20)
        {
          $arrss = db::name('question')->field('id')->where('cid','in',$dates)->where('id','not in',$data)->limit((20-count($data)))->select();
            foreach($arrss as $k=>$v)
            {
              $data[] = $v['id'];
            }
        }

        if(count($data)<20)
        {
            return 2;
        }
        $info['tid'] = implode(',',$data);
        $info['cid'] = $cid;
        db::name('list')->insert($info);
        return 1;
    }
    
    public function updateQuestion()
    {
        $infos = db::name('outline')->where('id',input('id'))->find();
        $info['title'] = Db::name('classinfo')->where(['id'=>$infos['classify'],'status'=>'1','status'=>'1'])->value('title');
        $date = db::Name('classinfo')->field('id,cid')->where(['pid'=>$infos['classify'],'status1'=>'1'])->select();
        $num = floor(20/count($date));
        foreach($date as $k=>$v)
        {
            $arr = db('question')->field('id')->where('cid',$v['cid'])->orderRaw('rand()')->limit($num)->select();
            if(!$arr)
            {
                continue;
            }
            foreach($arr as $K=>$V)
            {
                $data[] = $V['id'];
            }
            $dates[] = $v['cid'];

        }

        if((20%count($date)) !== 0)
        {
            $arrs = db::name('question')->field('id')->where('cid','in',$dates)->where('id','not in',$data)->limit(20%count($date))->select();
            foreach($arrs as $k=>$v)
            {
                $data[] = $v['id'];
            }
        }
        if(count($data)<20)
        {
            $arrss = db::name('question')->field('id')->where('cid','in',$dates)->where('id','not in',$data)->limit((20-count($data)))->select();
            foreach($arrss as $k=>$v)
            {
                $data[] = $v['id'];
            }
        }
        $info['tid'] = implode(',',$data);
        db::name('list')->where('cid',$infos['id'])->update($info);
        db::name('outline')->where('id',$infos['id'])->update(['files'=>1]);
        return json(['code'=>0,'msg'=>'更新成功']);
    }

    /*
      考核问卷
    */
      public  function question()
      {
        if (Request::instance()->isAjax())
        {
            $count = Db::name('list')->count();
            $lists = Db::name('list')->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$lists];
        }
        return $this->fetch();
      }

      /*试题列表*/
      public function wtList()
      {
        if (Request::instance()->isAjax())
        {
            $questions=Db::name('list')->where('id',input('id'))->value('tid');
            $count=Db::name('question')->where('id','in',$questions)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('question')->where('id','in',$questions)->order('orderby desc,id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
              $list[$k]['type'] = $this->getTitle($v['cid']);
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        return $this->fetch('wt_list',['id'=>input('id')]);
      }

      /*
     * 统计查询
     */
    public function assessment(){
        if ($this->request->isPost())
        {
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
            $where['start_time']=array('between',$array);///员工入职时间
            $where['is_quit'] = array('eq',-1);
            $where['del'] = ['eq','-1'] ; 
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);//员工部门
            }
            if(!empty($_POST['station'])){
                $where['station']=array('in',$_POST['station']);//员工岗位
            }
            //如果是项目经理或项目负责人，只查询自己项目中的所有人
            if($_SESSION['think']['role_title']=='部门总监'){
                $where_pro['framework_id']=Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department');
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $where_pro['user_id']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $where_pro['manager']=$_SESSION['think']['user_id'];
            }elseif($_SESSION['think']['role_title']=='地区业管'){
                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
            }
//            if($_SESSION['think']['role_title']=='地区业管'&&!empty($_SESSION['think']['department'])){
//                //如果是地区业管，且department不为空
//                $where_pro['framework_id']=array('in',$_SESSION['think']['department']);
//            }
            if(isset($where_pro)){
                $where_pro['status']=1;
                $pro_id_arr=Db::name('project')->where($where_pro)->field('id')->select();
                foreach ($pro_id_arr as $item) {
                    $pro_id[]=$item['id'];
                }
                $where['projectname']=array('in',$pro_id);
            }

            //根据条件查询（已上过）该课程的员工
            //var_dump($where);die;

            $list =Db::name('users')->where($where)
                ->where("find_in_set(".$_POST['classify'].",classid)")
                ->order('id desc')->select();
            //Db::name('users')->getLastSql();
            //若查询未培训人员，在对应岗位中去除已培训人员id即可
            if($_POST['is_train']=='-1'){
                if(!empty($list)){

                    $list =Db::name('users')->where($where)
                        ->where("!find_in_set(".$_POST['classify'].",classid)")
                        ->order('id desc')->select();
                }else{

                    $list =Db::name('users')->where($where)
                        ->order('id desc')->select();
                }
            }


            foreach($list as $key => $val){
                $list[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>count($list),"data"=>$list];
        }
        $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('classArr',$classArr);
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());

        return $this->fetch();

    }

    public function Train()
    {
      if ($this->request->isPost())
        {
           $Post = input('');
           if($Post['type'] !== '1')
           {
              $where['uid'] = $Post['uid'];
           }else{
              $where['startdate'] = array('GT',$Post['start_time']);
              $where['enddate']   = array('LT',$Post['end_time']);
              $where['department']= array('in',$Post['department']);

           }

           $list = db::name('question_an')->where($where)->order('department desc')->select();
           foreach($list as $key=>$val)
           {
                $list[$key]['region']=Db::name('framework')->where('id',$val['region'])->value('name');
                $list[$key]['department']=Db::name('framework')->where('id',$val['department'])->value('name');
                $list[$key]['station']=Db::name('posts')->where('id',$val['station'])->value('posts');
                $list[$key]['projectname']=Db::name('project')->where('id',$val['projectname'])->value('name');
                $list[$key]['dates'] = $val['startdate'].'-'.$val['enddate'];
                $list[$key]['info']   =  db::name('classinfo')->where('id',$val['classtype'])->value('title');
           }
            return ["code"=>"0","msg"=>"","count"=>count($list),"data"=>$list];
        }
        $classArr=Db::name('users')->field('id,work_id,username')->where(['is_quit'=>-1,'del'=>-1])->select();
        $this->assign('userinfo',$classArr);
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
        return $this->fetch();
    }

    public function kaohe()
    {
        if (Request::instance()->isAjax())
        {
           $time = Db::name('outline')->where('times',input('times'))->find();
            if($time['classtype'] !== '7')
            {
                 $questions=Db::name('list')->where('cid',$time['id'])->value('tid');
                 $testquestion=Db::name('question')->where('id','in',$questions)->order('id desc')->select();
            }
           
            $infos = db::name('answers')->where('pid',input('id'))->value('content');
            $infos = explode('|', $infos);
            foreach($infos as $k=>$v)
            {
                $dd  = explode(',', $v);
                $arr[$dd[0]] = $dd[1];
            }
            foreach($testquestion as $k=>$v)
            {
              $testquestion[$k]['error'] = $arr[$v['id']];
              $testquestion[$k]['pid'] = input('id');
            }
            return ["code"=>"0","msg"=>"","count"=>count($testquestion),"data"=>$testquestion];
        }
       
        return $this->fetch('kaohe',['id'=>input('id'),'times'=>input('times')]);
    }
    public function editFen()
    {
    
      
        if(db::name('question_an')->where('id',input('id'))->update([input('field')=>input('value')]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);    
    }

    

    public function editAn()
    {
        $info = input('');
        $arr = db::name('answers')->where('pid',$info['pid'])->find();
         $infos = explode('|', $arr['content']);
            foreach($infos as $k=>$v)
            {
                $dd  = explode(',', $v);
                if($dd[0] == $info['id'])
                {
                  $dd[1] = $info['value'];

                }

                $dd = implode(',', $dd);
                $infoarr[] = $dd;
            }
        $arrs = implode('|', $infoarr);
        if(db::name('answers')->where('id',$arr['id'])->update(['content'=>$arrs]))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);  

    }


    public function tests11()
    {
      $userInfo = db::name('users')->field('id as uid,username,region,department,station,projectname,classid')->where(['is_quit'=>-1,'del'=>-1])->where('id','not in','1,2,3,4,5,6,7')->select();
      $data=array();
      foreach($userInfo as $k=>$v)
      {
        foreach(explode(',', $v['classid']) as $key => $val)
        {
          $times = db::name('notice')->where('classify',$val)->where("find_in_set(".$v['uid'].",usersid)")->order('inputtime desc')->value('times');
          
          if($times !== null)
          {
            $info = db::name('outline')->field('username as headmaster,startdate,enddate,times,classify as classtype')->where(['times'=>$times,'del'=>-1])->find();
            if($info !== null)
            {
              unset($v['classid']);
              $v['branch'] = '100';
              $data[] = $v+$info;
            }
          }
          
        }
      }
      
      db::Name('question_an')->insertAll($data);
    }

    public function editPrice()
    {
      $data[input('field')]  =  input('value');
        if(db::name('outline')->where('id',input('id'))->update($data))
        {
            $info = array('code'=>1,'msg'=>'更新成功');
        }else{
            $info = array('code'=>2,'msg'=>'更新失败');
        }
        return json($info);
    }

    public function classSearchInfo()
    {
        $post = input('');
        (isset($post['username']) && $post['username'] != "") && $where['username'] = array('in', $post['username']);
        (isset($post['area']) && $post['area'] != "") && $where['area'] = array('in', $post['area']);
        (isset($post['classify']) && $post['classify'] != "") && $where['classify'] = array('in', $post['classify']);
        if (isset($post['date']) && $post['date'] != '') {
            list($start, $middle, $end) = explode(' ', $post['date']);
            $where['startdate'] = array('between', [$start . ' 00:00:00', $end . ' 00:00:00']);
        }
        if($_SESSION['think']['role_title']=='地区业管'){
            //地区业管只能看自己创建的课程
            $where['userid']=$_SESSION['think']['user_id'];
        }
        $where['del']=array('neq','1');
        $where['is_outline'] = array('eq','线下课程');
        $count=Db::name('outline')->where($where)->count();

        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::name('outline')->where($where)->order('startdate desc')->limit($tol,$limit)->select();

        foreach($list as $key => $val) {
            $list[$key]['classtype'] = Db::name('classinfo')->where('id', $list[$key]['classtype'])->value('title');
            $list[$key]['classify'] = Db::name('classinfo')->where('id', $list[$key]['classify'])->value('title');
            $list[$key]['classname'] = Db::name('classinfo')->where('id', $list[$key]['classname'])->value('title');
        }

        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];

    }
     public function class_info_edit()
    {
      if ($this->request->isPost())
        {
                      unset($_POST['add']);

            if(db::name('class_info')->update($_POST))
            {
              return json(['code'=>1,'msg'=>'修改成功']);
            }else{
              return json(['code'=>2,'msg'=>'修改失败']);
            }
        }
      $list = db::name('class_info')->where('id',input('id'))->find();
      return $this->fetch('class_info_add',['pid'=>$list['pid'],'list'=>$list]);
    }
    public function Management()
    {
        if(Request::instance()->isAjax())
        {
            $list =Db::name('class_info')->where('del','0')->select();
            return json(["code"=>"0","msg"=>"ok","data"=>$list]);
        }
        return $this->fetch();

    }

    public function getUsers()
    {
        $userInfo = db::name('users')->field('id as uid,work_id,user_id as bs_id,username,phone,region,department,station,projectname as project_id,classid,classname,outline_id')->where('region','neq','16')->where('department','neq','29')->where('id','neq','1')->where('id','neq','3262')->limit(4000,500)->select();
        $framework = getFramework();
        $posts = getStations();
        $project = getProjectTitle();
        $class_info = getClassInfo();
        foreach($userInfo as $k => $v)
        {
            $v['region']     != 0 ? $v['region_title']     =  $framework[$v['region']]    :  $v['region_title']   =  '暂无';
            $v['department'] != 0 ? $v['department_title'] =  $framework[$v['department']]:  $v['department_title']=  '暂无';
            $v['station']    != 0 ? $v['station_title']    =  $posts[$v['station']]       :  $v['station_title']   =  '暂无';
            $v['project_id'] != 0 ? $v['project_title']    =  $project[$v['project_id']]  :  $v['project_title']   =   '暂无';
            if($v['classid'] != 0)
            {
                $list = array_filter(explode(',',$v['classid'])) ;
                foreach($list as $key => $val) {
                    $times = db::name('notice')->field('times')->where('classify', $val)->where("find_in_set(" . $v['uid'] . ",usersid)")->select();
                    if (empty($times)) {
                        $times = db::name('notice')->field('times')->where('classify', $val)->select();
                    }
                    if(!empty($times))
                    {
                        foreach($times as $value)
                        {
                            $whereOutline[] = $value['times'];
                        }
                        $outlineArr = db::name('outline')->field('times as class_time,username as headmaster,startdate,enddate')->where('times','in',$whereOutline)->find();
                        if(empty($outlineArr))
                        {
                            $outlineArr = db::name('outline')->field('times as class_time,username as headmaster,startdate,enddate')->where("find_in_set(" . $v['department'] . ",department)")->where("find_in_set(" . $v['station'] . ",station)")->where('classify',$val)->find();
                        }
                        if(!empty($outlineArr))
                        {
                            unset($v['classid']);
                            unset($v['classname']);
                            unset($v['outline_id']);
                            if($val != 0)
                            {
                                $v['classify_title'] = $class_info[$val];
                            }
                            $v['classify_id'] = $val;
                            $v['branch'] = 100;
                            $outlineArr  += $v;
                            $dates[] = $outlineArr;
                        }
                    }

                }
            }

        }
        db::name('train_test_copy')->insertAll($dates);


    }




    public function getUser()
    {
        $userInfo = db::name('users')->field('id as uid,work_id,user_id as bs_id,username,phone,region,department,station,projectname as project_id,classid,classname,outline_id')->where(['is_quit'=>-1,'del'=>-1])->where('region','neq','16')->where('department','neq','29')->where('id','neq','1')->where('id','neq','3262')->limit('2500,500')->select();
       dd($userInfo);
        $framework = getFramework();
        $posts = getStations();
        $project = getProjectTitle();
        $class_info = getClassInfo();
        foreach($userInfo as $k => $v)
        {
            dd($v);
            $v['region']     != 0 ? $v['region_title']     =  $framework[$v['region']]    :  $v['region_title']   =  '暂无';
            $v['department'] != 0 ? $v['department_title'] =  $framework[$v['department']]:  $v['department_title']=  '暂无';
            $v['station']    != 0 ? $v['station_title']    =  $posts[$v['station']]       :  $v['station_title']   =  '暂无';
            $v['project_id'] != 0 ? $v['project_title']    =  $project[$v['project_id']]  :  $v['project_title']   =   '暂无';
            if($v['classid'] != 0)
            {
                $list = array_filter(explode(',',$v['classid'])) ;
                foreach($list as $key => $val)
                {
                    $times = db::name('notice')->field('times')->where('classify',$val)->where("find_in_set(".$v['uid'].",usersid)")->select();

                    if(empty($times))
                    {
                        $times = db::name('notice')->field('times')->where('classify',$val)->select();
                    }

                    if(!empty($times))
                    {
                        foreach($times as $value)
                        {
                            $whereOutline[] = $value['times'];
                        }
                        $outlineArr = db::name('outline')->field('times as class_time,username as headmaster,startdate,enddate')->where('times','in',$whereOutline)->find();
                        unset($v['classid']);
                        unset($v['classname']);
                        unset($v['outline_id']);
                        if($val != 0)
                        {
                            $v['classify_title'] = $class_info[$val];
                        }
                        $v['classify_id'] = $val;
                        $v['branch'] = 100;
                        $outlineArr  += $v;
                        $dates[] = $outlineArr;
                    }

                }

            }
        }
        db::name('train_test_copy')->insertAll($dates);
    }

    public function getClassInfos()
    {
        $info = db::name('five')->select();
        $posts = getStations();
        $posts1 = getStations1();
        $project = getProjectTitle();
        $projects = getProjectTitles();
        $framework = getFramework();
        $class_info = getClassInfo();

        foreach($info as $k=>$v)
        {
            $userId = db::name('users')->field('id as uid,work_id,user_id as bs_id,username,phone,region,department,projectname as project_id')->where('username',$v['username'])->find();
            $times = db::name('notice')->where('classify',$v['class'])->where("find_in_set(".$userId['uid'].",usersid)")->order('times desc')->select();
            foreach($times as $k)
            {
                $datas[] = $k['times'];
            }
            $outlineArr = db::name('outline')->field('times as class_time,username as headmaster,startdate,enddate')->where('times','in',$datas)->order('times desc')->find();
            $outlineArr['classify_title'] = $class_info[$v['class']];
            $outlineArr['classify_id'] = $v['class'];
            $outlineArr['branch'] = $v['brach'];
            $outlineArr['station'] = $posts1[$v['posts']];
            $outlineArr['station_title'] = $v['posts'];

            if($v['project'] != $project[$userId['project_id']])
            {
                $id=db::name('project')->where('name',$v['project'])->find();
                $userId['project_id'] = $id['id'];
                $outlineArr['project_title'] = $id['name'];
            }else{
                $outlineArr['project_title'] = $v['project'];
            }
            $outlineArr += $userId;

            db::name('train')->insert($outlineArr);
            unset($datas);


        }

    }

    /*
     * 整体统计
     * */
    public function getTrainUser()
    {
        if($_SESSION['think']['role_title']=='地区业管'){
            $where['headmaster'] = $_SESSION['think']['user_name'];
        }
        $info = input('');
        if(!empty($info['time_code'])){
            $array_time=explode(' - ', $info['time_code']);
            $array_time[0]=date('Y-m-d H:i:s',strtotime($array_time[0])-1);
            $where['start_time']=array('between',$array_time);
            $wheres['startdate']=array('between',$array_time);
        }
        if(!empty($info['department']))
        {
            $where['department']=array('in',$info['department']);
            $wheres['department']=array('in',$info['department']);
        }
        if(!empty($info['station']))
        {
            $where['station']=array('in',$info['station']);
            $wheres['station']=array('in',$info['station']);
        }
        if(!empty($info['project']))
        {
            $where['projectname']=array('in',$info['project']);
            $wheres['project_id']=array('in',$info['project']);
        }
        if($info['is_train'] != 1)//未培训
        {
            if(!empty($info['username'])){
                $where['id']=array('in',$info['username']);
            }
            if(!empty($info['project'])){
                $where['projectname']=array('in',$info['project']);
            }
            $classify = getClassInfo();
            $project = getProjectTitle();
            $department = getFramework();
            $station = getStations();
            if(!empty($info['classify'])){
                $date = $info['classify'];
                if(strstr($date, ','))
                {
                    return ["code"=>"0","msg"=>"","count"=>0,"data"=>0];
                }
                $where['is_quit']='-1';
                $where['del']='-1';
                //判断筛选人员是否为空
                $id_list=Db::name('users')->where($where)
                    ->where("!find_in_set(".$date.",classid)")
                    ->field('id,work_id,username,region,department,station,projectname,phone')->select();
                if(empty($id_list)){
                    $data['code'] = 0;
                    $data['msg'] = '筛选范围内，没有任何员工';
                    return json($data);
                }
                foreach($id_list as $k=>$val)
                {
                    $id_list[$k]['region'] = $department[$val['region']];
                    $id_list[$k]['department'] = $department[$val['department']];
                    $id_list[$k]['project'] = $project[$val['projectname']];
                    $id_list[$k]['station'] = $station[$val['station']];
                }

                return ["code"=>"0","msg"=>"","count"=>count($id_list),"data"=>$id_list];
            }
        }else{//已培训
            if(!empty($info['classify'])){
                $wheres['classify_id']=array('in',$info['classify']);
            }
            if((int)$info['is_qualified'] !==3)
            {
                $wheres['branch'] = $info['is_qualified'] > 0 ? ['EGT',90] : ['LT',90];
            }
            if(!empty($info['username']))
            {
                $wheres['uid']=array('in',$info['username']);
            }
            $list = db::name('train')->where($wheres)->select();
            return ["code"=>"0","msg"=>"","count"=>count($list),"data"=>$list];
        }
    }

    public function setFid()
    {

        session('fid',input('id'));
        echo session('fid');
    }
    public function setRid()
    {

        session('rid',input('id'));
    }

    public function setFeedback()
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
            db::name('outline')->where('id',session('fid'))->update(['feedbacks'=>$url]);

                    return json($ret);
        }
    }

    public function setReport()
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
            db::name('outline')->where('id',session('rid'))->update(['reports'=>$url]);
            return json($ret);
        }
    }

    public function changeDate()
    {
        $sql = "select id from shilian_train group by classify_title,uid having count(*) > 1";
        $ids = db::name('train')->query($sql);
        foreach($ids as $k=>$v)
        {
            $date[] = $v['id'];
        }
        db::name('train')->where('id','in',$ids)->delete();
    }

    public function getFeekBacks()
    {
            $file = request()->file('file');
            $name = $file->getInfo();
            $name =substr($name['name'],0,strrpos($name['name'],"."));
            $info = $file->move(ROOT_PATH . 'public/uploads',$name.time());
            $reubfo = array();
            if($info){
                $reubfo['info']= 1;
                $reubfo['savename'] = $info->getSaveName();
                $feedbacks = db::name('outline')->where('times',input('times'))->value('feedbacks');
                if(empty($feedbacks))
                {
                    db::name('outline')->where('times',input('times'))->update(['feedbacks'=>'public/uploads/'.$info->getSaveName()]);
                }else{
                    db::name('outline')->where('times',input('times'))->update(['feedbacks'=>$feedbacks.','.'public/uploads/'.$info->getSaveName()]);
                }
            }
        return json(['code'=>0,'msg'=>'上传成功','status'=>1,'src'=>'public/uploads/'.$info->getSaveName()]);

    }


    public function ceshis2()
    {
        $userInfo = db::name('train')->select();
        dd($userInfo);die;
        $framework = getFramework();
        $project = getProjectTitle();
        foreach($userInfo as $k => $v) {
            $v['region'] != 0 ? $v['region_title'] = $framework[$v['region']] : $v['region_title'] = '暂无';
            $v['department'] != 0 ? $v['department_title'] = $framework[$v['department']] : $v['department_title'] = '暂无';
            $v['project_id'] = db::name('users')->where('id',$v['uid'])->value('projectname');
            $v['project_id'] != 0 ? $v['project_title']    =  $project[$v['project_id']]  :  $v['project_title']   =   '暂无';
            db::name('train')->update($v);
        }
    }
    public function teacher()
    {
        if ($this->request->isAjax())
        {
            $array=explode(' - ', input('time_code'));
            $where['startdate']=array('between',$array);
            $where['userid'] = array('in',input('username'));
            $info = db::name('outline')->field('times')->where($where)->select();
            foreach($info as $k=>$v)
            {
                $date[] = $v['times'];
            }
            if(isset($date))
            {
                $lists = db::name('train')->where('class_time','in',$date)->where('uid','not in','1,2,3,4,5,6,7,8,9,10,11,12')->order('headmaster desc')->select();
                foreach($lists as $k=>$v)
                {
                    $lists[$k]['money'] = 15;
                }
                return ["code"=>"0","msg"=>"","count"=>count($lists),"data"=>$lists];
            }else{
                return ["code"=>"0","msg"=>"","count"=>0,"data"=>0];
            }
        }else{
            return $this->fetch('',['teacher'=>db::name('outline')->field('userid,username')->group('userid')->select()]);
        }
    }


    public function getProjects()
    {
        $date = db::Name('maintain')->where('station','in','12,13,14,15,18,19,21')->select();
        foreach($date as $k=>$v)
        {
            if($v['pid']!==$v['project'])
            {
                $data[]=$v;
            }
        }
//        dd($data);die;
//        foreach($data as $k=>$v)
//        {
//            db::name('users')->where('id',$v['uid'])->update(['projectname'=>$v['pid']]);
//            db::name('maintain')->where('id',$v['id'])->update(['project'=>$v['pid']]);
//        }
    }


    public function Trains()
    {
        if ($this->request->isAjax())
        {
            $info  =  input('');
            if(isset($info['area']))
            {
                $where['area'] = array('in',$info['area']);
            }
            if(isset($info['classify']))
            {
                $where['classtype'] = array('in',$info['classify']);
            }
            if($_SESSION['think']['role_title']=='地区业管'){
                $where['userid']=$_SESSION['think']['user_id'];
            }
            $where['is_outline'] = array('neq','线下课程');
            $count=Db::name('outlines')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('outlines')->where($where)->order('startdate desc')->limit($tol,$limit)->select();
            if(!empty($list))
            {
                foreach($list as $key => $val){
                    $list[$key]['classtype'] = getOutline($list[$key]['classtype']);
                    $list[$key]['classify']  = getOutline($list[$key]['classify']);
                    $list[$key]['classname'] = getOutline($list[$key]['classname']);
                }
            }else{
                $list = '';
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $area = db::name('outlines')->group('area')->select();
        return $this->fetch('',['area'=>$area]);
    }

    public function outlineAdds()
    {
        if ($this->request->isPost())
        {
            $_POST['video_url'] = db::name('class_info')->where('id',$_POST['classname'])->value('url');
            $id = db::name('outlines')->insertGetId($_POST);
            $this->qrcode('http://app.sz-senox.com/api/course/outlineStars?id='.$id,$id.'.png');
            db::name('outlines')->where('id',$id)->update(['qrcode'=>$id.'.png']);
            return json(['code'=>1,'msg'=>'增加成功']);
        }
        $classArr=Db::name('class_info')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
        $this->assign('classArr',$classArr);
        $this->assign('times',time());
        return $this->fetch();
    }


    public function class_Info()
    {
        if(input('pid') == '222')
        {
            $pid = '225';
        }else if(input('pid') == '235')
        {
            $pid = '250';
        }else{
            $pid = input('pid');
        }
        return json(["code"=>"0","msg"=>"ok","data"=>db::name('class_info')->where('pid',$pid)->select()]);
    }

    public function outlinesDel()
    {
        if(Db::name('outlines')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }

    public function outlineEdit()
    {
        if (Request::instance()->isPost())
        {
            db::name('outlines')->update(input(''));
            return json(['code'=>1,'msg'=>'修改成功']);
        }
        $list = db::name('outlines')->where('id',input('id'))->find();
        $list['classify_name']  = getOutline($list['classify']);
        $list['class_name']      = getOutline($list['classname']);
        $classArr=Db::name('class_info')->where('pid','0')->order('orderby desc,id asc')->select();
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
        $this->assign('classArr',$classArr);
        return $this->fetch('outline_adds',['list'=>$list]);
    }

    public function outlineStars()
    {
        return $this->fetch();
    }

    public function apply()
    {
        if (Request::instance()->isAjax())
        {
            if(!empty($_POST['username'])){
                $where['username']= $_POST['username'];
            }
            if(!empty($_POST['ban'])){
                $where['ban']= $_POST['ban'];
            }
            if(!empty($_POST['className'])){
                $where['className']= $_POST['className'];
            }
            if(!empty($_POST['start_date'])){
                $where['start_date']= $_POST['start_date'];
            }
            $userId = (int)session('user_id');

            if($userId !== 1)
            {
                $department = db::name('user')->where('id',$userId)->value('department');
                $where['department'] = array('in',explode(',',$department));
            }
            if(empty($where))
            {
                $where = '1=1';
            }
            $count=Db::name('apply')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('apply')->where($where)->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $userName = db::name('apply')->field('username')->group('username')->select();
        $ban = db::name('apply')->field('ban')->group('ban')->select();
        $className = db::name('apply')->field('className')->group('className')->select();
        $start_date = db::name('apply')->field('start_date')->group('start_date')->select();
        return $this->fetch('',['userName'=>$userName,'ban'=>$ban,'className'=>$className,'start_date'=>$start_date]);
    }

    public function applyStatus()
    {
        $status = -$_POST['status'];
        db::name('apply')->where('id',input('id'))->update(['status'=>$status]);
        return json(['code'=>1,'msg'=>'修改成功']);
    }
    public function peixun(){
        if ($this->request->isPost())
        {
            $time_code=$_POST['time_code'];
            $array=explode(' - ', $time_code);
            $where['start_time']=array('between',$array);///员工入职时间
            $wheres['start_time']=array('between',$array);///员工入职时间
            $where['is_quit'] = array('eq',-1);
            $where['del'] = ['eq','-1'] ;
            $department = [19,20,21,23,38,65,67,68,69,75];
            $where['station'] = ['in',$_POST['station']];
            $wheres['station'] = ['in',$_POST['station']];
            foreach($department as $k)
            {
                $where['department'] = array('eq',$k);
                $val['count'] = db::name('users')->where($where)->count();
                $val['study'] = db::name('users')->where("find_in_set(".$_POST['classify'].",classid)")->where('department',$k)->where($where)->count();
                $val['studys'] = db::name('users')->where("find_in_set(".$_POST['classify'].",classid)")->where('department',$k)->where($wheres)->count();
                if($val['study'] == 0)
                {
                    $val['bate']  = '0%';
                }else{
                    $val['bate']  = (100*round($val['study']/$val['count'],2)).'%';
                }
                $val['notStudy'] = $val['count']-$val['study'];
                $val['department']=Db::name('framework')->where('id',$k)->value('name');
                $list[] = $val;
            }
            return ["code"=>"0","msg"=>"","count"=>6,"data"=>$list];
        }

        $this->assign('classArr',Db::name('classinfo')->where('pid','0')->order('orderby desc,id asc')->select());
        $this->assign('classify',Db::name('classinfo')->where('pid','neq','0')->order('orderby desc,id asc')->select());
        $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
        $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
        $this->assign('posts_pid',Db::name('posts')->where('pid','eq','0')->order('id asc')->select());
        $this->assign('posts',Db::name('posts')->where('pid','neq','0')->where('status',1)->select());
        $this->assign('project',Db::name('project')->field('id,name')->where(['status'=>1,'del'=>-1])->select());
        $userArr = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->select();
        $this->assign('userArr',$userArr);
        return $this->fetch();
    }
    public function uploads12()
    {
        header("Access-Control-Allow-origin:*");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit;
        }


        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

        @set_time_limit(5 * 60);

        $targetDir = 'upload_tmp';
        $uploadDir = 'shipin';

        $cleanupTargetDir = true;
        $maxFileAge = 5 * 3600;


        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
            $size = $_REQUEST["size"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
            $size = $_REQUEST["file"]["size"];
        } else {
            $fileName = uniqid("file_");
        }
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                // echo '123';
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id","uploadPath":$uploadPath}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                // echo '1';
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }

        echo ('{"jsonrpc" : "2.0", "result" : '.$uploadPath.', "id" : "id"}');
    }


}
