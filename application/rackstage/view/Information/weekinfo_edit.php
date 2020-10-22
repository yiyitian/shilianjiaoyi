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
</style>
<body>



    <!-- 内容主体区域 -->
    <div style="padding: 15px;">

        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="weekinfo">周报列表</a>
        </script>


    </div>



<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
        layui.use(['table','layer', 'form','element','jquery'], function(){
            var table = layui.table,
                layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;
            var renderTable = function(){
                var time_code=$('#time_code').val();
                table.render({
                    id:'test'
                    ,elem: '#test'
                    ,url:'weekinfo_edit?id=1&pro_id={$pro_id}&times={$times}'
                    ,cols: [[
                        {type:'numbers', minWidth: 20, title: '编号'}
                        ,{field:'company',  width:'5.5%', align:'center',edit:'text',  title: '公司名称'}
                        ,{field:'comecall',  width:'5.5%', align:'center', edit:'text',  title: '来电(组)'}
                        ,{field:'comevisit', width:'5.5%', align:'center',edit:'text',  title: '来访(组)'}
                        ,{field:'weektao', align:'center',width:'7.5%',edit:'text', title: '周认购总套数'}
                        ,{field:'mainhouse', align:'center',width:'7.5%',edit:'text', title: '周认购总金额(万)'}
                        ,{field:'weekjine', align:'center',width:'7.5%',edit:'text',title:'周成交主房套数'}
                        ,{field:'monthtao', align:'center',width:'7.5%',edit:'text',title:'月认购套数'}
                        ,{field:'monthjine', align:'center',width:'7.5%',edit:'text',title:'月认购金额(万)'}
                        //,{field:'yearaim', align:'center',edit:'text',title:'年认购目标(万)'}
                        ,{field:'yearjine', align:'center',width:'7.5%',edit:'text',title:'年认购金额(万)'}
//                        ,{field:'yearincome', align:'center',width:'7.5%',edit:'text',title:'年创收金额(万)'}
//                        ,{field:'weshare', align:'center',width:'7.5%',edit:'text',title:'分享加油站'}
                        ,{field:'remark', align:'center',width:'7.5%',edit:'text',title:'备注'}

                    ]]
                });
            }
            renderTable();
            //编辑表格工具
            table.on('edit(test)', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

                $.ajax({
                    url: "weekinfo_field_edit",
                    data: {'id':data.id,'field':field,'value':value} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,time:500},function(){
                            //renderTable();
                        });
                    }
                })
            });
            //监听select start
            form.on('select(time_code)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url: "creatweekinfo" ,
                    data: {'time_code':data.value,'pro_id':{$pro_id},'check':'1'} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){

                            layer.msg(data.msg, {icon: data.code,time:1000},function(){
                                renderTable();
                            });



                    }
                })
            })
     })

</script>
</body>
</html>