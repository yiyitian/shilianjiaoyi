<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>



    #classtable + div{margin-left:50px;}
    #userstable + div{margin-left:50px;}
    #station_table + div{margin-left:50px;}
    .layui-table td, .layui-table th{text-align: center;}
</style>
<body>


<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <legend>通知人员，保存后，再编辑时会显示</legend>
</fieldset>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <legend>通知人员</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table"  lay-filter="userstable" id="userstable" align="center"></table>
</div>

<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });

	var callbackdata;
	layui.use(['laydate','table','layer', 'form','element','jquery'], function(){
		var table = layui.table
            ,layer = layui.layer
			,$=layui.jquery
			,form = layui.form
            ,laydate = layui.laydate;
//转换静态表格
        table.init('demo', {
            toolbar: true
        });

        var renderTable= function (){
            table.render({
                id:'userstable'
                ,toolbar: true
                ,width:$(window).width()*.9
                ,initSort: {
                    field: 'is_done' //排序字段，对应 cols 设定的各字段名
                    ,type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                }
                ,elem: '#userstable'
                ,url: "testss"
                ,where: {
                    'get_list':'{$lists.station|default=""}',
                         'classname':'{$lists.classname|default=""}',

                    }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'count', align:'center',  title: '已学习人数'}
                   

                ]]
            });
        };

        renderTable();
        table.render({
            id:'station_table'
            ,width:500
            ,method:'post'
            ,autoSort: true
            ,elem: '#station_table'
            ,url: "/rackstage/Getinfo/getstation"
            ,where: {
                'station':'{$list.station|default=""}',
            }
            ,cols: [[
                {type:'numbers',  title: '编号'}
                ,{field:'pid_name', align:'center',  title: '地区'}
                ,{field:'posts', align:'center',  title: '岗位'}
            ]]

        });
       



	})
   

</script>
</body>
</html>