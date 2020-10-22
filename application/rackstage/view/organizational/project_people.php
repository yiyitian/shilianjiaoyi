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
<div style="padding:  0;">
    <div class="demoTable">
       
        <button class="layui-btn" id="tel">添加</button>
        <button class="layui-btn" id="true">确认人员数据完成</button>

    </div>
    <table class="layui-hide"  lay-filter="test" id="test"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="editMaintain">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delMaintain">删除</a>
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
        if({$is_assessment} > 0)
        {
            table.render({
                id:'test',
                elem: '#test'
                ,url:"projectPeople?id={$id}"
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:1000 //一页显示多少条
                    ,limits:[1000,2000,3000]//每页条数的选择项
                    ,groups: 2 //只显示 2 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers', minWidth: 45, title: '序号'}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'phone', align:'center',  title: '电话'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'subsidy', align:'center', edit:'number',  title: '项目补助(元）'}
                    ,{field:'addtime', align:'center',  title: '入住项目时间'}
                    ,{field:'stoptime', align:'center',  title: '调整项目时间'}
                    ,{fixed: 'right', width:180, align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        }else{
            table.render({
                id:'test',
                elem: '#test'
                ,url:"projectPeople?id={$id}"
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:1000 //一页显示多少条
                    ,limits:[1000,2000,3000]//每页条数的选择项
                    ,groups: 2 //只显示 2 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers', minWidth: 45, title: '序号'}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'phone', align:'center',  title: '电话'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'addtime', align:'center',  title: '入住项目时间'}
                    ,{field:'stoptime', align:'center',  title: '调整项目时间'}
                    ,{fixed: 'right', width:180, align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        }


        /*搜索开始*/
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        var $ = layui.$, active = {
            reload: function(){
                var demoReload = $('#contract_num');
                //执行重载
                table.reload('test', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        title: demoReload.val()
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        /*搜索结束*/
        table.on('edit(test)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            $.ajax({
                url: "subsidyEdit" ,
                data: {'id':data.id,'field':field,'value':value} ,
                type: "post",
                dataType:'json',
                success:function(data){
                    $(".layui-laypage-btn").click();
                }
            })
        });

        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'delMaintain'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "delMaintain" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('删除成功', {icon: 1},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            } else if(obj.event === 'editMaintain'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"编辑数据",
                    area: ['900px', '600px'],
                    maxmin: true,
                    content: 'editMaintain?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"editMaintain",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{time: 2000},function () {
                                        location.reload();
                                    });
                                }else{
                                    layer.msg(data.msg, { icon: 0});
                                }
                            }
                        });
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } 
        });
    });

    layui.use(['table','layer','jquery'], function(){
        var $ = layui.jquery, layer = layui.layer;
        $(document).on('click','#true',function(){
            $.ajax({
                url: "isTrue",
                type: "post",
                data: {'id': {$id}},
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                }
            })
        });
        $(document).on('click','#tel',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: ['900px', '400px'],
                maxmin: true,
                content: 'projectPeopleAdd?id={$id}',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"projectPeopleAdd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{time: 2000},function () {
                                    location.reload();
                                });
                            }else{
                                layer.msg(data.msg, { icon: 0});
                            }
                        }
                    });
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