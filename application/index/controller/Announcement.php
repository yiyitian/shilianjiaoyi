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
class Announcement extends Common
{
    public function index()
    {
        if(isset($_GET['num']))
        {
            $department = Db::name('users')->where('id',Session::get('userId'))->value('department');
            $station = Db::name('users')->where('id',Session::get('userId'))->value('station');
            $Info['curPageData'] = Db::name('article')
                ->where("find_in_set(".$department.",department)")
                ->where("find_in_set(".$station.",station)")
                ->limit((input('num')-1)*input('size'),input('size'))->order('id desc')->select();
            $ids = Db::name('article')
                ->where("find_in_set(".$department.",department)")
                ->where("find_in_set(".$station.",station)")
                ->where("!find_in_set(".Session::get('userId').",seen)")
                ->field('id')->select();
            foreach ($Info['curPageData'] as $key=> $val){
                foreach ($ids as $k=> $v){
                    if($val['id']==$v['id']){
                        $Info['curPageData'][$key]['is_seen']=1;
                    }
                }
            }
            return json($Info);
        }

        return $this->fetch();
    }

    /*
     * 详情页面
     * */
    public function Detail()
    {
        $classInfo = Db::name('article')->where('id',input('id'))->find();
                $re = Db::name('ready')->where(['gid'=>input('id'),'uid'=>session('userId'),'ready'=>1])->find();
                
                if($re)
                {
                    $this->assign('re',1);
                }else{
                                        $this->assign('re',2);

                }
                 $de = Db::name('ready')->where(['gid'=>input('id'),'uid'=>session('userId'),'do'=>1])->find();
                if($de)
                {
                    $this->assign('du',1);
                }else{
                                        $this->assign('du',2);

                }

        if(empty($classInfo['seen'])){
            $classInfo['seen']=Session::get('userId');
            Db::name('article')->update($classInfo);
        }else{
            $classInfo['seen']=$classInfo['seen'].','.Session::get('userId');
            $classInfo['seen']=implode(',',array_unique(explode(',',$classInfo['seen'])));
            Db::name('article')->update($classInfo);
        }
        $classInfo['content']=str_replace("&amp;nbsp;","&nbsp;",$classInfo['content']);
        $this->assign('info',$classInfo);

        $info = Db::name('users')->where('id',session('userId'))->value('station');
        
        $data = stristr($classInfo['stations'],$info);
        if($info)
        {
            $this->assign('ids',1);
        }else{
            $this->assign('ids',2);
        }
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

    public function addReady()
    {
        $list = Db::name('ready')->where(['gid'=>input('gid'),'uid'=>session('userId'),'ready'=>1])->find();
        if($list)
        {
            return json(['msg'=>'已经读过了','code'=>1]);
        }
        $info = Db::name('users')->field('username,region,department,station,projectname')->where('id',session('userId'))->find();
        $info['region'] = db::name('framework')->where('id',$info['region'])->value('name');
        $info['department'] = db::name('framework')->where('id',$info['department'])->value('name');
        $info['station'] = db::name('posts')->where('id',$info['station'])->value('posts');
        $info['project'] = db::name('project')->where('id',$info['projectname'])->value('name');
        $info['gid'] = input('gid');
        $info['uid'] = session('userId');
        $info['ready'] = 1;
        unset($info['projectname']);
        $infos = Db::name('ready')->insert($info);
        if($infos)
        {
            return json(['msg'=>'成功阅读','code'=>1]);
        }else{
            return json(['msg'=>'阅读失败','code'=>2]);
        }

    }

    public function addDu()
    {
        $list = Db::name('ready')->where(['gid'=>input('gid'),'uid'=>session('userId')])->find();
        if($list['do'] == 1)
        {
            return json(['msg'=>'已经完成了','code'=>1]);
        }else if($list['ready'] !== '1'){
            return json(['msg'=>'还没有阅读呢','code'=>1]);
        }
        $infos = Db::name('ready')->where('id',$list['id'])->update(['do'=>1]);
        if($infos)
        {
            return json(['msg'=>'公告完成','code'=>1]);
        }else{
            return json(['msg'=>'公告失败','code'=>2]);
        }

    }
}

