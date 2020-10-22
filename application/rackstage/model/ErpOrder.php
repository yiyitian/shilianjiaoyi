<?php

namespace app\rackstage\model;

use think\Model;

class ErpOrder extends Model
{
    //
    protected $connection='mysql://58ifang_sel:ifs2017!@rm-uf643magn5q4y3hw7po.mysql.rds.aliyuncs.com:3306/58aifangbi#utf8';
    protected $table="b_sale_order";
    public function get_order_turnover($where)
    {
        $data=$this->where($where)->whereTime("sale_date","last month")->sum("sale_total_price");
        return $data;
    }

}
