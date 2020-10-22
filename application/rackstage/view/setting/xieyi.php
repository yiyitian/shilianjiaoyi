
{include file="public/header" /}

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div >
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">安全协议</label>
        <div class="layui-input-block">
            <textarea id="content" name="content" placeholder="请输入协议内容">{$list.content|default=''}</textarea>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">隐私协议</label>
        <div class="layui-input-block">
            <textarea id="content" name="contents" placeholder="请输入隐私协议">{$list.contents|default=''}</textarea>
        </div>
    </div>
    <button type="submit" style="margin-left:150px;" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>

</form>
        </div>
    </div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/kindeditor/kindeditor-all.js" charset="utf-8"></script>
<script src="/public/kindeditor/plugins/code/prettify.js" charset="utf-8"></script>
<script src="/public/jwplayer/jwplayer.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
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

    KindEditor.ready(function(K) {
        var editor2 = K.create('textarea[name="contents"]', {
            cssPath : '/public/kindeditor/plugins/code/prettify.css',
            uploadJson : '/public/kindeditor/php/upload_json.php',
            allowFileManager : true,
            width:"80%",height:"300px",
            afterBlur: function () { this.sync(); }
        });
        prettyPrint();
    });

    layui.use(['table','layer','jquery'], function() {
        var table = layui.table,
            $ = layui.jquery
            , form = layui.form
            , layer = layui.layer;
        form.on('submit(demo1)', function(data){
            var data = JSON.stringify(data.field);
            $.ajax({
                url: "xieyi" ,
                data: {'data':data} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                }
            })
            return false;
        });
    });
</script>
{include file="public/footer" /}