
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTpl">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="是|否" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>

</script>
<script type="text/html" id="checkboxTp2">
        <input type="checkbox" name="is_verified" value="{{d.is_verified}}" lay-skin="switch" lay-text="是|否" lay-filter="sexDemo" {{ d.is_verified == 1 ? 'checked' : '' }}>
</script>
    <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                
            </div>
        </div>
        <script src="/public/layui/layui.js"></script>
        <script>
            layui.use(['table','layer','jquery'], function(){
                var table = layui.table,
                    $   = layui.jquery
                    ,form = layui.form
                    ,layer = layui.layer;
                window.location.href='/rackstage/Welcome/index';
            });



        </script>


{include file="public/footer" /}