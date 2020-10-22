<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>在线课程</title>
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

<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>在线课程</p></div>
        </div>
    </div>
    <section class="aui-scrollView">
        <div class="aui-tab" data-ydui-tab>
            <div class="tab-panel">
                <div class="tab-panel-item tab-active">

                    <div class="divHeight"></div>
                    <div class="aui-slide-body" style="padding-top:40px;">
                        {volist name="list" id="vo"   empty="<div style='width:100%;text-align:center'><img style='width:80%' src='/public/api/images/none.png'></div>"}
                        <div  class="aui-slide-body-item">
                            <h2>{$vo.class_name}</h2>
                            <p>{$vo.is_outline}</p>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    {eq name="$vo.study" value="1"}
                                    <a href="outlineDetails?id={$vo.id}" style="background:#7d7475;">已学习</a>
                                    {else/}
                                    <a href="outlineDetails?id={$vo.id}"  style="background:#d0111b">去学习</a>
                                    {/eq}
                                </div>
                                <div class="aui-slide-info">
                                            <span>
                                                </i>{$vo.startdate}
                                            </span>
                                </div>
                            </div>
                        </div>
                        {/volist}
                        <div class="divHeight"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</section>

{include file="layouts/footer" /}
