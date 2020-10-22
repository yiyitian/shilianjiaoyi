<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends Common
{
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    /*
     * 保留方法
     * */
    public function index()
    {
        return $this->fetch();
    }
    public function uploads12()
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
                $url = '/public/uploads/'.str_replace("\\","/",$pic['savename']);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            $ret["msg"]= "上传成功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            return json($ret);
        }
    }
    /*
     * 删除上传文件
     */
    public function uploads_del()
    {

        if(Db::name('uploads')->where('id',$_POST['id'])->update(['del'=>'1']))
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }

    /*
     * 删除
     * */
    public function del()
    {
        $data = Db::name('task_list')->where('contract_num',Request::instance()->param('contract_num'))->find();
        if($data!==null)return json(array('code'=>2,'msg'=>'请删除任务清单'));
        if(Db::name('sales__department')->where('id='.input('id'))->delete())
        {
            $info = array('code'=>1,'msg'=>'删除成功');
        }else{
            $info = array('code'=>2,'msg'=>'删除失败');
        }
        return json($info);
    }
    /*
     * 添加
     * */
    public function add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['delivery_time'] = substr($_POST['delivery_time'],2);
             $_POST['contract_time'] = substr($_POST['delivery_time'],2);
            if(0!=(Db::name('sales__department')->insert($_POST)))
            {
                $data['code'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '添加失败';
            }
            return json($data);
        }else{
            $this->assign('times',time());
            return $this->fetch();
        }
    }
    /*
     * 编辑
     * */
    public function edit()
    {
        if (Request::instance()->isPost())
        {
            $info = Db::name('sales__department')->update($_POST);
            if($info!==false)
            {
                $data['code'] = 1;
                $data['msg'] = '更新成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '更新失败';
            }
            return json($data);
        }else{
            $date = Db::name('sales__department')->where('id',Request::instance()->param('id'))->find();
            $this->assign('times',$date['times']);
            $this->assign('list',$date);
            return $this->fetch('add');
        }


    }
    /*
     * 上传方法
     * */
    public function uploads()
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
                $url = '/public/uploads/'.str_replace("\\","/",$pic['savename']);
            }  else {
                $ret["message"] = $this->error($pic['err']);
                $ret["status"] = 0;
            }
            $ret["msg"]= "上传成1功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            if(!empty($_REQUEST['id'])){
                $info=Db::name('user')->where('id',$_REQUEST['id'])->update(['head_img'=>$url]);
                if($info){
                    return json($ret);
                }else{
                    $ret["msg"]= "头像修改失败";
                    return json($ret);
                }
            }
            if($this->request->param('times'))
            {
               $reserve = isset($_GET['reserve'])?$_GET['reserve']:1;
               $info = Db::name('uploads')->insert(array('url'=>$url,
                    'times'=>$this->request->param('times'),
                    'mark'=>$this->request->param('mark'),
                    'reserve' =>$reserve,
                    'filename' =>$_FILES["file"]["name"],
                    'updatetime' =>$_REQUEST['updatetime']));
                if($info){
                    return json($ret);
                }else{
                    $ret["msg"]= "保存记录失败";
                    return json($ret);
                }
            }else{
                $ret["msg"]= "记录值不能为空，请联系技术支持";
                return json($ret);
            }

        }
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
    /*
     * 修改 回款状态
     * */
    public function edit_back_money()
    {
        $_POST['status'] = -$_POST['status'];
        if(Db::name('sales__department')->update($_POST))
        {
            $info = array('msg'=>1,'info'=>'修改回款状态成功');
        }else{
            $info = array('msg'=>2,'info'=>'修改回款状态成功失败');
        }
        return json($info);
    }
    /*
     * 任务清单操作
     * */
    public function task_list()
    {
        if (Request::instance()->isPost())
        {
            $_POST['count_price'] = $_POST['unit_price']*$_POST['product_count'];

            $_POST['customer_name'] = Db::name('sales__department')->where('contract_num',$_POST['contract_num'])->value('customer_name');
                $_POST['is_mould'] = -1;
                $data = Db::name('task_list')->insert($_POST);
                if($data!=false)
                {
                    return json(array('code'=>1,'msg'=>'添加成功'));
                }else{
                    return json(array('code'=>2,'msg'=>'添加失败，请重试！！！'));
                }
        }else{
            $this->assign('times',time());
            $this->assign('delivery_time',Db::name('sales__department')->where('contract_num',$_GET['contract_num'])->value('delivery_time'));
            $this->assign('ContractNumber',$_GET['contract_num']);
            return $this->fetch();
        }
    }
    /*
     * 推送任务清单到下一部门
     * */
    public function edit_verified()
    {
        $_POST['is_verified'] = -$_POST['is_verified'];
        Db::startTrans();
        try{
            Db::name('sales__department')->update($_POST);
            Db::name('task_list')->where('contract_num',$_POST['contract_num'])->update(['is_sale'=>$_POST['is_verified']]);
            Db::commit();
            $info = array('msg'=>1,'info'=>'推送成功，清单已进入下一部门');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'推送失败，请联系技术人员支持');
        }
        return json($info);
    }

    /*
     * 清单编辑操作
     * */
    public function edit_task()
    {
        if (Request::instance()->isPost()){
            if(Db::name('task_list')->where('id',$_POST['id'])->update($_POST))
            {
                return json(array('code'=>1,'msg'=>'修改成功'));
            }else{
                return json(array('code'=>2,'msg'=>'修改失败，请重试！！！'));
            }
        }else{
            $date = Db::name('task_list')->where('id',$this->request->param('id'))->find();
            $this->assign('list',$date);
            $this->assign('times',$date['times']);
            $this->assign('delivery_time',Db::name('sales__department')->where('contract_num',$date['contract_num'])->value('delivery_time'));
            $this->assign('ContractNumber',$date['contract_num']);
            return $this->fetch('task_list');
        }
    }
    /*
     * 任务清单删除
     * */
    public function del_task()
    {
        if(Db::name('task_list')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    /*
   * 获取客户图片
   * */
    public function getImg()
    {
        $id = $_POST['id'];
        $date = [
            "title"  => "生产图片",
            "id"  => $id,
            "start"  => 0,
            "data" => Db::query("select id as alt,tid as pid,url as src,mark as thumb from ying_img where  tid = ".$id)
        ];
        return json($date);
    }
   /*
    * 财务申请列表
    * */
    public function finance()
    {
        if(isset($_GET['id']))
        {
            if(Request::instance()->isAjax())
            {
                $val = '%'.input('title').'%';
                $where['product_title'] = array('like',$val);
            }else{
                $where="1=1";
            }
            $count=Db::name('purchasing_consumables')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('purchasing_consumables')->where($where)->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }
    /*
     * 财务删除
     * */
    public function finance_del()
    {
        if(Db::name('account')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    /*
    * 推送任务清单到下一部门
    * */
    public function is_status()
    {
        $_POST['status'] = -$_POST['status'];
        Db::startTrans();
        try{
            Db::name('purchasing_consumables')->update($_POST);

            Db::commit();
            $info = array('msg'=>1,'info'=>'审核成功');
        } catch (\Exception $e) {
            Db::rollback();
            $info = array('msg'=>2,'info'=>'审核失败，请联系技术人员支持');
        }
        return json($info);
    }
    /*
     * 回款详情
     * */
    public function backs()
    {
        if(isset($_GET['id']))
        {
            $count=Db::name('back')->where('contract_num',$_GET['id'])->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('back')->where('contract_num',$_GET['id'])->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $this->assign('contract_num',$_GET['contract_num']);
            return $this->fetch();
        }
    }
    /*
  * 回款列表删除
  * */
    public function del_back()
    {
        if(Db::name('back')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    /*
   * 任务清单操作
   * */
    public function back_add()
    {
        if (Request::instance()->isPost())
        {
            if($_POST['status']=='1')
            {
                Db::name('sales__department')->where('contract_num',$_POST['contract_num'])->update(array('status'=>$_POST['status']));
                unset($_POST['status']);

            }

            $data = Db::name('back')->insert($_POST);
            if($data!=false)
            {
                return json(array('code'=>1,'msg'=>'添加成功'));
            }else{
                return json(array('code'=>2,'msg'=>'添加失败，请重试！！！'));
            }
        }else{
            $this->assign('ContractNumber',$_GET['contract_num']);
            return $this->fetch();
        }
    }


    /*
     * 日志列表
     * */
    public function condition()
    {
        if(isset($_GET['pid']))
        {
            $count=Db::name('words_log')->where('pid',$_GET['pid'])->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('words_logs')->where('contract_num',$_GET['id'])->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            return $this->fetch();
        }
    }

    public function status()
    {
        if (Request::instance()->isPost())
        {
            $info = Db::name('purchasing_consumables')->update($_POST);
            if($info!==false)
            {
                $data['code'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['code'] = 0;
                $data['msg']= '操作失败';
            }
            return json($data);
        }else{
            $this->assign('list',Db::name('purchasing_consumables')->where('id',Request::instance()->param('id'))->find());
            return $this->fetch('public/status');
        }
    }
    /*
     * 模具清单
     * */
    public function mould()
    {

        if(isset($_GET['id']))
        {
            $where['contract_num']  = array('eq',$_GET['id']);
            $where['is_mould'] = array('eq','1');
            $count=Db::name('task_list')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('task_list')->where($where)->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $data = Db::name('sales__department')->where('contract_num',$_GET['contract_num'])->value('is_verified');
            $this->assign('is_verified',$data?$data:0);
            $this->assign('contract_num',$_GET['contract_num']);
            return $this->fetch();
        }
    }
    /*
    * 编辑添加模具
    * */
    public function mould_add()
    {
        if (Request::instance()->isPost())
        {
            $_POST['customer_name'] = Db::name('sales__department')->where('contract_num',$_POST['contract_num'])->value('customer_name');
            $_POST['is_mould'] = 1;
            $data = Db::name('task_list')->insert($_POST);
            if($data!=false)
            {
                return json(array('code'=>1,'msg'=>'添加成功'));
            }else{
                return json(array('code'=>2,'msg'=>'添加失败，请重试！！！'));
            }
        }else{
            $this->assign('times',time());
            $this->assign('delivery_time',Db::name('sales__department')->where('contract_num',$_GET['contract_num'])->value('delivery_time'));
            $this->assign('ContractNumber',$_GET['contract_num']);
            return $this->fetch();
        }
    }
    /*
     * 模具编辑操作
     * */
    public function edit_mould()
    {
        if (Request::instance()->isPost()){
            if(Db::name('task_list')->where('id',$_POST['id'])->update($_POST))
            {
                return json(array('code'=>1,'msg'=>'修改成功'));
            }else{
                return json(array('code'=>2,'msg'=>'修改失败，请重试！！！'));
            }
        }else{
            $date = Db::name('task_list')->where('id',$this->request->param('id'))->find();
            $this->assign('list',$date);
            $this->assign('times',$date['times']);
            $this->assign('delivery_time',Db::name('sales__department')->where('contract_num',$date['contract_num'])->value('delivery_time'));
            $this->assign('ContractNumber',$date['contract_num']);
            return $this->fetch('mould_add');
        }
    }
    /*
     * 模具清单删除
     * */
    public function del_mould()
    {
        if(Db::name('task_list')->where('id='.input('id'))->delete())
        {
            $info = array('msg'=>200,'info'=>'删除成功');
        }else{
            $info = array('msg'=>100,'info'=>'删除失败');
        }
        return json_encode($info);
    }
    public function show_list()
    {

        if(isset($_GET['id']))
        {
            $where['contract_num']  = array('eq',$_GET['id']);
            $where['is_mould'] = array('eq','1');
            $count=Db::name('task_list')->where($where)->count();
            $page = $this->request->param('page');
            $limit = $this->request->param('limit');
            $tol=($page-1)*$limit;
            $list =Db::name('task_list')->where($where)->order('id asc')->limit($tol,$limit)->select();
            return ["code"=>"0","msg"=>"","count"=>$count,"data"=>$list];
        }else{
            $data = Db::name('sales__department')->where('contract_num',$_GET['contract_num'])->value('is_verified');
            $this->assign('is_verified',$data?$data:0);
            $this->assign('contract_num',$_GET['contract_num']);
            return $this->fetch();
        }

    }
}
