<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>

<body>
<form class="layui-form" action="" id="formid" style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">请选择岗位</label>
        <div class="layui-input-inline">
            <select name="posts" lay-filter="posts" id="posts">
                  {if condition="isset($posts)"}
                  {volist name="posts" id="dp"}
                  <option value="{$dp.id}">{$dp.posts|default=''}</option>
                  {/volist}
                  {/if}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">到岗日期</label>
        <div class="layui-input-inline">
            <input type="text" id="test6" name="join_date" lay-verify="required" value=""
                   placeholder="请输到岗日期" autocomplete="off" class="layui-input">
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var callbackdata;
    layui.use(['layer', 'form', 'element', 'jquery','laydate'], function () {
        var layer = layui.layer
            , $ = layui.jquery
            ,laydate=layui.laydate
            , form = layui.form;


        //返回值
        callbackdata = function () {
            if (!verifycontent()) {
                false;
            } else {
                var data = $("#formid").serialize();
                return data;
            }
        }
        laydate.render({
            elem: '#test6'
            , range: false
            ,trigger: 'click'//呼出事件改成click
        });
        form.on('select(region)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    framework=data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < framework.length; i++){
                        $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                    }

                    post=data.post
                    $("#station").empty();
                    $("#station").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < post.length; i++){
                        $("#station").append("<option value='"+post[i].id+"'>"+post[i].posts+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        })
        //自定义验证规则
        function verifycontent() {
            if ($('#framework_id').val() == "") {
                layer.alert($('#framework_id').attr('placeholder'));
                return false;
            }
            ;
            if ($('#user_id').val() == "") {
                layer.alert($('#user_id').attr('placeholder'));
                return false;
            }
            ;
            if ($('#name').val() == "") {
                layer.alert($('#name').attr('placeholder'));
                return false;
            }
            ;
            return true;
        }
    })

</script>
</body>
</html>
