<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
    .layui-table-cell {
        font-size:14px;
        padding:0 5px;
        height:auto;
        overflow:visible;
        text-overflow:inherit;
        white-space:normal;
        word-wrap: break-word;
    }
</style>
<body>

<div style="padding: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 5px;">
        <legend>列表</legend>
    </fieldset>
    <table class="layui-hide"  lay-filter="test" id="test"></table>
    <div id="pages" class="text-center"></div>
</div>

<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery;
        var renderTable = function() {
            table.render({
                id: 'test',
                elem: '#test'
                , url: 'teacherDetails?uid={$uid}&code={$code}'

                , cols: [[
                    {type: 'numbers', width: '5%', title: '序号'}
                    ,{field:'master', align:'center',  title: '班主任'}
                    ,{field:'classify', align:'center',  title: '课程类型'}
                    ,{field:'startdate', align:'center',  title: '课程时间'}
                    ,{field:'classname', align:'center',  title: '课程名称'}
                    ,{field:'classtime', align:'center',  title: '上课时长'}
                    ,{field:'a',  align:'center',  title: '专业知识'}
                    ,{field:'b',  align:'center',  title: '授课技巧'}
                    ,{field:'c', align:'center',  title: '课堂气氛'}
                    ,{field:'d',  align:'center',  title: '理论案例'}
                    ,{field:'e',  align:'center',  title: '反应解答'}
                    ,{field:'f',  align:'center',  title: '节奏把控'}
                    ,{field:'g',  align:'center',  title: '教材相符'}

                ]]
            });
        }
        renderTable();
    });


</script>
</body>
</html>