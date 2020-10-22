<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">

{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<style type="text/css">

    .layui-table-cell span{
        display: block;
        text-align: center;
    }
</style>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">

            <div class="layui-input-inline" style="">
                <input class="layui-input" name="create_at" value="" id="test6" placeholder="请选择日期" autocomplete="off">
            </div>
            <button class="layui-btn" id="add_user"  style="">添加人员</button>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
        </div>
        <table class="layui-table"
               lay-data="{height:'',url:'labor_costs?id=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test'}"
               lay-filter="test">
            <thead>
            <tr>
                <th  lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field: 'station_name',width:150,align:'center'}">职位</th>
                <th lay-data="{field: 'station', align: 'center',width:150,hide:true}">职位id</th>
                                <th lay-data="{field: 'number', align: 'center',width:150,edit:'text'}">数量</th>

                <th lay-data="{align: 'center',toolbar:'#barDemo',width:50}">操作</th>
            </tr>
            </thead>
        </table>
        <script type="text/html" id="barDemo">
            {{#  if(d.full ==2){ }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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

        var clientWidth = document.body.clientWidth;
        var clientHeight = document.body.clientHeight;
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: '/rackstage/Plan/employee_search'
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , method: 'post'
                    , where: {
                        project: layui.formSelects.value('select7_1', 'val'),
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
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "/rackstage/Profit/labor_edit",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
                },
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {

                        $(".layui-laypage-btn").click()
                    });
                }
            })
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                console.log(data.id);
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/Profit/labor_del" ,
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
        $("#cesuan").click(function () {
            $.ajax({
                url: "esimate",
                data: {
                    'ce': data.id,
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
                    if (data.url!=''){
                        window.location.href=data.url
                    }
                }
            })
        });
        $("#add_user").click(function() {
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title: "添加/编辑",
                area: ['700px', '500px'],
                maxmin: true,
                content: '/rackstage/Profit/add_user',
                btn: ['保存', '关闭'],
                zIndex: layer.zIndex,
                yes: function(index) {
                    var row = window["layui-layer-iframe" + index].callbackdata();
                    if (!$.trim(row)) {
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url: "/rackstage/Profit/add_user",
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