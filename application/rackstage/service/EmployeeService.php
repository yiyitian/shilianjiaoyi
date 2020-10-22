<?php


namespace app\rackstage\service;


use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;
use think\Request;
use app\rackstage\model\ErpCostume;
use app\rackstage\model\ErpBalance;

/**
 * 置业顾问
 * Class EmployeeService
 * @package app\rackstage\service
 */
class EmployeeService
{
    /**
     * 处理打分记录
     * @param $role_title
     * @param $user_id
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function handle_employee($role_title, $user_id)
    {
        $employee = [];
        $arr = [];
        switch ($role_title) {
            case 1:
                $employee = Db::name('employee_evaluate')->where(['admin_id' => $user_id, 'admin_submit' => 1, 'is_submit' => 2, 'clerk_submit' => 2])->select();

                break;
            case 2:
                $employee = Db::name('employee_evaluate')->where(['manager_id' => $user_id, 'is_submit' => 1])->select();
                break;
            case 5:
                $employee = Db::name('employee_evaluate')->where(['clerk_id' => $user_id, 'clerk_submit' => 1])->select();
                foreach($employee as $k=>$v)
                {
                    if($v['is_submit'] == 1)
                    {
                        echo json_encode(['code' => 2, 'msg' => '请等待项目经理提交后再提交！！！']);
                        die;
                    }
                }
                break;
        }
        if (empty($employee)) {
            echo json_encode(['code' => 2, 'msg' => '没有需要提交的数据']);
            die;
        }

        self::employee_separate($role_title, $employee);
    }
    /**
     * 获取打分记录
     */
    public static function get_data(Request $request, $role, $where, $user_id)
    {
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        $list =  Db::name('employee_evaluate')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
        foreach ($list as $k => $v) {
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
            $list[$k]['username'] = str_replace(', ','',$v['username']);
        }
        $count = Db::name('employee_evaluate')->where($where)->count();
        return array($count, $page, $limit, $list);
    }

    public static function get_datas(Request $request, $role, $where, $user_id)
    {
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        $db = Db::name('employee_evaluate')->where($where);
        switch ($role) {
            case 1:
                break;
            case 2:

                //删除了 static function ($query) use
                $db->where(function ($query) use ($user_id) {
                $query->table('employee_evaluate')->where(['manager_id' => $user_id])->whereOr(['manager_id' => 0]);
            });
                $db->where(function ($query) use ($user_id) {
                $query->table('employee_evaluate')->where(['manager_id' => $user_id])->whereOr(['manager_id' => 0]);
            });
                break;
            case 5:
                $db->where(function ($query) use ($user_id) {
                $query->table('employee_evaluate')->where(['clerk_id' => $user_id])->whereOr(['clerk_id' => 0]);
            });
                $db->where(function ($query) use ($user_id) {
                $query->table('employee_evaluate')->where(['clerk_id' => $user_id])->whereOr(['clerk_id' => 0]);
            });
                break;

        }
        $list = $db->limit($tol, $limit)->fetchSql(false)->select();

        foreach ($list as $k => $v) {
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
            $list[$k]['username'] = str_replace(', ','',$v['username']);

        }
        $count = Db::name('employee_evaluate')->where($where)->count();
        return array($count, $page, $limit, $list);
    }


    public function dddd()
    {
        dd(session('haha'));
    }

