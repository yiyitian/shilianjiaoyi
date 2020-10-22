<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
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

    <!-- 内容主体区域 -->
   <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline layui-form" style="">
                <select id="ready" name="search_field" lay-search>
                    <option value="10">请选择</option>
                    <option value="1">已阅读</option>
                    <option value="-1">未阅读</option>
                </select>
            </div>
             <div class="layui-input-inline layui-form" style="">

                <select id="du" name="search_field" lay-search>
                    <option value="10">请选择</option>
                    <option value="1">已完成</option>
                    <option value="-1">未完成</option>
                </select>
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索查询</button>
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
       
    </div>

<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        var renderTable = function() {
            table.render({
                id: 'test',
                elem: '#test'
                , url: 'articleDetail?cid={$id}'
               
                , cols: [[
                    {type: 'numbers', width: '5%', title: '编号'}
                    , {field: 'username', align: 'center', title: '用户名称'}
                    , {field: 'region', align: 'center', title: '地区'}
                    , {field: 'department', align: 'center', title: '部门'}
                    , {field: 'station', align: 'center', title: '岗位'}
                    , {field: 'projectname', align: 'center', title: '项目名称'}
                    , {field: 'isReady', align: 'center', title: '是否阅读'}
                    , {field: 'isdu', align: 'center', title: '是否完成'}
                ]]
            });
        }
        renderTable();
         var $ = layui.$, active = {
            reload: function(){
                table.reload('test', {
                    url: 'getList'
                  
                    ,method: 'post'
                    ,where: {
                        ready: $('#ready').val(),
                        du: $('#du').val(),
                        cid:"{$id}",
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        
      
    });


</script>
</body>
</html>