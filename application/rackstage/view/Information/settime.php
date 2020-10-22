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
    <input type="hidden" name="id" value="1"/>
    <div class="layui-form-item">
        <label class="layui-form-label">开始时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="starttime" name="starttime" value="{$list.starttime|default=''}"/>
        </div>
        <div class="layui-form-mid layui-word-aux">请精确到时分秒</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">结束时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="endtime" name="endtime" value="{$list.endtime|default=''}"/>
        </div>
        <div class="layui-form-mid layui-word-aux">请精确到时分秒</div>
    </div>
</form>




<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
    var callbackdata
        layui.use(['table','layer','laydate', 'form','element','jquery'], function(){
            var table = layui.table,
                layer = layui.layer
                ,$=layui.jquery
                ,laydate = layui.laydate
                ,form = layui.form;
            laydate.render({
                elem: '#starttime'
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#endtime'
                ,type: 'datetime'
            });
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