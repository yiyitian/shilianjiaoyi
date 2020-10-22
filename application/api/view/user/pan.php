<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>我的网盘</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
</head>

<body>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>我的网盘</p></div>
    </div>
</div>
<div class="clear"></div>
<div class="courseBox" style="padding-top:40px;">
    <ul class="ul_4">
        {volist name="list" id="vo" empty="<div style='width:100%;text-align:center'><img style='width:80%' src='/public/api/images/none.png'></div>"}
            <li>
                <a href='lists?id={$vo.id}'>
                    <div class="R">
                        <div class="tit">{$vo.files}</div>
                        <div class="sub">{$vo.content}</div>
                    </div>
                </a>
            </li>
       {/volist}

    </ul>
    {eq name="info" value="40"}
        <div class="C" style="text-align:center;"><p><a href="add"><img src="/public/api/images/add.jpg"/ style="width:12%"></a></p></div>
    {/eq}
</div>
{include file="layouts/footer" /}
