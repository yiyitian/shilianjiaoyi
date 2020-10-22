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
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 5px;">
            <legend>月报列表</legend>
        </fieldset>
        <div class="demoTable">
        {empty name='settime'}
            <button class="layui-btn" id="add">添加</button>
        {else /}
            收集时间：{$settime}
        {/empty}
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            {empty name='settime'}

            {if condition="($_SESSION.think.role_title eq '项目负责人')OR($_SESSION.think.role_title eq '项目经理')"}
            {{#  if(d.LAY_INDEX==1){ }}
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {{#  } }}
            {else /}

            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {/if}
            {/empty}
        </script>
        <div id="pages" class="text-center"></div>
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
                , url: 'monthinfo?id={$pro_id}'
                , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    , limit: 25 //一页显示多少条
                    , limits: [25, 50, 100]//每页条数的选择项
                    , groups: 2 //只显示 2 个连续页码
                    , first: "首页" //不显示首页
                    , last: "尾页" //不显示尾页
                }
                , cols: [[
                    {type: 'numbers', width: '5%', title: '编号'}
                    , {field: 'title', align: 'center', title: '月份起始时间'}
                    , {fixed: 'right', width: 210, align: 'center', toolbar: '#barDemo', title: '操作'}

                ]]
            });
        }
        renderTable();

        table.on('tool(test)', function(obj){
            var data = obj.data;

            if(obj.event === 'edit'){
                console.log(data);
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: [clientWidth*0.9+'px', '600px'],
					                    btn: ['保存','关闭'],

                    maxmin: true,
                    content: 'monthinfo_edit?id='+data.id,
                    zIndex: layer.zIndex, //重点1
                    yes: function(){
                        layer.closeAll();
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            }else if(obj.event === 'see'){
                console.log(data);
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: [clientWidth*0.9+'px', '600px'],
                    maxmin: true,
                    content: 'monthinfo_see?id='+data.id,
                    zIndex: layer.zIndex, //重点1
                    yes: function(){
                        layer.closeAll();
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "monthinfo_del" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }
        });

        $(document).on('click','#add',function(){
            console.log({$pro_id});
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: ['95%', '60%'],
                maxmin: true,
                content: 'monthinfo_add?pro_id={$pro_id}',
                btn: ['保存'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    layer.closeAll();
                    renderTable();
                },
                cancel: function(){
                },
                end: function(){ //此处用于演示
                }
            });

        });

    });


</script>
</body>
</html>