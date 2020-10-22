<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>询盘详情</title>
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
            <div class="C"><p>询盘详情</p></div>
        </div>
    </div>
    <form id="form" style="    padding-bottom: 88px;padding-top:40px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='33%' style='font-weight:bold;'>打分名称</td>
                    <td  style="text-align:center;width:33%">分数</td>
                    <td  style="text-align:center;width:33%">图片</td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='33%' style='font-weight:bold;'>部门</td>
                    <td  class="fen">{$info.department|default=''}</td>
                    <td  class="fen">
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>项目</td>
                    <td  class="fen">{$info.project|default=''}</td>
                    <td  class="fen">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>项目经理</td>
                    <td  class="fen">{$info.manager|default=''}</td>
                    <td  class="fen">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>得分</td>
                    <td  class="fen">{$info.score|default=''}</td>
                    <td  class="fen">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>等级</td>
                    <td  class="fen">{$info.levels|default=''}</td>
                    <td  class="fen">
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>考勤纪律</td>
                    <td  class="fen">{$info.a|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['as'])"}
                            {volist name="$info['as']" id="vo"}
                                <image src="/public/{$vo}" width="45%" alt=""/>
                            {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>仪容仪表</td>
                    <td  class="fen">{$info.b|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['bs'])"}
                        {volist name="$info['bs']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>行为规范</td>
                    <td  class="fen">{$info.c|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['cs'])"}
                        {volist name="$info['cs']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>团队激励</td>
                    <td  class="fen">{$info.d|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ds'])"}
                        {volist name="$info['ds']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>会议组织</td>
                    <td  class="fen">{$info.f|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['fs'])"}
                        {volist name="$info['fs']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>电话接听</td>
                    <td  class="fen">{$info.h|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['hs'])"}
                        {volist name="$info['hs']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>小客户回访</td>
                    <td  class="fen">{$info.i|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['is'])"}
                        {volist name="$info['is']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>客户登记</td>
                    <td  class="fen">{$info.j|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['js'])"}
                        {volist name="$info['js']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>数据录入</td>
                    <td  class="fen">{$info.k|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ks'])"}
                        {volist name="$info['ks']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>录音手环</td>
                    <td  class="fen">{$info.l|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ls'])"}
                        {volist name="$info['ls']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>六大文件夹</td>
                    <td  class="fen">{$info.m|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ms'])"}
                        {volist name="$info['ms']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>团队沟通</td>
                    <td  class="fen">{$info.n|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ns'])"}
                        {volist name="$info['ns']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>400投诉</td>
                    <td  class="fen">{$info.p|default=''}</td>
                    <td  class="fen">
                        {if condition="isset($info['ps'])"}
                        {volist name="$info['ps']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>备注</td>
                    <td  >{$info.mark|default=''}</td>
                    <td  ></td>
                </tr>

                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='32%' style='font-weight:bold;'>合格照片</td>
                    <td  class="fen"></td>
                    <td  class="fen">
                        {if condition="isset($info['es'])"}
                        {volist name="$info['es']" id="vo"}
                        <image src="/public/{$vo}" width="45%" alt=""/>
                        {/volist}
                        {/if}
                    </td>
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
