<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>回访详情</title>
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
            <div class="C"><p>添加回访</p></div>

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
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>销售员工</td>
                    <td  class="fen">
                        <input type="text" id="salesman" name="salesman" value="{$list.salesman|default=''}" placeholder="请输入业务员姓名" class="layui-input">

                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>客户电话</td>
                    <td  class="fen">
                        <input type="text" id="phone" name="phone" value="{$list.phone|default=''}" placeholder="请输入客户电话" class="layui-input">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>客户姓名</td>
                    <td  class="fen">
                        <input type="text"  id="customer"  name="customer" value="{$list.customer|default=''}"  placeholder="请输入客户姓名" class="layui-input">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>主动接待</td>
                    <td  class="fen">
                        {empty name="list"}
                        <input type="radio" name="positive" value="1" title="1分">
                        <input type="radio" name="positive" value="0" title="0分">
                        {else /}
                        <input type="radio" name="positive" value="1" title="1分" {if condition="$list.positive eq '1'"} checked {/if}>
                        <input type="radio" name="positive" value="0" title="0分" {if condition="$list.positive eq '0'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>耐心回答</td>
                    <td  class="fen">
                        {empty name="list"}
                        <input type="radio" name="patient" value="1" title="1分">
                        <input type="radio" name="patient" value="0" title="0分">
                        {else /}
                        <input type="radio" name="patient" value="1" title="1分" {if condition="$list.patient eq '1'"} checked {/if}>
                        <input type="radio" name="patient" value="0" title="0分" {if condition="$list.patient eq '0'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>客户了解楼盘</td>
                    <td  class="fen">
                        {empty name="list"}
                        <input type="radio" name="lucid" value="1" title="1分">
                        <input type="radio" name="lucid" value="0" title="0分">
                        {else /}
                        <input type="radio" name="lucid" value="1" title="1分" {if condition="$list.lucid eq '1'"} checked {/if}>
                        <input type="radio" name="lucid" value="0" title="0分" {if condition="$list.lucid eq '0'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>有无异议</td>
                    <td  class="fen">
                        {empty name="list"}
                        <input type="radio" name="dissent" value="1" title="1分">
                        <input type="radio" name="dissent" value="0" title="0分">
                        {else /}
                        <input type="radio" name="dissent" value="1" title="1分" {if condition="$list.dissent eq '1'"} checked {/if}>
                        <input type="radio" name="dissent" value="0" title="0分" {if condition="$list.dissent eq '0'"} checked {/if}>
                        {/empty}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>客户对服务评价</td>
                    <td  class="fen">
                        <input type="text" id="appraise" name="appraise" value="{$list.appraise|default=''}" placeholder="客户对服务评分" class="layui-input">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>客户建议</td>
                    <td  class="fen">
                        {empty name="list"}
                        <input type="radio" name="suggest" value="1" title="1分">
                        <input type="radio" name="suggest" value="0" title="0分">
                        <input type="radio" name="suggest" value="-1" title="-1分">
                        {else /}
                        <input type="radio" name="suggest" value="1" title="1分" {if condition="$list.suggest eq '1'"} checked {/if}>
                        <input type="radio" name="suggest" value="0" title="0分" {if condition="$list.suggest eq '0'"} checked {/if}>
                        <input type="radio" name="suggest" value="-1" title="-1分" {if condition="$list.suggest eq '-1'"} checked {/if}>
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>总分</td>
                    <td  class="fen">
                        <input type="text" id="score" name="score" value="{$list.score|default=''}" placeholder="总分" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>抽查时间</td>
                    <td  class="fen">
                        <input type="text"  id="enquirytime"  name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
                    </td>
                </tr>
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
    layui.use(['laydate','layer', 'form','element','jquery'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form
            ,laydate = layui.laydate;
        form.on('submit(demo1)', function(data){
            $.ajax({
                url: "addReview" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg('添加成功',function(){
                        location.href="review";
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
                    console.log(data);


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
