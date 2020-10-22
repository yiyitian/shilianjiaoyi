<?php

namespace app\rackstage\model;

use think\Db;
use think\Model;

class ErpCostume extends Model
{
    //
    protected $connection='mysql://58ifang_sel:ifs2017!@rm-uf643magn5q4y3hw7po.mysql.rds.aliyuncs.com:3306/58aifangbi#utf8';
    protected $table="b_contact";

    public function get_one_oln($where)
    {
        $one = date('Y-m-01', strtotime('-1 month'));
        $end = date('Y-m-t', strtotime('-1 month'));
       $where[ 'join_date'] = ['between time',array($one,$end)];
        $data=$this->where($where)->count();
        return $data;
    }
    public function get_one_olns($where,$wheres)
    {
        $data=$this->where($where)->whereOr($wheres)->count();
        return $data;
    }
    public function get_costume_real($where)
    {
     
      $costume_count=$this->where($where)->fetchSql(false)->count();
      return $costume_count;
    }
    public function get_completed_status($project_name)
    {
      $sql="select p.project_name as '项目名称',
      p.org_name as '事业部',
      DATE_FORMAT(o.sale_date,'%Y-%m') as '所属月份',
      p.manager_name as '项目经理',
      round(sum(b.scale_amount / 100),2) as '认购套数',
      round(sum(o.sale_total_price * b.scale_amount)/100,2) as '认购总额',
   case when DATE_FORMAT(NOW(),'%m') = '01' then ct.MONTH_1 
     when DATE_FORMAT(NOW(),'%m') = '02' then ct.MONTH_2 
     when DATE_FORMAT(NOW(),'%m') = '03' then ct.MONTH_3 
     when DATE_FORMAT(NOW(),'%m') = '04' then ct.MONTH_4 
     when DATE_FORMAT(NOW(),'%m') = '05' then ct.MONTH_5 
     when DATE_FORMAT(NOW(),'%m') = '06' then ct.MONTH_6 
     when DATE_FORMAT(NOW(),'%m') = '07' then ct.MONTH_7 
     when DATE_FORMAT(NOW(),'%m') = '08' then ct.MONTH_8 
     when DATE_FORMAT(NOW(),'%m') = '09' then ct.MONTH_9 
     when DATE_FORMAT(NOW(),'%m') = '10' then ct.MONTH_10 
     when DATE_FORMAT(NOW(),'%m') = '11' then ct.MONTH_11 
     when DATE_FORMAT(NOW(),'%m') = '12' then ct.MONTH_12 
     else 0 end as '月度目标'
from b_project p inner join b_sale_order o 
   on  p.project_id = o.project_id
  inner join b_saler_balance b 
   on o.sale_order_id = b.sale_order_id
  left join co_task ct 
   on  p.project_id = ct.project_id
where 1=1 
  and p.void_flag = 1
  and o.void_flag = 1
  and b.void_flag = 1
  and ct.void_flag = 1
  and p.project_name='{$project_name}'
  and DATE_FORMAT(o.sale_date, '%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')
 group by p.project_id,p.project_name,p.org_id,p.org_name, 
  DATE_FORMAT(o.sale_date,'%Y-%m')";
  $str="mysql://58ifang_sel:ifs2017!@rm-uf643magn5q4y3hw7po.mysql.rds.aliyuncs.com:3306/58aifangbi#utf8";
  $data=Db::connect($str)->query($sql);
  return [$data['认购总额'],$data['月度目标']];
    }

}
