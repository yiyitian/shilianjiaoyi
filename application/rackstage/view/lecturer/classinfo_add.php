<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">选择课程</label>
        <div class="layui-input-inline">
            <select name="quiz1" id="cate"  lay-filter="cate">
                <option value="">请选择分类</option>
                {volist name="cate" id="vo"}
                    <option value="{$vo.id}" {if condition="isset($list)&&($fInfo.id eq $vo.id)"} selected {/if}>{$vo.title}</option>
                {/volist}
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="quiz2" id="date"  lay-filter="date">
            {notempty name="list"}
                {volist name="pInfoList" id="vo"}
                <option value="{$vo.id}" {eq name="$vo.id" value="$pInfo.id"} selected {/eq}>{$vo.title}</option>
                {/volist}
            {else/}
                <option value="">请选择分类</option>

            {/notempty}
        
            </select>
        </div>
        {notempty name="list"}
             <input type="hidden" name="id" value="{$list.id}"/>

            {/notempty}
        <div class="layui-input-inline">
            <select name="quiz3" id="city"  lay-filter="city">
                {notempty name="list"}
                {volist name="infoList" id="vo"}
                <option value="{$vo.id}" {eq name="$vo.id" value="$infos.id"} selected {/eq}>{$vo.title}</option>
                {/volist}
            {else/}
                <option value="">请选择课程</option>

            {/notempty}
            </select>
        </div>
    </div>

    <input type="hidden" name="pid" value="{$pid}"/>
    <input type="hidden" name="levels" value="{$levels}"/>
    <input type="hidden" name="add" value="1"/>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">分类备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>


    var callbackdata;
    layui.use(['layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form;
            form.on('select(cate)', function(data){
                $.ajax({
                    url: "getCate" ,
                    data: {'pid':data.value} ,
                    type: "get" ,
                    dataType:'json',
                    success:function(data){
                        $("#date").empty();
                        $("#date").append("<option value=''>请选择</option>");//新增
                        for(var i = 0; i < data.length; i++){
                            $("#date").append("<option value='"+data[i].id+"'>"+data[i].title+"</option>");//新增
                        }
                        form.render('select');
                    }
                })
            });
        form.on('select(date)', function(data){
            $.ajax({
                url: "getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].id+"'>"+data[i].title+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }else {
                var data =$("#formid").serialize();
                return data;
            }
        }
        //自定义验证规则
        function verifycontent() {
            //if($('#contract_num').val()==""){ layer.alert('合同编号不能为空'); return false;};
            

            return true;

        }

    })

</script>
</body>
</html>