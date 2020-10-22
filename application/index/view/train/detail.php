{include file="public/header" /}
<body style="background:#eee">
<script type="text/javascript" src="/public/layui/layui.js"></script>
<script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<style>

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
<form class="layui-form" action="">
<input type="hidden" name="qid" value="{$qid}"/>
    {volist name="infoList" id="vo"}
        <div class="layui-form-item" style="background:#fff;">
            <div style="width:90%;margin-left:5%;font-size:18px;padding:10px 1px">{$i}.{$vo.question}</div>
            <div class="layui-input-block" style="margin-left:0;width:90%;margin-left:5%;padding-bottom:15px;">
                <li {if condition="isset($answer)&&($vo['true_option'] eq 'A')"}style="color:green"{/if} ><input type="radio" name="{$vo.id}" value="A" title="{$vo.option_a}" {if condition="isset($answer)&&($answer[$vo['id']] eq 'A')"} checked="" {else /} checked="" {/if}></li>
                <li {if condition="isset($answer)&&($vo['true_option'] eq 'B')"}style="color:green"{/if}><input type="radio" name="{$vo.id}" value="B" title="{$vo.option_b}" {if condition="isset($answer)&&($answer[$vo['id']] eq 'B')"} checked="" {/if}></li>
                {if condition="$vo['is_choose'] eq 1"}
                <li {if condition="isset($answer)&&($vo['true_option'] eq 'C')"}style="color:green"{/if}><input type="radio" name="{$vo.id}" value="C" title="{$vo.option_c}" {if condition="isset($answer)&&($answer[$vo['id']] eq 'C')"} checked="" {/if}></li>
                <li {if condition="isset($answer)&&($vo['true_option'] eq 'D')"}style="color:green"{/if}><input type="radio" name="{$vo.id}" value="D" title="{$vo.option_d}" {if condition="isset($answer)&&($answer[$vo['id']] eq 'D')"} checked="" {/if}></li>
                {/if}
            </div>
        </div>
    {/volist}
    {if condition="isset($fraction)"}
        <div class="layui-form-item" style="padding-bottom:100px;">
            <div class="layui-input-block" >
                    <button class="layui-btn" lay-submit="" lay-filter="demo2">您的得分为{$fraction}分</button>
            </div>
        </div>
    {else/}
        <div class="layui-form-item" style="padding-bottom:100px;">
            <div class="layui-input-block" >
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交试卷</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    {/if}

</form>
</body>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer;

        form.on('submit(demo1)', function(data){
            var i = JSON.stringify(data.field);
            $.ajax({
                url: "Detail" ,
                data:{'info':i},
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.open({
                        content: '你的考核分数为'+data.msg+'分'
                        ,btn: '我知道了'
                    });
                }
            })
            return false;
        });
        form.on('submit(demo2)', function(data){
            return false;
        });
    });
</script>
{include file="public/footer" /}





