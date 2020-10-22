<!doctype html>
<html>
<head>
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <meta content="山东世联交易业务运营平台" http-equiv="keywords">
    <meta name="description" content="山东世联交易业务运营平台">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">
    <title>山东世联交易业务运营平台</title>
    <link rel="stylesheet" href="/public/index/css/index.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/swiper.min.css" type="text/css">
    <script type="text/javascript" src="/public/index/js/swiper.min.js"></script>
    <script type="text/javascript" src="/public/index/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
</head>

<body style="height: 100%;">
<!-- 头部 -->
<div class="toub_beij">
    <div class="fanhui_jt" style="color:#fff;"><a href="#" style="color:#fff;"><i class="fanh_jiant" style="display:none;"><img src="/public/index/images/fanh_jiant_hei.png"></i><span>返回GO</span></a></div>
    <div class="mingc_tb">登录</div>
    <div class="sy_zaix"><a href="register">去<span>注册</span></a></div>
</div>
<script type="text/javascript">
    //滑动头部透明（针对首页头部用）
    window.onscroll=function(){

        var autoheight=document.body.scrollTop||document.documentElement.scrollTop;
        if(autoheight>20){
            $(".toub_beij").css("position" ,"fixed")
        }else{
            $(".toub_beij").css("position" ,"relative")
        }
    }
</script>
<!-- 内容 -->

<div class="dengl_nr_k">
    <div class="dengl_logo"><img src="/public/index/images/logo_dengl.png"></div>
    <div class="dengl_biaod_k">
        <div class="kuang_a">
            <input type="text" name="username" id="username" placeholder="请输入用户名">
        </div>
        <div class="kuang_a input_img2">
            <input type="password" name="pass" id="pass" placeholder="输入密码">
        </div>
        <div class="zhuzhong_tx" id="xuanz">
            <button id="button" class="dengl_anniu ">登录</button>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">
    $('#button').click(function()
    {
        var username = $('#username').val()
            ,pass = $('#pass').val();

        if((''!==username)&&(''!==pass))
        {
            $.ajax({
                url: "login" ,
                data: {'username':username,'pass':pass} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code==1)
                    {
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 3 //2秒后自动关闭
                        });
						if(data.url!=undefined){
							location.href=data.url;
						}else{
							location.href="/index/User/personalCenter";
						}
                        
                    }else{
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 3 //2秒后自动关闭
                        });
                    }

                }
            })
            return false;
        }


    })
</script>