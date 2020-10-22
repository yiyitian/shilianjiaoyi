<?php


namespace app\rackstage\service;


use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;
use think\Request;

/**
 * 置业顾问
 * Class EmployeeService
 * @package app\rackstage\service
 */
class ManagerService
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
                $employee = Db::name('manager_evaluate')->where(['admin_id' => $user_id, 'admin_submit' => 1])->select();
                list($arr['employee'], $arr['ty']) = [$employee, 1];
                break;
            case 2:
                $employee = Db::name('manager_evaluate')->where(['manager_id' => $user_id, 'is_submit' => 1])->select();
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
    public static function get_data(Request $request, $where, $role_title)
    {

        switch ($role_title) {
            case 1:
                isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;

                break;
            case 2:
//                isset($_GET['history']) ? $where['is_submit'] = 2 : $where['is_submit'] = 1;
        $where['userid']=$$_SESSION['think']['user_id'];
//
                break;
        }
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;

        $value = Db::name('project')->where('manager', $_SESSION['think']['user_id'])->value('name');
        $value1 = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department');
        switch ($role_title) {
            case 1:

                break;
            case 2:
            case 7:

            $where['project_title'] = $value;//项目
                break;
            case 8:

                $where['department'] = $value1;//项目
                break;
        }
         $db = Db::name('manager_evaluate')->where($where);

        $list = $db->limit($tol, $limit)->fetchSql(false)->select();

        foreach ($list as $k => $v) {
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
        }
        $count = $db->count();
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
            Db::name('manager_evaluate')->update($data);

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
        $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id');//项目
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
        $one = Db::name('manager_evaluate')->where(['id' => $info['id']])->find();
        $one=set_zero($one,['work_book_score','subscribe_score','authenticity','profit_score','develop_costume']);
        $develop_costume=$one['develop_costume'];
        $work_book_score=$one['work_book_score'];
   
        $total=$one['subscribe_score']+$one['authenticity']+$one['visiting_score']+$one['profit_score']+$work_book_score+$develop_costume;
        $data = ['total' => $total, 'total_real' => $total];
//        switch ($j) {
//            case 1:
////                $data['admin_id'] = $admin_id;
//                $data['admin_submit'] =2;
//                break;
////            case 2:
////                $data['manager_id'] = $manager_id;
////                break;
//        }
        Db::name('manager_evaluate')->where(['id' => $info['id']])->update($data);//
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