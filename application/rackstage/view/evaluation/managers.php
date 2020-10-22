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
           <!--  <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name|default=''}</option>
                    {/volist}

                </select>
            </div> -->

<!--            <div class="layui-input-inline" style="width:300px;">-->
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
            <div class="layui-input-inline" style="">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="month" id="vo"}
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

            <button class="layui-btn search" id="search"  type="button"style="">搜索</button>
                                                            <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

            {/in}
            {in name="jurisdiction" value="1,2,8"}
            <button class="layui-btn"  type="button"id="exp">导出</button>

            {/in}
            {neq name="jurisdiction" value="2"}

            <button class="layui-btn" type="button" style="background: grey" onclick="window.location.href='managers?history=1'">历史打分</button>
            {in name='jurisdiction' value='1'}
            <button class="layui-btn"  type="button"id="create_table">一键刷新</button>
            {/in}
            {/neq}
        </div>
        </form>

        {neq name="jurisdiction" value="2"}

        <script type="text/html" id="barDemo">
            {eq name="jurisdiction" value="1"}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="pass">通过</a>
            {/eq}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        {/neq}
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <div id=" pages" class="text-center">
        </div>
        <div style="bottom: 10%;color: #868282;">
            <span style="float:left">
                <h3>持销期</h3>
                <div>月理论利润≥0得30分，否得0分</div>
                <div>数据真实有效30分，否得0分</div>
                <div>月认购完成率≥50%得40分，否得0分</div>
            </span>
            <h3>蓄客期</h3>
            <div>蓄客完成率≥50得70分，否得0分</div>
            <div>工作计划书完成得30分，否得0分</div>
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
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        var renderTable=function(){
            table.render({
                id:'test'
            {eq name="jurisdiction" value='1'}
            ,toolbar:true
            {/eq}
                ,elem: '#test'
                ,url:'manager?id=1'
                ,page: {
                 //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,99999]//每页条数的选择项
                    ,groups: 6 //只显示 2 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                         {field:'id', width:80,align:'center', sort: true , title:'编号'},
                         {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                         {field: 'username', align: 'center',width:150,title:'项目经理'},
                         {eq name="project_status|default=1" value="1"}
                         {field: 'subscribe_rate',width:150, align: 'center',title:'认购完成率'},
                         {field: 'subscribe_score',width:150, align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'认购完成得分'},
                         {field: 'authenticity',width:150, align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'真实性得分'},
                        {field: 'profit_score',width:150, align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq}  title:'理论利润得分'},
                         {/eq}
                         {eq name="project_status|default=-1" value="-1"}
                         {field: 'visiting',width:150, align: 'center',width:150,  title:'蓄客人数'},
                         {field: 'develop_costume', width:150,align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'蓄客完成得分'},
                         {field: 'work_book_score',width:150, align: 'center',width:150,{eq name="jurisdiction" value="1"}edit:'text',{/eq}title:'计划书'},
                         {/eq}
                         {field: 'total', align: 'center',width:150,title:'总计得分'},
                         {field: 'total_real',width:150, align: 'center',title:'总计实际得分'},
                         {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}
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
                url: "/rackstage/Manager/export",
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
                //department = layui.formSelects.value('select7_0', 'val'),
                ids = layui.formSelects.value('select7_3', 'val'),
                date = layui.formSelects.value('select7_4', 'val');
                status1 = layui.formSelects.value('select7_5', 'val');
                if(status1>0)
                {
                    table.render({
                        id:'test'
                        ,toolbar:true
                        ,elem: '#test'
                        ,url:'/rackstage/manager/employee_search?status1=1&date='+date+'&project='+project
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
                            {field:'id', width:80,align:'center', sort: true , title:'编号'},
                            {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                            {field: 'username', align: 'center',width:150,title:'项目经理'},
                            {field: 'subscribe_rate', align: 'center',title:'认购完成率'},
                            {field: 'subscribe_score', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'认购完成得分'},
                            {field: 'authenticity', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'真实性得分'},
                            {field: 'profit', align: 'center',width:150,title:'理论利润'},
                            {field: 'profit_score', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq}  title:'理论利润得分'},
                            {field: 'total',width:150, align: 'center',title:'总计得分'},
                            {field: 'total_real',width:150, align: 'center',title:'总计实际得分'},
                            {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}
                        ]]
                    });
                }else{
                    table.render({
                        id:'test'
                        ,toolbar:true
                        ,elem: '#test'
                        ,url:'/rackstage/manager/employee_search?status1=-1&date='+date+'&project='+project
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
                            {field:'id', width:80,align:'center', sort: true , title:'编号'},
                            {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                            {field: 'username', align: 'center',width:150,title:'项目经理'},
                            {field: 'visiting', align: 'center',width:150,  title:'蓄客人数'},
                            {field: 'develop_costume', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'蓄客完成得分'},
                            {field: 'work_book_score', align: 'center',width:150,{eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'计划书'},
                            {field: 'total',width:150, align: 'center',title:'总计得分'},
                            {field: 'total_real',width:150, align: 'center',title:'总计实际得分'},
                            {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}
                        ]]
                    });
                }

        })
        $('#create_table').click(function () {
            $.ajax({
                url: "create_manager_tables",
                data: {'create': 'yes'},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                       location.reload();
                    });
                }
            })
            ;
        });
        /*搜索结束*/
        //#添加end
        //编辑表格工具
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "/rackstage/Manager/employee_edit",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
                },
                type: "post",
                dataType: 'json',
                success: function (data) {
                    $(".layui-laypage-btn").click()
                }
            })
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                console.log(data.id);
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/Manager/del" ,
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
                        url: "/rackstage/Manager/pass" ,
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

    });


</script>
{include file="public/footer" /}