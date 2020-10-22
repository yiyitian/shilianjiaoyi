<?php

namespace app\rackstage\controller;

use app\rackstage\model\ErpBalance;
use app\rackstage\model\ErpCostume;
use app\rackstage\model\ErpDeal;
use app\rackstage\model\Project;
use app\rackstage\service\BasicService;
use app\rackstage\service\EmployeeService;
use think\Db;
use think\Request;
use think\Response;
use think\response\Json;

/**
 * 置业顾问考评
 * Class Employee
 * @package app\rackstage\controller
 */
class Employee extends Common
{

    /**
     * @return Json
     */
    public function employee_edit()
    {
        $da = session('');
        $user_id = $da['user_id'];
        $info = input('post.');
        $role_title = $this->role_title;
        $j = $this->jurisdiction;
    
        (isset($info['manager_id']) && $info['manager_id'] != 0) ? $manager_id = $info['manager_id'] : $manager_id = 0;
        (isset($info['clerk_id']) && $info['clerk_id'] != 0) ? $clerk_id = $info['clerk_id'] : $clerk_id = 0;
        (isset($info['admin_id']) && $info['admin_id'] != 0) ? $admin_id = $info['admin_id'] : $admin_id = 0;
        $field = $info['field'];
        $data[$field]  =  $info['value'];
        if($j==1)
        {
            if($field == 'subscribe_score')
            {
                $data['color1']  = '#9400d3';
            }else if($field == 'oln_score')
            {
                $data['color2'] = '#9400d3';
            }else if($field == 'erp_entry_score')
            {
                $data['color3'] = '#9400d3';
            }
        }
        if($j==5)
        {
            $one = Db::name('employee_evaluate')->where(['id' => $info['id']])->find();
            if($one['is_submit'] == 1)
            {
                return json(['code' => 2, 'msg' => '请等待项目经理打分']);
            }
        }
        try {
            Db::name('employee_evaluate')->where('id', $info['id'])->update($data);
            EmployeeService::total_score($info, $manager_id, $clerk_id, $admin_id, $j);
        } catch (\Exception $e) {
            return json(['code' => 2, 'msg' => $e->getMessage()]);
        }


        return json(['code' => 1, 'msg' => '打分完成']);
    }

    public function employee_edits()
    {
        db::name('clerk_evaluate')->where('id',input('id'))->update([input('field')=>input('value')]);

        return json(['code' => 1, 'msg' => '打分完成']);
    }

    /**
     * 置业顾问打分记录搜索
     * @param Request $request
     * @return Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function employee_search(Request $request)
    {
        $post = input('');
        if(isset($post['date'])&&($post['date'] !=="")) {$where['month'] = $post['date'];}else{$where['month'] = date("Y-m", strtotime("last day of -1 month", time())) ;}
        (isset($post['project']) && $post['project'] != "") && $where['project_title'] = array('in', $post['project']);
        /*项目对搜索结果的影响判断开始*/
        if(!empty($post['project']))
        {
            $map['project_title'] =  ['in',$post['project']];
        }else{
            $map = 1;
        }
        $eve = db::name('aims')->where($map)->where('status',$post['status'])->where('month',$where['month'])->select();
        if(empty($eve))
        {
            return json(['code' => '0', 'msg' => '', 'count' => 1, 'data' => 0, 'page' => 0, 'limit' => 0]);
        }else{
            foreach($eve as $k=>$v)
            {
                $projectId[] = $v['project_title'];
            }
            $where['project_title'] = ['in',$projectId];
        }
        /*项目对结果判断的影响结束*/


