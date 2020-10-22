<?php

namespace app\rackstage\controller;

use think\Request;
use think\Controller;
use app\rackstage\model\ErpCostume;
use think\Db;
use app\rackstage\model\ErpProject;
use app\rackstage\model\ErpBalance;
use app\rackstage\model\Manager;

class Test extends controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = db::name('train')->field('uid,classify_id')->select();
        $user = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->field('id,classid')->select();
        foreach($user as $k=>$v)
        {
            $users[$v['id']] = $v['classid'];
        }
        foreach($list as $k=>$v)
        {
            if(array_key_exists($v['uid'], $users))
            {
                $date = explode(',',$users[$v['uid']]);
                if(!in_array($v['classify_id'],$date))
                {
                    $dates = implode(',',$date);
                    if($dates == '')
                    {
                        db::name('users')->where('id',$v['uid'])->update(['classid'=>$v['classify_id']]);
                    }else{
                        $data = $dates.','.$v['classify_id'];
                        dd(db::name('users')->where('id',$v['uid'])->update(['classid'=>$data]));
                    }
                }
            }

        }
    }
    public function tests()
    {
        $info = db::name('users')->where(['is_quit'=>-1,'del'=>-1])->field('id,classid')->select();
        dd($info);
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function checkTrain()
    {
        $lists = db::name('train')->field('uid,classify_id')->select();
        foreach($lists as $k=>$v)
        {
            $list[$v['uid']][] = $v['classify_id'];
        }
        $user = db::name('users')->field('id,classid')->where(['is_quit'=>-1,'del'=>-1])->select();

        $array = [8,9,10,11,12,13,14,15,16];
        foreach($user as $k=>$v)
        {
            if(array_key_exists($v['id'], $list))
            {
                $classArr = explode(',',$v['classid']);
                $containArr = array_intersect($array,$classArr);
                $diffArr = array_diff($containArr,$list[$v['id']]);
                if(!empty($diffArr))
                {
                    foreach($diffArr as $val)
                    {
                        $insertArr = db::name('users')->where('id',$v['id'])->field('id as uid,work_id,username,phone,region,department,station,projectname as project_id')->find();
                        $insertArr['region_title'] = $this->getTitle(3,$insertArr['region']);
                        $insertArr['department_title'] = $this->getTitle(3,$insertArr['department']);
                        $insertArr['station_title'] = $this->getTitle(1,$insertArr['station']);
                        $insertArr['project_title'] = $this->getTitle(2,$insertArr['project_id']);
                        $outline = db::Name('outline')->where(['status'=>1,'del'=>-1,'classify'=>$val])->field('classify as classify_id,username as headmaster,times as class_time,startdate,enddate')->find();
                        $insertArr['classify_id'] = $val;
                        $insertArr['branch'] = 98;
                        $insertArr['classify_title'] = db::name('classinfo')->where('id',$val)->value('title');
                        if(!empty($outline))
                        {
                            $insert = array_merge($insertArr,$outline);
                            db::name('train')->insert($insert);
                        }else{
                            db::name('train')->insert($insertArr);
                        }
                    }
                }

            }else{
                if($v['classid'] !== "")
                {
                    $classArr = explode(',',$v['classid']);
                    $containArr = array_intersect($array,$classArr);
                    if(!empty($containArr))
                    {
                        foreach($containArr as $val)
                        {
                            $insertArr = db::name('users')->where('id',$v['id'])->field('id as uid,work_id,username,phone,region,department,station,projectname as project_id')->find();
                            $insertArr['region_title'] = $this->getTitle(3,$insertArr['region']);
                            $insertArr['department_title'] = $this->getTitle(3,$insertArr['department']);
                            $insertArr['station_title'] = $this->getTitle(1,$insertArr['station']);
                            $insertArr['project_title'] = $this->getTitle(2,$insertArr['project_id']);
                            $outline = db::Name('outline')->where(['status'=>1,'del'=>-1,'classify'=>$val])->field('classify as classify_id,username as headmaster,times as class_time,startdate,enddate')->find();
                            $insertArr['classify_id'] = $val;
                            $insertArr['branch'] = 98;
                            $insertArr['classify_title'] = db::name('classinfo')->where('id',$val)->value('title');
                            if(!empty($outline))
                            {
                                $insert = array_merge($insertArr,$outline);
                                db::name('train')->insert($insert);
                            }else{
                                db::name('train')->insert($insertArr);
                            }
                        }
                    }
                }
            }
        }
    }
    public function getTitle($types,$id)
    {
        if($types == 1)
        {
            return db::name('posts')->where('id',$id)->value('posts');
        }else if($types == 2)
        {
            return db::name('project')->where('id',$id)->value('name');
        }else{
            return db::name('framework')->where('id',$id)->value('name');
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
    }
}
