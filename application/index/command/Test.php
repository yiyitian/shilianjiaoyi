<?php

namespace app\index\Command;

use think\console\Command;
use think\console\input;
use think\console\output;
use app\index\service\HttpService;
use think\Db;

class Test extends Command
{

    protected function configure()
    {
        $this->setName('Test')->setDescription('Test');
    }

    protected function execute(Input $input, Output $output)
     {
       self::sys_costume();
       self::sys_deal();
       self::sys_achievement();
    }
    /**
     * 同步来访台帐
     */
    protected static function sys_costume()
    {
        $str=config("database.db_config2");
        $field="c.contact_id,b.project_name,b.org_name,c.person_name,c.c_mobile,c.source_type_cd,c.join_date";
        $data=Db::connect($str)->name('b_contact')->field($field)->alias("c")->join("b_project b","b.project_id=c.project_id")->chunk(100,function ($dd)
        {
            $log=[];
     
           
                    });

        
    }
    /**
     * 同步成交台帐
     */
    protected static function sys_deal()
    {
        $str=$str=config("database.db_config2");
        $data=Db::connect($str);
    }
    /**
     * 同步业绩
     */
    protected static function sys_achievement()
    {
        $str=$str=config("database.db_config2");
        $data=Db::connect($str);
    }
  
}
