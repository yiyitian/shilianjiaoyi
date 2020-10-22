<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/16
 * Time: 15:41
 */
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Ding extends Controller{
    function getUserInfo($v,$station,$where='1=1')
    {
        $projectUserList = Db::name('users')
            ->where(['projectname'=>$v['id'],'is_quit'=>'-1','del'=>'-1'])
            ->where('station','in','13,14,15,16,17,18,19,20,21,44')
            ->where($where)
            ->field('id as uid,work_id,username,phone,station')
            ->select();
        if(!empty($projectUserList))
        {
            foreach($projectUserList as $key => $val)
            {
                $projectUserList[$key]['project'] = $v['id'];
                $projectUserList[$key]['pid'] = $v['id'];
                $projectUserList[$key]['project_name'] = $v['name'];
                $projectUserList[$key]['station_name'] = $station[$val['station']];
                $projectUserList[$key]['status'] = '正常';
                $projectUserList[$key]['addtime'] = date('Y-m-d');
                $projectUserList[$key]['isHave'] = '在';
                $projectUserList[$key]['update_time'] = date('Y-m-d');
            }
            return $projectUserList;
        }else{
            return false;
        }
    }


     /*
     * 同步
     * */
    public function checkAchievements()
    {
        // $date = date('d');
        // if($date<6)
        // {
        //    echo '考核时间不同步数据'; die;
        // }
        $post = db::name('posts')->where('pid',2)->field('id,posts')->select();
        foreach($post as $k=>$v)
        {
            $station[$v['id']] = $v['posts'];
        }
        $checkProject = db::name('project')->where('is_assessment','1')->select();
        foreach($checkProject as $k=>$v)
        {
                $achievements = db::name('maintain')->where('project',$v['id'])->field('uid')->select();
                if(empty($achievements))
                {
                    $projectUserList = $this->getUserInfo($v,$station);
                    if($projectUserList)
                    {
                        db::name('maintain')->insertAll($projectUserList);
                    }
                }else{
                    $projectUserList = Db::name('users')
                        ->where(['projectname'=>$v['id'],'is_quit'=>'-1','del'=>'-1'])
                        ->where('station','in','13,14,15,16,17,18,19,20,21,44')
                        ->field('id as uid ')
                        ->select();
                    $diff_data = array_filter($projectUserList, function($v) use ($achievements) { return ! in_array($v, $achievements);});
                    if(!empty($diff_data))
                    {
                        foreach($diff_data as $keys => $vals)
                        {
                            $raise[] = $vals['uid'];
                        }
                        Db::name('maintain')->where(['project'=>$v['id']])->where('uid','in',$raise)->delete();
                        $where['id'] = array('in',$raise);
                        Db::name('maintain')->insertAll($this->getUserInfo($v,$station,$where));
                    }
                    $diff_datas = array_filter($achievements, function($v) use ($projectUserList) { return ! in_array($v, $projectUserList);});
                    if(!empty($diff_datas))
                    {
                        foreach($diff_datas as $keys => $vals)
                        {
                            $isHave = Db::Name('maintain')->where(['project'=>$v['id'],'uid'=>$vals['uid'],'status'=>'正常','isHave'=>'在'])->find();
                            if(!empty($isHave))
                            {
                                Db::Name('maintain')->where('project',$v['id'])->where('uid',$vals['uid'])->update(['update_time'=>date('Y-m-d',time()),'status'=>'禁用','isHave'=>'不在','stoptime'=>date('Y-m-d',time()),'is_add'=>1]);
                            }
                        }
                    }
                }
        }

        echo "success";
    }
  
    /*
     * 获取钉钉token
     * */
    public function getToken()
    {
        $info = db::name('token')->find();
        $time = $info['time'] + 7200;
        if($time < time())
        {
            $token = $this->getCurl('https://oapi.dingtalk.com/gettoken?appkey=dingpdmsbz0sb927de4d&appsecret=5BxrIMjNMgIVTFUn0Zk7ofdBHhJB42GFcDdUd1x0kzJP9LhB_Yef3RrR0W7T2M9_');
            db::name('token')->where('id',$info['id'])->update(['access_token'=>$token['access_token'],'time'=>time()]);
        }else{
            $token = $info;
        }
        return $token['access_token'];
    }

    public function test()
    {
        $trainArr = db::Name('train')->field('id,classify_id,uid')->select();
        dd($trainArr);
    }


    /*事业部更新第一步，更新项目到数据库*/
public function getProject()
    {
        $accessToken = $this->getToken();
        $list = array(137662923,137662922,137662924,137662920,137662921,99680037);
        foreach($list as $k)
        {
                $list = $this->getCurl('https://oapi.dingtalk.com/department/list?access_token='.$accessToken.'&id='.$k);

                foreach($list['department'] as $K=>$v)
                {
                    if(strrpos($v['name'],'（'))
                    {
                        $project  = substr($v['name'],0,strrpos($v['name'],'（'));
                    }else{
                        if(strrpos($v['name'],'('))
                        {
                            $project  = substr($v['name'],0,strrpos($v['name'],'('));
                        }else{
                            $project = $v['name'];
                        }
                    }
                    $project_id = db::name('project')->where('name',$project)->find();
                    if(!empty($project_id))
                    {
                        $dates['project'] = $project;
                        $dates['project_id'] = $project_id['id'];
                        $dates['department'] = $project_id['framework_id'];
                        $dates['region'] = db::name('framework')->where('id',$project_id['framework_id'])->value('pid');
                        $dates['ding_id'] = $v['id'];
                        $data[] = $dates;
                    }
                }
                db::name('ceshi')->insertAll($data);
                unset($data);
        }

        $this->getProjectUser(db::name('ceshi')->select());

    }



    /*事业部更新第二步，更新用户项目、岗位，新增用户账号是手机号、密码是123456*/

    public function getProjectUser($project)
    {
        $postArr = db::name('posts')->where('pid','2')->select();
        foreach($postArr as $k=>$v)
        {
            $station[$v['posts']] = $v['id'];
        }
        $accessToken = $this->getToken();
        foreach($project as $k=>$v)
        {
            $url = "https://oapi.dingtalk.com/user/listbypage?access_token=".$accessToken."&department_id=".$v['ding_id']."&offset=0&size=100";
            $list = $this->getCurl($url);
            if($list['hasMore'] == true)
            {
                $lists = $this->getCurl("https://oapi.dingtalk.com/user/listbypage?access_token=".$accessToken."&department_id=".$id."&offset=100&size=100");
                $listArr = array_merge($list['userlist'],$lists['userlist']);
            }else {
                $listArr = $list['userlist'];
            }

            if(!empty($listArr))
            {
                foreach($listArr as $key=>$val)
                {
                    if(isset($val['position']))
                    {
                        switch ($val['position'])
                        {
                            case '主策':
                              $val['position'] = '策划经理' ;
                              break;
                            case '后台主管':
                              $val['position'] = '主管';
                              break;
                            case '置业顾问':
                              $val['position'] = '销售代表' ;
                              break;
                            case '项目助理':
                              $val['position'] = '项目文员' ;
                              break;
                            case '销售经理':
                              $val['position'] = '项目经理' ;
                              break;
                        }
                    }else{
                        $val['position'] = '销售代表';
                    }
                    $getRandom = getRandom();
                    $work_id = isset($val['jobnumber'])?$val['jobnumber']:'SD888888';
                    if(empty($work_id))
                    {
                        $work_id = 'SD888888';
                    }
                    $info = [
                                'work_id'=>$work_id,
                                'phone'=>$val['mobile'],
                                'updates'=>date('Y-m-d',time()),
                                'username'=>$val['name'],
                                'projectname'=>$v['project_id'],
                                'department'=>$v['department'],
                                'region'=>$v['region'],
                                'station' => isset($station[$val['position']])?$station[$val['position']]:19,
                                'random'=> $getRandom,
                                'pass' => md5($getRandom.'123456'),
                                'start_time'=>isset($val['hiredDate'])?date('Y-m-d',($val['hiredDate']/1000)):time('Y-m-d',time()),
                                'is_quit' => -1,
                                'del' => -1
                            ];
                    $datas[] = $info;
                }
                $date = '';
                 foreach($datas as $k=>$v)
                {
                    $date .= ',('.'"'.$v['work_id'].'","'.$v['phone'].'","'.$v['updates'].'","'.$v['department'].'","'.$v['region'].'","'.$v['username'].'","'.$v['projectname'].'","'.$v['station'].'","'.$v['random'].'","'.$v['pass'].'","'.$v['start_time'].'","'.$v['is_quit'].'","'.$v['del'].'")';
                };
                $str = substr($date, 1);
                $res = Db::query("INSERT INTO shilian_users (work_id,phone,updates,department,region,username,projectname,station,random,pass,start_time,is_quit,del) VALUES ".$str." ON DUPLICATE KEY UPDATE updates = VALUES(updates),is_quit = VALUES(is_quit),del = VALUES(del),station = VALUES(station),department = VALUES(department),username = VALUES(username),work_id = VALUES(work_id),start_time = VALUES(start_time),projectname = VALUES(projectname);");
                unset($datas);
            }
        }
        $this->getUpdateQuit();
    }

    /*事业部更新员工第三步（钉钉没有的系统人员离职操作）*/
    public function getUpdateQuit()
    {
        $user = db::query("SELECT *, COUNT(work_id) FROM shilian_users where is_quit = '-1' and del = '-1' and work_id != 'SD888888' GROUP BY work_id HAVING COUNT(work_id) > 1");
        foreach($user as $k=>$v)
        {
            $info = db::name('users')->where(['work_id'=>$v['work_id'],'updates'=>date('Y-m-d',time())])->find();
            if($info !== null)
            {
                db::name('users')->where('id',$info['id'])->delete();
                db::name('users')->where('work_id',$v['work_id'])->update(['updates'=>$info['updates'],'phone'=>$info['phone']]);
            }
        }
        $updates = date('Y-m-d',time());
        $infos1 = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->where('updates','lt',$updates)->where('station','in','5,8,18,19,12,13,14,15,16,17,20,21,44')->select();
        foreach($infos1 as $k=>$v)
        {
            db::name('users')->where('id',$v['id'])->update(['is_quit'=>1]);
        }
        $infos = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->where('updates',null)->where('station','in','5,8,18,19,12,13,14,15,16,17,20,21,44')->select();
        foreach($infos as $k=>$v)
        {
            db::name('users')->where('id',$v['id'])->update(['is_quit'=>1]);
        }
        db::name('ceshi')->where('id','>',0)->delete();
        echo 'ok';
    }

   

    public function getCurl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
    }



    public function DirectUser()
    {
        /*获取所有的房联宝部门*/
        $accessToken = $this->getToken();
        $FangLianBaoDepartment = $this->getFangLianBaoDepartment();
        $postArr = db::name('posts')->select();
        foreach($postArr as $k=>$v)
        {
            $station[$v['posts']] = $v['id'];
        }
        $list = $this->getCurl('https://oapi.dingtalk.com/department/list?access_token='.$accessToken.'&id=141834095');
        if($list['errmsg'] == 'ok')
        {
            $DingDepartment = $list['department'];
            foreach($DingDepartment as $k=>$v)
            {
                $num = !empty($FangLianBaoDepartment[$v['name']])?$FangLianBaoDepartment[$v['name']]:false;
                if($num) {
                    $url = "https://oapi.dingtalk.com/user/listbypage?access_token=" . $accessToken . "&department_id=" . $v['id'] . "&offset=0&size=100";
                    $UserList = $this->getCurl($url);
                    if ($UserList['hasMore'] == true) {
                        $lists1 = $this->getCurl("https://oapi.dingtalk.com/user/listbypage?access_token=" . $accessToken . "&department_id=" . $v['id'] . "&offset=100&size=100");
                        $listArr = array_merge($UserList['userlist'], $lists1['userlist']);
                    } else {
                        $listArr = $UserList['userlist'];
                    }
                    foreach($listArr as $key=>$val)
                    {
                        $getRandom = getRandom();
                        $work_id = isset($val['jobnumber'])?$val['jobnumber']:'SD888888';
                        if(empty($work_id))
                        {
                        $work_id = 'SD888888';
                        }
                        $info = [
                            'work_id'=>$work_id,
                            'phone'=>$val['mobile'],
                            'updates'=>date('Y-m-d',time()),
                            'username'=>$val['name'],
                            'department'=>$num,
                            'region'=>70,
                            'station' => isset($station[$val['position']])?$station[$val['position']]:19,
                            'random'=> $getRandom,
                            'pass' => md5($getRandom.'123456'),
                            'start_time'=>isset($val['hiredDate'])?date('Y-m-d',($val['hiredDate']/1000)):time('Y-m-d',time()),
                            'is_quit' => -1,
                            'del' => -1
                        ];
                        $datas[] = $info;
                    }
                    if(!empty($datas))
                    {
                        $date = '';
                        foreach($datas as $k=>$v)
                        {
                            $date .= ',('.'"'.$v['work_id'].'","'.$v['phone'].'","'.$v['updates'].'","'.$v['department'].'","'.$v['region'].'","'.$v['username'].'","'.$v['station'].'","'.$v['random'].'","'.$v['pass'].'","'.$v['start_time'].'","'.$v['is_quit'].'","'.$v['del'].'")';
                        };
                        $str = substr($date, 1);
                        $res = Db::query("INSERT INTO shilian_users (work_id,phone,updates,department,region,username,station,random,pass,start_time,is_quit,del) VALUES ".$str." ON DUPLICATE KEY UPDATE updates = VALUES(updates),is_quit = VALUES(is_quit),del = VALUES(del),station = VALUES(station),department = VALUES(department),username = VALUES(username),work_id = VALUES(work_id),start_time = VALUES(start_time);");
                        unset($datas);
                    }
                }
            }
            $this->getUpdateQuitSale();
        }
        echo 'success';
    }

