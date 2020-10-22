<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/7/6
 * Time: 17:38
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Common extends Controller{

    public function __construct(){
        {
            parent::__construct();
        }
        if(request()->controller()!=="Login")self::check_login();
    }
    /*
     * ¼ì²éµÇÂ¼
     * */
    private function check_login()
    {
        $user = session('userName');
        if(""==$user)
        {
            session('users',$user);
            session('REQUEST_URI',$_SERVER['REQUEST_URI']);
            $this->redirect('/api/Login/login');
        }
    }
}