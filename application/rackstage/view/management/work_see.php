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
<style>
    .layui-textarea,.layui-input{
        color: #868686;}
</style>
</head>

<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <input type="hidden" name="id" value="{$list.id|default=''}">
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-inline">
            <input class="layui-input" type="text" value="{$list.username}" readonly />
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
     <div class="layui-form-item">
            <label class="layui-form-label">提报日期</label>
            <div class="layui-input-inline">
                <input class="layui-input" type="text" name="id" value="{:date('Y-m-d',$list.createtime)}" readonly />
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
     </div>

    <div class="layui-form-item">
        <label class="layui-form-label">地区</label>
        <div class="layui-input-inline">
            <input class="layui-input" type="text" name="id" value="{$list.area|default=''}">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">本周工作</label>
        <div class="layui-input-block">
            <textarea placeholder="暂无内容" readonly class="layui-textarea" id="lastweek" name="lastweek" style="width:80%;height:300px;">{$list.lastweek|default=''}</textarea>
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">下周计划</label>
        <div class="layui-input-block">
            <textarea placeholder="暂无内容" readonly class="layui-textarea" id="thisweek" name="thisweek" style="width:80%;height:300px;">{$list.thisweek|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>

    var callbackdata;
        layui.use(['laydate','layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;



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
                if($('#area').val()==""){ layer.alert($('#area').attr('placeholder'));  return false;};
                if($('#lastweek').val()==""){ layer.alert($('#lastweek').attr('placeholder'));  return false;};
                if($('#thisweek').val()==""){ layer.alert($('#thisweek').attr('placeholder'));  return false;};
                // if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }

        })

</script>
</body>
</html>