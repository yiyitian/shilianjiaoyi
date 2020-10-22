<?php

namespace app\rackstage\controller;

use app\rackstage\service\ClerkService;
use app\rackstage\service\EmployeeService;
use app\rackstage\service\ExportService;
use think\Db;
use think\Request;
use think\response\Json;

/**
 *文员考评
 * Class Clerk
 * @package app\rackstage\controller
 */
class Clerk extends Common
{

    /**
     * @return Json
     */
    public function employee_edit()
    {
        $da = session('');
        $user_id = $da['user_id'];
        $info = input('post.');
        $j = $this->jurisdiction;
        $field = $info['field'];
        try {
            Db::name('clerk_evaluate')->where('id', $info['id'])->update([$info['field'] => $info['value']]);
            ClerkService::total_score($info, $field, $user_id, $j);
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
        $where['station'] = 21;
        (isset($post['project']) && $post['project'] != "") && $where['project_title'] = array('in', $post['project']);
                // (isset($post['department']) && $post['department'] != "") && $where['department'] = array('in', $post['department']);

        if (isset($info['date']) && $info['date'] != '') {
            $where['month'] = $info['date'];
        }else{
            $where['month'] = date("Y-m", strtotime("last day of -1 month", time())) ;
        }
        $user_id = $this->user_id;
        list($count, $page, $limit, $list) = ClerkService::get_data($request, $where, $this->jurisdiction, $user_id);
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
        if($this->jurisdiction == 5)
        {
            $this_project = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->value('projectname');
        }else{
            $this_project=getProject();
        }
            $is_true = db::name('project')->where('id',$this_project)->value('is_true');
            if($is_true<0)
            {
                return json(['code'=>2,'msg'=>'请先去组织架构-》项目管理-》项目人员确认人员数据']);
            }
            if($this_project==null){
                return json(['code'=>2,'msg'=>'无数据插入']);
                            }

            $this_department = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->value('department');
            //已打分
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));

            $rated = Db::name('clerk_evaluate')->where(['project_title' => $this_project,'month'=>$month])->fetchSql(false)->column('userid');//已生成得打分表

            if(empty($rated)) $rated = 1;
            $w['projectname'] = ['neq', 0];
            //$w['del'] = -1;
            $w['station'] = 21;
            //$w['is_quit']=-1;

