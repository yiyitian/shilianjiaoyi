<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$info.class_name}</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/public/api/css/course.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <style>
        .xue {
            display:none;
        }
    </style>
</head>
<body>

<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>{$info.class_name}</p></div>
        </div>
    </div>
    <section class="aui-scrollView">
        <div class='course-art'>
            <h2 style="font-size:18xp;">{$info.class_name}</h2>
            <div class='sourcedata' style="padding-top: 20px;"><span>来源：山东世联</span>&nbsp;&nbsp;&nbsp;<span>发布时间：{$info['startdate']}</span>&nbsp;&nbsp;&nbsp;</div>
            <div style="padding-top: 20px;">
                <video width="100%" height="180"  controls controlsList="nodownload">
                    　　<source src="{$video}" type="video/mp4" poster="img/tony.jpg">
                </video>
            </div>
            <div style="padding-top:20px;">
                {$info.remark}
            </div>
        </div>
        <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
    </section>
</section>
{include file="layouts/footer" /}



