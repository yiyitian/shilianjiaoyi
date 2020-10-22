<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>ɨһɨ</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <script src="//g.yimenyun.net/cdn/jsbridge-mini.js"></script>
    <script src="http://qiniu.22xcx.com/jssdk/sdk.js"></script>
    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>


</head>
<script>

    $(function() {
        var ua = navigator.userAgent;
        if(ua.indexOf("bsl") >= 0 )
        {
            BSL.Qcode('1','callbackMethod')
        } else {
            jsBridge.scan();
        }

    });
</script>
{include file="layouts/footer" /}
