<?php

namespace app\rackstage\controller;

use app\rackstage\service\AimsService;
use app\rackstage\service\ClerkService;
use think\Db;
use think\Request;
use think\response\Json;

/**
 *文员考评
 * Class Clerk
 * @package app\rackstage\controller
 */
class Aims extends Common
{

    /**
     * @return Json
     */
    public function employee_edit()
    {
        $da = session('');
        $info = input('post.');
        try {
            Db::name('aims')->where('id', $info['id'])->update([$info['field'] => $info['value']]);
            Db::name('aims')->update(['id' => $info['id'], 'manager_id' => $info['manager_id']]);
        } catch (\Exception $e) {
            return json(['code' => 2, 'msg' => $e->getMessage()]);
        }
        return json(['code' => 1, 'msg' => '目标编辑完成']);
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
        (isset($post['project']) && $post['project'] != "") && $where['project_title'] = array('in', $post['project']);
        (isset($post['department']) && $post['department'] != "") && $where['department'] = array('in', $post['department']);
        (isset($post['date']) && $post['date'] != "") && $where['month'] = array('in', $post['date']);
        (isset($post['ids']) && $post['ids'] != "") && $where['user_id'] = array('in', $post['ids']);
        
        $user_id = $this->user_id;
        list($count, $page, $limit, $list) = AimsService::get_datas($request, $where, $this->jurisdiction, $user_id);
        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
    }

    public function edit_status()
    {
        $_POST['status'] = -$_POST['status'];
        Db::startTrans();
        try{
            Db::name('aims')->where('id',$_POST['id'])->update(['status'=>$_POST['status']]);
            AddLog(Db::name('aims')->getLastSql());
            Db::commit();
            $info = array('msg'=>1,'info'=>'启用成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'启用失败，请联系技术人员支持');
        }
        return json($info);
}

}