        (isset($post['department']) && $post['department'] != "") && $where['department'] = array('in', $post['department']);
        $where = EmployeeService::insert_where($this->jurisdiction, $where);
        list($count, $page, $limit, $list) = EmployeeService::get_data($request, $this->jurisdiction, $where, session('user_id'),$post['status'][0]);
        foreach($list as $k=>$v)
        {
            $list[$k]['dep'] = getDepartment($v['department']);
        }
        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
    }

    /**
     * 一件生成打分表
     * @param Request $request
     * @return Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function create_table(Request $request)
    {
        if ($request->isGet()) {
            $post = $request->get();
            $role_title = session('role_title');
            $this_project=getProject();
            $is_true = db::name('project')->where('id',$this_project)->value('is_true');
            if($is_true<0)
            {
                return json(['code'=>2,'msg'=>'请先去组织架构-》项目管理-》项目人员确认人员数据']);
            }
            $this_depart = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->value('department');
            $wheres = db::name('maintain')->field('uid as id')->where('pid',$this_project)->where('station','in','18,19')->select();
            foreach($wheres as $k=>$v)
            {
                $map[] = $v['id'];
            }
            $month = date("Y-m", strtotime("last day of -1 month", time())) ;
            $rated = Db::name('employee_evaluate')->where('project_title',$this_project)->where('month',$month)->column('userid'); //已生成得打分表

            $w['projectname'] = ['neq', 0];
            $w['del'] = -1;
            $w['station'] = ['in','19,18'];
           // $w['is_quit'] = -1;
            $w['id'] =  ['in',$map];
            if($this_project==null){
                return json(['code'=>2,'msg'=>'无数据插入']);
            }
            $else = Db::name('users')->where($w)->whereNotIn('id', $rated)->select();

            $log = [];
            $month = date("Y-m", strtotime("last day of -1 month", time())) ;
            $clerk = db::name('maintain')->where(['project'=>$this_project,'station'=>'21'])->find();
            if(empty($clerk))
            {
                $clerkId = 1;
                $submit  = 2;
            }else{
                $clerkId = 0;
                $submit = 1;
            }
            foreach ($else as $k => $v) {
                $full = $v['work_id'] . sysconf('username_break') . $v['username'];
                $el_count = Db::name('employee_evaluate')->where(['username' => $full, 'month' => $month,'project_title'=>$this_project])->count();
                if ($el_count == 0) {
                    $log[] = [
                        'project_title' => $this_project, //本项目
                        'username' => $full, //全名：工号+姓名
                        'userid' => $v['id'], //员工id
                        'month' => $month, //月份
                        'station' => $v['station'], //岗位id
                        'department' => $this_depart,
                        'subsidy' => db::name('maintain')->where(['project'=>$this_project,'uid'=>$v['id']])->value('subsidy'),
                        'clerk_id' => $clerkId,
                        'clerk_submit' => $submit,
                        'work_id' => $v['work_id'],
                    ];
                }
            }
           
            try {
                Db::name('employee_evaluate')->insertAll($log);
            } catch (\ErrorException $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '生成表单成功,插入' . count($log) . '条记录']);
        }
    }

    public function getHaha()
    {

        $one = date('Y-m-01', strtotime('-1 month'));
        $end = date('Y-m-t', strtotime('-1 month'));

        $where = [
            'person_name' => 'SD10204, 孟祥龙',
            'void_flag' => 1,
            'source_type_cd' => array('in', ['微信', '老带新/友介','微信朋友圈','邀约', '外拓']),
            'join_date' => ['between time',array($one,$end)]
        ];
        $dd = str_replace(', ',',','SD10204, 孟祥龙');
        $wheres = "person_name = '".$dd."' and void_flag = 1 and `source_type_cd` IN ('微信','老带新/友介','微信朋友圈','邀约','外拓') and `join_date` BETWEEN '".$one."' AND '".$end."'";
        $total_oln = (new ErpCostume())->get_one_olns($where,$wheres);

    }

    /**
     * 提价打分，生成打分结果
     * @param Request $request
     * @return Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function submit_employee(Request $request)
    {
        if ($request->isPost()) {
            $da = session('');
            $user_id = $da['user_id']; //当前账号
            $role = $da['role'];
            $role_title = $da['role_title'];
            $jurisdiction = $this->jurisdiction;
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) ;
            $count = 0;
            $project_name=getProject();
            switch ($jurisdiction) {
                case 1:
                    $count = Db::name('employee_evaluate')->where(['month' => $month, 'admin_id' => 0, 'is_submit' => 2, 'clerk_submit' => 2])->count();
                    break;
                case 2:
                    $count = Db::name('employee_evaluate')->where(['month' => $month, 'manager_id' => 0,'is_submit'=>1, 'project_title' => $project_name])->count();
                    break;
                case 5:
                    $count = Db::name('employee_evaluate')->where(['month' => $month, 'clerk_id' => 0, 'project_title' => $project_name])->count();
                    break;
            }
            $is_costume = Db::name('clerk_upload')->where(['user_id' => $user_id, 'month' => $month, 'type' => 1])->count();
            $is_deal = Db::name('clerk_upload')->where(['user_id' => $user_id, 'month' => $month, 'type' => 2])->count();
            if ($jurisdiction==5 && $is_costume == 0 ) {
                return json(['code' => 4, 'msg' => '台账上传不完整']);
            }
            if ($count > 0) {
                return json(['code' => 3, 'msg' => '请完成全部打分']);
            }
            try {
                EmployeeService::handle_employee($jurisdiction, $user_id);
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '打分已完成']);
        }
    }


    public function testss()
    {
        $info = db::name('employee_evaluate')->select();
        EmployeeService::employee_separates(2,$info);
    }

    /**
     * @param Request $request
     * @return Json
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \think\Exception
     */
    public function upload(Request $request)
    {
        $session = session('user_id');
        $date = date('Y-m', strtotime('-1 months')); //上一个月
        $clerk_evaluate = Db::name('employee_evaluate')->where(['month' => $date])->where(['clerk_submit' => 1, 'clerk_id' => $session])->fetchSql(false)->count();
        $one = Db::name('users')->field('work_id,user_id,projectname,username,department')->where(['user_id' => $session])->find();
        $file = $request->file('file');
        $get = input('param.');
        $infos = db::name('clerk_upload')->where(['username' => $one['work_id'] . sysconf('username_break') . $one['username'], 'user_id' => $session, 'project' => $one['projectname'],  'type' => $get['type'], 'department' => $one['department'],'month'=>date('Y-m',strtotime('-1 month'))])->find();
        if(!empty($infos))
        {
            return json(['code' => 2, 'msg' => '已经上传过了，请删除后重新上传', 'url' => $file->getError()]);
        }
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $saveName = str_replace("\\", '/', $info->getSaveName());
                $str = '/public/uploads/' . $saveName;
                $arr = ['username' => $one['work_id'] . sysconf('username_break') . $one['username'], 'user_id' => $session, 'project' => $one['projectname'], 'url' => $str, 'type' => $get['type'], 'department' => $one['department'],'month'=>date('Y-m',strtotime('-1 month'))];
                switch ($get['type']) {
                    case 1:
                        EmployeeService::import_costume($str, $session);
                        break;
                    case 2:
                        EmployeeService::import_deal($str, $session);
                        break;
                    case 3:
                        EmployeeService::import_performance($str, $session);
                        break;
                    case 4:
                        EmployeeService::import_erp_costume($str, $session);
                        break;
                    case 5:
                        EmployeeService::import_erp_deal($str, $session);
                        break;
                }
                Db::name('clerk_upload')->insert($arr);
                return json(['code' => 1, 'msg' => '上传成功', 'url' => $info->getSaveName()]);
            } else {
                return json(['code' => 2, 'msg' => '系统故障', 'url' => $file->getError()]);
            }
        }
    }
    public function uploads(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $saveName = str_replace("\\", '/', $info->getSaveName());
                $str = '/public/uploads/' . $saveName;
                EmployeeService::target($str);

                return json(['code' => 1, 'msg' => '上传成功', 'url' => $info->getSaveName()]);
            } else {
                return json(['code' => 2, 'msg' => '系统故障', 'url' => $file->getError()]);
            }
        }
    }


    protected static function total_subscribe()
    {
    }

    /**
     * 文员考核
     *
     * @return Response
     */
    public function clerk()
    {
        //
        return $this->fetch();
    }

    /**
     * 经理
     *
     * @return Response
     */
    public function manager()
    {
        //
        return $this->fetch();
    }

    /**
     * 策划
     *
     * @return Response
     */
    public function plan()
    {
        //
        return $this->fetch();
    }

    /**
     * 台账显示
     * @param Request $request
     * @return mixed|Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ledger(Request $request)
    {
        //
        $get = $request->get();
        if (isset($get['id'])) {
            $page = $request->param('page');
            $limit = $request->param('limit');
            $tol = ($page - 1) * $limit;
            $db = Db::name('clerk_upload');
            $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
            switch ($this->jurisdiction) {
                case 1:
                    break;
                case 2:
                    $db->where(['project' => $project_name]);
                    break;

                case 5:
                    $db->where(['user_id' => $this->user_id])->where(['project' => $project_name]);
                    break;
            }
            $list = $db->limit($tol, $limit)->fetchSql(false)->select();
            foreach ($list as $k => $v) {
                $list[$k]['project'] = Db::name('project')->where(['id' => $project_name])->value('name');
            }
            $count = $db->count();
            return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
        }
        list($pro_pid, $framework_pid) = EmployeeService::frame_project();
        return $this->fetch('', compact('pro_pid', 'framework_pid'));
    }

    /**
     * 下载台账
     * @param Request $request
     */
    public function download_file(Request $request)
    {
        $id = $request->get('id');
        $one = Db::name('clerk_upload')->where(['id' => $id])->value('url');
        $file = '../' . $one;
        BasicService::download($file);
    }

    public function del()
    {
        # code...
        $id = $_REQUEST['id'];


        $info = Db::name('employee_evaluate')->delete($id);
        //Db::name('classinfo')->getLastsql();
        if ($info) {
            $info = array('code' => 1, 'msg' => '删除置业顾问打分成功');
        } else {
            $info = array('code' => 2, 'msg' => '删除置业顾问打分失败');
        }


        return json($info);
    }

    public function pass()
    {
        $id = $_REQUEST['id'];
        $info = db::name('employee_evaluate')->where('id',$id)->find();
        $actual = $info['subsidy'] * $info['total'] / 100;
        $info = Db::name('employee_evaluate')->update(['id' => $id, "admin_submit" => 2, 'admin_id' => $_SESSION['think']['user_id'],'actual'=>$actual]);
        if ($info) {
            $info = array('code' => 1, 'msg' => '打分通过');
        } else {
            $info = array('code' => 2, 'msg' => '系统故障');
        }
        return json($info);
    }

    public function erp_costume()
    {
        $date = date('Y-m');
        Project::where(['status' => 1,'del'=>-1])->chunk(50, function ($data) use ($date) {
            
            $log = [];
            //  $date = date('Y-m',strtotime('-1 month'));

        foreach($data as $k=>$v1){
           $manager=Db::name('users')->where(['user_id'=>$v1['manager']])->find();
//                    $manager = Db::name('users')->where(['station' => 16, 'projectname' => $v1['id']])->find();
                    if (empty($manager)) {
                        $full = '暂无';

                    } else {
                        $full = $manager['work_id'] . sysconf('username_break') . $manager['username'];

                    }
                    $number=Db::name('aims')->where(['project_title'=>$v1['id'],'month'=>$date])->value('number');
                    if (Db::name('aims_copy')->where(['month' => $date, 'project_title' => $v1['id']])->count() == 0) {
                        $log[] = [
                            'project_title' => $v1['id'],
                            'username' => $full,
                            'station' => 16,
                            'month' => $date,
                            'number'=>$number,
                            'user_id' => $v1['manager'],
                            'department' => $v1['framework_id'],
                            'plan_total' => Db::name('users')->whereIn('station', [14, 15])->where(['projectname' => $v1['id'], 'is_quit' => -1])->count(),
                            'employee_total' => Db::name('users')->where(['station' => 19, 'projectname' => $v1['id'], 'is_quit' => -1])->count(),
                            'clerk_total' => Db::name('users')->where(['station' => 21, 'projectname' => $v1['id'], 'is_quit' => -1])->count(),
                        ];
                    }
        }
             Db::name('aims_copy')->insertAll($log);
        });
    }

    public function recall()
    {

        if (\request()->isPost()) {
            $post = input("param.");
            $data['id'] = $post['id'];
            $user_id = $_SESSION['think']['user_id'];
            $this_evaluate=Db::name('employee_evaluate')->field('back,project_title')->find($post['id']);
            switch ($this->jurisdiction) {
                case 1:
                    $data['admin_submit'] = 1;
                    break;
                case 2:
                    $data['is_submit'] = 1;
                    $data['manager_score'] = 0;
                    break;
                case 5:
                    $data['clerk_submit'] = 1;
                    break;
            }
            $data['back']=$this_evaluate['back']+1;
            try {
                Db::name('employee_evaluate')->update($data);
                Db::name('aims')->where(['project_title'=>$this_evaluate['project_title'],'month'=>date('Y-m',strtotime('-1 month'))])->setDec('employee_complete');
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '撤回打分成功']);
        }
    }
}