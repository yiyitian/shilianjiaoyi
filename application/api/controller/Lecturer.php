<?php
namespace app\api\controller;
use app\api\model\Users;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Lecturer extends Common
{
   public function index()
   {
       if(!empty($_GET['time'])&&!empty($_GET['endtime']))
       {
           $date =date("Y-m-01",strtotime($_GET['endtime']));
           $start = strtotime(date("Y-m-01",strtotime($_GET['time'])));
           $end = strtotime(date("Y-m-d",strtotime("$date +1 month -1 day")));
           $sql = "select sum(classtime) as classTime,lecturer from shilian_outline_lecturer where status = 1 and times > " . $start . " and times < " . $end ." group by lecturer";
           $this->assign('times',$_GET['time']);
       }else{
           $sql = "select sum(classtime) as classTime,lecturer from shilian_outline_lecturer where status = 1 group by lecturer";
       }
       $list = db::query($sql);
       $last_ages = array_column($list,'classTime');
       array_multisort($last_ages ,SORT_DESC,$list);
       foreach($list as $k=>$v)
       {
           if($k<10)
           {
               $info = db::name('lecturer')->where('users_id',$v['lecturer'])->find();
               $v['type'] = $info['types'];
               $v['username'] = $info['username'];
               $v['images'] = Users::where('id',$v['lecturer'])->value('avatar');
               $data[] = $v;
           }
       }
       return $this->fetch('',['list'=>$data]);
   }

    public function classify()
    {
        $info = db::name('outline_lecturer')->where('lecturer',session('userId'))->select();
        return $this->fetch('',['list'=>$info]);
    }

    public function details()
    {
        $list = db::name('scoring')->where(['cid'=>input('cid'),'time'=>input('time')])->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['name'] = Users::where('id',$v['tid'])->value('username');
        }
        return $this->fetch('',['list'=>$list]);
    }

    public function detail()
    {
        return $this->fetch('',['list'=>db::name('scoring')->where('id',input('id'))->find()]);
    }
}