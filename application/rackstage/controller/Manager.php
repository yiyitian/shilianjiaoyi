<?php

namespace app\rackstage\controller;

use app\rackstage\service\EmployeeService;
use app\rackstage\service\ExportService;
use app\rackstage\service\ManagerService;
use think\Db;
use think\Request;
use think\response\Json;

/**
 * 项目经理考评
 * Class Manager
 * @package app\rackstage\controller
 */
class Manager extends Common
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
        try {
            Db::name('manager_evaluate')->where('id', $info['id'])->update([$info['field'] => $info['value']]);
            ManagerService::total_score($info, $field, $user_id,$this->jurisdiction);
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
        $info = input('');
        
        if(isset($info['project'])&&($info['project'] !==""))
        {
            $where['project_title'] = $info['project'];
        }
        if (isset($info['date']) && $info['date'] != '') {
            $where['month'] = $info['date'];
        }else{
            $where['month'] = date("Y-m", strtotime("last day of -1 month", time())) ;
        }
        if(!empty($info['project']))
        {
            $map['project_title'] =  ['in',$info['project']];
        }else{
            $map = 1;
        }
        $eve = db::name('aims')->where($map)->where('status',$info['status1'])->where('month',$where['month'])->group('project_title')->select();
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
        isset($_GET['history']) ? $where['admin_submit'] = 2 : $where['admin_submit'] = 1;
        list($count, $page, $limit, $list) = ManagerService::get_data($request, $where, $this->jurisdiction);
        foreach($list as $k=>$v)
        {
            $list[$k]['subscribe_rate'] = ($v['subscribe_rate']*100)."%";
            $list[$k]['profit'] = ($v['profit'] == 0)?"0%":$v['profit'].'%';
            $list[$k]['dep'] = getDepartment($v['department']);

        }

        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
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
            try {
                Db::name('manager_evaluate')->where(['manager_id' => $user_id])->update(['is_submit' => 2]);
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


//数据中对应的字段，用于读取相应数据：

        $where['del']=-1;
        $where['month']=date('Y-m',strtotime('-1 month'));
        $aim = db::name('aims')->where(['month'=>$where['month'],'project_title'=>getProject()])->value('status');
        if($aim == 1)
        {
            $arr=['编号', '事业部', '项目名称', '姓名', '工号', '认购完成得分', '考核数据真实得分', '利润完成得分', '总分'];
        }else{
            $arr=['编号', '事业部', '项目名称', '姓名', '工号', '计划书','蓄客率完成', '总分'];

        }
        switch($this->jurisdiction){
            case 1://
                (isset($post['project']) && $post['project'] != "0") && $where['project_name'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "0") && $where['department'] = array('in', $post['department']);
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
        $list = Db::name('manager_evaluate')->where($where)->select();
        if (empty($list)){
            return json(['code'=>2,'msg'=>'没有可导出数据']);
        }
        foreach ($list as $k => $v) {
            $list[$k]['department'] = Db::name('framework')->where(['id' => $v['department']])->value('name');
            $list[$k]['project_title'] = Db::name('project')->where(['id' => $v['project_title']])->value('name');
        }
        if($aim == 1)
        {
            $keys=['id','department','project_title','username','work_id','subscribe_score','authenticity','profit_score','total'];
        }else{
            $keys=['id','department','project_title','username','work_id','work_book_score','visiting_score','total'];

        }
        $file=ExportService::outdata(date('Y-m',strtotime('-1 month'))."项目经理考评", $list, $arr, $keys);
        return json(['code'=>1,'msg'=>'下载成功','url'=>$file]);


    }
    public function pass()
    {
        $id = $_REQUEST['id'];
        $info = Db::name('manager_evaluate')->update(['id' => $id, "admin_submit" => 2]);
        $this->getAllManager($id);
        if ($info) {
            $info = array('code' => 1, 'msg' => '打分通过');
        } else {
            $info = array('code' => 2, 'msg' => '系统故障');
        }
        return json($info);
    }
    public function del()
    {
        $id = $_REQUEST['id'];
        $info = Db::name('manager_evaluate')->delete($id);
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
            $this_evaluate=Db::name('manager_evaluate')->field('back,project_title')->find($post['id']);
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
                Db::name('manager_evaluate')->update($data);

            }catch(\Exception $e){
                return json(['code'=>2,'msg'=>$e->getMessage()]);
            }
            return json(['code'=>1,'msg'=>'撤回打分成功']);
        }
    }
    public function getAllManager($id)
    {
        $list =  db::name('manager_evaluate')->where('id',$id)->find();
        $subsidy = db::name('maintain')->where(['work_id'=>$list['work_id'],'project'=>$list['project_title']])->value('subsidy');
        if($subsidy>10)
        {
            $actual = $subsidy* $list['develop_costume'];
        }else{
            $actual = 0;
        }
        db::name('manager_evaluate')->where('id',$id)->update(['actual'=>$actual,'subsidy'=>$subsidy]);
        $info = db::name('maintain')->field('work_id,username,subsidy')->where('pid',$list['project_title'])->where('station','in','12,16,17')->where('work_id','<>',$list['work_id'])->select();
        
        if(!empty($info))
        {
            unset($list['id']);unset($list['userid']);unset($list['work_id']);unset($list['username']);
            if($info)
            {
                foreach($info as $k=>$v)
                {
                    $v['username'] = $v['work_id'].','.$v['username'];
                    $v += $list;
                    $v['actual'] = $v['subsidy'] * (int)$v['develop_costume']/100;
                    $dataArr[] = $v;
                }
                db::name('manager_evaluate')->insertAll($dataArr);
            }
        }

    }
}
