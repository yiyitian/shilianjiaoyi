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
        <a href="###">问卷调查</a>
    </div>

</div>
<form action="" id="login" style="padding-bottom:125px;">
    {notempty name="testquestion"}
    <div>
        <ul>
            {volist name="testquestion" id="vo" key="k"}
            <li>
                <div class="test" style="display: block;">
                    <div class="test_con">
                        <div class="item">
                            <div class="tit"><span>{$k}:{$vo.question}</span></div>
                            <div class="item_con">
                                <ul>
                                    <li>
                                        <input type="radio" name="{$vo.id}"  class="rad" value="{$vo.id},A"><span>{$vo.option_a}</span>
                                    </li>
                                    <li>
                                        <input type="radio" name="{$vo.id}"  class="rad"  value="{$vo.id},B"><span>{$vo.option_b}</span>
                                    </li>
                                    <li>
                                        <input type="radio" name="{$vo.id}"  class="rad" value="{$vo.id},C"><span>{$vo.option_c}</span>
                                    </li>
                                    <li class="bn">
                                        <input type="radio" name="{$vo.id}"  class="rad" value="{$vo.id},D"><span>{$vo.option_d}</span>
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
    {else/}
    <div class="item">
        <div class="tit"><span>您需要的课程支持</span></div>
        <div class="item_con">
            <textarea placeholder="请输入内容" class="layui-textarea" name="zhichi" ></textarea>
        </div>
    </div>
    {/notempty}
    <input type="hidden" name="times" value="{$times}">

    <div class="item">
        <div class="tit"><span>培训建议</span></div>
        <div class="item_con">
            <textarea placeholder="请输入内容" class="layui-textarea" name="proposal" ></textarea>
        </div>
    </div>
    <div class="item">
        <div class="tit"><span>培训心得（至少3点）</span></div>
        <div class="item_con">
            <textarea placeholder="请输入内容" class="layui-textarea" name="experience" ></textarea>
        </div>
    </div>
    <div class="item">
        <div class="tit"><span>在岗的工作困惑（选填）</span></div>
        <div class="item_con">
            <textarea placeholder="请输入内容" class="layui-textarea" name="puzzled"  ></textarea>
        </div>
    </div>

    <input type="hidden" name="id" value="{$id}"/>
    <div class="aui-code-btn">
        <button type="button" id="register" style="    background: #d21a24;height: 45px;line-height: 45px;border: none;color: #fff;border-radius: 40px;width: 100%;font-size: 0.3rem;">立即评测</button>
    </div>
</form>
</body>
<script>

    $('#register').click(function()
    {
        var radiolen = $("#login input[type=radio]:visible").length;
        var checkedlen = radiolen / 4;//一组3个
        if ($("input[type=radio]:checked").length < checkedlen) {
            layer.open({content: '存在未选择项',skin: 'footer'});return false;

            return false;
        }
        //$(this).attr('disabled', true);

        $.ajax({
            url: "feedbacks" ,
            data: $('#login').serializeArray()  ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                if(data.code == 8)
                {
                    layer.open({
                        content: data.msg
                        ,btn: '确定'
                        ,yes: function(index){
                            window.location.replace("/index/Classdone/index");                           },
                    });  return false;
                }
                if(data.code !== 1)
                {
                    if(data.code == 3)
                    {
                        layer.open({
                            content: data.msg
                            ,btn: '确定'
                            ,yes: function(index){
                                window.location.replace("/api/course/Details?timely=1&id="+data.url);                           },
                        });
                    }else{
                        layer.open({
                            content: data.msg
                            ,btn: '确定'
                            ,yes: function(index){
                                location.reload();
                            },
                        });
                    }

                }else{
                    layer.open({
                        content: data.msg
                        ,btn: '确定'
                        ,yes: function(index){
                            window.location.replace("/api/course/details?timely=1&id="+data.url);
                        },
                    });
                }
            }
        })
        return false;
    })

</script>







