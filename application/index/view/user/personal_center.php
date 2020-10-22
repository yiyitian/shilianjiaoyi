{include file="public/header" /}

<link href="/public/index/css/style.css" rel="stylesheet">
<style>
    .lzz{position:relative;}
    #art {
        display: inline-block;
        padding: 2px;
        font-size: 0.18rem;
        background: #ff0000;
        border-radius: 0.1rem;
        position: absolute;
        top: -0.13rem;
        right: -0.25rem;
        color: #fff;
    }
    </style>
<body style="height: 100%;">
<!-- 头部 -->
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="###"><i class="fanh_jiant"><!-- <img src="/public/index/images/fanh_jiant_hei.png"> --></i><span style="color:#e28d00;">帮助</span></a></div>
    <div class="mingc_tb">欢迎进入个人主页</div>
    <div class="sy_zaix"><a href="Message"><div class="xiaoxi_tub_img"><img src="/public/index/images/Shape_1.png"><i>{$num}</i></div></a></div>
</div>

<div class="vipcenter">
    <div class="vipheader">
        <a href="#">
            <div class="touxiang"><img src="{$info.avatar|default='/public/index/images/toux_mor.jpg'}" alt=""></div>
            <div class="name">{$info.username}</div>
            <div class="gztt" style="">{if condition="$info.is_teacher eq 1"}
                讲师
                {elseif condition="$_SESSION['think']['project'] eq '项目负责人'" }
                项目负责人
                {/if}</div>
        </a>
    </div>
    <ul class="vipul" style="padding-bottom:120px;">
        <li style="display:;">
            <a href="/index/Announcement/">
                <div class="icc"><i class="iconfont icon-xitongmingpian"></i></div>
                <div class="lzz">公告信息<i id="art">{$article_num}</i></div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>
        <li>
            <a href="setUser">
                <div class="icc"><i class="iconfont icon-xitongmingpian"></i></div>
                <div class="lzz">个人资料</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>
        <li style="">
            <a href="checkPass">
                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>
                <div class="lzz">修改密码</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>

        <li style="">
            <a href="/index/Classdone/index">
                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>
                <div class="lzz">已学内容</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>
       <!--  <li style="">
            <a href="should">
                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>
                <div class="lzz">应学内容</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li> -->
        <li style="">
            <a href="/index/Online/index">
                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>
                <div class="lzz">课程列表</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>

<!--          <li style="">-->
<!--            <a href="/index/login/update">-->
<!--                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>-->
<!--                <div class="lzz">修改已学习课程</div>-->
<!--                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>-->
<!--            </a>-->
<!--        </li>-->
        <li style="border: none;">
            <a href="/index/login/login_out">
                <div class="icc"><i class="iconfont icon-huodongfj"></i></div>
                <div class="lzz">退出登录</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>
        <li style="display: none;">
            <a href="checkPosts">
                <div class="icc"><i class="iconfont icon-liebiao"></i></div>
                <div class="lzz">岗位信息</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>
        <li style="display: none;">
            <a href="checkProject">
                <div class="icc"><i class="iconfont icon-yonghux"></i></div>
                <div class="lzz">项目信息</div>
                <div class="rizi lvzi"><img src="/public/index/images/jiantou.png" alt=""></div>
            </a>
        </li>

    </ul>
</div>

{include file="public/footer" /}