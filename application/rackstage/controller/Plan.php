<?php

namespace app\rackstage\controller;

use app\rackstage\service\ClerkService;
use app\rackstage\service\EmployeeService;
use app\rackstage\service\ExportService;
use app\rackstage\service\PlanService;
use think\Db;
use think\Request;
use think\response\Json;

/**
 * 项目策划考评
 * Class Plan
 * @package app\rackstage\controller
 */
class Plan extends Common
{

    /**
     * @return Json
     */
    public function employee_edit()
    {
        $da = session('');
        $user_id = $da['user_id'];
        $info = input('post.');
        $field = $info['field'];
        $j = $this->jurisdiction;
        (isset($info['manager_id']) && $info['manager_id'] != 0) ? $manager_id = $info['manager_id'] : $manager_id = 0;
        (isset($info['admin_id']) && $info['admin_id'] != 0) ? $admin_id = $info['admin_id'] : $admin_id = 0;
        $this_evaluate = Db::name('plan_evaluate')->field('id,visiting_aims')->find($info['id']);
        if ($info['field'] == 'visiting_score' && $this_evaluate['visiting_aims'] == 0) {
            return json(['code' => 2, 'msg' => '请先填写此策划月度访问目标']);
        }

        $data[$field]  =  $info['value'];
        $data['manager_id']  = $manager_id;
        if($j == 1)
        {
            if($field == 'subscribe_real')
            {
                $data['color1']  = '#9400d3';
            }else if($field == 'visiting_score')
            {
                $data['color2'] = '#9400d3';
            }else if($field == 'profit_score')
            {
                $data['color3'] = '#9400d3';
            }
        }

        try {
            Db::name('plan_evaluate')->where('id', $info['id'])->update($data);
            $plans = Db::name('plan_evaluate')->find($info['id']);

            $datt = (int)$plans['visiting_score']+(int)$plans['profit_score']+(int)$plans['subscribe_real'];
            $xuke = (int)$plans['work_book_score'] + (int)$plans['develop_costume'];
            db::name('plan_evaluate')->where('id',$plans['id'])->update(['total'=>$datt,'xukecount'=>$xuke]);

        } catch (\Exception $e) {
            return json(['code' => 2, 'msg' => $e->getMessage()]);
        }
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
        $da = session('');
        $role_title = $da['role_title'];
        $post = input('param.');
        $where['del'] = -1;
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) ;
        if ($this->jurisdiction == 2) {
            $where['month'] = $month;
        }

        $where['station'] = ['in', [14, 15]];
        (isset($post['project']) && $post['project'] != "") && $where['project_title'] = array('in', $post['project']);
        (isset($post['department']) && $post['department'] != "") && $where['department'] = array('in', $post['department']);

