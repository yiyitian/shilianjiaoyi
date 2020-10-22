<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>通知公告</title>
    <link href="/public/api/css/news.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">

    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/api/js/news-tab.js"></script>
    <style>
        .ready{
            text-align:center;
            width:100%;
        }
        .ready button{
            border-radius:25px;
            border: 5px solid #e28d00;
            background: #e28d00;
            color:#fff;
        }

    </style>
</head>
<body>
<section class="aui-flexView ">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>通知公告</p></div>
        </div>
    </div>
    <section class="aui-scrollView aui-tab" data-ydui-tab>
        <div class='news-art' style="padding-top:50px;">
            <h2>{$article.title}</h2>
            <div class='sourcedata'><span>来源：山东世联</span>&nbsp;&nbsp;&nbsp;<span>发布时间：{$article.createtime}</span>&nbsp;&nbsp;&nbsp;</div>
            <hr style='border: 0.5px solid #ccc;'></hr>
            <div class='artview_detail'>
                {$article.content}
            </div>
        </div>
    </section>
</section>
{include file="layouts/footer" /}
