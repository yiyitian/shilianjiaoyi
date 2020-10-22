<?php

namespace app\rackstage\model;

use think\Db;
use think\Model;

class ErpBalance extends Model
{
    //
    protected $connection = 'mysql://58ifang_sel:ifs2017!@rm-uf643magn5q4y3hw7po.mysql.rds.aliyuncs.com:3306/58aifangbi#utf8';
    protected $table = "b_saler_balance";
    public function get_one_number($where)
    {
       $balance=$this->where($where)->fetchSql(false)->column("sale_order_id");
        $last_month_first = date('Y-m-01 00:00:00', strtotime(date('Y-m-01') . " - 1 month")) ;
        $last_month_end = date('Y-m-t 00:00:00', strtotime(date('Y-m-01') . " - 1 month"));
       $data=(new ErpOrder())->whereIn("sale_order_id",$balance)->whereTime('sale_date', 'between', [$last_month_first, $last_month_end])->count();
        return $data;
    }
    public function get_order_turnover($where)
    {
       $balance=$this->where($where)->column("sale_order_id");
       $last_month_first = date('Y-m-01 00:00:00', strtotime(date('Y-m-01') . " - 1 month")) ;
       $last_month_end = date('Y-m-t 00:00:00', strtotime(date('Y-m-01') . " - 1 month"));
        $wheres['act_date'] = array('neq','');
        $data=(new ErpOrder())->whereIn("sale_order_id",$balance)->whereTime('sale_date','between', [$last_month_first, $last_month_end])->sum("sale_total_price");
       $datas=(new ErpOrder())->whereIn("sale_order_id",$balance)->where($wheres)->whereTime('sale_date','between', [$last_month_first, $last_month_end])->sum("sale_total_price");
        return $data-$datas;
    }
}

