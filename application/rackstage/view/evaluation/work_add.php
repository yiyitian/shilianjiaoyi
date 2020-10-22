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

<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <input type="hidden" name="id" value="{$list.id|default=''}">


    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-inline">
            <input class="layui-input" type="text" name="title" value="{$list.title|default=''}" />
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" id="content" name="content" style="width:80%;height:300px;">{$list.content|default=''}</textarea>
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
                // if($('#area').val()==""){ layer.alert($('#area').attr('placeholder'));  return false;};
                if($('#content').val()==""){ layer.alert($('#lastweek').attr('placeholder'));  return false;};
                // if($('#thisweek').val()==""){ layer.alert($('#thisweek').attr('placeholder'));  return false;};
                // if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }

        })

</script>
</body>
</html>