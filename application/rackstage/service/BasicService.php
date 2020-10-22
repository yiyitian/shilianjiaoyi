<?php


namespace app\rackstage\service;
class BasicService
{
    /**下载文件
     * @param $file
     */
    public static function download($file,$name)
    {
        if (is_file($file)) {
            $length = filesize($file); //文件大小
            $type = mime_content_type($file); //文件类型
            header('Content-Description: File Transfer');
            header('Content-type: ' . $type);
            header('Content-Length:' . $length);
            if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($name) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $name . '"');
            }
            readfile($file);
            exit;
        }

        exit('文件已被删除！');
    }
}