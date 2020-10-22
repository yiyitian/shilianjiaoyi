<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;

class Technology extends Common
{

    public function index()
    {
        $str = '<xml>

  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>';
        render($str);

    }

    public function lists()
    {
        if(isset($_GET['nickname']))
        {
            $val = '%'.input('nickname').'%';
            $where['nickname'] = array('like',$val);
        }
        $where['is_del'] = array('eq',2);
        $count=Db::table('wx_user')->where($where)->count();
        $page = $this->request->param('page');
        $limit = $this->request->param('limit');
        $tol=($page-1)*$limit;
        $list =Db::table('wx_user')->where($where)->order('id desc')->limit($tol,$limit)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['sex'] = $v['sex']==1?'男':'女';
        }

        return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
    }



    public function del()
    {
        if(Db::table('wx_user')->where('id='.input('id'))->Update(array('is_del'=>1)))
        {
            $info = array('msg'=>'删除成功','code'=>1);
        }else{
            $info = array('msg'=>'删除失败','code'=>2);
        }
        return json($info);
    }
    public function request_info()
    {
        if(isset($_GET['id']))
        {
            if(isset($_GET['nickname']))
            {
                $val = '%'.input('nickname').'%';
                $where['nickname'] = array('like',$val);
            }
            if(isset($_GET['is_work']))
            {
                $listArr  = Db::table('wx_user')->field('openid')->where('is_work',$_GET['is_work'])->select();
                if($listArr)
                {
                    foreach($listArr as $k=>$v)
                    {
                        $arr[]= $v['openid'];
                        $where['openid'] = array('in',$arr);
                    }
                }
            }
            $where['is_del'] =  array('eq',2);
            $count=Db::table('wx_select')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::table('wx_select')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['user_id'] = Db::table('wx_user')->where('openid',$v['openid'])->value('id');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }

    public function getImg()
    {
        $publish_id = $_GET['publish_id'];
        $user_id = $_GET['user_id'];
        $date = [
            "title"  => "资料图片",
            "id"  => $publish_id,
            "start"  => 0,
            "data" => Db::query("select id as alt,userid as pid,img_url as src,publish_id as thumb from img where  publish_id = ".$publish_id.' and userid = '.$user_id)
        ];
        return json($date);
    }

    public function request_edit()
    {
        $list = Db::table('wx_select')->where('id',input('id'))->find();
        if(""!==$list['remark'])
        {
            $this->assign('list',$list);
        }
        return $this->fetch();
    }
    public function request_add()
    {
        $id = input('id');
        $remark = input('remark');
        if(Db::table('wx_select')->where('id',$id)->update(array('remark'=>$remark)))
        {
            $info = array('msg'=>'操作成功','code'=>1);
        }else{
            $info = array('msg'=>'操作失败','code'=>2);
        }
        return json($info);
    }

    public function request_del()
    {
        $id = input('id');
        if(Db::table('wx_select')->where('id',$id)->update(array('is_del'=>1)))
        {
            $info = array('msg'=>'删除成功','code'=>1);
        }else{
            $info = array('msg'=>'删除失败','code'=>2);
        }
        return json($info);
    }

    public function is_work()
    {
        $_POST['is_work'] = -$_POST['is_work'];
        echo $_POST['is_work'];
        $data = Db::table('wx_user')->where('id',$_POST['id'])->update(array('is_work'=>$_POST['is_work']));
        dd($data);
        echo Db::table('wx_user')->getLastSql()
;die;        if(1)
        {
            $info = array('msg'=>'操作成功','code'=>1);
        }else{
            $info = array('msg'=>'操作失败','code'=>2);
        }
        return json($info);
    }

}
