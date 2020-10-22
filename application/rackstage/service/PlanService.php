<?php


namespace app\rackstage\service;

use app\rackstage\model\ErpBalance;
use app\rackstage\model\ErpCostume;
use app\rackstage\model\ErpProject;
use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;
use think\Request;

/**
 * 置业顾问
 * Class EmployeeService
 * @package app\rackstage\service
 */
class PlanService
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
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        switch ($role_title) {
            case 1:
                $employee = Db::name('plan_evaluate')->where(['admin_id' => $user_id, 'admin_submit' => 1, 'month' => $month, 'is_submit' => 2])->select();
                list($arr['employee'], $arr['ty']) = [$employee, 1];
                break;
            case 2:
                $employee = Db::name('plan_evaluate')->where(['manager_id' => $user_id, 'is_submit' => 1, 'month' => $month])->select();

                list($arr['employee'], $arr['ty']) = [$employee, 2];
                break;
        }
        if (empty($employee)) {
            echo json_encode(['code' => 2, 'msg' => '没有需要提交的数据']);
            die;
        }
        self::employee_separate($employee, $role_title);
    }

    /**
     * 获取打分记录
     * @param Request $request
     * @param $where
     * @param $role_title
     * @param $user_id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get_data(Request $request, $where, $role_title, $user_id)
    {
        if ($role_title == 2) {
            $project_name = getProject();
        } else {
            $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
            $project_name = $this_one['projectname'];
        }
        $department = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department'); //项目
        switch ($role_title) {
            case 1://管理员
                isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;
                break;
            case 2://项目经理
                isset($_GET['history']) ? $where['is_submit'] = 2 : $where['is_submit'] = 1;
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
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        switch ($role_title) {
            case 1:
                $where['is_submit'] = 2;
                break;
            case 2:
                $where['project_title'] = $project_name;//项目
                break;
        }

        $list = Db::name('plan_evaluate')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['username'] = str_replace(', ','',$v['username']);
            if($v['subscribe_rate']!==null)
            {
                $list[$k]['subscribe_rate'] = 100*$v['subscribe_rate'].'%';

            }
           if($v['profit']!==null)
            {
                $list[$k]['profit'] = $v['profit'].'%';

            }
            if($v['visiting_score']==null)
            {
                $list[$k]['visiting_score'] = "";

            }  if($v['profit_score']==null)
            {
                $list[$k]['profit_score'] = "0";

            }
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');

        }
        $count = Db::name('plan_evaluate')->where($where)->count();
        return array($count, $page, $limit, $list);
    }
    public static function get_datas(Request $request, $where, $role_title, $user_id)
    {
//        if ($role_title == 2) {
//            $project_name = getProject();
//        } else {
//            $this_one = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();
//            $project_name = $this_one['projectname'];
//        }
        //$department = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department'); //项目
        switch ($role_title) {
            case 1://管理员
                isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;
                break;
            case 2://项目经理
                isset($_GET['history']) ? $where['is_submit'] = 2 : $where['is_submit'] = 1;
                break;
//            case 7://部门秘书
//                $where['admin_submit'] = 2;
//                $where['project_title'] = $project_name;
//                break;
//            case 8://部门秘书
//                $where['admin_submit'] = 2;
//                $where['department'] = $department;
//                break;
        }
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        switch ($role_title) {
            case 1:
                $where['is_submit'] = 2;
                break;
//            case 2:
//                $where['project_title'] = $project_name;//项目
//                break;
        }

        $list = Db::name('plan_evaluate')->where($where)->limit($tol, $limit)->fetchSql(false)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['username'] = str_replace(', ','',$v['username']);
            if($v['subscribe_rate']!==null)
            {
                $list[$k]['subscribe_rate'] = 100*$v['subscribe_rate'].'%';

            }
            if($v['profit']!==null)
            {
                $list[$k]['profit'] = $v['profit'].'%';

            }
            if($v['visiting_score']==null)
            {
                $list[$k]['visiting_score'] = "";

            }  if($v['profit_score']==null)
        {
            $list[$k]['profit_score'] = "0";

        }
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');

        }
        $count = Db::name('plan_evaluate')->where($where)->count();
        return array($count, $page, $limit, $list);
    }

    /**
     *
     * @param $role_title
     * @param $arr
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function employee_separate($arr, $role_title)
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        foreach ($arr as $k => $v) {
            $this_project = Db::name('project')->find($v['project_title']);
            $erp_project = (new ErpProject())->get_project(['project_name' => $this_project['name']]);
            $where = ["project_id" => $erp_project['project_id']];
            $total_oln = (new ErpCostume())->get_one_oln(['project_id' => $erp_project['project_id']]);//来访人数
            $this_evaluate = Db::name('plan_evaluate')->find($v['id']);
            $this_project = Db::name('project')->field('type,aims,name,status')->where(['id' => $v['project_title']])->find();
            $this_aims = Db::name('aims')->field('id,number,username')->where(['project_title' => $v['project_title'], 'month' => $month])->find();//月认购额目标
            //月度目标
            $subscribe_real = 0;//
            $subscribe_rate = 0;//认购目标完成
            $profit = 0;//理论利润
            $work_book_score = 0;//计划书
            $visit_real_score = 0;//来访人数得分
            $profit_score = 0;//理论利润得分
            $total_subscribe = 0;//认购金额
            $develop_costume = 0;//拓客
            switch ($this_project['status']) {
                case '1':
                    $total_subscribe = (new ErpBalance())->get_order_turnover($where);
                    $number = calc($this_aims['number'], 10000, 'mul', 2);//月度购额
                    $subscribe_rate = calc($total_subscribe, $number, 'div', 2); //月度认购完成率
                    $subscribe_rate > (float)sysconf('subscribe_complete') ? $subscribe_real = 30 : $subscribe_real = 0; //认购完成得分
                    if($v['subscribe_real']>$subscribe_real)
                {
                    $date['manager_score'] = -1;
                    $date['color1'] = 'red';
                }else{
                        $date['color1'] = 'black';
                    }
                    ($this_evaluate['visiting_aims'] < $total_oln) ? $visit_real_score = 40 : $visit_real_score = 0; //来访
                    if((int)$v['visiting_score'] > $visit_real_score)
                    {
                        $date['manager_score'] = -1;
                        $date['color2'] = 'red';
                    }else{
                        $date['color2'] = 'black';
                    }

                    $profit = Db::name('profit')->where(['project_name' => $v['project_title'], 'month' => $month])->value('total_profit'); ////获得项目理论利润
                    $profit > 0 ? $profit_score = 30 : $profit_score = 0;

                    if($v['profit_score']>$profit_score)
                    {
                        $date['manager_score'] = -1;
                        $date['color3'] = 'red';
                    }else{
                        $date['color3'] = 'black';
                    }

                    break;
                case '-1'://蓄客
                    $rate = calc($total_oln, $this_aims['visiting'], 'div', 2);
                    $rate > 0.5 ? $develop_costume = 50 : $develop_costume = 0;
                    $work_book_score = $this_evaluate['work_score'];
                    break;
            }

            $total_real = $subscribe_real + $visit_real_score + $profit_score + $work_book_score + $develop_costume;
            $total =  (int)$v['visiting_score'] +$profit_score + $subscribe_real;
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
                'subscribe_money' => $total_subscribe,
                'subscribe_rate' => $subscribe_rate, //认购完成率
                'subscribe_real' => $subscribe_real, //认购完成得分
                'visiting' => $total_oln, //来访人数
                'visiting_real_score' => $visit_real_score, //来访完成真实得分
                'profit' => $profit, //理论利润
                'total_real' => $total_real, //总得分
                'total' => $total,
                'profit_score'=> $profit_score,
                'result' => $result //得分结果
            ];
            $this_evaluate = Db::name('plan_evaluate')->field('visiting_score,manager_score,back')->find($v['id']);
            if ($visit_real_score != $this_evaluate['visiting_score'] && $role_title == 2) {
                $data['manager_score'] = $this_evaluate['manager_score'] - 1;
                $data['color'] = 'red';
            }
            switch ($role_title) {
                case 1:
                    $data['admin_submit'] = 2;
                    break;
                case 2:
                    $data['is_submit'] = 2;
                    break;
            }

            if(isset($date))
            {
                $data  = $data+$date;
            }

            Db::name('plan_evaluate')->update($data);
            if ($this_evaluate['back'] == 0) {
                Db::name('aims')->where(['id' => $this_aims['id']])->setInc('plan_complete');
            }
        }
    }







    public static function employee_separates($arr, $role_title)
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        foreach ($arr as $k => $v) {
            if($v['project_title']=='309') continue;
            $this_project = Db::name('project')->find($v['project_title']);
            $erp_project = (new ErpProject())->get_project(['project_name' => $this_project['name']]);
            $where = ["project_id" => $erp_project['project_id']];
            $total_oln = (new ErpCostume())->get_one_oln(['project_id' => $erp_project['project_id']]);//来访人数
            $this_evaluate = Db::name('plan_evaluate')->find($v['id']);
            $this_project = Db::name('project')->field('type,aims,name,status')->where(['id' => $v['project_title']])->find();
            $this_aims = Db::name('aims')->field('id,number,username')->where(['project_title' => $v['project_title'], 'month' => $month])->find();//月认购额目标
            //月度目标
            $subscribe_real = 0;//
            $subscribe_rate = 0;//认购目标完成
            $profit = 0;//理论利润
            $work_book_score = 0;//计划书
            $visit_real_score = 0;//来访人数得分
            $profit_score = 0;//理论利润得分
            $total_subscribe = 0;//认购金额
            $develop_costume = 0;//拓客
            switch ($this_project['status']) {
                case '1':
                    $total_subscribe = (new ErpBalance())->get_order_turnover($where);
                    $number = calc($this_aims['number'], 10000, 'mul', 2);//月度购额
                    $subscribe_rate = calc($total_subscribe, $number, 'div', 2); //月度认购完成率
                    $subscribe_rate > (float)sysconf('subscribe_complete') ? $subscribe_real = 30 : $subscribe_real = 0; //认购完成得分
                    if($v['subscribe_real']>$subscribe_real)
                    {
                        $date['manager_score'] = -1;
                        $date['color1'] = 'red';
                    }else{
                        $date['color1'] = 'black';
                    }
                    ($this_evaluate['visiting_aims'] < $total_oln) ? $visit_real_score = 40 : $visit_real_score = 0; //来访
                    if((int)$v['visiting_score'] > (int)$visit_real_score)
                    {                        $date['manager_score'] = -1;

                        $date['color2'] = 'red';
                    }else{
                        $date['color2'] = 'black';
                    }

                    $profit = Db::name('profit')->where(['project_name' => $v['project_title'], 'month' => $month])->value('total_profit'); ////获得项目理论利润
                    $profit > 0 ? $profit_score = 30 : $profit_score = 0;

                    if($v['profit_score']>$profit_score)
                    {
                        $date['manager_score'] = -1;
                        $date['color3'] = 'red';
                    }else{
                        $date['color3'] = 'black';
                    }

                    break;
                case '-1'://蓄客
                    $rate = calc($total_oln, $this_aims['visiting'], 'div', 2);
                    $rate > 0.5 ? $develop_costume = 50 : $develop_costume = 0;
                    $work_book_score = $this_evaluate['work_score'];
                    break;
            }
            $total_real = $subscribe_real + $visit_real_score + $profit_score + $work_book_score + $develop_costume;
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
                'subscribe_money' => $total_subscribe,
                'subscribe_rate' => $subscribe_rate, //认购完成率
                'subscribe_real' => $subscribe_real, //认购完成得分
                'visiting' => $total_oln, //来访人数
                'visiting_real_score' => $visit_real_score, //来访完成真实得分
                'profit' => $profit, //理论利润
                'total_real' => $total_real, //总得分
                'profit_score'=> $profit_score,
                'result' => $result //得分结果
            ];
            $this_evaluate = Db::name('plan_evaluate')->field('visiting_score,manager_score,back')->find($v['id']);
            if ($visit_real_score != $this_evaluate['visiting_score'] && $role_title == 2) {
                $data['manager_score'] = $this_evaluate['manager_score'] - 1;
                $data['color'] = 'red';
            }else{
                $data['color'] = 'black';
            }
            switch ($role_title) {
                case 1:
                    $data['admin_submit'] = 2;
                    break;
                case 2:
                    $data['is_submit'] = 2;
                    break;
            }
            if(isset($date))
            {
                $data  = $data+$date;
            }
            Db::name('plan_evaluate')->update($data);
            if ($this_evaluate['back'] == 0) {
                Db::name('aims')->where(['id' => $this_aims['id']])->setInc('plan_complete');
            }
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
     * @return mixed
     */
    public static function insert_where($role_title, $where)
    {
        $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
        switch ($role_title) {
            case '项目经理':
                $where['project_title'] = $project_name;
                break;
            case '总管理员':
                break;
        }
        return $where;
    }

    /**
     * @param $info
     * @param $field
     * @param $manager_id
     * @param $j
     * @param $admin_id
     * @return int|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function total_score($info, $manager_id, $admin_id, $j)
    {
        $one = Db::name('plan_evaluate')->where(['id' => $info['id']])->find();
        $one=set_zero($one,['work_book_score','profit_score','visiting_score']);
       

          $total = $one['visiting_score']  + $one['work_book_score']+$one['profit_score'];
         
         
        $data = ['total' => $total, 'visiting_score' => $one['visiting_score']];


        switch ($j) {
            case 1:
                $data['admin_id'] = $admin_id;
                break;
            case 2:
                $data['manager_id'] = $manager_id;
                break;
        }

        Db::name('plan_evaluate')->where(['id' => $info['id']])->update($data); //
    }

    /**
     * @param \think\File $info
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public static function import_costume($saveName)
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
            $count = Db::name('costume')->where(['project_title' => $v[1], 'costume' => $v[2], 'phone' => $v[4]])->count();
            if ($count == 0) {
                $log[] = [
                    'project_title' => $v[1],
                    'costume' => $v[2],
                    'phone' => $v[4],
                    'source' => $v[6],
                    'date' => $v[3],
                    'employee' => $v[7],
                ];
            }
        }
        Db::name('costume')->insertAll($log);
    }
}