        (isset($post['ids']) && $post['ids'] != "") && $where['userid'] = array('in', $post['ids']);
        if (isset($post['date']) && $post['date'] != '') {
            $where['month'] = $post['date'][0];
        }
        $user_id = $this->user_id;
        list($count, $page, $limit, $list) = PlanService::get_data($request, $where, $this->jurisdiction, $user_id);
        foreach($list as $k=>$v)
        {
            $list[$k]['dep'] = getDepartment($v['department']);
        }
        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
    }

    public function checkStatus()
    {
        $info = input('');
        if(isset($info['project'][0])&&($info['project'][0] !==""))
        {
            $where['project_title'] = ['eq',$info['project'][0]];
        }
        if(isset($info['date'][0])&&($info['date'][0] !==""))
        {
            $where['month'] = ['eq',$info['date'][0]];
        }
        $info = db::name('aims')->where($where)->value('status');
        return json(['status'=>$info]);
    }

    public function getProject(Request $request)
    {
        $info = input('');
        if(isset($info['project'])&&($info['project'] !==""))
        {
            $where['project_title'] = $info['project'];
        }
        if(isset($info['date'])&&($info['date'] !==""))
        {
            $where['month'] = $info['date'];
        }else{
            $where['month'] = date("Y-m", strtotime("last day of -1 month", time())) ;
        }
        /*项目对搜索结果的影响判断开始*/
        if(!empty($info['project']))
        {
            $map['project_title'] =  ['in',$info['project']];
        }else{
            $map = 1;
        }
        $eve = db::name('aims')->where($map)->where('status',$info['status'])->where('month',$where['month'])->group('project_title')->select();
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

        $where['del'] = -1;

        $user_id = $this->user_id;
        list($count, $page, $limit, $list) = PlanService::get_datas($request, $where, $this->jurisdiction, $user_id);
        foreach($list as $k=>$v)
        {
            $list[$k]['dep'] = db::name('framework')->where('id',$v['department'])->value('name');
        }
        return json(['code' => '0', 'msg' => 'ok', 'data' => $list, 'limit' => $limit, 'count' => $count, 'page' => $page]);
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
            if($this_project==null)
            {
                return json(['code'=>2,'msg'=>'无数据插入']);
            }
            $this_department = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->value('department');
            $wheres = db::name('maintain')->field('uid as id')->where('pid',$this_project)->where('station','in','13,14,15,44')->select();
            foreach($wheres as $k=>$v)
            {
                $map[] = $v['id'];
            }
            $month = date("Y-m", strtotime("last day of -1 month", time())) ;

            $rated = Db::name('plan_evaluate')->where('project_title',$this_project)->where('month',$month)->column('userid'); //已生成得打分表
            $w['del'] = -1;
            $w['station'] = ['in', [13,14,15,44]];
            //$w['is_quit']=-1;
            $w['id'] = ['in',$map];
            $else = Db::name('users')->where($w)->whereNotIn('id', $rated)->select();

            $log = [];
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) ;
            $info = db::name('aims')->where(['month'=>$month,'project_title'=>$this_project])->find();
            foreach ($else as $k => $v) {
                $full = $v['work_id'] . sysconf('username_break') . $v['username'];
                $el_count = Db::name('plan_evaluate')->where(['username' => $full,'project_title'=> $this_project, 'month' => $month])->count();
                if ($el_count == 0) {
                    $log[] = [
                        'project_title' => $this_project, //本项目
                        'username' => $full, //全名：工号+姓名
                        'userid' => $v['id'], //员工id
                        'month' => $month, //月份
                        'station' => $v['station'], //岗位id
                        'department' => $this_department,
                        'subsidy' => db::name('maintain')->where(['project'=>$this_project,'uid'=>$v['id']])->value('subsidy'),
                        'work_id' => $v['work_id'],
                        // 'develop_costume' =>$info['visiting'],月许可目标
                         //'visiting_aims'  => $info['number']，
                    ];

                }
            }
            try {
                Db::name('plan_evaluate')->insertAll($log);
            } catch (\ErrorException $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '生成表单成功,插入' . count($log) . '条记录']);
        }
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
            $aims = Db::name('aims')->where(['project_title' => $project_name, 'month' => $month])->value('number'); //月度目标
            $this_project = Db::name('project')->field('type,aims')->where(['id' => $project_name])->find();
            switch ($jurisdiction) {
                case 1:
                    $count = Db::name('plan_evaluate')->where(['month' => $month, 'admin_id' => 0, 'is_submit' => 2])->count();
                    break;
                case 2:
                    $count = Db::name('plan_evaluate')->where(['month' => $month, 'manager_id' => 0, 'project_title' => $project_name])->count();
                    $project = $project_name;
                    $status = db::name('aims')->where(['project_title' => $project, 'month' => $month])->value('status');
                    if($status>0)
                    {
                        $count1 = Db::name('profit')->where(['project_name' => $project, 'month' => $month])->count();
                        if ($count1 <= 0) {
                            return json(['code' => 4, 'msg' => '请先测算理论利润', 'url' => 'profit']);
                        }
                    }
                    if ($aims['number'] <= 0 && $aims['status']==1) {
                        return json(['code' => 4, 'msg' => '月度目标未设置，请联系管理员', 'url' => 'profit']);
                    }
                    break;
            }
