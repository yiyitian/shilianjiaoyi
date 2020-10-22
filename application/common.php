<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//$m和$n代表传入的两个数值，主要就是这两个数值之间的比较
//$x代表传入的方法，比如是；add,sub等
//$scale  代表传入的小数点位数。这个根据需求更改即可
use library\tools\Data;
use think\Cache;
use think\Db;

function calc($m, $n, $x, $scale)
{
    $errors = array(
        '被除数不能为零',
        '负数没有平方根'
    );
    $t = 0;
    switch ($x) {
        case 'add':
            $t = bcadd($m, $n, $scale);
            break;
        case 'sub':
            $t = bcsub($m, $n, $scale);
            break;
        case 'mul':
            $t = bcmul($m, $n, $scale);
            break;
        case 'div':
            if ($n != 0) {
                $t = bcdiv($m, $n, $scale);
            } else {
                return $errors[0];
            }
            break;
        case 'pow':
            $t = bcpow($m, $n, $scale);
            break;
        case 'mod':
            if ($n != 0) {
                $t = bcmod($m, $n);
            } else {
                return $errors[0];
            }
            break;
        case 'sqrt':
            if ($m >= 0) {
                $t = bcsqrt($m, $scale);
            } else {
                return $errors[1];
            }
            break;
    }
    return $t;
}
/**
 * 设备或配置系统参数
 * @param string $name 参数名称
 * @param boolean $value 无值为获取
 * @return string|boolean
 * @throws \think\Exception
 * @throws \think\exception\PDOException
 */
function sysconf($name, $value = null)
{
    static $config = [];
    if ($value !== null) {
        list($config, $data) = [[], ['name' => $name, 'value' => $value]];
        return save('Config', $data, 'name');
    }
    if (empty($config)) {
        $config = Db::name('Config')->column('name,value');
    }
    return isset($config[$name]) ? $config[$name] : '';
}
function save($dbQuery, $data, $key = 'id', $where = [])
{
    $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
    $where[$key] = isset($data[$key]) ? $data[$key] : '';
    if ($db->where($where)->count() > 0) {
        return $db->strict(false)->where($where)->update($data) !== false;
    }
    return $db->strict(false)->insert($data) !== false;
}
function zhuan($number)
{


    return  (float) $number / 100;
}

function filter_by_value($array, $index, $value)
{
    if (is_array($array) && count($array) > 0) {
        foreach (array_keys($array) as $key) {
            $temp[$key] = $array[$key][$index];

            if ($temp[$key] == $value) {
                $newarray[$key] = $array[$key];
            }
        }
    }

    return $newarray;
}
function in_time()
{
    list($start, $middle, $end) = explode(' ', sysconf('open_time'));
    $now = strtotime(date('Y-m-d'));
    $start = strtotime($start);
    $end = strtotime($end);
    if ($now < $start || $now > $end) {
        return 3;
    } else {
        return 1;
    }
}
function diffBetweenTwoDays($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}
function get_project($role)
{
    if ($role == 2) {
        $project_name = Db::name('project')->where(['manager' => $_SESSION['think']['user_id'], 'status' => 1,'is_edit'=>'1'])->value('id'); //项目

    } else {
        $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
        $project_name = $this_one['projectname'];
    }
    return $project_name;
}
 function getDepartment($id=19)
{
    $list = [
        '19' => '事业一部',
        '20' => '事业三部',
        '21' => '事业四部',
        '22' => '事业五部',
        '23' => '事业五部(青岛)',
        '24' => '事业六部',
        '25' => '营业一部',
        '26' => '营业二部',
        '38' => '临沂交易事业部',
        '39' => '代理机构',
        '65' => '事业五部（潍坊）',
        '67' => '事业六部（济南）',
        '68' => '事业六部（烟台）',
        '69' => '事业六部（青岛）',
        '75' => '事业六部（泰安）',
        '61'=>'事业五部（青岛）'




    ];
    return $list[$id];
}

/**
 * 监测经理打分状态
 */
