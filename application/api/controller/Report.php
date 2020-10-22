<?php
namespace app\api\controller;
use app\api\model\Users;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class Report extends Common
{
    /*
     * 周报列表
     * */
    public function Weekly()
    {
        $userInfo = Users::get(session('userId'))->toArray();
        if($userInfo['user_id'])
        {
            $role = db::name('user')->where('id',$userInfo['user_id'])->find();
            if($role['role'] == '36')
            {
                $list=Db::name('settime')->where('id',1)->find();
                if(time()>$list['starttime'] && time()<$list['endtime']){
                    $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
                }
            }
        }

        $projectName = db::name('project')->where('id',input('pid'))->value('name');
        $list =Db::name('weekinfo')->where('pro_id',input('pid'))->order('id desc')->field('times')->select();
        foreach($list as $key=>$val)
        {
            $list_new[]=$val['times'];
        }
        if(!isset($list_new))
        {
            return $this->fetch('',['list'=>'','pid'=>input('pid')]);
        }
        arsort($list_new);
        $list_new=array_values(array_unique($list_new));
        foreach($list_new as $key => $val){
            $data[$key]['times']=date('Y-m-d',$val-6*24*3600).'~'.date('Y-m-d',$val);
            $data[$key]['title'] = $projectName;
            $data[$key]['time']=$val;
        }
        return $this->fetch('',['list'=>$data,'pid'=>input('pid')]);
    }
    /*
     * 月报列表
     * */
    public function monthly()
    {
        $userInfo = Users::get(session('userId'))->toArray();
        if($userInfo['user_id'])
        {
            $role = db::name('user')->where('id',$userInfo['user_id'])->find();
            if($role['role'] == '36')
            {
                $list=Db::name('settime')->where('id',1)->find();
                if(time()>$list['starttime'] && time()<$list['endtime']){
                    $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
                }
            }
        }
        $pro_id = $_GET['pid'];
        $data =Db::name('monthinfo')->where('pro_id',$pro_id)->order('title desc')->select();
        return $this->fetch('',['list'=>$data,'pid'=>input('pid')]);
    }

    /*
     * 周报月报列表
     * */
    public function lists()
    {
        $userInfo = Users::get(session('userId'))->toArray();
        if($userInfo['user_id'])
        {
            $role = db::name('user')->where('id',$userInfo['user_id'])->find();
            if($role['role'] == '36')
            {
                $wheres['manager'] = array('eq',$role['id']);
            }
        }
        if(!isset($wheres))
        {
            if(!in_array($userInfo,['7,3660']))
            {
                $wheres['id'] = array('eq',$userInfo['projectname']);
            }
        }
        if(!isset($wheres))
        {
            return $this->fetch('',['lists'=>""]);
        }
        $wheres['status']=1;
        $list =Db::name('project')->where($wheres)->order('id asc')->select();
        foreach($list as $k=>$v)
        {
            $department=Db::name('framework')->where('id',$v['framework_id'])->find();
            $region=Db::name('framework')->where('id',$department['pid'])->value('name');
            $list[$k]['department'] = $region.'--'.$department['name'];
        }
        return $this->fetch('',['lists'=>$list]);
    }

    /*
     * 周报列表
     * */
    public function weeklyList()
    {
        $where['pro_id']=input('pid');
        $where['times']=input('time');
        $data=Db::name('weekinfo')->where($where)->order('orderby desc')->limit(4)->select();
        $list=Db::name('settime')->where('id',1)->find();
//        if(time()<$list['starttime'] || time()>$list['endtime']){
//            $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
//        }
        return $this->fetch('',['list'=>$data]);
    }

    /*
     *周报详情
     * */
    public function detail()
    {
        if(Request::instance()->isAjax())
        {
            $return =  db::name('weekinfo')->update(input(''));
            return json(['code'=>0,'msg'=>'更新成功']);
        }
        $list=Db::name('settime')->where('id',1)->find();
        if(time()<$list['starttime'] || time()>$list['endtime']){
            $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
        }
        $info = db::name('weekinfo')->where('id',input('pid'))->find();
        return $this->fetch('',['info'=>$info]);
    }
    /*
     *月报详情
     * */
    public function MonthDetail()
    {
        if(Request::instance()->isAjax())
        {
            $return =  db::name('monthinfo')->update(input(''));
            return json(['code'=>0,'msg'=>'更新成功']);
        }
        $userInfo = Users::get(session('userId'))->toArray();
        if($userInfo['user_id'])
        {
            $role = db::name('user')->where('id',$userInfo['user_id'])->find();
            if($role['role'] == '36')
            {
                $list=Db::name('settime')->where('id',1)->find();
                if(time()>$list['starttime'] && time()<$list['endtime']){
                    $this->assign('settime',date('y-m-d H:i:s',$list['starttime']).'~'.date('y-m-d H:i:s',$list['endtime']));
                }
            }
        }
        $where['id']=$_REQUEST['id'];
        $data=Db::name('monthinfo')->where($where)->order('orderby desc')->select();
        return $this->fetch('',['info'=>$data[0]]);
    }

    /*
     * 创建月报
     * */
    public function CreateMonthInfo()
    {
        $where['pro_id']=$pro_id=$_REQUEST['pro_id'];
        $where['times']=date('Y-m',time());
        if(!empty($_REQUEST['check'])){
            $count=Db::name('monthinfo')->where($where)->count();
            if($count>0){
                return json(["code"=>"0","msg"=>"数据已存在，数据初始化中","times"=>Db::name('monthinfo')->where($where)->value('times')]);
            }else{
                $createtime=time();
                $data=array(
                    'title' => $where['times'],
                    'pro_id' => $pro_id,
                    'company' => '世联',
                    'lastmonthcall' => '',
                    'lastmonthcome' => '',
                    'lastmonthmainhouse' => '',
                    'lastmonthparking' => '',
                    'lastmonthbasement' => '',
                    'lastmonthsale' => '',
                    'thismonthsale' => '',
                    'is_add' => '',
                    'addnum' => '',
                    'addaim' => '',
                    'obj_type' => '',
                    'bestaim' => '',

                    'createtime' => $createtime
                );
                $info=Db::name('monthinfo')->insert($data);
                if($info){
                    return json(["code"=>"1","msg"=>"表格初始化中"]);
                }else{
                    return json(["code"=>"0","msg"=>"月报插入数据表失败，请重试"]);
                }

            }
        }
    }

    /*
     * 创建周报
     * */
    public function CreateWeekInfo()
    {
        if($_REQUEST['time_code']=='this_week'){
            $times=strtotime(date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600)));
        }else if($_REQUEST['time_code']=='last_week'){
            $times=strtotime(date('Y-m-d 23:59:59', strtotime('-1 sunday', time())));
        }
        $where['pro_id']=$pro_id=$_REQUEST['pro_id'];
        $where['times']=$times;
        if(!empty($_REQUEST['check'])){
            $count=Db::name('weekinfo')->where($where)->count();
            if($count>0){
                return json(["code"=>"0","msg"=>"数据已存在"]);
            }else{
                $createtime=time();
                $data=array(
                    ['company' => '周目标',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '6',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'aim'],
                    ['company' => '世联',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '5',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'shilian'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '4',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '3',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '2',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '',
                        'comecall' => '',
                        'comevisit' => '',
                        'weektao' => '',
                        'mainhouse' => '',
                        'weekjine' => '',
                        'monthtao' => '',
                        'monthjine' => '',
                        'yearaim' => '',
                        'yearjine' => '',
                        'yearincome' => '',
                        'weshare' => '',
                        'orderby' => '1',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'liandai'],
                    ['company' => '项目人数',
                        'comecall' => '项目经理',
                        'comevisit' => '',
                        'weektao' => '销售主管',
                        'mainhouse' => '',
                        'weekjine' => '销售代表',
                        'monthtao' => '',
                        'monthjine' => '后台文员',
                        'yearaim' => '',
                        'yearjine' => '主策',
                        'yearincome' => '',
                        'weshare' => '助理策划',
                        'orderby' => '0',
                        'times' => $times,
                        'pro_id' => $pro_id,
                        'createtime' => $createtime,
                        'title'=>date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times),
                        'type'=>'shilian']
                );
                $info=Db::name('weekinfo')->insertAll($data);
                if($info){
                    return json(["code"=>"1","msg"=>"创建成功"]);
                }else{
                    return json(["code"=>"0","msg"=>"周报插入数据表失败，请重试"]);
                }
            }
        }
    }

    public function addWeek()
    {
        dd(db::name('weekinfo')->where('id',input('id'))->update([input('field')=>input('s')]));
    }

    public function workBook()
    {
        $list = db::name('work_books')->where('uid',session('userId'))->select();
        $setting=Db::name('settime')->where('id',1)->find();
        if(time()>$setting['starttime'] && time()<$setting['endtime']){
            $this->assign('setTime',date('y-m-d H:i:s',$setting['starttime']).'~'.date('y-m-d H:i:s',$setting['endtime']));
        }
        return $this->fetch('',['list'=>$list]);
    }
    public function CreateWorkBook()
    {
        if (Request::instance()->isPost())
        {
            $times=strtotime(date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600)));
            $info = input('');
            $info['title'] = date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times);
            $userInfo = db::name('users')->field('id as uid, username as uname,department,station,projectname as project')->where('id',session('userId'))->find();
            $info =array_merge($info,$userInfo);
            if(db::name('work_books')->where(['uid'=>$info['uid'],'title'=>$info['title']])->count()>0)
            {
                return json(['code'=>2,'msg'=>'您已经添加过了']);
            }
            $info['department_name'] = getName(1,$info['department']);
            $info['station_name'] = getName(2,$info['station']);
            $info['project_name'] = getName(3,$info['project']);
            if(db::name('work_books')->insert($info))
            {
                return json(['code'=>1,'msg'=>'操作成功']);
            }
        }
        $id = input('id');
        if(!empty($id))
        {
            $this->assign('list',db::name('work_books')->where('id',$id)->find());
        }
        $setting=Db::name('settime')->where('id',1)->find();
        if(time()>$setting['starttime'] && time()<$setting['endtime']){
            $this->assign('setTime',date('y-m-d H:i:s',$setting['starttime']).'~'.date('y-m-d H:i:s',$setting['endtime']));
        }
        return $this->fetch();
    }
    public function CreateWorkBooks()
    {

            $times=strtotime(date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600)));
            $info = input('');
            $info['title'] = date('Y-m-d',$times-6*24*3600).'~'.date('Y-m-d',$times);
            $userInfo = db::name('users')->field('id as uid, username as uname,department,station,projectname as project')->where('id',session('userId'))->find();
            $info =array_merge($info,$userInfo);
            $info['department_name'] = getName(1,$info['department']);
            $info['station_name'] = getName(2,$info['station']);
            $info['project_name'] = getName(3,$info['project']);
            if(db::name('work_books')->update($info))
            {
                return json(['code'=>1,'msg'=>'操作成功']);
            }

    }

}