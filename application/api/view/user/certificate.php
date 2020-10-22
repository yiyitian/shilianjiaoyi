<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>我的证书</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="js/tab.js"></script>
    <style>
        .anniu{
            background:#d0111b
        }
    </style>
</head>
<body>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>我的证书</p></div>
        <div class="R" style="position: absolute;right: 10px;top: 0;color: #fff;line-height: 39px;" id="picker"></div>

    </div>
</div>
<div class="clear"></div>
<div class="courseBox" style="padding-top:40px;">
    <ul class="ul_3">
        {volist name="lists" id="vo"  empty="<div style='width:100%;text-align:center'><img style='width:80%' src='/public/api/images/none.png'></div>"}
            <li>
                <div ><a href="/public/imgs/{$vo.img}"><img src="/public/imgs/{$vo.img}"></a></div>
            </li>
        {/volist}

    </ul>
</div>

{include file="layouts/footer" /}
