<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>我的-修改密码</title>
    <meta name="apple-mobile-web-app-capable" content="no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="/public/api/css/MultiPicker.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
</head>
<body class="">
<div class="body-container">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>我的-修改密码</p></div>
        </div>
    </div>


    <form id="form" style="padding-top:40px;">
        <div class="datawrap1">
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        旧密码
                    </div>

                </div>
                <div class="databox-right">
                    <input class="text-input" type="password" name="pwd" id="pwd" value="" placeholder="旧密码" maxlength="100">
                </div>
            </div>

            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        新密码
                    </div>

                </div>
                <div class="databox-right">
                    <input class="text-input" type="password" name="newPwd" id="newPwd" value="" placeholder="新密码" maxlength="100">
                </div>
            </div>

            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        确认新密码
                    </div>

                </div>
                <div class="databox-right">
                    <input class="text-input" style="padding-left:30%" type="password" name="rePwd" id="rePwd" value="" placeholder="再次输入您的新密码" maxlength="100">
                </div>
            </div>
        </div>
        <div class="objo">
            <a  class="btn" ><button type="button" id="anq_tuic" value="立即提交" >立即提交</button></a>
        </div>
    </form>
</div>
<script>
    layui.use(['upload','laydate','table','layer', 'form','element','jquery'], function() {
        var $ = layui.jquery
            , layer = layui.layer
            , form = layui.form;
        $("#anq_tuic").click(function()
        {
            var pass   = $('#pwd').val(),
                newPwd = $('#newPwd').val(),
                rePwd  = $('#rePwd').val();
            if(pass==""||newPwd==""||rePwd=="")
            {
                layer.msg('不能为空');return false;
            }
            if(newPwd !== rePwd)
            {
                layer.msg('两次密码不一致');return false;
            }
            $.ajax({
                url: "updatePwd" ,
                data: $("form").serialize() ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code == 2)
                    {
                        layer.msg(data.msg);
                    }else{
                        layer.msg(data.msg,{time:1000},function () {
                            window.location.replace('/api/User/index');
                        });
                    }


                }
            })
            return false;
        })


    })
</script>


</body>
</html>