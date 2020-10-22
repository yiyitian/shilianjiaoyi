<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>月报详情</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
</head>
<body>


<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>月报详情</p></div>
        </div>
    </div>
    <form id="form" style="padding-top:40px;">
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
                        <input class="text-input" type="text" name="company"     style="text-align:center;color:red"    value="{$info.company|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="company"    style="text-align:center;color:red"   readonly  value="{$info.company|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>上月销售住房套数</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="lastmonthmainhouse"    style="text-align:center;color:red"     value="{$info.lastmonthmainhouse|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="lastmonthmainhouse"   style="text-align:center;color:red"    readonly  value="{$info.lastmonthmainhouse|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>上月实际销售额</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="lastmonthsale"   style="text-align:center;color:red"      value="{$info.lastmonthmainhouse|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="lastmonthsale"   style="text-align:center;color:red"    readonly  value="{$info.lastmonthmainhouse|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>本月可售货量多少（万）</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="thismonthsale"     style="text-align:center;color:red"    value="{$info.thismonthsale|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="thismonthsale"   style="text-align:center;color:red"    readonly  value="{$info.thismonthsale|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>本月是否加推/开盘</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="is_add"    style="text-align:center;color:red"     value="{$info.is_add|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="is_add"   style="text-align:center;color:red"    readonly  value="{$info.is_add|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td  valign="middle" width='71%' style='font-weight:bold;'>加推/开盘总货量多少（万）</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="addnum"    style="text-align:center;color:red"     value="{$info.addnum|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="addnum"    style="text-align:center;color:red"   readonly  value="{$info.addnum|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>加推/开盘目标（万）</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="addaim"    style="text-align:center;color:red"   readonly  value="{$info.addaim|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="addaim"    style="text-align:center;color:red"   readonly  value="{$info.addaim|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>销售最高目标(万)</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="bestaim"   style="text-align:center;color:red"      value="{$info.bestaim|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="bestaim"   style="text-align:center;color:red"    readonly  value="{$info.bestaim|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>年认购金额(万)</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="yearjine"   style="text-align:center;color:red"     value="{$info.yearjine|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="yearjine"   style="text-align:center;color:red"   readonly  value="{$info.yearjine|default=''}"  maxlength="100">
                        {/empty}
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='71%' style='font-weight:bold;'>备注</td>
                    <td  class="fen">
                        {empty name='settime'}
                        <input class="text-input" type="text" name="mark"   readonly  value="{$info.mark|default=''}"  maxlength="100">
                        {else/}
                        <input class="text-input" type="text" name="mark"   readonly  value="{$info.mark|default=''}"  maxlength="100">
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

                                {notempty name='settime'}
                                    <div class="objo">
                                        <a class="btn">
                                            <button id="anq_tuic"  value="立即提交">
                                                立即提交
                                            </button>
                                        </a>
                                    </div>
                                {/notempty}
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
                url: "MonthDetail" ,
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
