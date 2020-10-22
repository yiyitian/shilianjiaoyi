<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/7/6
 * Time: 17:37
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
use think\Cookie;
class login extends Controller
{
    public function login()
    {
        if(Request::instance()->isAjax())
        {
            $userInfo = db::name('users')->where('phone',input('phone'))->find();
            if(empty($userInfo)) return json(['code'=>0,'msg'=>'无此用户']);
            if(md5($userInfo['random'].input('pwd'))!==$userInfo['pass'])return json(['code'=>2,'msg'=>'密码错误']);

           session('userId',$userInfo['id']);session('userName',$userInfo['username']);session('station',$userInfo['station']);
           if(input('xuan') == 1)
           {
               Cookie::set('phone',input('phone'),360000);
               Cookie::set('pwd',input('pwd'),360000);
           }
            return json(['code'=>1,'msg'=>'登陆成功']);
        }

        if(Cookie::has('phone'))
        {
            $this->assign(['phone'=>cookie('phone'),'pwd'=>cookie('pwd')]);
        }
        return $this->fetch();
    }
    public function zhichi()
    {
      return $this->fetch();
    }

    public function yinsi()
    {
      return $this->fetch('yinsi',['yinsi'=>db::name('xieyi')->where('id',1)->value('contents')]);
    }
}