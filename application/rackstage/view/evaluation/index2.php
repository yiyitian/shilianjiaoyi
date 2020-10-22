<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">

{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
                    <form class="layui-form" action="">

        <div class="demoTable">
            {in name="jurisdiction" value="1"}


            <!--            <div class="layui-input-inline" style="width:200px;">-->
            <!--                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger"-->
            <!--                        xm-select-search="" xm-select-show-count="1">-->
            <!--                    <option value="">请选择部门</option>-->
            <!--                    {volist name="framework_pid" id="vo_pid"}-->
            <!--                    <optgroup label="{$vo_pid.name}">-->
            <!--                        {volist name="vo_pid.framework" id="vo"}-->
            <!--                        {if condition="$vo.pid eq $vo_pid.id"}-->
            <!---->
            <!--                        <option value="{$vo.id}">{$vo.name}</option>-->
            <!--                        {/if}-->
            <!--                        {/volist}-->
            <!--                    </optgroup>-->
            <!--                    {/volist}-->
            <!---->
            <!--                </select>-->
            <!--            </div>-->
            <div class="layui-input-inline" style="width:200px;">
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
            <button class="layui-btn search" id="search" data-type="reload"  type="button" style="">搜索</button>
                                                <button type="reset" class="layui-btn" type="button"  id="reset">重置</button>

            {/in}
            {in name="jurisdiction" value="1,2,7,8"}
            <button class="layui-btn"  id="exp" type="button" >导出</button>
            {/in}
            <button class="layui-btn"  type="button" onclick="window.location.href='index'">返回打分</button>
            <table class="layui-hide"  lay-filter="test" id="test"></table>
        </div>
        </form>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="back">撤回</a>
        </script>
        <script type="text/html" id="subscribe_score">
            <span style="color: {{d.color1}};">{{ d.subscribe_score}}</span>
        </script>
        <script type="text/html" id="oln_score">

            <span style="color: {{d.color2}};">{{ d.oln_score}}</span>

        </script>
        <script type="text/html" id="erp_entry_score">

            <span style="color: {{d.color3}};">{{ d.erp_entry_score}}</span>

        </script>
        <script type="text/html" id="adminTpl">
            {{#  if(d.admin_id === 0){ }}
            <span style="color: red;">管理员未打分</span>
            {{#  } else { }}
            <span style="color: green;">管理员已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="isTpl">
            {{#  if(d.manager_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="clerkTpl">
            {{#  if(d.clerk_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
            {{#  } }}
        </script>

        <div id=" pages" class="text-center">
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
    layui.use(['table', 'layer', 'jquery', 'laydate'], function () {
        var table = layui.table,
            $ = layui.jquery
            , form = layui.form
            , laydate = layui.laydate
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
        var renderTable=function(){
                table.render({
                    id:'test'
                {eq name="jurisdiction" value='1'}
                ,toolbar:true
                {/eq}
                ,elem: '#test'
                    ,url:'index?id=1&history=1'
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
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field: 'dep', align: 'center',width:150,title:'部门'}
                    ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                    ,{field: 'username', align: 'center',width:120,title:'业务员'}
                    {in name="jurisdiction" value="1,2"}
                    {eq name="project_status|default=1" value="1"}
                    ,{field: 'subscribe_rate', align: 'center',width:120,title:'认购完成数量'}
                    ,{field: 'subscribe_score', align: 'center',width:120,templet:'#subscribe_score',title:'认购得分'}
                    ,{field: 'subscribe_real', align: 'center',width:120,title:'系统检查得分'}
                    {/eq}
            ,{field: 'old_with_new', align: 'center',width:120,title:'自拓人数'}
            ,{field: 'oln_score', align: 'center',width:120,templet:'#oln_score',title:'自拓客户得分'}
            ,{field: 'oln_real_score', align: 'center',width:120,title:'系统检查得分'}
            ,{field: 'work_book_score', align: 'center',width:120,title:'计划书得分'}
        {/in}
        ,{field: 'erp_entry_score', align: 'center',width:120,templet:'#erp_entry_score',title:'ERP录入得分'}
        {in name="jurisdiction" value="1,2"}
        ,{field: 'erp_entry_real_score', align: 'center',width:120,title:'系统检查得分'}
        ,{field: 'total', align: 'center',width:120,title:'总分'}
        ,{field: 'total_real', align: 'center',width:120,title:'系统检查总分'}
        {/in}
        {eq name="jurisdiction" value='2'}
        ,{field: 'admin_id', align: 'center',width:120,templet:'#adminTpl',title:'状态'}
        {/eq}
        {eq name="jurisdiction" value='1'}
        ,{field: 'subsidy', align: 'center',width:120,title:'补助'}
        ,{field: 'actual', align: 'center',width:120,title:'实际补助'}
        {/eq}
        ,{field: 'mark', align: 'center',title:'备注',edit:'text'}

        ,{ width:120, align:'center', toolbar: '#barDemo',title:'操作'}
        ]]
    });
    };
    renderTable();
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
    $("#exp").click(function() {
        var project = layui.formSelects.value('select7_1', 'val')||''
        var department = layui.formSelects.value('select7_0', 'val')|''
        $.ajax({
            url: "/rackstage/Evaluation/export",
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
    var clientWidth = document.body.clientWidth;
    var clientHeight = document.body.clientHeight;

    $("#search").click(function() {
        var project = layui.formSelects.value('select7_1', 'val'),
            $ = layui.$,
        //department = layui.formSelects.value('select7_0', 'val'),

            date = layui.formSelects.value('select7_4', 'val'),
            status1 = layui.formSelects.value('select7_5', 'val');
        if(status1>0)
        {
            table.render({
                    id:'test'
                    ,toolbar:true
                    ,elem: '#test'
                    ,url:'/rackstage/Employee/employee_search?history=1&project='+project+'&date='+date+'&status=1'
                    ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                        ,limit:25 //一页显示多少条
                        ,limits:[25,50,100,99999]//每页条数的选择项
                        ,groups: 6 //只显示 2 个连续页码
                        ,first: "首页" //不显示首页
                        ,last: "尾页" //不显示尾页
                    }
                    ,cols: [[
                        {type:'numbers', minWidth: 20, title: '编号'}
                        ,{field: 'dep', align: 'center',width:150,title:'部门'}
                        ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                        ,{field: 'username', align: 'center',width:120,title:'业务员'}
                        {in name="jurisdiction" value="1,2"}
                        ,{field: 'subscribe_rate', align: 'center',width:120,title:'认购完成数量'}
                        ,{field: 'subscribe_score', edit:'text', align: 'center',width:120,templet:'#subscribe_score',title:'认购得分'}
                        ,{field: 'subscribe_real', align: 'center',width:120,title:'系统检查得分'}
                        ,{field: 'old_with_new', align: 'center',width:120,title:'自拓人数'}
                        ,{field: 'oln_score', edit:'text', align: 'center',width:120,templet:'#oln_score',title:'自拓客户得分'}
                        ,{field: 'oln_real_score', align: 'center',width:120,title:'系统检查得分'}
                        ,{field: 'work_book_score', edit:'text', align: 'center',width:120,title:'计划书得分'}
                        {/in}
                ,{field: 'erp_entry_score', edit:'text', align: 'center',width:120,templet:'#erp_entry_score',title:'ERP录入得分'}
            {in name="jurisdiction" value="1,2"}
        ,{field: 'erp_entry_real_score', align: 'center',width:120,title:'系统检查得分'}
        ,{field: 'total', align: 'center',width:120,title:'总分'}
        ,{field: 'total_real', align: 'center',width:120,title:'系统检查总分'}
            {/in}
            {eq name="jurisdiction" value='2'}
        ,{field: 'admin_id', align: 'center',width:120,templet:'#adminTpl',title:'状态'}
            {/eq}
            {eq name="jurisdiction" value='1'}
        ,{field: 'subsidy', align: 'center', edit:'text',width:120,title:'补助'}
        ,{field: 'actual', align: 'center',width:120, edit:'text',title:'实际补助'}
            {/eq}
        ,{field: 'mark', align: 'center',title:'备注',edit:'text'}

        ,{ width:120, align:'center', toolbar: '#barDemo',title:'操作'}
        ]]
        });
    }else{
        table.render({
                id:'test'
                ,toolbar:true
                ,elem: '#test'
                ,url:'/rackstage/Employee/employee_search?history=1&project='+project+'&date='+date+'&status=-1'
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,99999]//每页条数的选择项
                    ,groups: 6 //只显示 2 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field: 'dep', align: 'center',width:150,title:'部门'}
                    ,{field: 'project_title', align: 'center',width:150,title:'项目名称'}
                    ,{field: 'username', align: 'center',width:120,title:'业务员'}
                    {in name="jurisdiction" value="1,2"}
                    ,{field: 'old_with_new', align: 'center',width:120,title:'自拓人数'}
                    ,{field: 'oln_score',  edit:'text',align: 'center',width:120,templet:'#oln_score',title:'自拓客户得分'}
                    ,{field: 'oln_real_score', align: 'center',width:120,title:'系统检查得分'}
                    ,{field: 'work_book_score', edit:'text', align: 'center',width:120,title:'计划书得分'}
                    {/in}
            ,{field: 'erp_entry_score', edit:'text', align: 'center',width:120,templet:'#erp_entry_score',title:'ERP录入得分'}
        {in name="jurisdiction" value="1,2"}
    ,{field: 'erp_entry_real_score', align: 'center',width:120,title:'系统检查得分'}
    ,{field: 'total', align: 'center',width:120,title:'总分'}
    ,{field: 'total_real', align: 'center',width:120,title:'系统检查总分'}
        {/in}
        {eq name="jurisdiction" value='2'}
    ,{field: 'admin_id', align: 'center',width:120,templet:'#adminTpl',title:'状态'}
        {/eq}
        {eq name="jurisdiction" value='1'}
    ,{field: 'subsidy', align: 'center',width:120, edit:'text',title:'补助'}
    ,{field: 'actual', align: 'center',width:120, edit:'text',title:'实际补助'}
        {/eq}
    ,{field: 'mark', align: 'center',title:'备注',edit:'text'}

    ,{ width:120, align:'center', toolbar: '#barDemo',title:'操作'}
    ]]
    });
    }
    })

    table.on('tool(test)', function(obj){
        var data = obj.data;
        if(obj.event=='back'){
            layer.confirm('确认撤回吗', function(index){
                $.ajax({
                    url: "/rackstage/Employee/recall" ,
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
    $(document).on('click', '#settime', function () {
        var index = layer.open({
            type: 2,
            shade: [0.1],
            title: "设置",
            area: ['750px', '550px'],
            maxmin: true,
            content: 'settime?type=1',
            btn: ['保存', '关闭'],
            zIndex: layer.zIndex, //重点1
            yes: function (index) {
                var row = window["layui-layer-iframe" + index].callbackdata();
                if (!$.trim(row)) {
                    return false;
                }
                layer.closeAll();
                $.ajax({
                    url: "settime",
                    type: "post",
                    dataType: "json",
                    cache: false,
                    data: row,
                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {time: 2000}, function () {
                                renderTable();//location.reload();
                            });
                        } else {
                            layer.msg(data.msg, {icon: 0});
                        }
                    }
                });
            },
            cancel: function () {
            },
            end: function () { //此处用于演示
            }
        });
    });
    //#添加end
    //编辑表格工具
    table.on('edit(test)', function (obj) {
        var data = obj.data //得到所在行所有键值
            , field = obj.field; //得到字段
        if(field == 'mark')
        {
            var  value = obj.value;  //得到修改后的值
        }else{
            var value = parseInt(obj.value||0) ;//得到修改后的值
        }

        // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
        console.log(value);
        $.ajax({
            url: "/rackstage/Employee/employee_edit",
            data: {
                'id': data.id,
                'field': field,
                'value': value,
                manager_id: "{$manager_id}",
                clerk_id: "{$clerk_id}",
                admin_id: "{$admin_id}"
            },
            type: "post",
            dataType: 'json',
            success: function (data) {
                layer.msg(data.msg, {icon: data.code,time:500},function(){
                    $(".layui-laypage-btn").click();
                });
            }
        })
    });
    });


</script>
{include file="public/footer" /}