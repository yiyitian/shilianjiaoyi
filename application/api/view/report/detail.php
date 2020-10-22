<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>周报详情</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
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
<!--    <div class="header">-->
<!--        <div class="box">-->
<!--            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>-->
<!--            <div class="C"><p>周报详情</p></div>-->
<!--        </div>-->
<!--    </div>-->
    <form id="form">
    <div class="lecture-art">
        <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>名称</td>
                <td  style="text-align:center">目标</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>公司名称</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" style="text-align:center;color:red" name="company"    value="{$info.company|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text"   style="text-align:center;color:red" name="company"  readonly  value="{$info.company|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>来电(组)</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="comecall"   style="text-align:center;color:red"   value="{$info.comecall|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="comecall"  style="text-align:center;color:red"  readonly  value="{$info.comecall|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>来访(组)</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="comevisit"  style="text-align:center;color:red"    value="{$info.comevisit|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="comevisit"   style="text-align:center;color:red" readonly  value="{$info.comevisit|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周认购总套数</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="weektao"    style="text-align:center;color:red"  value="{$info.weektao|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="weektao"  style="text-align:center;color:red"  readonly  value="{$info.weektao|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周认购总金额(万)</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="mainhouse"  style="text-align:center;color:red"    value="{$info.mainhouse|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="mainhouse" readonly   style="text-align:center;color:red"  value="{$info.mainhouse|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周成交主房套数</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="weekjine"   style="text-align:center;color:red"   value="{$info.weekjine|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="weekjine"  style="text-align:center;color:red"  readonly  value="{$info.weekjine|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>月认购套数</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="monthtao"   style="text-align:center;color:red"   value="{$info.monthtao|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="monthtao"  style="text-align:center;color:red"  readonly  value="{$info.monthtao|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>月认购金额(万)</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="monthjine"  style="text-align:center;color:red"    value="{$info.monthjine|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="monthjine"  style="text-align:center;color:red"  readonly  value="{$info.monthjine|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>年认购金额(万)</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="yearjine"   style="text-align:center;color:red"   value="{$info.yearjine|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="yearjine"  style="text-align:center;color:red"  readonly  value="{$info.yearjine|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='71%' style='font-weight:bold;'>备注</td>
                <td  class="fen">
                    {empty name='settime'}
                    <input class="text-input" type="text" name="remark"  style="text-align:center;"  readonly value="{$info.remark|default=''}"  maxlength="100">
                    {else/}
                    <input class="text-input" type="text" name="remark"  style="text-align:center;"  readonly value="{$info.remark|default=''}"  maxlength="100">
                    {/empty}
                </td>
            </tr>
        </table>
    </div>




                                <input type="hidden" name="id" value="{$info.id}"/>

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

                                {empty name='settime'}
                                    <div class="objo">
                                        <a class="btn">
                                            <button id="anq_tuic"  value="立即提交">
                                                立即提交
                                            </button>
                                        </a>
                                    </div>
                                {/empty}
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
