<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>绩效考核</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="js/tab.js"></script>
</head>
<body>
<div class="clear"></div>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>讲课列表</p></div>
    </div>
</div>
<div class="courseBox" style="padding-top:40px;">
    <ul class="ul_3">
        {eq name="role" value="21"}
            <li>
                <a href='achievement?cid=1'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/wenyuan.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">文员考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
        {/eq}
        {eq name="role" value="19"}
            <li>
                <a href='achievement?cid=2'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/guwen.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">置业顾问考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
        {/eq}
        {eq name="role" value="14"}
            <li>
                <a href='achievement?cid=3'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/cehua.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">策划考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
        {/eq}
        {eq name="role" value="36"}
            <li>
                <a href='achievement?cid=1'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/wenyuan.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">文员考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
            <li>
                <a href='achievement?cid=2'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/guwen.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">置业顾问考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
            <li>
                <a href='achievement?cid=3'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/cehua.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">策划考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
            <li>
                <a href='achievement?cid=4'>
                    <div class="L" style="width:60px;"><img src="/public/api/images/jingli.png" style="height:60px;"></div>
                    <div class="R">
                        <div class="tit">项目经理考核</div>
                        <div class="sub">山东世联</div>
                        <div class="anniu">
                            查看</div>
                    </div>
                </a>
            </li>
        {/eq}
    </ul>
</div>
{include file="layouts/footer" /}