//            if ($count > 0) {
//                return json(['code' => 3, 'msg' => '请完成全部打分', 'url' => '']);
//            }
            try {
                PlanService::handle_employee($jurisdiction, $user_id);
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage(), 'url' => '']);
            }
            return json(['code' => 1, 'msg' => '打分已完成', 'url' => '']);
        }
    }


    public function tests()
    {
        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $planInfo = db::name('plan_evaluate')->where([ 'is_submit' => 2, 'month' => $month])->select();
        PlanService::employee_separates($planInfo, 2);
    }

    public function export()
    {
        $post=input("param.");
        $project_name=getProject();
//设置表头：


//数据中对应的字段，用于读取相应数据：

        $where['del']=-1;
        $where['month']=date('Y-m',strtotime('-1 month'));
        $aim = db::name('aims')->where(['month'=>$where['month'],'project_title'=>$project_name])->value('status');
        if($aim == 1)
        {
            $arr=['编号', '事业部', '项目名称', '姓名', '工号', '认购完成得分', '来访', '利润完成得分','备注', '总分'];
        }else{
            $arr=['编号', '事业部', '项目名称', '姓名', '工号', '计划书得分','蓄客完成得分','备注', '总分'];

        }


        switch($this->jurisdiction){
            case 1://
                (isset($post['project']) && $post['project'] != "0") && $where['project_name'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "0") && $where['department'] = array('in', $post['department']);
                $where['admin_submit']=2;
                break;
            case 2:

            case 7:
         
                $where['project_title']=$project_name;
                break;
            case 8:
                $where['department']=Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department');
                break;

        }
        $list = Db::name('plan_evaluate')->where($where)->select();
        if (empty($list)){
            return json(['code'=>2,'msg'=>'没有可导出数据']);
        }
        foreach ($list as $k => $v) {
            $list[$k]['department'] = Db::name('framework')->where(['id' => $v['department']])->value('name');
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
        }
        if($aim == 1)
        {
            $keys=['id','department','project_title','username','work_id','subscribe_real','visiting_real_score','profit_score','mark','total'];
        }else{
            $keys=['id','department','project_title','username','work_id','work_book_score','develop_costume','mark','xukecount'];
        }
        $file=ExportService::outdata(date('Y-m',strtotime('-1 month'))."项目策划考评", $list, $arr, $keys);
        return json(['code'=>1,'msg'=>'下载成功','url'=>$file]);

    }
    public function pass()
    {
        # code...
        $id = $_REQUEST['id'];
        $info = db::name('plan_evaluate')->where('id',$id)->find();
        $actual = $info['subsidy'] * $info['total'] / 100;
        $info = Db::name('plan_evaluate')->update(['id' => $id, "admin_submit" => 2,'admin_id'=>$_SESSION['think']['user_id'],'actual'=>$actual]);
        if ($info){
            $info = array('code' => 1, 'msg' => '打分通过');
        } else {
            $info = array('code' => 2, 'msg' => '系统故障');
        }


        return json($info);
    }
        /*
     * 删除
     * */
    public function del()
    {
        $id=$_REQUEST['id'];

    
            $info =  Db::name('plan_evaluate')->delete($id);
            //Db::name('classinfo')->getLastsql();
            if($info)
            {
                $info = array('code'=>1,'msg'=>'删除策划打分成功');
            }else{
                $info = array('code'=>2,'msg'=>'删除策划打分失败');
            }
      

        return json($info);
    }
    public function recall()
    {

        if (\request()->isPost()){
            $post=input("param.");
            $data['id']=$post['id'];
            $this_evaluate=Db::name('plan_evaluate')->field('back,project_title')->find($post['id']);
            switch ($this->jurisdiction){
                case 1:
                    $data['admin_submit']=1;
                    break;
                case 2:
                    $data['is_submit']=1;
                    break;

            }
            $data['back']=$this_evaluate['back']+1;
            try {
                Db::name('plan_evaluate')->update($data);
                Db::name('aims')->where(['project_title'=>$this_evaluate['project_title'],'month'=>date('Y-m',strtotime('-1 month'))])->setDec('plan_complete');
            }catch(\Exception $e){
                return json(['code'=>2,'msg'=>$e->getMessage()]);
            }
            return json(['code'=>1,'msg'=>'撤回打分成功']);
        }
    }
    public function add_user()
    {
        $date1 = date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) ;
        $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目
        if ($this->request->isPost()) {
            $post = input('param.');
            $one_user=Db::name('users')->field('work_id,username,department,station')->where(['id'=>$post['users_id']])->find();
            $work_id=$one_user['work_id'];
            $username=$one_user['username'];
            $full = $work_id . sysconf('username_break') . $username;
            $data = [
                'project_title' => $project_name, //本项目
                'username' => $full, //全名：工号+姓名
                'userid' => $post['users_id'], //员工id
                'month' => $date1, //月份
                'station' =>14, //岗位id
                'department' => $one_user['department'],
                'work_id' => $work_id,
            ];
            try {
                Db::name('plan_evaluate')->insertGetId($data);
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
}
