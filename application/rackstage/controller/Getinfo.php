<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Getinfo extends Common
{
    /*
    * 记录日志
    * */
    public function _initialize(){
        parent::get_user_operation();
    }
    /*
     * 获取项目
     * */
    public function getProject()
    {
        if(!empty($_GET['pid']))
        {
            foreach($_GET['pid'] as $key=>$val){
                $data=Db::name('project')->where('framework_id',$val)->field('id as value,name')->where('status','1')->where('del',-1)->select();
                $group=[
                    ['name'=>Db::name('framework')->where('id',$val)->value('name'),'type'=>'optgroup']
                ];
                if(!isset($datas)){
                    $datas=array();
                }
                $datas=array_merge($datas,array_merge($group,$data));
            }
            return json($datas);
    }

    }
    /*
     * 获取项目
     * */
    public function getstation()
    {
        $data=Db::name('posts')->where('id','in',$_REQUEST['station'])->order('pid asc')->select();
        foreach ($data as $key => $val){
            $data[$key]['pid_name']=Db::name('posts')->where('id',$val['pid'])->value('posts');
        }
        return json(['code'=>'0','msg'=>'筛选岗位成功','data'=>$data]);
    }
}
