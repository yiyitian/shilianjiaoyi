<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>周报详情</title>
    <meta name="apple-mobile-web-app-capable" content="no">
    <link rel="stylesheet" type="text/css" href="/public/api/css/MultiPicker.css">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link rel="stylesheet" href="/public/api/css/top.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">

</head>
<body class="">
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>周报详情</p></div>
    </div>
</div>
    <section class="aui-flexView" style="padding-top:40px;">
        {volist name="list" id="vo"}
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
                            <input class="text-input" type="text" id="{$vo.id}-company" onblur="ajaxEdit({$vo.id},'company');" style="text-align:center;color:red" name="company"    value="{$vo.company|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text"   style="text-align:center;color:red" name="company"  readonly  value="{$vo.company|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>来电(组)</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="comecall"   style="text-align:center;color:red"   id="{$vo.id}-comecall" onblur="ajaxEdit({$vo.id},'comecall');"  value="{$vo.comecall|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="comecall"  style="text-align:center;color:red"  readonly  value="{$vo.comecall|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>来访(组)</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="comevisit"  style="text-align:center;color:red"  id="{$vo.id}-comevisit" onblur="ajaxEdit({$vo.id},'comevisit');"    value="{$vo.comevisit|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="comevisit"   style="text-align:center;color:red" readonly  value="{$vo.comevisit|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周认购总套数</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="weektao"    style="text-align:center;color:red"  id="{$vo.id}-weektao" onblur="ajaxEdit({$vo.id},'weektao');"  value="{$vo.weektao|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="weektao"  style="text-align:center;color:red"  readonly  value="{$vo.weektao|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周认购总金额(万)</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="mainhouse"  style="text-align:center;color:red"   id="{$vo.id}-mainhouse" onblur="ajaxEdit({$vo.id},'mainhouse');"   value="{$vo.mainhouse|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="mainhouse" readonly   style="text-align:center;color:red"  value="{$vo.mainhouse|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>周成交主房套数</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="weekjine"   style="text-align:center;color:red"   id="{$vo.id}-weekjine" onblur="ajaxEdit({$vo.id},'weekjine');"  value="{$vo.weekjine|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="weekjine"  style="text-align:center;color:red"  readonly  value="{$vo.weekjine|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>月认购套数</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="monthtao"   style="text-align:center;color:red"  id="{$vo.id}-monthtao" onblur="ajaxEdit({$vo.id},'monthtao');"   value="{$vo.monthtao|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="monthtao"  style="text-align:center;color:red"  readonly  value="{$vo.monthtao|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>月认购金额(万)</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="monthjine"  style="text-align:center;color:red"   id="{$vo.id}-monthjine" onblur="ajaxEdit({$vo.id},'monthjine');"   value="{$vo.monthjine|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="monthjine"  style="text-align:center;color:red"  readonly  value="{$vo.monthjine|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>年认购金额(万)</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="yearjine"   style="text-align:center;color:red"  id="{$vo.id}-yearjine" onblur="ajaxEdit({$vo.id},'yearjine');"   value="{$vo.yearjine|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="yearjine"  style="text-align:center;color:red"  readonly  value="{$vo.yearjine|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                    <tr style="background-color: rgb(245, 245, 245);">
                        <td align="left" valign="middle" width='71%' style='font-weight:bold;'>备注</td>
                        <td  class="fen">
                            {empty name='settime'}
                            <input class="text-input" type="text" name="remark"  style="text-align:center;"  id="{$vo.id}-remark" onblur="ajaxEdit({$vo.id},'remark');"  readonly value="{$vo.remark|default=''}"  maxlength="100">
                            {else/}
                            <input class="text-input" type="text" name="remark"  style="text-align:center;"  readonly value="{$vo.remark|default=''}"  maxlength="100">
                            {/empty}
                        </td>
                    </tr>
                </table>
            </div>
        {/volist}
    </section>
</body>
</html>

<script>
    function ajaxEdit(a,b){
        var s = a+'-'+b;
        var i = $("#"+s).val();
        $.ajax({
            url: "addWeek" ,
            data: {'s':i,'id':a,'field':b} ,
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
    }
</script>