    /**
     *
     * @param $role_title
     * @param $employee
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function employee_separate($role_title, $employee)
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        foreach ($employee as $k => $v) {

            $infoUser = db::name('users')->where('id',$v['userid'])->value('username');
             $v['username'] =  $v['work_id'] . sysconf('username_break') . preg_replace('|[0-9a-zA-Z/]+|','',trim($infoUser));
            $total_subscribe = (new ErpBalance())->get_one_number(['saler_name' => $v['username']]);
            $deal = db::name('deal')->where(['username'=>str_replace(', ','，',$v['username']),'month'=>$month])->count();
            if($_SESSION['think']['user_id']==330){
            }
            $one = date('Y-m-01', strtotime('-1 month'));
            $end = date('Y-m-t', strtotime('-1 month'));
            $where = [
                'person_name' => $v['username'],
                'void_flag' => 1,
                'source_type_cd' => array('in', ['CALL客', '老带新/友介','微信朋友圈','邀约', '外拓']),
                'join_date' => ['between time',array($one,$end)]
            ];
            $dd = str_replace(', ',',',$v['username']);
            $wheres = "person_name = '".$dd."' and void_flag = 1 and `source_type_cd` IN ('CALL客','老带新/友介','微信朋友圈','邀约','外拓') and `join_date` BETWEEN '".$one."' AND '".$end."'";
            $total_oln = (new ErpCostume())->get_one_olns($where,$wheres);
            $map = [
                'source' => array('in',['CALL客', '老带新/友介','微信朋友圈','邀约', '外拓']),
                'employee' => str_replace(', ','，',$v['username']),
                'month' => $month,
            ];

            $costume = db::name('costume')->where($map)->count();
            $this_project = Db::name('project')->field('type')->where(['id' => $v['project_title']])->find();
            $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $v['project_title'], 'month' => $month])->find();
            $this_evaluate = Db::name('employee_evaluate')->find($v['id']);
            $project_status = $this_aims['status'];
            $score = 0;
            $subscribe_real = 0;

            switch ($project_status) {
                case '1':
                    $score = 30;
                    $subscribe_real = $total_subscribe >= (int)sysconf('employee_min') ? 30 : 0;
                    break;
                case '-1':
                    $score = 40;
                    $subscribe_real = 0;
                    break;
            }

            $oln_real_score = 0;
            switch ($this_project['type']) {
                case 1: //住宅
                    $oln_real_score = $total_oln >= (int)sysconf('primary_visiting') ? $score : 0; //老带新完成率得分
                    break;
                case 2: //商办
                    $oln_real_score = $total_oln >= (int)sysconf('business_visiting') ? $score : 0; //老带新完成率得分
                    break;
            }

            $work_book_score = $v['work_book_score']; //计划书的得分
            $erp_entry_real_score = 0;

//            /*计划书的方法为看*/
//            if ($role_title == 1) {
//                $erp_entry_real_score = self::get_erp_real($this_evaluate, $month, $v);
//            }
//            if ($role_title == 5) {
//                $erp_entry_real_score = self::get_erp_real($this_evaluate, $month, $v);
//            }
            $total_real = (int)$subscribe_real + (int)$oln_real_score + (int)$work_book_score + (int)$erp_entry_real_score;


            $result = 0;

            switch ($total_real) {
                case $total_real > $v['total'];
                    $result = 1;
                    break;
                case $total_real == $v['total'];
                    $result = 2;
                    break;
                case $total_real < $v['total'];
                    $result = 3;
                    break;
            }

            $data = [
                'id' => $v['id'],
                'subscribe_rate' => $total_subscribe,
                'subscribe_real' => $subscribe_real,
                'old_with_new' => $total_oln,
                'oln_real_score' => $oln_real_score,
                'erp_entry_real_score' => $erp_entry_real_score,
                'total_real' => $total_real,
                'result' => $result
            ];


            if (($this_evaluate['subscribe_score'] != $subscribe_real) && $role_title == 2) {

                $data['color1'] = 'red';
                $data['manager_score'] = $this_evaluate['manager_score'] - 1;

            }

