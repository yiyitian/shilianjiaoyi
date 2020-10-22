<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>报名</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/api/login_js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
</head>
<body>

<section class="aui-flexView">
    <!--    <div class="header">-->
    <!--        <div class="box">-->
    <!--            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>-->
    <!--            <div class="C"><p>报名</p></div>-->
    <!--        </div>-->
    <!--    </div>-->
    <section class="aui-scrollView">
        <form id="form">
            <div class="clear"></div>
            <div class="lecture-art">
                <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='25%' style='text-align:center;font-weight:bold;'>课程名称</td>
                        <td>
                            <input type="text" name="className"  value="{$outline.className}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='25%' style='text-align:center;font-weight:bold;'>班主任</td>
                        <td>
                            <input type="text" name="ban"  value="{$outline.username}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='25%' style='text-align:center;font-weight:bold;'>培训时间</td>
                        <td>
                            <input type="text" name="startime"  value="{$outline.startdate}-{$outline.enddate}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>工号</td>
                        <td>
                            <input type="text" name="work_id"  value="{$userInfo.work_id}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>地区</td>
                        <td>{$userInfo.region}</td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>部门</td>
                        <td>
                            <input type="text" name="department_name"  value="{$userInfo.department}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>所属项目</td>
                        <td>
                            <input type="text" name="project"  value="{$userInfo.projectname}" readonly="readonly" class="text-input"/>
                        </td>
                    </tr>
                    {eq name="is_zheng" value="1"}
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>身份证号</td>
                        <td>
                            <input type="text" name="card" id="card" value="{$apply.card|default=''}"  placeholder="购买保险以及住宿使用" class="text-input"/>
                        </td>
                    </tr>
                    {/eq}
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>入住日期</td>
                        <td>
                            <input type="text" name="start_date" id="start_date" value="{$apply.start_date|default=''}" placeholder="选择入住日期" readonly="readonly" class="text-input" />
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>退房日期</td>
                        <td>
                            <input type="text" name="end_date" value="{$apply.end_date|default=''}" id="end_date" placeholder="选择退房日期" readonly="readonly"  class="text-input"/>
                        </td>
                        <input type="hidden" name="station_name" value="{$userInfo.station}"/>
                        <input type="hidden" name="times" value="{$times}"/>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" style='text-align:center;font-weight:bold;'>备注</td>
                        <td>
                            <input type="text" name="mark" value="{$apply.mark|default=''}" placeholder="请输入备注"  class="text-input"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="objo">
                <a class="btn" >
                    {if condition="isset($apply)"}
                    <button value="立即申请" type="button" >
                        {if condition="$apply.status eq -1"}
                        等待审核
                        {else/}
                        审核通过
                        {/if}
                    </button>
                    {else/}
                    <button value="立即申请" type="button" id="button">
                        立即申请
                    </button>
                    {/if}
                </a>
            </div>
        </form>
    </section>
</section>
<script src="/public/api/LCalendar/js/LCalendar.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#start_date', //标签id
        'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
        'minDate': (new Date().getFullYear()-3) + '-' + 1 + '-' + 1, //最小日期
        'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31 //最大日期
    });
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#end_date', //标签id
        'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
        'minDate': (new Date().getFullYear()-3) + '-' + 1 + '-' + 1, //最小日期
        'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31 //最大日期
    });
    $('#button').click(function()
    {
        var start_date = $('#start_date').val(),
            cards = {$is_zheng},
            end_date   = $('#end_date').val();
        if(cards>0)
        {
            var card = $('#card').val();
            if(""==card)
            {
                layer.open({
                    content: '身份证号不能为空'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
        }

        if((""==start_date)||(''==end_date))
        {
            layer.open({
                content: '入驻日期和退房日期不能为空'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
        }
        $.ajax({
            url: "signUp" ,
            data: $("form").serialize() ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                if(data.code !==1)
                {
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2
                    });
                }else if(data.code == 1)
                {
                    location.href="/api/User/index"
                }
            }
        })
        return false;

    })


</script>

{include file="layouts/footer" /}

