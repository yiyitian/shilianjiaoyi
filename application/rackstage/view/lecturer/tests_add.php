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


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    {notempty name="id"}
        <input type="hidden" name="id" value="{$id}">
    {else /}
        {if condition="$times eq ''"}
            <input type="hidden" name="times" value="{$list.times|default=''}">
        {else /}
            <input type="hidden" name="times" value="{$times}">
        {/if}
    {/notempty}
    {notempty name="act"}
        <input type="hidden" name="act" value="{$act}">
    {/notempty}
    <div class="layui-form-item">
        <label class="layui-form-label">课程类型</label>
        <div class="layui-input-inline">
            <select name="classtype" id="classtype" lay-filter="classtype">
                {notempty name="list"}
                <option value="{$list.classtype|default=''}">{$list.classtype_name|default=''}</option>
                {else /}
                <option value=""></option>
                {/notempty}
                {volist name="classArr" id="vo"}
                <option value="{$vo.id}">{$vo.title}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">课程分类</label>
        <div class="layui-input-inline">
            <select name="classify" id="classify" lay-filter="classify">
                {notempty name="list"}
                <option value="{$list.classify|default=''}">{$list.classify_name|default=''}</option>
                {else /}
                <option value=""></option>
                {/notempty}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-inline">
            <input type="text"  id="classtime"  name="title" value="{$list.title|default=''}"  placeholder="请输入标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>


        var callbackdata;
        layui.use(['layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;
            //返回值
            callbackdata=function () {
                if(!verifycontent()){
                    false;
                }else {
                    var data =$("#formid").serialize();
                    return data;
                }
            }
            //自定义验证规则
            function verifycontent() {
                if($('#types').val()==""){ layer.alert($('#types').attr('placeholder'));  return false;};
                if($('#levels').val()==""){ layer.alert($('#levels').attr('placeholder'));  return false;};
                if($('#classtime').val()==""){ layer.alert($('#classtime').attr('placeholder'));  return false;};
                if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }
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
            //监听  select end

        })

</script>
</body>
</html>