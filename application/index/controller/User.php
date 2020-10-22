<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class User extends Common
{
    /*
     * 个人中心
     * */
    public function personalCenter()
    {
        $notice=Db::name('notice')->where("find_in_set(".Session::get('userId').",usersid)")->select();
        $i=0;
        foreach ($notice as $key => $val){
            $outline_id=Db::name('outline')
                ->where('times',$val['times'])
                ->where('del','neq','1')
                ->where('station','eq','')
                ->value('id');//var_dump(Db::name('outline')->getLastSql());die;
            if(!empty($outline_id)){
                $count=Db::name('users')->where("find_in_set(".$outline_id.",outline_id)")
                    ->where('id',Session::get('userId'))
                    ->count();
                if($count==0){
                    $i++;
                }
            }
        }
        $department = Db::name('users')->where('id',Session::get('userId'))->value('department');
        $station = Db::name('users')->where('id',Session::get('userId'))->value('station');
        $article_num = Db::name('article')
            ->where("find_in_set(".$department.",department)")
            ->where("find_in_set(".$station.",station)")
            ->where("!find_in_set(".Session::get('userId').",seen)")
            ->count();

        $info=Db::name('users')->where('id',Session::get('userId'))->find();

        $this->assign('info',$info);
        $this->assign('num',$i);
        $this->assign('article_num',$article_num);
        return $this->fetch();
    }
    /*
     * 设置个人信息
     * */
    public function setUser()
    {

        if (Request::instance()->isPost())
        {
            
            if($_POST['region'] === "")
            {
                unset($_POST['region']);
              unset($_POST['department']);

                unset($_POST['station']);
                  unset($_POST['projectname']);

            }
            $where['username'] = array('eq',$_POST['username']);
            $where['id']       = array('neq',$_POST['id']);
            
            $username = Db::name('users')->where($where)->find();
            if($username)
            {
                return json(['code'=>2,'msg'=>'用户名已存在']);
            }
            if(Db::name('users')->update($_POST))
            {
                $return = ['code'=>1,'msg'=>'更新成功'];
            }else{
                $return = ['code'=>2,'msg'=>'未更改任何内容'];
            }
            return json($return);
        }
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        $info = Db::name('users')->where('username',Session::get('username'))->find();
        $info['departments'] = Db::name('framework')->where('id',$info['department'])->value('name');
        $info['stations']  = Db::name('posts') ->where('id',$info['station'])->value('posts');
        $info['projectnames']  = Db::name('project') ->where('id',$info['projectname'])->value('name');

     
        return $this->fetch('set_user',['info'=>$info]);
    }

    /*
     * 头像上传
     * */
    public function checkAvatar()
    {
        return $this->fetch();
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
    /*
     * 修改密码
     * */
    public function checkPass()
    {
        if (Request::instance()->isPost())
        {
            $info = Db::name('users')->where('id',Session::get('userId'))->find();
            if(md5($info['random'].input('pass'))!==$info['pass'])return json(['msg'=>'旧密码不正确']);
            if(input('new_pass')!==input('news_pass'))return json(['msg'=>'两次密码不一致']);
            Db::name('users')->where('id',Session::get('userId'))->update(['pass'=>md5($info['random'].input('new_pass'))]);
            return json(['msg'=>'更新密码成功']);
        }
        return $this->fetch();
    }

    /*
     *修改岗位
     * */
    public function checkPosts()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('users')->update(input('')))
            {
                return json(['msg'=>'修改成功']);
            }else
            {
                return json(['msg'=>'修改失败']);
            }
        }
        $info=Db::name('users')->where('id',Session::get('userId'))->find();
        if($info['station']!=="")
        {
            $this->assign('station',Db::name('posts')->where('pid',$info['region'])->select());
        }
        $this->assign('region',Db::name('posts')->where('pid',0)->select());
        $this->assign('info',$info);
        return $this->fetch();
    }
    /*
     * 获取岗位
     * */
    public function getPosts()
    {
        return json(Db::name('posts')->where('pid',input('pid'))->select());
    }
    /*
     * 修改项目
     * */
    public function checkProject()
    {
        if (Request::instance()->isPost())
        {
            if(Db::name('users')->update(input('')))
            {
                return json(['msg'=>'修改成功']);
            }else
            {
                return json(['msg'=>'修改失败']);
            }
        }
        $info=Db::name('users')->where('id',Session::get('userId'))->find();
        if($info['projectname']!=="")
        {
            $this->assign('project',Db::name('project')->where('framework_id',$info['department'])->select());
        }
        $this->assign('fatherList',Db::name('framework')->where('pid','-1')->select());
        $this->assign('sonList',Db::name('framework')->where('pid','>','-1')->order('pid asc')->select());
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function getProject()
    {
        return json(Db::name('project')->where('framework_id',input('pid'))->select());
    }
    /*
     * 通知消息
     * */
    public function Message()
    {

        if(isset($_GET['num']))
        {

            $info = Db::name('notice')->field('times')->where("find_in_set(".Session::get('userId').",usersid)")->select();
            foreach ($info as $val) {
                $val = join(",",$val);//数组转化为字符串
                $temp_array[] = $val;
            }
            $str = implode(",", $temp_array);
            //var_dump($str);exit;
            $Info['curPageData'] = Db::name('outline')->where('times','in',$str)->limit((input('num')-1)*input('size'),input('size'))->order('times desc')->select();
            foreach($Info['curPageData'] as $key => $val)
            {
                $Info['curPageData'][$key]['title'] = Db::name('classinfo')->where('id',$val['classify'])->value('title');
                $count=Db::name('users')->where('id',Session::get('userId'))
                    ->where("find_in_set(".$val['classify'].",classid)")
                    ->count();
                if($count>0){
                    $Info['curPageData'][$key]['title'] .='（已学习）';
                }
                $Info['curPageData'][$key]['startdate'] = date('y-m-d',strtotime($val['startdate']));
                $Info['curPageData'][$key]['enddate'] = date('y-m-d',strtotime($val['enddate']));
            }
            return json($Info);
        }
        return $this->fetch();
    }
    public function feedback(){
        if (Request::instance()->isPost())
        {

//获取question,让员工提交start
            //outline的times,testquestion的id，testlist的id
            $info=$_POST['info'];


            $i=0;
            $time=time();
            foreach ($info as $key => $val){
                if($key!='question'&&$key!='times'){
                    $data[$i]['answer']=$val;
                    $data[$i]['testquestion']=$key;
                    $data[$i]['testlist']=$info['question'];
                    $data[$i]['times']=$info['times'];
                    $data[$i]['users_id']=Session::get('userId');
                    $data[$i]['updatetime']=$time;
                    $i++;
                }
            }
            $data=array_values($data);
            $infos=Db::name('answer')->insertAll($data);
            //获取question,让员工提交end
            //员工提交问题后，修改users中classid/outline_id    start
            if($infos){
                //获取times，查询对应课程id/classify
                $result=Db::name('outline')->where('times',$info['times'])->field('id as outline_id,classify as classid')->find();
                $users=Db::name('users')->where('id',Session::get('userId'))->find();
                if(!empty($users['classid'])){
                    $users['classid']=$users['classid'].','.$result['classid'];
                    $users['classid']=implode(',',array_unique(explode(',',$users['classid'])));
                }else{
                    $users['classid']=$result['classid'];
                }
                if(!empty($users['outline_id'])){
                    $users['outline_id']=$users['outline_id'].','.$result['outline_id'];
                    $users['outline_id']=implode(',',array_unique(explode(',',$users['outline_id'])));
                }else{
                    $users['outline_id']=$result['outline_id'];
                }
                $users['updatetime']=time();
                $info=Db::name('users')->update($users);//记录学过的课程分类，记录上过的outline 的id
                if($info){
                    $data['msg']='提交成功，已记录对应课程！';
                    return json($data);
                }else{
                    $data['msg']='提交失败，请联系管理员！';
                    return json($data);
                }

            }


        }
        //非提交

        $count=Db::name('notice')
                ->where('times',$_GET['times'])
                ->where("find_in_set(".session::get('userId').",usersid)")
                ->count();

       /* if($count<1){
            $this->error('未通知您上课，无需提交！');
        }*/
        $count=Db::name('answer')
            ->where('testlist',$_GET['question'])
            ->where('times',$_GET['times'])
            ->where('users_id',session::get('userId'))
            ->count();
        if($count>0){
            $this->error('已提交，请勿重复操作');
        }
        $questions=Db::name('testlist')->where('id',$_GET['question'])->value('questions');
        $testquestion=Db::name('testquestion')->where('id','in',$questions)->order('orderby desc,id desc')->select();
        $this->assign('testquestion',$testquestion);


        $this->assign('question',$_GET['question']);
        $this->assign('times',$_GET['times']);
        return $this->fetch();
    }

    public function should()
    {
         if(isset($_GET['num']))
        {
            $classids = Db::name('users')->where('id',$_SESSION['think']['userId'])->find();
            $classid =  (int)$classids['station'];

            $ddd = explode(',',$classids['classid']);
            if(in_array($classid,['16','17','18','19']))
            {
                    $pid = 3;
                    if($classid == 16)
                    {
                        $pid = '2,3';
                    }
            }elseif(in_array($classid,['13','14','15']))
            {
                 $pid = '1';
                     if($classid == 13)
                    {
                        $pid = '2,1';
                    }

                  
            }elseif(in_array($classid,['2','12']))
            {
                    $pid = 2;
            }
            
            $Info= Db::name('classinfo')->where('pid','in',$pid)->limit((input('num')-1)*input('size'),input('size'))->select();
           
           
            foreach($Info as $key=>$v)
            {
                $Info[$key]['pid'] = Db::name('classinfo')->where('id',$v['pid'])->value('title') ;
                if(in_array($v['id'],$ddd))
                {
                    unset($Info[$key]);
                }
               
            }


            $Infos['curPageData'] = array_values($Info);
           
            return json($Infos);
        }
        return $this->fetch();
    }

    public function feedbacks(){
        $userId = session('userId');

        $numbers = db::name('scoring')->where(['tid'=>$userId,'time'=>input('times')])->count();
        $number = db::name('outline_lecturer')->where('times',input('times'))->group('id')->count();
        if($numbers<$number)
        {
            $this->error('未完成讲师打分，不能进行考核！');

        }
        if (Request::instance()->isPost())
        {
            $info = input('');
            $userInfo = Db::name('users')->field('region,department,station,projectname,username,id as uid')->where('id',session('userId'))->find();
            if(count($info)>20)
            {
                $ddd = Db::name('outline')->where('times',$info['times'])->find();
                $time = $ddd['id'];
                $questions=Db::name('list')->where('cid',$time)->value('tid');
                $testquestion=Db::name('question')->where('id','in',$questions)->order('id desc')->select();
                $infos['times'] = $info['times'];unset($info['times']);
                $infos['proposal'] = $info['proposal'];unset($info['proposal']);
                $infos['experience'] = $info['experience'];unset($info['experience']);
                $infos['puzzled'] = $info['puzzled'];unset($info['puzzled']);
                $infos['price'] = $ddd['price'];
                $data =  0;
                $add = $info;
                unset($add['id']);
               
                $arrInfo['content'] = implode('|', $add); 
               
                foreach($testquestion as $k=>$v)
                {
                    foreach($info as $K)
                    {
                        $dd = explode(',',$K);
                        if($dd[0] == $v['id'])
                        {
                            if($dd[1] == $v['true_option'])
                            {
                                $data +=5;
                                break;
                            }
                        }
                    }
                }

                $infos['branch'] = $data;
unset($infos['times']);
                if($data<60)
                {
                                db::name('train')->where('id',$info['id'])->update($infos);
                                $arrInfo['pid'] = $info['id'];
                                db::name('answers')->insert($arrInfo);
                    return json(['code'=>3,'msg'=>'考试不及格','url'=>$ddd['classify']]);
                }
                if($data<90)
                {
                    if(Session::has('data'))
                    {
                                db::name('train')->where('id',$info['id'])->update($infos);
                                $arrInfo['pid'] = $info['id'];
                                db::name('answers')->insert($arrInfo);
                        return json(['code'=>3,'msg'=>'考试不及格','url'=>$ddd['classify']]);
                    }else{
                        session('data',$data);
                    }                    
                    return json(['code'=>2,'msg'=>'您的分数不够90分，需要重新考试！！！']);
                }else{
                                db::name('train')->where('id',$info['id'])->update($infos);
                                $arrInfo['pid'] = $info['id'];
                                db::name('answers')->insert($arrInfo);
                                return json(['code'=>1,'msg'=>'你的成绩合格了','url'=>$ddd['classify']]);
                }
            }else{

                $info += $userInfo;
                db::name('train')->insert($info);
                return json(['code'=>'8','msg'=>'谢谢参与']);
            }
        }
        //非提交
        $count=Db::name('notice')
                ->where('times',$_GET['times'])
                ->where("find_in_set(".$userId.",usersid)")
                ->count();
        if($count<1){
            $this->error('未通知您上课，无需提交！');
        }
        $count=Db::name('train')
            ->where('class_time',$_GET['times'])
            ->where('uid',$userId)
            ->find();
        if($count&&($count['branch']>0)){
            $this->error('已提交，请勿重复操作');
        }
        $time = Db::name('outline')->where('times',input('times'))->find();

        if($time['classtype'] !== '7')
        {
             $questions=Db::name('list')->where('cid',$time['id'])->value('tid');
             $testquestion=Db::name('question')->where('id','in',$questions)->order('id desc')->select();
             $this->assign('testquestion',$testquestion);
        }
        $result=Db::name('outline')->where('times',input('times'))->field('id as outline_id,classify as classid')->find();
        $users = db::name('users')->field('id as uid,work_id,user_id as bs_id,username,phone,region,department,station,projectname as project_id,classid,outline_id')->where('id',$userId)->find();
        $framework = getFramework();
        $posts = getStations();
        $project = getProjectTitle();
        $class_info = getClassInfo();
        $users['region']     != 0 ? $users['region_title']     =  $framework[$users['region']]    :  $users['region_title']   =  '暂无';
        $users['department'] != 0 ? $users['department_title'] =  $framework[$users['department']]:  $users['department_title']=  '暂无';
        $users['station']    != 0 ? $users['station_title']    =  $posts[$users['station']]       :  $users['station_title']   =  '暂无';
        $users['project_id'] != 0 ? $users['project_title']    =  $project[$users['project_id']]  :  $users['project_title']   =   '暂无';
        if(!empty($users['classid'])){
            $users['classid']=$users['classid'].','.$result['classid'];
            $class_id = implode(',',array_unique(explode(',',$users['classid']))); //去除重复的课程id
        }else{
            $class_id = $result['classid'];
        }
        unset($users['classid']);
        if(!empty($users['outline_id'])){
            $users['outline_id'] = $users['outline_id'].','.$result['outline_id'];
            $outline_id = implode(',',array_unique(explode(',',$users['outline_id'])));
        }else{
            $outline_id = $result['outline_id'];
        }
        unset($users['outline_id']);
        $info=Db::name('users')->where('id',$userId)->update(['outline_id'=>$outline_id,'classid'=>$class_id]);
        $outlineArr = db::name('outline')->field('times as class_time,username as headmaster,startdate,enddate')->where('times',input('times'))->find();
        if($result['classid'] != 0)
        {
            $outlineArr['classify_title'] = $class_info[$result['classid']];
        }
        $outlineArr['classify_id'] = $result['classid'];
        if(!empty($count))
        {
            $id = $count['id'];
        }else{
            $users  += $outlineArr;
            $id = db::name('train')->insertGetId($users);
        }
        $this->assign('id',$id);
        $this->assign('times',$_GET['times']);
        $this->assign('types',$time['classtype']);
        return $this->fetch();
    }

    public function Troubleshooting()
    {

        $time = Db::name('outline')->where('times',input('times'))->find();
        if($time['classtype'] !== '7')
        {
             $questions=Db::name('list')->where('cid',$time['id'])->value('tid');
             $testquestion=Db::name('question')->where('id','in',$questions)->order('id desc')->select();
             $this->assign('testquestion',$testquestion);
        }
        $info = db::name('train')->where(['uid'=>session('userId'),'class_time'=>input('times')])->value('id');
        if($info == null)
        {
            $this->error('你还没有进行考核');
        };
        $infos = db::name('answers')->where('pid',$info)->value('content');
        $infos = explode('|', $infos);
       
        foreach($infos as $k=>$v)
        {
            $dd  = explode(',', $v);
            $arr[$dd[0]] = $dd[1];
        }
        $this->assign('haha',$arr);
        return $this->fetch();
    }

}
