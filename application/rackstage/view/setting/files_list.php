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
        <div class="layui-inline">
            <input class="layui-input" name="contract_num" value="" id="title" placeholder="文件名称" autocomplete="off">
        </div>
         <div class="layui-inline">
            <input class="layui-input" name="uname" value="" id="uname" placeholder="上传人" autocomplete="off">
        </div>
        <button class="layui-btn search" data-type="reload">搜索</button>
        <button type="reset" class="layui-btn" id="reset">重置</button>

    </div>

    <table class="layui-hide"  lay-filter="test" id="test"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-normal" lay-event="del">删除</a>
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
            $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');
            renderTable();
        });
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        var renderTable = function() {
            table.render({
                id: 'test',
                elem: '#test'
                , url: 'filesList?id={$pro_id}'
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
                    , {field: 'name', align: 'center', title: '文件名称'}
                    , {field: 'uname', align: 'center', title: '上传人'}
                    , {field: 'times', align: 'center', title: '上传时间'}

                    , {fixed: 'right', width: 210, align: 'center', toolbar: '#barDemo', title: '操作'}

                ]]
            });

        }

        var $ = layui.$, active = {
            reload: function(){
                table.reload('test', {
                    url: 'search1'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        title:$('#title').val(),
                        uname:$('#uname').val(),
                        pro_id:{$pro_id}
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        renderTable();
        //renderPostTable();
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
                    content: 'weekinfo_edit?pro_id={$pro_id}&times='+data.times,
                    zIndex: layer.zIndex, //重点1
                    yes: function(){
                        layer.closeAll();
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } else if(obj.event === 'see'){
                console.log(data);
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: [clientWidth*0.9+'px', '600px'],
                    maxmin: true,
                    content: 'weekinfo_see?pro_id={$pro_id}&times='+data.times,
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
                        url: "filesDel" ,
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
                area: ['95%', '550px'],
                maxmin: true,
                content: 'weekinfo_add?pro_id={$pro_id}',
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