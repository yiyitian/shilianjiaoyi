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
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-inline">
            <input type="text"   name="title" lay-verify="required"  style="width:180%" value="{$list.title|default=''}" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-inline">
            <select name="pid" lay-filter="pid">
                <option select="selected">请选择</option>
                {volist name="lists" id="vo"}
                <option value="{$vo.id}" {if condition="isset($list)&&($vo.id eq $list.pid)"}selected{/if}>{$vo.posts}</option>
                {/volist}

            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">图片</label>
        <div class="layui-upload" >
            <div class="layui-upload-drag" id="test10">

                <p><img id="avatar" src="{$list.avatar|default='/public/api/img/lunbo.png'}" style="border-radius:10%;width:197;height:120px;" alt=""/></p>
            </div>
        </div>
    </div>


     
    <div class="layui-form-item">
        <label class="layui-form-label">发布时间</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" id="createtime"  name="createtime" lay-verify="required"  value="{$list.createtime|default=$times}" placeholder="" autocomplete="off" class="layui-input">
                <input type="hidden" name="avatar" value="{$info.avatar|default='/public/api/img/lunbo.png'}" id="ava"/>

            </div>
        </div>
    </div>
    <?php if(isset($list))echo '<input type="hidden" name="id" value="'.$list['id'].'" />';?>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入简介" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea id="content" name="content" placeholder="请输入内容">{$list.content|default=''}</textarea>

        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/kindeditor/kindeditor-all.js" charset="utf-8"></script>
<script src="/public/kindeditor/plugins/code/prettify.js" charset="utf-8"></script>
<script src="/public/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="hTHv8+BvigYhzJUOpkmEGlJ7ETsKmqyrQb8/PetBTBI=";</script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        //添加课程start
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();

        upload.render({
            elem: '#test10'
            ,url: 'uploads'
            ,done: function(res){
                layer.msg('上传成功');
                document.getElementById('avatar').src = res.src;
                document.getElementById('ava').value = res.src;
            }
        });
    })

    //kindeditor加载开始
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="content"]', {
            cssPath : '/public/kindeditor/plugins/code/prettify.css',
            uploadJson : '/public/kindeditor/php/upload_json.php',
            allowFileManager : true,
            width:"80%",height:"300px",
            afterBlur: function () { this.sync(); }
        });
        prettyPrint();
    });
    //kindeditor加载结束
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

            var arr = new Array();
            $("input:checkbox[name='department']:checked").each(function(i){
                arr[i] = $(this).val();
            });
                var data =$("#formid").serialize();

                return data;

        }
        //自定义验证规则
        function verifycontent() {
            return true;
        }
    })
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#test3'
        });

    });

</script>
</body>
</html>