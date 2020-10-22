<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 120px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">图片链接</label>
        <div class="layui-input-inline">
            <input type="text"   name="img" lay-verify="required"  value="{$info.img|default=''}" style="width:200%"  placeholder="请输入轮播图链接"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">轮播图片</label>
        <input type="hidden" name="url" value="{$info.url|default='/public/api/img/lunbo.png'}"  id="src_img"/>
        <?php if(isset($info))echo '<input type="hidden" name="id" value="'.$info['id'].'" />';?>
        <div class="layui-input-inline">
            <button type="button" class="layui-btn" id="test1">上传轮播图片</button>
            <div class="layui-upload-list">
                <img class="layui-upload-img" <?php if(isset($info)){echo 'src="'.$info['url'].'" ';}else{echo 'src="/public/api/img/lunbo.png" ';}?>  id="demo1">
                <p id="demoText"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text"   name="sort" lay-verify="required"  value="{$info.sort|default=''}" style="width:200%"  placeholder="请输入排序"  class="layui-input">
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/kindeditor/kindeditor-all.js" charset="utf-8"></script>
<script src="/public/kindeditor/plugins/code/prettify.js" charset="utf-8"></script>
<script src="/public/jwplayer/jwplayer.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: '/rackstage/index/uploads12'
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
    layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;
        laydate.render({
            elem:'#createtime'
        });



        //返回值
        callbackdata=function () {

            var data =$("#formid").serialize();
            return data;
        }
        //自定义验证规则
        function verifycontent() {
            return true;
        }
    })
</script>
</body>
</html>