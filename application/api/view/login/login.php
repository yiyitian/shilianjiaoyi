<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/public/api/login_css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/public/api/login_js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>

</head>
<body>


<section class="aui-flexView">

    <section class="aui-scrollView">
        <div class="aui-code-box">

            <div class="login-logo">
                <img src='/public/api/login_images/logo.png'/>
            </div>

            <form action="">
                <p class="aui-code-line">
                    <input type="text" class="aui-code-line-input" name="phone" value="{$phone|default=''}" id="phone" autocomplete="off"  placeholder="请输入手机号">
                </p>
                <p class="aui-code-line aui-code-line-clear">
                    <i class="aui-show  operate-eye-open"></i>
                    <input type="password" class="aui-code-line-input password" name="pwd" id="pwd" placeholder="请输入密码" value="{$pwd|default=''}">
                </p>
                <div class="aui-flex-links">
                    <a href="javascript:;">
                        <label class="cell-right">
                            <input type="checkbox" value="1" name="checkbox" id="xuanzhong" checked="checked">
                            <i class="cell-checkbox-icon"></i>记住密码
                        </label>
                    </a>
                    <a href="javascript:;"></a>
                </div>

            </form>
            <div class="aui-code-btn">
                <button class="button" value="登录">登录</button>
                <!--<button class="register">注册</button>-->
            </div>
        </div>
<div style="text-align:center;padding-bottom:10px;" ><span style="color:b9b3b3;">没有账号？</span><a href="http://app.sz-senox.com/index/Login/registers?random=253562" >立即注册</a></div>
    </section>
    <div style="text-align:center;padding-bottom:10px;">登录即代表阅读并同意<a href="http://app.sz-senox.com/api/login/yinsi" style="color:red;">《服务条款》</a></div>
</section>

<script type="text/javascript">
    $('.aui-show').click(function() {
        let pass_type = $('input.password').attr('type');

        if (pass_type === 'password') {
            $('input.password').attr('type', 'text');
            $('.aui-show').removeClass('operate-eye-open').addClass('operate-eye-close');
        } else {
            $('input.password').attr('type', 'password');
            $('.aui-show').removeClass('operate-eye-close').addClass('operate-eye-open');
        }
    })

    $('.button').click(function()
    {
        var phone = $('#phone').val(),
            xuan = $("#xuanzhong").prop("checked"),
            pwd   = $('#pwd').val();
        if(xuan)
        {
            xuan = 1;
        }else{
            xuan = -1;
        }
        if((phone== '')||(pwd == ''))
        {
            layer.open({
                content: '密码或手机号不能为空'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
        }

        $.ajax({
            url: "login" ,
            data: {'phone':phone,'pwd':pwd,'xuan':xuan} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                if(data.code !==1)
                {
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2
                    });
                }else if(data.code == 1)
                {
                    location.href="/api/User/indexs"
                }
            }
        })
        return false;
    })
</script>

</body>
</html>
