<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>培训课程</title>
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
        <div class="C"><p>培训课程</p></div>
        <div class="R" style="position: absolute;right: 10px;top: 0;color: #fff;line-height: 39px;" id="picker"><p>扫一扫</p></div>

    </div>
</div>
<div class="clear"></div>
<div class="courseBox" style="padding-top:40px;">
    <ul class="ul_3">
        {notempty name="fang"}
            <li>
                <a href='fangLianBao'>
                    <div class="L"><img src="/public/api/picture/zhixiao.jpg"></div>
                    <div class="R">
                        <div class="tit" style="margin-bottom:15px;">直销课程</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            去学习</div>
                    </div>
                </a>
            </li>
        {else/}
            <li>
                <a href='Authentication'>
                    <div class="L"><img src="/public/api/picture/gangwei.jpg"></div>
                    <div class="R">
                        <div class="tit" style="margin-bottom:15px;">岗位认证课程</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            去学习</div>
                    </div>
                </a>
            </li>
        {/notempty}

        <li>
            <a href='/api/course/onlineClassify'>
                <div class="L"><img src="/public/api/picture/zaixian.jpg"></div>
                <div class="R">
                    <div class="tit" style="margin-bottom:15px;">在线课程(未学习课程{$num})</div>
                    <div class="sub">山东世联</div>
                    <div class="anniu">
                        去学习</div>
                </div>
            </a>
        </li>
        <li>
            <a href='stars'>
                <div class="L"><img src="/public/api/picture/xingxing.jpg"></div>
                <div class="R">
                    <div class="tit" style="margin-bottom:15px;">星星学社</div>
                    <div class="sub">山东世联</div>
                    <div class="anniu">
                        去学习</div>
                </div>
            </a>
        </li>
    </ul>
</div>
<script>
    $('#picker').click(function(){
        location.href="/api/user/scan";
    })
</script>
{include file="layouts/footer" /}
