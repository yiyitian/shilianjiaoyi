<?php


namespace app\rackstage\service;


use app\rackstage\model\Project;
use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;
use think\Request;

/**
 * 置业顾问
 * Class EmployeeService
 * @package app\rackstage\service
 */
class AimsService
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
                $employee = Db::name('plan_evaluate')->where(['admin_id' => $user_id, 'admin_submit' => 1])->select();
                list($arr['employee'], $arr['ty']) = [$employee, 1];
                break;
            case 2:
                $employee = Db::name('plan_evaluate')->where(['manager_id' => $user_id, 'is_submit' => 1])->select();
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
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;

$where['month']=date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        switch ($role_title) {
            case 1:
                break;
            case 2:
                $info = db::name('project')->field('id')->where(['manager'=>$_SESSION['think']['user_id']])->select();
                $where['project_title'] = ['in',array_reduce($info, create_function('$v,$w', '$v[$w["id"]]=$w["id"];return $v;'))];
                
                break;
        }
        $db = Db::name('aims')->where($where);
        $list = $db->limit($tol, $limit)->fetchSql(false)->select();
        foreach ($list as $k => $v) {
            $list[$k]['projectId'] =$v['project_title'];
            $proArray = Db::name('project')->where(['id' => $v['project_title']])->find();
            $list[$k]['project_title'] = $proArray['name'];
            $userId = db::name('users')->where('user_id',$proArray['manager'])->find();
            db::name('aims')->where($where)->update(['username'=>$userId['work_id'] . sysconf('username_break') . $userId['username']]);
            $list[$k]['username'] = $userId['work_id'] . '&nbsp;' . $userId['username'];

        }
        $count = Db::name('aims')->where($where)->fetchSql(false)->count();
        return array($count, $page, $limit, $list);
    }

     public static function get_datas(Request $request, $where, $role_title, $user_id)
    {
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        
        switch ($role_title) {
            case 1:
                break;
            case 2:
                $info = db::name('project')->field('id')->where(['manager'=>$_SESSION['think']['user_id']])->select();
                $where['project_title'] = ['in',array_reduce($info, create_function('$v,$w', '$v[$w["id"]]=$w["id"];return $v;'))];
                
                break;
        }
        $db = Db::name('aims')->where($where);

        $list = $db->limit($tol, $limit)->fetchSql(false)->select();
        foreach ($list as $k => $v) {
            $list[$k]['projectId'] =$v['project_title'];
            $proArray = Db::name('project')->where(['id' => $v['project_title']])->find();

            $list[$k]['project_title'] = $proArray['name'];
            $userId = db::name('users')->where('user_id',$proArray['manager'])->find();
            db::name('aims')->where($where)->update(['username'=>$userId['work_id'] . sysconf('username_break') . $userId['username']]);
            $list[$k]['username'] = $userId['work_id'] . '&nbsp;' . $userId['username'];
        }
        $count = Db::name('aims')->where($where)->fetchSql(false)->count();
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
//        $ty = $arr['ty'];

        foreach ($arr as $k => $v) {
            $total_subscribe = Db::name('performance')->where(['username' => $v['username']])->sum('number');//
            $total_oln = Db::name('costume')->where(['employee' => $v['username']])->count();//来访人数
            $this_project = Db::name('project')->field('type,aims')->where(['id' => $v['project_title']])->find();
            ($this_project['aims'] > $total_subscribe) ? $subscribe_real = 0 : $subscribe_real = 30;//认购完成得分
            $number = '';
            ($number < $total_oln) ? $visit_real_score = 0 : $visit_real_score = 30;//来访


            $profit_score = (int)3;
            $total_real = $subscribe_real + $visit_real_score + $profit_score;
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
            $data = ['id' => $v['id'], 'total_real' => $total_real, 'result' => $result];
            switch ($role_title) {
                case 1:
                    $data['admin_submit'] = 2;
                    break;
                case 2:
                    $data['is_submit'] = 2;
                    break;
            }
            Db::name('plan_evaluate')->update($data);

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
        $framework_id = Db::name('project')->where('del', 'neq', '1')->where('status', 1)->column('framework_id');//项目
        $pro_pid = Db::name('framework')->field('id,pid,name')->whereIn('id', array_unique($framework_id))->select();//获取项目所有
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
        if ($role_title==2){
            $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

        }else{
            $this_one=Db::name('users')->where(['user_id'=>$_SESSION['think']['user_id']])->find();
            $project_name=$this_one['projectname'];
        }
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
        $one = Db::name('aims')->where(['id' => $info['id']])->find();


        switch ($j) {
            case 1:
                $data['admin_id'] = $admin_id;
                break;
            case 2:
                $data['manager_id'] = $manager_id;
                break;
        }
        Db::name('plan_evaluate')->where(['id' => $info['id']])->update($data);//
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

    public static function create_aims_table()
    {
        $date = date('Y-m');
        $aims_count = Db::name('aims')->where(['month' => $date])->count();
        $project = Db::name('project')->where(['status' => 1])->count();
        $aims=Db::name('aims')->where(['del'=>-1])->select();
        if ($aims_count!=$project){

            Project::where(['status' => 1,'del'=>-1])->chunk(50, function ($data) use ($date) {
                $log = [];
                foreach ($data as $k1 => $v1) {
                    $manager=Db::name('users')->where(['user_id'=>$v1['manager']])->find();
                    if (empty($manager)) {
                        $full = '暂无';
                    } else {
                        $full = $manager['work_id'] . sysconf('username_break') . $manager['username'];
                    }
                    if (Db::name('aims')->where(['month' => $date, 'project_title' => $v1['id']])->count() == 0) {
                        $log[] = [
                            'project_title' => $v1['id'],
                            'username' => $full,
                            'station' => 16,
                            'month' => $date,
                            'user_id' => $v1['manager'],
                            'department' => $v1['framework_id'],
                            'plan_total' => Db::name('users')->whereIn('station', [14, 15])->where(['projectname' => $v1['id'], 'is_quit' => -1])->count(),
                            'employee_total' => Db::name('users')->where(['station' => 19, 'projectname' => $v1['id'], 'is_quit' => -1])->count(),
                            'clerk_total' => Db::name('users')->where(['station' => 21, 'projectname' => $v1['id'], 'is_quit' => -1])->count(),
                        ];
                    }
                }
                Db::name('aims')->insertAll($log);
            });

        }

         //die;

    }
}