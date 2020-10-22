<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>添加访谈</title>
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
            <div class="C"><p>添加访谈</p></div>

        </div>
    </div>
    <form class="layui-form" action="" id="formid"  style="margin-top: 40px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                
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
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>项目策划</td>
                    <td  class="fen">
                        <input type="text"  id="plan"  name="plan" value="{$list.plan|default=''}"  placeholder="请输入项目策划" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>访谈人</td>
                    <td  class="fen">
                        <input type="text"  id="ftname"  name="ftname" value="{$list.ftname|default=''}"  placeholder="请输入项目策划" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>被访谈人</td>
                    <td  class="fen">
                        <input type="text"  id="bftname"  name="bftname" value="{$list.bftname|default=''}"  placeholder="请输入项目策划" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>被访谈人职位</td>
                    <td  class="fen">
                        <input type="text"  id="bftposts"  name="bftposts" value="{$list.bftposts|default=''}"  placeholder="请输入项目策划" class="layui-input">
                    </td>
                </tr>

                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>访谈时间</td>
                    <td  class="fen">
                        <input type="text"  id="fttime"  name="fttime" value="{$list.fttime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>工作状态</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="status" style="width:100%">{$list.status|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>执行力</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="zxl" style="width:100%">{$list.zxl|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>配合度</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="phd" style="width:100%">{$list.phd|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>建议</td>
                    <td  class="fen">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="jy" style="width:100%">{$list.jy|default=''}</textarea>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>满意度</td>
                    <td  class="fen">
                        {empty name="list.standard"}
                        <input type="radio" name="myd" value="非常满意" title="非常满意">
                        <input type="radio" name="myd" value="满意" title="满意">
                        <input type="radio" name="myd" value="一般" title="一般">
                        <input type="radio" name="myd" value="不满意" title="不满意">
                        {else /}
                        <input type="radio" name="myd" value="非常满意" title="非常满意" {if condition="$list.standard eq '非常满意'"} checked {/if}>
                        <input type="radio" name="myd" value="满意" title="满意" {if condition="$list.standard eq '满意'"} checked {/if}>
                        <input type="radio" name="myd" value="一般" title="一般" {if condition="$list.standard eq '一般'"} checked {/if}>
                        <input type="radio" name="myd" value="不满意" title="不满意" {if condition="$list.standard eq '不满意'"} checked {/if}>
                        {/empty}
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
    layui.use(['laydate','layer', 'form','element','jquery','upload'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form
            , upload = layui.upload
            ,laydate = layui.laydate;



        form.on('submit(demo1)', function(data){

            $.ajax({
                url: "ftAdd" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                   layer.msg('添加成功',function(){
                       location.href="ft";
                   })
                }
            })
            return false;
        });

        laydate.render({
            elem: '#fttime'
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
