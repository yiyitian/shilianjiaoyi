<?php

namespace app\rackstage\controller;

use app\rackstage\service\AimsService;
use app\rackstage\service\ClerkService;
use app\rackstage\service\EmployeeService;
use app\rackstage\service\ExportService;
use app\rackstage\service\PlanService;
use app\rackstage\service\ProfitService;
use think\Db;
use think\helper\Time;
use think\Request;
use think\response\Json;

/**
 *文员考评
 * Class Clerk
 * @package app\rackstage\controller
 */
class Profit extends Common
{
    public function export()
    {


        $post = input("param.");
//设置表头：
        $arr = ['编号', '事业部', '项目', '项目经理', '成交金额（万元）', '平均代理费率', '物业费', '保证金扣款比率', '保证金扣款', '理论结算代理费', '人员数量', '人力成本', '二次薪(补助)', '联代补助', '提成比率', '二次薪（佣金）', '其他费用', '集团管理费率', '集团管理费金额', '税费率', '税费金额', '预计利润额'];


//数据中对应的字段，用于读取相应数据：

        $where['del'] = -1;
        switch ($this->jurisdiction) {
            case 1://
                (isset($post['project']) && $post['project'] != "0") && $where['project_name'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "0") && $where['department'] = array('in', $post['department']);
                break;
            case 2:

            case 7:
        
            $project_name=get_project($this->jurisdiction);
                $where['project_name'] = $project_name; //项目
                break;

            case 8:
                $where['department'] = Db::name('users')->where('user_id', $_SESSION['think']['user_id'])->value('department');
                break;

        }
        $list = Db::name('profit')->where($where)->select();
        if (empty($list)) {
            return json(['code' => 2, 'msg' => '没有可导出数据']);
        }
        foreach ($list as $k => $v) {
            $list[$k]['department'] = Db::name('framework')->where(['id' => $v['department']])->value('name');
            $list[$k]['project_name'] = Db::name('project')->where(['id' => $v['project_name']])->value('name');
        }
        $keys = array_keys((array)$list[0]);
        $file = ExportService::outdata(date('Y-m', strtotime(date('Y-m-01') . " - 1 month")) . "月度利润", $list, $arr, $keys);
        return json(['code' => 1, 'msg' => '下载成功', 'url' => $file]);
    }

    /**
     * @return Json
     */
    public function profit_edit()
    {
         $project_id= getProject();

        if (\request()->isPost()) {
            $post = json_decode(input('i'),true);
            $date = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $user=Db::name('user')->find($_SESSION['think']['user_id']);
            extract($post);
            $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
            $count = Db::name('profit')->where(['month' => $date, 'project_name' => $project_id])->count();
//            if ($count > 0 && !isset($post['id'])) {
//                return json(['code' => 3, 'msg' => '无需重复结算']);
//            }

            $margin_rate = zhuan($margin_rate);//
            
            $agency_rate = zhuan($agency_rate);
            $commission_ratio = zhuan($commission_ratio);
            $taxes_rate = zhuan($taxes_rate);
            $post['type'] == 1 ? $group_management_rate = 0.07 : $group_management_rate = 0.05;
            $margin = calc($turnover, $margin_rate, 'mul', 2);//保证金扣款
            //            $agency_fees = ($turnover * $agency_rate) - $margin;//理论结算代理费
          
            $agency_fees = calc(calc($turnover, $agency_rate, 'mul', 3), $margin, 'sub', 3);//理论结算代理费
         
//            $group_management_money = $agency_fees * $group_management_rate;//集团管理费
            $group_management_money = calc($agency_fees, $group_management_rate, 'mul', 2);//集团管理费

//            $taxes_money = $agency_fees * $taxes_rate;
            $taxes_money = calc($agency_fees, $taxes_rate, 'mul', 2);
         
//            $second_money2 = $agency_fees * $commission_ratio;
            $second_money2 = calc($agency_fees, $commission_ratio, 'mul', 2);

//            $total_profit = $agency_fees - $labor_costs - $second_money - $subsidies - $second_money2 - $else - $group_management_money - $taxes_money;
            $a = calc($agency_fees, $labor_costs, 'sub', 2);
            $b = calc($a, $second_money, 'sub', 2);
            $c = calc($b, $subsidies, 'sub', 2);
            $d = calc($c, $second_money2, 'sub', 2);
            $e = calc($d, $else, 'sub', 2);
            $f = calc($e, $group_management_money, 'sub', 2);
            $total_profit = calc($f, $taxes_money, 'sub', 2);
          
            // if($_SESSION['think']['user_id']==110){
            //     $total_profits = "{$agency_fees} - {$labor_costs} - {$second_money} - {$subsidies} - {$second_money2} - {$else} - {$group_management_money} - {$taxes_money}";
            //     dd($total_profits);
            // }
            $this_department = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->value('department');
            $data = [
                'project_name' => $project_id,
                'department' => $this_department,
                'username' => $user['user_name'],
                'turnover' => $turnover,//成交额
                'agency_rate' => $agency_rate,//平均代理费率
                'property' => $property,//物业费
                'margin_rate' => $margin_rate,//保证金扣款比率
                'margin' => $post['margin'],
                'agency_fees' => $agency_fees,//理论结算代理费
                'number' => $number,//人员数量
                'labor_costs' => $labor_costs,//人力成本
                'second_money' => $second_money,//二次薪(补助),
                'subsidies' => $subsidies,//联代补助
                'commission_ratio' => $commission_ratio,//提成比率
                'second_money2' => $second_money2,//二次薪(佣金)
                'else' => $else,//其他费用
                'group_management_rate' => $group_management_rate,//集团管理费率
                'group_management_money' => $group_management_money,//集团管理金额
                'taxes_rate' => $taxes_rate,//税费率
                'taxes_money' => $taxes_money,//税费金额
                'total_profit' => $total_profit,
                'month' => date('Y-m', strtotime(date('Y-m-01') . " - 1 month")),
                'userid' => $_SESSION['think']['user_id'],
                'type'=>$post['type'],
            ];

            try {
                if (isset($post['id'])) {
                    $data['id'] = $post['id'];
                    Db::name('profit')->update($data);
                } else {
                    Db::name('profit')->insert($data);
                }
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '理论利润计算成功']);

            return json($info);
        }
        $get = input('param.');
        if (isset($get['id'])) {
            $pid = $get['id'];
        } else {
            $pid = 0;
        }

