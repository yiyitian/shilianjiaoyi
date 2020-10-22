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
    .layui-upload-img{width: 92px; height:92px; margin: 0 10px 10px 0; }
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">请选择地区</label>
        <div class="layui-input-inline">
            <select name="region" lay-filter="region">
                {volist name="framework" id="vo"}
                <option select="selected" value="{$vo.id}">{$vo.name}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">请选择部门</label>
        <div class="layui-input-inline">
            <select name="department" lay-filter="department" id="department">
                {if condition="isset($dept)"}
                {volist name="dept" id="dp"}
                <option value="{$dp.id}" {if condition="$info.department eq $dp.id"} selected="selected"{/if}>{$dp.name}</option>
                {/volist}
                {/if}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">请选择岗位</label>
        <div class="layui-input-inline">
            <select name="posts" lay-filter="posts" id="posts">
              <!--  {if condition="isset($dept)"}
                {volist name="dept" id="dp"}
                <option value="{$dp.id}" {if condition="$info.department eq $dp.id"} selected="selected"{/if}>{$dp.name}</option>
                {/volist}
                {/if}-->
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">请选择项目</label>
        <div class="layui-input-inline">
            <select name="projectname" lay-filter="projectname" id="projectname">
              <!--  {if condition="isset($dept)"}
                {volist name="dept" id="dp"}
                <option value="{$dp.id}" {if condition="$info.department eq $dp.id"} selected="selected"{/if}>{$dp.name}</option>
                {/volist}
                {/if}-->
            </select>
        </div>
    </div>
    {if condition="isset($info)"} <input type="hidden" name="id" value="{$info['id']}"/>{/if}
    {if condition="isset($type)"} <input type="hidden" name="type" value="{$type}"/>{/if}
    <div class="layui-form-item">
        <label class="layui-form-label">{if condition="isset($type)&&($type eq 1)"}岗位名称{else /}项目名称{/if}</label>
        <div class="layui-input-inline">
            <input type="text" id="name" name="posts" lay-verify="required" value="{$info.posts|default=''}" placeholder="请输入岗位名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否启用</label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="启用" {if condition="isset($info)&&($info.status eq 1)"}checked=""{/if}>
            <input type="radio" name="status" value="-1" title="不启用" {if condition="isset($info)&&($info.status eq -1)"}checked=""{/if}>

        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">岗位备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注内容" class="layui-textarea" name="remark" style="width:80%">{$info.remark|default=''}</textarea>
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
        form.on('select(region)', function(data){
            $.ajax({
                url: "getDepartment" ,
                data: {'id':data.value} ,
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
        form.on('select(department)', function(data){
            layer.msg(data.value);
            $.ajax({
                url: "getPost" ,
                data: {'id':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
					//console.log(data);
                    $("#area").empty();
                    $("#area").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#area").append("<option value='"+data[i].codes+"'>"+data[i].names+"</option>");//新增
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