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


    </div>



<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
        layui.use(['table','layer', 'form','element','jquery'], function(){
            var table = layui.table,
                layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;
            var renderTable = function(){

                table.render({
                    id:'test'
                    ,elem: '#test'
                    ,url:'monthinfo_edit?list={$id}'
                    ,cols: [[
                        {type:'numbers', minWidth: 20, title: '编号'}
                        ,{field:'company',width:120,  align:'center',  title: '公司名称'}
//                        ,{field:'lastmonthcall',width:120,  align:'center',edit:'text',  title: '上月实际来电'}
//                        ,{field:'lastmonthcome',width:120,  align:'center',edit:'text',  title: '上月实际来访'}
                        ,{field:'lastmonthmainhouse',  align:'center',edit:'text',  title: '上月销售主房套数'}
//                        ,{field:'lastmonthparking',  align:'center',edit:'text',  title: '上月销售车位套数'}
//                        ,{field:'lastmonthbasement',  align:'center',edit:'text',  title: '上月销售地下室套数'}
                        ,{field:'lastmonthsale',  align:'center',edit:'text',  title: '上月实际销售额（万）'}
                        ,{field:'thismonthsale', align:'center',edit:'text',  title: '本月可售货量多少（万）'}
                        ,{field:'is_add', align:'center',edit:'text', title: '本月是否加推/开盘'}
                        ,{field:'addnum', align:'center',edit:'text',title:'加推/开盘总货量多少（万）'}
                        ,{field:'addaim', align:'center',edit:'text',title:'加推/开盘目标（万）'}
//                        ,{field:'obj_type', align:'center',title:'项目模式', event: 'set_obj_type', style:'cursor: pointer;'}
                        ,{field:'bestaim', align:'center',edit:'text',title:'本月预计销售最高目标多少（万）'}
//                        ,{field:'thismonth_flbaim', align:'center',edit:'text',title:'本月房联宝预计认购创收目标（万）'}
//                        ,{field:'thismonth_flbaim_done', align:'center',edit:'text',title:'本月房联宝预计可完成创收（万）'}
                        ,{field:'mark', align:'center',edit:'text',title:'备注'}

                    ]]
                    ,done: function(res, curr, count){
                        table.render({
                            id:'post'
                            ,elem: '#post'
                            ,url:'monthinfo_edit?list={$id}'
                            ,cols: [[
                                {field:'manager',  align:'center',edit:'text',  title: '项目经理'}
                                ,{field:'director',  align:'center',edit:'text',  title: '销售主管'}
                                ,{field:'delegate',  align:'center',edit:'text',  title: '销售代表'}
                                ,{field:'clerk',  align:'center',edit:'text',  title: '后台文员'}
                                ,{field:'plan',  align:'center',edit:'text',  title: '主策'}
                                ,{field:'assistantplan',  align:'center',edit:'text',  title: '助理策划'}


                            ]]

                        });
                    }
                });
            }
            renderTable();
            //监听单元格事件
            table.on('tool(test)', function(obj){
                var data = obj.data;
                if(obj.event === 'set_obj_type'){
                    layer.open({
                        type: 2,
                        shade: [0.1],
                        title:"添加/编辑",
                        area: ['600px', '430px'],
                        maxmin: true,
                        content: 'set_obj_type?obj_type='+data.obj_type+'&id='+data.id,
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
                }
            });
            //编辑表格工具
            table.on('edit(test)', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

                $.ajax({
                    url: "monthinfo_field_edit",
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
            table.on('edit(post)', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

                $.ajax({
                    url: "monthinfo_field_edit",
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

     })

</script>
</body>
</html>