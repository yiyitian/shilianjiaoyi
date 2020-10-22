
{include file="public/header" /}
<script type="text/javascript" src="/public/layui/layui.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
<link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">


<body style="height: 100%;background: #eaeaea;">
<!-- 头部 -->
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="personalCenter"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_bai.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">项目设置</div>
    <div class="sy_zaix"><a href="javascript:;"><span id="anq_tuic">保存</span></a></div>
</div>

<!-- 内容 -->

<div class="nei_r_btk">
    <form id="form">
        <ul>
            <li>
                <a href="#">
                    <h1>所属部门</h1>
                    <div class="xiugai" style="padding-top: 20px;padding-right:10px;">
                        <select name="department" id="department" style="font-size:12px;direction: rtl;" >
                            {volist name="sonList" id="vo"}
                                <option style="width:100px;" value="{$vo.id}" {if condition="$info.department eq $vo.id"} selected="selected"{/if}>
                                    {volist name="fatherList" id="voFather"}
                                        {if condition="$voFather.id eq $vo.pid"}{$voFather.name}--{/if}
                                    {/volist}
                                        {$vo.name}
                                </option>
                            {/volist}

                        </select>
                    </div>
                </a>
            </li>
            <input type="hidden" name="id" value="{$info.id}"/>
            <li>
                <a href="#">
                    <h1>所属项目</h1>
                    <div class="xiugai" style="padding-top: 20px;padding-right:10px;">
                        <select name="projectname" id="projectname"  style="font-size:12px;" >
                        {if condition="isset($project)"}
                            {volist name="project" id="vo"}
                             <option style="width:100px;" value ="{$vo.id}" {if condition="$info.projectname eq $vo.id"} selected="selected" {/if}  >{$vo.name}</option>
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
    $("#department").change(function(){
        var id=$("#department").val();
        $.ajax({
            url: "getProject" ,
            data: {'pid':id} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                for(var i = 0; i < data.length; i++){
                    $("#projectname").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                }
            }
        })
    });
    $("#anq_tuic").click(function()
    {
        var i = $("form").serialize();
        $.ajax({
            url: "checkProject" ,
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
