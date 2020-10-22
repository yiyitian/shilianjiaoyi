<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>山东世联交易业务赋能平台2.0</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="shortcut icon" href="/public/newLogin/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/public/newLogin/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/newLogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/public/newLogin/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="/public/newLogin/css/util.css">
    <link rel="stylesheet" type="text/css" href="/public/newLogin/css/main.css">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

</head>

<body onload="aaa()">

<div class="limiter">
    <div class="container-login100" style="background-image: url('/public/newLogin/images/bg-01.jpg');">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-55 p-b-55">
            <form class="login100-form validate-form">
                <span class="login100-form-title p-b-49">山东世联交易业务赋能平台</span>

                <div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
                    <!--<span class="label-input100">用户名</span>-->
                    <input class="input100" type="text" name="username" id="user" placeholder="请输入手机号码" autocomplete="off">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="请输入密码">
                    <!--<span class="label-input100">密码</span>-->
                    <input class="input100" type="password" id="pwd" name="pass" placeholder="请输入密码">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" id="button" type="button">登 录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/public/newLogin/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="/public/newLogin/layer/layer.js"></script>
<script src="/public/newLogin/js/main.js"></script>
</body>
</html>
<script>
    $('#button').click(function(){
        var username = $('#user').val(),
            pwd      = $('#pwd').val();
        if('' == username)
        {
            layer.msg('用户名不能为空');return false;
        }
        if('' == pwd)
        {
            layer.msg('密码不能为空');return false;
        }
        $.ajax({
            url: "login" ,
            data: {'user_name':username,'pwd':pwd} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                layer.msg(data.msg, {icon: data.code},function(){ window.location.href=data.url;;});
            }
        })
        return false;
    })

    function aaa()
    {
        layer.msg('系统已经更新为手机号码登陆');
    }
</script>