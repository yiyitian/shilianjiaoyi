{include file="public/header" /}
<!-- 头部 -->
<style>
.ready{
    padding-bottom:100px;
    width:100%;
}
.ready button{
    border-radius:25px;
    border: 7px solid #e28d00;
    background: #e28d00;
    color:#fff;
}

</style>
<div class="toub_beij">
    <div class="logo"><a href="###"><img src="/public/index/images/logo_sy.png"></a></div>
<!--    <div class="sy_zaix"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2239329788&site=qq&menu=yes">在线咨询</a></div>-->
</div>

<div class="luj">
    <div class="luj_nk">
        <em></em>
        <a href="###">公告详情</a>
    </div>
</div>
<div class="news_xiangq_k">
    <h1>{$info['title']}</h1>
    <span>发布时间：{$info['createtime']}</span>
    <div class="news_text">
        {$info.content|default=''}

{if condition="$info.id eq 7"}
     <object width="100%"  data="/public/kindeditor/attached/media/20200312/20200312085301_63101.mp4"></object>
     
          <object width="100%"  data="/public/11111.mp4"></object>

     {/if}

    </div>
    {if condition="$ids eq 1"}
    <div class="ready">
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
    {/if}
 

</div>


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
                    data:{'gid':"{$info.id}"},
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
                    data:{'gid':"{$info.id}"},
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

{include file="public/footer" /}