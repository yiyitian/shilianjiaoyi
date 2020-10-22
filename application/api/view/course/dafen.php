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
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">

    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/swiper.min.css" type="text/css">
    <script type="text/javascript" src="/public/index/js/swiper.min.js"></script>
    <script type="text/javascript" src="/public/index/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
</head>


<body style="height: 100%;background: #eaeaea;" xmlns="http://www.w3.org/1999/html">
<!-- 头部 -->
<style>
    #anq_tuic{color:#fff;}

</style>

<div class="hui_k"></div>
<form id="form">
    <div class="yinghka_k">
        <ul>
            <li>
                <p>讲师</p>
                <input type="text"  value="{$info.name}" readonly style="text-align:right;">
            </li>
            <input type="hidden" name="uid" value="{$info.id}"/>
            <input type="hidden" name="time" value="{$info.time}"/>

            <li>
                <p>讲师的专业知识</p>
                <input type="number" id="a" name="a"  value="{$list.a|default=''}" placeholder="满分20分"  oninput="if(value>20)value=20"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师的授课技巧</p>
                <input type="number" id="b" name="b"  value="{$list.b|default=''}" placeholder="满分10分" oninput="if(value>10)value=10"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师能及时调节课堂气氛，吸引注意力</p>
                <input type="number" id="c" name="c"  value="{$list.c|default=''}"  placeholder="满分20分" oninput="if(value>20)value=20"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师能将理论和实际联系起来，提供案例</p>
                <input type="number" id="d" name="d"  value="{$list.d|default=''}"   placeholder="满分20分" oninput="if(value>20)value=20"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师对学员问题的反应与解答</p>
                <input type="number" id="e" name="e"  value="{$list.e|default=''}"  placeholder="满分10分" oninput="if(value>10)value=10"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师对课程节奏及时间把控</p>
                <input type="number" id="f" name="f"  value="{$list.f|default=''}"  placeholder="满分10分" oninput="if(value>10)value=10"  style="text-align:right;" >
            </li>
            <li>
                <p>讲师所讲内容与教材相符</p>
                <input type="number" id="g" name="g" value="{$list.g|default=''}"  placeholder="满分10分" oninput="if(value>10)value=10"  style="text-align:right;" >
            </li>
            <input type="hidden" name="cid" value="{$info.cid}"/>
            <li>
                <p>备注</p>
                <input type="text" id="mark" name="mark" placeholder="输入备注"   value="{$list.mark|default=''}"  style="text-align:right;">
            </li>

        </ul>
    </div>
    <div style="width:100%;text-align: center;padding-top:18px;">
        <button type="button"  id="anq_tuic" class="layui-btn">马上打分</button>
    </div>

</form>
<script type="text/javascript" src="/public/layui/layui.js"></script>

<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;

        $("#anq_tuic").click(function () {
            var i = "{$dd}";
            if(i !== '2')
            {
                layer.msg('打分已完成，不可修改', {icon:0,time: 1000});
                return false;
            }
            a=$('#a').val();b=$('#b').val();c=$('#c').val();d=$('#d').val();e=$('#e').val();f=$('#f').val();g=$('#g').val();
            if(a==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(b==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(c==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(d==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(e==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(f==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }
            if(g==''){
                layer.msg('请打分！', {icon:0,time: 1000});
                return false;
            }

            var i = $("form").serialize();

            $.ajax({
                url: "Scoring",
                data: i,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {time: 1000}, function () {
                        window.history.back();
                    });
                }
            })
            return false;
        });
    });

</script>
</body>
</html>
