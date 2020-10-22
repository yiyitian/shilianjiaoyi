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
            <!-- <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name|default=''}</option>
                    {/volist}

                </select>
            </div>

            <div class="layui-input-inline" style="width:300px;">
                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择部门</option>
                    {volist name="framework_pid" id="vo_pid"}
                    <optgroup label="{$vo_pid.name}">
                        {volist name="vo_pid.framework" id="vo"}
                        {if condition="$vo.pid eq $vo_pid.id"}

                        <option value="{$vo.id}">{$vo.name}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                    {/volist}

                </select>
            </div> -->
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
            <button class="layui-btn search"  id="search"  type="button"  style="">搜索</button>
                                                            <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

            {in name="jurisdiction" value="1,8"}
            <button class="layui-btn"  type="button" id="exp">导出</button>

            {/in}
            <button type="button"  class="layui-btn" style="background: grey"
                    onclick="window.location.href='managers'">返回
                
        </div>
        </form>
<!--        <table class="layui-table"-->
<!--               lay-data="{height:'',url:'manager?id=1&history=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test',toolbar:true,cellMinWidth:120}"-->
<!--               lay-filter="test">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th lay-data="{field:'id', width:80,align:'center', sort: true}">编号</th>-->
<!--                <th lay-data="{field: 'project_title', align: 'center',width:150}">项目名称</th>-->
<!--                <th lay-data="{field: 'username', align: 'center',width:150}">项目经理</th>-->
<!--                <th lay-data="{field: 'subscribe_rate', align: 'center'}">认购完成率</th>-->
<!---->
<!--                <th lay-data="{field: 'subscribe_score', align: 'center',width:150}">认购完成得分</th>-->
<!--                <th lay-data="{field: 'authenticity', align: 'center',width:150}">真实性得分</th>-->
<!--                <th lay-data="{field: 'profit', align: 'center',width:150}">理论利润</th>-->
<!--                <th lay-data="{field: 'profit_score', align: 'center',width:150}">理论利润得分</th>-->
<!--                <th lay-data="{field: 'develop_costume', align: 'center',width:150}">蓄客完成得分</th>-->
<!--                <th lay-data="{field: 'work_book_score', align: 'center',width:150}">计划书</th>-->
<!--                <th lay-data="{field: 'total', align: 'center'}">总计得分</th>-->
<!--                <th lay-data="{field: 'total_real', align: 'center'}">总计实际得分</th>-->
<!--                <th lay-data="{align: 'center',toolbar:'#barDemo'}">操作</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--        </table>-->
        <script type="text/html" id="barDemo">
            {eq name="jurisdiction" value="1"}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="back">撤回</a>
            {/eq}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        <table class="layui-hide"  lay-filter="test" id="test"></table>

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
    //日期范围

    layui.use(['table', 'layer', 'jquery', 'laydate', 'upload'], function () {
        var table = layui.table,
            $ = layui.jquery
            , form = layui.form
            , laydate = layui.laydate
            , upload = layui.upload
            , layer = layui.layer;
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');

            renderTable();
        });
        var renderTable=function(){
            table.render({
                id:'test'
                ,toolbar:true
                ,elem: '#test'
                ,url:'manager?id=1&history=1'
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
                    {field: 'dep', align: 'center',width:150,title:'部门'},
                    {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                    {field: 'username', align: 'center',width:150,title:'项目经理'},
                    {field: 'subscribe_rate', align: 'center',title:'认购完成率'},
                    {field: 'subscribe_score', align: 'center',width:150,edit:'text',title:'认购完成得分'},
                    {field: 'authenticity', align: 'center',width:150,edit:'text',title:'真实性得分'},
                    {field: 'profit', align: 'center',width:150,title:'理论利润'},
                    {field: 'profit_score', align: 'center',width:150,edit:'text',title:'理论利润得分'},
                    {field: 'develop_costume', align: 'center',width:150,edit:'text',title:'蓄客完成得分'},
                    {field: 'work_book_score', align: 'center',width:150,title:'计划书'},
                    {field: 'total', align: 'center',width:150,title:'总计得分'},
                    {field: 'total_real',width:150, align: 'center',title:'总计实际得分'},
                    {field: 'mark', align: 'center',title:'备注',edit:'text'},


                    {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}

                ]]
            });
        };
        renderTable();

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
                        ,url:'/rackstage/manager/employee_search?status1=1&history=&date='+date+'&project='+project
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
                            {field: 'dep', align: 'center',width:150,title:'部门'},
                            {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                            {field: 'username', align: 'center',width:150,title:'项目经理'},
                            {field: 'subscribe_rate', align: 'center',title:'认购完成率'},
                            {field: 'subscribe_score', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'认购完成得分'},
                            {field: 'authenticity', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'真实性得分'},
                            {field: 'profit', align: 'center',width:150,title:'理论利润'},
                            {field: 'profit_score', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq}  title:'理论利润得分'},
                            {field: 'total', width:150,align: 'center',title:'总计得分'},
                            {field: 'total_real',width:150, align: 'center',title:'总计实际得分'},
    {field: 'mark', align: 'center',width:150,title:'备注',edit:'text'},

    {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}
                        ]]
                     });
                 }else{
                    table.render({
                        id:'test'
                        ,toolbar:true
                        ,elem: '#test'
                        ,url:'/rackstage/manager/employee_search?status1=-1&history=&date='+date+'&project='+project
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
                            {field: 'dep', align: 'center',width:150,title:'部门'},
                            {field: 'project_title', align: 'center',width:150,title:'项目名称'},
                            {field: 'username', align: 'center',width:150,title:'项目经理'},
                            {field: 'visiting', align: 'center',width:150,  title:'蓄客人数'},
                            {field: 'develop_costume', align: 'center',width:150, {eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'蓄客完成得分'},
                            {field: 'work_book_score', align: 'center',width:150,{eq name="jurisdiction" value="1"}edit:'text',{/eq} title:'计划书'},
                            {field: 'total', align: 'center',title:'总计得分'},
                            {field: 'total_real', align: 'center',title:'总计实际得分'},
    {field: 'mark', align: 'center',title:'备注',edit:'text'},

    {align: 'center',toolbar:'#barDemo',width:150,title:'操作'}
                            ]]
                        });
                    }

             })

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


        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event=='back'){
                layer.confirm('确认撤回吗', function(index){
                    $.ajax({
                        url: "/rackstage/Manager/recall" ,
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
        /*搜索结束*/
        //#添加end
        //编辑表格工具



    });


</script>
{include file="public/footer" /}