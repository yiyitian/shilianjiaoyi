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
<body>

    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
          

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
   
        <div id="pages" class="text-center"></div>
    </div>

<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        var renderTable=function(){
            table.render({
                id:'test',
                elem: '#test'
                ,url:'kaohe?id={$id}&times={$times}'
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers', width: '5%', title: '编号'}
                    ,{field:'question', align:'center',  title: '试卷标题'}
                    ,{field:'option_a', align:'center',width:'8.5%',  title: '选项A'}
                    ,{field:'option_b', align:'center',width:'8.5%',  title: '选项B'}
                    ,{field:'option_c', align:'center',width:'8.5%',  title: '选项C'}
                    ,{field:'option_d', align:'center',width:'8.5%',  title: '选项D'}
                    ,{field:'true_option', align:'center',width:'8.5%',  title: '正确答案'}
                    ,{field:'error', align:'center',width:'8.5%', edit:'text', title: '培训人员答案'}
                ]]
            });
        }
        renderTable();

        table.on('edit(test)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

            $.ajax({
                url: "editAn",
                data: {'id':data.id,'value':value,'pid':data.pid} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon: data.code,time:500},function(){
                        //renderTable();
                    });
                }
            })
        });


        table.on('tool(test)', function(obj){
            var data = obj.data;

            if(obj.event === 'edit_question'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                    maxmin: true,
                    content: 'question_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"question_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon: data.code,time:500},function () {
                                        renderTable();//location.reload();
                                    });
                                }else{
                                    layer.msg(data.msg, {icon: 0});
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
                layer.confirm('从试卷中删除？(题库中问题保留)', function(index){
                    $.ajax({
                        url: "tests_q_del" ,
                        data: {'questions':data.id,'id':{$id}} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }

        });
        $(document).on('click','#add',function(){

            console.log({$id});
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'question_lists_choose?id={$id}',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    //layer.closeAll();
                    $.ajax({
                        url:"question_lists_choose",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            console.log(data);
                            layer.closeAll();
                            if(data.code==1){
                                layer.msg(data.msg,{icon:1,time: 500},function () {
                                    renderTable();
                                });
                            }else{
                                layer.msg(data.msg, {icon:0});
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