            $wheres = db::name('maintain')->field('uid as id')->where('pid',$this_project)->where('station','21')->select();
            foreach($wheres as $k=>$v)
            {
                $map[] = $v['id'];
            }
            $w['id'] = ['in',$map];
            $else = Db::name('users')->where($w)->whereNotIn('id', $rated)->select();
            $log = [];
            foreach ($else as $k => $v) {
                $full = $v['work_id'] . sysconf('username_break') . $v['username'];
                $el_count = Db::name('clerk_evaluate')->where(['username' => $full,'project_title'=> $this_project, 'month' => $month])->select();
                if (empty($el_count)) {
                    $log[] = [
                        'project_title' => $this_project,//本项目
                        'username' => $full,//全名：工号+姓名
                        'userid' => $v['id'],//员工id
                        'month' => $month,//月份
                        'station' => $v['station'],//岗位id
                        'subsidy' => db::name('maintain')->where(['project'=>$this_project,'uid'=>$v['id']])->value('subsidy'),
                        'department' => $this_department,
                        'work_id'=>$v['work_id']
                    ];
                }
            }
            try {
                Db::name('clerk_evaluate')->insertAll($log);
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
            $user_id = $da['user_id'];//当前账号
            $role = $da['role'];
            $role_title = $da['role_title'];
            $month = date('Y-m');
            $jurisdiction = $this->jurisdiction;
            $complete_count = 0;
        
            $project_name=get_project($this->jurisdiction);
            switch ($jurisdiction) {
                case 1:
                    $complete_count = Db::name('clerk_evaluate')->where(['month' => $month, 'admin_id' => 0,'is_submit'=>2])->count();
                    break;
                case 2:
                    $complete_count = Db::name('clerk_evaluate')->where(['month' => $month, 'manager_id' => 0,'project_title'=>$project_name])->count();
                    break;
            }

            if ($complete_count > 0) {
                return json(['code' => 3, 'msg' => '请完成全部打分']);
            }
            try {
                ClerkService::handle_employee($jurisdiction, $user_id);
                switch ($jurisdiction) {
                    case 1:
                        Db::name('clerk_evaluate')->where(['admin_id' => $user_id])->update(['admin_submit' => 2]);
                        break;
                    case 2:
                        Db::name('clerk_evaluate')->where(['manager_id' => $user_id])->update(['is_submit' => 2]);
                        break;
                }

            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '打分已完成']);

        }
    }

    public function export()
    {
        $post=input("param.");
//设置表头：
        $arr=['编号','事业部', '项目', '姓名','工号', '计划书完成得分','备注', '总分'];


//数据中对应的字段，用于读取相应数据：

        $where['del']=-1;
        $where['month']=date('Y-m',strtotime('-1 month'));

        switch($this->jurisdiction){
            case 1://
                (isset($post['project']) && $post['project'] != "0") && $where['project_title'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "0") && $where['department'] = array('in', $post['department']);
                $where['admin_submit']=2;
                break;
            case 2:



            case 7:
        
            $project_name=get_project($this->jurisdiction);
                $where['project_title']=$project_name;
                break;
            case 8:
                $where['department']=Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department');
                break;

        }

        $list = Db::name('clerk_evaluate')->where($where)->fetchSql(false)->select();
        if (empty($list)){
            return json(['code'=>2,'msg'=>'没有可导出数据']);
        }
        foreach ($list as $k => $v) {
            $list[$k]['department'] = Db::name('framework')->where(['id' => $v['department']])->value('name');
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
        }
        $keys=['id','department','project_title','username','work_id','work_book_score','mark','total_real'];
        $file=ExportService::outdata(date('Y-m',strtotime('-1 month'))."文员考评", $list, $arr, $keys);
        return json(['code'=>1,'msg'=>'下载成功','url'=>$file]);

    }

    public function pass()
    {
        # code...
        $id = $_REQUEST['id'];
        $info = db::name('clerk_evaluate')->where('id',$id)->find();
        $actual = $info['subsidy'] * $info['total'] / 100;
        $info = Db::name('clerk_evaluate')->update(['id' => $id, "admin_submit" => 2,'actual'=>$actual]);
        //Db::name('classinfo')->getLastsql();
        if ($info) {
            $info = array('code' => 1, 'msg' => '打分通过');
        } else {
            $info = array('code' => 2, 'msg' => '系统故障');
        }


        return json($info);
    }
    public function del()
    {
        # code...
        $id = $_REQUEST['id'];


        $info = Db::name('clerk_evaluate')->delete($id);
        //Db::name('classinfo')->getLastsql();
        if ($info) {
            $info = array('code' => 1, 'msg' => '删除文员打分成功');
        } else {
            $info = array('code' => 2, 'msg' => '删除文员打分失败');
        }


        return json($info);
    }
    public function recall()
    {

        if (\request()->isPost()){
            $post=input("param.");
            $data['id']=$post['id'];
            $this_evaluate=Db::name('clerk_evaluate')->field('back,project_title')->find($post['id']);
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
                Db::name('clerk_evaluate')->update($data);
                Db::name('aims')->where(['project_title'=>$this_evaluate['project_title'],'month'=>date('Y-m',strtotime('-1 month'))])->setDec('clerk_complete');
            }catch(\Exception $e){
                return json(['code'=>2,'msg'=>$e->getMessage()]);
            }
            return json(['code'=>1,'msg'=>'撤回打分成功']);
        }
    }

    public function delAllClerk()
    {
        $info = db::name('clerk_upload')->field('user_id as clerk_id,type,month,project')->where('id',input('id'))->find();
        if($info['type']  == 1)
        {
            $list = db::name('costume')->where(['clerk_id'=>$info['clerk_id'],'month'=>$info['month']])->select();
            if(!empty($list))
            {
                db::name('costume')->where(['clerk_id'=>$info['clerk_id'],'month'=>$info['month']])->delete();
            }
        }else{
            $list = db::name('deal')->where(['clerk_id'=>$info['clerk_id'],'month'=>$info['month'],'project'=>$info['project']])->select();
            if(!empty($list))
            {
                db::name('deal')->where(['clerk_id'=>$info['clerk_id'],'month'=>$info['month'],'project'=>$info['project']])->delete();
            }
        }
        db::name('clerk_upload')->where('id',input('id'))->delete();
        return json(['code'=>1,'msg'=>'成功删除'.$info['month'].'月台账']);

    }

}
