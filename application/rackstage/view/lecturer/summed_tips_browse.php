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

    <div class="layui-form-item outline online">
        <label class="layui-form-label">员工姓名</label>
        <div class="layui-input-inline">
            <input style="" type="text" readonly lay-verify="required" value="{$list.usersname|default=''}" placeholder="入职时间范围" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label">提交时间</label>
        <div class="layui-input-inline">
            <input style="" type="text" readonly lay-verify="required" value="{:date('Y-m-d H:i:s',$list.startdate)}" placeholder="入职时间范围" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label">心得附件</label>
        <div class="layui-input-inline">
            {notempty name="list.tips_files"}
            <span class="layui-btn" onclick="window.open('{$list.tips_files|default=''}')">打开</span>
            {else /}
            <input style="" type="text" readonly lay-verify="required" placeholder="未上传附件" autocomplete="off" class="layui-input">
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">心得总结</label>
        <div class="layui-input-inline" style="width:700px;">
            <textarea placeholder="请输入内容" class="layui-textarea" name="remark" rows="20" style="width:80%">{$list.remark|default=''}</textarea>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>

    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        $(document).on('click','.del_uploads',function(){
            var O_id=$(this).attr('indexs');
            layer.confirm('确定删除吗', function(index){
                $.ajax({
                    url: "/rackstage/index/uploads_del" ,
                    data: {'id':O_id} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,time:500},function(){
                            location.reload();
                        });
                    }
                })
            });
        });




    });


</script>
</body>
</html>