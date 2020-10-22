<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">

{include file="public/header" /}
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
                            <form class="layui-form" action="">

        <div class="demoTable">
        {in name="jurisdiction" value="1"}
<!--            <div class="layui-input-inline" style="width:300px;">-->
<!--                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""-->
<!--                        xm-select-show-count="1">-->
<!--                    <option value="">员工姓名多选</option>-->
<!--                    {volist name="users" id="vo"}-->
<!--                    <option value="{$vo.id}">{$vo.username}-{$vo.work_id}</option>-->
<!--                    {/volist}-->
<!--                </select>-->
<!--            </div>-->
<!--            <div class="layui-input-inline" style="width:300px;">-->
<!--                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger"-->
<!--                        xm-select-search="" xm-select-show-count="1">-->
<!--                    <option value="">请选择部门</option>-->
<!--                    {volist name="framework_pid" id="vo_pid"}-->
<!--                    <optgroup label="{$vo_pid.name}">-->
<!--                        {volist name="vo_pid.framework" id="vo"}-->
<!--                        {if condition="$vo.pid eq $vo_pid.id"}-->
<!--                        <option value="{$vo.id}">{$vo.name}</option>-->
<!--                        {/if}-->
<!--                        {/volist}-->
<!--                    </optgroup>-->
<!--                    {/volist}-->
<!--                </select>-->
<!--            </div>-->
            <div class="layui-input-inline" style="width:220px;">
                <select id="project" lay-filter="project" xm-select="select7_1" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择项目</option>
                    {volist name="project_pid" id="vo_pid"}
                    <optgroup label="{$vo_pid.name}-{$vo_pid.father}">
                        {volist name="vo_pid.project" id="vo"}
                        {if condition="$vo.framework_id eq $vo_pid.id"}
                        <option value="{$vo.id}">{$vo.name}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                    {/volist}

                </select>
            </div>
            <div class="layui-input-inline" style="width:200px;">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="timeType" id="vo"}
                    <option value="{$vo.month}">{$vo.month}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline" style="width:200px;">
                <select name="status" lay-filter="status" xm-select="select7_5" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择状态</option>
                    <option value="1">持销期</option>
                    <option value="-1">蓄客期</option>
                </select>
            </div>
            <button class="layui-btn search" id="search" style="" type="button" >搜索</button>
                                                            <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

            {/in}

            {in name="jurisdiction" value="1,2,7,8"}
            <button class="layui-btn"  type="button" id="exp">导出</button>
            {/in}
            <button class="layui-btn"  type="button"  onclick="window.location.href='plans'">返回打分
            </button>
        </div>
        </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <div style="bottom: 10%;color: #868282;">
            <h3>持销期</h3>
            <div>月理论利润≥0得30分，否得0分</div>
            <div>月来访目标完成得40分，否得0分</div>
            <div>月认购完成率≥50%得30分，否得0分</div>
        </div>
        <div style="bottom: 10%;color: #868282;">
            <h3>蓄客期</h3>
            <div>蓄客完成率≥50得50分，否得0分</div>
            <div>工作计划书完成得50分，否得0分</div>
        </div>
        {eq name="jurisdiction" value='1'}
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="back">撤回</a>
        </script>
        {/eq}
        <script type="text/html" id="isTpl">
            {{#  if(d.admin_id === 0){ }}
            <span style="color: red;">管理员未打分</span>
            {{#  } else { }}
            <span style="color: green;">管理员已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="adminTpl">
            {{#  if(d.admin_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="visiting_score">
            {{#  if(d.visiting_score !==d.erp_entry_real_score){ }}
            <span style="color: {{d.color2}};">{{ d.visiting_score}}</span>
            {{#  } else { }}
            {{ d.visiting_score}}
            {{#  } }}
        </script>
        <script type="text/html" id="subscribe_real">
            <span style="color: {{d.color1}};">{{ d.subscribe_real}}</span>
        </script>
        <script type="text/html" id="profit_score">
            <span style="color: {{d.color3}};">{{ d.profit_score}}</span>
        </script>
        </div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<script>
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
    //日期范围
    layui.use(['table', 'layer', 'jquery', 'laydate', 'upload'], function () {
        var table = layui.table,
            $ = layui.jquery
            , form = layui.form
            , laydate = layui.laydate
            , upload = layui.upload
            , layer = layui.layer;
        laydate.render({
            elem: '#test6'
            , range: true
        });
        $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');
            renderTable();

        });
        function isEmpty(v) {
            switch (typeof v) {
                case 'undefined':
                    return true;
                case 'string':
                    if (v.replace(/(^[ \t\n\r]*)|([ \t\n\r]*$)/g, '').length == 0) return true;
                    break;
                case 'boolean':
                    if (!v) return true;
                    break;
                case 'number':
                    if (0 === v || isNaN(v)) return true;
                    break;
                case 'object':
                    if (null === v || v.length === 0) return true;
                    for (var i in v) {
                        return false;
                    }
                    return true;
            }
            return false;
        }
        $("#search").click(function(){
            var  project = layui.formSelects.value('select7_1', 'val'),
                 $ = layui.$,
                department = layui.formSelects.value('select7_0', 'val'),
                ids = layui.formSelects.value('select7_3', 'val'),
                date = layui.formSelects.value('select7_4', 'val'),
                status1 = layui.formSelects.value('select7_5', 'val');
            if(status1>0)
            {
                table.render({
                    id:'test'
                    ,toolbar:true
                    ,elem: '#test'
                    ,url:'/rackstage/plan/getProject?history=1&project='+project+'&date='+date+'&status=1'
                    ,cols: [[
                        {type:'numbers', minWidth: 20, title: '编号'},
                            {field: 'dep', align: 'center',width:150,title:'部门'}
                        ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                        ,{field: 'username', align: 'center',width:150,title:'业务员'}
                        ,{field: 'subscribe_rate',width:150, align: 'center',title:'认购完成率'}
                        ,{field: 'subscribe_real',width:150,edit:'text', align: 'center',title:'认购完成得分'}
                        ,{field: 'visiting_aims', width:150,align: 'center',title:'月来访目标'}
                        ,{field: 'visiting', width:150,align: 'center',title:'月来访人数'}
                        ,{field: 'visiting_score',width:150,edit:'text', align: 'center',title:'月来访得分',templet:'#visiting_score'}
                        ,{field: 'visiting_real_score',width:150, align: 'center',title:'系统检查得分'}
                        ,{field: 'profit',width:150, align: 'center',title:'理论利润'}
                        ,{field: 'profit_score',width:150, align: 'center',title:'理论利润得分'}
                        ,{field: 'total',width:150, align: 'center',title:'总计'}
                            {eq name="jurisdiction" value='1'}
                            ,{field: 'subsidy',width:150,edit:'text', align: 'center',title:'补助'}
                            ,{field: 'actual',width:150,edit:'text', align: 'center',title:'实际补助'}
                            {/eq}
                        ,{field: 'total_real',width:150, align: 'center',title:'系统检查总分'}
                        {eq name="jurisdiction" value='1'}
                        ,{field: 'admin_id',width:150, align: 'center',title:'状态',templet:'#adminTpl'}
                        {/eq}
                        {eq name="jurisdiction" value='2'}
                        ,{field: 'manager_id', width:150,align: 'center',title:'状态',templet:'#isTpl'}
                        {/eq}
            ,{field: 'mark', align: 'center',width:150,title:'备注',edit:'text'}

            ,{ width:150, align:'center', toolbar: '#barDemo',title:'操作'}
                    ]]
                 });
            }else{
            table.render({
                id:'test'
                ,toolbar:true
                ,elem: '#test'
                ,url:'/rackstage/plan/getProject?history=1&project='+project+'&date='+date+'&status=-1'
                ,cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'},
                    {field: 'dep', align: 'center',width:150,title:'部门'}
                    ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                    ,{field: 'username', align: 'center',width:150,title:'业务员'}
                    ,{field: 'customers_number',width:150, align: 'center',title:'蓄客数量',{in name='jurisdiction' value='1,2'}edit:'text'{/in}}
                    ,{field: 'develop_costume',width:150, edit:'text',align: 'center',title:'蓄客得分',{in name='jurisdiction' value='1,2'}edit:'text'{/in}}
                    ,{field: 'work_book_score',width:150,edit:'text', align: 'center',title:'计划书',{in  name='jurisdiction' value='1,2'}edit:'text'{/in}}
                    ,{field: 'xukecount',width:150, align: 'center',title:'总分'}
        {eq name="jurisdiction" value='1'}
        ,{field: 'subsidy', width:150,align: 'center',edit:'text',title:'补助'}
        ,{field: 'actual',width:150, align: 'center',edit:'text',title:'实际补助'}
        {/eq}
                    {eq name="jurisdiction" value='1'}
                    ,{field: 'admin_id',width:150, align: 'center',title:'状态',templet:'#adminTpl'}
                    {/eq}
                    {eq name="jurisdiction" value='2'}
                    ,{field: 'manager_id',width:150, align: 'center',title:'状态',templet:'#isTpl'}
                    {/eq}
        ,{field: 'mark', align: 'center',width:150,title:'备注',edit:'text'}

        ,{ width:150, align:'center', toolbar: '#barDemo',title:'操作'}
                    ]]
                });
            }
        })
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        var renderTable=function(){
            table.render({
                id:'test'
            {eq name="jurisdiction" value='1'}
                ,toolbar:true
            {/eq}
                ,elem: '#test'
                ,url:'plans?id=1&history=1'
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,99999]//每页条数的选择项
                    ,groups: 6 //只显示 2 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'},
                {field: 'dep', align: 'center',width:150,title:'部门'}
                    ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                    ,{field: 'username', align: 'center',width:150,title:'业务员'}

                     {eq name="project_status|default=1" value="1"}

                    ,{field: 'subscribe_rate',width:150, align: 'center',title:'认购完成率'}

                    ,{field: 'subscribe_real',width:150, align: 'center',title:'认购完成得分'}
                     ,{field: 'visiting',width:150, align: 'center',title:'月来访人数',style:'font-weight:600;background-color: lightskyblue;'}
                    ,{field: 'visiting_aims',width:150, align: 'center',title:'月来访目标',style:'font-weight:600;background-color: lightskyblue;'}
                    ,{field: 'visiting_score',width:150, align: 'center',title:'月来访得分', {eq name="jurisdiction" value="1"}edit:'text',{/eq}  style:'font-weight:600;background-color: lightskyblue;',templet:'#visiting_score'}
                    ,{field: 'visiting_real_score',width:150, align: 'center',title:'系统检查得分'}
                    ,{field: 'profit', width:150,align: 'center',title:'理论利润'}
                    ,{field: 'profit_score',width:150, align: 'center',title:'理论利润得分',templet:'#profit_score'}
                    {/eq}
                     {eq name="project_status|default=-1" value="-1"}
                    
                    ,{field: 'customers_biao',width:150, align: 'center',title:'蓄客目标'}
                    ,{field: 'customers_number',width:150, align: 'center',title:'蓄客数量'}
                    ,{field: 'develop_costume',width:150, align: 'center',title:'蓄客得分'}
                                        ,{field: 'work_book_score',width:150, align: 'center',title:'计划书'}

                    ,{field: 'xukecount',width:150, align: 'center',title:'总分'}
                     {/eq}
    {eq name="jurisdiction" value='1'}
    ,{field: 'subsidy', align: 'center',width:150,title:'补助'}
    ,{field: 'actual', align: 'center',width:150,title:'实际补助'}
    {/eq}
                    ,{field: 'total',width:150, align: 'center',title:'总计'}
                    ,{field: 'total_real',width:150, align: 'center',title:'系统检查总分'}
                    {eq name="jurisdiction" value='1'}
                    ,{field: 'admin_id', align: 'center',width:150,title:'状态',templet:'#adminTpl'}
                    {/eq}
                    {eq name="jurisdiction" value='2'}
                    ,{field: 'manager_id', align: 'center',width:150,title:'状态',templet:'#isTpl'}
                    {/eq}
    ,{field: 'mark', align: 'center',title:'备注',width:150,edit:'text'}

    ,{ width:150, align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        };
        renderTable();


        var in_time={$in_time};

        layui.formSelects.opened('select7_1', function (id) {
            console.log(layui.formSelects.value('select7_0', 'val'));
            val = layui.formSelects.value('select7_0', 'val');    //取值val字符串
            $.ajax({
                url: "/rackstage/Getinfo/getProject",
                data: {'pid': val},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    project = data;
                    var formSelects = layui.formSelects;
                    formSelects.data('select7_1', 'local', {
                        arr: data
                    });
                }
            });
            console.log(val);
        });




        $('#create_table').click(function () {
            $.ajax({
                url: "/rackstage/Plan/create_table",
                data: {'create': 'yes'},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        setTimeout(function () {
                            window.location.reload();
                        }, 666)

                    });
                }
            })
            ;
        });
        /*搜索结束*/
        //#添加end
        //编辑表格工具
    $("#exp").click(function() {
        var project = layui.formSelects.value('select7_1', 'val')||''
        var department = layui.formSelects.value('select7_0', 'val')|''
        $.ajax({
            url: "/rackstage/Plan/export",
            type: "post",
            dataType: "json",
            cache: false,
            data: {project:project,department:department},
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            success: function(data) {

                layer.msg(data.msg, {
                    time: 1000
                }, function() {
                    //renderTable();
                    if(data.code==1){
                        window.location.href=data.url
                    }

                    $(".layui-laypage-btn").click()
                });
            }
        });
    });
    table.on('edit(test)', function (obj) {
        var value = obj.value //得到修改后的值
            , data = obj.data //得到所在行所有键值
            , field = obj.field; //得到字段
        // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
        $.ajax({
            url: "/rackstage/Plan/employee_edit",
            data: {
                'id': data.id,
                'field': field,
                'value': value,
                manager_id: "{$manager_id}",
                admin_id: "{$admin_id}"
            },
            type: "post",
            dataType: 'json',
            success: function (data) {

            }
        })
    });
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "/rackstage/Plan/employee_edit",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
                    manager_id: "{$manager_id}",
                    admin_id: "{$admin_id}"
                },
                type: "post",
                dataType: 'json',
                success: function (data) {

                }
            })
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                console.log(data.id);
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/Plan/del" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                $(".layui-laypage-btn").click();
                            });
                        }
                    })
                });

            }else if(obj.event=='pass'){
                layer.confirm('确认通过吗', function(index){
                    $.ajax({
                        url: "/rackstage/Plan/pass" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                $(".layui-laypage-btn").click();
                            });
                        }
                    })
                });
            }
        });
    table.on('tool(test)', function(obj){
        var data = obj.data;
        if(obj.event=='back'){
            layer.confirm('确认撤回吗', function(index){
                $.ajax({
                    url: "/rackstage/Plan/recall" ,
                    data: {'id':data.id},
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,time:500},function(){
                            $(".layui-laypage-btn").click();
                        });
                    }
                })
            });
        }
    });
        $("#submit_employee").click(function () {
            $.ajax({
                url: "/rackstage/Plan/submit_employee",
                data: {is_submit: 'yes'},
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        $(".layui-laypage-btn").click();

                    });
                }
            })
        });
        $("#add_user").click(function () {
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title: "添加/编辑",
                area: ['700px', '500px'],
                maxmin: true,
                content: '/rackstage/Plan/add_user',
                btn: ['保存', '关闭'],
                zIndex: layer.zIndex,
                yes: function(index) {
                    var row = window["layui-layer-iframe" + index].callbackdata();
                    if (!$.trim(row)) {
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url: "/rackstage/Plan/add_user",
                        type: "post",
                        dataType: "json",
                        cache: false,
                        data: row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success: function(data) {
                            layer.msg(data.msg, {
                                time: 1000
                            }, function() {
                                //renderTable();
                                $(".layui-laypage-btn").click()
                            });
                        }
                    });
                },
                cancel: function() {},
                end: function() { //此处用于演示
                }
            });
        });
    });


</script>
{include file="public/footer" /}