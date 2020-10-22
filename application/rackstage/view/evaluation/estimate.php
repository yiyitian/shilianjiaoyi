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
    <input name="id" type="hidden" value="{$info.id|default=''}" />


{volist name="data" id="vo"}
    <div class="layui-form-item">
        <label class="layui-form-label">{$vo.posts}</label>
        <div class="layui-input-inline">
            <input type="text" id="name" name="station{$vo.id}" lay-verify="required" value="{$vo.station{$vo.id}|default=''}" placeholder="请输入岗位名称" autocomplete="off" class="layui-input">
        </div>
    </div>
{/volist}


</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var callbackdata;
    layui.use(['layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form;
        //两级联动选择地区和部门
        form.on('select(region)', function(data){
            $.ajax({
                url: "getCate" ,
                data: {'cateId':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#department").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        })
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
            return true;
        }
    })

</script>
</body>
</html>