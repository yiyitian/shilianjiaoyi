<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>山东世联交易业务运营平台</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/swipe/css/swiper.min.css"/>
    <style>
        .swiper-container {
            width: 100%;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="headerbox swiper-container">
    <div class="swiper-wrapper">
        {volist name="banner" id="vo"}
            <div class="swiper-slide"><a href="{$vo.img}"><img src="{$vo.url}" alt=""></a></div>
       {/volist}
    </div>
    <div class="swiper-pagination"></div>
</div>
<script src="/public/api/swipe/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container',{
        loop:true,
        autoplay:true,
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>
<link rel="stylesheet" href="/public/api/css/xiaoxi/iconfont.css">

<div class="notice">
    <span style='float:left;text-indent: 5px;line-height:30px;width:10%;color:#da2761'>
        <span class="iconfont icon-xiaoxi"></span>
    </span>
    <ul id="jsfoot02" class="noticTipTxt" style="width:85%">
        {volist name='article' id="vo"}
        <li>
            <a href="details?id={$vo.id}" style="text-decoration : none " target="_blank">{$vo.title|mb_substr=0,15}...
            <span class="datetime" style="float:right;font-size:12px;">{$vo.createtime}</span></a>
        </li>
        {/volist}
    </ul>
    <!-- <div class='notice-more'><a href='/api/User/massage'><i class="go-right"></i></a></div> -->
</div>

<script type="text/javascript" src="/public/api/js/scrolltext.js"></script>
<script type="text/javascript">
    if(document.getElementById("jsfoot02")){
        var scrollup = new ScrollText("jsfoot02");
        scrollup.LineHeight = 30;        //单排文字滚动的高度
        scrollup.Amount = 1;            //注意:子模块(LineHeight)一定要能整除Amount.
        scrollup.Delay = 20;           //延时
        scrollup.Start();             //文字自动滚动
        scrollup.Direction = "up";   //默认设置为文字向上滚动
    }
</script>

<div class="allbox"></div>

<div class="clear"></div>
<div class="typebox">
    <ul>
        <li><a href='/api/lecturer/index'><img src="/public/api/images/ico001.png"><p>讲师管理</p></a></li>
        <li><a href='/api/Cases/index'><img src="/public/api/images/ico002.png"><p>案场管控</p></a></li>
        <li><a href='/api/Report/Lists'><img src="/public/api/images/ico003.png"><p>周报月报</p></a></li>
        <li><a href='/api/User/pan'><img src="/public/api/images/ico004.png"><p>网盘管理</p></a></li>
    </ul>
</div>
<div class="clear"></div>
<div class="allbox"></div>
<div class="clear"></div>
<div class="courseBox">
    <div class="titbox">
        <img src="/public/api/picture/icon.png"><p>平台播报</p>	<a href='/api/user/massages'><i class="go-right"></i></a>
    </div>



    <script type="text/javascript" src="/public/api/js/jquery.1.4.2-min.js"></script>
    <!--演示内容开始-->
    <script type="text/javascript">
        //js无缝滚动代码
        function marquee(i, direction){
            var obj = document.getElementById("marquee" + i);
            var obj1 = document.getElementById("marquee" + i + "_1");
            var obj2 = document.getElementById("marquee" + i + "_2");
            if (direction == "up"){
                if (obj2.offsetTop - obj.scrollTop <= 0){
                    obj.scrollTop -= (obj1.offsetHeight + 20);
                }else{
                    var tmp = obj.scrollTop;
                    obj.scrollTop++;
                    if (obj.scrollTop == tmp){
                        obj.scrollTop = 1;
                    }
                }
            }else{
                if (obj2.offsetWidth - obj.scrollLeft <= 0){
                    obj.scrollLeft -= obj1.offsetWidth;
                }else{
                    obj.scrollLeft++;
                }
            }
        }

        function marqueeStart(i, direction){
            var obj = document.getElementById("marquee" + i);
            var obj1 = document.getElementById("marquee" + i + "_1");
            var obj2 = document.getElementById("marquee" + i + "_2");

            obj2.innerHTML = obj1.innerHTML;
            var marqueeVar = window.setInterval("marquee("+ i +", '"+ direction +"')", 20);
            obj.onmouseover = function(){
                window.clearInterval(marqueeVar);
            }
            obj.onmouseout = function(){
                marqueeVar = window.setInterval("marquee("+ i +", '"+ direction +"')", 20);
            }
        }
    </script>

    <div id="marquee1" class="marqueeleft">
        <div style="width:8000px;">
            <ul id="marquee1_1">
                {volist name="project" id="vo"}
                <li>
                    <a class="pic" href="detail?id={$vo.id}"><img  src="{$vo.avatar}"></a>
                    <div class="txt"><a href="detail?id={$vo.id}" style="font-size:12px;">{$vo.title}</a></div>
                </li>
                {/volist}

            </ul>
            <ul id="marquee1_2"></ul>
        </div>
    </div><!--marqueeleft end-->
    <script type="text/javascript">marqueeStart(1, "left");</script>


    <!-- <ul class="ul_1">
      <li>
          <a href='course.html'>
            <img src="/public/api/picture/1.jpg">
            <div class="tit">如何与销售团队沟通合作力</div>
            <!--<div class="price"><em href="">去学习</em><span>未培训</span></div>
          </a>
      </li>
      <li>
          <a href='lecturer-df.html'>
            <img src="/public/api/picture/1-1.jpg">
            <div class="tit">如何与开发商有效沟通</div>
           <!-- <div class="price"><em href="">去打分</em><span>已培训/合格</span></div> 
          </a>
      </li>
    </ul> -->
</div>

<div class="allbox"></div>
<div class="clear"></div>

<div class="courseBox">
    <div class="titbox">
        <img src="/public/api/picture/icon2.png"><p>我的课程</p></a>
    </div>
    <ul class="ul_2">


    {notempty name="fang"}
        <li>
            <a href="/api/Course/fangLianBao">
                <div class="L"><img src="/public/api/picture/zhixiao.jpg"></div>
                <div class="R">
                    <div class="tit">直销课程</div>
                    <div class="sub">房联宝直销课程</div>
                    <!-- <div class="pri">
                    <!-- <a href="">
                    去学习</a><!-- <span>已培训/合格</span></div> -->
                </div>
            </a>
        </li>
        {else/}
            <li>
            <a href="/api/course/Authentication">
                <div class="L"><img src="/public/api/picture/gangwei.jpg"></div>
                <div class="R">
                    <div class="tit">岗位认证课程</div>
                    <div class="sub">代理线课程</div>
                    <!-- <div class="pri"><!-- <a href="">去学习</a><!-- <span>未培训</span></div> -->
                </div>
            </a>
            </li>
        {/notempty}
        
        
        <li>
            <a href="/api/course/onlineClassify">
                <div class="L"><img src="/public/api/picture/zaixian.jpg"></div>
                <div class="R">
                    <div class="tit">在线公开课程</div>
                    <div class="sub">在线课程</div>
                    <!-- <div class="pri"><!-- <a href="">去学习</a><!-- <span>已培训/<font color='#999'>不合格</font></span></div> -->
                </div>
            </a>
        </li>
        <li>
            <a href="/api/course/stars">
                <div class="L"><img src="/public/api/picture/xingxing.jpg"></div>
                <div class="R">
                    <div class="tit">星星学社</div>
                    <div class="sub">了解公司最新动态</div>
                </div>
            </a>
        </li>
    </ul>
</div>
{include file="layouts/footer" /}


