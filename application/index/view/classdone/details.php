{include file="public/header" /}
<link rel="stylesheet" href="/public/index/mescroll-master/dist/mescroll.min.css">
<script src="/public/index/mescroll-master/dist/mescroll.min.js" type="text/javascript" charset="utf-8"></script>
<!--mescroll本身不依赖jq,这里为了模拟发送ajax请求-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .news_k li h1{
            width:1.1rem;
        }
        * {
            margin: 0;
            padding: 0;
            -webkit-touch-callout:none;
            -webkit-user-select:none;
            -webkit-tap-highlight-color:transparent;
        }
        body{background-color: white}
        ul{list-style-type: none}
        a {text-decoration: none;color: #18B4FE;}

        /*模拟的标题*/
        .header{
            z-index: 9990;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 44px;
            line-height: 44px;
            text-align: center;
            border-bottom: 1px solid #eee;
            background-color: white;
        }
        .header .btn-left{
            position: absolute;
            top: 0;
            left: 0;
            padding:12px;
            line-height: 22px;
        }
        .header .btn-right{
            position: absolute;
            top: 0;
            right: 0;
            padding: 0 12px;
        }
        /*说明*/
        .mescroll .notice{
            font-size: 14px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            text-align: center;
            color:#555;
        }
        /*列表*/
        .mescroll{
            position: fixed;
            top: 90px;
            bottom: 0;
            height: auto;
        }
        /*展示上拉加载的数据列表*/
        .news-list li{
            padding: 16px;
            border-bottom: 1px solid #eee;
        }
        .news-list .new-content{
            font-size: 14px;
            margin-top: 6px;
            margin-left: 10px;
            color: #666;
        }
    </style>
</head>
<!-- 头部 -->
<div class="toub_beij">
    <div class="logo"><a href="###"><img src="/public/index/images/logo_sy.png"></a></div>
<!--    <div class="sy_zaix"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2239329788&site=qq&menu=yes">在线咨询</a></div>-->
</div>

<div class="luj">
    <div class="luj_nk">
        <em></em>
        <a href="###">讲师课程列表</a>
    </div>
</div>

<!--滑动区域-->
<div id="mescroll" style="bottom:40px;" class="mescroll news_k">

    <ul id="newsList" class="news-list">
       
        {volist name="timely" id="vo"}
            <li>
                <h1>
                    <img src="/public/index/images/black.jpg">
                </h1>
                <p><span style="display:inline-block;overflow:hidden;max-width:100px">{$vo.classname_name}</span>
                    <a href="Detail?timely=1&id={$vo.id}">
                        <span style="float:right;display: inline-block; background: #e28d00;text-align: center; padding: 0.08rem 0;width: 1rem;border-radius: 3px;color: #fff;">
                            去学习
                        </span>
                    </a>
                </p>
                <h2>
                    {$vo.username} &nbsp;&nbsp;&nbsp;
                    <span style="float:right;padding-top:5px;"></span>
                </h2>
            </li>
        {/volist}
    </ul>
</div>
</body>


{include file="public/footer" /}

