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
<input type="hidden" name="question" value="{$question}"/>
<input type="hidden" name="times" value="{$times}"/>
    {volist name="testquestion" id="vo"}
        <div class="layui-form-item" style="background:#fff;">
            <div style="width:90%;margin-left:5%;font-size:18px;padding:10px 1px">{$i}.{$vo.question}</div>
            {if condition="$vo.is_choose eq 1"}
            <div class="layui-input-block" style="margin-left:0;width:90%;margin-left:5%;padding-bottom:15px;">
                {notempty name="vo.option_a"}
                <input type="radio" name="{$vo.id}" value="{$vo.option_a}" title="{$vo.option_a}" checked>
                {/notempty}
                {notempty name="vo.option_b"}
                <input type="radio" name="{$vo.id}" value="{$vo.option_b}" title="{$vo.option_b}" >
                {/notempty}
                {notempty name="vo.option_c"}
                <input type="radio" name="{$vo.id}" value="{$vo.option_c}" title="{$vo.option_c}" >
                {/notempty}
                {notempty name="vo.option_d"}
                <input type="radio" name="{$vo.id}" value="{$vo.option_d}" title="{$vo.option_d}" >
                {/notempty}
            </div>
            {else /}
            <div class="layui-input-block" style="margin-left:0;width:90%;margin-left:5%;padding-bottom:15px;">
                <textarea placeholder="请输入内容" class="layui-textarea" name="{$vo.id}" id="a{$vo.id}" ></textarea>
            </div>
            {/if}
        </div>
    {/volist}
    {if condition="isset($fraction)"}
        <div class="layui-form-item" style="padding-bottom:100px;">
            <div class="layui-input-block" >
                    <button class="layui-btn" lay-submit="" lay-filter="demo2">您的得分为{$fraction}分</button>
            </div>
        </div>
    {else/}
        <div class="layui-form-item sub" style="padding-bottom:100px;">
            <div class="layui-input-block" >
                <span class="layui-btn" lay-submit="" lay-filter="demo1">提交试卷</span>
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
//自定义验证规则

        form.on('submit(demo1)', function(data){
            //var info = JSON.stringify(data.field);
            var info = data.field;

            //console.log(info);
            {volist name="testquestion" id="vo"}
            // console.log({$vo.id});
            // console.log(info['{$vo.id}']);
            // console.log(info['{$vo.id}'].length<2);
                if(info['{$vo.id}']==''){
                    alert('请认真填写每一项');
                    return false;
                }


            {/volist}
console.log(info);

            $.ajax({
                url: "feedback" ,
                data:{info},
                type: "post" ,

                success:function(data){
                    console.log(data);

                    layer.open({
                        content: data.msg
                        ,btn: '确定'
                        ,yes: function(index){
                            $('.sub').hide();
                            layer.closeAll();
                            window.location.replace("/index/Online/index");
                        },
                    });
                }
            })

        });

    });
</script>
{include file="public/footer" /}





