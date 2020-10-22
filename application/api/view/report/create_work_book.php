<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>工作计划化详情</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
</head>
<body>
<style>
    .fen{
        text-align:center;
        color:red;
    }
</style>
<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>添加计划书</p></div>
    </div>
    </div>
    <form class="layui-form" action="" id="formid"  style="margin-top: 30px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>名称</td>
                    <td  style="text-align:center">内容</td>
                </tr>
                {notempty name="list"}
                    <input type="hidden" name="id" value="{$list.id}" />
                {/notempty}

                {notempty name="setTime" }
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='40%' style='font-weight:bold;'>计划书（周）</td>
                        <td  class="fen">
                            <textarea placeholder="请输入内容" class="layui-textarea" name="content" style="width:100%">{$list.content|default=''}</textarea>
                        </td>
                    </tr>
                {else/}
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='40%' style='font-weight:bold;'>计划书（周）</td>
                        <td  class="fen">
                            <textarea placeholder="请输入内容" class="layui-textarea" readonly name="content" style="width:100%">{$list.content|default=''}</textarea>
                        </td>
                    </tr>
                {/notempty}
            </table>
        </div>
        <div class="layui-form-item">
            {notempty name="setTime"}
                {notempty name="list"}
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo2">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                {else/}
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                {/notempty}
            {/notempty}
        </div>
    </form>
</section>
</body>
<script>
    layui.use(['laydate','layer', 'form','element','jquery'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form
            ,laydate = layui.laydate;
        form.on('submit(demo1)', function(data){
            $.ajax({
                url: "CreateWorkBook" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg,function(){
                        location.href="workBook";
                    })
                }
            })
            return false;
        });
        form.on('submit(demo2)', function(data){
            $.ajax({
                url: "/api/Report/CreateWorkBooks" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg,function(){
                        location.href="workBook";
                    })
                }
            })
            return false;
        });

    })


</script>

{include file="layouts/footer" /}
