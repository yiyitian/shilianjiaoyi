<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>我的</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <script src="//g.yimenyun.net/cdn/jsbridge-mini.js"></script>

</head>

<body>
<div class="myHeader">
    <div class="my_1">
        <!--引进jquery，script才有效果-->
        <script src="/public/api/js/jquery.min.js"></script>
        <script>
            $(function(){
                $("#userHead").click(function(){
                    window.location.href="setAvatar"
                });
            });

        </script>

        <div class="media" style="padding-top:0px;margin: 0 50px;">
            <img src="{$info.avatar|default='/public/imgs/touxiang.png'}" class="img-rounded" id="userHead" style="height:70px;width:70px;border-radius: 50%;border: 2px solid #ffffff;vertical-align: middle;">
        </div>
        <!--<img src="/public/api/picture/5.jpg" class="tx">-->
        <span>姓名：{$info.username}</br>工号：{$info.work_id}</br>部门：{$info.department}</br>岗位：{$info.station}</span>
    </div>
    <div class="my_2">
        <a href="/api/Course/index" class="L">我的课程</a>
        <a href="pan" class="R">我的网盘</a>
    </div>
</div>
<div class="clear"></div>
<style>
    #badge {
        width: 15px;
        height: 15px;
        line-height: 15px;
        text-align: center;
        background: #f00;
        color: white;
        font-size: 12px;
        font-weight: 700;
        border-radius: 50%;
        position: relative;
        top: 25px;
        left: 25px;
        z-index: 1000;

    }
    #badge4 {
        width: 15px;
        height: 15px;
        line-height: 15px;
        text-align: center;
        background: #f00;
        color: white;
        font-size: 12px;
        font-weight: 700;
        border-radius: 50%;
        position: relative;
        /* top: 0px; */
        left: 37px;
        z-index: 99999999;
        bottom: 90%;
        /* right: 5px; */
    }
</style>

<div class="aui-list-item">
    <a href="massage" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/icon-001.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>通知公告</p>
        </div>
    </a>
    <a href="/api/lecturer/index" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/picture/f0018.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>讲师时长</p>
        </div>
    </a>
    {eq name="is_teacher" value="1"}
    <a href="/api/Lecturer/classify" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/rl.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>我的授课</p>
        </div>
    </a>
    {/eq}
    {if condition="isset($role)" }
    <a href="/api/Report/Lists?mid={$role}&userId={$userId}" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/rl.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>周报月报</p>
        </div>
    </a>
    {/if}

    <a href="personal" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/icon-002.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>个人资料</p>
        </div>
    </a>
    <a href="Certificate" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/v.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>我的证书</p>
        </div>
    </a>
    <a href="/api/Report/workBook" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/workBook.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>工作计划书</p>
        </div>
    </a>
    <a href="updatePwd" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/icon-003.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>修改密码</p>
        </div>
    </a>

    <div class="divHeight b-line"></div>
    <a href="exitLogin" class="aui-flex b-line">
        <div class="aui-cou-img">
            <img src="/public/api/images/icon-004.png" alt="">
        </div>
        <div class="aui-flex-box">
            <p>退出登录</p>
        </div>
    </a>
</div>
{include file="layouts/footer" /}
