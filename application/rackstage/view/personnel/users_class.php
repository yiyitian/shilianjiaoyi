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
    .layui-form{margin-left: 50px;}
</style>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <legend>已学习课程</legend>
</fieldset>
<table class="layui-hide" style="width:90%;display: block;margin:0 auto;"  lay-filter="classinfo" id="classinfo"></table>
<!--<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">-->
<!--    <legend>已通知，但未学习课程</legend>-->
<!--</fieldset>-->
<!--<table class="layui-hide"  lay-filter="notice" id="notice"></table>-->

<!--<fieldset class="layui-elem-field layui-field-title site-title">-->
<!--    <legend>可根据课程类型选择课程，保存后将覆盖之前选择的所有课程，请慎重选择！</legend>-->
<!--</fieldset>-->
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<!--<form class="layui-form" action="" id="formid"  >-->
<!--    <div class="demoTable layui-form">-->
<!--        <div class="layui-form-item">-->
<!--            <div class="layui-input-inline" style="width:150px;">-->
<!--                <select name="classtype" id="classtype" lay-filter="classtype">-->
<!--                    <option value="">课程类型</option>-->
<!--                    {volist name="classArr" id="vo"}-->
<!--                    <option value="{$vo.id}">{$vo.title}</option>-->
<!--                    {/volist}-->
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <input name="id"  type="hidden" value="{$id}" />-->
<!--    <input name="classes" id="classes" type="hidden" />-->
<!--</form>-->
<!--<table class="layui-hide"  lay-filter="test" id="test"></table>-->

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <legend>新增培训记录</legend>
</fieldset>
<form class="layui-form layui-form-pane" id="form">

    <div class="layui-form-item">
        <label class="layui-form-label">课程选择</label>
        <div class="layui-input-inline">
            <select name="classify_id" lay-filter="classify" id="classify">
                <option value="">请选择</option>
                {volist name="classArrs" id="vo"}-->
                      <option value="{$vo.id}">{$vo.title}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">培训场次</label>
        <div class="layui-input-inline">
            <select name="class_time" id="class_time" lay-filter="class_time">

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">培训得分</label>
        <div class="layui-input-inline">
            <input type="text" name="branch" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            <input type="hidden" name="uid" value="{$id}" />
        </div>
    </div>
    <div class="layui-form-item">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
    </div>
</form>
<div id="pages" class="text-center"></div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    layui.use(['layer', 'table','element','jquery','laydate','form'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate=layui.laydate;
        form.on('submit(demo1)', function(data){
            var data =$("#formid").serialize();
            $.ajax({
                url: "addTrain" ,
                data: $("#form").serialize() ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon:1,time:500},function(){
                        $(".layui-laypage-btn").click();})
                }
            })

            return false;
        });
        form.on('select(classify)', function(data){
            $.ajax({
                url: "getOutline" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#class_time").empty();
                    $("#class_time").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#class_time").append("<option value='"+data[i].id+"'>"+data[i].area+"-"+data[i].username+"-"+data[i].startdate+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });

        table.on('tool(classinfo)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "DelUserClassId" ,
                        data: {'id':data.id,'userId':"{$id}"} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                                layer.msg('删除成功', {icon:1,time:500},function(){
                                    $(".layui-laypage-btn").click();
                            });
                        }
                    })
                });
            }
        });
        table.render({
            id:'classinfo'
            ,width:'500'
            ,elem: '#classinfo'
            ,url:'users_class?classinfo=1&id={$id}'
            ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                //,curr: 5 //设定初始在第 5 页
                ,limit:25 //一页显示多少条
                ,limits:[25,50,100,99999]//每页条数的选择项
                ,groups: 6 //只显示 2 个连续页码
                ,first: "首页" //不显示首页
                ,last: "尾页" //不显示尾页

            }
            ,cols: [[
                {type:'numbers', minWidth: 20, title: '编号'}
                ,{field:'title',  align:'center',  title: '课程分类'}
                ,{ width:150, align:'center', toolbar: '#barDemo',title:'操作'}
            ]]
        });
        table.render({
            id:'notice'
            ,width:'500'
            ,elem: '#notice'
            ,url:'users_class?notice=1&id={$id}'

            ,page: false
            ,cols: [[
                {type:'numbers', minWidth: 20, title: '编号'}
                ,{field:'title',  align:'center',  title: '课程分类'}


            ]]
        });
/////////////////课程选择开始
        //监听 select start
        form.on('select(classtype)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.othis); //得到美化后的DOM对象
            //执行重载
            table.reload('test', {
                url: 'class_lists?list=1'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    classtype: data.value
                }
            });
        });
        table.render({
            id:'test',
            elem: '#test'
            ,width:500
            ,url:'class_lists'
            ,page:false
            ,cols: [[
                {type:'checkbox'}
                ,{type:'numbers', title: '编号'}
                ,{field:'title', align:'center',  title: '课程分类'}


            ]]
        });

        table.on('checkbox(test)', function(obj){
            console.log(obj.checked); //当前是否选中状态
            console.log(obj.data); //选中行的相关数据
            console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
            if(obj.type=='one'){
                var classes=$('#classes').val();
                if(obj.checked){
                    console.log(obj.data.id)
                    if(classes=='')
                    {
                        $('#classes').val(obj.data.id)
                    }else
                    {
                        $('#classes').val(classes+','+obj.data.id)
                    }

                }else
                {
                    if(classes!=''){
                        classes=','+classes+',';
                        check_id=','+obj.data.id+',';
                        console.log(classes)
                        console.log(check_id)
                        var result=classes.replace(check_id, ',');

                        //console.log(result.length)
                        if(result.length>2)
                        {
                            console.log(result)
                            result=result.substr(1,result.length-2);
                            console.log(result)
                            $('#classes').val(result);
                        }else{
                            $('#classes').val('');
                        }
                    }
                }

            }else if(obj.type=='all'){
                if(obj.checked){
                    $('#classes').val('all');
                }else{
                    $('#classes').val('');
                }
            }

        });
        callbackdata=function () {
            var data  = 1;
            return data;
        }
    })

</script>
</body>
</html>