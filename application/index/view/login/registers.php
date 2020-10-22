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
    <script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
    <link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">
    <style>
        .zhuc_kluang select{width:70%;}
        .zhuc_kluang input{width:66%;}
    </style>
</head>
<body style="height: 100%;" >
<!-- 头部 -->
<div class="toub_beij">
    <div class="fanhui_jt"><a href="http://app.sz-senox.com/api/login/login"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_hei.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">注册</div>
    <div class="sy_zaix"><a href="http://app.sz-senox.com/api/login/login">有账号<span>登录</span></a></div>
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
<div class="zhuc_img">
    <img src="/public/index/images/zhuc_img.jpg">
</div>

<div class="dengl_nr_k">


    <form id="formid" action="register" method="post">


        <div class="zhuc_kluang">
            <p><em>*</em>员工姓名：</p>
            <input type="text" name="username" id='username' required="required" placeholder="输入真实姓名,不可更改" autocomplete="off">
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>设置密码：</p>
            <input type="password" name="pass" id="pass" required="required" placeholder="请设置您的登录密码" autocomplete="off">
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>手机号码：</p>
            <input type="text" name="phone" id="phone" required="required" placeholder="请设置您的手机号码" autocomplete="off">
        </div>
        <div class="zhuzhong_tx" id="xuanz" >
            <input id="button" type="button" class="dengl_anniu dengl_anniu_zcy" value="注 册">
        </div>
    </form>



</div>

</body>
</html>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['upload','laydate','table','layer', 'form','element','jquery'], function() {
        var $ = layui.jquery
            , upload = layui.upload
            , table = layui.table
            , layer = layui.layer
            , form = layui.form
            , laydate = layui.laydate;
        $('#button').click(function () {
                var username = $('#username').val()
                    , pass = $('#pass').val()
                    , phone = $('#phone').val();
                // 验证用户名是否含有特殊字符
                function check_other_char(str) {
                    var arr = ["&", "\\", "/", "*", ">", "<", "@", "!", " "];
                    for (var i = 0; i < arr.length; i++) {
                        for (var j = 0; j < str.length; j++) {
                            if (arr[i] == str.charAt(j)) {
                                return true;
                            }
                        }
                    }
                    return false;
                }
            if (check_other_char(username)) {
                $('#username').focus();
                alert('用户名不能包含特殊字符或空格');
                return false;
            }
            var regs = /[A-Za-z]+/;
            if (regs.test(username)) {
                alert('用户名不能包含字母');
            }
            var date = $("#formid").serialize();
            if (username == '' || username.length < 2) {
                $('#username').focus();
                alert('请填写真实姓名,且不少2个字');
                return false;
            }
            if (username == 'admin') {
                $('#username').focus();
                alert('请填写真是姓名');
                return false;
            }
            if ('' == pass || pass.length < 6) {
                $('#pass').focus();
                alert('密码不能为空,且长度不小于6位');
                return false;
            }
            if ('' == phone || !/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/.test(phone)) {
                $('#phone').focus();
                alert('请输入正确手机号');
                return false;
            }
            $.ajax({
                url: "registers",
                data: date,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    alert(data.msg);
                    if (data.code == 1) {
                        location.href = "/api/User/indexs";
                    }
                }
            });
        })

    })
</script>