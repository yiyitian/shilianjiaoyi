{include file="public/header" /}


<body style="height: 100%;background: #eaeaea;" xmlns="http://www.w3.org/1999/html">
<!-- 头部 -->
<style>
    #anq_tuic{color:#fff;}

</style>
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="personalCenter"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_bai.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">修改密码</div>
    <div class="sy_zaix"><a href="javascript:;"><span id="anq_tuic">保存</span></a></div>
</div>
<div class="hui_k"></div>
<form id="form">
<div class="yinghka_k">
    <ul>
        <li>
            <p>旧密码</p>
            <input type="text" id="pass" name="pass" placeholder="输入旧密码"  style="text-align:right;">
        </li>
        <li>
            <p>新密码</p>
            <input type="text" id="new_pass" name="new_pass" placeholder="输入新密码"  style="text-align:right;">
        </li>
        <li>
            <p>确认密码</p>
            <input type="text" id="news_pass" name="news_pass" placeholder="再次输入你的新密码" style="text-align:right;" >
        </li>
    </ul>
</div>
</form>
<script type="text/javascript" src="/public/layui/layui.js"></script>

<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;

        $("#anq_tuic").click(function () {
            pass=$('#pass').val();
            new_pass=$('#new_pass').val();
            news_pass=$('#news_pass').val();
            if(pass==''){
                layer.msg('请输入旧密码！', {icon:0,time: 1000});
                return false;
            }
            if(new_pass.length<6){
                layer.msg('请输入至少6位的密码！', {icon:0,time: 1000});
                return false;
            }
            if(new_pass!=news_pass){
                layer.msg('新密码和确认密码不一致！', {icon:0,time: 1000});
                return false;
            }
            console.log($('#news_pass').val().length);
            //return false;
            var i = $("form").serialize();
            console.log(i);//return false;
            $.ajax({
                url: "checkPass",
                data: i,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {time: 1000}, function () {
                        window.location.replace('/index/User/personalCenter');
                    });
                }
            })
            return false;
        });
    });

</script>
</body>
</html>
