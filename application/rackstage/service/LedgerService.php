<?php


namespace app\rackstage\service;


use think\Db;
use think\Request;

/**
 * 台账
 * Class EmployeeService
 * @package app\rackstage\service
 */
class LedgerService
{
    /**
     * 查询台账数据
     * @param Request $request
     * @param $role
     * @param $user_id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get_data(Request $request, $role, $user_id)
    {
        $page = $request->param('page');
        $limit = $request->param('limit');
        $db = Db::name('clerk_upload');
        $post=input('param.');
        if ($role==2){
            $project_name = Db::name('project')->where(['manager'=>$_SESSION['think']['user_id'],'status'=>1])->value('id'); //项目

        }else{
            $this_one=Db::name('users')->where(['user_id'=>$_SESSION['think']['user_id']])->find();
            $project_name=$this_one['projectname'];
        }
        $tol = ($page - 1) * $limit;
        $where = [];
        switch ($role) {
            case 1:
                break;
            case 2:
                $where['project'] = $project_name;
                break;
            case 5:
                $where['userid'] = $user_id;
                $where['project'] = $project_name;
                break;
        }
        (isset($post['project']) && $post['project'] != "") && $where['project'] = array('in', $post['project']);

        if (isset($info['date']) && $info['date'] != '') {
            $where['month'] = $info['date'];
        }else{
            $where['month'] = date("Y-m", strtotime("last day of -1 month", time())) ;
        }
        $list = $db->where($where)->limit($tol, $limit)->fetchSql(false)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['project'] = db::name('project')->where('id',$v['project'])->value('name');
        }
        $count = $db->count();
        return array($count, $page, $limit, $list);
    }
}