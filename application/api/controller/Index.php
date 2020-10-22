<?php
namespace app\api\controller;
use app\api\model\Users;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Index extends Common
{
    public function index()
    {
        $article = db::name('article')->where('status1',1)->select();
        $project = db::name('project_article')->where('status1',1)->select();
        $banner = db::name('banner')->order('id desc')->select();
        $userInfo = db::name('users')->where('id', session('userId'))->find();
       if($userInfo['region']  == '70')
        {
            $this->assign('fang',1);
        }
        foreach($project as $K=>$v)
        {
            $project[$K]['title'] = mb_substr( $v['title'], 0, 10, 'utf-8' );
        }
        return $this->fetch('',['article'=>$article,'project'=>$project,'banner'=>$banner]);
    }
    public function details()
    {
        $info = db::name('article')->where('id',input('id'))->find();
        return $this->fetch('',['article'=>$info]);
    }
    public function detail()
    {
        $info = db::name('project_article')->where('id',input('id'))->find();
        return $this->fetch('',['article'=>$info]);
    }
}