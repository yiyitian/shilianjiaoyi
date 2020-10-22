<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>项目列表</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/public/api/css/course.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/api/js/course-tab.js"></script>

</head>
<body>
    <section class="aui-scrollView">

        <div class="header">
            <div class="box">
                <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
                <div class="C"><p>周报月报</p></div>
            </div>
        </div>
        <div class="aui-tab" data-ydui-tab style="padding-top:50px;">
            <ul class="tab-nav b-line">
            </ul>
            <div class="tab-panel">
                {volist name="lists" id="vo" empty="<div style='width:100%;text-align:center'><img style='width:80%' src='/public/api/images/none.png'></div>"}
                    <div class="tab-panel-item tab-active">
                        <div class="aui-slide-body">
                            <div  class="aui-slide-body-item" style="margin:8px 0">
                                <h2>{$vo.name}</h2>
                                <p>{$vo.department}</p>
                                <div class="aui-flex" style="width: 140px;
 position: absolute;
 right: 10px;
 top: 0px;">
                                    <div class="aui-flex-box">
                                        <a href="Weekly?pid={$vo.id}" style="background:#d0111b">周报列表</a>
                                        <a href="Monthly?pid={$vo.id}"  style="background:#d0111b">月报列表</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divHeight"></div>
                    </div>
                {/volist}
            </div>
        </div>

    </section>

{include file="layouts/footer" /}