            if (((int)$this_evaluate['oln_score'] != $oln_real_score) && $role_title == 2 ) {
                $data['color2'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;
            }

            if($role_title == 5)
            {
                if(($total_subscribe < $deal)||($total_oln < $costume))
                {
                    if($v['erp_entry_score'])
                        $data['erp_entry_real_score'] = 0;

                    $data['color3'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;

                }else{
                    $data['erp_entry_real_score'] = 10;

                }
                if($v['erp_entry_score'] == $data['erp_entry_real_score'])
                {
                    $data['color3'] = 'black';
                }else{
                    $data['color3'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;
                }
            }

            $data['total_real'] += $data['erp_entry_real_score'];
            switch ($role_title) {
                case 1:
                    $data['admin_submit'] = 2;
                    break;
                case 2:
                    $data['is_submit'] = 2;
                    break;
                case 5:
                    $data['clerk_submit'] = 2;
                    break;
            }
            Db::name('employee_evaluate')->update($data);
            if ($this_evaluate['back']==0){
                Db::name('aims')->where(['id' => $this_aims['id']])->setInc('employee_complete');

            }
        }
    }



    public static function employee_separates($role_title, $employee)
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        foreach ($employee as $k => $v) {
            $infoUser = db::name('users')->where('id',$v['userid'])->value('username');
            $v['username'] =  $v['work_id'] . sysconf('username_break') . preg_replace('|[0-9a-zA-Z/]+|','',trim($infoUser));
            $total_subscribe = (new ErpBalance())->get_one_number(['saler_name' => $v['username'], 'void_flag' => 1]);
            $deal = db::name('deal')->where(['username'=>str_replace(', ','，',$v['username']),'month'=>$month])->count();
            if($_SESSION['think']['user_id']==330){
            }
            $one = date('Y-m-01', strtotime('-1 month'));
            $end = date('Y-m-t', strtotime('-1 month'));
            $where = [
                'person_name' => $v['username'],
                'void_flag' => 1,
                'source_type_cd' => array('in', ['CALL客', '老带新/友介','微信朋友圈','邀约', '外拓']),
                'join_date' => ['between time',array($one,$end)]
            ];
            $dd = str_replace(', ',',',$v['username']);
            $wheres = "person_name = '".$dd."' and void_flag = 1 and `source_type_cd` IN ('CALL客','老带新/友介','微信朋友圈','邀约','外拓') and `join_date` BETWEEN '".$one."' AND '".$end."'";
            $total_oln = (new ErpCostume())->get_one_olns($where,$wheres);
            $map = [
                'source' => array('in',['CALL客', '老带新/友介','微信朋友圈','邀约', '外拓']),
                'employee' => str_replace(', ','，',$v['username']),
                'month' => $month,
            ];
            $costume = db::name('costume')->where($map)->count();
            $this_project = Db::name('project')->field('type')->where(['id' => $v['project_title']])->find();
            $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $v['project_title'], 'month' => $month])->find();
            $this_evaluate = Db::name('employee_evaluate')->find($v['id']);
            $project_status = $this_aims['status'];
            $score = 0;
            $subscribe_real = 0;
            switch ($project_status) {
                case '1':
                    $score = 30;
                    $subscribe_real = $total_subscribe >= (int)sysconf('employee_min') ? 30 : 0;
                    break;
                case '-1':
                    $score = 40;
                    $subscribe_real = 0;
                    break;
            }
            $oln_real_score = 0;
            switch ($this_project['type']) {
                case 1: //住宅
                    $oln_real_score = $total_oln >= (int)sysconf('primary_visiting') ? $score : 0; //老带新完成率得分
                    break;
                case 2: //商办
                    $oln_real_score = $total_oln >= (int)sysconf('business_visiting') ? $score : 0; //老带新完成率得分
                    break;
            }

            $work_book_score = $v['work_book_score']; //计划书的得分
            $erp_entry_real_score = 0;
//            /*计划书的方法为看*/
//            if ($role_title == 1) {
//                $erp_entry_real_score = self::get_erp_real($this_evaluate, $month, $v);
//            }
//            if ($role_title == 5) {
//                $erp_entry_real_score = self::get_erp_real($this_evaluate, $month, $v);
//            }
            $total_real = (int)$subscribe_real + (int)$oln_real_score + (int)$work_book_score + (int)$erp_entry_real_score;

