<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>培训课程-列表</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/public/api/css/course.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/api/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/api/js/course-tab.js"></script>

</head>
<body>

<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>线上课程</p></div>
        </div>
    </div>
    <section class="aui-scrollView">

        <div class="aui-tab" data-ydui-tab>
            <div class="tab-panel">
                <div class="tab-panel-item tab-active">
                    <div class="divHeight"></div>
                    <div class="aui-slide-body" style="padding-top:40px;">
                        {volist name="compulsory" id="vo"   empty="<div style='width:100%;text-align:center'>暂无数据</div>"}
                        <div  class="aui-slide-body-item">
                            <h2>{$vo.title}</h2>
                            <p>必修课程</p>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    {if condition="isset($vo.isLearn)&&$vo.isLearn eq 1"}
                                    <a href="/api/user/scan">去学习</a>
                                    {/if}
                                    {if condition="isset($vo.isHave)&&$vo.isHave eq 1"}
                                    <a href="signUp?times={$vo.times}">报名</a>
                                    {/if}
                                </div>
                                <div class="aui-slide-info">
                                    {if condition="$vo.is_train eq 1"}
                                            <span>
                                                <i class="icon icon-eye"></i>已培训
                                            </span>
                                    {if condition="$vo.is_qualified eq 1"}
                                                <span>
                                                     <i class="icon icon-icon-zan"></i>合格
                                                </span>
                                    {else/}
                                                 <span>
                                                     <i class="icon icon-bhg"></i>不合格
                                                 </span>
                                    {/if}
                                    {else/}
                                            <span>
                                                <i class="icon icon-eye1"></i>未培训
                                            </span>
                                    {/if}
                                </div>
                            </div>
                        </div>
                        <div class="divHeight"></div>
                        {/volist}

                        {volist name="elective" id="vo"}
                        <div  class="aui-slide-body-item">
                            <h2>{$vo.title}</h2>
                            <p>选修课程</p>
                            <div class="aui-flex">
                                <div class="aui-flex-box">

                                    {if condition="isset($vo.isHave)"}
                                    <a href="signUp?times={$vo.times}"  style="background:#d0111b">报名</a>
                                    {/if}
                                </div>
                                <div class="aui-slide-info">
                                    {if condition="$vo.is_train eq 1"}
                                            <span>
                                                <i class="icon icon-eye"></i>已培训
                                            </span>
                                    {if condition="$vo.is_qualified eq 1"}
                                                <span>
                                                     <i class="icon icon-icon-zan"></i>合格
                                                </span>
                                    {else/}
                                                 <span>
                                                     <i class="icon icon-bhg"></i>不合格
                                                 </span>
                                    {/if}
                                    {else/}
                                            <span>
                                                <i class="icon icon-eye1"></i>未培训
                                            </span>
                                    {/if}
                                </div>
                            </div>
                        </div>
                        <div class="divHeight"></div>
                        {/volist}

                    </div>
                </div>
            </div>
        </div>

    </section>
</section>

{include file="layouts/footer" /}
