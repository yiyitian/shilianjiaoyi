<?php
namespace app\rackstage\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Welcome extends Common{
    public function index()
    {
        $this->assign('role_name',Db::name('role')->where('id',session::get('role'))->value('role_name'));
        $this->assign('content',Db::name('role')->where('id',session::get('role'))->value('mark'));
        return $this->fetch();
    }

    public function ceshi()
    {
        return $this->fetch();
    }
    public function uploads()
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
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
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
        $arr = @Db('vio')->where('vio',"$uploadPath")->find();
        // print_r($arr);
        if($arr)
        {
            echo ('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        }
        else
        {
            $res=Db('vio')->insert(['vio'=>$uploadPath]);
        }

    }

    public  function  vioshow()
    {
        $re=Db::query('select * from vio');
        // $this->view->engine->layout(true);
        return $this->fetch('vioshow',['re'=>$re]);
    }


    public function getCurl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
    }

    /*
     * 获取access_token
     * */
    public function getToken()
    {
        $info = db::name('token')->find();
        $time = $info['time'] + 7200;
        if($time < time())
        {
            $token = $this->getCurl('https://oapi.dingtalk.com/gettoken?appkey=dingpdmsbz0sb927de4d&appsecret=5BxrIMjNMgIVTFUn0Zk7ofdBHhJB42GFcDdUd1x0kzJP9LhB_Yef3RrR0W7T2M9_');
            db::name('token')->where('id',$info['id'])->update(['access_token'=>$token['access_token'],'time'=>time()]);
        }else{
            $token = $info;
        }
        return $token['access_token'];
    }
    /*
     * 获取项目名称
     * */
    public function getProject($id='137662923')
    {
        $accessToken = $this->getToken();
        $list = $this->getCurl('https://oapi.dingtalk.com/department/list?access_token='.$accessToken.'&id='.$id);
        return $list['department'];
    }

    /*
     * 获取项目人员列表
     * */
    public function getProjectUser($id='137678995')
    {
        $accessToken = $this->getToken();
        $url = "https://oapi.dingtalk.com/user/listbypage?access_token=".$accessToken."&department_id=".$id."&offset=0&size=100";
        $list = $this->getCurl($url);
        if($list['hasMore'] == true)
        {
            $lists = $this->getCurl("https://oapi.dingtalk.com/user/listbypage?access_token=".$accessToken."&department_id=".$id."&offset=100&size=100");
            $List = array_merge($list['userlist'],$lists['userlist']);
        }else {
            $List = $list['userlist'];
        }
        return $List;
    }

    public function getDepartment()
    {
        return [137662923/*,137662922,137662924,137662920,137662921,99680037,141834095*/];
    }

    public function test()
    {
       foreach($this->getDepartment() as $val)
       {
           $lists = $this->getProject($val);
           foreach($lists as $k=>$v)
           {
               $projectId = db::name('project')->where('name','like','%'.$v['name'].'%')->value('id');
               if(!empty($projectId))
               {
                   $userList = $this->getProjectUser($v['id']);
                   foreach($userList as $k=>$v)
                   {

                   }
               }
           }
       }
    }


}