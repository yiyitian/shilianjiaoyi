<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/7/6
 * Time: 17:37
 */
namespace app\api\controller;
use app\api\model\Users;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Course extends Common
{
    public function index()
    {
        $userInfo = db::name('users')->where('id', session('userId'))->find();
       if($userInfo['region']  == '70')
        {
            $this->assign('fang',1);
        }

        $list = db::name('outlines')->where('classtype','in',[223])->select();
        $outlines = db::Name('users')->where('id',session('userId'))->value('outlines');
        $inArray = empty($outlines)?[]:explode(',',$outlines);
        $nom = 0;
        foreach($list as $k=>$v)
        {
            $list[$k]['class_name'] = getOutline($v['classname']);
            $num = in_array($v['id'],$inArray)?1:-1;
            $list[$k]['study'] = $num;
            if($num<0)
            {
                $nom  = $nom + 1;
            }

        }
        $this->assign('num',$nom);
        return $this->fetch();
    }
    /*
     * 认证课程
     * */
    public function Authentication()
    {
        return $this->fetch();
    }
    public function agentOnline()
    {
        $userInfo = db::name('users')->where('id',session('userId'))->find();
        $station = $userInfo['station'];
        $classList = empty($userInfo['outlines'])?[]:explode(',',$userInfo['outlines']);
        if(in_array($station,[18,19]))
        {
            $pid = '241';
        }elseif(in_array($station,[13,14,15]))
        {
            $pid = '233';
        }else{
            $pid = '240';
        }
        $classInfo = db::name('outlines')->where('classify',$pid)->select();
        foreach($classInfo as $k=>$v)
        {
            $classInfo[$k]['study'] = in_array($v['id'],$classList)?-1:1;
            $classInfo[$k]['class_name'] = getOutline($v['classname']);
        }
        return $this->fetch('',['list'=>$classInfo]);
    }

     /*
     * 直销课程
     * */
    public function fangLianBao()
    {
        return $this->fetch();
    }

    /*
     * 直销线下课程
     * */
    public function sellingOffline()
    {
        $class = db::name('classinfo')->where('pid','193')->select();
        foreach($class as $k=>$v)
        {
            $isTrain = db::name('train')->where(['uid'=>session('userId'),'classify_id'=>$v['id']])->value('branch');
            if(empty($isTrain))
            {
                $class[$k]['is_train'] = '-1';
                $class[$k]['is_qualified'] = -1;
            }else{
                $class[$k]['is_train'] = '1';
                if($isTrain<90)
                {
                    $class[$k]['is_qualified'] = -1;
                }else{
                    $class[$k]['is_qualified'] = 1;
                }
            }
        }
        return $this->fetch('sellingOffline',['compulsory'=>$class]);
    }

    /*
     * 直销线上课程
     * */
    public function sellingOnline()
    {
        $userInfo = db::name('users')->where('id',session('userId'))->find();
        $classList = empty($userInfo['outlines'])?[]:explode(',',$userInfo['outlines']);
        $classInfo = db::name('outlines')->where('classtype','235')->select();
        foreach($classInfo as $k=>$v)
        {
            $classInfo[$k]['study'] = in_array($v['id'],$classList)?-1:1;
            $classInfo[$k]['class_name'] = getOutline($v['classname']);
        }
        return $this->fetch('',['list'=>$classInfo]);
    }
    /*
     * 在线学习课程*/
    public function agentOnlineDetail()
    {
        db::name('outlines')->where('id',input('id'))->setInc('num',1);
        $info = db::name('users')->where('id',session('userId'))->value('outlines');
        if(!empty($info))
        {
            $info = explode(',',$info);
        }else{
            $info = [];
        }
        if(!in_array(input('id'),$info))
        {
            $info[] = input('id');
            db::name('users')->where('id',session('userId'))->update(['outlines'=>implode(',',$info)]);
            $this->assign('show',1);
        }
        $info = db::name('outlines')->where('id',input('id'))->find();
        $video = db::name('class_info')->where('id',$info['classname'])->value('url');
        $info['class_name'] = getOutline($info['classname']);
        return $this->fetch('',['info'=>$info,'video'=>$video]);
    }

    public function agentOffline()
    {
        if(session('userId') ==1)
        {
            session('station',19);
        }
        switch (session('station')) {
            case 19:
                $where['id']     = ['in','13,14'];
                $elective['id']  = ['in','15,16,8,9,10,11'];
                break;
            case 18:
                $where['id']     = ['in','13,14'];
                $elective['id']  = ['in','15,16,8,9,10,11'];
                break;
            case 16:
                $where['id']     = ['in','13,14,15,16'];
                $elective['id']  = ['in','8,9,10,11'];
                break;
            case 17:
                $where['id']     = ['in','13,14,15,16'];
                $elective['id']  = ['in','8,9,10,11'];
                break;
            case 15:
                $where['id']     = ['in','8,9'];
                $elective['id']  = ['in','13,14,15,16,10,11'];
                break;
            case 14:
                $where['id']     = ['in','8,9'];
                $elective['id']  = ['in','13,14,15,16,10,11'];
                break;
            case 13:
                $where['id']     = ['in','8,9,10,11'];
                $elective['id']  = ['in','13,14,15,16'];
                break;
        }
        if(!isset($where))
        {
            $compulsory='';
            $elective='';
            return $this->fetch('',['compulsory'=>$compulsory,'elective'=>$elective]);

        }else{
            $compulsory = db::name('classinfo')->where($where)->select();
            $elective = db::name('classinfo')->where($elective)->select();
            return $this->fetch('',['compulsory'=>$this->getClass($compulsory,1),'elective'=>$this->getClass($elective,2)]);

        }
    }

    private function getClass($list,$type=1)
    {
        foreach($list as $k=>$v)
        {
            $array = db::Name('train')->where(['uid'=>session('userId'),'classify_id'=>$v['id']])->value('branch');
            $list[$k]['is_train']     = (null !== $array)?1:-1;
            $list[$k]['is_qualified'] = ((null !== $array)&&($array>90))?1:-1;
            $times = db::name('outline')->where('classify',$v['id'])->where('startdate','<',date('Y-m-d H:i:s',time()))->where('enddate','>',date('Y-m-d H:i:s',time()))->value('times');
            $time = db::name('outline')->where('classify',$v['id'])->where('startdate','<',date('Y-m-d H:i:s',time()))->where('enddate','>',date('Y-m-d H:i:s',time()))->value('times');
            if(null !== $times)
            {
                if($type == 1)
                {
                    $isHave = db::name('notice')->where('times',$times)->where("find_in_set(".session('userId').",usersid)")->find();
                    $list[$k]['isHave'] = (null !== $isHave) ? 1 : -1;
                }else{
                    $list[$k]['isHave'] = 1;
                }
                $list[$k]['times'] = $times;
            }
            if(null !== $time)
            {
                if($type == 1)
                {
                    $isHave = db::name('notice')->where('times',$time)->where("find_in_set(".session('userId').",usersid)")->find();
                    $list[$k]['isLearn'] = (null !== $isHave) ? 1 : -1;
                }else{
                    $list[$k]['isLearn'] = 1;
                }
                $list[$k]['time'] = $time;
            }
        }
        return $list;
    }

    public function signUp()
    {
        if(Request::instance()->isPost())
        {
            $userInfo = db::name('users')->field('department,projectname,station,username,id as uid')->where('id',session('userId'))->find();
            $date = input('')+$userInfo;
            if(db::name('apply')->insert($date))
            {
                return json(['code'=>0,'msg'=>'报名成功，请等待审核']);
            }else{
                return json(['code'=>2,'msg'=>'报名失败']);
            }
        }
        $outlineInfo = db::name('outline')->where('times',input('times'))->find();
        $outlineInfo['className'] = db::name('classinfo')->where('id',$outlineInfo['classify'])->value('title');
        $userInfo = Users::get(session('userId'))->toArray();
        $userInfo['region'] = getName(1,$userInfo['region']);
        $userInfo['department'] = getName(1,$userInfo['department']);
        $userInfo['projectname'] = getName(3,$userInfo['projectname']);
        $userInfo['station'] = getName(2,$userInfo['station']);
        $apply = db::name('apply')->where(['times'=>input('times'),'uid'=>session('userId')])->find();
        if($outlineInfo['is_zheng'] == '是')
        {
            $this->assign('is_zheng',1);
        }else{
            $this->assign('is_zheng',-1);
        }
        if(!empty($apply))
        {
            $this->assign('apply',$apply);
        }
        return $this->fetch('',['outline'=>$outlineInfo,'userInfo'=>$userInfo,'times'=>input('times')]);
    }

    public function details()
    {
        if(null !== input('times'))
        {
            $ddd = input('times');
        }else{
            $id = session('userId');
            $userInfo = db::name('users')->where('id',$id)->value('outline_id');
            $dd = Db::name('notice')->where('classify',input('id'))->where("find_in_set(".$id.",usersid)")->order('id desc')->select();
            foreach($dd as $k=>$v)
            {
                $datas[] = $v['times'];
            }
            $ddd = db::name('outline')->where('classify',input('id'))->where('times','in',$datas)->where('id','in',$userInfo)->value('times');
        }
        $outArr = db::Name('outline')->where('times',$ddd)->find();
        if($outArr['status'] == 1)
        {
            $this->error('考试已经结束了');
        }
        $user = db::name('outline_lecturer')->where('times',$ddd)->select();
        if($user == null)
        {
            $this->redirect('/api/course/feedbacks?times='.$ddd);
        }
        foreach($user as $k=>$v)
        {
            $user[$k]['name'] = db::name('users')->where('id',$v['lecturer'])->value('username');
        }
        return $this->fetch('details',['lists'=>$user,'times'=>$ddd]);
    }

    public function Scoring()
    {
        if (Request::instance()->isAjax())
        {
            $info = input('');
            $dd = db::name('users')->field('region,department,station,id as tid')->where('id',session('userId'))->find();
            if($dd == null)
            {
                $dd['ss'] = 1;
            }

            $dd += $info;
            unset($dd['ss']);
            $dd['branch'] = $dd['a']+$dd['b']+$dd['c']+$dd['d']+$dd['e']+$dd['f']+$dd['g'];
            if(db::name('scoring')->insert($dd))
            {
                return json(['msg'=>'打分成功']);
            }

        }else{
            $dd = db::name('scoring')->where(['tid'=>session('userId'),'time'=>input('time'),'uid'=>input('id'),'cid'=>input('cid')])->find();
            if($dd)
            {
                $this->assign('list',$dd);
                $this->assign('dd',1);
            }else{
                $this->assign('dd',2);
            }
            return $this->fetch('dafen',['info'=>input('')]);

        }

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

    public function feedbacks(){
        $userId = session('userId');
        if($userId !== 1)
        {
            $numbers = db::name('scoring')->where(['tid'=>$userId,'time'=>input('times')])->count();
        $number = db::name('outline_lecturer')->where('times',input('times'))->group('id')->count();
        if($numbers<$number)
        {
            $this->error('未完成讲师打分，不能进行考核！');

        }
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

    public function onlineClassify()
    {
        $list = db::name('outlines')->where('classtype','in',[223])->select();
        $outlines = db::Name('users')->where('id',session('userId'))->value('outlines');
        $inArray = empty($outlines)?[]:explode(',',$outlines);
        foreach($list as $k=>$v)
        {
            $list[$k]['class_name'] = getOutline($v['classname']);
            $list[$k]['study'] = in_array($v['id'],$inArray)?1:-1;

        }
        return $this->fetch('',['list'=>$list]);
    }
    public function getShang()
    {
        $classid = Db::name('users')->where('id',$_SESSION['think']['userId'])->value('classid');
        $Info['curPageData'] = Db::name('classinfo')->where('id','in',$classid)->limit((input('num')-1)*input('size'),input('size'))->select();
        //var_dump($Info);
        foreach($Info['curPageData'] as $key=>$v)
        {
            $Info['curPageData'][$key]['pid'] = Db::name('classinfo')->where('id',$v['pid'])->value('title') ;
        }
        return array_column($Info['curPageData'],'id');
    }

    public function Detail()
    {
        $classInfo = Db::name('outline')->where('id',input('id'))->find();
        $classInfo['startdate'] = date('Y-m-d',strtotime($classInfo['startdate']));
        if(!empty($_GET['timely'])){
            $name = Db::name('classinfo')->where('id',$classInfo['classname'])->value('title');
        }else{
            $name = Db::name('classinfo')->where('id',$classInfo['classify'])->value('title');
        }
        $this->assign('info',$classInfo);
        $this->assign('name',$name);
        $tips=Db::name('tips')->where(['uid'=>Session::get('userId'),'class_id'=>input('id')])->find();
        $this->assign('tips',$tips);
        $classArr = explode(',',db::name('users')->where('id',session('userId'))->value('classname'));
        if(in_array($classInfo['classname'],$classArr))
        {
            $xue = 1;
        }else{
            $xue = -1;
        }
        $this->assign('xue',$xue);
        return $this->fetch();
    }

    public function addclassinfo()
    {
        $classInfo = Db::name('outline')->where('id',input('id'))->find();
        if(empty($_REQUEST['outline'])) {
            //如果为空，修改users--classid/outline_id
            $users = Db::name('users')->where('id', $_SESSION['think']['userId'])->find();
            $data['id']=$users['id'];
            if (!empty($users['outline_id'])) {
                $users['outline_id'] = $users['outline_id'] . ',' . $classInfo['id'];
                $data['outline_id'] = implode(',', array_unique(explode(',', $users['outline_id'])));
            }
            if (!empty($classInfo['classname'])) {
                if (!empty($users['classname'])) {
                    $users['classname'] = $users['classname'] . ',' . $classInfo['classname'];
                    $data['classname'] = implode(',', array_unique(explode(',', $users['classname'])));
                }else{
                    $data['classname'] =$classInfo['classname'];
                }
            }
            Db::name('users')->update($data);
            return json(['code'=>1]);
        }
    }
    public function addTips()
    {
        $info = json_decode(input('info'),true);
        $info['uid'] = $uid = Session::get('userId');
        $info['usersname']=Session::get('username');
        $info['startdate']=time();

        //var_dump($info);exit;
        $date = Db::name('tips')->where(['uid'=>$uid,'class_id'=>$info['class_id']])->find();
        if($date=='')
        {
            Db::name('tips')->insert($info);
        }else{
            Db::name('tips')->where(['uid'=>$uid,'class_id'=>$info['class_id']])->update($info);

        }
        return json(['msg'=>'成功发布心得']);
    }

    public function stars()
    {
        return $this->fetch('',['type'=>input('type')]);
    }

    public function outline()
    {
        $list = db::name('outlines')->where('classify','in',[243,244,245])->select();
        $outlines = db::Name('users')->where('id',session('userId'))->value('outlines');
        $inArray = empty($outlines)?[]:explode(',',$outlines);
        foreach($list as $k=>$v)
        {
            $list[$k]['class_name'] = getOutline($v['classname']);
            $list[$k]['study'] = in_array($v['id'],$inArray)?1:-1;

        }
        return $this->fetch('',['list'=>$list]);
    }

    public function outlineDetails()
    {
        db::name('outlines')->where('id',input('id'))->setInc('num',1);
        $info = db::name('users')->where('id',session('userId'))->value('outlines');
        if(!empty($info))
        {
            $info = explode(',',$info);
        }else{
            $info = [];
        }
        if(!in_array(input('id'),$info))
        {
            $info[] = input('id');
            db::name('users')->where('id',session('userId'))->update(['outlines'=>implode(',',$info)]);
        }
        $info = db::name('outlines')->where('id',input('id'))->find();
        $video = db::name('class_info')->where('id',$info['classname'])->value('url');
        $info['class_name'] = getOutline($info['classname']);
        return $this->fetch('',['info'=>$info,'video'=>$video]);
    }

    public function offline()
    {
        $list = db::name('outlines')->where('classify','in',[227,228,229])->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['class_name'] = getOutline($v['classname']);
            $is_study = db::name('outline_record')->where(['uid'=>session('userId'),'pid'=>$v['id']])->count();
            $list[$k]['is_study'] = ($is_study>0)?1:-1;
        }
        return $this->fetch('',['list'=>$list]);
    }

    public function outlineStars()
    {
        if(Request::instance()->isPost())
        {
            $input =  input('');
            $info = db::name('users')->field('id as uid,username,department,projectname as project,station,outlines')->where('id',session('userId'))->find();
            $info += $input;
            if(empty($info['outlines']))
            {
                $outlines = [];
            }else{
                $outlines = explode(',',$info['outlines']);
            }
            unset($info['outlines']);
            $outlines[] = $info['pid'];
            db::Name('users')->where('id',$info['uid'])->update(['outlines'=>implode(',',$outlines)]);
            $info['department_name'] = getName(1,$info['department']);
            $info['station_name'] = getName(2,$info['station']);
            $info['project_name'] = getName(3,$info['project']);
            db::Name('outline_record')->insert($info);
            return json(['code'=>1,'msg'=>'学习成功']);
        }
        $info = db::name('outlines')->where('id',input('id'))->find();
        $info['class_name'] = getOutline($info['classname']);
        return $this->fetch('',['info'=>$info,'id'=>input('id')]);
    }
    public function checkStudy()
    {
        if (Request::instance()->isPost())
        {
            $info = input('');
            $ids = $info['id'];unset($info['id']);
            $score = 0;
            foreach($info as $v)
            {
                $arr = explode(',',$v);
                $value = db::name('question')->where('id',$arr[0])->value('true_option');
                if($arr[1] == $value)
                {
                    $values = 5;
                }else{
                    $values = 0;
                }
                $score +=$values;
            }
            if($score <80)
            {
                return json(['code'=>3,'msg'=>'考试不及格']);
            }else{
                $classList = explode(',',db::name('users')->where('id',session('userId'))->value('outlines'));
                $classList[] = $ids;
                db::name('users')->where('id',session('userId'))->update(['outlines'=>implode(',',$classList)]);
                return json(['code'=>1,'msg'=>'考试及格']);
            }
        }
        $classInfo = db::name('outlines')->where('id',input('id'))->find();
        $questionList = db::name('question')->where('cid',$classInfo['classname'])->orderRaw("RAND()")->limit('20')->select();
        return $this->fetch('',['questionList'=>$questionList,'id'=>input('id')]);
    }



}