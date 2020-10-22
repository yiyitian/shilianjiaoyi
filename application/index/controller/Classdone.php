<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Classdone extends Common
{
    /*
     * 考核列表
     * */
    public function Index()
    {
        if(isset($_GET['num']))
        {
            $classid = Db::name('users')->where('id',$_SESSION['think']['userId'])->value('classid');
            $Info['curPageData'] = Db::name('classinfo')->where('id','in',$classid)->limit((input('num')-1)*input('size'),input('size'))->select();
            //var_dump($Info);
            foreach($Info['curPageData'] as $key=>$v)
            {
                $Info['curPageData'][$key]['pid'] = Db::name('classinfo')->where('id',$v['pid'])->value('title') ;
                $Info['curPageData'][$key]['cid'] = Db::name('outline')->where('classname',$v['id'])->value('id') ;
                $Info['curPageData'][$key]['is_online'] = $this->getLevel($v['levels'],$v['pid']);
            }
            return json($Info);
        }
        return $this->fetch();
    }

    public function getLevel($level,$id)
    {
        if($level == '2')
        {
            $name = db::name('classinfo')->where('id',db::name('classinfo')->where('id',$id)->value('pid'))->value('title');
        }else
        {
            $name = db::name('classinfo')->where('id',$id)->value('title');
           
        }
        
        if($name !== '在线课堂')
        {
            return 1;
        }else{
            return 2;
        }
    }

    
}
