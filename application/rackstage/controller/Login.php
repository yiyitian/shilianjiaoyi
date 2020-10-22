<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Login extends Common
{
    /*
     * 记录日志
     * */
    public function _initialize(){
        parent::get_user_operation();
    }
    public function yinsi()
    {
              return $this->fetch('yinsi',['yinsi'=>db::name('xieyi')->where('id',1)->value('contents')]);
    }
    public function zhichi()
    {
        return $this->fetch();
    }
    /*
     * 登录
     * */
    public function login()
    {
        if (Request::instance()->isPost())
        {
            if($_POST['user_name'] == 'admin')
            {
                $_POST['user_name'] = '18663710910';
            }
            $info = Db::name('users')->where('phone',$_POST['user_name'])->find();
            if(empty($info)||(md5($info['random'].$_POST['pwd'])!==$info['pass']))
            {
                //users表中没有符合信息
                //检测user表注册信息
                $date =  Db::name('user')->where('id',$info['user_id'])->find();
                if(empty($date)||(md5("pwd_shilian".$_POST['pwd'])!==$date['pwd']))
                {
                    return json(array('code'=>2,"url"=>"login","msg"=>'登录失败，请查看密码或账号是否正确。。。'));
                }
            }else{
                if(empty($info['user_id'])){
                    return json(array('code'=>2,"url"=>"login","msg"=>'登录失败，您没有登录后台的权限。。。'));
                }
                $date=Db::name('user')->where('id',$info['user_id'])->find();
                if(empty($date)){
                    return json(array('code'=>2,"url"=>"login","msg"=>'登录失败，与您关联的后台用户不存在。。。'));
                }
            }
            if($date['status']!=='1')return json(array('code'=>2,"url"=>"login","msg"=>'登录失败，请确定账号是否启用。。。'));
            $data = Db::name('role')->where('id',$date['role'])->find();
            $date['remark']=mt_rand(11,99).$_POST['pwd'].mt_rand(11,99);
            Db::name('user')->update($date);
            $arr = explode(',',$data['role_cate']);
            if(count($arr)>1){
                Session::set('role_id',$arr[0]);
            }else{
                Session::set('role_id',$data['role_cate']);
            }
            Session::set('user_name',$date['user_name']);
            Session::set('role',$date['role']);
            Session::set('user_id',$date['id']);
            Session::set('role_title',$date['role_title']);
            Session::set('department',$date['department']);
            
            self::getLog($date['user_name'],$_SERVER['REMOTE_ADDR']);//登录日志和ip


            return json(array('code'=>1,'url'=>"/rackstage/Welcome/index",'msg'=>'登录成功，正在跳转。。。'));
        }else{
            return $this->fetch();
        }

    }
    /*
     * 登出
     * */
    public function login_out()
    {
        session::set('user_name',null);
        $this->redirect('/rackstage/Login/login');
    }
    /*
     * 修改密码
     * */
    public function edit_pwd()
    {
        if (Request::instance()->isPost())
        {
            if($_SESSION['think']['user_id']==4){
                dd((Db::name('user')->where('id',$_SESSION['think']['user_id'])->value('pwd')));
                dd("pwd_shilian".$_POST['old_pwd']);
                               }
           if(md5("pwd_shilian".$_POST['old_pwd'])==(Db::name('user')->where('id',$_SESSION['think']['user_id'])->value('pwd'))){
           
               if(false!==Db::name('user')->where('id',$_SESSION['think']['user_id'])->update(['pwd'=>md5('pwd_shilian'.$_POST['pwd']),'remark'=>$_POST['pwd'].rand(1000,9999)]))
               {
                   $data['code'] = 1;
                   $data['msg'] = '修改密码成功';
               }else{
                   $data['code'] = 0;
                   $data['msg']= '修改密码失败';
               }
           }else{
               $data['code'] = 0;
               $data['msg']= '原密码输入错误';
           }
            return json($data);
        }else{
            //var_dump($_SESSION['think']['user_id']);exit;
            $this->assign('list',Db::name('user')->where('id',$_SESSION['think']['user_id'])->find());
            return $this->fetch();
        }
    }

    private function getLog($user_name,$ips)
    {
        $dateArr['user_name']= $user_name;
        $dateArr['ips']=  $ips;
       $dateArr['create_time'] = date("Y-m-d H:i:s",time());
        Db::name('log')->insert($dateArr);

    }
    /*
     * 更换头像
     * */
    public function edit_head()
    {
        if (Request::instance()->isPost())
        {
                if(false!==Db::name('user')->where('id',$_POST['id'])->update(array('head_img'=>$_POST['src_img'])))
                {
                    $data['code'] = 1;
                    $data['msg'] = '更换成功';
                }else{
                    $data['code'] = 0;
                    $data['msg']= '更换失败';
                }

            return json($data);
        }else{
            $list = Db::name('user')->where('id',session::get('user_id'))->find();
            if($list['head_img']==null)$list['head_img']="http://t.cn/RCzsdCq";
            $this->assign('list',$list);

            return $this->fetch();
        }
    }

}
