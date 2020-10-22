<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>接听详情</title>
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
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>添加电话接听</p></div>

        </div>
    </div>
    <form class="layui-form" action="" id="formid"  style="margin-top: 40px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>打分名称</td>
                    <td  style="text-align:center">分数</td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>地区</td>
                    <td  class="fen">
                        <select id="region" name="region" lay-filter="region">
                            <option></option>
                            {volist name="region" id="vo"}
                            {notempty name="list.region"}
                            <option value="{$vo.id}" {if condition="$vo.id eq $list.region"}selected{/if}>{$vo.name}</option>
                            {else /}
                            <option value="{$vo.id}">{$vo.name}</option>
                            {/notempty}
                            {/volist}
                        </select>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>部门</td>
                    <td  class="fen">
                        <select id="department" name="department" lay-filter="department">
                            <option></option>
                            {notempty name="list.department"}
                            <option value="{$list.department}" selected>{$list.department_name}</option>
                            {/notempty}
                        </select>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>项目</td>
                    <td  class="fen">
                        <select name="project_id" id="city" lay-verify="required" lay-search="">
                            <option value="">直接选择或搜索选择</option>
                        </select>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>项目经理</td>
                    <td  class="fen">
                        <input type="text"  id="manager"  name="manager" value="{$list.manager|default=''}"  placeholder="请输入项目经理" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>项目电话</td>
                    <td  class="fen">
                        <input type="text" id="project_tel" name="project_tel" value="{$list.project_tel|default=''}" placeholder="请输入项目电话" class="layui-input">
                    </td>
                </tr> <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>标准开场语言</td>
                    <td  class="fen">
                        {empty name="list.standard"}
                        <input type="radio" name="standard" value="√" title="√">
                        <input type="radio" name="standard" value="×" title="×">
                        {else /}
                        <input type="radio" name="standard" value="√" title="√" {if condition="$list.standard eq '√'"} checked {/if}>
                        <input type="radio" name="standard" value="×" title="×" {if condition="$list.standard eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>积极接听</td>
                    <td  class="fen">
                        {empty name="list.positive"}
                        <input type="radio" name="positive" value="√" title="√">
                        <input type="radio" name="positive" value="×" title="×">
                        {else /}
                        <input type="radio" name="positive" value="√" title="√" {if condition="$list.positive eq '√'"} checked {/if}>
                        <input type="radio" name="positive" value="×" title="×" {if condition="$list.positive eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>自报姓名</td>
                    <td  class="fen">
                        {empty name="list.a"}
                        <input type="radio" name="a" value="√" title="√">
                        <input type="radio" name="a" value="×" title="×">
                        {else /}
                        <input type="radio" name="a" value="√" title="√" {if condition="$list.a eq '√'"} checked {/if}>
                        <input type="radio" name="a" value="×" title="×" {if condition="$list.a eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>传递核心价值</td>
                    <td  class="fen">
                        {empty name="list.core"}
                        <input type="radio" name="core" value="√" title="√">
                        <input type="radio" name="core" value="×" title="×">
                        {else /}
                        <input type="radio" name="core" value="√" title="√" {if condition="$list.core eq '√'"} checked {/if}>
                        <input type="radio" name="core" value="×" title="×" {if condition="$list.core eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>询问来电渠道</td>
                    <td  class="fen">
                        {empty name="list.callfrom"}
                        <input type="radio" name="callfrom" value="√" title="√">
                        <input type="radio" name="callfrom" value="×" title="×">
                        {else /}
                        <input type="radio" name="callfrom" value="√" title="√" {if condition="$list.callfrom eq '√'"} checked {/if}>
                        <input type="radio" name="callfrom" value="×" title="×" {if condition="$list.callfrom eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>邀约客户</td>
                    <td  class="fen">
                        {empty name="list.invitation"}
                        <input type="radio" name="invitation" value="√" title="√">
                        <input type="radio" name="invitation" value="×" title="×">
                        {else /}
                        <input type="radio" name="invitation" value="√" title="√" {if condition="$list.invitation eq '√'"} checked {/if}>
                        <input type="radio" name="invitation" value="×" title="×" {if condition="$list.invitation eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>主动留电</td>
                    <td  class="fen">
                        {empty name="list.b"}
                        <input type="radio" name="b" value="√" title="√">
                        <input type="radio" name="b" value="×" title="×">
                        {else /}
                        <input type="radio" name="b" value="√" title="√" {if condition="$list.b eq '√'"} checked {/if}>
                        <input type="radio" name="b" value="×" title="×" {if condition="$list.b eq '×'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>是否合格</td>
                    <td  class="fen">
                        {empty name="list.qualified"}
                        <input type="radio" name="qualified" value="合格" title="合格">
                        <input type="radio" name="qualified" value="不合格" title="不合格">
                        {else /}
                        <input type="radio" name="qualified" value="合格" title="合格" {if condition="$list.qualified eq '合格'"} checked {/if}>
                        <input type="radio" name="qualified" value="不合格" title="不合格" {if condition="$list.qualified eq '不合格'"} checked {/if}>
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>抽查时间</td>
                    <td  class="fen">
                        <input type="text"  id="enquirytime"  name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>上传录音</td>
                    <td  class="fen">
                        <button type="button" class="layui-btn" id="test6"><i class="layui-icon"></i>上传音频</button>
                    </td>
                </tr>
                <input type="hidden" name="times" value="{$nowtime}"/>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>备注</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:100%">{$list.mark|default=''}</textarea>
                    </td>
                </tr>

            </table>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</section>
</body>
<script>
    layui.use(['laydate','layer', 'form','element','jquery','upload'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form
            , upload = layui.upload
            ,laydate = layui.laydate;

        upload.render({
            elem: '#test6'
            ,url: "uploads?mark=answercall&reserve=mp3&times={$nowtime}&updatetime={$nowtime}" //改成您自己的上传接口
            ,accept: 'audio' //音频
            ,done: function(res){
                layer.msg('上传成功');
                console.log(res)
            }
        });

        form.on('submit(demo1)', function(data){

            $.ajax({
                url: "addCall" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg('添加成功',function(){
                        location.href="answerCall";
                    })
                }
            })
            return false;
        });

        laydate.render({
            elem: '#enquirytime'
            , trigger: 'click'
        });
        form.on('select(region)', function(data){
            $.ajax({
                url: "getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    framework=data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < framework.length; i++){
                        $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });

        form.on('select(department)', function(data){
            console.log(data.value)
            $.ajax({
                url: "getProject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
    })

</script>
{include file="layouts/footer" /}
