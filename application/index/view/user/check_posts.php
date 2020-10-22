
{include file="public/header" /}
<script type="text/javascript" src="/public/layui/layui.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
<link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">


<body style="height: 100%;background: #eaeaea;">
<!-- 头部 -->
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="personalCenter"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_bai.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">资料设置</div>
    <div class="sy_zaix"><a href="javascript:;"><span id="anq_tuic">保存</span></a></div>
</div>

<!-- 内容 -->

<div class="nei_r_btk">
    <form id="form">
        <ul>
            <li>
                <a href="#">
                    <h1>所属公司</h1>
                    <div class="xiugai" style="padding-top: 20px;padding-right:10px;">
                        <select name="region" id="region" style="font-size:12px;" >
                            {volist name="region" id="vo"}
                            <option style="width:100px;"  value ="{$vo.id}" {if condition="$info.region eq $vo.id"} selected="selected"{/if}>{$vo.posts}</option>
                            {/volist}
                        </select>
                    </div>
                </a>
            </li>
            <input type="hidden" name="id" value="{$info.id}"/>
            <li>
                <a href="#">
                    <h1>所属岗位</h1>
                    <div class="xiugai" style="padding-top: 20px;padding-right:10px;">
                        <select name="station" id="station"  style="font-size:12px;" >
                        {if condition="isset($station)"}
                            {volist name="station" id="vo"}
                             <option style="width:100px;" value ="{$vo.id}" {if condition="$info.station eq $vo.id"} selected="selected" {/if}  >{$vo.posts}</option>
                            {/volist}
                        {else/}
                            <option style="width:100px;" >请选择</option>
                        {/if}
                        </select>
                    </div>
                </a>
            </li>

        </ul>
    </form>
</div>

<script>
    $("#region").change(function(){
        var id=$("#region").val();
        $.ajax({
            url: "getPosts" ,
            data: {'pid':id} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                for(var i = 0; i < data.length; i++){
                    $("#station").append("<option value='"+data[i].id+"'>"+data[i].posts+"</option>");//新增
                }
            }
        })
    });
    $("#anq_tuic").click(function()
    {
        var i = $("form").serialize();
        $.ajax({
            url: "checkPosts" ,
            data: i ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
        })
        return false;
    })
</script>
</body>
</html>
