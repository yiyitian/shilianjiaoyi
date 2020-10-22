<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Assessment extends Common
{
    /*
     * 考核列表
     * */
    public function Index()
    {
        if(isset($_GET['num']))
        {
            $Info['curPageData'] = Db::name('testlist')->where('types',1)->limit((input('num')-1)*input('size'),input('size'))->select();
            foreach($Info['curPageData'] as $key=>$v)
            {
                $Info['curPageData'][$key]['times'] = date('Y-m-d',$v['times']);
            }
            return json($Info);
        }
        return $this->fetch();
    }
    /*
     * 考核详情
     * */
    public function Detail()
    {
        $uid = Session::get('userId');
        if (Request::instance()->isPost())
        {
            $info = json_decode(input('info'),true);
            $qid  = $info['qid'];unset($info['qid']);
            $list = json_decode(Session::get('answer'),true);
            $result=array_intersect_assoc($info,$list);
            $fraction = count($result);
            Db::name('question_answer')->where(['uid'=>$uid,'qid'=>$qid])->update(['answer'=>json_encode($info),'fraction'=>$fraction]);
            return json(['msg'=>$fraction]);
        }
        $info = Db::name('testlist')->where('id',input('id'))->find();
        $infoList = Db::name('testquestion')->where('id','in',$info['questions'])->select();
        $data = [];
        foreach($infoList as $key=>$val)
        {
            $data[$val['id']] = $val['true_option'];
        }
        $info =Db::name('question_answer')->where(['uid'=>$uid,'qid'=>input('id')])->find();
        if(!$info)
        {
            Db::name('question_answer')->insert([
                'uid'         => $uid,
                'qid'         => input('id'),
                'username'    => Session::get('username'),
            ]);

        }else if($info['fraction']!==null)
        {
            $this->assign('answer',json_decode($info['answer'],true));
            $this->assign('fraction',$info['fraction']);
        }
        Session::set('answer',json_encode($data));
        $this->assign('qid',input('id'));
        $this->assign('infoList',$infoList);
        return $this->fetch();
    }
    /*
     * 测试使用
     * */
    public function test()
    {

    }


}
