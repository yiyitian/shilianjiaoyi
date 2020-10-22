<?php

namespace app\rackstage\controller;

use app\rackstage\model\ErpCostume;
use app\rackstage\model\ErpProject;
use app\rackstage\model\Users;
use app\rackstage\service\AimsService;
use app\rackstage\service\ClerkService;
use app\rackstage\service\EmployeeService;
use app\rackstage\service\ProfitService;
use app\rackstage\service\ExportService;
use app\rackstage\service\ManagerService;
use app\rackstage\service\PlanService;
use app\rackstage\model\Manager;
use app\rackstage\model\ErpBalance;
use think\Db;
use think\Request;
use think\Response;

class Evaluation extends Common
{
    /**
     * @param $users
     * @param $month
     * @param array $log
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function create_manager_tables()
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $w['role'] = ['eq','36'];
        $w['status'] = 1;
        //$w['id'] = 150;
        $users = Db::name('user')->where($w)->order('id desc')->select();
        $log = [];
        foreach ($users as $key => $val) {
            $this_projects = Db::name('project')->where(['manager' => $val['id']])->select();
            foreach($this_projects as $k => $this_project)
            {
                $project_id = $this_project['id'];
                $bool = check_manager_status($project_id);
                if ($bool == 2) { //
                    continue;
                }
                $erp_project=(new ErpProject())->get_project(['project_name' => $this_project['name']]);
                $where = ["project_id" => $erp_project['project_id']];
                $subscribe_money = (new ErpBalance())->get_order_turnover($where);
                $project_log = Db::name('aims')->where(['project_title' => $project_id, 'month' => $month])->find(); //月度目标
                $number = 0;
                $subscribe_rate = 0;
                $subscribe_real = 0;
                $visiting_score = 0;
                $authenticity = 0;
                $develop_costume = 0;
                $profit = 0;
                $profit_score = 0;
                $a = Db::name('plan_evaluate')->where('manager_score', '<', 0)->count();
                $b = Db::name('employee_evaluate')->where('manager_score', '<', 0)->count();
                $total_oln = (new ErpCostume())->get_one_oln(['project_id' => $erp_project['project_id']]); //来访人数
                switch ($project_log['status']) {
                    case '1': //持效期
                        $aims = Db::name('aims')->where(['project_title' => $project_id, 'month' => $month])->value('number'); //月度目标
                        $aims = calc($aims, 10000, 'mul', 2);
                        $subscribe_rate = calc($subscribe_money, $aims, 'div', 2); //认购完成�?
                        $subscribe_rate > 0.5 ? $subscribe_real = 40 : $subscribe_real = 0; //认购完成得分
                        $profit = Db::name('profit')->where(['project_name' => $project_id, 'month' => $month])->value('total_profit');
                         if($profit =='null')
                        {
                            $profit = '';
                        }

                        if (empty($profit) || $aims == 0) {
                            continue;
                        }
                        $profit > 0 ? $profit_score = 30 : $profit_score = 0;
                        $total_oln > $project_log['number'] ? $visiting_score = 40 : $visiting_score = 0;
                        if ($a > 0 || $b > 0) {
                            $authenticity = 0;
                        } else {
                            $authenticity = 30;
                        }
                        break;
                    case '-1': //蓄客期
                        $erp_project = (new ErpProject())->get_project(['project_name' => $this_project['name']]);
                        $rate = calc($total_oln, $project_log['visiting'], 'div', 2);
                        $rate > 0.5 ? $develop_costume = 70 : $develop_costume = 0;
                        if ($a > 0 || $b > 0) {//
                            $authenticity = 0;
                        } else {
                            $authenticity = 40;
                        }
                        break;
                }
                 if($project_log['status'] == 1)
                {
                     if(empty($profit))
                {
continue;
                }
                }

                $userInfo = db::name('users')->where('user_id',$val['id'])->find();
                $one = Db::name('manager_evaluate')->where(['project_title' => $this_project['id'], 'username' => $userInfo['work_id'] . ', ' . $userInfo['username'], 'month' => $month])->find();

                if (empty($one)) {
                    $b = calc($subscribe_real, $authenticity, 'add', 2);
                    $das = [
                        'project_title' => $this_project['id'],
                        'username' => $userInfo['work_id'] . sysconf('username_break') . $userInfo['username'],
                        'subscribe_money' => $subscribe_money,
                        'subscribe_rate' => $subscribe_rate,
                        'subscribe_score' => $subscribe_real,
                        'authenticity' => $authenticity,
                        'profit' => $profit,
                        'visiting_score'=>$visiting_score,
                        'visiting'=>$total_oln,
                        'profit_score' => $profit_score,
                        'develop_costume' => $develop_costume,
                        'month' => $month,
                        'department' => $userInfo['department'],
                        'work_id' => $userInfo['work_id'],
                        'total' => calc($profit_score, $b, 'add', 2),
                        'total_real' => calc($profit_score, $b, 'add', 2),
                        'userid' => $val['id'],
                    ];
                    if(isset($das))
                    {
                        $logs[] = $das;
                    }
                }

            }
        }

        if (!isset($logs)) {
            return json(['code' => 3, 'msg' => '暂时无数数据']);
        }
        try {
            (new Manager)->saveAll($logs);
        } catch (\Exception $e) {
            return json(['code' => 2, 'msg' => $e->getMessage()]);
        }
        return json(['code' => 1, 'msg' => '刷新成功']);
    }

    /**
     * @param $project_name
     * @param $month
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function create_labor_table($project_name, $month)
    {
        $where = ['project' => $project_name, 'month' => $month];
        $count2 = Db::name('months_costs')->where($where)->count();
        if ($count2 == 0) {
            $post = Db::name('posts')->whereIn('id', [13, 14, 15, 16, 17, 18, 19, 21, 44])->order('sort asc')->select();
            $log = [];
            foreach ($post as $k => $v) {
                $count1 = Db::name('months_costs')->where($where)->where(['station_name' => $v['posts'], 'station' => $v['id']])->count();
                if ($count1 == 0) {
                    $log[] = [
                        'station_name' => $v['posts'],
                        'station' => $v['id'],
                        'month' => $month,
                        'project' => $project_name,
                        'one' => $v['total_money'],
                        'manager_id' => $_SESSION['think']['user_id']
                    ];
                }
            }
            Db::name('months_costs')->insertAll($log);
        }
    }


    /**
     * �?业顾�?打分�?(考评人：项目经理，文�?)
     * @param Request $request
     * @return Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        $da = session('');
        list($start, $middle, $end) = explode(' ', sysconf('open_time'));
        $now = strtotime(date('Y-m-d'));
        $start = strtotime($start);
        $end = strtotime($end);
        $role_id = $da['role']; //当前角色权限
        $role_title = $da['role_title'];
        $role = $da['role']; //当前按角色权限
        $user_id = $da['user_id']; //账号id
        $jurisdiction = $this->jurisdiction;
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $project_name = getProject();
        $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $project_name, 'month' => $month])->find();
        $project_status = $this_aims['status'];
        if ($jurisdiction == 4) {
            redirect(url('rackstage/index', ['history' => 1]));
        }
        if ($jurisdiction == 2) {
            $clerk = db::name('maintain')->where(['project'=>$project_name,'station'=>'21'])->find();
            if(empty($clerk))
            {
                $this->assign('showUpload',1);
            }
        }
        if ($jurisdiction == 5) {
            $project_name = getProjects();
        }
        if (isset($_GET['id'])) {
            $where['del'] = -1;
            $where['month'] = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $where = EmployeeService::insert_where($jurisdiction, $where, $project_name);
            list($count, $page, $limit, $list) = EmployeeService::get_data($request, $jurisdiction, $where, $user_id);
            foreach($list as $k=>$v)
            {
                $list[$k]['dep'] = getDepartment($v['department']);
            }

            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $clerk_id = 0;
        $manager_id = 0;
        $admin_id = 0;
        switch ($jurisdiction) {
            case 1:
                $manager_id = 0;
                $clerk_id = 0;
                $admin_id = $user_id;
                break;
            case 2:
                $manager_id = $user_id;
                $clerk_id = 0;
                $admin_id = 0;
                break;
            case 5:
                $manager_id = 0;
                $clerk_id = $user_id;
                $admin_id = 0;
                break;
        }
        (isset($_GET['history']) && $_GET['history'] != "") ? $tem = 'index2' : $tem = 'index';
        $this->assign('clerk_id', $clerk_id);
        $this->assign('manager_id', $manager_id);
        $this->assign('admin_id', $admin_id);
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('role_id', $role_id);
        $this->assign('role', $role);
        $this->assign('jurisdiction', $this->jurisdiction);
        $value = Db::name('users')->where('del', 'neq', '1')->field('id,work_id,username')->select();
        $this->assign('users', $value);
        $this->assign("project_status", $project_status);
        $in_time = $this->in_time;
        $this->assign('in_time', $in_time);
        $timeType = db::name('employee_evaluate')->field('month')->group('month')->select();
        $this->assign('timeType', $timeType);
        return $this->fetch($tem);
    }
    /**
     * 文员考核
     *
     * @param Request $request
     * @return Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function clerk(Request $request)
    {
        $role_title = $this->jurisdiction;
        
        $manager_id = $this->user_id;
        $user_id = $this->user_id;
        $admin_id = 0;
        switch ($this->jurisdiction) {
            case 1:
                $admin_id = $user_id;
                $manager_id = 0;
                break;
            case 2:
                $admin_id = 0;
                $manager_id = $user_id;
                break;
            case 7:
                $admin_id = 0;

                break;
        }
        if (isset($_GET['id'])) {
            $where['del'] = -1;
            $where['month'] = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            if ($role_title==2){
                $counts = db::name('project')->where(['manager' => $_SESSION['think']['user_id'],'status'=>1])->count();
                if($counts > 1)
                {
                    $project_name = db::name('project')->where(['manager' => $_SESSION['think']['user_id'],'status'=>1,'is_edit'=>1])->value('id');

                }else{
                                    $project_name = Db::name('project')->where(['manager' => $_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

                }
    
            }else{
    
                    $this_one=Db::name('users')->where(['user_id'=>$_SESSION['think']['user_id']])->find();
                    $project_name=$this_one['projectname'];

            }
            list($count, $page, $limit, $list) = ClerkService::get_data($request, $where, $this->jurisdiction, $user_id,$project_name);
            foreach($list as $k=>$v)
            {
                $list[$k]['dep'] = getDepartment($v['department']);
                $list[$k]['username'] = str_replace(', ','',$v{'username'});
            }
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        isset($_GET['history']) ? $tem = 'clerk2' : $tem = 'clerk';
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('manager_id', $manager_id);
        $this->assign('admin_id', $admin_id);
        $this->assign('users', Db::name('users')->where('del', 'neq', '1')->field('id,work_id,username')->select());
        $this->assign('role_title', $role_title);
        $this->assign('jurisdiction', $this->jurisdiction);
        $in_time = $this->in_time;
        $this->assign('in_time', $in_time);
        $this->assign('month',db::name('clerk_evaluate')->where('del','-1')->group('month')->select());
        return $this->fetch($tem);
    }

    /**
     * 经理
     *
     * @param Request $request
     * @return Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function manager(Request $request)
    {
        $get = $request->get();
        $jurisdiction = $this->jurisdiction;
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $department = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department'); //项目
        if (isset($get['id'])) {
            if($jurisdiction == 2)
            {
                //$where['userid'] = $_SESSION['think']['user_id'];
                $where['month'] = $month;
                $where['project_title'] = getProject();
                $list = Db::name('manager_evaluate')->where($where)->select();
                return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => 0, 'count' => 1, 'page' => 1]);
            }
            $where['del'] = -1;
            $log = [];
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $where['month'] = $month;
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            switch ($jurisdiction) {
                case 1:
                    break;
                case 2:
                    $where['userid'] = $_SESSION['think']['user_id'];
                    break;
                case 8:
                    $where['department'] = $department;
                    break;
            }
            isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;
            $db = Db::name('manager_evaluate')->where($where);
            $list = Db::name('manager_evaluate')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
            foreach ($list as $k => $v) {
                $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
                $list[$k]['subscribe_rate'] = 100*$v['subscribe_rate'].'%';
                $list[$k]['profit'] = $v['profit'].'%';
                $list[$k]['username'] = str_replace(', ','',$v['username']);
            }
            $count = Db::name('manager_evaluate')->where($where)->count();
            foreach($list as $k=>$v)
            {
                $list[$k]['dep'] = getDepartment($v['department']);
            }
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        isset($_GET['history']) ? $tem = 'manager2' : $tem = 'manager';

        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('users', Db::name('user')->field('id,user_name')->select());
        $this->assign("jurisdiction", $this->jurisdiction);
        $this->assign("month", db::name('plan_evaluate')->field('month')->group('month')->select());

        return $this->fetch($tem);
    }
    public function managers(Request $request)
    {
        $get = $request->get();
        $jurisdiction = $this->jurisdiction;
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $department = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department'); //项目

        if (isset($get['id'])) {

            if($jurisdiction == 2)
            {
                $where['userid'] = $_SESSION['think']['user_id'];
                $where['month'] = $month;
                $where['project_title'] = getProject();
                $list = Db::name('manager_evaluate')->where($where)->select();
                return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => 0, 'count' => 1, 'page' => 1]);
            }
            $where['del'] = -1;
            $log = [];
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $where['month'] = $month;
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            switch ($jurisdiction) {
                case 1:
                    break;

                case 8:
                    $where['department'] = $department;
                    break;
            }
            isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;
            $db = Db::name('manager_evaluate')->where($where);
            $list = Db::name('manager_evaluate')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
            foreach ($list as $k => $v) {
                $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
                $list[$k]['subscribe_rate'] = 100*$v['subscribe_rate'].'%';
                $list[$k]['profit'] = $v['profit'].'%';
                $list[$k]['username'] = str_replace(', ','',$v['username']);
            }
            $count = Db::name('manager_evaluate')->where($where)->count();
            foreach($list as $k=>$v)
            {
                $list[$k]['dep'] = getDepartment($v['department']);
            }
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        isset($_GET['history']) ? $tem = 'managers2' : $tem = 'managers';

        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('users', Db::name('user')->field('id,user_name')->select());
        $this->assign("jurisdiction", $this->jurisdiction);
        if($this->jurisdiction ==2)
        {
            $project_id = getProject();
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $project_id, 'month' => $month])->find();
            $this->assign("project_status", $this_aims['status']);
        }
        $this->assign("month", db::name('plan_evaluate')->field('month')->group('month')->select());
        return $this->fetch($tem);
    }

    /**
     * 策划
     *
     * @param Request $request
     * @return Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function plan(Request $request)
    {
        $role_title = $this->role_title;
        $manager_id = $this->user_id;
        $user_id = $this->user_id;
        $admin_id = 0;
        $manager_id = 0;
        switch ($this->jurisdiction) {
            case 1:
                $admin_id = $user_id;
                $manager_id = 0;
                break;
            case 2:
                $admin_id = 0;
                $manager_id = $user_id;
                break;
        }
        if (isset($_GET['id'])) {
            $where['del'] = -1;
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $where['month'] = $month;
            list($count, $page, $limit, $list) = PlanService::get_data($request, $where, $this->jurisdiction, $user_id);
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        $project_id = getProject();
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $project_id, 'month' => $month])->find();
        $project_status = $this_aims['status'];

        isset($_GET['history']) ? $tem = 'plan2' : $tem = 'plan';
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('manager_id', $manager_id);
        $this->assign('admin_id', $admin_id);
        $this->assign('users', Db::name('users')->where('del', 'neq', '1')->field('id,work_id,username')->select());
        $this->assign('role_title', $role_title);
        $this->assign('jurisdiction', $this->jurisdiction);
        $in_time = $this->in_time;
        $this->assign('in_time', $in_time);
        $this->assign('project_status', $project_status);
        return $this->fetch($tem);
    }

    public function plans(Request $request)
    {
        $role_title = $this->role_title;
        $manager_id = $this->user_id;
        $user_id = $this->user_id;
        $admin_id = 0;
        $manager_id = 0;
        switch ($this->jurisdiction) {
            case 1:
                $admin_id = $user_id;
                $manager_id = 0;
                break;
            case 2:
                $admin_id = 0;
                $manager_id = $user_id;
                break;
        }
        if (isset($_GET['id'])) {
            $where['del'] = -1;
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $where['month'] = $month;
            list($count, $page, $limit, $list) = PlanService::get_data($request, $where, $this->jurisdiction, $user_id);
            foreach($list as $k=>$v)
            {
                $list[$k]['dep'] = getDepartment($v['department']);
            }
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        $project_id = getProject();
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $this_aims = Db::name('aims')->field('id,number,status')->where(['project_title' => $project_id, 'month' => $month])->find();
        $project_status = $this_aims['status'];
        isset($_GET['history']) ? $tem = 'plans2' : $tem = 'plans';
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('manager_id', $manager_id);
        $this->assign('admin_id', $admin_id);
        $this->assign('users', Db::name('users')->where('del', 'neq', '1')->field('id,work_id,username')->select());
        $this->assign('role_title', $role_title);
        $this->assign('jurisdiction', $this->jurisdiction);
        $in_time = $this->in_time;
        $this->assign('in_time', $in_time);
        $timeType = db::name('plan_evaluate')->field('month')->group('month')->select();
        $this->assign('timeType', $timeType);
        $this->assign('project_status', $project_status);
        return $this->fetch($tem);
    }


    public function export()
    {
        $post = input("param.");
        //设置表头：
        $arr = ['编号', '事业部', '项目', '姓名', '工号', '认购得分', '自拓客户得分', '计划书得分', 'Erp录入得分', '总分','备注'];
        //数据中对应的字段，用于读取相应数据：
        $where['del'] = -1;
        $where['month'] = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        switch ($this->jurisdiction) {
            case 1: //
                (isset($post['project']) && $post['project'] != "0") && $where['project_title'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "0") && $where['department'] = array('in', $post['department']);

                break;
            case 2:
                $where['project_title'] = getProject();
            case 7:
            case 8:
                $where['department'] = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department');
                break;
        }
        $where['admin_submit'] = 2;
        $list = Db::name('employee_evaluate')->where($where)->select();
        if (empty($list)) {
            return json(['code' => 2, 'msg' => '没有可导出数据']);
        }
        foreach ($list as $k => $v) {
            $list[$k]['department'] = Db::name('framework')->where(['id' => $v['department']])->value('name');
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
        }
        $status = db::name('aims')->where(['project_title'=>getProject(),'month'=>$where['month']])->value('status');
        if($status<0)
        {
            $keys = ['id', 'department', 'project_title', 'username', 'work_id', 'subscribe_real', 'oln_score', 'work_book_score', 'erp_entry_score', 'total','mark'];
        }else{
            $keys = ['id', 'department', 'project_title', 'username', 'work_id', 'subscribe_score', 'oln_score', 'work_book_score', 'erp_entry_score', 'total','mark'];
        }
        $file = ExportService::outdata(date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) . "置业顾问考评", $list, $arr, $keys);
        return json(['code' => 1, 'msg' => '下载成功', 'url' => $file]);
    }

    /**
     * 策划
     *
     * @param Request $request
     * @return Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function aims(Request $request)
    {
        $role_title = $this->role_title;
        $manager_id = $this->user_id;
        $user_id = $this->user_id;
        $admin_id = 0;
        $manager_id = 0;
        $date = date('Y-m');
        $project = Db::name('project')->where(['status' => 1])->count();
        $aims = Db::name('aims')->where(['del' => -1])->select();
        $aims_count = Db::name('aims')->where(['month' => $date])->count();
        if ($aims_count != $project) {
            AimsService::create_aims_table();
        }
        if (isset($_GET['id'])) {
            $where['del'] = -1;
            list($count, $page, $limit, $list) = AimsService::get_data($request, $where, $this->jurisdiction, $user_id);
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('month',db::name('aims')->where('del','-1')->group('month')->select());
        $this->assign('framework_pid', $framework_pid);
        $this->assign('project_pid', $pro_pid);
        $this->assign('manager_id', $manager_id);
        $this->assign('admin_id', $admin_id);
        $this->assign('users', Db::name('user')->field('id,user_name')->select());
        $this->assign('role_title', $role_title);
        $this->assign('jurisdiction', $this->jurisdiction);
        return $this->fetch();
    }

    /**
     * 台账显示
     * @param Request $request
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ledger(Request $request)
    {
        $get = $request->get();
        if (isset($get['id'])) {
            $date = date('d');
        if($date>10)
        {
                return json(['code' => '0', 'msg' => 'ok', 'data' => 0, 'limit' => 0, 'count' => 0, 'page' => 0]);
        }
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            $db = Db::name('clerk_upload');
            if ($this->jurisdiction == 2) {
                $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

            } else {
                $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
                $project_name = $this_one['projectname'];
            }
            $where=[];
            switch ($this->jurisdiction) {
                case 1:
                    break;
                case 2:
                    $where['project']=$project_name;
                    break;
                case 5:
                    $where['user_id'] =$this->user_id;
                    $where['project'] = $project_name;
                    break;
            }
            $list = $db->where($where)->limit($tol, $limit)->fetchSql(false)->where(['month'=>$month,'del'=>-1])->select();
            foreach ($list as $k => $v) {
                $list[$k]['project'] = Db::name('project')->where(['id' => $v['project']])->value('name');
            }
            $count = Db::name('clerk_upload')->where($where)->where(['month'=>$month,'del'=>-1])->count();
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('users', Db::name('user')->field('id,user_name')->select());
        $jurisdiction = $this->jurisdiction;
        $this->assign("month", db::name('clerk_upload')->field('month')->group('month')->select());
        return $this->fetch('', compact('pro_pid', 'framework_pid', 'jurisdiction'));
    }

    /**
     * 台账显示
     * @param Request $request
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function labor_costs(Request $request)
    {
        //
        $get = $request->get();
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $project_name = Db::name('project')->where(['manager' => $_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
        self::create_labor_table($project_name, $month);
        if (isset($get['id'])) {
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            $db = Db::name('months_costs');

            switch ($this->jurisdiction) {
                case 1:
                    break;
                case 2:
                    $where['project'] = $project_name;
                    break;
                    //                case 5:
                    //                    $where['user_id'] = $this->user_id;
                    //                    $where['project'] = $project_name;
                    //                    break;
            }
            $where['month'] = $month;
            $list = Db::name('months_costs')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
            foreach ($list as $k => $v) {
                $list[$k]['project'] = Db::name('project')->where(['id' => $v['project']])->value('name');
            }
            $count = Db::name('months_costs')->where($where)->count();
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        $this->assign('users', Db::name('user')->field('id,user_name')->select());
        return $this->fetch('', compact('pro_pid', 'framework_pid'));
    }


    /***
     * 理�?�利�?
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function profit(Request $request)
    {
        $get = $request->get();
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $project_name = getProject(); //项目
        if (isset($get['id'])) {
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            $db = Db::name('profit');
            switch ($this->jurisdiction) {
                case 1:
                    break;
                case 2:
                    $db->where(['project_name' => $project_name]);
                    break;
            }
            $list = $db->where(['month' => $month])->limit($tol, $limit)->fetchSql(false)->select();
            foreach ($list as $k => $v) {
                $list[$k]['project_name'] = Db::name('project')->where(['id' => $v['project_name']])->value('name');
                $list[$k]['labor_costs'] = round($v['labor_costs'],3);
                $list[$k]['second_money'] = round($v['second_money'],3);
                $list[$k]['second_money2'] = round($v['second_money2'],3);
                $list[$k]['group_management_money'] = round($v['group_management_money'],3);
                $list[$k]['taxes_money'] = round($v['taxes_money'],3);
                $list[$k]['total_profit'] = round($v['total_profit'],3);
                $list[$k]['subsidies'] = round($v['subsidies'],3);
                $list[$k]['agency_rate'] = round($v['agency_rate'],3);
                $list[$k]['turnover'] = round($v['turnover'],3);
                $list[$k]['commission_ratio'] = round($v['commission_ratio'],3);

            }
            $count = $db->where(['month' => $month])->count();
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        $jurisdiction = $this->jurisdiction;
        $this_profit = db::name('profit')->where(['project_name'=>$project_name,'month'=>$month])->find();
        if (!empty($this_profit)){
            $this_profit['project_title'] = Db::name('project')->where(['id' => $this_profit['project_name']])->value('name');
            isset($this_profit['agency_rate']) && $this_profit['agency_rate']=(100 * $this_profit['agency_rate']);
            isset($this_profit['margin_rate'])&& $this_profit['margin_rate'] = (100 *$this_profit['margin_rate']);
            isset($this_profit['commission_ratio'])&&$this_profit['commission_ratio'] = (100*$this_profit['commission_ratio']);
            isset($this_profit['taxes_rate'])&& $this_profit['taxes_rate']= (100 * $this_profit['taxes_rate']);
            isset($this_profit['total_profit'])&& $this_profit['total_profit']= $this_profit['total_profit'];
        }
         switch ($this->jurisdiction) {
                case 1:
                    list($pro_pid, $framework_pid) = EmployeeService::frame_project();
                    $this->assign('users', Db::name('user')->field('id,user_name')->select());
                    $this->assign('month',db::name('profit')->where('del','-1')->group('month')->select());
                    return $this->fetch('', compact('pro_pid', 'framework_pid','this_profit', 'jurisdiction'));
                case 2:
                    if(ProfitService::labor_cost_calculation($project_name)){
                        list($total_number, $total_money) = ProfitService::labor_cost_calculation($project_name);
                    }else{
                        echo "<script>alert('请先添加人员');</script>";die;
                    }
                    list($pro_pid, $framework_pid) = EmployeeService::frame_project();
                    $this->assign('users', Db::name('user')->field('id,user_name')->select());
                    $this->assign('month',db::name('profit')->where('del','-1')->group('month')->select());
                    return $this->fetch('', compact('total_money', 'total_number','pro_pid', 'framework_pid','this_profit', 'jurisdiction'));
                    break;
            }
    }

    public function work()
    {
        if (!empty($_GET['id'])) {
            if (!empty($_POST['search_field'])) {
                $where['username'] = array('like', '%' . $_POST["search_field"] . '%');
            }
            if (!isset($where)) {
                $where = '1=1';
            }
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol = ($page - 1) * $limit;
            if ($this->jurisdiction == 2) {
                $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

            } else {
                $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
                $project_name = $this_one['projectname'];
            }
            switch ($this->jurisdiction) {
                case 1:
                    $count = Db::name('work_book')->where($where)->count();

                    $list = Db::name('work_book')->where($where)->order('id desc')->limit($tol, $limit)->select();
                    break;
                case 2:
                    $count = Db::name('work_book')->where($where)->where(['project_title' => $project_name])->count();

                    $list = Db::name('work_book')->where($where)->where(['project_title' => $project_name])->order('id desc')->limit($tol, $limit)->select();
                    break;
                case 5:
                    $count = Db::name('work_book')->where($where)->where(['userid' => $_SESSION['think']['user_id']])->count();

                    $list = Db::name('work_book')->where($where)->where(['userid' => $_SESSION['think']['user_id']])->order('id desc')->limit($tol, $limit)->select();
                    break;
            }

            foreach ($list as $key => $val) {
                $list[$key]['project_title'] = Db::name('project')->where(['id' => $val['project_title']])->value('name');
            }
            return ["code" => "0", "msg" => "", "count" => $count, "data" => $list];
        }
        $jurisdiction = $this->jurisdiction;
        return $this->fetch("", compact('jurisdiction'));
    }

    /*
 * 工作提报添加
 * */
    public function work_add()
    {
        if (Request::instance()->isPost()) {

            if (!empty($_POST['id'])) {
                if (Db::name('work_book')->update($_POST)) {
                    $data['code'] = 1;
                    $data['msg'] = '�?改成�?';
                } else {
                    $data['code'] = 0;
                    $data['msg'] = '�?改失�?';
                }
            } else {
                $_POST['userid'] = $_SESSION['think']['user_id'];
                $users = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->find();
                if (!empty($users)) {
                    $_POST['username'] = $users['username'];
                } else {
                    $_POST['username'] = Db::name('users')->where('id', $_SESSION['think']['user_id'])->value('user_name');
                }
                if ($this->jurisdiction == 2) {
                    $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

                } else {
                    $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
                    $project_name = $this_one['projectname'];
                }
                $_POST['project_title'] = $project_name; //项目
                if (Db::name('work_book')->insert($_POST)) {
                    $data['code'] = 1;
                    $data['msg'] = '添加成功';
                } else {
                    $data['code'] = 0;
                    $data['msg'] = '添加失败';
                }
            }
            return json($data);
        }
        if (!empty($_GET['id'])) {
            $this->assign('list', Db::name('work_book')->where('id', $_GET['id'])->find());
        }
        return $this->fetch();
    }

