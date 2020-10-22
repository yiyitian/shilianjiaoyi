<!doctype html>
<html>
<head>
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <meta content="山东世联交易业务运营平台" http-equiv="keywords">
    <meta name="description" content="山东世联交易业务运营平台">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">
    <title>山东世联交易业务运营平台</title>
    <link rel="stylesheet" href="/public/index/css/index.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/swiper.min.css" type="text/css">
    <script type="text/javascript" src="/public/index/js/swiper.min.js"></script>
    <script type="text/javascript" src="/public/index/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
</head>
<body style="background:#eee">
<script type="text/javascript" src="/public/layui/layui.js"></script>
<script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<style>
.test .test_con {
    background-color: #f6f6f6;
    padding: 0px 0px 10px 0px;
}
.item {
    background-color: #fff;
    padding: 10px 10px;
    text-align: left;
}
.item .tit {
    font-size: 16px;
    color: #363636;
    margin: 10px 0px;
}
.item_con {
    background-color: #fff;
    padding: 10px 0px;
}
.item_con li {
    font-size: 14px;
    border-bottom: 1px solid #dddddd;
    padding: 10px 10px 10px 10px;
    line-height: 22px;
}
.item_con .rad {
    height: 20px;
    vertical-align: middle;
}
.item_con li span {
    font-size: 14px;
    margin: 0px 15px 0px 10px;
    font-weight: 700;
}
input {
    border: 0;
    // 去除未选中状态边框outline: none;
    // 去除选中状态边框background-color: rgba(0, 0, 0, 0);
    // 透明背景: ;
}
.aui-code-box button {
    background: #ff6849;
    height: 45px;
    line-height: 45px;
    border: none;
    color: #fff;
    border-radius: 4px;
    width: 100%;
    font-size: 0.98rem;
}
</style>
<!-- 头部 -->
<div class="toub_beij">
    <div class="logo"><a href="###"><img src="/public/index/images/logo_sy.png"></a></div>
<!--    <div class="sy_zaix"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2239329788&site=qq&menu=yes">在线咨询</a></div>-->
</div>

<div class="luj">
    <div class="luj_nk">
        <em></em>
        <a href="###">问卷详情</a>
    </div>

</div>
<form action="" id="login" style="padding-bottom:125px;">
                <div>
                    
                    <ul>
                        {volist name="testquestion" id="vo" key="k"}
                        <li {if condition="$haha[$vo.id] neq $vo.true_option"} style="color:red" {/if}>
                            <div class="test" style="display: block;">
                                <div class="test_con">
                                    <div class="item">
                                        <div class="tit"><span>{$k}:{$vo.question}</span></div>
                                        <div class="item_con">
                                            <ul>
                                                <li>
                                                    <input type="radio" name="{$vo.id}"  class="rad" disabled {if condition="$haha[$vo.id] eq 'A'"} checked="checked" {/if} value="{$vo.id},A"><span {if condition="$vo.true_option eq 'A'"} style="color:#49a250" {/if}>{$vo.option_a}</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="{$vo.id}" disabled  {if condition="$haha[$vo.id] eq 'B'"} checked="checked" {/if}  class="rad"  value="{$vo.id},B"><span {if condition="$vo.true_option eq 'B'"} style="color:#49a250" {/if}>{$vo.option_b}</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="{$vo.id}" disabled {if condition="$haha[$vo.id] eq 'C'"} checked="checked" {/if}   class="rad" value="{$vo.id},C"><span {if condition="$vo.true_option eq 'C'"} style="color:#49a250" {/if}>{$vo.option_c}</span>
                                                </li>
                                                <li class="bn">
                                                    <input type="radio" name="{$vo.id}" disabled {if condition="$haha[$vo.id] eq 'D'"} checked="checked" {/if}   class="rad" value="{$vo.id},D"><span {if condition="$vo.true_option eq 'D'"} style="color:#49a250" {/if}>{$vo.option_d}</span>
                                                </li>
                                            </ul>
                                           
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>
                        {/volist}
                    </ul>
                   
                </div>
              


            </form>
</body>






