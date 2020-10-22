<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>火爆项目列表</title>
    <link href="/public/api/css/news.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">

    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/api/js/news-tab.js"></script>
</head>
<body>
<section class="aui-flexView ">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>平台播报</p></div>
        </div>
    </div>
    <section class="aui-scrollView aui-tab" data-ydui-tab style="padding-top:40px;">
        <div class="aui-form-search b-line">
            <div class="tab-nav-over">
                <ul class="tab-nav">
                    {volist name="cate" id="vo" key="k"}
                    {if condition="$k eq 1"}
                    <li class="tab-nav-item tab-active">
                        {else /}
                    <li class="tab-nav-item ">

                        {/if}
                            <a href="javascript:;">
                                <span>{$vo.posts}</span>
                            </a>
                        </li>
                    {/volist}

                </ul>
            </div>
        </div>

        <div class="tab-panel">
            {volist name="list" id="vo"}
            <div class="tab-panel-item tab-active">
                {volist name="vo" id="dd"}
                <a href="/api/index/detail?id={$dd.id}" class="aui-news-item b-line" style="width: 100%;float:left;line-height: 30px;display: block;padding: 5px 10px">
                    <h2 style="margin-bottom: 0;"><p style="width: 80%;float:left;color: #333;font-size: 14px;line-height: 30px;">{$dd.title}</p><span style="line-height:30px;font-size: 12px;color: #999;text-align: right;">{$dd.createtime}</span></h2>
                    <!--<p>{$dd.mark}</p>-->
                    <!--<div class="aui-flex">
                        <div class="aui-flex-user">
                            <img src="/public/api/picture/user-001.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <p>山东世联 {$dd.createtime}</p>
                        </div>
                    </div>-->
                </a>
                {/volist}
            </div>
            {/volist}

        </div>
    </section>

</section>




{include file="layouts/footer" /}



