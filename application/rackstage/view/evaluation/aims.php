<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">

{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="持销|蓄客" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
        {in name="jurisdiction" value="1"}
           <!--  <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name}</option>
                    {/volist}

                </select>
            </div> -->
        
            <!-- <div class="layui-input-inline" style="width:300px;">
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
            {/in}
            <div class="layui-input-inline" style="width:200px;">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="month" id="vo"}
                         <option value="{$vo.month}">{$vo.month}</option>
                    {/volist}
                </select>
            </div>
            <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传月度目标</button>
            <button class="layui-btn  search" data-type="reload" style="">搜索</button>
                        <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

        </div>
        <table class="layui-table"
               lay-data="{height:'',url:'aims?id=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100,300] , groups: 5 , first: '首页', last: '尾页' }, id:'test',toolbar:true}"
               lay-filter="test">
            <thead>
            <tr>
                <th lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field:'project_title',align:'center',width:150}">项目名称</th>
                <th lay-data="{field: 'username',align:'center',width:150}">项目经理</th>
                <th lay-data="{field: 'month',align:'center',width:150}">目标月份</th>
                <th lay-data="{field: 'number', align: 'center',width:150,{eq name='jurisdiction' value='1'}edit:'text'{/eq}}">月度目标(万）</th>
                <th lay-data="{field: 'visiting', align: 'center',width:150,{eq name='jurisdiction' value='2'}edit:'text'{/eq}}">蓄客目标（人）</th>
                <th lay-data="{field:'status', title:'启用',width:'8%',align:'center',templet: '#checkboxTp2', unresize: true,event:'is_status'}">月度目标</th>

            </tr>
            </thead>
        </table>

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
           $(document).on('click','#reset',function(){
            layui.formSelects.value('select7_1', [0]);
            layui.formSelects.value('select7_4', [0]);
            table.reload('test', {
                url: "aims?id=1"
                , page: {
                    curr: 1 //重新从第 1 页开始
                }
                , method: 'post'
            });
        });

        upload.render({ //允许上传的文件后缀
            elem: '#test3'
            , url: '/rackstage/Employee/uploads?type=1' //改成您自己的上传接口
            , accept: 'file' //普通文件
            , exts: 'xls|csv|xlsx' //只允许上传压缩文件
            , done: function (res) {
                layer.msg(res.msg, {icon: res.code, time: 3000}, function () {
                    setTimeout(function () {
                        window.location.reload();
                    }, 666)

                });
                console.log(res)
            }
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
                    url: '/rackstage/Aims/employee_search'
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,toolbar:true
                    , method: 'post'
                    , where: {
                        project: layui.formSelects.value('select7_1', 'val'),
                         department: layui.formSelects.value('select7_0', 'val'),
                        ids: layui.formSelects.value('select7_3', 'val'),
                        date: layui.formSelects.value('select7_4', 'val'),
                    }
                });
            }
        };
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "/rackstage/Aims/employee_edit",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
                    manager_id: "{$manager_id}",
                },
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        table.reload();
                        $(".layui-laypage-btn").click()
                    });
                }
            })
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
if(obj.event === 'is_status'){
                if(data.is_technology==='1'){layer.msg('已经通过审核，无需再次操作');return false;}
                layer.confirm('确认启用操作？', function(index){
                    $.ajax({
                        url: "/rackstage/Aims/edit_status" ,
                        data: {'id':data.id,'status':data.status} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.info, {icon: data.msg},function(){$(".layui-laypage-btn").click();});
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