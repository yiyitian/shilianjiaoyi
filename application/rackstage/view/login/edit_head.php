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
        <label class="layui-form-label">更改头像</label>
        <input type="hidden" name="src_img" value="{$list.src_img|default=''}"  id="src_img"/>
        <?php if(isset($list))echo '<input type="hidden" name="id" value="'.$list['id'].'" />';?>
        <div class="layui-input-inline">
            <button type="button" class="layui-btn" id="test1">上传头像</button>
            <div class="layui-upload-list">
                <img class="layui-upload-img" <?php if(isset($list))echo 'src="'.$list['head_img'].'" ';?>  id="demo1">
                <p id="demoText"></p>
            </div>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: '/rackstage/index/uploads?id={$list["id"]}'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res) {

                if (res.code > 0) {
                    return layer.msg('上传失败');
                }else{
                    $('#src_img').val(res.src);
                    return layer.msg(res.msg);
                }
                //上传成功
            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
    });
    var callbackdata;
    layui.use(['layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form;
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

            return true;

        }

    })

</script>
</body>
</html>