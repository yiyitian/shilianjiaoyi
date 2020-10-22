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
    <input type="hidden" name="id" value="{$id|default=''}" />
<div class="layui-form-item">
    <label class="layui-form-label">课程名称</label>
    <div class="layui-input-inline">
        <select name="set_obj_type" id="set_obj_type" lay-filter="set_obj_type">
            {notempty name='obj_type'}
            <option value="{$obj_type}">{$obj_type}</option>
            {/notempty}
            <option value=""></option>
            <option value="纯代理">纯代理</option>
            <option value="代理+房联宝全包">代理+房联宝全包</option>
            <option value="代理+房联宝半包">代理+房联宝半包</option>
            <option value="代理+房联宝分销">代理+房联宝分销</option>
            <option value="代理+房联宝平台">代理+房联宝平台</option>
            <option value="代理+房联宝保证金">代理+房联宝保证金</option>
        </select>
    </div>
</div>
</form>




<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
        layui.use(['table','layer', 'form','element','jquery'], function(){
            var table = layui.table,
                layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;

            //监听select start
            form.on('select(set_obj_type)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url: "set_obj_type" ,
                    data: {'obj_type':data.value,'id':{$id}} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){

                           // layer.msg(data.msg, {icon: data.code,time:1000},function(){});



                    }
                })
            })
     })

</script>
</body>
</html>