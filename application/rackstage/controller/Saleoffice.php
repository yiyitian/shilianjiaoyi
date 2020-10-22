<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use think\Request;
use think\Session;

class Saleoffice extends Common
{


    public function exportExcel()
    {
        if(!empty($_GET['department'])){
            $where['department']=array('in',$_GET['department']);
        }
        if(!empty($_GET['enquiryer'])){
            $where['enquiryer']=array('in',$_GET['enquiryer']);
        }

        if(!empty($_GET['koufen'])){
            foreach($_GET['koufen'] as $val)
            {
                $where[$val] =  array('neq','');
            }
        }

        if(!empty($_GET['levels'])){
            $where['levels']=$_GET['levels'];
        }
        if(!empty($_GET['project'])){
            $where['project_id']=array('in',$_GET['project']);
        }
        if(!empty($_GET['time_code'])){
            $array=explode(' - ', $_GET['time_code']);
            $where['enquirytime']=array('between',$array);
        }
        if(!empty($_GET['manager'])){
            $where['manager']=array('like','%'.$_GET['manager'].'%');
        }
        if($_SESSION['think']['role_title']=='项目负责人'){
            $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
            foreach ($project as $key => $val){
                $project_arr[]=$val['id'];
            }
            $project_id=implode(',',$project_arr);
            $where['project_id']=array('in',$project_id);
        }elseif($_SESSION['think']['role_title']=='项目经理'){
            $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
            foreach ($project as $key => $val){
                $project_arr[]=$val['id'];
            }
            $project_id=implode(',',$project_arr);
            $where['project_id']=array('in',$project_id);
        }elseif($_SESSION['think']['role_title']=='案场管控'){

            $where['enquiryer']= $_SESSION['think']['user_id'];
        }
        $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
        if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
            $where['enquiryer']=$_SESSION['think']['user_id'];
        }
        $where['del']='-1';
        $data =Db::name('enquiry')->where($where)->order('id desc')->select();
        foreach($data as $k=>$v)
        {

            $data[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
            $data[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
            $data[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
        }
        if(!empty($data)){

            foreach ($data as $key => $value)
            {

                $arr = ['as','bs','cs','ds','fs','hs','is','js','ks','ls','ms','ns','ps','es','gs'];
                for($i=0;$i<15;$i++)
                {
                    if($i==0)
                    {
                        $file = 'file';
                    }else{
                        $file = 'file'.$i;
                    }

                    $imgArr = db::name('xunpan')->where('times',$value['times'])->where('type',$file)->select();
                    if(!empty($imgArr))
                    {
                        foreach($imgArr as $k=>$v)
                        {
                            $dates[] = $v['images'];
                        }
                        $data[$key][$arr[$i]] = $dates;
                        unset($dates);
                    }else{
                        $data[$key][$arr[$i]] = '';
                    }

                }

            }

        }
        $newExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $objSheet = $newExcel->getActiveSheet();
        //设置当前sheet的标题
        $objSheet->setTitle('询盘成绩');
        //设置宽度为true,不然太窄了
        $newExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $newExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $newExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $newExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $newExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(30);
        $newExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(30);




        //设置第一栏的标题

        $objSheet->setCellValue('A1', '项目名称')
            ->setCellValue('B1', '项目经理')
            ->setCellValue('C1', '分数')
            ->setCellValue('D1', '等级')
            ->setCellValue('E1', '询盘时间')
            ->setCellValue('F1', '考勤纪律')
            ->setCellValue('H1', '仪容仪表')
            ->setCellValue('J1', '行为规范')
            ->setCellValue('L1', '团队激励')
            ->setCellValue('N1', '公共区域维护')
            ->setCellValue('P1', '会议组织')
            ->setCellValue('R1', '接待流程')
            ->setCellValue('T1', '电话接听')
            ->setCellValue('V1', '小客户回访')
            ->setCellValue('X1', '客户登记')
            ->setCellValue('Z1', '数据录入')
            ->setCellValue('AB1', '录音手环')
            ->setCellValue('AD1', '六大文件夹')
            ->setCellValue('AF1', '团队沟通')
            ->setCellValue('AH1', '400投诉')
            ->setCellValue('AJ1', '询盘人')
            ->setCellValue('AK1', '备注');



        //第二行起，每一行的值,setCellValueExplicit是用来导出文本格式的。

        //->setCellValueExplicit('C' . $key, $val['admin_password']PHPExcel_Cell_DataType::TYPE_STRING),可以用来导出数字不变格式

        if(!empty($data)){
            foreach ($data as $key => $val) {
                $key = $key + 2;
                //设置第行高度
                $newExcel->getActiveSheet()->getRowDimension($key)->setRowHeight(65);
                //设置行值
                $objSheet->setCellValue('A' . $key, $val['project_name'])
                    ->setCellValue('B' . $key, $val['manager'])
                    ->setCellValue('C' . $key, $val['score'])
                    ->setCellValue('D' . $key, $val['levels'])
                    ->setCellValue('E' . $key, $val['enquirytime'])
                    ->setCellValue('F' . $key, $val['a'])
                    ->setCellValue('H' . $key, $val['b'])
                    ->setCellValue('J' . $key, $val['c'])
                    ->setCellValue('L' . $key, $val['d'])
                    ->setCellValue('N' . $key, $val['e'])
                    ->setCellValue('P' . $key, $val['f'])
                    ->setCellValue('R' . $key, $val['g'])
                    ->setCellValue('T' . $key, $val['h'])
                    ->setCellValue('V' . $key, $val['i'])
                    ->setCellValue('X' . $key, $val['j'])
                    ->setCellValue('Z' . $key, $val['k'])
                    ->setCellValue('AB' . $key, $val['l'])
                    ->setCellValue('AD' . $key, $val['m'])
                    ->setCellValue('AF' . $key, $val['n'])
                    ->setCellValue('AH' . $key, $val['p'])
                    ->setCellValue('AJ' . $key, $val['enquiryer'])
                    ->setCellValue('AK' . $key, $val['mark']);



                //处理图片
                if(!empty($val['cs'][0])){
                    foreach($val['cs'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('K'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('K' . $key, '');
                }
                if(!empty($val['ps'][0])){
                    foreach($val['ps'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('AI'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('AI' . $key, '');
                }
                if(!empty($val['ns'][0])){
                    foreach($val['ns'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('AG'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('AG' . $key, '');
                }
                if(!empty($val['ms'][0])){
                    foreach($val['ms'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('AE'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('AE' . $key, '');
                }
                if(!empty($val['ls'][0])){
                    foreach($val['ls'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('AC'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('AC' . $key, '');
                }

                if(!empty($val['ks'][0])){
                    foreach($val['ks'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('AA'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('AA' . $key, '');
                }
                if(!empty($val['js'][0])){
                    foreach($val['js'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('Y'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('Y' . $key, '');
                }
                if(!empty($val['is'][0])){
                    foreach($val['is'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('W'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('W' . $key, '');
                }
                if(!empty($val['hs'][0])){
                    foreach($val['hs'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('U'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('U' . $key, '');
                }
                if(!empty($val['gs'][0])){
                    foreach($val['gs'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('S'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('S' . $key, '');
                }
                if(!empty($val['fs'][0])){
                    foreach($val['fs'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('Q'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('Q' . $key, '');
                }
                if(!empty($val['es'][0])){
                    foreach($val['es'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('O'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('O' . $key, '');
                } //处理图片
                if(!empty($val['ds'][0])){
                    foreach($val['ds'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('M'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('M' . $key, '');
                }
                if(!empty($val['as'][0])){
                    foreach($val['as'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('G'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('G' . $key, '');
                }
                if(!empty($val['bs'][0])){
                    foreach($val['bs'] as $K => $V)
                    {
                        $thumb = str_replace(request()->domain(), '.', $V);
                        $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing[$key]->setName('图片');
                        $drawing[$key]->setDescription('图片');
                        $drawing[$key]->setPath($thumb);
                        $drawing[$key]->setWidth(80);
                        $drawing[$key]->setCoordinates('I'.$key);
                        $drawing[$key]->setOffsetX(0);
                        $drawing[$key]->setOffsetY($K*50);
                        $drawing[$key]->setWorksheet($newExcel->getActiveSheet());
                    }

                } else {
                    $objSheet->setCellValue('I' . $key, '');
                }



            }
        } else {
            $this->error('暂无数据');
        }
        //导出
        $filename = '询盘数据';
        $format = 'Xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=" . $filename . date('Y-m-d') . '.' . strtolower($format));
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($newExcel, $format);
        return $objWriter->save('php://output');
        exit;
    }


    public function ft()
    {
        if (Request::instance()->isAjax())
        {
            if(!empty($_POST['search_field'])){
                $where['project_id']=$_POST['search_field'];
            }
            if(!empty($_POST['user_id'])){
                $where['enquiryer']=$_POST['user_id'];
            }
            if($_SESSION['think']['role_title']=='部门总监'){
                $project=Db::name('project')->where('framework_id',Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department'))->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){

                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            if(!isset($where))
            {
                $where = '1=1';
            }
            $count=Db::name('ft')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('ft')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $project=Db::name('project')->where('del','neq','1')->select();
        $this->assign('project',$project);
        $this->assign('user',Db::name('user')->where('role','in','32,35')->select());
        return $this->fetch();
    }

    public function ftDel()
    {
        if(Db::name('ft')->where('id',$_POST['id'])->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    public function ftEdit()
    {
        if (Request::instance()->isPost())
        {

            $info=Db::name('ft')->update($_POST);
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
            $this->assign('id',$_GET['id']);
            $list=Db::name('ft')->where('id',$_GET['id'])->find();
            $list['project_name'] =Db::name('project')->where('id',$list['project_id'])->value('name');
            $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
            $this->assign('list',$list);
            $this->assign('lists',db::name('project')->where('framework_id',$list['department'])->select());
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            return $this->fetch('ft_add');
        }
    }

    public function ftSee()
    {
            $this->assign('id',$_GET['id']);
            $list=Db::name('ft')->where('id',$_GET['id'])->find();
            $list['project_name'] =Db::name('project')->where('id',$list['project_id'])->value('name');
            $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
            $this->assign('list',$list);
            $this->assign('lists',db::name('project')->where('framework_id',$list['department'])->select());
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            return $this->fetch('ft_add');
    }

    public function ftSearch()
    {
        if ($this->request->isPost())
        {
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);
            }
            if(!empty($_POST['enquiryer'])){
                $where['enquiryer']=array('in',$_POST['enquiryer']);
            }
            if(!empty($_POST['myd'])){
                $where['myd']=$_POST['myd'];
            }
            if(!empty($_POST['project'])){
                $where['project_id']=array('in',$_POST['project']);
            }
            if(!empty($_POST['time_code'])){
                $array=explode(' - ', $_POST['time_code']);
                $where['fttime']=array('between',$array);
            }
            if(!empty($_POST['manager'])){
                $where['manager']=array('like','%'.$_POST['manager'].'%');
            }
            if(!empty($_POST['plan'])){
                $where['plan']=array('like','%'.$_POST['plan'].'%');
            }
            if($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){

                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            if(!isset($where))
            {
                $where = '1=1';
            }
            //var_dump($where);exit;
            $count=Db::name('ft')->where($where)->count();

            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('ft')->where($where)->order('id desc')->limit($tol,$limit)->select();

            foreach($list as $k=>$v)
            {

                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $userInfo = db::name('enquiry')->field('enquiryer')->group('enquiryer')->select();
            foreach($userInfo as $k)
            {
                $dd[] = $k['enquiryer'];
            }
            $this->assign('userInfo',Db::name('user')->field('id,user_name')->where('id','in',$dd)->select());
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id desc')->select();
            $this->assign('classArr',$classArr);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id desc')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
            return $this->fetch();
        }
    }

    public function ftAdd()
    {
        if (Request::instance()->isPost())
        {
            $_POST['enquiryer']=$_SESSION['think']['user_id'];
            $info=Db::name('ft')->insert($_POST);

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
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
            return $this->fetch();
        }
    }
    /*
     * 列表
     * */
    public function enquiry()
    {
        if(isset($_GET['id']))
        {
            if(!empty($_POST['search_field'])){
                $where['project_id']=$_POST['search_field'];
            }
            if(!empty($_POST['user_id'])){
                $where['enquiryer']=$_POST['user_id'];
            }
            if($_SESSION['think']['role_title']=='部门总监'){
                $project=Db::name('project')->where('framework_id',Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department'))->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            $count=Db::name('enquiry')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('enquiry')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['deduction'] = preg_replace("/\s+/", " ", $v['deduction']);
                $list[$k]['deduction'] = str_replace(",", "，", $v['deduction']);
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $project=Db::name('project')->where('del','neq','1')->select();
        $this->assign('project',$project);
        $this->assign('user',Db::name('user')->where('role','in','32,35')->select());
        return $this->fetch();
    }
    /*
     * 添加
     * */
    public function enquiry_add()
    {
        if (Request::instance()->isPost())
        {
            
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                $info=Db::name('enquiry')->update($_POST);
            }else{
                $_POST['enquiryer']=$_SESSION['think']['user_id'];
                $info=Db::name('enquiry')->insert($_POST);
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
                $list=Db::name('enquiry')->where('id',$_GET['id'])->find();
                $list['project_name'] =Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('lists',db::name('project')->where('framework_id',$list['department'])->select());
                $this->assign('list',$list);
                $imglist=Db::name('uploads')
                    ->where('mark','enquiry')
                    ->where('times',$list['times'])
                    ->where('del','-1')
                    ->select();
                $this->assign('imglist',$imglist);
                $this->assign('times',$list['times']);
                for($i=0;$i<15;$i++)
                {
                    if($i==0)
                    {$i ="";}
                    $file = 'file'.$i;
                    $this->assign($file,db::name('xunpan')->where('times',$list['times'])->where('type',$file)->select());
                }
                $this->assign('file16',db::name('xunpan')->where('times',$list['times'])->where('type','file16')->select());
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
    /*
     * 查看
     * */
    public function enquiry_see()
    {
        if(!empty($_GET['id'])){
            $this->assign('id',$_GET['id']);
            $list=Db::name('enquiry')->where('id',$_GET['id'])->find();
            $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
            $list['region_name'] = Db::name('framework')->where('id',$list['region'])->value('name');
            $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
            $this->assign('list',$list);
            $imglist=Db::name('uploads')
                ->where('mark','enquiry')
                ->where('times',$list['times'])
                ->where('del','-1')
                ->select();
            for($i=0;$i<15;$i++)
            {
                if($i==0)
                {$i ="";}
                $file = 'file'.$i;
                $this->assign($file,db::name('xunpan')->where('times',$list['times'])->where('type',$file)->select());
            }
            $this->assign("file16",db::name('xunpan')->where('times',$list['times'])->where('type',"file16")->select());
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
    /*
     * 删除
     * */
    public function enquiry_del()
    {
        if(Db::name('enquiry')->where('id',$_POST['id'])->update(['del'=>'1']))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 巡盘查询
     */
    public function enquiry_search(){
        if ($this->request->isPost())
        {
           
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);
            }
             if(!empty($_POST['enquiryer'])){
                $where['enquiryer']=array('in',$_POST['enquiryer']);
            }
            
             if(!empty($_POST['koufen'])){
                    foreach($_POST['koufen'] as $val)
                    {
                        $where[$val] =  array('neq','');
                    }
            }
            
            if(!empty($_POST['levels'])){
                $where['levels']=$_POST['levels'];
            }
            if(!empty($_POST['project'])){
                $where['project_id']=array('in',$_POST['project']);
            }
            if(!empty($_POST['time_code'])){
                $array=explode(' - ', $_POST['time_code']);
                $where['enquirytime']=array('between',$array);
            }
            if(!empty($_POST['manager'])){
                $where['manager']=array('like','%'.$_POST['manager'].'%');
            }
            if($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            //var_dump($where);exit;
            $count=Db::name('enquiry')->where($where)->count();

            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('enquiry')->where($where)->order('id desc')->limit($tol,$limit)->select();

            foreach($list as $k=>$v)
            {
                
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $info = [
                        [
                            'a',
                            '考勤纪律'
                        ],
                        [
                            'b',
                            '仪容仪表'
                        ], [
                            'c',
                            '行为规范'
                        ], [
                            'd',
                            '团队激励'
                        ], [
                            'e',
                            '公共区域维护'
                        ], [
                            'f',
                            '会议组织'
                        ],[
                            'g',
                            '接待流程'
                        ],[
                            'h',
                            '电话接听'
                        ],[
                            'i',
                            '小客户回访'
                        ],[
                            'j',
                            '客户登记'
                        ],[
                            'k',
                            '数据录入'
                        ],[
                            'l',
                            '录音手环'
                        ],[
                            'm',
                            '六大文件夹'
                        ],[
                            'n',
                            '团队沟通'
                        ],[
                            'p',
                            '400投诉'
                        ]
                    ];
                    $this->assign('koufen',$info);
            $userInfo = db::name('enquiry')->field('enquiryer')->group('enquiryer')->select();
            foreach($userInfo as $k)
            {
                $dd[] = $k['enquiryer'];
            }
            $this->assign('userInfo',Db::name('user')->field('id,user_name')->where('id','in',$dd)->select());
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id desc')->select();
            $this->assign('classArr',$classArr);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id desc')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
            return $this->fetch();
        }
    }


    public function answercall()
    {
        if(isset($_GET['id']))
        {
            if(!empty($_POST['search_field'])){
                $where['project_id']=$_POST['search_field'];
            }
            if(!empty($_POST['user_id'])){
                $where['enquiryer']=$_POST['user_id'];
            }
            if($_SESSION['think']['role_title']=='部门总监'){
                $project=Db::name('project')->where('framework_id',Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department'))->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            $count=Db::name('answercall')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('answercall')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $project=Db::name('project')->where('del','neq','1')->select();
        $this->assign('project',$project);
        $this->assign('user',Db::name('user')->where('role','in','32,35')->select());
        return $this->fetch();
    }
    /*
     * 添加
     * */
    public function answercall_add()
    {
        if (Request::instance()->isPost())
        {
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();
                $info=Db::name('answercall')->update($_POST);
            }else{
                            $_POST['enquiryer']=$_SESSION['think']['user_id'];

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
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);
                                $this->assign('lists',db::name('project')->where('framework_id',$list['department'])->select());

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
    /*
     * 查看
     * */
    public function answercall_see()
    {
        if(!empty($_GET['id'])){
            $this->assign('id',$_GET['id']);
            $list=Db::name('answercall')->where('id',$_GET['id'])->find();
            $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
            $list['region_name'] = Db::name('framework')->where('id',$list['region'])->value('name');
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
    /*
     * 删除
     * */
    public function answercall_del()
    {
        if(Db::name('answercall')->where('id',$_POST['id'])->update(['del'=>'1']))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 电话接听查询
     */
    public function answercall_search(){
        if ($this->request->isPost())
        {
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);
            }
             if(!empty($_POST['enquiryer'])){
                $where['enquiryer']=array('in',$_POST['enquiryer']);
            }
            if(!empty($_POST['qualified'])){
                $where['qualified']=$_POST['qualified'];
            }
            if(!empty($_POST['project'])){
                $where['project_id']=array('in',$_POST['project']);
            }
            if(!empty($_POST['time_code'])){
                $array=explode(' - ', $_POST['time_code']);
//                $array[0]=date('Y-m-d',strtotime($array[0].' 0:0:0')-1);
//                $array[1]=date('Y-m-d',strtotime($array[1].' 23:59:59')+1);
                $where['enquirytime']=array('between',$array);
            }
            if(!empty($_POST['manager'])){
                $where['manager']=array('like','%'.$_POST['manager'].'%');
            }
            if($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            
            $count=Db::name('answercall')->where($where)
                ->count();

            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('answercall')->where($where)
                ->order('id desc')->limit($tol,$limit)->select();

            foreach($list as $k=>$v)
            {
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                if(empty($list[$k]['project_name']))
                {
                    $date[] = $v['project_id'];
                }
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $userInfo = db::name('enquiry')->field('enquiryer')->group('enquiryer')->select();
            foreach($userInfo as $k)
            {
                $dd[] = $k['enquiryer'];
            }
            $this->assign('userInfo',Db::name('user')->field('id,user_name')->where('id','in',$dd)->select());
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id desc')->select();
            $this->assign('classArr',$classArr);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id desc')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
            return $this->fetch();
        }
    }

/*
 * 客户回访抽查
 */
    public function review()
    {
        if(isset($_GET['id']))
        {
            if(!empty($_POST['search_field'])){
                $where['project_id']=$_POST['search_field'];
            }
            if(!empty($_POST['user_id'])){
                $where['enquiryer']=$_POST['user_id'];
            }
            if($_SESSION['think']['role_title']=='部门总监'){
                $project=Db::name('project')->where('framework_id',Db::name('users')->where('id',$_SESSION['think']['user_id'])->value('department'))->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            $count=Db::name('review')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('review')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }
        $project=Db::name('project')->where('del','neq','1')->select();
        $this->assign('project',$project);
        $this->assign('user',Db::name('user')->where('role','in','32,35')->select());
        return $this->fetch();
    }
    /*
     * 添加
     * */
    public function review_add()
    {
        if (Request::instance()->isPost())
        {
            if(!empty($_POST['id'])){
                $_POST['updatetime']=time();

                $info=Db::name('review')->update($_POST);
            }else{
                            $_POST['enquiryer']=$_SESSION['think']['user_id'];

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
                $list['project_name'] =Db::name('project')->where('id',$list['project_id'])->value('name');
                $list['department_name'] = Db::name('framework')->where('id',$list['department'])->value('name');
                $this->assign('list',$list);
                $this->assign('lists',db::name('project')->where('framework_id',$list['department'])->select());

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
    /*
     * 添加
     * */
    public function review_see()
    {
        if(!empty($_GET['id'])){
            $this->assign('id',$_GET['id']);
            $list=Db::name('review')->where('id',$_GET['id'])->find();
            $list['project_name'] =$list['project_id'] .'--'.Db::name('project')->where('id',$list['project_id'])->value('name');
            $list['region_name'] = Db::name('framework')->where('id',$list['region'])->value('name');
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
    /*
     * 删除
     * */
    public function review_del()
    {
        if(Db::name('review')->where('id',$_POST['id'])->update(['del'=>'1']))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 巡盘查询
     */
    public function review_search(){
        if ($this->request->isPost())
        {
            //var_dump($_POST);exit;
            if(!empty($_POST['department'])){
                $where['department']=array('in',$_POST['department']);
            }
             if(!empty($_POST['enquiryer'])){
                $where['enquiryer']=array('in',$_POST['enquiryer']);
            }
            if(!empty($_POST['project'])){
                $where['project_id']=array('in',$_POST['project']);
            }
            if(!empty($_POST['time_code'])){
                $array=explode(' - ', $_POST['time_code']);
                $where['enquirytime']=array('between',$array);
            }
            if(!empty($_POST['customer'])){
                $where['customer']=array('like','%'.$_POST['customer'].'%');
            }
            if($_SESSION['think']['role_title']=='项目负责人'){
                $project=Db::name('project')->where('user_id',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='项目经理'){
                $project=Db::name('project')->where('manager',$_SESSION['think']['user_id'])->select();
                foreach ($project as $key => $val){
                    $project_arr[]=$val['id'];
                }
                $project_id=implode(',',$project_arr);
                $where['project_id']=array('in',$project_id);
            }elseif($_SESSION['think']['role_title']=='案场管控'){
               
                $where['enquiryer']= $_SESSION['think']['user_id'];
            }
            $station=Db::name('users')->where('user_id',$_SESSION['think']['user_id'])->value('station');
            if(Db::name('posts')->where('id',$station)->value('posts')=='地区业管'||$_SESSION['think']['role_title']=='地区业管'){
                $where['enquiryer']=$_SESSION['think']['user_id'];
            }
            $where['del']='-1';
            $count=Db::name('review')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('review')->where($where)->order('id desc')->limit($tol,$limit)->select();
            foreach($list as $k=>$v)
            {
                $list[$k]['enquiryer'] = Db::name('user')->where('id',$v['enquiryer'])->value('user_name');
                $list[$k]['project_name'] = Db::name('project')->where('id',$v['project_id'])->value('name');
                $list[$k]['department_name'] = Db::name('framework')->where('id',$v['department'])->value('name');
            }

            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $userInfo = db::name('enquiry')->field('enquiryer')->group('enquiryer')->select();
            foreach($userInfo as $k)
            {
                $dd[] = $k['enquiryer'];
            }
            $this->assign('userInfo',Db::name('user')->field('id,user_name')->where('id','in',$dd)->select());
            $classArr=Db::name('classinfo')->where('pid','0')->order('orderby desc,id desc')->select();
            $this->assign('classArr',$classArr);
            $this->assign('region',Db::name('framework')->where('pid','-1')->order('id desc')->select());
            $this->assign('framework_pid',Db::name('framework')->where('pid','-1')->select());
            $this->assign('framework',Db::name('framework')->where('pid','neq','-1')->select());
            return $this->fetch();
        }
    }


public function Uploads()
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
                $url = 'uploads/'.str_replace("\\","/",$pic['savename']);
                $info = $this->insertList($url);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            if($info['code']==1)
            {
                $ret["msg"]= "上传成功";
            }else{
                $ret["msg"]= "上传失败";
            }
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            return json($ret);
        }
    }

    public function Uploads1()
    {

        $ret = array();
        if ($_FILES["file"]["error"] > 0)
        {
            $ret["message"] =  $_FILES["file"]["error"] ;
            $ret["status"] = 0;
            $ret["src"] = "";

            return json($ret);
        }else{
            $pic =  upload();
            if($pic['info']== 1){
                $url = 'uploads/'.str_replace("\\","/",$pic['saveName']);
                $info = $this->insertLists($url);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            if($info['code']==1)
            {
                $ret["msg"]= "上传成功";
            }else{
                $ret["msg"]= "上传失败";
            }
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            return json($ret);
        }
    }
    public function uploads2()
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
                $url = 'uploads/'.str_replace("\\","/",$pic['savename']);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            $info = input('');
            $info['images'] = $url;
            db::Name('xunpan')->insert($info);
            $ret["msg"]= "上传成功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            return json($ret);

        }
    }

    public function uploads_del()
    {
        db::name('xunpan')->where('id',input('id'))->delete();
        return json(['code'=>1,'msg'=>'删除成功']);
    }



    /**
     *租房信息增加
     */
    private function insertList($url)
    {
        set_time_limit(0);
        vendor("phpExcel.PHPExcel");
        vendor("phpExcel.PHPExcel.Reader.Excel2007");
        vendor("phpExcel.PHPExcel.IOFactory");
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($url);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $k = 0;
        for($j=2;$j<=$highestRow;$j++) {
            $b = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();//租金5500
            $c = $objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue();//租金5500
            $d = $objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue();//租金5500
            $e = $objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue();//租金5500
            $f = $objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue();//租金5500
            $g = $objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue();//租金5500
            $h = $objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue();//租金5500
            $i = $objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue();//租金5500
            $jj = $objPHPExcel->getActiveSheet()->getCell("J".$j)->getValue();//租金5500
            $k = $objPHPExcel->getActiveSheet()->getCell("K".$j)->getValue();//租金5500
            $l = $objPHPExcel->getActiveSheet()->getCell("L".$j)->getValue();//租金5500
            $m = $objPHPExcel->getActiveSheet()->getCell("M".$j)->getValue();//租金5500
            $n = $objPHPExcel->getActiveSheet()->getCell("N".$j)->getValue();//租金5500
            $o = $objPHPExcel->getActiveSheet()->getCell("O".$j)->getValue();//租金5500
            $p = $objPHPExcel->getActiveSheet()->getCell("P".$j)->getValue();//租金5500
            $b = db::name('framework')->where('name',trim($b))->find();

           

                $list =  [
                    
                    'region'  => $b['pid'],
                    'department'  =>$b['id'],
                    'project_id'      => db::name('project')->where('name',$c)->value('id'),
                    'customer'=> $d,
                    'phone'    => $e,
                    'salesman'  => $f,
                    'positive'         => $g,
                    'patient'        => $h,
                    'lucid'       => $i,
                    'dissent'       => $jj,
                    'appraise'       => $k,
                    'suggest'       => $l,
                    'score'       => $m,
                    'enquirytime'       =>  gmdate('Y-m-d ', (int)((int)((int)$n - 25569) * 86400)),
                    'enquiryer'   =>db::name('user')->where('user_name',$o)->value('id'),
                    'mark'       => $p,
                    
                ];
               
               
                Db::name('review')->insert($list);
           
        };


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





}
