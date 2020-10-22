
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTpl">
    <input type="checkbox" name="status" value="{{d.status}}" title="回款" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="is_verified" value="{{d.is_verified}}" title="通过" lay-filter="lockDemo" {{ d.is_verified == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body" style="background:url('/public/static/bg1.png') no-repeat center;background-size:100% 100%;bottom:0;">
    <!-- 内容主体区域 -->
    <div style="text-align:center;font-size:34px;line-height:16;color: #405dd4;font-weight:bold;font-family:'Microsoft Yahei', '微软雅黑', Arial, '宋体', 'sans-serif';">
       欢迎使用山东世联交易业务赋能平台！
    </div>
    
    <div style="position: absolute;bottom: 5%;line-height:25px;padding-left:10px;font-size:14px">
       <p><a href="/public/绩效考评操作流程.rar" style="color:red" >绩效考评操作手册</a></br> <a href="/public/google.rar" style="color:red">谷歌浏览器（32位、64位下载).rar</a></p>

    </div>
</div>
<script src="/public/layui/layui.js"></script>

{include file="public/footer" /}