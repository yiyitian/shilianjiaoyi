
<!DOCTYPE html>
<html style="background-color:#FFFFFF;">
<head>
    <meta charset="utf-8" />
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>个人信息</title>
    <meta name="apple-mobile-web-app-capable" content="no" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="/public/api/js/rembasic.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/public/api/css/MultiPicker.css"/>
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <link rel="stylesheet" href="/public/api/css/pandastar.css" />
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">


    <script src="/public/api/js/js/jquery.min.js"></script>
    <script src="/public/api/js/js/common.js"></script>
    <script src="/public/api/js/js/Popt.js"></script>
    <script src="/public/api/js/js/cityJson.js"></script>
    <script src="/public/api/js/js/citySet.js"></script>

    <style type="text/css">
        ._citys {width:100%; height:100%;display: inline-block; position: relative;background:#fff;}
        ._citys span {color: #56b4f8; height: 15px; width: 15px; line-height: 15px; text-align: center; border-radius: 3px; position: absolute; right: 1em; top: 10px; border: 1px solid #56b4f8; cursor: pointer;}
        ._citys0 {width: 100%; height: 34px; display: inline-block; border-bottom: 2px solid #56b4f8; padding: 0; margin: 0;background:#fff}
        ._citys0 li {float:left; height:34px;line-height: 34px;overflow:hidden; font-size: 15px; color: #888; width: 80px; text-align: center; cursor: pointer; }
        .citySel {background-color: #56b4f8; color: #fff !important;}
        ._citys1 {width: 100%;height:80%; display: inline-block;  overflow: auto;background:#fff;}
        ._citys1 a {height: 35px; display: block; color: #666; padding-left: 6px;  line-height: 35px; cursor: pointer; font-size: 13px; overflow: hidden;}
        ._citys1 a:hover { color: #fff; background-color: #56b4f8;}
        .ui-content{border: 1px solid #EDEDED;}
        li{list-style-type: none;}
    </style>

</head>
<body>
<div class="body-container">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>个人信息</p></div>
            <div class="R" style="position: absolute;right: 10px;top: 0;color: #fff;line-height: 39px;" id="anq_tuic"><p>保存</p></div>
        </div>
    </div>
    <form id="form">
        <div class="toper-wrap">

        </div>
        <div class="datawrap1">
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        姓名
                    </div>

                </div>
                <div class="databox-right">
                    <input class="text-input" type="text" name="username"  value="{$info.username|default=''}" placeholder="李倩" maxlength="100">
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        工号
                    </div>

                </div>
                <div class="databox-right">
                    <input class="text-input" type="text" name="work_id"  value="{$info.work_id|default=''}" placeholder="GH-007" maxlength="100">
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        性别
                    </div>
                </div>
                <div class="databox-right">
                    <select name="sex" class="text-input sex-input" id="sex-input" style="background:#fff;" >
                        <option value ="1" {if condition="$info['sex'] eq 1"} selected="selected" {/if} >男</option>
                        <option value ="-1"  {if condition="$info['sex'] eq -1"} selected="selected" {/if} >女</option>
                    </select>
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        手机号
                    </div>
                </div>
                <div class="databox-right">
                    <input class="text-input" type="text" name="phone" id="" value="{$info.phone|default=''}" placeholder="17853103949" maxlength="100">
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        出生日期
                    </div>
                </div>
                <div class="databox-right">
                    <input type="text" name="birthday" id="birthday"  value="{$info.birthday|default=''}" readonly="readonly" class="text-input"/>
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        入职日期
                    </div>
                </div>
                <div class="databox-right">
                    <input type="text" name="start_time" id="start_date"  value="{$info.birthday|default=''}" readonly="readonly" class="text-input" />
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        婚姻
                    </div>
                    <input type="hidden" name="id" value="{$info.id}"/>
                </div>
                <div class="databox-right">
                    <select name="marriage"  class="text-input age-input" id="age-input"  style="background:#fff;" >
                        <option value ="-1" {if condition="$info['marriage'] eq -1"} selected="selected" {/if} >未婚</option>
                        <option value ="1" {if condition="$info['marriage'] eq 1"} selected="selected" {/if}>已婚</option>
                    </select>
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        户口所在地
                    </div>
                </div>
                <div class="databox-right">
                    <div id="city" style="font-size:12px;text-align:right;" >{$info.domicile|default='山东省济南市历下区'}</div>
                    <input type="hidden"  class="text-input"  id="citys" name="domicile" value="{$info.domicile|default='山东省济南市历下区'}" />
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        最高学历
                    </div>
                </div>
                <div class="databox-right">
                    <input class="text-input" type="text"  name="education" value="{$info.education|default=''}"  >
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        所学专业
                    </div>
                </div>
                <div class="databox-right">
                    <input class="text-input" type="text"  name="education" value="{$info.education|default=''}"  >
                </div>
            </div>
            <div class="databox">
                <div class="databox-left">
                    <div class="databox-left-ct">
                        毕业院校
                    </div>
                </div>
                <div class="databox-right">
                    <input class="text-input" type="text" name="universit" value="{$info.universit|default=''}" >
                </div>
            </div>
        </div>
    </form>
</div>
<div id="sex-targetContainer"></div>
<div id="age-targetContainer"></div>
<script src="/public/api/LCalendar/js/LCalendar.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#start_date',
        'type': 'date',
        'minDate': (new Date().getFullYear()-30) + '-' + 1 + '-' + 1,
        'maxDate': (new Date().getFullYear()+3) + '-' + 12 + '-' + 31
    });
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#birthday',
        'type': 'date',
        'minDate': (new Date().getFullYear()-50) + '-' + 1 + '-' + 1,
        'maxDate': (new Date().getFullYear()+0) + '-' + 12 + '-' + 31
    });
</script>

<script src="/public/api/js/jquery-2.1.3.min.js"></script>
<script src="/public/api/js/MultiPicker.js" type="text/javascript" charset="utf-8"></script>
<script>
    $("#city").click(function (e) {
        SelCity(this,e);

    });
        $("#anq_tuic").click(function () {
            var i = $("form").serialize();
            $.ajax({
                url: "personal",
                data: i,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    if (data.code == 2) {
                        alert(data.msg);
                    } else {
                            window.location.replace('/api/User/indexs');
                    }
                }
            })
            return false;
        })
</script>

</body>
</html>