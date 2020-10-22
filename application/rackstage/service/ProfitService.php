<?php


namespace app\rackstage\service;


use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;
use think\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * 置业顾问
 * Class EmployeeService
 * @package app\rackstage\service
 */
class ProfitService
{
    public static function labor_cost_calculation($project_name)
    {
        $Info = Db::name('maintain')->where(['pid' => $project_name])->fetchSql(false)->select();
        if(self::getTotal($Info))
        {
            return [Db::name('maintain')->where(['pid' => $project_name])->fetchSql(false)->count(),self::getTotal($Info) ];
        }else{
            return false;
        }
    }


    public static function getTotal($info)
    {
        $month = strtotime(date('Y-m', strtotime(date('Y-m-01') . " - 1 month")));
        $days = date('t',$month );
        foreach($info as $k=>$v)
        {
            switch($v['station'])
            {
                case 21:
                    $date = (float)0.43;
                    break;
                case 15:
                    $date = (float)0.46;
                    break;
                case 14:
                    $date = (float)0.62;
                    break;
                case 44:
                    $date = (float)0.78;
                    break;
                case 19:
                    $date = (float)0.33;
                    break;
                case 18:
                    $date = (float)0.38;
                    break;
                case 17:
                    $date = (float)0.47;
                    break;
                case 16:
                    $date = (float)0.57;
                    break;
                case 13:
                    $date = (float)1.03;
                    break;
            }
            if($v['status'] ==='禁用')
            {
                if(strtotime($v['addtime'])>=$month)
                {
                    $timediff = strtotime($v['stoptime']) - strtotime($v['addtime']);
                    $cha = intval($timediff / 86400)+1;
                }else{
                    $cha = $cha =  date('d',strtotime($v['stoptime']));
                }

                $data[$k] = bcmul(bcdiv($date,$days,2),$cha,2);
            }else{
                $data[$k] = $date;
            }
        }
        if(isset($data))
        {
            return array_sum($data);
        }else{
            return false;
        }

    }

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

        switch ($role_title) {
            case 1:
                isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;

                break;
            case 2:
                isset($_GET['history']) ? $where['is_submit'] = 2 : $where['is_submit'] = 1;

                break;
        }
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        $db = Db::name('plan_evaluate')->where($where);

        switch ($role_title) {
            case 1:
                break;
            case 2:
                $where['project_title'] = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id');//项目
                break;
        }

        $list = $db->limit($tol, $limit)->fetchSql(false)->select();
        foreach ($list as $k => $v) {
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
        $project_name =Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id');//项目
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
        $data = ['total' => $one['visiting_score'], 'visiting_score' => $one['visiting_score']];


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
        $aims_id = Db::name('aims')->where(['month' => date('Y-m')])->column('user_id');
        $users = Db::name('users')->field('id,username,work_id,projectname,station')->whereIn('station', [14, 15])->whereNotIn('id', $aims_id)->select();
        $log = [];
        foreach ($users as $k => $v) {
            $log[] = [
                'project_title' => $v['projectname'],
                'username' => $v['work_id'] . ', ' . $v['username'],
                'station' => $v['station'],
                'month' => date('Y-m'),
                'user_id' => $v['id']
            ];
        }
        Db::name('aims')->insertAll($log);
    }
  // 导出商家列表
public  function excelStore($arr,$list)
{
    ini_set('memory_limit', '-1');
    // 读取数据到数组
  
    if (empty($list)) {
        $this->error = '没有数据';
        return false;
    }
  
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // 设置工作表标题名称
    $sheet->setTitle('商家数据表');
    // 表头
    // 设置单元格内容
    
    
$count=count($arr);
    for($i=1;$i<=$count-1;$i++){
        $sheet->setCellValueByColumnAndRow($i, 1, $arr[$i]);
    
    }   //第一个参数代表列 第二个参数代表行  第三个参数代表表格里的内容
   

    // 设置列宽
    $sheet->getColumnDimension('A')->setWidth(20);       
    // $sheet->getColumnDimension('B')->setWidth(20);
    // $sheet->getColumnDimension('C')->setWidth(20);

    // $sheet->mergeCells('A1:E1');   //合并单元格   从第一行的A 一直合并到第一行的E 
     
    //  //设置字体样式  不多说   自行脑补  
    // $styleArray = [
    //     'font' => [
    //         'bold' => true
    //     ],
    //     'alignment' => [
    //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    //     ]
    // ];
    // // 设置单元格样式
    // $sheet->getStyle('A1')
    //     ->applyFromArray($styleArray)
    //     ->getFont()
    //     ->setSize(28);    

    // $sheet->getStyle('A2:E2')
    //     ->applyFromArray($styleArray)
    //     ->getFont()
    //     ->setSize(14);
    //    //第一行是表头 第二行是字段 所以我们的数据要从第三行开始循环加入
    $row_num = 2; // 初始行
    foreach ($list as $row) {
        $sheet->getStyle('A' . $row_num)   
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);     // 居左显示                                                      
        $sheet->getStyle('A' . $row_num)
            ->getNumberFormat() 
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);   // 设置数字格式为文本
        $sheet->setCellValueExplicit('A' . $row_num, $row['department'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); 
        $sheet->setCellValueExplicit('B' . $row_num, $row['project_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row_num, $row['username'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row_num, $row['turnover'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row_num, $row['agency_rate'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $row_num, $row['property'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('G' . $row_num, $row['margin_rate'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('H' . $row_num, $row['margin'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('I' . $row_num, $row['agency_fees'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('J' . $row_num, $row['number'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('K' . $row_num, $row['labor_costs'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('L' . $row_num, $row['second_money'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('M' . $row_num, $row['subsidies'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('N' . $row_num, $row['commission_ratio'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('O' . $row_num, $row['second_money2'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('P' . $row_num, $row['else'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('Q' . $row_num, $row['group_management_rate'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('R' . $row_num, $row['group_management_money'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('S' . $row_num, $row['taxes_rate'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('T' . $row_num, $row['taxes_money'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('U' . $row_num, $row['total_profit'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);


     //有几个字段就执行几次
        $row_num ++;
    }
   
    //生成表格
    $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
           
    $save_path = config('upload.storexls'); //配置下载路径
    $filename = uniqid() . '.xlsx';    //文件名
    $abs_filepath ='../CSV/' . $filename; // 文件绝对路径
    $show_path = '/CSV/' . $filename; // 下载相对路径

    $objWriter->save($abs_filepath);  //在该路径下保存生成好的表格文件
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);

   return $show_path;
}

}