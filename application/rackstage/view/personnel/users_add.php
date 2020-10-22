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
    <input type="hidden" id="id" name="users[id]" lay-verify="required" value="{$list.id|default=''}">

    <div class="layui-form-item">
        <label class="layui-form-label">工号</label>
        <div class="layui-input-inline">
            <input type="text" id="work_id" name="users[work_id]" lay-verify="required" value="{$list.work_id|default=''}" placeholder="请输入工号" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">员工姓名</label>
        <div class="layui-input-inline">
            <input type="text" id="username" name="users[username]" lay-verify="required" value="{$list.username|default=''}" placeholder="请输入员工姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <!-- <div class="layui-form-item">
        <label class="layui-form-label">手机号</label>
        <div class="layui-input-inline">
            <input type="text" id="phone" name="users[phone]" lay-verify="required" value="{$list.phone|default=''}" placeholder="请输入手机号" autocomplete="off" class="layui-input">
        </div>
    </div> -->
    <div class="layui-form-item">
        <label class="layui-form-label">出生日期</label>
        <div class="layui-input-inline">
            <input type="text" id="birthday" name="users[birthday]" lay-verify="required" value="{$list.birthday|default=''}" placeholder="请选择出生日期" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">性别</label>
        <div class="layui-input-inline">
            {notempty name="list.sex"}
            <input type="radio" name="users[sex]" value="1" title="男" {if condition="$list['sex'] eq '1'"}checked{/if}>
            <input type="radio" name="users[sex]" value="-1" title="女" {if condition="$list['sex'] eq '-1'"}checked{/if}>
            {else /}
            <input type="radio" name="users[sex]" value="1" title="男" checked>
            <input type="radio" name="users[sex]" value="-1" title="女" >
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">独立项目</label>
        <div class="layui-input-inline">
            {notempty name="list.independent"}
            <input type="radio" name="users[independent]" value="1" title="否" {if condition="$list['independent'] eq '1'"}checked{/if}>
            <input type="radio" name="users[independent]" value="-1" title="是" {if condition="$list['independent'] eq '-1'"}checked{/if}>
            {else /}
            <input type="radio" name="users[independent]" value="1" title="否" checked>
            <input type="radio" name="users[independent]" value="-1" title="是" >
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">婚姻状况</label>
        <div class="layui-input-inline">

            {notempty name="list.marriage"}
            <input type="radio" name="users[marriage]" value="-1" title="未婚" {if condition="$list['marriage'] eq '-1'"}checked{/if}>
            <input type="radio" name="users[marriage]" value="1" title="已婚" {if condition="$list['marriage'] eq '1'"}checked{/if}>
            {else /}
            <input type="radio" name="users[marriage]" value="-1" title="未婚" checked>
            <input type="radio" name="users[marriage]" value="1" title="已婚" >
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">户籍所在地</label>
        <div class="layui-input-inline" style="width:200px;">
            {notempty name="list.domicile"}
            <input type="text" id="domicile" name="users[domicile]" lay-verify="required" value="{$list.domicile|default=''}" placeholder="户籍所在地" autocomplete="off" class="layui-input" />
            {else /}
            <select id="province" name="users[province]" lay-filter="province">
                <option></option>
                {volist name="province" id="vo"}
                <option value="{$vo.codes}">{$vo.name_se}</option>
                {/volist}
            </select>
        </div>
        <div class="layui-input-inline" style="width:200px;">
            <select id="city" name="users[city]" lay-filter="city" placeholder="请选择户籍所在地">
                <option></option>
            </select>
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">最高学历</label>
        <div class="layui-input-inline">
            <select id="education" name="users[education]" lay-filter="education" placeholder="请选择学历">
                <option></option>
                {notempty name="list.education"}
                <option value="{$list.education}" selected>{$list.education}</option>
                {/notempty}
                <option value="初中">初中</option>
                <option value="高中">高中</option>
                <option value="专科">专科</option>
                <option value="本科">本科</option>
                <option value="硕士研究生">硕士研究生</option>
                <option value="博士研究生">博士研究生</option>

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">毕业院校</label>
        <div class="layui-input-inline">
            <input type="text" id="universit" name="users[universit]" lay-verify="required" value="{$list.universit|default=''}" placeholder="请输入毕业院校" autocomplete="off" class="layui-input" />
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所学专业</label>
        <div class="layui-input-inline">
            <input type="text" id="major" name="users[major]" lay-verify="required" value="{$list.major|default=''}" placeholder="请输入所学专业" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">入职日期</label>
        <div class="layui-input-inline">
            <input type="text" id="start_time" name="users[start_time]" lay-verify="required" value="{$list.start_time|default=''}" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">所属地区</label>
        <div class="layui-input-inline" style="width:200px;">
            <select id="region" name="users[region]" lay-filter="region">
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
            <select id="department" name="users[department]" lay-filter="department" placeholder="请选择部门">
                {notempty name="depart"}
                   {volist name="depart" id="vo"}
                        <option value="{$vo.id}" {if condition="$vo.id eq $list.department"}selected{/if}>{$vo.name}</option>
                    {/volist}
                {/notempty}

            </select>
        </div>
        <div class="layui-input-inline" style="width:200px;">
            <select id="station" name="users[station]" lay-filter="station" placeholder="请选择岗位">
                {notempty name="station"}
                    {volist name="station" id="vo"}
                    <option value="{$vo.id}" {if condition="$vo.id eq $list.station"}selected{/if}>{$vo.posts}</option>
                    {/volist}
                {/notempty}

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目名称</label>
       <div class="layui-input-inline">
            <select id="projectname" name="users[projectname]" lay-filter="projectname" placeholder="请选择项目名称">
                {notempty name="project"}
                    <option value="" >请选择</option>
                    {volist name="project" id="vo"}
                    <option value="{$vo.id}" {if condition="isset($list)&&($vo.id eq $list.projectname)"}selected{/if}>{$vo.name}</option>
                    {/volist}
                {/notempty}
            </select>
        </div> 
        <div class="layui-inline layui-word-aux">请先选部门再选项目</div>
    </div>
    {notempty name='list'}
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <span class="layui-btn layui-btn-danger " id="resetpassword">重置密码</span>
        </div>
    </div>
    {/notempty}
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var callbackdata;
    layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate=layui.laydate
        laydate.render({
            elem:"#birthday",
        });
        laydate.render({
            elem:"#start_time",
        });
        $('#resetpassword').click(function(){
            $.ajax({
                url: "/rackstage/Personnel/resetpassword" ,
                data: {'id':{$list.id|default='0'}} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.open({
                        title: '密码已重置'
                        ,content: '新密码：'+data.msg
                    });

                }
            })
        });
        //联动选择地区和部门
        form.on('select(province)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/get_city_area" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].codes+"'>"+data[i].name_se+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        form.on('select(city)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/get_city_area" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    //console.log(data);
                    $("#area").empty();
                    $("#area").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#area").append("<option value='"+data[i].codes+"'>"+data[i].name_se+"</option>");//新增
                    }

                    form.render('select');
                }
            })
        });
        //所属岗位开始
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

                    post=data.post
                    $("#station").empty();
                    $("#station").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < post.length; i++){
                        $("#station").append("<option value='"+post[i].id+"'>"+post[i].posts+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        //所属项目开始
        form.on('select(department)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getProject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);

                    $("#projectname").empty();
                    $("#projectname").append("<option value=''>请选择</option>");//新增
                    $("#projectname").append("<option value='0'>暂无项目</option>");
                    if(data==''){
                        layer.msg('暂无项目', {icon:0});

                        //return false;
                    }
                    for(var i = 0; i < data.length; i++){
                        $("#projectname").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });

        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }
            else {
                var data =$("#formid").serialize();
                return data;
            }
        }
    function isRealNum(val){
        // isNaN()函数 把空串 空格 以及NUll 按照0来处理 所以先去除，

        if(val === "" || val ==null){
            return false;
        }
        if(!isNaN(val)){
            //对于空数组和只有一个数值成员的数组或全是数字组成的字符串，isNaN返回false，例如：'123'、[]、[2]、['123'],isNaN返回false,
            //所以如果不需要val包含这些特殊情况，则这个判断改写为if(!isNaN(val) && typeof val === 'number' )
            return true;
        }

        else{
            return false;
        }
    }
        //自定义验证规则
        function verifycontent() {
            var sd = $('#work_id').val();
            var i = sd.substring(0, 2);
            if('' !==i)
            {
                
                var s = sd.substring(sd.length-5);
                var is = isRealNum(s);
                if(!is)
                {
                    layer.alert('工号不规范');return false;
                }
            }

            if($('#username').val()==""){ layer.alert($('#username').attr('placeholder'));  return false;};
            if($('#birthday').val()==""){ layer.alert($('#birthday').attr('placeholder'));  return false;};
            if($('#city').val()==""){ layer.alert($('#city').attr('placeholder'));  return false;};
            // if($('#phone').val()==""){ layer.alert($('#phone').attr('placeholder'));  return false;};
            if($('#domicile').val()==""){ layer.alert($('#domicile').attr('placeholder'));  return false;};
            if($('#education').val()==""){ layer.alert('请选择学历');  return false;};
            if($('#start_time').val()==""){ layer.alert('请选择入职时间');  return false;};
            if($('#department').val()==""){ layer.alert($('#department').attr('placeholder'));  return false;};
            // if($('#station').val()==""){ layer.alert($('#station').attr('placeholder'));  return false;};
            // if($('#projectname').val()==""){ layer.alert('请选择项目');  return false;};

            return true;
        }

    })

</script>
</body>
</html>