        $this_profit = Db::name('profit')->find($pid);dd($this_profit);
        $this_profit['project_title'] = Db::name('project')->where(['id' => $this_profit['project_name']])->value('name');
        if (!empty($this_profit)){
            isset($this_profit['agency_rate']) && $this_profit['agency_rate']*=100;
            isset($this_profit['margin_rate'])&& $this_profit['margin_rate']*=100;
            isset($this_profit['commission_ratio'])&&$this_profit['commission_ratio']*=100;
            isset($this_profit['taxes_rate'])&& $this_profit['taxes_rate']*=100;
        }

        $month = date('Y-m', strtotime(date('Y-m-01') . " - 1 month"));
        $users = Db::name('users')->where(['user_id' => $_SESSION['think']['user_id']])->find();

        list($total_number, $total_money) = ProfitService::labor_cost_calculation($project_id);
        return $this->fetch('', compact('total_money', 'total_number', 'users', 'this_profit'));
    }

    
    public function labor_edit()
    {
        $da = session('');
        $user_id = $da['user_id'];
        $info = input('post.');
        (isset($info['manager_id']) && $info['manager_id'] != 0) ? $manager_id = $info['manager_id'] : $manager_id = 0;
        try {
            Db::name('months_costs')->where('id', $info['id'])->update([$info['field'] => $info['value']]);
            $data = Db::name('months_costs')->find($info['id']);
            $total = $data['number'] * $data['one'];
            Db::name('months_costs')->update(['id' => $info['id'], 'total' => $total, 'manager_id' => $user_id]);
        } catch (\Exception $e) {
            return json(['code' => 2, 'msg' => $e->getMessage()]);
        }
        return json(['code' => 1, 'msg' => '人员配置完毕']);

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
    public function profit_search(Request $request)
    {
        $da = session('');
        $role_title = $da['role_title'];
        $post = input('param.');
        $where['del'] = -1;
        (isset($post['date']) && $post['date'] != "") && $where['month'] = array('in', $post['date']);


        $user_id = $this->user_id;
        $page = $request->param('page');
        $limit = $request->param('limit');
        $tol = ($page - 1) * $limit;
        switch ($this->jurisdiction) {
            case 1:
                (isset($post['project']) && $post['project'] != "") && $where['project_name'] = array('in', $post['project']);
                (isset($post['department']) && $post['department'] != "") && $where['department'] = array('in', $post['department']);
                (isset($post['ids']) && $post['ids'] != "") && $where['userid'] = array('in', $post['ids']);
                break;
            case '2':
                $where['project_name'] = getProject();
                # code...
                break;
            default:
                # code...
                break;
        }

        $list = Db::name('profit')->where($where)->limit($tol, $limit)->select();
        $count = Db::name('profit')->where($where)->count();

        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
    }

    /*
   * 获取分类下分类
   * */
    public function getCate()
    {
        $data['framework'] = Db::name('framework')->where('pid', input('pid'))->select();
        $post_pid = Db::name('framework')->where('id', input('pid'))->value('type');

        $data['post'] = Db::name('posts')->where('pid', $post_pid)->select();
        return json($data);
    }

    public function add_user()
    {
        if (\request()->isPost()) {
            $post = input('param.');
            $station = $post['posts'];
            $join_date = $post['join_date'];
            list($start, $end) = Time::lastMonth();
            $days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime('-1 month')), date('Y'));
            $end = date('Y-m-d', $end);
            $cha = diffBetweenTwoDays($end, $join_date);
            $this_posts = Db::name('posts')->where(['id' => $station])->find();
            $rate = calc($cha, $days, 'div', 2);
            $project = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id');
            $data = [
                'station' => $station,
                'station_name' => $this_posts['posts'] . '(未足月)',
                'number' => $rate,
                'month' => date('Y-m', strtotime(date('Y-m-01') . " - 1 month")),
                'project' => $project,
                'one' => $this_posts['total_money'],
                'total' => calc($this_posts['total_money'], $rate, 'mul', 2),
                'full' => 2,
            ];
            try {
                Db::name('months_costs')->insertGetId($data);
            } catch (\Exception $e) {
                return json(['code' => 2, 'msg' => $e->getMessage()]);
            }
            return json(['code' => 1, 'msg' => '添加人员成功']);

        }
        $posts = Db::name('posts')->where(['pid' => 2])->select();
        return $this->fetch('', compact('posts'));
    }

    public function labor_del()
    {
        # code...
        $id = $_REQUEST['id'];


        $info = Db::name('months_costs')->delete($id);
        //Db::name('classinfo')->getLastsql();
        if ($info) {
            $info = array('code' => 1, 'msg' => '删除人员打成功');
        } else {
            $info = array('code' => 2, 'msg' => '删除人员打失败');
        }


        return json($info);
    }

}
