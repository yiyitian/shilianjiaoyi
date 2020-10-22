<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>讲师时长排名</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
</head>
<style type="text/css">
    h1 {
        font-size: 30px;
    }

    .form-control[readonly] {
        background: none;
    }

    @media(max-width: 414px) {
        .form-control {
            font-size: 12px;
        }
    }

    @media(max-width: 360px) {
        .form-control {
            font-size: 10px;
            padding: 0 5px;
        }
    }

    @media(max-width: 320px) {
        .col-xs-6 {
            padding: 0 5px;
        }
    }
</style>
<body>

<div class="clear"></div>
<script src="/public/api/LCalendar/js/LCalendar.js" type="text/javascript" charset="utf-8"></script>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>讲师时长排名</p></div>
    </div>
</div>

<div class="videoBox" style="padding-top: 50px;">
    <div class="row">
        <div class="form-group clearfix">
            <div class="col-xs-6" style="    text-align: center;">
                <input readonly class="form-control"  style="border: 1px solid #ccc;border-radius: 20px;height: 30px;text-align: center;width:30%"  type="text" id="date-group1-1" {if condition="isset($times)"} value="{$times}"{/if} placeholder="开始时间">
                <input readonly class="form-control1"  style=" border: 1px solid #ccc;border-radius: 20px;height: 30px;text-align: center;width:30%"  type="text" id="date-group1-2" {if condition="isset($times)"} value="{$times}"{/if} placeholder="结束时间">
                <button type="button" id="button" style="background: #d70c18;padding: 5px 18px;border-radius: 23px;border-color: #d70c18;color: #fff;">查询</button>
            </div>
        </div>
    </div>
    <ul>
        {volist name="list" id="vo" key="k"}
        <li>
            <div class="L">
                <div class="date1"><img src="/public/api/picture/date.png"><p>授课时长</p></div>
                <div class="date2"><span style="color:#d0111b">{$vo.classTime}</span><br><span style="font-size:13px;">小时</span></div>
            </div>
            <div class="C"><img src="/public/api/picture/line.jpg"></div>
            <div class="R">
                <div class='dj'><img src='/public/api/images/dj{$k}.png'/></div>
                <div class="tit">培训分类：{$vo.type}   </div>
                <div class="tit">讲师级别：普通</div>
                <div class="sub">
                    <img src="{$vo.images}">
                    <p>讲师：{$vo.username}</p>
                </div>
            </div>
        </li>
        {/volist}
    </ul>
</div>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script>
    window.onload = function() {
        new Jdate({
            el: '#date-group1-1',
            format: 'YYYY-MM',
            beginYear: 2000,
            endYear: 2100
        })
        new Jdate({
            el: '#date-group1-2',
            format: 'YYYY-MM',
            beginYear: 2000,
            endYear: 2100
        })
    }

    $('#button').click(function()
    {
        window.location.href="index?time="+$('#date-group1-1').val()+"&endtime="+$('#date-group1-2').val();
    })
</script>
<script type="text/javascript" src="/public/api/js/jdate.min.js"></script>

{include file="layouts/footer" /}