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
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" lay-verify="required" value="{$list.title|default=''}" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否启用</label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="启用" {notempty name="list.status"}{if condition="$list.status eq '1'"}checked{/if}{/notempty}>
            <input type="radio" name="status" value="-1" title="不启用" {notempty name="list.status"}{if condition="$list.status eq '-1'"}checked{/if}{/notempty}>

        </div>
    </div>
    <input type="hidden" name="id" value="{$id}"/>
    <input type="hidden" name="edit" value="1"/>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">分类备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
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
            //if($('#contract_num').val()==""){ layer.alert('合同编号不能为空'); return false;};
            

            return true;

        }

    })

</script>
</body>
</html>