            $result = 0;
            switch ($total_real) {
                case $total_real > $v['total'];
                    $result = 1;
                    break;
                case $total_real == $v['total'];
                    $result = 2;
                    break;
                case $total_real < $v['total'];
                    $result = 3;
                    break;
            }
            $data = [
                'id' => $v['id'],
                'subscribe_rate' => $total_subscribe,
                'subscribe_real' => $subscribe_real,
                'old_with_new' => $total_oln,
                'oln_real_score' => $oln_real_score,
                'erp_entry_real_score' => $erp_entry_real_score,
                'total_real' => $total_real,
                'result' => $result
            ];


            if (($this_evaluate['subscribe_score'] != $subscribe_real) && $role_title == 2) {
                $data['color1'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;

            }else{
                $data['color1'] = 'black';
            }

            if (((int)$this_evaluate['oln_score'] != $oln_real_score) && $role_title == 2 ) {
                $data['color2'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;
            }else{
                $data['color2'] = 'black';
            }

            if($role_title == 5)
            {
                if(($total_subscribe < $deal)||($total_oln < $costume))
                {
                    $data['color3'] = 'red';                $data['manager_score'] = $this_evaluate['manager_score'] - 1;

                }else{
                    $data['erp_entry_real_score'] = 10;
                    $data['black'] = 'red';
                }
            }

            $data['total_real'] += $data['erp_entry_real_score'];
            switch ($role_title) {
                case 1:
                    $data['admin_submit'] = 2;
                    break;
                case 2:
                    $data['is_submit'] = 2;
                    break;
                case 5:
                    $data['clerk_submit'] = 2;
                    break;
            }
           echo  Db::name('employee_evaluate')->update($data);

        }
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function frame_project()
    {
        $framework_id = Db::name('project')->where('del', 'neq', '1')->where('status', 1)->column('framework_id'); //项目
        $pro_pid = Db::name('framework')->field('id,pid,name')->whereIn('id', array_unique($framework_id))->select(); //获取项目所有
        foreach ($pro_pid as $k => $v) {
            $pro_pid[$k]['father'] = Db::name('framework')->where('id', $v['pid'])->value('name');
            $pro_pid[$k]['project'] = Db::name('project')->where('del', 'neq', '1')->where(['status' => 1, 'framework_id' => $v['id']])->select();
        }
        $framework_pid = Db::name('framework')->where('pid', '-1')->order('id asc')->select();
        foreach ($framework_pid as $k1 => $v1) {
            $framework_pid[$k1]['framework'] = Db::name('framework')->where('pid', 'neq', '-1')->select();
        }

        return array($pro_pid, $framework_pid);
    }

    /**
     * 拼装条件
     * @param $role_title
     * @param $where
     * @param $project_name
     * @return mixed
     */
    public static function insert_where($role_title, $where,$project_name='')
    {
//        $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
        $department = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department'); //项目
        $where['del'] = -1;

        switch ($role_title) {
            case 1://
                if (isset($_GET['history'])) { //历史记录
                    $where['admin_submit'] = 2;
                } else {
                    $where['admin_submit'] = 1;
                    $where['is_submit'] = 2;
                    $where['clerk_submit'] = 2;
                }
                break;
            case 4://
                $where['admin_submit'] = 2;
                $where['userid'] = $_SESSION['think']['user_id'];
                break;
            case 2://项目经理
                $where['project_title'] = $project_name;
                (isset($_GET['history']) && $_GET['history'] != "") ? $where['is_submit'] = 2 : $where['is_submit'] = 1;
                break;
            case 5://文员
                (isset($_GET['history']) && $_GET['history'] != "") ? $where['clerk_submit'] = 2 : $where['clerk_submit'] = 1;
                $where['project_title'] = $project_name;
                break;
            case 7://部门秘书
                $where['admin_submit'] = 2;
                $where['project_title'] = $project_name;
                break;
            case 8://部门秘书
                $where['admin_submit'] = 2;
                $where['department'] = $department;
                break;
        }
        return $where;
    }

    /**
     * @param $info
     * @param $manager_id
     * @param $clerk_id
     * @param $admin_id
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function total_score($info, $manager_id, $clerk_id, $admin_id, $j)
    {
        $one = Db::name('employee_evaluate')->where(['id' => $info['id']])->find();

        $subscribe_score = (int)$one['subscribe_score']; //认购完成分数
        $oln_score = (int)$one['oln_score']; //老带新完成分数
        $work_book_score = (int)$one['work_book_score']; //计划完成分数
        $erp_entry_score = (int)$one['erp_entry_score']; //erp录入得分
        $total = $subscribe_score + $oln_score + $work_book_score + $erp_entry_score; //认购完成分数+老带新完成分数+计划书完成分数+erp录入得分
        $data = ['manager_id' => $manager_id, 'clerk_id' => $clerk_id, 'admin_id' => $admin_id, 'total' => $total];
        switch ($j) {
            case 1:
                $data['admin_id'] = $admin_id;
                break;
            case 2:
                $data['manager_id'] = $manager_id;
                break;
            case 5:
                $data['clerk_id'] = $clerk_id;
                break;
        }

        Db::name('employee_evaluate')->where(['id' => $info['id']])->update($data); //
    }

    /**
     * 上传来访台账
     * @param $saveName
     * @param $user_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_costume($saveName, $user_id)
    {
        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径
        $excelReader = IOFactory::createReader($inputFileType); //Xlsx
        $PHPExcel = $excelReader->load($file_url); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $sheetdata = $sheet->toArray();
        unset($sheetdata[0]);
        $log = [];
        foreach ($sheetdata as $k => $v) {
            unset($v[0]);
            if($v[7] == null)
            {
                break;
            }
            $count = Db::name('costume')->where(['project_title' => $v[1], 'costume' => $v[2], 'phone' => $v[3]])->count();
            if ($count == 0) {
                if((strpos($v[7],',') !== false)||(strpos($v[7],'，') !== false)){
                    if(count(explode('，', $v['7']))<2)
                    {
                        list($work_id, $username) = explode(',', $v['7']);
                    }else{
                        list($work_id, $username) = explode('，', $v['7']);
                    }
                }else{
                    $work_id = "无";
                    $username = $v[7];
                }


                $uid = Db::name('users')->where(['work_id' => $work_id])->value('id');
                $project = Db::name('project')->where(['name' => $v['1']])->value('id');
                $log[] = [
                    'project_title' => $v[1],
                    'project' => $project,
                    'costume' => $v[2],
                    'phone' => $v[3],
                    'address' => $v[4],
                    'source' => $v[5],
                    'date' => $v[6],
                    'employee' => $v[7],
                    'user_id' => $uid, //置业顾问id
                    'clerk_id' => $user_id, //置业顾问id
                    'month' => date('Y-m', strtotime($v[6])),
                ];
            }
        }
        Db::name('costume')->insertAll($log);
    }

    public static function target($saveName)
    {
        $dates = date('Y-m', time());
        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径
        $excelReader = IOFactory::createReader($inputFileType); //Xlsx
        $PHPExcel = $excelReader->load($file_url); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $sheetdata = $sheet->toArray();
        $log = [];
        foreach ($sheetdata as $k => $v) {
            $date['project_title'] = db::name('project')->where('name',$v['0'])->value('id');
            if('' !== $v[2])
            {
                $user = explode(',',$v[1]);

                if(count($user)>1)
                {
                    $userName = trim($user[1]);
                }else{
                    $userName = trim($user[0]);
                }
                $userId = db::Name("user")->where('user_name',$userName)->value('id');
                if(null !== $userId)
                {
                    $date['user_id'] = $userId;
                }
            }
            $date['number'] = $v['2'];
            db::name('aims')->where(['month'=>$dates,'project_title'=>$date['project_title']])->update($date);
        }
    }


    /**上传成交台账
     * @param $saveName
     * @param $user_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_deal($saveName, $user_id)
    {

        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径

        $excelReader = IOFactory::createReader($inputFileType); //Xlsx

        $PHPExcel = $excelReader->load($file_url); // 载入excel文件

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        $sheetdata = $sheet->toArray();
        unset($sheetdata[0]);
        $log = [];
        foreach ($sheetdata as $k => $v) {
            unset($v[0]);
            if($v[9] == null)
            {
                break;
            }
            $count = Db::name('deal')->where(['project_title' => $v[1], 'costume' => $v[2], 'phone' => $v[3],'room_number'=>$v[6]])->count();
            if ($count == 0) {
                if((strpos($v[9],',') !== false)||(strpos($v[9],'，') !== false)){
                    if(count(explode('，', $v['9']))<2)
                    {
                        list($work_id, $username) = explode(',', $v['9']);
                    }else{
                        list($work_id, $username) = explode('，', $v['9']);
                    }
                }else{
                    $work_id = "无";
                    $username = $v[9];
                }

                $uid = Db::name('users')->where(['work_id' => $work_id])->value('id');
                $project = Db::name('project')->where(['name' => $v['1']])->value('id');
                $log[] = [
                    'project_title' => $v[1],
                    'project' => $project,
                    'costume' => $v[2],
                    'phone' => $v[3],
                    'type' => $v[4],
                    'number' => $v[5],
                    'room_number' => $v[6],
                    'date' => $v[7],
                    'money' => $v[8],
                    'username' => $v[9],
                    'user_id' => $uid, //置业顾问id
                    'clerk_id' => $user_id, //上传人id
                    'month' => date('Y-m', strtotime($v[7])),
                ];
            }
        }
        Db::name('deal')->insertAll($log);
    }

    /**上传成交台账
     * @param $saveName
     * @param $user_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_performance($saveName, $user_id)
    {

        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径

        $excelReader = IOFactory::createReader($inputFileType); //Xlsx

        $PHPExcel = $excelReader->load($file_url); // 载入excel文件

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        $sheetdata = $sheet->toArray();
        unset($sheetdata[0]);
        $log = [];
        foreach ($sheetdata as $k => $v) {
            unset($v[0]);
            $count = Db::name('performance')->where(['username' => $v[2]])->count();
            if ($count == 0) {

                $project = Db::name('project')->where(['name' => $v['1']])->value('id');
                $dd = [
                    'project_title' => $v[1],
                    'project' => $project,
                    'username' => $v[2],
                    'status' => $v[3],
                    'number' => $v[5],
                    'turnover' => $v[6],
                    'area' => $v[7],
                    'admin_id' => $user_id, //上传人id
                    'month' => date('Y-m', strtotime(date('Y-m-01') . " - 1 month")),
                ];
                list($work_id, $username) = explode(sysconf('username_break'), $v['2']);
                $dd['userid'] = Db::name('users')->where(['work_id' => $work_id])->value('id');
                Db::name('performance')->insertGetId($dd);
            }
        }
    }

    /**上传er来访台账
     * @param $saveName
     * @param $user_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_erp_costume($saveName, $user_id)
    {

        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径

        $excelReader = IOFactory::createReader($inputFileType); //Xlsx

        $PHPExcel = $excelReader->load($file_url); // 载入excel文件

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        $sheetdata = $sheet->toArray();
        unset($sheetdata[0]);
        $log = [];
        foreach ($sheetdata as $k => $v) {
            unset($v[0]);
            $count = Db::name('erp_costume')->where(['username' => $v[7]])->count();
            if ($count == 0) {

                $project = Db::name('project')->where(['name' => $v['1']])->value('id');
                $dd = [
                    'project_title' => $v[1],
                    'project' => $project,
                    'costume' => $v[2],
                    'date' => $v[3],
                    'phone' => $v[4],
                    'source' => $v[6],
                    'username' => $v[7],
                    'admin_id' => $user_id, //上传人id
                    'month' => date('Y-m', strtotime(date('Y-m-01') . " - 1 month")),
                ];

                list($work_id, $username) = explode(sysconf('username_break'), $v['7']);
                $dd['userid'] = Db::name('users')->where(['work_id' => $work_id])->value('id');
                Db::name('erp_costume')->insertGetId($dd);
            }
        }
    }

    /**上传erp成交台账
     * @param $saveName
     * @param $user_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_erp_deal($saveName, $user_id)
    {

        $file_url = '..' . $saveName;
        $inputFileType = IOFactory::identify($file_url); //传入Excel路径

        $excelReader = IOFactory::createReader($inputFileType); //Xlsx

        $PHPExcel = $excelReader->load($file_url); // 载入excel文件

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        $sheetdata = $sheet->toArray();
        unset($sheetdata[0]);
        $log = [];
        foreach ($sheetdata as $k => $v) {
            unset($v[0]);
            $count = Db::name('erp_costume')->where(['username' => $v[7]])->count();
            if ($count == 0) {

                $project = Db::name('project')->where(['name' => $v['1']])->value('id');
                $dd = [
                    'project_title' => $v[1],
                    'project' => $project,
                    'floor' => $v[2],
                    'room_number' => $v[3],
                    'date' => $v[4],
                    'money' => $v[5],
                    'costume' => $v[6],
                    'type' => $v[7],
                    'number' => $v[8],
                    'phone' => $v[9],
                    'username' => $v[10],
                    'admin_id' => $user_id, //上传人id
                    'month' => date('Y-m', strtotime(date('Y-m-01') . " - 1 month")),
                ];

                list($work_id, $username) = explode(sysconf('username_break'), $v['10']);
                $dd['userid'] = Db::name('users')->where(['work_id' => $work_id])->value('id');
                Db::name('erp_deal')->insertGetId($dd);
            }
        }
    }

    /**
     * @param $this_evaluate
     * @param $month
     * @param $v
     * @return int
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get_erp_real($this_evaluate, $month, $v)
    {
        $erp_entry_real_score = 0;

        $clerk_costume = Db::name('costume')->where(['clerk_id' => $_SESSION['think']['user_id'], 'user_id' => $this_evaluate['userid'], 'month' => $month])->select();
        foreach ($clerk_costume as $k1 => $v1) {
            $w1 = ['contact_names' => formatTrueName($v1['costume']), 'c_mobile' =>formatMobile($v1['phone']), 'source_type_cd' => $v1['source']];;
            $da = (new ErpCostume)->get_costume_real($w1);
            if ($da > 0) {
                $erp_entry_real_score = 10;
            } else {
                $erp_entry_real_score = 0;
            }
        }
        $deal_costume = Db::name('deal')->where(['clerk_id' => $_SESSION['think']['user_id'], 'user_id' => $this_evaluate['userid'], 'month' => $month])->select();
        foreach ($deal_costume as $k3 => $v3) {
            $w2 = ['costume' => $v3['costume'], 'phone' => $v3['phone'], 'source' => $v3['source'], 'number' => $v3['number'], 'room_number' => $v3['room_number'], 'floor' => $v3['floor'], 'date' => $v3['date']];
            $d2 = Db::name('erp_costume')->where($w2)->count();
            if ($d2 > 0) {
                $erp_entry_real_score = 10;
            } else {
                $erp_entry_real_score = 0;
            }
        }
        return $erp_entry_real_score;
    }

    public static function export_csv($fileName, $heade, $data)
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        //打开php数据输入缓冲区
        $fp = fopen('php://output', 'a');

        //将数据编码转换成GBK格式
        mb_convert_variables('GBK', 'UTF-8', $heade);
        //将数据格式化为CSV格式并写入到output流中
        fputcsv($fp, $heade);

        //如果在csv中输出一个空行，向句柄中写入一个空数组即可实现
        foreach ($data as $k => $row) {
            //将数据编码转换成GBK格式
            if (isset($row['project_title'])) {
                $row['project_title'] = Db::name('project')->where(['id' => $row['project_title']])->value("name");
            } else {
                $row['project_name'] = Db::name('project')->where(['id' => $row['project_name']])->value("name");
            }

            $row['department'] = Db::name('framework')->where(['id' => $row['department']])->value('name');
            mb_convert_variables('GBK', 'UTF-8', $row);
            fputcsv($fp, $row);
            //将已经存储到csv中的变量数据销毁，释放内存
            unset($row);
        }
        //关闭句柄
        fclose($fp);
        die;
    }
}
