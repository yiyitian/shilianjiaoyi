<?php

namespace app\rackstage\model;

use think\Db;
use think\Model;

class ErpProject extends Model
{
        protected $connection='mysql://58ifang_sel:ifs2017!@rm-uf643magn5q4y3hw7po.mysql.rds.aliyuncs.com:3306/58aifangbi#utf8';
    public $table='b_project';

    public function get_project($where)
    {
        return $this->where($where)->find();
    }
}
