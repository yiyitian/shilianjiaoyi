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
class Cases extends Common
{
    public function index()
    {
        return $this->fetch('');
    }
    public function ft()
    {
        $userId = Users::get(session('userId'))->toArray();
        if(''!==$userId['user_id'])
        {
            $role = db::name('user')->where('id',$userId['user_id'])->find();
            if(($role['role'] == '32')||$role['role'] == '35'||($role['role'] == '47'))
            {
                $date = db::name('ft')->where('enquiryer',$role['id'])->order('id desc')->select();
                $this->assign('isAdd',1);
            }else{
                $date = db::name('ft')->where("find_in_set('".session('userName')."',manager) ")->order('id desc')->select();
            }
            if(empty($date))
            {
                $date = db::name('ft')->where('project_id',$userId['projectname'])->order('id desc')->select();
            }
            if(empty($date))
            {
                return $this->fetch('',['list'=>'']);
            }
        }else{
            $date = '';
        }
        if(session('userId') == '96374')
        {
            $date = db::name('ft')->select();
        }
        return $this->fetch('ft',['list'=>$date]);
    }

    public function ftDetail()
    {
        $list = db::name('ft')->where('id',input('id'))->find();
        $list['department'] = db::name('framework')->where('id',$list['department'])->value('name');
        $list['project'] = db::name('project')->where('id',$list['project_id'])->value('name');
        $list['enquiryer'] = db::name('users')->where('id',$list['enquiryer'])->value('username');

        return $this->fetch('',['info'=>$list]);
    }

public function ftAdd()
    {
        if (Request::instance()->isPost())
        {
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                $info=Db::name('ft')->update($_POST);
            }else{
                $role = db::name('users')->where('id',session('userId'))->value('user_id');
                $_POST['enquiryer']=$role;
                $info=Db::name('ft')->insert($_POST);
            }
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }else{
            if(!empty($_GET['id'])){
                $this->assign('id',$_GET['id']);
                $list=Db::name('answercall')->where('id',$_GET['id'])->find();
                $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);
                $imglist=Db::name('uploads')
                    ->where('mark','answercall')
                    ->where('times',$list['times'])
                    ->where('del','-1')
                    ->select();
                $this->assign('imglist',$imglist);
                $this->assign('times',$list['times']);
            }else{
                $this->assign('times',time());
            }
            $list =Db::name('project')->order('id desc')->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
                $region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
            }
            $this->assign('project',$list);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            return $this->fetch('add_ft');
        }
    }
    /*
     * 询盘成绩
     * */
    public function enquiry()
    {
        $userId = Users::get(session('userId'))->toArray();
        if(''!==$userId['user_id'])
        {
            $role = db::name('user')->where('id',$userId['user_id'])->find();
            if(($role['role'] == '32')||$role['role'] == '35'||($role['role'] == '47'))
            {
                $date = db::name('enquiry')->where('enquiryer',$role['id'])->order('id desc')->select();
                $this->assign('isAdd',1);
            }else{
                $date = db::name('enquiry')->where("find_in_set('".session('userName')."',manager) ")->order('id desc')->select();
            }
            if(empty($date))
            {
                $date = db::name('enquiry')->where('project_id',$userId['projectname'])->order('id desc')->select();
            }
            if(empty($date))
            {
                return $this->fetch('',['list'=>'']);
            }
        }else{
            $date = '';
        }
        if(session('userId') ==1)
        {
            $date = db::name('enquiry')->select();
        }
        return $this->fetch('',['list'=>$date]);
    }

    /*
     * 案场详情
     * */
    public function Details()
    {
        $list = db::name('enquiry')->where('id',input('id'))->find();
        $list['department'] = db::name('framework')->where('id',$list['department'])->value('name');
        $list['project'] = db::name('project')->where('id',$list['project_id'])->value('name');
        $list['enquiryer'] = db::name('users')->where('id',$list['enquiryer'])->value('username');
        $data = db::name('xunpan')->where('times',$list['times'])->select();
        foreach($data as $k=>$v)
        {
            switch ($v['type'])
            {
                case 'file':
                    $list['as'][] = $v['images'] ;
                    break;
                case 'file1':
                    $list['bs'][] = $v['images'] ;
                    break;
                case 'file2':
                    $list['cs'][] = $v['images'] ;
                    break;
                case 'file3':
                    $list['ds'][] = $v['images'] ;
                    break;
                case 'file4':
                    $list['fs'][] = $v['images'] ;
                    break;
                case 'file5':
                    $list['hs'][] = $v['images'] ;
                    break;
                case 'file6':
                    $list['is'][] = $v['images'] ;
                    break;
                case 'file7':
                    $list['js'][] = $v['images'] ;
                    break;
                case 'file8':
                    $list['ks'][] = $v['images'] ;
                    break;
                case 'file9':
                    $list['ls'][] = $v['images'] ;
                    break;
                case 'file10':
                    $list['ms'][] = $v['images'] ;
                    break;
                case 'file11':
                    $list['ns'][] = $v['images'] ;
                    break;
                case 'file16':
                    $list['es'][] = $v['images'] ;
                    break;
                default:
                    $list['ps'][] = $v['images'] ;            }
        }
        return $this->fetch('',['info'=>$list]);
    }
    /*
     * 电话接听
     * */
    public function answerCall()
    {
        $userId = Users::get(session('userId'))->toArray();
        if(''!==$userId['user_id'])
        {
            $role = db::name('user')->where('id',$userId['user_id'])->find();
            if(($role['role'] == '32')||$role['role'] == '35'||($role['role'] == '47'))
            {
                $date = db::name('answercall')->where('enquiryer',$role['id'])->order('id desc')->select();
                $this->assign('isAdd',1);
            }else{
                $date = db::name('answercall')->where("find_in_set('".session('userName')."',manager) ")->order('id desc')->select();
            }
            if(empty($date))
            {
                $date = db::name('answercall')->where('project_id',$userId['projectname'])->order('id desc')->select();
            }
            if(empty($date))
            {
                return $this->fetch('',['list'=>'']);
            }
        }else{
            $date = '';
        }

        if(session('userId') == 1)
        {
            $date = db::name('answercall')->select();
        }

        return $this->fetch('answer_call',['list'=>$date]);
    }
    /*
     * 电话接听详情
     * */
    public function callDetail()
    {
        $list = db::name('answercall')->where('id',input('id'))->find();
        $list['department'] = db::name('framework')->where('id',$list['department'])->value('name');
        $list['project'] = db::name('project')->where('id',$list['project_id'])->value('name');
        $list['enquiryer'] = db::name('users')->where('id',$list['enquiryer'])->value('username');
        $imglist=Db::name('uploads')
            ->where('mark','answercall')
            ->where('times',$list['times'])
            ->where('del','-1')
            ->find();
        return $this->fetch('',['info'=>$list,'mp3'=>$imglist]);
    }

    /*
     * 客户回访
     * */
    public function review()
    {
        $userId = Users::get(session('userId'))->toArray();
        if(''!==$userId['user_id'])
        {
            $role = db::name('user')->where('id',$userId['user_id'])->find();
            if(($role['role'] == '32')||$role['role'] == '35'||($role['role'] == '47'))
            {
                $date = db::name('review')->where('enquiryer',$role['id'])->order('id desc')->select();
                $this->assign('isAdd',1);
            }else{
                $date = db::name('review')->where("find_in_set('".session('userName')."',salesman) ")->order('id desc')->select();
            }
            if(empty($date))
            {
                $date = db::name('review')->where('project_id',$userId['projectname'])->order('id desc')->select();
            }
            if(empty($date))
            {
                return $this->fetch('',['list'=>'']);
            }
        }else{
            $date = '';
        }

        if(session('userId') ==1)
        {
            $date = db::name('review')->select();
        }
        return $this->fetch('',['list'=>$date]);
    }
    /*
     * 回访详情
     * */
    public function reviewDetail()
    {
        $list = db::name('review')->where('id',input('id'))->find();
        $list['department'] = db::name('framework')->where('id',$list['department'])->value('name');
        $list['project'] = db::name('project')->where('id',$list['project_id'])->value('name');
        $list['enquiryer'] = db::name('users')->where('id',$list['enquiryer'])->value('username');
        return $this->fetch('',['list'=>$list]);
    }


    public function addEnquiry()
    {
        if (Request::instance()->isPost())
        {
            $arr=explode('--',$_POST['project_id']);
            $where['project_id']=$arr[0];

                $role = db::name('users')->where('id',session('userId'))->value('user_id');
                $_POST['enquiryer']=$role;
                $info=Db::name('enquiry')->insert($_POST);

            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }else{
            if(!empty($_GET['id'])){
                $this->assign('id',$_GET['id']);
                $list=Db::name('enquiry')->where('id',$_GET['id'])->find();
                $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);
                $imglist=Db::name('uploads')
                    ->where('mark','enquiry')
                    ->where('times',$list['times'])
                    ->where('del','-1')
                    ->select();
                $this->assign('imglist',$imglist);
                $this->assign('times',$list['times']);
            }else{
                $this->assign('times',time());
            }
            $list =Db::name('project')->order('id desc')->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
                $region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
            }
            $this->assign('project',$list);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            $this->assign('nowtime',time());
            return $this->fetch('',['time'=>time()]);
        }
    }

    public function addReview()
    {
        if (Request::instance()->isPost())
        {
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                $info=Db::name('review')->update($_POST);
            }else{

                $role = db::name('users')->where('id',session('userId'))->value('user_id');
                $_POST['enquiryer']=$role;
                $info=Db::name('review')->insert($_POST);
            }
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }else{
            if(!empty($_GET['id'])){
                $this->assign('id',$_GET['id']);
                $list=Db::name('review')->where('id',$_GET['id'])->find();
                $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);

                $this->assign('times',$list['times']);
            }else{
                $this->assign('times',time());
            }
            $list =Db::name('project')->order('id desc')->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
                $region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
            }
            $this->assign('project',$list);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            $this->assign('nowtime',time());
            return $this->fetch();
        }
    }

    public function getCate()
    {
        $data['framework']=Db::name('framework')->where('pid',input('pid'))->select();
        $post_pid=Db::name('framework')->where('id',input('pid'))->value('type');

        $data['post']=Db::name('posts')->where('pid',$post_pid)->select();
        return json($data);
    }
    public function getProject()
    {
        $data=Db::name('project')->where('framework_id',input('pid'))->where('status',1)->where('del',-1)->select();
        return json($data);
    }
    public function addCall()
    {
        if (Request::instance()->isPost())
        {
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                $info=Db::name('answercall')->update($_POST);
            }else{
                $role = db::name('users')->where('id',session('userId'))->value('user_id');
                $_POST['enquiryer']=$role;
                $info=Db::name('answercall')->insert($_POST);
            }
            if($info)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }else{
            if(!empty($_GET['id'])){
                $this->assign('id',$_GET['id']);
                $list=Db::name('answercall')->where('id',$_GET['id'])->find();
                $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);
                $imglist=Db::name('uploads')
                    ->where('mark','answercall')
                    ->where('times',$list['times'])
                    ->where('del','-1')
                    ->select();
                $this->assign('imglist',$imglist);
                $this->assign('times',$list['times']);
            }else{
                $this->assign('times',time());
            }
            $list =Db::name('project')->order('id desc')->select();
            foreach($list as $k=>$v)
            {
                $department=Db::name('framework')->where('id',$v['framework_id'])->find();
                $region=Db::name('framework')->where('id',$department['pid'])->value('name');
                $list[$k]['department'] = $region.'--'.$department['name'];
            }
            $this->assign('project',$list);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            $this->assign('nowtime',time());
            return $this->fetch();
        }
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
            $ret["msg"]= "上传成1功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            if(!empty($_REQUEST['id'])){
                $info=Db::name('user')->where('id',$_REQUEST['id'])->update(['head_img'=>$url]);
                if($info){
                    return json($ret);
                }else{
                    $ret["msg"]= "头像修改失败";
                    return json($ret);
                }
            }
            if($this->request->param('times'))
            {
                $reserve = isset($_GET['reserve'])?$_GET['reserve']:1;
                $info = Db::name('uploads')->insert(array('url'=>$url,
                    'times'=>$this->request->param('times'),
                    'mark'=>$this->request->param('mark'),
                    'reserve' =>$reserve,
                    'filename' =>$_FILES["file"]["name"],
                    'updatetime' =>$_REQUEST['updatetime']));
                if($info){
                    return json($ret);
                }else{
                    $ret["msg"]= "保存记录失败";
                    return json($ret);
                }
            }else{
                $ret["msg"]= "记录值不能为空，请联系技术支持";
                return json($ret);
            }

        }
    }
    /*
     * 文件上传实际操作
     * */
    private  function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录�?
        $info = $file->move(ROOT_PATH . 'public/uploads');
        $reubfo = array();
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();;
        }
        return $reubfo;
    }


    public function upload1()
    {
        $header = getallheaders();
        $list['times']  = $header['Token'];
        $list['type']  = $header['Type'];
        $file = request()->file('files');
        if($file){
            $info = $file->validate(['size'=>1567800000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $list['images'] = '/uploads/'.$info->getSaveName();
                db::name('xunpan')->insert($list);
                return json(['msg'=>1]);
            }else{
                $this->error($file->getError());
            }
        }
    }
}