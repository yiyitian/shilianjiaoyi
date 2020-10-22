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

  
   <div style="padding: 15px;">
        <div class="demoTable">
           <!--  <div class="layui-input-inline layui-form" style="">
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
            <button class="layui-btn search" data-type="reload" style="">搜索查询</button> -->
            <button class="layui-btn search" data-type="add" style="" id='add'>增加试题</button>

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="oper-col">
      
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="questionEdit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
       

    </script>
       
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
                , url: 'questionList?id='+{$id}
               ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                //,curr: 5 //设定初始在第 5 页
                ,limit:25 //一页显示多少条
                ,limits:[25,50,100]//每页条数的选择项
                ,groups: 6 //只显示 6 个连续页码
                ,first: "首页" //不显示首页
                ,last: "尾页" //不显示尾页
            }
                , cols: [[
                    {type: 'numbers', width: '5%', title: '编号'}
                    , {field: 'cid', align: 'center', title: '课程名称'}
                    , {field: 'question', align: 'center', title: '问题'}
                    , {field: 'option_a', align: 'center', title: '选项A'}
                    , {field: 'option_b', align: 'center', title: '选项B'}
                    , {field: 'option_c', align: 'center', title: '选项C'}
                    , {field: 'option_d', align: 'center', title: '选项D'}
                    , {field: 'true_option', align: 'center', title: '正确选项'}
                    ,{templet: '#oper-col',align:'center', title: '操作'}

                   
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
                        
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

         table.on('tool(test)', function(obj){
            var data = obj.data;

            if(obj.event === 'questionEdit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: ['100%', '100%'],
                    maxmin: true,
                    content: 'questionEdit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"questionEdit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon: data.code,time: 2000},function(){$(".layui-laypage-btn").click();});
                                }else{
                                    layer.msg(data.msg, { icon: data.code});
                                }
                            }
                        });
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "questionDel" ,
                        data: {'id':data.id} ,
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
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: ['80%', '80%'],
                maxmin: true,
                content: 'questionAdd?id='+{$id},
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:"questionAdd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            layer.closeAll();
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