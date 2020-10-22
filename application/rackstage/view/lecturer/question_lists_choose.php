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
        <form class="layui-form" action="" id="formid"  >
        <div class="demoTable layui-form">
            <div class="layui-form-item">
                <div class="layui-input-inline" style="width:150px;">
                    <select name="classtype" id="classtype" lay-filter="classtype">
                        <option value="">课程类型</option>
                        {volist name="classArr" id="vo"}
                        <option value="{$vo.id}">{$vo.title}</option>
                        {/volist}
                    </select>
                </div>
                <div class="layui-input-inline" style="width:160px;">
                    <select name="classify" id="classify" lay-filter="classify">
                        <option value="">先选课程类型</option>
                    </select>
                </div>
                <div class="layui-input-inline" style="width:300px;">
                    <select name="classname" id="classname" lay-filter="classname">
                        <option value="">先选课程分类</option>
                    </select>
                </div>
            </div>
        </div>

            <input name="id" id="id" type="hidden" value="{$id}" />
            <input name="questions" id="questions" type="hidden" />
        </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">

            <a class="layui-btn layui-btn-xs" lay-event="edit_question">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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

        //监听 select start
        form.on('select(classtype)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.othis); //得到美化后的DOM对象
            $.ajax({
                url: "classinfo" ,
                data: {'pid':data.value,'levels':'1'} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    var lists=data.data;
                    $("#classify").empty();
                    $("#classname").empty();
                    $("#classify").append("<option value=''>请选择</option>");
                    for(var i=0;i<lists.length;i++){
                        console.log(i+": "+lists[i]['title'])
                        $('#classify').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                    }
                    form.render('select');
                    //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                }
            })
        });
        form.on('select(classify)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.othis); //得到美化后的DOM对象
            $.ajax({
                url: "classinfo" ,
                data: {'pid':data.value,'levels':'2'} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    var lists=data.data;
                    $("#classname").empty();
                    $("#classname").append("<option value=''>请选择</option>");
                    for(var i=0;i<lists.length;i++){
                        console.log(i+": "+lists[i]['title'])
                        $('#classname').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                    }
                    form.render('select');
                    //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                }
            });
            //执行重载
            table.reload('test', {
                url: 'question_lists?list='+$('#id').val()
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    classify: data.value
                }
            });



        });
        form.on('select(classname)', function(data){
            //执行重载
            table.reload('test', {
                url: 'question_lists?list='+$('#id').val()
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    classify: $('#classify').val(),
                    classname: data.value
                }
            });
        });
        //监听  select end
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        table.render({
            id:'test',
            elem: '#test'
            ,url:'question_lists?list={$id}'
            ,page:false
            // ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
            //     layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
            //     //,curr: 5 //设定初始在第 5 页
            //     ,limit:25 //一页显示多少条
            //     ,limits:[25,50,100]//每页条数的选择项
            //     ,groups: 6 //只显示 6 个连续页码
            //     ,first: "首页" //不显示首页
            //     ,last: "尾页" //不显示尾页
            // }
            ,cols: [[
                {type:'checkbox'}
                ,{type:'numbers', width: '5%', title: '编号'}
                ,{field:'question', align:'center',  title: '试卷标题'}
                ,{field:'option_a', align:'center',width:'8.5%',  title: '选项A'}
                ,{field:'option_b', align:'center',width:'8.5%',  title: '选项B'}
                ,{field:'option_c', align:'center',width:'8.5%',  title: '选项C'}
                ,{field:'option_d', align:'center',width:'8.5%',  title: '选项D'}
                ,{field:'true_option', align:'center',width:'8.5%',  title: '答案'}

            ]]
        });
        table.on('checkbox(test)', function(obj){
            console.log(obj.checked); //当前是否选中状态
            console.log(obj.data); //选中行的相关数据
            console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
            if(obj.type=='one'){
                var questions=$('#questions').val();
                if(obj.checked){
                    console.log(obj.data.id)
                    if(questions=='')
                    {
                        $('#questions').val(obj.data.id)
                    }else
                    {
                        $('#questions').val(questions+','+obj.data.id)
                    }

                }else
                {
                    if(questions!=''){
                        questions=','+questions+',';
                        check_id=','+obj.data.id+',';
                        console.log(questions)
                        console.log(check_id)
                        var result=questions.replace(check_id, ',');

                        //console.log(result.length)
                        if(result.length>2)
                        {
                            console.log(result)
                            result=result.substr(1,result.length-2);
                            console.log(result)
                            $('#questions').val(result);
                        }else{
                            $('#questions').val('');
                        }
                    }
                }

            }else if(obj.type=='all'){
                if(obj.checked){
                    $('#questions').val('all');
                }else{
                    $('#questions').val('');
                }
            }

        });


        callbackdata=function () {

                var data =$("#formid").serialize();
                return data;

        }
    });

</script>
</body>
</html>