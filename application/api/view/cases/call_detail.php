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
                <div class="C"><p>接听详情</p></div>
            </div>
        </div>
    <div class="lecture-art" style="padding-top:50px;">
        <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>打分名称</td>
                <td  style="text-align:center">分数</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>部门</td>
                <td  class="fen">{$info.department|default=''}</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>项目</td>
                <td  class="fen">{$info.project|default=''}</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>项目经理</td>
                <td  class="fen">{$info.manager|default=''}</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>项目电话</td>
                <td  class="fen">{$info.project_tel|default=''}</td>
            </tr> <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>标准开场语言</td>
                <td  class="fen">{$info.standard|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>积极接听</td>
                <td  class="fen">{$info.positive|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>传递核心价值</td>
                <td  class="fen">{$info.core|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>询问来电渠道</td>
                <td  class="fen">{$info.callfrom|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>邀约客户</td>
                <td  class="fen">{$info.invitation|default=''}</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>是否合格</td>
                <td  class="fen">{$info.qualified|default=''}</td>
            </tr>

            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>电话录音</td>
                <td  class="fen">{if condition="isset($mp3)"}<a href="{$mp3.url}" style="color:red;">查看音频</a>{else/}暂无音频{/if}</td>
            </tr>

            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>抽查时间</td>
                <td  class="fen">{$info.enquirytime|default=''}</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='52%' style='font-weight:bold;'>备注</td>
                <td  class="fen">{$info.mark|default=''}</td>
            </tr>

        </table>
    </div>









    </div>

    <script src="/public/api/LCalendar/js/LCalendar.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#start_date', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': (new Date().getFullYear()-30) + '-' + 1 + '-' + 1, //最小日期
            'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31 //最大日期
        });
        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#birthday', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': (new Date().getFullYear()-50) + '-' + 1 + '-' + 1, //最小日期
            'maxDate': (new Date().getFullYear()+0) + '-' + 12 + '-' + 31 //最大日期
        });
        //		$(function() {
        //			$('#start_date').date();
        //			$('#end_date').date();
        //		});
    </script>


    </form>
    </div>
    <!--aui-slide-body end -->
    </div>
    </div>
    </div>

</section>
</form>
</section>
</body>

<script>
    layui.use('upload', function() {
        var $ = layui.jquery;
        $("#anq_tuic").click(function()
        {
            var i = $("form").serialize();
            $.ajax({
                url: "detail" ,
                data: i ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code == 2)
                    {
                        alert(data.msg);
                    }else{
                        layer.msg(data.msg,{time:1000},function () {
                            location.reload();
                        });
                    }
                }
            })
            return false;
        })
    })

</script>

{include file="layouts/footer" /}