    public function add_user()
    {
        $date1 = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
        if ($this->request->isPost()) {
            $post = input('param.');
            $one_user = Db::name('users')->field('work_id,username,department,station')->where(['id' => $post['users_id']])->find();
            $work_id = $one_user['work_id'];
            $username = $one_user['username'];
            $full = $work_id . sysconf('username_break') . $username;
            $data = [
                'project_title' => $project_name, //本项目
                'username' => $full, //全名：工号+姓名
                'userid' => $post['users_id'], //员工id
                'month' => $date1, //月份
                'station' => 21, //岗位id
                'department' => $one_user['department'],
                'work_id' => $work_id,
            ];
            try {
                Db::name('employee_evaluate')->insertGetId($data);
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '添加人员成功']);
        }


        $date = Db::name('role')->where('status', 1)->select();
        $this->assign('role', $date);

        $user_ids = Db::name('employee_evaluate')->where(['project_title' => $project_name, 'month' => $date1])->column('userid');
        $value = Db::name('users')
            ->where(['del' => '-1', 'is_quit' => -1])
            //            ->whereNotIn('id', $user_ids)
            ->select();
        $this->assign('users', $value);
        return $this->fetch();
    }

    /*
 * 角色删除
 * */
    public function work_del()
    {
        if (Db::name('work_book')->where('id=' . input('id'))->delete()) {
            $info = array('code' => 1, 'msg' => '删除成功');
        } else {
            $info = array('code' => 0, 'msg' => '删除失败');
        }
        return json($info);
    }

    public function tests()
    {
        $dbObj = Db::connect('erp_databases');
        $info = $dbObj->table('b_project')->select();
        dd($info);
    }

    public function tests1()
    {
        $dd = db::name('users')->field('username')->select();
        foreach($dd as $k=>$v)
        {
            echo preg_replace('|[0-9a-zA-Z/]+|','',trim($v['username']));
        }

    }


    public function ceshi()
    {
        $planInfo = db::name('maintain')->select();
        foreach($planInfo as $k=>$v)
        {
            $v['project'] = $v['pid'];
            $v['project_name'] = getName('3',$v['pid']);
            dd($v);
        }
    }



    public function addlogss()
    {
        addlogs('lkjklj',session('user_id'));
    }

    public function getWhere()
    {
        $pid = db::name('maintain')->field('pid')->where('station',21)->group('pid')->select();
        foreach($pid as $k)
        {
            $date[] = $k['pid'];
        }
        return $date;
    }
    public function getDepartment($id=19)
    {
        $list = [
            '19' => '事业一部',
            '20' => '事业三部',
            '21' => '事业四部',
            '22' => '事业五部',
            '24' => '事业六部',
            '25' => '营业一部',
            '26' => '营业二部',
            '61' => '事业五部（青岛）',

        ];
        return $list[$id];
    }
}
