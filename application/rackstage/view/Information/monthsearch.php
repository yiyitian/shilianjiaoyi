{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>月报查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item">
            <label class="layui-form-label">时间范围</label>
            <div class="layui-input-inline">
                <input type="text"  id="time_code"  name="time_code" value=""  placeholder="请选择" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux">请选择时间</div>
        </div>



    </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>

        var callbackdata;
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var table = layui.table
                ,layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            laydate.render({
                elem: '#time_code'
                ,range: true
                ,type: 'month'
                ,done: function(value, date, endDate){
                    console.log(value); //得到日期生成的值，如：2017-08-18
                    console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                    console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                    if(value==''){
                        layer.msg('请选择时间范围',{icon:0,time:500})
                        return false;
                    }
                    table.render({
                        id: 'test'
                        ,toolbar: true
                        ,elem: '#test'
                        , url: 'monthsearch?search=1'
                        ,method:'post'
                        ,where: {time_code: value}
                        , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                            layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                            //,curr: 5 //设定初始在第 5 页
                            , limit: 25 //一页显示多少条
                            , limits: [25, 50, 100, 999999]//每页条数的选择项
                            , groups: 2 //只显示 2 个连续页码
                            , first: "首页" //不显示首页
                            , last: "尾页" //不显示尾页
                        }
                        , cols: [[
                            {type: 'numbers', width: '3%', title: '编号'}
                            ,{field:'title', width: '7%',align:'center', sort: true,  title: '月报标题'}
                            ,{field:'framework',width: '7%' ,align:'center', sort: true,  title: '部门'}
                            ,{field:'name',width: '8%',  align:'center',  title: '项目名称'}
                            ,{field:'company', width: '7%', align:'center',  title: '公司名称'}
//                            ,{field:'lastmonthcall',  align:'center',  title: '上月实际来电'}
//                            ,{field:'lastmonthcome',  align:'center',  title: '上月实际来访'}
                            ,{field:'lastmonthmainhouse',  align:'center', width:'8%', title: '上月销售主房套数'}
//                            ,{field:'lastmonthparking',  align:'center',  title: '上月销售车位套数'}
//                            ,{field:'lastmonthbasement',  align:'center',  title: '上月销售地下室套数'}
                            ,{field:'lastmonthsale',  align:'center', width:'8%',  title: '上月实际销售额（万）'}
                            ,{field:'thismonthsale', align:'center', width:'8%', title: '本月可售货量多少（万）'}
                            ,{field:'is_add', align:'center',width:'8%', title: '本月是否加推/开盘'}
                            ,{field:'addnum', align:'center',width:'8%',title:'加推/开盘总货量多少（万）'}
                            ,{field:'addaim', align:'center',width:'8%',title:'加推/开盘目标（万）'}
//                            ,{field:'obj_type', align:'center',title:'项目模式', event: 'set_obj_type', style:'cursor: pointer;'}
                            ,{field:'bestaim', align:'center',width:'8%',title:'销售最高目标（万）'}
//                            ,{field:'thismonth_flbaim', align:'center',title:'本月房联宝预计认购创收目标（万）'}
//                            ,{field:'thismonth_flbaim_done', align:'center',title:'本月房联宝预计可完成创收（万）'}
                            ,{field:'mark', align:'center',width:'8%',title:'备注'}
//                            ,{field:'manager',  align:'center',  title: '项目经理'}
//                            ,{field:'director',  align:'center',  title: '销售主管'}
//                            ,{field:'delegate',  align:'center',  title: '销售代表'}
//                            ,{field:'clerk',  align:'center',  title: '后台文员'}
//                            ,{field:'plan',  align:'center',  title: '主策'}
//                            ,{field:'assistantplan',  align:'center',  title: '助理策划'}
                        ]]
                    });
                }
            });
            //触发搜索
            form.on('select(type)', function(data){
                console.log(data.value);
                var time_code=$('#time_code').val();
                if(time_code==''){
                    layer.msg('请选择时间',{icon:0,time:500});
                    return false;
                }
                table.render({
                    id: 'test'
                    ,toolbar: '#toolbarDemo'
                    ,elem: '#test'
                    , url: 'weeksearch?search=1'
                    ,method:'post'
                    ,where: {time_code: time_code, type: data.value}
                    , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                        //,curr: 5 //设定初始在第 5 页
                        , limit: 25 //一页显示多少条
                        , limits: [25, 50, 100, 999999]//每页条数的选择项
                        , groups: 2 //只显示 2 个连续页码
                        , first: "首页" //不显示首页
                        , last: "尾页" //不显示尾页
                    }
                    , cols: [[
                        {type: 'numbers', width: '5%', title: '编号'}
                        ,{field:'title', width: '15%',align:'center', sort: true,  title: '周报标题'}
                        ,{field:'name',  align:'center',  title: '项目名称'}
                        ,{field:'company',  align:'center',  title: '公司名称'}
                        ,{field:'comecall',  align:'center',  title: '来电'}
                        ,{field:'comevisit', align:'center',  title: '来访'}
                        ,{field:'weektao', align:'center', title: '周认购套数'}
                        ,{field:'weekjine', align:'center',title:'周认购金额'}
                        ,{field:'monthtao', align:'center',title:'月认购套数'}
                        ,{field:'monthjine', align:'center',title:'月认购金额'}
                        ,{field:'yearaim', align:'center',title:'年认购目标'}
                        ,{field:'yearjine', align:'center',title:'年认购金额'}
                        ,{field:'yearincome', align:'center',title:'年创收金额'}
                        ,{field:'weshare', align:'center',title:'分享加油站'}
                    ]]
                });

            })

            //返回值
            callbackdata=function () {
                if(!verifycontent()){
                    false;
                }else {
                    var data =$("#formid").serialize();
                    return data;
                }
            }
            //自定义验证规则
            function verifycontent() {

                if($('#levels').val()==""){ layer.alert($('#levels').attr('placeholder'));  return false;};
                if($('#classtime').val()==""){ layer.alert($('#classtime').attr('placeholder'));  return false;};
                if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }

        })

</script>
{include file="public/footer" /}