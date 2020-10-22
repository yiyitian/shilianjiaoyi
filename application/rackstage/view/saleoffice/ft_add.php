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
    <style>
        .search
        {
            left: 0;
            position: relative;
        }
        .layui-form-label{
            width:150px;
        }
        #auto_div
        {
            display: none;
            width: 300px;
            border: 1px #74c0f9 solid;
            background: #FFF;
            position: absolute;
            top: 40px;
            left: 0;
            color: #323232;
            z-index:999;
        }
    </style>
</head>

<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    {notempty name="id"}
    <input type="hidden" name="id" value="{$id}">
    {else /}
    {empty name='times'}
    <input type="hidden" name="times" value="{$list.times|default=''}">
    {else /}
    <input type="hidden" name="times" value="{$times}">
    {/empty}
    {/notempty}

    <div class="layui-form-item">
        <label class="layui-form-label">选择部门</label>
        <div class="layui-input-inline" style="width:200px;">
            <select id="region" name="region" lay-filter="region">
                <option></option>
                {volist name="region" id="vo"}
                <option value="{$vo.id}" {if condition="isset($list)&&$list.region eq $vo.id"} selected {/if}>{$vo.name}</option>
                {/volist}
            </select>
        </div>
        <div class="layui-input-inline" style="width:200px;">
            <select id="department" name="department" style="width:150%" lay-filter="department">
                <option></option>
                {notempty name="list.department"}
                <option value="{$list.department}" selected>{$list.department_name}</option>
                {/notempty}
            </select>
        </div>

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择项目</label>
        <div class="layui-input-inline" >
                <select name="project_id" id="projectName" style="width:150%" lay-verify="required" lay-search="">
                {notempty   name="list"}
                    {volist name="lists" id="vo"}
                        <option value="{$vo.id}" {if condition="$vo.id eq $list.project_id"} selected {/if}>{$vo.name}</option>
                    {/volist}}
                {/notempty}}
                </select>
        </div>

    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">项目经理</label>
        <div class="layui-input-inline">
            <input type="text"  id="manager"  name="manager" value="{$list.manager|default=''}"  style="width:150%" placeholder="请输入项目经理" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目策划</label>
        <div class="layui-input-inline">
            <input type="text"  id="plan"  name="plan" value="{$list.plan|default=''}"  style="width:150%" placeholder="请输入项目策划" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">访谈人姓名</label>
        <div class="layui-input-inline">
            <input type="text"  id="ftname"  name="ftname" value="{$list.ftname|default=''}"  style="width:150%" placeholder="请输入访谈人姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">被访谈人姓名</label>
        <div class="layui-input-inline">
            <input type="text"  id="bftname"  name="bftname" value="{$list.bftname|default=''}"  style="width:150%" placeholder="请输入被访谈人姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">被访谈人职位</label>
        <div class="layui-input-inline">
            <input type="text"  id="bftposts"  name="bftposts" value="{$list.bftposts|default=''}"  style="width:150%" placeholder="请输入被访谈人职位" class="layui-input">
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">访谈时间</label>
        <div class="layui-input-inline">
            <input type="text"  id="enquirytime"  autocomplete="off" name="fttime" value="{$list.fttime|default=''}" style="width:150%"  placeholder="请输入访谈时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">团队日常工作状态</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入内容" class="layui-textarea" name="status" style="width:150%">{$list.status|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">团队执行力</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入内容" class="layui-textarea" name="zxl" style="width:150%">{$list.zxl|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">策划和销售配合度</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入内容" class="layui-textarea" name="phd" style="width:150%">{$list.phd|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">对团队的建议</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入内容" class="layui-textarea" name="jy" style="width:150%">{$list.jy|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">甲方满意度</label>
        <div class="layui-input-inline" style="width:50%">
            <input type="radio" name="myd" value="非常满意" title="非常满意" {if condition="isset($list)&&($list.myd eq '非常满意')"} checked {/if}>
            <input type="radio" name="myd" value="满意" title="满意"  {if condition="isset($list)&&($list.myd eq '满意')"} checked {/if}>
            <input type="radio" name="myd" value="一般" title="一般"  {if condition="isset($list)&&($list.myd eq '一般')"} checked {/if}>
            <input type="radio" name="myd" value="不满意" title="不满意"   {if condition="isset($list)&&($list.myd eq '不满意')"} checked {/if}>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">问题反馈</label>
        <div class="layui-input-inline" >
            <textarea placeholder="请输入内容" class="layui-textarea" name="fk" style="width:150%">{$list.fk|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item ">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:150%">{$list.mark|default=''}</textarea>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>


    layui.use(['laydate','layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;


        laydate.render({
            elem: '#enquirytime'

        });
        //监听select  end
        // 所属部门开始
        form.on('select(region)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    framework=data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < framework.length; i++){
                        $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        form.on('select(department)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getproject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#projectName").empty();
                    $("#projectName").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#projectName").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
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
            if($('#projectName').val()==null){ layer.alert("项目部门不能为空");  return false;};
              if($('#manager').val()==""){ layer.alert("项目经理不能为空");  return false;};
              if($('#enquirytime').val()==""){ layer.alert("访谈时间不能为空");  return false;};
            return true;
        }
    })
</script>
</body>
</html>