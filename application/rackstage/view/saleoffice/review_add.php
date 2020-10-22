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
                {notempty name="list.region"}
                <option value="{$vo.id}" {if condition="$vo.id eq $list.region"}selected{/if}>{$vo.name}</option>
                {else /}
                <option value="{$vo.id}">{$vo.name}</option>
                {/notempty}
                {/volist}
            </select>
        </div>
        <div class="layui-input-inline" style="width:200px;">
            <select id="department" name="department" lay-filter="department">
                <option></option>
                {notempty name="list.department"}
                <option value="{$list.department}" selected>{$list.department_name}</option>
                {/notempty}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择项目</label>
        <div class="layui-input-inline">
           <select name="project_id" id="projectName" lay-verify="required" lay-search="">
                {notempty   name="list"}
                    {volist name="lists" id="vo"}
                        <option value="{$vo.id}" {if condition="$vo.id eq $list.project_id"} selected {/if}>{$vo.name}</option>
                    {/volist}}
                {/notempty}}
                </select>
        </div>
        <div class="layui-form-mid layui-word-aux">若列表中没有，请先添加项目</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户姓名</label>
        <div class="layui-input-inline">
            <input type="text"  id="customer"  name="customer" value="{$list.customer|default=''}"  placeholder="请输入客户姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户电话</label>
        <div class="layui-input-inline">
            <input type="text" id="phone" name="phone" value="{$list.phone|default=''}" placeholder="请输入客户电话" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">业务员</label>
        <div class="layui-input-inline">
            <input type="text" id="salesman" name="salesman" value="{$list.salesman|default=''}" placeholder="请输入业务员姓名" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">

        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">抽查时间</label>
        <div class="layui-input-inline">
            <input type="text"  id="enquirytime"  autocomplete="off"  name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">主动接待</label>
        <div class="layui-input-block">
            {empty name="list"}
            <input type="radio" name="positive" value="1" title="1分">
            <input type="radio" name="positive" value="0" title="0分">
            {else /}
            <input type="radio" name="positive" value="1" title="1分" {if condition="$list.positive eq '1'"} checked {/if}>
            <input type="radio" name="positive" value="0" title="0分" {if condition="$list.positive eq '0'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            (是1分，否0分)
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">耐心回答</label>

        <div class="layui-input-block">
            {empty name="list"}
            <input type="radio" name="patient" value="1" title="1分">
            <input type="radio" name="patient" value="0" title="0分">
            {else /}
            <input type="radio" name="patient" value="1" title="1分" {if condition="$list.patient eq '1'"} checked {/if}>
            <input type="radio" name="patient" value="0" title="0分" {if condition="$list.patient eq '0'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            (是1分，否0分)
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户了解楼盘</label>
        
        <div class="layui-input-block">
            {empty name="list"}
            <input type="radio" name="lucid" value="1" title="1分">
            <input type="radio" name="lucid" value="0" title="0分">
            {else /}
            <input type="radio" name="lucid" value="1" title="1分" {if condition="$list.lucid eq '1'"} checked {/if}>
            <input type="radio" name="lucid" value="0" title="0分" {if condition="$list.lucid eq '0'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            客户是否清楚了解所需楼盘情况（是1分，否0分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">有无异议</label>

        <div class="layui-input-block">
            {empty name="list"}
            <input type="radio" name="dissent" value="1" title="1分">
            <input type="radio" name="dissent" value="0" title="0分">
            {else /}
            <input type="radio" name="dissent" value="1" title="1分" {if condition="$list.dissent eq '1'"} checked {/if}>
            <input type="radio" name="dissent" value="0" title="0分" {if condition="$list.dissent eq '0'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            对销售代表在接待过程中介绍的购房所产生的费用有无异议?（无1分，有0分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户对服务评分</label>
        <div class="layui-input-inline">
            <input type="text" id="appraise" name="appraise" value="{$list.appraise|default=''}" placeholder="客户对服务评分" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">
            （1-5分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户建议</label>
        <div class="layui-input-block">
            {empty name="list"}
            <input type="radio" name="suggest" value="1" title="1分">
            <input type="radio" name="suggest" value="0" title="0分">
            <input type="radio" name="suggest" value="-1" title="-1分">
            {else /}
            <input type="radio" name="suggest" value="1" title="1分" {if condition="$list.suggest eq '1'"} checked {/if}>
            <input type="radio" name="suggest" value="0" title="0分" {if condition="$list.suggest eq '0'"} checked {/if}>
            <input type="radio" name="suggest" value="-1" title="-1分" {if condition="$list.suggest eq '-1'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            表扬1分，无0分，投诉－1分
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">总分</label>
        <div class="layui-input-inline">
            <input type="text" id="score" name="score" value="{$list.score|default=''}" placeholder="总分" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">

        </div>
    </div>
   
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
    var callbackdata;
        layui.use(['laydate','layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            $(document).on('click','.del_uploads',function(){
                var O_id=$(this).attr('indexs');
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/index/uploads_del" ,
                        data: {'id':O_id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                location.reload();
                            });
                        }
                    })
                });
            });

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
//监听select  end
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
                if($('#projectName').val()==null){ layer.alert('项目部门不能为空');  return false;};
                 if($('#salesman').val()==""){ layer.alert('业务员不能为空');  return false;};

                 if($('#enquirytime').val()==""){ layer.alert('巡查时间不能为空');  return false;};

                 if($('#phone').val()==""){ layer.alert('客户电话不能为空');  return false;};
                 if($('#customer').val()==""){ layer.alert('客户不能为空');  return false;};


                return true;

            }
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

//所属项目开始
            
        })

</script>
</body>
</html>