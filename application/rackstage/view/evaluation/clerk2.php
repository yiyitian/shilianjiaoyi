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
            {/in}
             <div class="layui-input-inline" style="">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="month" id="vo"}
                    <option value="{$vo.month}">{$vo.month}</option>
                    {/volist}
                </select>
            </div>
            <button class="layui-btn search" type="button" id="search" data-type="reload" style="">搜索</button>
                                                            <button type="reset" class="layui-btn" type="button"  id="reset">重置</button>

            {in name="jurisdiction" value="1,2,7,8"}
            <button class="layui-btn" id="exp"  type="button" >导出</button>
{/in}
            {if $role_title=='项目经理'}
            <button class="layui-btn"  type="button"  style="background: grey" onclick="window.location.href='clerk'">返回打分</button>
            {/if}

        </div>
        </form>
        <table class="layui-table"
               lay-data="{height:'',url:'clerk?id=1&history=1' ,toolbar:true, page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test'}"
               lay-filter="test">
            <thead>
            <tr>
                <th lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field: 'dep', align: 'center',width:150}">事业部</th>
                <th lay-data="{field: 'project_title', align: 'center',width:150}">项目名称</th>
                <th lay-data="{field: 'username', align: 'center',width:150}">业务员</th>
<!--                <th lay-data="{field: 'station', align: 'center',width:150}">岗位</th>-->
                {if $role_title == '项目经理'}

                <th lay-data="{field: 'work_book_score', align: 'center', {in name='jurisdiction' value='1,2'}edit: 'text'{/in},style:'font-weight:600'}">
                    计划书得分
                </th>
                {/if}

                <th lay-data="{field: 'total', align: 'center',style:'font-weight:600'}">总计得分</th>
                <th lay-data="{field: 'subsidy', align: 'center', edit:'text',style:'font-weight:600'}">补助</th>
                <th lay-data="{field: 'actual', align: 'center', edit:'text',style:'font-weight:600'}">实际补助</th>

                <th lay-data="{field: 'total_real', align: 'center',style:'font-weight:600'}">总计实际得分</th>
                <th lay-data="{field: 'manager_id', align: 'center',templet:'#isTpl'}">状态</th>
                <th lay-data="{field: 'mark', align: 'center'}">备注</th>
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

    layui.use(['table', 'layer', 'jquery', 'laydate','upload'], function () {
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
              document.getElementById("search").click();

        });
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
                url: "/rackstage/Employee/employee_edits",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
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
                url: "/rackstage/Clerk/export",
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
                    url: '/rackstage/Clerk/employee_search?history=1'
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
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        /*搜索结束*/
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event=='back'){
                layer.confirm('确认撤回吗', function(index){
                    $.ajax({
                        url: "/rackstage/Clerk/recall" ,
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
        //#添加end
        //编辑表格工具

    });


</script>
{include file="public/footer" /}