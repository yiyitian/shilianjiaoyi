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
            <div class="C"><p>回访详情</p></div>
        </div>
    </div>
    <div class="lecture-art" style="padding-top:50px;">
        <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>打分名称</td>
                <td  style="text-align:center">分数</td>
            </tr>
            <tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>部门</td>
                <td  class="fen">{$list.department|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>项目</td>
                <td  class="fen">{$list.project|default=''}1</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>销售员工</td>
                <td  class="fen">{$list.salesman|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>客户电话</td>
                <td  class="fen">{$list.phone|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>客户姓名</td>
                <td  class="fen">{$list.customer|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>主动接待</td>
                <td  class="fen">{$list.positive|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>耐心回答</td>
                <td  class="fen">{$list.patient|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>客户了解楼盘</td>
                <td  class="fen">{$list.lucid|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>有无异议</td>
                <td  class="fen">{$list.dissent|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>客户对服务评价</td>
                <td  class="fen">{$list.appraise|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>客户建议</td>
                <td  class="fen">{$list.suggest|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>总分</td>
                <td  class="fen">{$list.score|default=''}</td>
            </tr><tr style="background-color: rgb(245, 245, 245);">
                <td align="left" valign="middle" width='56%' style='font-weight:bold;'>备注</td>
                <td  class="fen">{$list.mark|default=''}</td>
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
