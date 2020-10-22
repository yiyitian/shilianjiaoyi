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
class Downfile extends controller
{
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