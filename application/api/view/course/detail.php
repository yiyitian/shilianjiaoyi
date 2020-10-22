<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title{$name}</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/public/api/css/course.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <style>
        .xue {
            display:none;
        }
    </style>
</head>
<body>

<section class="aui-flexView">
   
    <section class="aui-scrollView">
        <div class='course-art'>
            <h2 style="font-size:18xp;">{$name}</h2>
            <div class='sourcedata'><span>来源：山东世联</span>&nbsp;&nbsp;&nbsp;<span>发布时间：{$info['startdate']}</span>&nbsp;&nbsp;&nbsp;</div>
            <hr style='border: 0.5px solid #ccc;'></hr>

            <div>
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
                //echo '<video src="http://mpvideo.qpic.cn/0bf2qqadwaaa3maatcbsfnpvbbgdhocaaoya.f10002.mp4?dis_k=7402666e4a072bb0e9ac65fe5a49f6e1&dis_t=1597127623" controls="controls"></video>';
                ?>
            </div>
            <div id="xue" {if condition="$xue eq 1"} class="xue"{/if}style="padding:20px;text-align: center;padding-left: 32px;">
                <button id='button' style="color: #fff;background: #d70c18;border: 9px solid #d70c18;border-left: 18px solid #d70c18;
    border-right: 17px solid #d70c18;">完成学习</button>
            <span style="float:right;"><button type="button" class="layui-btn layui-btn-warm" id="test3">上传心得</button><span  style="color:#999">&nbsp;&nbsp;&nbsp;(仅限word文件)</span></span>

        </div>

            <div id="wan" {if condition="$xue eq -1"} class="xue"{/if} style="padding:20px;text-align: center;padding-left: 32px;">
                <button id='buttons' style="color: #fff;background: #6c6c6c;border: 9px solid #6c6c6c;border-left: 18px solid #6c6c6c;
    border-right: 17px solid #6c6c6c;">学习完成</button>
<span style="float:right;"><button type="button" class="layui-btn layui-btn-warm" id="test3">上传心得</button><span  style="color:#999">&nbsp;&nbsp;&nbsp;(仅限word文件)</span></span>
        </div>

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
            <div class="layui-form-item" style="text-align: center;">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" style="margin-left:-34%;" lay-submit="" lay-filter="demo1">立即提交</button>
                    <a href="http://www.baidu.com" style="display: none;"><button type="reset" class="layui-btn layui-btn-warm"  style="margin-left:55%;">在线考核</button></a>

                </div>
            </div>
        </form>

        <script type="text/javascript" src="/public/layui/layui.js"></script>
        <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
     
    </section>

</section>

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
                    layer.msg(data.msg,{time:1000});
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
                    layer.msg("学习成功",{time:1000});
                    $("#xue").css({"display":"none"});
                    $("#wan").css({"display":"block"});
                }
            })
        })
    });
</script>
{include file="layouts/footer" /}