public function getUpdateQuitSale()
    {
        $name = db::name('posts')->where('pid','51')->field('id')->select();
        foreach($name as $k=>$v)
        {
            $date[] = $v['id'];
        }
        $user = db::query("SELECT *, COUNT(work_id) FROM shilian_users where is_quit = '-1' and del = '-1' and work_id != 'SD888888' GROUP BY work_id HAVING COUNT(work_id) > 1");
        foreach($user as $k=>$v)
        {
            $info = db::name('users')->where(['work_id'=>$v['work_id'],'updates'=>date('Y-m-d',time())])->find();
            if($info !== null)
            {
                db::name('users')->where('id',$info['id'])->delete();
                db::name('users')->where('work_id',$v['work_id'])->update(['updates'=>$info['updates'],'phone'=>$info['phone']]);
            }
        }
        $infos = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->where('updates',null)->where('station','in',$date)->select();
        foreach($infos as $k=>$v)
        {
            db::name('users')->where('id',$v['id'])->update(['is_quit'=>1]);
        }
                $updates = date('Y-m-d',time());

        $infos1 = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->where('updates','lt',$updates)->where('station','in',$date)->select();
        foreach($infos1 as $k=>$v)
        {
            db::name('users')->where('id',$v['id'])->update(['is_quit'=>1]);
        }
        echo 'ok';
    }


    function getFangLianBaoDepartment()
    {
        $department = db::name('framework')->field('id,name')->select();
        //$departmentArr = db::name('framework')->field('id,cid,name')->where('id','in',$this->getTree($department))->select();
        foreach($department as $k=>$v)
        {
            $data[$v['name']] = $v['id'];
        }
        return $data;
    }

     function getTree($data, $pid = '70', $is_first_time = true)
    {
        static $arr = [];
        if ($is_first_time) {
            $arr = [];
        }
        foreach ($data as $k => $v) {
            if ($v['cid'] == $pid) {
                $arr[]           = $v['id'];
                $this->getTree($data, $v['id'], false);
            }
        }
        return $arr;
    }

    function DeepInArray($value, $array) 
    {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }
            if(in_array($value, $item)) {
                return true;
            } else if($this->DeepInArray($value, $item)) {
                return true;
            }
        }
        return false;
    }


}