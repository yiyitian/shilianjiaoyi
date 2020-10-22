<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>世联怡高管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>

<body>

<form class="layui-form" action="" id="formid" style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名称</label>
        <div class="layui-input-inline" style="width: 200px;">
            <input type="text" readonly id="user_name" name="user_name" lay-verify="username" value="{$list.user_name|default=''}" disabled="disabled" placeholder="请输入角色名称" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">
            不可修改用户名
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">旧密码</label>
        <div class="layui-input-inline">
            <input type="password"  name="old_pwd" id="old_pwd" lay-verify="oldpass" value="" placeholder="请输入旧密码" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-inline">
            <input type="password"  name="pwd" id="pwd" lay-verify="pass" value="" placeholder="请输入新密码" autocomplete="off" class="layui-input">
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
        };
        //自定义验证规则

        function verifycontent() {
            var pPattern =/^[\S]{6,12}$/;
            if(!pPattern.test($("#old_pwd").val()))
            {
                layer.alert( '旧密码必须6到12位，且不能出现空格');
                return false;
            }
            if(!pPattern.test($("#pwd").val()))
            {
                layer.alert( '新密码必须6到12位，且不能出现空格');
                return false;
            }

            return true;

        }

    });

</script>
</body>
</html>
