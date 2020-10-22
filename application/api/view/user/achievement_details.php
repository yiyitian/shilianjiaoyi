<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>考核详情</title>
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
            <div class="C"><p>考核详情</p></div>
        </div>
    </div>
    <form id="form" style="padding-top:50px;">
        <section class="aui-scrollView">
            <div class="aui-tab" data-ydui-tab>
                <div class="tab-panel">
                    <div class="tab-panel-item">
                        <div class="aui-slide-body">
                            <form>
                                <div class="lecture-art">
                                    <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>打分名称</td>
                                            <td  style="text-align:center;color:red">分数</td>
                                        </tr>
                                        {eq name="cid" value="4"}
                                            {empty name="status" value="1"}
                                                <tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>认购完成得分</td>
                                                    <td  style="text-align:center;color:red">{$info.subscribe_score|default=''}</td>
                                                </tr>
                                                <tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>真实性得分</td>
                                                    <td  style="text-align:center;color:red">{$info.authenticity|default=''}</td>
                                                </tr>
                                                
                                                 <tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>理论利润得分</td>
                                                    <td  style="text-align:center;color:red">{$info.profit_score|default=''}</td>
                                                </tr>
                                            {else/}
                                                <tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>蓄客完成得分</td>
                                                    <td  style="text-align:center;color:red">{$info.profit_score|default=''}</td>
                                                </tr><tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>计划书得分</td>
                                                    <td  style="text-align:center;color:red">{$info.work_book_score|default=''}</td>
                                                </tr>
                                                <tr style="background-color: rgb(245, 245, 245);">
                                                    <td align="left" valign="middle" width='52%' style='font-weight:bold;'>所在项目</td>
                                                    <td  style="text-align:center;color:red">{$info.project|default=''}</td>
                                                </tr>
                                        {/empty}
                                        {/eq}
                                        {eq name="cid" value="1"}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>计划书得分</td>
                                            <td  style="text-align:center;color:red">{$info.work_book_score|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>所在项目</td>
                                            <td  style="text-align:center;color:red">{$info.project|default=''}</td>
                                        </tr>
                                        {/eq}
                                        {eq name="cid" value="3"}
                                        {empty name="status" value="1"}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>完成率得分</td>
                                            <td  style="text-align:center;color:red">{$info.subscribe_real|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>来访得分</td>
                                            <td  style="text-align:center;color:red">{$info.visiting_score|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>理论利润得分</td>
                                            <td  style="text-align:center;color:red">{$info.profit_score|default=''}</td>
                                        </tr>
                                        {else/}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>来访得分</td>
                                            <td  style="text-align:center;color:red">{$info.develop_costume|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>计划书得分</td>
                                            <td  style="text-align:center;color:red">{$info.work_book_score|default=''}</td>
                                        </tr>
                                        {/empty}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>所在项目</td>
                                            <td  style="text-align:center;color:red">{$info.project|default=''}</td>
                                        </tr>
                                        {/eq}
                                        {eq name="cid" value="2"}
                                        {empty name="status" value="1"}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>认购得分</td>
                                            <td  style="text-align:center;color:red">{$info.subscribe_score|default=''}</td>
                                        </tr>
                                        {/empty}
                                        <tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>自拓客户得分</td>
                                            <td  style="text-align:center;color:red">{$info.oln_score|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>计划书得分</td>
                                            <td  style="text-align:center;color:red">{$info.work_book_score|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>ERP录入得分</td>
                                            <td  style="text-align:center;color:red">{$info.erp_entry_score|default=''}</td>
                                        </tr><tr style="background-color: rgb(245, 245, 245);">
                                            <td align="left" valign="middle" width='52%' style='font-weight:bold;'>所在项目</td>
                                            <td  style="text-align:center;color:red">{$info.project|default=''}</td>
                                        </tr>
                                        {/eq}
                                    </table>
                                </div>









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
