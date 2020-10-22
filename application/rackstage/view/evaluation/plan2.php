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
        <div class="demoTable">
            {in name="jurisdiction" value="1"}
            <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.username}-{$vo.work_id}</option>
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
            </div>
            <div class="layui-input-inline" style="width:300px;">
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
            {/in}
            <div class="layui-input-inline" style="">
                <input class="layui-input" name="create_at" value="" id="test6" placeholder="请选择日期" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
            {in name="jurisdiction" value="1,2,7,8"}
            <button class="layui-btn" id="exp">导出</button>
            {/in}
            {in name="jurisdiction" value="1,7,8"}
            <button class="layui-btn" id="xu">蓄客期查询</button>
            <button class="layui-btn" id="chi">持销期查询</button>
            {/in}
            {in name="jurisdiction" value="1,2"}

            <button class="layui-btn" onclick="window.location.href='plan'">返回打分</button>
            {/in}
        </div>
        <table class="layui-table"
               lay-data="{height:'',url:'plan?id=1&history=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test', {neq name='jurisdiction' value='2'}
        toolbar:true,
        {/neq} cellMinWidth:120}"
               lay-filter="test">
            <thead>
            <tr>
                <th lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field: 'project_title', align: 'center',width:150}">项目名称</th>
                <th lay-data="{field: 'username', align: 'center',width:150}">业务员</th>
                <!--                <th lay-data="{field: 'station', align: 'center',width:150}">岗位</th>-->
                {eq name="project_status|default=1" value="1"}
                    {in name="jurisdiction" value="1,2"}
                    <th lay-data="{field: 'subscribe_rate', align: 'center'}">认购完成率</th
                    <th lay-data="{field: 'subscribe_real', align: 'center',templet:'#subscribe_real',style:'font-weight:600'}">认购完成得分</th>
                    <th lay-data="{field: 'visiting', align: 'center'}">月来访人数</th>
                    <th lay-data="{field: 'visiting_score', align: 'center',templet:'#visiting_score',style:'font-weight:600'}">月来访得分</th>
                    {/in}
                    {in name="jurisdiction" value="1"}
                    <th lay-data="{field: 'visiting_real_score', align: 'center'}">系统检查得分</th>
                    {/in}
                    {in name="jurisdiction" value="1,2"}
                    <th lay-data="{field: 'profit', align: 'center'}">理论利润</th>
                    {/in}
                    <th lay-data="{field: 'profit_score', align: 'center',templet:'#profit_score',style:'font-weight:600'}">理论利润达标得分</th>
                {else/}
                     <th lay-data="{field: 'visiting', align: 'center'}">蓄客人数</th>
                     <th lay-data="{field: 'develop_costume', align: 'center'}">蓄客完成得分</th>
                     <th lay-data="{field: 'work_book_score', align: 'center'}">计划书</th>
                {/eq}

                <th lay-data="{field: 'total', align: 'center',style:'font-weight:600'}">总计得分</th>
                <th lay-data="{field: 'total_real', align: 'center',style:'font-weight:600'}">系统检查得分</th>
                {eq name="jurisdiction" value="2"}
                <th lay-data="{field: 'manager_id', align: 'center',templet:'#isTpl'}">状态</th>
                {/eq}
                {eq name="jurisdiction" value="1"}
                <th lay-data="{field: 'admin_id', align: 'center',templet:'#adminTpl'}">状态</th>
                {/eq}
                <th lay-data="{align: 'center',toolbar:'#barDemo'}">操作</th>

            </tr>
            </thead>
        </table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="back">撤回</a>
        </script>
        <script type="text/html" id="isTpl">
            {{#  if(d.manager_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
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
        laydate.render({
            elem: '#test6'
            , range: true
        });
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
        var clientWidth = document.body.clientWidth;
        var clientHeight = document.body.clientHeight;
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: '/rackstage/Plan/employee_search?history=1'
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , method: 'post'
                    , where: {
                        project: layui.formSelects.value('select7_1', 'val'),
                        department: layui.formSelects.value('select7_0', 'val'),
                        ids: layui.formSelects.value('select7_3', 'val'),
                        date: $("#test6").val(),
                    }
                });
            }
        };
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
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });


</script>
{include file="public/footer" /}