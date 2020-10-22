<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/7/6
 * Time: 17:37
 */
namespace app\api\controller;
use app\api\model\Users;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
class User extends Common
{
     public function getDepartments()
    {
        $id = Request::instance()->param('id');
        if($id>0)
        {
            $dateArr = explode(",",Db::name('files')->where('id',$id)->value('role'));
        }else{
            $dateArr = [];
        }
        //$date = Db::query("select id as value,title as title from shilian_cate where pid='0' ");
        $date = Db::name("framework")->where('status','1')->where('cid','in','-1')->where('cid','neq','')->field('id as value,name as title')->order('id asc')->select();
        foreach($date as $key=>$val)
        {
            if(in_array($val['value'],$dateArr))
            {
                $date[$key]['checked'] = true;
            }
            $data =  Db::name("framework")->where('status','1')->where('cid',$val['value'])->where('cid','neq','')->field('id as value,name as title')->order('id desc')->select();
            if(empty($data))
            {
                $date[$key]['data'] = [];
            }else{
                foreach($data as $k=>$v)
                {
                    if(in_array($v['value'],$dateArr))
                    {
                        $data[$k]['checked'] = true;
                    }
                    $data[$k]['data'] = [];
                }
                $date[$key]['data'] = $data;
            }
        }
        return  json_encode($date);
    }
    public function indexs()
    {
        $info = Users::get(session('userId'))->toArray();
        if($info['is_teacher'] == '1')
        {
            $this->assign('is_teacher','1');
        }else{
            $this->assign('is_teacher','-1');
        }
        $info['region'] = getName(1,$info['region']);
        $info['department'] = getName(1,$info['department']);
        $info['station'] = getName(2,$info['station']);
        if($info['user_id'] !== '')
        {
            $role = db::Name('user')->where('id',$info['user_id'])->value('role');
            if(($role == '36')||(session('userId') == 1))
            {
                $this->assign(['role'=>$role,'userId'=>$info['user_id']]);
            }
        }
        return $this->fetch('index',['info'=>$info,'station'=>session('station')]);
    }

    /*
     * 个人资料
     * */
    public function Personal()
    {
        if(Request::instance()->isPost())
        {
            $info = input('');
            if(!isset($info['harea']))
            {
                return json(['code'=>0,'msg'=>'请选择所在地']);
            }else{
                $info['domicile'] = $info['hcity'].'-'.$info['hproper'].'-'.$info['harea'];
                unset($info['hcity']);
                unset($info['hproper']);
                unset($info['harea']);
            }
            $return = Users::update($info,$info['id']);
            if($return)
            {
                return json(['code'=>1,'msg'=>'修改成功']);
            }else{
                return json(['code'=>0,'msg'=>'修改失败']);
            }
        }
        $info = Users::get(session('userId'))->toArray();
        $info['regions'] = getName(1,$info['region']);
        $info['departments'] = getName(1,$info['department']);
        $info['stations'] = getName(2,$info['station']);
        $info['projectnames']  = Db::name('project') ->where('id',$info['projectname'])->value('name');
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        return $this->fetch('',['info'=>$info]);
    }

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
            $ret["msg"]= "上传成功";
            $ret["status"] = 1;
            $ret["src"] = $url;
            $ret['code'] = 0;
            if($this->request->param('id'))
            {
                $reserve = isset($_GET['reserve'])?$_GET['reserve']:1;
                Db::name('img')->insert(array('url'=>$url,'tid'=>$this->request->param('id'),'mark'=>$this->request->param('mark'),'reserve' =>$reserve));

            }
            if($this->request->param('cid'))
            {

                Db::name('users')->where('id',$this->request->param('cid'))->update(['avatar'=>$url]);

            }
            return json($ret);
        }
    }
    /*
     * 文件上传实际操作
     * */
    private  function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录?
        $info = $file->move(ROOT_PATH . 'public/uploads');
        $reubfo = array();
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();
        }
        return $reubfo;
    }


    public function uploads12()
    {
        header("Access-Control-Allow-origin:*");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }


        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }
//
//var_dump($_REQUEST);
//
// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time
        @set_time_limit(5 * 60);

        $targetDir = 'upload_tmp';   //切片保留路径
        $uploadDir = 'upload';       //最终上传路径

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

// Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

// Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
            $size = $_REQUEST["size"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
            $size = $_REQUEST["file"]["size"];
        } else {
            $fileName = uniqid("file_");
        }
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                // echo '123';
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id","uploadPath":$uploadPath}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                // echo '1';
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }



        //查询当前是否已经入库过数据
        $arr = @Db('upload')->where('url',"$uploadPath")->find();
        // print_r($arr);
        if($arr)
        {
            echo ('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        }
        else
        {
            $res=Db('upload')->insert(['cid'=>input('cid'),'url'=>$uploadPath,'size'=>$size,'name'=>$fileName,'times'=>date('Y-m-d'),'uid'=>session('userId'),'uname'=>session('userName')]);
        }

    }

    /*
     * 修改密码
     * */
    public function updatePwd()
    {
        if(Request::instance()->isPost())
        {
            $userInfo = Users::get(session('userId'))->toArray();
            if(md5($userInfo['random'].input('pwd'))!==$userInfo['pass'])return json(['code'=>2,'msg'=>'密码错误']);
            $return = Users::where('id',$userInfo['id'])->update(['pass'=>md5($userInfo['random'].input('newPwd'))]);
            if($return)
            {
                return json(['code'=>1,'msg'=>'修改成功']);
            }else{
                return json(['code'=>0,'msg'=>'修改失败']);
            }
        }
        return $this->fetch();
    }
    /*
     * 退出
     * */
    public function exitLogin()
    {
        session(null);
        $this->redirect('/api/Login/login');
    }

    /*
     * 通知公告
     * */
    public function Massage()
    {
        $department = Users::where('id',session('userId'))->value('department');
        $list = db::name('article')
            ->where("find_in_set(".$department.",department)")
            ->where("find_in_set(".session('station').",station)")
            ->order('id desc')->select();
        $cate = db::Name('article_cate')->where('pid',2)->select();
        foreach($cate as $k=>$v)
        {
            $date[] = db::name('article')
                ->where("find_in_set(".$department.",department)")
                ->where("find_in_set(".session('station').",station)")
                ->where('pid',$v['id'])
                ->order('id desc')->select();
        }
        return $this->fetch('',['list'=>$date,'cate'=>$cate]);
    }

    public function Massages()
    {

        $list = db::name('project_article')
            ->order('id desc')->select();
        $cate = db::Name('article_cate')->where('pid',1)->select();
        foreach($cate as $k=>$v)
        {
            $date[] = db::name('project_article')
                ->where('pid',$v['id'])
                ->order('id desc')->select();
        }
        return $this->fetch('',['list'=>$date,'cate'=>$cate]);
    }
    /*
     * 公告详情
     * */
    public function Detail()
    {
        $classInfo = Db::name('article')->where('id',input('id'))->find();
        $re = Db::name('ready')->where(['gid'=>input('id'),'uid'=>session('userId'),'ready'=>1])->find();

        if($re)
        {
            $this->assign('re',1);
        }else{
            $this->assign('re',2);

        }
        $de = Db::name('ready')->where(['gid'=>input('id'),'uid'=>session('userId'),'do'=>1])->find();
        if($de)
        {
            $this->assign('du',1);
        }else{
            $this->assign('du',2);

        }
        if(empty($classInfo['seen'])){
            $classInfo['seen']=Session::get('userId');
            Db::name('article')->update($classInfo);
        }else{
            $classInfo['seen']=$classInfo['seen'].','.Session::get('userId');
            $classInfo['seen']=implode(',',array_unique(explode(',',$classInfo['seen'])));
            Db::name('article')->update($classInfo);
        }
        $classInfo['content']=str_replace("&amp;nbsp;","&nbsp;",$classInfo['content']);
        $this->assign('article',$classInfo);
        $info = Db::name('users')->where('id',session('userId'))->value('station');
        $data = stristr($classInfo['stations'],$info);
        if($info)
        {
            $this->assign('ids',1);
        }else{
            $this->assign('ids',2);
        }
        return $this->fetch();
    }

    /*
     * 确认已读
     * */
    public function addReady()
    {
        $list = Db::name('ready')->where(['gid'=>input('gid'),'uid'=>session('userId'),'ready'=>1])->find();
        if($list)
        {
            return json(['msg'=>'已经读过了','code'=>1]);
        }
        $info = Db::name('users')->field('username,region,department,station,projectname')->where('id',session('userId'))->find();
        $info['region'] = db::name('framework')->where('id',$info['region'])->value('name');
        $info['department'] = db::name('framework')->where('id',$info['department'])->value('name');
        $info['station'] = db::name('posts')->where('id',$info['station'])->value('posts');
        $info['project'] = db::name('project')->where('id',$info['projectname'])->value('name');
        $info['gid'] = input('gid');
        $info['uid'] = session('userId');
        $info['ready'] = 1;
        unset($info['projectname']);
        $infos = Db::name('ready')->insert($info);
        if($infos)
        {
            return json(['msg'=>'成功阅读','code'=>1]);
        }else{
            return json(['msg'=>'阅读失败','code'=>2]);
        }

    }
    /*
     * 公告完成
     * */
    public function addDu()
    {
        $list = Db::name('ready')->where(['gid'=>input('gid'),'uid'=>session('userId')])->find();
        if($list['do'] == 1)
        {
            return json(['msg'=>'已经完成了','code'=>1]);
        }else if($list['ready'] !== '1'){
            return json(['msg'=>'还没有阅读呢','code'=>1]);
        }
        $infos = Db::name('ready')->where('id',$list['id'])->update(['do'=>1]);
        if($infos)
        {
            return json(['msg'=>'公告完成','code'=>1]);
        }else{
            return json(['msg'=>'公告失败','code'=>2]);
        }

    }

    public function Achievements()
    {
        if(in_array(session('station'),['18','19']))
        {
            $role = '19';
        }else if(in_array(session('station'),['13','14','15']))
        {
            $role = '13';
        }else if(in_array(session('station'),['21']))
        {
            $role = '21';
        }
        if(!isset($role))
        {
            $userId = Users::where('id',session('userId'))->value('user_id');
            $role = db::name('user')->where('id',$userId)->value('role');
            if($role == '36')
            {
                $role = '36';
            }
        }
        if(session('userId' ==1))
        {
            $role = 36;
        }

        return $this->fetch('',['role'=>$role]);
    }

    /*
     * 职业顾问考核详情
     * */
    public function achievement()
    {
        switch (input('cid'))
        {
            case 1:
                $table = 'clerk_evaluate' ;
                break;
            case 2:
                $table = 'employee_evaluate' ;
                break;
            case 3:
                $table = 'plan_evaluate' ;
                break;
            default:
                $table = 'manager_evaluate' ;
        }

        if(!in_array(session('station'),[13,14,15,18,19,21]))
        {
            $userId = Users::where('id',session('userId'))->value('user_id');
            $role = db::name('user')->where('id',$userId)->value('role');
            if($role == '36')
            {
                $id = db::name('project')->field('id')->where('manager',session('userId'))->select();
                if(empty($id)){
                    $list = "";
                }else{
                    foreach($id as $k=>$v)
                    {
                        $ids[] = $v['id'];
                    }
                    $list = db::name($table)->where('project_title','in',$ids)->order('month desc')->select();
                }

            }
        }else{
            $list = db::name($table)->where('userid',session('userId'))->order('month desc')->select();
        }
        if(!isset($list))
        {
            $list = "";
        }
        if(session('userId') == 1)
        {
            $list = db::name($table)->order('month desc')->select();
        }
        if("" !== $list)
        {
            foreach($list as $k=>$v)
            {
                $isTure = strpos($v['username'],"S");
                if($isTure === false)
                {
                    $list[$k]['username'] = str_replace(',','',$v['username']);
                    $list[$k]['workId'] = '无';
                }else{
                    $work = explode(',',$v['username']);
                    $list[$k]['username'] = $work[1];
                    $list[$k]['workId'] = $work[0];
                }
            }
        }
        return $this->fetch('',['list'=>$list,'cid'=>input('cid')]);
    }
    /*
     *详情
     * */
    public function achievementDetails()
    {
        switch (input('cid'))
        {
            case 1:
                $table = 'clerk_evaluate' ;
                break;
            case 2:
                $table = 'employee_evaluate' ;
                break;
            case 3:
                $table = 'plan_evaluate' ;
                break;
            default:
                $table = 'manager_evaluate' ;
        }
        $list = db::name($table)->where('id',input('id'))->find();
        $list['project'] = db::name('project')->where('id',$list['project_title'])->value('name');
        if(isset($list['subscribe_score'])&&($list['subscribe_score'] == ''))
        {
            $this->assign('status',1);
        }
        if(isset($list['profit_score']))
        {
            if(($list['develop_costume'] >0)||($list['work_book_score']>0))
            {
                $this->assign('status',1);
            }
        }
        return $this->fetch('',['cid'=>input('cid'),'info'=>$list]);
    }
    public function pan()
    {
        $info = Users::where('id',session('userId'))->find()->toArray();
        $list = db::name('files')->where("find_in_set(".$info['department'].",role)")->select();
        if($info['id'] ==1)
        {
            $list = db::name('files')->select();
        }
        return $this->fetch('',['info'=>$info['department'],'list'=>$list]);
    }
    public function add()
    {
       if(Request::instance()->isPost())
        {
            
           
            $info = input('');
            $titleArr = db::name('framework')->where('id','in',$info['role'])->field('name')->select();
            foreach($titleArr as $k=>$v)
            {
                $data[] = $v['name'];
            }
            $info['department'] = implode(',',$data);
            if(db::name('files')->insert($info))
            {
                $date = ['code'=>1,'msg'=>'创建文件夹成功'];
            }else{
                $date = ['code'=>2,'msg'=>'创建文件夹失败'];
            }
            return json($date);
        }
        $list = db::name('framework')->where('pid','>','0')->where('status',1)->select();
        return $this->fetch('',['list'=>$list]);
    }

    public function lists()
    {
        if(null !== input('search'))
        {
            $where['name'] = array('like',"%".input('search').'%');
        }
        $where['cid'] = ['eq',input('id')];
        $list = db::name('upload')->where($where)->order('id desc')->select();
        foreach($list as $k=>$v)
        {
            $result = substr($v['name'],strripos($v['name'],".")+1);
            $array = ['png','jpg','jpeg','gif'];
            $word = ['doc','ppt','xls','docx','xlsx','pptx'];
            if($v['size']>1000000)
            {
                $list[$k]['size'] = ($v['size']/1000).'K';
            }else{
                $list[$k]['size'] = ($v['size']/1000000).'M';
            }
            if(in_array($result,$array))
            {
                $list[$k]['urls'] = "/public/".$v['url'];
            }else if($result == 'mp4')
            {
                $list[$k]['urls'] = "/public/".$v['url'];
            }else if(in_array($result,$word)){
                $list[$k]['urls'] = "https://view.officeapps.live.com/op/view.aspx?src=http://app.sz-senox.com/public/".$v['url'];
            }else{
                $list[$k]['urls'] = "/api/downFile/downFile?url=".$v['url'];
            }


        }
        return $this->fetch('',['id'=>input('id'),'list'=>$list]);
    }
    public function uploads1(Request $request)
    {

        $file = $request->file('file');
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {

                $saveName = str_replace("\\", '/', $info->getSaveName());
                $arr['url'] = '/public/uploads/' . $saveName;
                $arr['cid'] = input('cid');
                $arr['name'] = $info->getInfo()['name'];
                $arr['size'] = $info->getInfo()['size']/1024;
                $arr['times'] = date('Y-m-d',time());
                Db::name('upload')->insert($arr);
                return json(['code' => 1, 'msg' => '上传成功', 'url' => $info->getSaveName()]);
            } else {
                return json(['code' => 2, 'msg' => '系统故障', 'url' => $file->getError()]);
            }
        }
    }

    public function scan()
    {
        return $this->fetch();
    }

    public function ceshi()
    {
        return $this->fetch();
    }
    public function setAvatar()
    {
        $info = Users::get(session('userId'))->toArray();
        $info['regions'] = getName(1,$info['region']);
        $info['departments'] = getName(1,$info['department']);
        $info['stations'] = getName(2,$info['station']);
        $info['projectnames']  = Db::name('project') ->where('id',$info['projectname'])->value('name');
        $this->assign('region',Db::name('framework')->where('pid','-1')->order('id asc')->select());
        return $this->fetch('',['info'=>$info]);
    }
    public function getCertificate($name,$id,$types)
    {
        $have = db::name('certificate')->where(['uid'=>$id,'type'=>$types])->find();
        if(empty($have))
        {
            $image = \think\Image::open('../public/api/img/'.$types.'.jpg'); //要加水印的图片
            $font = ROOT_PATH.'public/api/images/simkai.ttf';
            $image->text($name,$font,20,'#000000')->save('imgs/'.$types.$id.'.png'); //文字水印
            db::name('certificate')->insert(['uid'=>$id,'img'=>$types.$id.'.png','type'=>$types]);
        }
    }

    public function Certificate()
    {
        $userInfo = db::name('users')->where('id',session('userId'))->find();
        $this->getArray(explode(',',$userInfo['classid']),$userInfo['username'],$userInfo['id']);
        return $this->fetch('',['lists'=>db::name('certificate')->where('uid',$userInfo['id'])->select()]);
    }


    public function getArray($array,$username,$uid)
    {
        $guwen = [13,14];
        $cehua = [8,9];
        $manager = [13,14,15,16];
        $cehua_manager = [8,9,10,11];
        if($guwen == array_intersect($guwen,$array))
        {
            $this->getCertificate($username,$uid,'guwen');
        }
        if($cehua == array_intersect($cehua,$array))
        {
            $this->getCertificate($username,$uid,'cehua');
        }
        if($manager == array_intersect($manager,$array))
        {
            $this->getCertificate($username,$uid,'xiangmu');
        }
        if($cehua_manager == array_intersect($cehua_manager,$array))
        {
            $this->getCertificate($username,$uid,'cehuajingli');
        }

    }

    public function downFile()
    {
        $filename = input('url');
        if(file_exists($filename))
        {
            header ("Content-Type: application/force-download");
            header ('Content-Disposition: attachment;filename="'.$filename.'"');
            readfile ($filename);
        }else{
            echo '没有此文件';
        }
    }
}