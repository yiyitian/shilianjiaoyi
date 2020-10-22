<?php

namespace app\rackstage\controller;

use app\rackstage\service\BasicService;
use app\rackstage\service\LedgerService;
use think\Db;
use think\Request;

class Ledger extends Common
{
    /**
     * 查询台账
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ledger_search(Request $request)
    {
        $role_title = $this->role_title;
        $user_id = $this->user_id;
        $where['del']=-1;
        list($count, $page, $limit, $list) = LedgerService::get_data($request, $this->jurisdiction, $user_id);
        return json(['code' => '0', 'msg' => '', 'count' => $count, 'data' => $list, 'page' => $page, 'limit' => $limit]);
    }

    /**
     * 下载台账
     * @param Request $request
     */
    function download_file(Request $request)
    {
        $id = $request->get('id');
        $one = Db::name('clerk_upload')->where(['id' => $id])->find();
        db::name('clerk_upload')->where('id',$id)->update(['del'=>1]);
        $type = $one['type'] == 1?'来访':'成交';
        $name  = db::name('project')->where('id',$one['project'])->value('name').$one['month'].'份'.$type.'.xlsx';
        $file = '../' . $one['url'];
        BasicService::download($file,$name);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
