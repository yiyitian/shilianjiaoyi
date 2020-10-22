<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>火爆项目</title>
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
<!--    <div class="header">-->
<!--        <div class="box">-->
<!--            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>-->
<!--            <div class="C"><p>火爆项目</p></div>-->
<!--        </div>-->
<!--    </div>-->
    <section class="aui-scrollView aui-tab" data-ydui-tab>
<!--        <div class="aui-form-search b-line">-->
<!--            <div class="tab-nav-over">-->
<!--                <ul class="tab-nav">-->
<!--                    <li class="tab-nav-item tab-active">-->
<!--                        <a href="javascript:;">-->
<!--                            <span>线上培训</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="tab-nav-item ">-->
<!--                        <a href="javascript:;">-->
<!--                            <span>课程认证</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="tab-nav-item">-->
<!--                        <a href="javascript:;">-->
<!--                            <span>操作手册</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->



        <div class='news-art'>
            <h2>{$article.title}</h2>

            <div class='sourcedata'><span>来源：山东世联</span>&nbsp;&nbsp;&nbsp;<span>发布时间：{$article.createtime}</span>&nbsp;&nbsp;&nbsp;</div>
            <hr style='border: 0.5px solid #ccc;'></hr>
            <div class='artview_detail'>
               {$article.content}
            </div>
        </div>
        <div  class="ready">

            {if condition="$re neq 1"}
                <span style="padding-right:50px;"><button id='ready'>确认已读</button></span>
            {else/}
                <span style="padding-right:50px;"><button style='background:#9c9393;border:7px solid #9c9393' >已确认</button></span>

            {/if}

            {if condition="$du neq 1"}
            <span><button  id='do'>确认完成</button></span>
            {else/}
            <span><button style='background:#9c9393;border:7px solid #9c9393' >已完成</button></span>
            {/if}
        </div>
    </section>





</section>


<script type="text/javascript" src="/public/layui/layui.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<script>

    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,$ = layui.jquery;
        $("#ready").click(function(){
            $.ajax({
                url: "addReady" ,
                data:{'gid':"{$article.id}"},
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.open({
                        content: data.msg
                        ,btn: '我知道了'
                    });
                }
            })
        })

        $("#do").click(function(){
            $.ajax({
                url: "addDu" ,
                data:{'gid':"{$article.id}"},
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.open({
                        content: data.msg
                        ,btn: '我知道了'
                    });
                }
            })
        })

    });
</script>



{include file="layouts/footer" /}
