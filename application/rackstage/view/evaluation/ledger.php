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
           {in name='jurisdiction' value="1"}

            <div class="layui-input-inline" style="width:200px;">
                <select id="project" lay-filter="project" xm-select="select7_1" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择项目</option>
                    {volist name="pro_pid" id="vo_pid"}
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
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
                        <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

        </div>
        <table class="layui-table"
               lay-data="{height:'',url:'ledger?id=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test'}"
               lay-filter="test">
            <thead>
            <tr>
                <th lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field: 'username', align: 'center',width:150}">姓名</th>
                <th lay-data="{field: 'project', align: 'center',width:150}">项目</th>
                <th lay-data="{field: 'url', align: 'center', maxWidth: 10}">地址</th>
                <th lay-data="{field: 'type', align: 'center', maxWidth: 10,templet:'#typeTpl'}">类型</th>
                <th lay-data="{field: 'month', align: 'center', maxWidth: 10}">台账月份</th>
                <th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}"></th>
            </tr>
            </thead>
        </table>
        <div id=" pages" class="text-center">
        </div>
    </div>
</div>
<script type="text/html" id="typeTpl">
    {{#  if(d.type === 1){ }}
    <span class="layui-badge layui-bg-orange">来访</span>
    {{#  } else { }}
    <span class="layui-badge layui-bg-blue">成交</span>
    {{#  } }}
</script>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="download">下载</a>
    <a class="layui-btn layui-btn-xs" lay-event="del">删除</a>
</script>
<script src="/public/layui/layui.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<script>
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
    layui.use(['table', 'layer', 'jquery','laydate'], function () {
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
            layui.formSelects.value('select7_1', [0]);
            layui.formSelects.value('select7_4', [0]);
            table.reload('test', {
                url: "ledger?id=1"
                , page: {
                    curr: 1 //重新从第 1 页开始
                }
                , method: 'post'
            });
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
        var clientWidth = document.body.clientWidth;
        var clientHeight = document.body.clientHeight;
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: "/rackstage/Ledger/ledger_search"
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , method: 'post'
                    , where: {
                        project: layui.formSelects.value('select7_1', 'val'),
                        date : layui.formSelects.value('select7_4', 'val')

                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });


        table.on('tool(test)', function (obj) {
            var data = obj.data;
            if (obj.event === 'download') {
                window.location.href = '/rackstage/Ledger/download_file?id=' + data.id;
            }else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/Clerk/delAllClerk" ,
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
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "employee_edit",
                data: {'id': data.id, 'field': field, 'value': value},
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        //renderTable();
                    });
                }
            })
        });
    });


</script>
{include file="public/footer" /}