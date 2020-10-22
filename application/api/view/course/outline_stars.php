<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{$info.class_name}</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
    <style>
        .fen{
            text-align:center;
            color:red;
        }
    </style>
</head>
<body>

<section class="aui-flexView">
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                <input type="hidden" name="pid" lay-verify="title" autocomplete="off"  value="{$id}" placeholder="请输入标题" class="layui-input">
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='20%' style='font-weight:bold;'>培训建议</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="suggest" style="width:100%">{$list.suggest|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='20%' style='font-weight:bold;'>培训心得（至少三点）</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="experience" style="width:100%">{$list.experience|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='20%' style='font-weight:bold;'>在岗的工作困惑（选填）</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="puzzled" style="width:100%">{$list.puzzled|default=''}</textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            </div>
        </div>

    </form>
</section>
</body>
<script>
    layui.use(['laydate','layer', 'form','element','jquery','upload'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form;
        form.on('submit(demo1)', function(data){
            $.ajax({
                url: "outlineStars" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg,function(){
                        location.href="offline";
                    })
                }
            })
            return false;
        });
    })

</script>
{include file="layouts/footer" /}
