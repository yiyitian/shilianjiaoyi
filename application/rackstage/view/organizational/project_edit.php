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
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
	<input name="id" type="hidden" value="{$list.id|default=''}" />
    <div class="layui-form-item">
        <label class="layui-form-label">所属部门</label>
        <div class="layui-input-inline">
            <select name="framework_id" lay-filter="framework_id">
                <option value="{$list.framework_id|default=''}">{$list.framework_name_f|default=''}--{$list.framework_name|default=''}</option>
                {volist name="sonlist" id="vo"}
                <option value="{$vo.id}">{volist name="fatherlist" id="vofather"}
                    {if condition="$vofather.id eq $vo.pid"}{$vofather.name}--{/if}
                    {/volist}{$vo.name}</option>
                {/volist}

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目负责人</label>
        <div class="layui-input-inline">
            <select name="user_id" lay-filter="user_id" lay-search>
				<option></option>
                <option value='1' select>--</option>
                {volist name="user_list" id="vo"}
                {if condition="$vo.id eq $list.user_id"}
                <option value="{$vo.id}" selected>{$vo.user_name}</option>
                {else /}
                <option value="{$vo.id}">{$vo.user_name}</option>
                {/if}
                {/volist}

            </select>
        </div>
        <div class="layui-inline layui-word-aux">
            后台用户中，角色为“项目负责人”的用户
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目经理</label>
        <div class="layui-input-inline">
            <select name="manager" id="manager" lay-filter="manager" lay-search>
				<option></option>
                <option value='1' select>此为默认选项，若有经理，联系管理员删除此项</option>
                {volist name="manager_list" id="vo"}
                {if condition="$vo.id eq $list.manager"}
                <option value="{$vo.id}" selected>{$vo.user_name}</option>
                {else /}
                <option value="{$vo.id}">{$vo.user_name}</option>
                {/if}
                {/volist}

            </select>
        </div>
        <div class="layui-inline layui-word-aux">
            后台用户中，角色为“项目经理”的用户
        </div>
    </div>

    
    <div class="layui-form-item">
        <label class="layui-form-label">项目名称</label>
        <div class="layui-input-inline">
            <input type="text" id="name" name="name" lay-verify="required" value="{$list.name|default=''}" placeholder="请输入项目名称" autocomplete="off" class="layui-input">
        </div>
    </div>
         <label class="layui-form-label">目标</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="aims" lay-verify="required" value="{$list.aims|default=''}" placeholder="请输入目标" autocomplete="off" class="layui-input">
        </div>
    </div>
         <div class="layui-form-item">
        <label class="layui-form-label">项目类型</label>
        <div class="layui-input-block">
        {if condition="isset($list)&&($list.type eq 2)"}
            <input type="radio" name="type" value="1" title="住宅" >
            <input type="radio" name="type" value="2" title="商用" checked>
            {else /}
            <input type="radio" name="type" value="1" title="住宅" checked>
            <input type="radio" name="type" value="2" title="商用" >

        {/if}
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label">是否联代</label>
        <div class="layui-input-block">
            {if condition="isset($list)&&($list.is_agent eq -1)"}
            <input type="radio" name="is_agent" value="1" title="联代" >
            <input type="radio" name="is_agent" value="-1" title="非联代" checked>
            {else /}
            <input type="radio" name="is_agent" value="1" title="联代" checked>
            <input type="radio" name="is_agent" value="-1" title="非联代" >
            {/if}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否启用</label>
        <div class="layui-input-block">
		{if condition="isset($list)&&($list.status eq '-1')"}
            <input type="radio" name="status" value="1" title="启用" >
            <input type="radio" name="status" value="-1" title="不启用" checked>
			{else /}
            <input type="radio" name="status" value="1" title="启用" checked>
            <input type="radio" name="status" value="-1" title="不启用" >

		{/if}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否考核项目</label>
        <div class="layui-input-block">
		{if condition="isset($list)&&($list.is_assessment eq '-1')"}
            <input type="radio" name="is_assessment" value="1" title="是" >
            <input type="radio" name="is_assessment" value="-1" title="否" checked>
			{else /}
            <input type="radio" name="is_assessment" value="1" title="是" checked>
            <input type="radio" name="is_assessment" value="-1" title="否" >

		{/if}
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">项目备注</label>
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
            if($('#framework_id').val()==""){ layer.alert($('#framework_id').attr('placeholder'));  return false;};
            if($('#user_id').val()==""){ layer.alert($('#user_id').attr('placeholder'));  return false;};
            if($('#name').val()==""){ layer.alert($('#name').attr('placeholder'));  return false;};
            return true;
        }
    })

</script>
</body>
</html>