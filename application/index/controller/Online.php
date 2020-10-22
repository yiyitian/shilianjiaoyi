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
use think\Exception;
class Online extends Common
{
    public function index()
    {
        if(isset($_GET['num']))
        {
            $outline_id = Db::name('users')->where('id',Session::get('userId'))->value('outline_id');
            $Info['curPageData'] = Db::name('outline')->where('id','in',$outline_id)->limit((input('num')-1)*input('size'),input('size'))->order('id desc')->select();
            
            foreach($Info['curPageData'] as $key => $val)
            {
                $Info['curPageData'][$key]['title'] = Db::name('classinfo')->where('id',$val['classify'])->value('title');
                $Info['curPageData'][$key]['startdate'] = date('y-m-d',strtotime($val['startdate']));
                $Info['curPageData'][$key]['enddate'] = date('y-m-d',strtotime($val['enddate']));
                $Info['curPageData'][$key]['usersname'] =$val['username'];
            }
            return json($Info);
        }

        //查询当前登录员工的岗位，根据岗位查询outline表中是否有对应岗位的“岗位课”
        $department = Db::name('users')->where('id',Session::get('userId'))->value('department');
        $station = Db::name('users')->where('id',Session::get('userId'))->value('station');
        $outlines=Db::name('outline')
            ->where("find_in_set(".$department.",department)")
            ->where("find_in_set(".$station.",station)")
            ->where('show','1')
            ->select();
            $num = array("160", "161", "162", "163");

            foreach($outlines as $k=>$v)
            {
                if(in_array($v['classname'],$num)){
                   unset($v);
                }else{
                   $outline[] = $v; 
                }
                
            }
           $inArray = $this->getShang();
        foreach ($outline as $key=> $val)
        {
            $outline[$key]['classname_name']= Db::name('classinfo')->where('id',$val['classname'])->value('title');
            if(in_array($val['classname'],$inArray))
            {
                unset($outline[$key]);
            }

        }

        $this->assign('timely',$outline);
        return $this->fetch();
    }
    public function getClassList()
    {
        $classInfo['curPageData'] = Db::name('classinfo')->limit(input('num')*input('size'),input('size'))->select();
        return json($classInfo);
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

    public function addclassinfo()
    {
         $classInfo = Db::name('outline')->where('id',input('id'))->find();
        if(empty($_REQUEST['outline'])) {
            //如果为空，修改users--classid/outline_id
            $users = Db::name('users')->where('id', $_SESSION['think']['userId'])->find();

            $data['id']=$users['id'];

           
            if (!empty($users['classid'])) {
                $users['classid'] = $users['classid'] . ',' . $classInfo['classname'];

                $data['classid'] = implode(',', array_unique(explode(',', $users['classid'])));
            }
             if($users['classid'] == 0)
            {
                $data['classid'] = $classInfo['classname'];
            };
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
    /*
     * 详情页面
     * */
    public function Detail()
    {
        $classInfo = Db::name('outline')->where('id',input('id'))->find();
        if(!empty($_GET['timely'])){
            $name = Db::name('classinfo')->where('id',$classInfo['classname'])->value('title');
        }else{
            $name = Db::name('classinfo')->where('id',$classInfo['classify'])->value('title');
        }

        $this->assign('info',$classInfo);
        $this->assign('name',$name);
        $tips=Db::name('tips')->where(['uid'=>Session::get('userId'),'class_id'=>input('id')])->find();
        $this->assign('tips',$tips);
        return $this->fetch();
}

    /*
     * 添加心得
     * */
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
            $user = db::name('outline_lecturer')->where('times',$ddd)->select();
            if($user == null)
            {
                $this->redirect('/index/user/feedbacks?times='.$ddd);
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
            $dd +=$info;
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
}

