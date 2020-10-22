{include file="public/header" /}
<style>
#remark img{
    width:100%;
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
        <a href="###">课程详情</a>
    </div>
</div>
<div class="news_xiangq_k">
    <h1>{$name}</h1>
    <span>发布时间：{$info['startdate']}</span>
    <div class="news_text">
<!--        <p>又是一个声音交汇的“时节”。1月23日至26日，世界经济论坛2018年年会在瑞士达沃斯小镇举行，以“在分化的世界中打造共同命运”为主题，聚焦在地缘战略竞争加剧背景下国际合作的意义。“今年论坛的主题延续了习近平主席去年出席论坛年会时论述的‘构建人类命运共同体’理念。”世界经济论坛创始人兼执行主席施瓦布之言，将人们的视线转向习近平主席2017年在瑞士两个具有世界级分量的蕞尔之地留下的深深印记——</p>-->    </div>

<?php

if($info['id']>62)
{
    if($info['video_url'] !== '')
    {
    echo "<video  width='100%' height='240' controls='controls' ><source src='".$info['video_url']."' type='video/mp4' /></video>";

    }
}else{

    if(!empty($_GET['outline'])&&$_GET['outline']=='1'){

    }else{
        if(strpos($info['video_url'],'mudu') !== false){
            echo "<div style='position:relative;'><div onclick=javascript:window.open('".$info['video_url']."'); style='position: absolute;top:0;left:0;width:100%;height:100%;z-index: 999;display: block;'></div><iframe height=100% width=100% src='".$info['video_url']."'  frameborder=0 'allowfullscreen'></iframe></div>";
        }else{
            echo "<iframe height=100% width=100% src='".$info['video_url']."</iframe>";
        }
    }
}


?>



<div style="padding:20px" id='remark'>
{$info.remark}
</div>

<div style="padding:20px;text-align: center;">
        <button id='button' style="color: #fff;background: #d70c18;border: 9px solid #d70c18;border-radius: 5px;">学习完成</button>
</div>

</div>
<div class="layui-form-item layui-form-text">
    <div class="layui-input-block" style="margin-left:0;width:90%;padding-left:5%;">
        <button type="button" class="layui-btn layui-btn-warm" id="test3">上传心得</button><span>&nbsp;&nbsp;&nbsp;(仅限word文件)</span>
    </div>
</div>

<form class="layui-form" action="">
    <input type="hidden" name="classtype" value="{$info.classtype}"/>
    <input type="hidden" name="classify" value="{$info.classify}"/>
    <input type="hidden" name="classname" value="{$info.classname}"/>
    <input type="hidden" name="class_id" value="{$info.id}"/>
    <input type="hidden" name="class_name" value="{$name}"/>
    <input type="hidden" name="tips_files" id="tips_files" value="{$tips.tips_files|default=''}"/>
    <div class="layui-form-item layui-form-text">
        <div class="layui-input-block" style="margin-left:0;width:90%;padding-left:5%;">
            <textarea name="remark" placeholder="请输入培训心得" class="layui-textarea">{$tips.remark|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" style="margin-left:-34%;" lay-submit="" lay-filter="demo1">立即提交</button>
            <a href="http://www.baidu.com" style="display: none;"><button type="reset" class="layui-btn layui-btn-warm"  style="margin-left:55%;">在线考核</button></a>

        </div>
    </div>
</form>

<script type="text/javascript" src="/public/layui/layui.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<script>
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
        upload.render({
            elem: '#test3'
            ,url: '/Index/User/uploads/'
            ,accept: 'file' //普通文件
            ,done: function(res){
                layer.msg('上传成功');
                document.getElementById('tips_files').value = res.src;
            }
        });
    });
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,$ = layui.jquery;
        form.on('submit(demo1)', function(data){
            var i = JSON.stringify(data.field);
            $.ajax({
                    url: "addTips" ,
                    data:{'info':i},
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg,{time:1000},function () {
                            window.location.replace('/index/Online/index');
                        });
            }
        })
            return false;
        });

        $('#button').click(function(){
             $.ajax({
                    url: "addclassinfo" ,
                    data:{'id':"{$info.id}"},
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg("学习成功",{time:1000})
            }
        })
        })
    });
</script>

{include file="public/footer" /}