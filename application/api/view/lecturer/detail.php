<!doctype html>
<html>
<head>
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <meta content="山东世联交易业务运营平台" http-equiv="keywords">
    <meta name="description" content="山东世联交易业务运营平台">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">
    <title>讲师打分</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
</head>
<style>
    .fen{
        text-align:center;
        color:red;
    }
</style>
<body style="height: 100%;background: #eaeaea;" xmlns="http://www.w3.org/1999/html">
<!-- 头部 -->
<style>
    #anq_tuic{color:#fff;}

</style>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>讲师打分</p></div>
    </div>
</div>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>{$article.title}</p></div>
    </div>
</div>
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="#" onClick="javascript :history.back(-1);"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_bai.png"></i></a></div>
    <div class="mingc_tb">学员打分</div>
    <div class="sy_zaix"></div>
</div>
<div class="hui_k"></div>
<div class="lecture-art">
    <style>
        .fen{
            text-align:center;
            color:red;
        }
    </style>
    <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" width='71%' style='font-weight:bold;'>打分名称</td>
            <td  style="text-align:center">分数</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" width='71%' style='font-weight:bold;'>讲师的专业知识</td>
            <td  class="fen">{$list.a|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师的授课技巧</td>
            <td  class="fen">{$list.b|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师能及时调节课堂气氛，吸引注意力</td>
            <td  class="fen">{$list.c|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师能将理论和实际联系起来，提供案例</td>
            <td  class="fen">{$list.d|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师对学员问题的反应与解答</td>
            <td  class="fen">{$list.e|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师对课程节奏及时间把控</td>
            <td  class="fen">{$list.f|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>讲师所讲内容与教材相符</td>
            <td  class="fen">{$list.g|default=''}</td>
        </tr>
        <tr style="background-color: rgb(245, 245, 245);">
            <td align="left" valign="middle" style='font-weight:bold;'>备注</td>
            <td  >{$list.mark|default=''}</td>
        </tr>
    </table>
</div>

</body>
</html>