function check_manager_status($project_name)
{
    $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
    //dd($project_name);
    $month_number = Db::name('maintain')->where([ 'pid' => $project_name])->where('status','neq','禁止')->where('station','in','18,19')->count(); //统计参与考评的人数，除文员
    $employee_count = Db::name('employee_evaluate')->where(['project_title' => $project_name, 'month' => $month, 'admin_submit' => 2])->count();
    //dd($month_number);dd($employee_count);die;
    if (($month_number <= $employee_count)&&($month_number !==0)) {
         $month_numbers = Db::name('maintain')->where([ 'pid' => $project_name])->where('status','neq','禁止')->where('station','in','13,14,15')->count(); //统计参与考评的人数，除文员
            if($month_numbers  !== 0)
            {
                 $employee_counts = Db::name('employee_evaluate')->where(['project_title' => $project_name, 'month' => $month, 'admin_submit' => 2])->count();
                 if ($month_numbers <= $employee_counts) {
                        return 1;
                 }else{
                    return 2;
                 }
            }else{
                return 1;
            }
    } else {
        return  2;
    }
}
function  get_aims($project, $month = '')
{
    if ($month == '') {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
    }
    return $aims = Db::name('aims')->where(['project_title' => $project, 'month' => $month])->find();
}
function set_zero($arr, $field)
{
    $count=count($field);
    for ($i = 0; $i <= $count - 1; $i++) {
        if (!isset($arr[$field[$i]]) || $arr[$field[$i]]==null) {
            $arr[$field[$i]] = 0;
        }
    }
    return $arr;
}
function formatMobile($mobile){
         //颠倒顺序每隔4位分割为数组
        $split = str_split(strrev($mobile),4);    
        //头和尾保留，其他部分替换为星号  
        $split = array_fill(1,count($split) - 2,"****") + $split;
        ksort($split);
        //合并颠倒顺序
        return strrev( implode("",$split));
   }
 
  /**
    * 姓名第一个字掩码
    * @param string $true_name 真实姓名
    * @return string
    */
   function formatTrueName($true_name){      
       
  $str=mb_substr($true_name,0,1,'utf-8');
  return $str."**";
   }
   /*
    @param $type string 类型
   */
function getOutline($id)
{
    return db::name('class_info')->where('id',$id)->value('title');
}
   function getName($type,$id)
   {
        if($type==1)
        {
            return db::Name('framework')->where('id',$id)->value('name');
        }else if($type==2)
        {
            return db::Name('posts')->where('id',$id)->value('posts');
        }else
        {
            return db::Name('project')->where('id',$id)->value('name');    
        }
   }
   function getTotal($info)
    {
       
        foreach($info as $k=>$v)
        {
            switch($v['station'])
            {
                case 21:
                    $data[$k] = (float)0.43;
                    break;
                case 15:
                    $data[$k] = (float)0.46;
                    break;
                case 14:
                    $data[$k] = (float)0.62;
                    break;
                case 44:
                    $data[$k] = (float)0.78;
                    break;
                case 19:
                    $data[$k] = (float)0.33;
                    break;
                case 18:
                    $data[$k] = (float)0.38;
                    break;
                case 17:
                    $data[$k] = (float)0.47;
                    break;
                case 16:
                    $data[$k] = (float)0.57;
                    break;
                case 13:
                    $data[$k] = (float)1.03;
                    break;
                
            }
           
        }
        return array_sum($data);
    }
 function getRandom($length=6)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $string  = '';
        for($i = 0; $i < $length; $i ++) {
            $string .= $pattern {mt_rand ( 0, 61 )}; //生成php随机数
        }
        return $string;
    }
 function getProject()
    {
        $project_id= Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->count();
        if($project_id>'1')
        {
            $project_id = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1,'is_edit'=>1])->value('id');
        }else
        {
            $project_id = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1,])->value('id');
        }

        return $project_id;
        
    }

    function getProjects()
    {

        return db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('projectname');
        
    }

    function AddLog($var){
        file_exists("log/".date("Y-m-d").'.txt')?'':touch("log/".date("Y-m-d").'.txt');
        $content = file_get_contents("log/".date("Y-m-d").'.txt');//获取日志文件
        $content .= $content ? "\r\n" : '';//判断日志是否存在
        $content .= date('Y-m-d H:i:s',time()).'|'.implode(',',session('')).'|'.$var;//更新日志内容
        file_put_contents("log/".date("Y-m-d").'.txt',$content);//更新日志文件
    }

    function getFramework()
    {
        $list = db::name('framework')->field('id,name')->select();
        foreach($list as $k=>$v)
        {
            $data[$v['id']] = $v['name'];
        }
        return $data;
    }
    function getStations()
    {
        $list = db::name('posts')->field('id,posts')->select();
        foreach($list as $k=>$v)
        {
            $data[$v['id']] = $v['posts'];
        }
        return $data;
    }
function getStations1()
{
    $list = db::name('posts')->field('id,posts')->select();
    foreach($list as $k=>$v)
    {
        $data[$v['posts']] = $v['id'];
    }
    return $data;
}

    function getProjectTitle()
    {
        $list = db::name('project')->field('id,name')->select();
        foreach($list as $k=>$v)
        {
            $data[$v['id']] = $v['name'];
        }
        return $data;
    }

    function getProjectTitles()
    {
        $list = db::name('project')->field('id,name')->select();
        foreach($list as $k=>$v)
        {
            $data[$v['name']] = $v['id'];
        }
        return $data;
    }
    function getClassInfo()
    {
        $list = db::table('shilian_classinfo')->field('id,title')->select();
        foreach($list as $k=>$v)
        {
            $data[$v['id']] = $v['title'];
        }
        return $data;
    }

