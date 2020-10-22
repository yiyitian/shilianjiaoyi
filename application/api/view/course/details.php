<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>考核详情</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <script type="text/javascript" src="/public/api/login_js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
    <style type="text/css">
        .news_k li h1{
            width:1.1rem;
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
<body>

<section class="aui-flexView">
<!--    <div class="header">-->
<!--        <div class="box">-->
<!--            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>-->
<!--            <div class="C"><p>报名</p></div>-->
<!--        </div>-->
<!--    </div>-->
    <section class="aui-scrollView">
        <div id="mescroll" style="bottom:40px;" class="mescroll news_k">

            <ul id="newsList" class="news-list" style="width: 92%;padding-left: 4%;">

                {volist name="lists" id="vo"}
                <li>
                    <h1>
                        <img src="/public/index/images/black.jpg">
                    </h1>
                    <p><span style="display:inline-block;overflow:hidden;max-width:200px;font-size:17px;">{$vo.classname}</span>
                        <a href="Scoring?time={$vo.times}&id={$vo.lecturer}&name={$vo.name}&cid={$vo.id}">
                        <span style="float:right;display: inline-block; background: #d70c18;text-align: center; padding: 0.08rem 0;width: 1rem;border-radius: 3px;color: #fff;">
                            去打分
                        </span>
                        </a>
                    </p>
                    <h2>
                        讲师： {$vo.name} &nbsp;&nbsp;&nbsp;
                        <span style="float:right;padding-top:5px;"></span>
                    </h2>
                </li>
                {/volist}
            </ul>


            <div style="padding-bottom:50px;"><a href="/api/course/feedbacks?times={$times}"><button style="width: 80%;
    height: 30px;
    line-height: 30px;
    font-size: 16px;
    background: #d70c18;
    color: #fff;
    margin-left: 10%;
    margin-top: 10px;
    border-radius: 24px;">学习考核</button><a></div>

            <div style="padding-bottom:50px;"><a href="/api/course/Troubleshooting?times={$times}"><button style="width: 80%;
    height: 30px;
    line-height: 30px;
    font-size: 16px;
    background: #d70c18;
    color: #fff;
    margin-left: 10%;
    margin-top: 10px;
    border-radius: 24px;">考核详情</button><a></div>
        </div>
    </section>
</section>
<script src="/public/api/LCalendar/js/LCalendar.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#start_date', //标签id
        'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
        'minDate': (new Date().getFullYear()-3) + '-' + 1 + '-' + 1, //最小日期
        'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31 //最大日期
    });
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#end_date', //标签id
        'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
        'minDate': (new Date().getFullYear()-3) + '-' + 1 + '-' + 1, //最小日期
        'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31 //最大日期
    });
    $('#button').click(function()
    {
        var start_date = $('#start_date').val(),
            end_date   = $('#end_date').val();
        if((""==start_date)||(''==end_date))
        {
            layer.open({
                content: '入驻日期和退房日期不能为空'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
        }
        $.ajax({
            url: "signUp" ,
            data: $("form").serialize() ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                if(data.code !==1)
                {
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2
                    });
                }else if(data.code == 1)
                {
                    location.href="/api/User/index"
                }
            }
        })
        return false;

    })

</script>
{include file="layouts/footer" /}

